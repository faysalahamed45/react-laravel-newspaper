<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\Page;
use App\Models\Post;
use App\Models\Category;
use App\Models\HomeCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    /**
     * @header x-language [en, bn]
     * @response {
        * "success": true,
        * "message": "Menu Provided.",
        * "data": {
            * "header": [
                * {
                    * "id": 1,
                    * "page_type": "Page",
                    * "type": null,
                    * "slug": "rhona-beach",
                    * "name": "Rhona Beach"
                * }
            * ],
            * "footer": [
                * {
                    * "id": 3,
                    * "page_type": "Category",
                    * "type": "news",
                    * "slug": "c",
                    * "name": "C"
                * }
            * ]
        * }
     * }
     */
    public function menu(Request $request)
    {
        $lang = $request->header('x-language') ?? 'en';

        $menus = Menu::select('position')->with(['positions' => function($q) {
            $q->orderBy('sorting', 'ASC');
            $q->with(['taggable', 'childs' => function($q) {
                $q->where('status', 'Active');
                $q->orderBy('sorting', 'ASC');
                $q->with('taggable');
            }]);
        }])
        ->where('status', 'Active')
        ->groupBy('position')
        ->get();

        $menuData = [];
        foreach ($menus as $val) {
            $menuArr = [];
            foreach ($val->positions as $v) {
                $childArr = [];
                foreach ($v->childs as $c) {
                    $childArr[] = [
                        'id' => $c->id,
                        'page_type' => str_replace('App\\Models\\', '', $c->taggable_type),
                        'type' => $c->taggable->type,
                        'slug' => $lang == 'bn' ? $c->taggable->slug_bn : $c->taggable->slug_en,
                        'name' => $lang == 'bn' ? $c->taggable->name_bn : $c->taggable->name_en,
                    ];
                }

                $menuArr[] = [
                    'id' => $v->id,
                    'page_type' => str_replace('App\\Models\\', '', $v->taggable_type),
                    'type' => $v->taggable->type,
                    'slug' => $lang == 'bn' ? $v->taggable->slug_bn : $v->taggable->slug_en,
                    'name' => $lang == 'bn' ? $v->taggable->name_bn : $v->taggable->name_en,
                    'childs' => count($childArr) > 0 ? $childArr : null,
                ];
            }

            $menuData[$val->position] = $menuArr;
        }

        return response()->json([
            'success' => true,
            'message' => 'Menu Provided.',
            'data' => $menuData,
        ], 200);
    }

    /**
     * @header x-language [en, bn]
     * @response {
        * "success": true,
        * "message": "Home Page Data Provided.",
        * "data": {
            * "feature_post": [
                * {
                    * "id": 1,
                    * "category_id": 1,
                    * "editor_id": 2,
                    * "slug": "libero-nostrum-ut-si",
                    * "title": "Libero nostrum ut si",
                    * "content": "Labore inventore exc.1",
                    * "image_url": "http://localhost/oshni/thikana/public/storage/posts/1/1.jpg",
                    * "video_url": "https://www.youtube.com/watch?v=euutjIUIXTY",
                    * "published_at": "2022-06-01 03:45:00",
                    * "editor": {
                        * "id": 2,
                        * "name": "Fiona Paul"
                    * },
                    * "category": {
                        * "id": 1,
                        * "name": "রাজনীতি"
                    * },
                    * "medias": [
                        * {
                            * "post_id": 1,
                            * "type": "image",
                            * "file_url": "http://localhost/oshni/thikana/public/storage/posts/1/2.jpg"
                        * },
                        * {
                            * "post_id": 1,
                            * "type": "image",
                            * "file_url": "http://localhost/oshni/thikana/public/storage/posts/1/3.jpg"
                        * }
                    * ]
                * }
            * ],
            * "feature_post_2": [],
            * "exclusive": [],
            * "latest_post": [],
            * "top_read": [],
            * "category_section_1": []
        * }
     * }
     */
    public function homePosts(Request $request)
    {
        $lang = $request->header('x-language') ?? 'en';

        $featurePost = $this->postWith($lang)->where('feature_post', 1)->orderBy('id', 'DESC')->limit(10)->get();
        $featurePost2 = $this->postWith($lang)->where('feature_post_2', 1)->orderBy('id', 'DESC')->limit(10)->get();
        $exclusive = $this->postWith($lang)->where('exclusive', 1)->orderBy('id', 'DESC')->limit(10)->get();
        $latestPost = $this->postWith($lang)->orderBy('id', 'DESC')->limit(10)->get();
        $topRead = $this->postWith($lang)->orderBy('total_view', 'DESC')->limit(10)->get();

        $data = [
            'feature_post' => $featurePost, 
            'feature_post_2' => $featurePost2, 
            'exclusive' => $exclusive,
            'latest_post' => $latestPost,
            'top_read' => $topRead,
        ];

        $homePageCats = HomeCategory::with(['category' => function($q) use($lang) {
            if ($lang == 'bn') {
                $q->select('id', 'slug_bn AS slug', 'name_bn AS name');
            } else {
                $q->select('id', 'slug_en AS slug', 'name_en AS name');
            }
        }])->get();
        foreach ($homePageCats as $key => $val) {
            if ($val->category != null) {
                $posts = $this->postWith($lang)
                ->where('category_id', $val->category_id)
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();

                $data['category_section_' . ($key + 1)] = [
                    'slug' => $val->category->slug,
                    'name' => $val->category->name,
                    'posts' => $posts,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Home Page Data Provided.',
            'data' => $data,
        ], 200);

        
    }

    /**
     * @header x-language [en, bn]
     * @response {
        * "success": true,
        * "message": "Data Provided.",
        * "type": "Page",
        * "data": {
            * "page": {
                * "name": "Rhona Beach",
                * "content": "Cupiditate velit, iu.rterter"
            * },
            * "category": {
                * "id": 5,
                * "parent_id": 1,
                * "slug": "c",
                * "name": "C",
                * "parent": {
                    * "id": 1,
                    * "slug": "politics",
                    * "name": "Politics"
                * },
                * "childs": [
                    * {
                        * "parent_id": 1,
                        * "slug": "a",
                        * "name": "A"
                    * }
                * ]
            * },
            * "posts": {
                * "data": [
                    * {
                        * "id": 1,
                        * "category_id": 1,
                        * "editor_id": 2,
                        * "slug": "libero-nostrum-ut-si",
                        * "title": "Libero nostrum ut si",
                        * "content": "Labore inventore exc.1",
                        * "image_url": "http://localhost/oshni/thikana/public/storage/posts/1/1.jpg",
                        * "video_url": "https://www.youtube.com/watch?v=euutjIUIXTY",
                        * "published_at": "2022-06-01 03:45:00",
                        * "editor": {
                            * "id": 2,
                            * "name": "Fiona Paul"
                        * },
                        * "category": {
                            * "id": 1,
                            * "slug": "politics",
                            * "name": "Politics"
                        * }
                    * }
                * ]
            * }
        * }
     * }
     */
    public function menuPosts(Request $request, $slug)
    {
        $lang = $request->header('x-language') ?? 'en';

        $taggable = Menu::with('taggable')
        ->whereHas('taggable', function($q) use($slug, $lang) {
            if ($lang == 'bn') {
                $q->where('slug_bn', $slug);
            } else {
                $q->where('slug_en', $slug);
            }
        })
        ->first();

        if (empty($taggable)) {
            return response()->json([
                'success' => false,
                'message' => 'Menu not found!',
                'data' => null,
            ], 401);
        }

        $responseData = [];
        if ($taggable->taggable_type == Category::class) {
            $catSql = Category::select('id', 'parent_id')->with(['parent' => function($q) use($lang) {
                if ($lang == 'bn') {
                    $q->select('id', 'slug_bn AS slug', 'name_bn AS name');
                } else {
                    $q->select('id', 'slug_en AS slug', 'name_en AS name');
                }
            }, 'childs' => function($q) use($lang) {
                $q->orderBy('sorting', 'ASC');
                if ($lang == 'bn') {
                    $q->select('parent_id', 'slug_bn AS slug', 'name_bn AS name');
                } else {
                    $q->select('parent_id', 'slug_en AS slug', 'name_en AS name');
                }
            }]);

            if ($lang == 'bn') {
                $catSql->addSelect('slug_bn AS slug', 'name_bn AS name');
            } else {
                $catSql->addSelect('slug_en AS slug', 'name_en AS name');
            }
            
            $category = $catSql->find($taggable->taggable->id);

            $postSql = Post::select('id', 'category_id', 'editor_id', 'video_url', 'image_url', 'published_at')->with(['editor' => function($q) {
                $q->select('id', 'name');
            }, 'category' => function($q) use($lang) {
                if ($lang == 'bn') {
                    $q->select('id', 'slug_bn AS slug', 'name_bn AS name');
                } else {
                    $q->select('id', 'slug_en AS slug', 'name_en AS name');
                }
            }])
            ->where(function($q) use($category) {
                $q->where('category_id', $category->id);
                $q->orWhereHas('postCategories', function($r) use($category) {
                    $r->where('category_id', $category->id);
                });
            })
            ->whereNotNull('approved_at')
            ->orderBy('id', 'DESC');

            if ($lang == 'bn') {
                $postSql->addSelect('slug_bn AS slug', 'title_bn AS title', 'content_bn AS content');
            } else {
                $postSql->addSelect('slug_en AS slug', 'title_en AS title', 'content_en AS content');
            }

            $posts = $postSql->paginate(24);

            $responseData = [
                'category' => $category,
                'posts' => $posts,
            ];
        } elseif ($taggable->taggable_type == Page::class) {
            if ($lang == 'bn') {
                $page = Page::select('name_bn AS name', 'content_bn AS content')->find($taggable->taggable->id);
            } else {
                $page = Page::select('name_en AS name', 'content_en AS content')->find($taggable->taggable->id);
            }

            $responseData = [
                'page' => $page,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Provided.',
            'type' => str_replace('App\\Models\\', '', $taggable->taggable_type),
            'data' => $responseData,
        ], 200);
    }

    /**
     * @header x-language [en, bn]
     * @response {
        * "success": true,
        * "message": "Post Provided.",
        * "data": {
            * "id": 1,
            * "category_id": 1,
            * "editor_id": 2,
            * "slug": "libero-nostrum-ut-si",
            * "title": "Libero nostrum ut si",
            * "content": "Labore inventore exc.1",
            * "image_url": "http://localhost/oshni/thikana/public/storage/posts/1/1.jpg",
            * "video_url": "https://www.youtube.com/watch?v=euutjIUIXTY",
            * "published_at": "2022-06-01 03:45:00",
            * "editor": {
                * "id": 2,
                * "name": "Fiona Paul"
            * },
            * "category": {
                * "id": 1,
                * "slug": "politics",
                * "name": "Politics"
            * },
            * "medias": [
                * {
                    * "post_id": 1,
                    * "type": "image",
                    * "file_url": "http://localhost/oshni/thikana/public/storage/posts/1/2.jpg"
                * },
                * {
                    * "post_id": 1,
                    * "type": "image",
                    * "file_url": "http://localhost/oshni/thikana/public/storage/posts/1/3.jpg"
                * }
            * ]
        * }
     * }
     */
    public function postDetails(Request $request, $slug)
    {
        $lang = $request->header('x-language') ?? 'en';

        $post = $this->postWith($lang)
        ->where(function($q) use($slug, $lang) {
            if ($lang == 'bn') {
                $q->where('slug_bn', $slug);
            } else {
                $q->where('slug_en', $slug);
            }
        })
        ->first();

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post Not Found.',
                'data' => null,
            ], 401);
        }

        $post->update(['total_view' => ($post->total_view + 1)]);

        return response()->json([
            'success' => true,
            'message' => 'Post Provided.',
            'data' => $post,
        ], 200);
    }

    protected function postWith($lang)
    {
        $sql = Post::select('id', 'category_id', 'editor_id', 'image_url', 'video_url', 'published_at', 'total_view')
        ->whereNotNull('approved_at')
        ->where('status', 'Published')
        ->with(['editor' => function($q) {
            $q->select('id', 'name');
        }, 'category' => function($q) use($lang) {
            if ($lang == 'bn') {
                $q->select('id', 'slug_bn AS slug', 'name_bn AS name');
            } else {
                $q->select('id', 'slug_en AS slug', 'name_en AS name');
            }
        }, 'medias' => function($q) {
            $q->orderBy('sorting', 'ASC');
            $q->select('post_id', 'type', 'file_url');
        }]);

        if ($lang == 'bn') {
            $sql->addSelect('slug_bn AS slug', 'title_bn AS title', 'content_bn AS content');
        } else {
            $sql->addSelect('slug_en AS slug', 'title_en AS title', 'content_en AS content');
        }

        return $sql;
    }
}
