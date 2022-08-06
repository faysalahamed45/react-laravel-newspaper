<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller {

    public function index(Request $request)
    {
        $this->authorize('list page');

        $sql = Page::orderBy('name_en', 'ASC');

        if ($request->q) {
            $sql->where('name_en', 'LIKE', $request->q.'%')
                ->orWhere('name_bn', 'LIKE', $request->q.'%');
        }

        if ($request->status) {
            $sql->where('status', $request->status);
        }

        $records = $sql->paginate($request->limit ?? 15);

        return view('admin.page', compact('records'))->with('list', 1);
    }

    public function create()
    {
        $this->authorize('add page');

        return view('admin.page')->with('create', 1);
    }

    public function store(Request $request)
    {
        $this->authorize('add page');

        $this->validate($request, [
            'name_en' => 'required|max:255|unique:pages,name_en',
            'name_bn' => 'required|max:255|unique:pages,name_bn',
            'content_en' => 'required',
            'content_bn' => 'required',
            'status' => 'required|in:Active,Deactivated',
        ]);

        $storeData = [
            'slug_en' => Str::slug($request->name_en),
            'slug_bn' => Str::slug($request->name_bn),
            'name_en' => $request->name_en,
            'name_bn' => $request->name_bn,
            'content_en' => $request->content_en,
            'content_bn' => $request->content_bn,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ];
        $data = Page::create($storeData);

        $request->session()->flash('successMessage', __('lang.ModelCreated', ['model' => __('lang.Page')]));
        return redirect()->route('admin.page.create', qArray());
    }

    public function show(Request $request, $id)
    {
        $this->authorize('show page');

        $data = Page::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.page.index', qArray());
        }

        return view('admin.page', compact('data'))->with('show', $id);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('edit page');

        $data = Page::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.page.index', qArray());
        }

        return view('admin.page', compact('data'))->with('edit', $id);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit page');

        $this->validate($request, [
            'name_en' => 'required|max:255|unique:pages,name_en,'.$id.',id',
            'name_bn' => 'required|max:255|unique:pages,name_bn,'.$id.',id',
            'content_en' => 'required',
            'content_bn' => 'required',
            'status' => 'required|in:Active,Deactivated',
        ]);

        $data = Page::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.page.index', qArray());
        }

        $storeData = [
            'slug_en' => Str::slug($request->name_en),
            'slug_bn' => Str::slug($request->name_bn),
            'name_en' => $request->name_en,
            'name_bn' => $request->name_bn,
            'content_en' => $request->content_en,
            'content_bn' => $request->content_bn,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
        ];

        $data->update($storeData);

        $request->session()->flash('successMessage', __('lang.ModelUpdated', ['model' => __('lang.Page')]));
        return redirect()->route('admin.page.index', qArray());
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('delete page');

        $data = Page::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.page.index', qArray());
        }

        $data->delete();
        
        $request->session()->flash('successMessage', __('lang.ModelDeleted', ['model' => __('lang.Page')]));
        return redirect()->route('admin.page.index', qArray());
    }
}
