<?php

namespace App\Http\Controllers\Admin\Classified;

use App\Models\ClassifiedCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller {

    public function index(Request $request)
    {
        $this->authorize('list classified-category');

        $sql = ClassifiedCategory::orderBy('sorting', 'ASC');

        if ($request->q) {
            $sql->where('name_en', 'LIKE', $request->q.'%')
                ->orWhere('name_bn', 'LIKE', $request->q.'%');
        }

        if ($request->status) {
            $sql->where('status', $request->status);
        }

        $records = $sql->paginate($request->limit ?? 15);

        return view('admin.classified.category', compact('records'))->with('list', 1);
    }

    public function create()
    {
        $this->authorize('add classified-category');

        return view('admin.classified.category')->with('create', 1);
    }

    public function store(Request $request)
    {
        $this->authorize('add classified-category');

        $this->validate($request, [
            'name_en' => 'required|max:255|unique:categories,name_en',
            'name_bn' => 'required|max:255|unique:categories,name_bn',
            'status' => 'required|in:Active,Deactivated',
        ]);

        $storeData = [
            'slug_en' => Str::slug($request->name_en),
            'slug_bn' => Str::slug($request->name_bn),
            'name_en' => $request->name_en,
            'name_bn' => $request->name_bn,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ];
        $data = ClassifiedCategory::create($storeData);

        $request->session()->flash('successMessage', __('lang.ModelCreated', ['model' => __('lang.Category')]));
        return redirect()->route('admin.classified.category.create', qArray());
    }

    public function show(Request $request, $id)
    {
        $this->authorize('show classified-category');

        $data = ClassifiedCategory::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.classified.category.index', qArray());
        }

        return view('admin.classified.category', compact('data'))->with('show', $id);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('edit classified-category');

        $data = ClassifiedCategory::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.classified.category.index', qArray());
        }

        return view('admin.classified.category', compact('data'))->with('edit', $id);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit classified-category');

        $this->validate($request, [
            'name_en' => 'required|max:255|unique:categories,name_en,'.$id.',id',
            'name_bn' => 'required|max:255|unique:categories,name_bn,'.$id.',id',
            'status' => 'required|in:Active,Deactivated',
        ]);

        $data = ClassifiedCategory::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.classified.category.index', qArray());
        }

        $storeData = [
            'slug_en' => Str::slug($request->name_en),
            'slug_bn' => Str::slug($request->name_bn),
            'name_en' => $request->name_en,
            'name_bn' => $request->name_bn,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
        ];

        $data->update($storeData);

        $request->session()->flash('successMessage', __('lang.ModelUpdated', ['model' => __('lang.Category')]));
        return redirect()->route('admin.classified.category.index', qArray());
    }

    public function sortRow(Request $request)
    {
        $this->authorize('edit classified-category');

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:categories,id',
        ]);

        foreach ($request->ids as $key => $id) {
            ClassifiedCategory::where('id', $id)->update(['sorting' => $key]);
        }

        return response()->json(['success' => true, 'message' => __('lang.ModelUpdated', ['model' => __('lang.Category')])]);
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('delete classified-category');

        $data = ClassifiedCategory::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.classified.category.index', qArray());
        }

        $data->delete();
        
        $request->session()->flash('successMessage', __('lang.ModelDeleted', ['model' => __('lang.Category')]));
        return redirect()->route('admin.classified.category.index', qArray());
    }
}
