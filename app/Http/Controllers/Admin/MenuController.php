<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller {

    public function index(Request $request)
    {
        $this->authorize('list menu');

        $sql = Menu::select('position')->with(['positions' => function($q) {
            $q->orderBy('sorting', 'ASC');
            $q->with(['taggable', 'childs' => function($q) {
                $q->orderBy('sorting', 'ASC');
                $q->with('taggable');
            }]);
        }])
        ->groupBy('position');

        $records = $sql->get();

        return view('admin.menu', compact('records'))->with('list', 1);
    }

    public function create()
    {
        $this->authorize('add menu');

        $parents = Menu::where('parent_id', 0)->where('status', 'Active')->get();
        $pages = Page::select('id', 'name_en')->where('status', 'Active')->get();

        $categories = Category::select('id', 'name_en')
        ->with(['childs' => function ($q) {
            $q->select('id', 'parent_id', 'name_en');
        }])
        ->where('parent_id', 0)
        ->where('status', 'Active')
        ->get();

        return view('admin.menu', compact('parents', 'pages', 'categories'))->with('create', 1);
    }

    public function store(Request $request)
    {
        $this->authorize('add menu');

        $this->validate($request, [
            'parent_id' => 'nullable|integer',
            'position' => 'required|in:header,footer,hamburger',
            'taggable_type' => 'required|in:Category,Page',
            'taggable_id' => 'required|integer',
            'status' => 'required|in:Active,Deactivated',
        ]);

        $storeData = [
            'parent_id' => $request->parent_id > 0 ? $request->parent_id : 0,
            'position' => $request->position,
            'taggable_type' => 'App\\Models\\'.$request->taggable_type,
            'taggable_id' => $request->taggable_id,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ];
        $data = Menu::create($storeData);

        $request->session()->flash('successMessage', __('lang.ModelCreated', ['model' => __('lang.Menu')]));
        return redirect()->route('admin.menu.create', qArray());
    }

    public function show(Request $request, $id)
    {
        $this->authorize('show menu');

        $data = Menu::with(['taggable', 'parent.taggable'])->find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.menu.index', qArray());
        }

        return view('admin.menu', compact('data'))->with('show', $id);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('edit menu');

        $data = Menu::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.menu.index', qArray());
        }
        
        $parents = Menu::where('parent_id', 0)->where('status', 'Active')->get();
        $pages = Page::select('id', 'name_en')->where('status', 'Active')->get();

        $categories = Category::select('id', 'name_en')
        ->with(['childs' => function ($q) {
            $q->select('id', 'parent_id', 'name_en');
        }])
        ->where('parent_id', 0)
        ->where('status', 'Active')
        ->get();

        return view('admin.menu', compact('data', 'parents', 'pages', 'categories'))->with('edit', $id);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit menu');

        $this->validate($request, [
            'parent_id' => 'nullable|integer',
            'position' => 'required|in:header,footer,hamburger',
            'taggable_type' => 'required|in:Category,Page',
            'taggable_id' => 'required|integer',
            'status' => 'required|in:Active,Deactivated',
        ]);

        $data = Menu::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.menu.index', qArray());
        }

        $storeData = [
            'parent_id' => $request->parent_id > 0 ? $request->parent_id : 0,
            'position' => $request->position,
            'taggable_type' => 'App\\Models\\'.$request->taggable_type,
            'taggable_id' => $request->taggable_id,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
        ];

        $data->update($storeData);

        $request->session()->flash('successMessage', __('lang.ModelUpdated', ['model' => __('lang.Menu')]));
        return redirect()->route('admin.menu.index', qArray());
    }

    public function sortRow(Request $request)
    {
        $this->authorize('edit menu');

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:categories,id',
        ]);

        foreach ($request->ids as $key => $id) {
            Menu::where('id', $id)->update(['sorting' => $key]);
        }

        return response()->json(['success' => true, 'message' => __('lang.ModelUpdated', ['model' => __('lang.Menu')])]);
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('delete menu');

        $data = Menu::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.menu.index', qArray());
        }

        $data->delete();
        
        $request->session()->flash('successMessage', __('lang.ModelDeleted', ['model' => __('lang.Menu')]));
        return redirect()->route('admin.menu.index', qArray());
    }
}
