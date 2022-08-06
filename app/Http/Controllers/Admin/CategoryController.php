<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\HomeCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller {

    public function index(Request $request)
    {
        $this->authorize('list category');

        $sql = Category::with(['childs' => function($q) {
            $q->orderBy('sorting', 'ASC');
        }])
        ->where('parent_id', 0)
        ->orderBy('sorting', 'ASC');

        if ($request->q) {
            $sql->where('name_en', 'LIKE', $request->q.'%')
                ->orWhere('name_bn', 'LIKE', $request->q.'%');
        }

        if ($request->parent) {
            $sql->where('parent_id', $request->parent);
        }

        if ($request->status) {
            $sql->where('status', $request->status);
        }

        $records = $sql->paginate($request->limit ?? 15);

        $parents = Category::where('parent_id', 0)->get();

        return view('admin.category', compact('records', 'parents'))->with('list', 1);
    }

    public function create()
    {
        $this->authorize('add category');

        $parents = Category::where('parent_id', 0)->get();
        return view('admin.category', compact('parents'))->with('create', 1);
    }

    public function store(Request $request)
    {
        $this->authorize('add category');

        $this->validate($request, [
            'parent_id' => 'nullable|integer',
            'name_en' => 'required|max:255|unique:categories,name_en',
            'name_bn' => 'required|max:255|unique:categories,name_bn',
            'status' => 'required|in:Active,Deactivated',
        ]);

        $storeData = [
            'parent_id' => $request->parent_id > 0 ? $request->parent_id : 0,
            'type' => $request->type,
            'slug_en' => Str::slug($request->name_en),
            'slug_bn' => Str::slug($request->name_bn),
            'name_en' => $request->name_en,
            'name_bn' => $request->name_bn,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ];
        $data = Category::create($storeData);

        if ($data && $request->show_in_home == 'Yes') {
            HomeCategory::create([
                'category_id' => $data->id
            ]);
        }

        $request->session()->flash('successMessage', __('lang.ModelCreated', ['model' => __('lang.Category')]));
        return redirect()->route('admin.category.create', qArray());
    }

    public function show(Request $request, $id)
    {
        $this->authorize('show category');

        $data = Category::with(['parent', 'creator', 'showInHome'])->find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.category.index', qArray());
        }

        return view('admin.category', compact('data'))->with('show', $id);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('edit category');

        $data = Category::with('showInHome')->find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.category.index', qArray());
        }
        
        $parents = Category::where('parent_id', 0)->get();

        return view('admin.category', compact('data', 'parents'))->with('edit', $id);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit category');

        $this->validate($request, [
            'parent_id' => 'nullable|integer',
            'name_en' => 'required|max:255|unique:categories,name_en,'.$id.',id',
            'name_bn' => 'required|max:255|unique:categories,name_bn,'.$id.',id',
            'status' => 'required|in:Active,Deactivated',
        ]);

        $data = Category::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.category.index', qArray());
        }

        $storeData = [
            'parent_id' => $request->parent_id > 0 ? $request->parent_id : 0,
            'type' => $request->type,
            'slug_en' => Str::slug($request->name_en),
            'slug_bn' => Str::slug($request->name_bn),
            'name_en' => $request->name_en,
            'name_bn' => $request->name_bn,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
        ];

        $data->update($storeData);
        
        if ($data && $request->show_in_home == 'Yes') {
            HomeCategory::updateOrCreate(['category_id' => $data->id], ['category_id' => $data->id]);
        } else {
            HomeCategory::where('category_id', $data->id)->delete();
        }

        $request->session()->flash('successMessage', __('lang.ModelUpdated', ['model' => __('lang.Category')]));
        return redirect()->route('admin.category.index', qArray());
    }

    public function sortRow(Request $request)
    {
        $this->authorize('edit category');

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:categories,id',
        ]);

        foreach ($request->ids as $key => $id) {
            Category::where('id', $id)->update(['sorting' => $key]);
        }

        return response()->json(['success' => true, 'message' => __('lang.ModelUpdated', ['model' => __('lang.Category')])]);
    }

    public function homeCategory(Request $request)
    {
        $this->authorize('list category');

        $homeCategories = HomeCategory::with(['category'])
        ->orderBy('sorting', 'ASC')
        ->get();

        return view('admin.category', compact('homeCategories'))->with('homeCategory', 1);
    }

    public function homeSortRow(Request $request)
    {
        $this->authorize('edit category');

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:categories,id',
        ]);

        foreach ($request->ids as $key => $id) {
            HomeCategory::where('id', $id)->update(['sorting' => $key]);
        }

        return response()->json(['success' => true, 'message' => __('lang.ModelUpdated', ['model' => __('lang.Category')])]);
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('delete category');

        $data = Category::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.category.index', qArray());
        }

        $data->delete();
        
        $request->session()->flash('successMessage', __('lang.ModelDeleted', ['model' => __('lang.Category')]));
        return redirect()->route('admin.category.index', qArray());
    }
}
