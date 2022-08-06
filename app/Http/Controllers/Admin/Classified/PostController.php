<?php

namespace App\Http\Controllers\Admin\Classified;

use App\Models\Admin;
use App\Models\ClassifiedPost;
use App\Models\ClassifiedCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {

    public function index(Request $request)
    {
        $this->authorize('list classified-post');

        $sql = ClassifiedPost::with(['category', 'editor'])->orderBy('id', 'DESC');

        if ($request->q) {
            $sql->where('content_bn', 'LIKE', $request->q.'%')
                ->orWhere('content_bn', 'LIKE', $request->q.'%');
        }

        if ($request->status) {
            $sql->where('status', $request->status);
        }

        $records = $sql->paginate($request->limit ?? 15);

        return view('admin.classified.post', compact('records'))->with('list', 1);
    }

    public function create()
    {
        $this->authorize('add classified-post');

        $categories = ClassifiedCategory::where('status', 'Active')->get();
        $admins = Admin::where('status', 'Active')->get();

        return view('admin.classified.post', compact('categories', 'admins'))->with('create', 1);
    }

    public function store(Request $request)
    {
        $this->authorize('add classified-post');

        $this->validate($request, [
            'category_id' => 'required|integer',
            'editor_id' => 'nullable|integer',
            'content_en' => 'required',
            'content_bn' => 'required',
            'published_date' => 'required',
            'status' => 'required|in:Draft,Published',
            'is_premium' => 'required|in:No,Yes',
        ]);

        $storeData = [
            'category_id' => $request->category_id,
            'editor_id' => $request->editor_id,
            'content_en' => $request->content_en,
            'content_bn' => $request->content_bn,
            'published_date' => $request->published_date,
            'expired_date' => $request->expired_date,
            'status' => $request->status,
            'is_premium' => $request->is_premium,
            'created_by' => Auth::user()->id,
        ];

        $data = ClassifiedPost::create($storeData);

        $request->session()->flash('successMessage', __('lang.ModelCreated', ['model' => __('lang.Post')]));
        return redirect()->route('admin.classified.post.create', qArray());
    }

    public function show(Request $request, $id)
    {
        $this->authorize('show classified-post');

        $data = ClassifiedPost::with(['editor', 'category'])->find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.classified.post.index', qArray());
        }

        return view('admin.classified.post', compact('data'))->with('show', $id);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('edit classified-post');

        $data = ClassifiedPost::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.classified.post.index', qArray());
        }

        $categories = ClassifiedCategory::where('status', 'Active')->get();
        $admins = Admin::where('status', 'Active')->get();

        return view('admin.classified.post', compact('data', 'categories', 'admins'))->with('edit', $id);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit classified-post');

        $this->validate($request, [
            'category_id' => 'required|integer',
            'editor_id' => 'nullable|integer',
            'content_en' => 'required',
            'content_bn' => 'required',
            'published_date' => 'required',
            'status' => 'required|in:Draft,Published',
            'is_premium' => 'required|in:No,Yes',
        ]);

        $data = ClassifiedPost::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.classified.post.index', qArray());
        }

        $storeData = [
            'category_id' => $request->category_id,
            'editor_id' => $request->editor_id,
            'content_en' => $request->content_en,
            'content_bn' => $request->content_bn,
            'published_date' => $request->published_date,
            'expired_date' => $request->expired_date,
            'status' => $request->status,
            'is_premium' => $request->is_premium,
            'updated_by' => Auth::user()->id,
        ];

        $data->update($storeData);

        $request->session()->flash('successMessage', __('lang.ModelUpdated', ['model' => __('lang.Post')]));
        return redirect()->route('admin.classified.post.index', qArray());
    }

    public function approve(Request $request, $id)
    {
        $this->authorize('approve classified-post');

        $data = ClassifiedPost::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.classified.post.index', qArray());
        }

        $data->update([
            'approved_at' => now(), 
            'approved_by' => Auth::user()->id,
        ]);
        
        $request->session()->flash('successMessage', __('lang.ModelApproved', ['model' => __('lang.Post')]));
        return redirect()->route('admin.classified.post.index', qArray());
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('delete classified-post');

        $data = ClassifiedPost::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.classified.post.index', qArray());
        }

        $data->delete();
        
        $request->session()->flash('successMessage', __('lang.ModelDeleted', ['model' => __('lang.Post')]));
        return redirect()->route('admin.classified.post.index', qArray());
    }
}
