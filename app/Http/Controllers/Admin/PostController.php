<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Admin;
use App\Models\Category;
use App\Models\PostMedia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Sudip\MediaUploder\Facades\MediaUploader;

class PostController extends Controller {

    public function index(Request $request)
    {
        $this->authorize('list post');

        $sql = Post::with(['category', 'editor'])->orderBy('id', 'DESC');

        if ($request->q) {
            $sql->where('title_en', 'LIKE', $request->q.'%')
                ->orWhere('title_bn', 'LIKE', $request->q.'%')
                ->orWhere('content_bn', 'LIKE', $request->q.'%')
                ->orWhere('content_bn', 'LIKE', $request->q.'%');
        }
        
        if ($request->feature) {
            $sql->where($request->feature, 1);
        }

        if ($request->status) {
            $sql->where('status', $request->status);
        }

        if ($request->category) {
            $sql->where('category_id', $request->category);
        }

        $records = $sql->paginate($request->limit ?? 15);

        $categories = Category::with(['childs' => function($q) {
            $q->where('status', 'Active');
        }])->where('status', 'Active')->where('parent_id', 0)->get();

        return view('admin.post', compact('records', 'categories'))->with('list', 1);
    }

    public function create()
    {
        $this->authorize('add post');

        $categories = Category::with(['childs' => function($q) {
            $q->where('status', 'Active');
        }])->where('status', 'Active')->where('parent_id', 0)->get();

        $admins = Admin::where('status', 'Active')->get();

        $other_categories = [];        
        $medias = [
            (object)[
                'id' => 0,
                'file_name' => null,
            ]
        ];

        return view('admin.post', compact('categories', 'admins', 'other_categories', 'medias'))->with('create', 1);
    }

    public function store(Request $request)
    {
        $this->authorize('add post');

        $this->validate($request, [
            'category_id' => 'required|integer',
            'editor_id' => 'required|integer',
            'title_en' => 'required|max:255|unique:posts,title_en',
            'title_bn' => 'required|max:255|unique:posts,title_bn',
            'content_en' => 'required',
            'content_bn' => 'required',
            'published_at' => 'required',
            'video_url' => 'required_without:image|url',
            'image' => 'required_without:video_url|mimes:jpeg,jpg,png,gif',
            'status' => 'required|in:Draft,Published',
        ]);

        $storeData = [
            'category_id' => $request->category_id,
            'editor_id' => $request->editor_id,
            'slug_en' => Str::slug($request->title_en),
            'slug_bn' => Str::slug($request->title_bn),
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'content_en' => $request->content_en,
            'content_bn' => $request->content_bn,
            'video_url' => $request->video_url,
            'published_at' => $request->published_at,
            'status' => $request->status,
            'feature_post' => $request->feature_post ?? 0,
            'feature_post_2' => $request->feature_post_2 ?? 0,
            'exclusive' => $request->exclusive ?? 0,
            'created_by' => Auth::user()->id,
        ];

        $data = Post::create($storeData);

        if ($request->hasFile('image')) {
            $file = MediaUploader::imageUpload($request->image, 'posts/' . $data->id, 1);
            if ($file) {
                $data->update([
                    'image' => $file['name'], 
                    'image_url' => $file['url']
                ]);
            }
        }

        if ($data && $request->other_categories) {
            foreach ($request->other_categories as $oCat) {
                PostCategory::create([
                    'post_id' => $data->id,
                    'category_id' => $oCat,
                ]);
            }
        }

        if ($data && $request->hasFile('medias')) {
            foreach ($request->file('medias') as $ik => $img) {
                $file = MediaUploader::imageUpload($img, 'posts/' . $data->id, 1);
                PostMedia::create([
                    'post_id' => $data->id,
                    'file_name' => $file['name'],
                    'file_url' => $file['url'],
                    'sorting' => ($ik + 1),
                ]);
            }
        }

        $request->session()->flash('successMessage', __('lang.ModelCreated', ['model' => __('lang.Post')]));
        return redirect()->route('admin.post.create', qArray());
    }

    public function show(Request $request, $id)
    {
        $this->authorize('show post');

        $data = Post::with(['editor', 'medias', 'category', 'postCategories.category'])->find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.post.index', qArray());
        }

        return view('admin.post', compact('data'))->with('show', $id);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('edit post');

        $data = Post::with(['medias', 'postCategories'])->find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.post.index', qArray());
        }

        $categories = Category::with(['childs' => function($q) {
            $q->where('status', 'Active');
        }])->where('status', 'Active')->where('parent_id', 0)->get();

        $admins = Admin::where('status', 'Active')->get();

        if ($data->postCategories->count() > 0) {
            $other_categories = $data->postCategories->pluck('category_id')->toArray();
        } else {
            $other_categories = [];
        }

        if ($data->medias->count() > 0) {
            $medias = $data->medias;
        } else {
            $medias = [
                (object)[
                    'id' => 0,
                    'file_name' => null,
                ]
            ];
        }

        return view('admin.post', compact('data', 'categories', 'admins', 'other_categories', 'medias'))->with('edit', $id);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit post');

        $this->validate($request, [
            'category_id' => 'required|integer',
            'editor_id' => 'required|integer',
            'title_en' => 'required|max:255|unique:posts,title_en,'.$id.',id',
            'title_bn' => 'required|max:255|unique:posts,title_bn,'.$id.',id',
            'content_en' => 'required',
            'content_bn' => 'required',
            'published_at' => 'required',
            // 'video_url' => 'required_without:image|url',
            // 'image' => 'required_without:video_url|mimes:jpeg,jpg,png,gif',
            'status' => 'required|in:Draft,Published',
        ]);

        $data = Post::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.post.index', qArray());
        }

        $storeData = [
            'category_id' => $request->category_id,
            'editor_id' => $request->editor_id,
            'slug_en' => Str::slug($request->title_en),
            'slug_bn' => Str::slug($request->title_bn),
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'content_en' => $request->content_en,
            'content_bn' => $request->content_bn,
            'video_url' => $request->video_url,
            'published_at' => $request->published_at,
            'status' => $request->status,
            'feature_post' => $request->feature_post ?? 0,
            'feature_post_2' => $request->feature_post_2 ?? 0,
            'exclusive' => $request->exclusive ?? 0,
            'updated_by' => Auth::user()->id,
        ];

        if ($request->hasFile('image')) {
            $file = MediaUploader::imageUpload($request->image, 'posts/' . $data->id, 1);
            if ($file) {
                $storeData['image'] = $file['name'];
                $storeData['image_url'] = $file['url'];
            }
        }

        $data->update($storeData);

        if ($request->other_categories) {
            foreach ($request->other_categories as $oCat) {
                PostCategory::updateOrCreate([
                    'post_id' => $data->id,
                    'category_id' => $oCat,
                ], [
                    'post_id' => $data->id,
                    'category_id' => $oCat,
                ]);
            }

            PostCategory::where('post_id', $data->id)->whereNotIn('category_id', $request->other_categories)->delete();
        } else {
            PostCategory::where('post_id', $data->id)->delete();
        }

        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $ik => $img) {
                $file = MediaUploader::imageUpload($img, 'posts/' . $data->id, 1);

                if ($request->image_ids[$ik] > 0) {
                    $oldRow = PostMedia::find($request->image_ids[$ik]);
                    $oldRow->update([
                        'file_name' => $file['name'], 
                        'file_url' => $file['url']
                    ]);

                    MediaUploader::delete('posts/' . $data->id, $oldRow->image, 1);
                } else {
                    PostMedia::create([                        
                        'post_id' => $data->id,
                        'file_name' => $file['name'],
                        'file_url' => $file['url'],
                        'sorting' => ($ik + 1),
                    ]);
                }
            }
        }

        $request->session()->flash('successMessage', __('lang.ModelUpdated', ['model' => __('lang.Post')]));
        return redirect()->route('admin.post.index', qArray());
    }

    public function approve(Request $request, $id)
    {
        $this->authorize('approve post');

        $data = Post::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.post.index', qArray());
        }

        $data->update([
            'approved_at' => now(), 
            'approved_by' => Auth::user()->id,
        ]);
        
        $request->session()->flash('successMessage', __('lang.ModelApproved', ['model' => __('lang.Post')]));
        return redirect()->route('admin.post.index', qArray());
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('delete post');

        $data = Post::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.post.index', qArray());
        }

        $data->delete();

        MediaUploader::delete('posts', $data->id);
        
        $request->session()->flash('successMessage', __('lang.ModelDeleted', ['model' => __('lang.Post')]));
        return redirect()->route('admin.post.index', qArray());
    }

    public function destroyImage(Request $request)
    {
        $this->authorize('delete post');

        $validator = Validator::make($request->only('id'), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => implode(", ", $validator->messages()->all())], 401);
        }

        $data = PostMedia::find($request->id);
        if (empty($data)) {
            return response()->json(['success' => false, 'message' => 'Image not found!']);
        }

        MediaUploader::delete('posts/' . $data->id, $data->image, 1);

        $data->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }
}
