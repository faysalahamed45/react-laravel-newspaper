<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClassifiedCategory;
use App\Models\ClassifiedPost;

class ClassifiedController extends Controller
{
    /**
     * @header x-language [en, bn]
     * @response {
        * "success": true,
        * "message": "Classified Category Provided.",
        * "data": [
            * {
                * "id": 1,
                * "slug": "rhona-beach",
                * "name": "Amal Harris",
                * "posts_count": 106
            * }
        * ]
     * }
     */
    public function category(Request $request)
    {
        $lang = $request->header('x-language') ?? 'en';

        $sql = ClassifiedCategory::where('status', 'Active')
        ->orderBy('sorting', 'ASC');

        if ($lang == 'bn') {
            $sql->select('id', 'slug_bn AS slug', 'name_bn AS name');
        } else {
            $sql->select('id', 'slug_en AS slug', 'name_en AS name');
        }

        $categories = $sql->withCount('posts')->get();

        return response()->json([
            'success' => true,
            'message' => 'Classified Category Provided.',
            'data' => $categories,
        ], 200);
    }

    /**
     * @header x-language [en, bn]
     * @response {
        * "success": true,
        * "message": "Home Page Data Provided.",
        * "data": {
            * "premium_post": [
                * {
                    * "id": 1,
                    * "category_id": 1,
                    * "is_premium": "Yes",
                    * "content": "<p>vcb cb</p>",
                    * "category": {
                        * "id": 1,
                        * "name": "Constance Ryan",
                        * "slug": "constance-ryan"
                    * }
                * }
            * ],
            * "category_post": [
                * {
                    * "id": 1,
                    * "slug": "constance-ryan",
                    * "name": "Constance Ryan",
                    * "posts": [
                        * {
                            * "id": 1,
                            * "category_id": 1,
                            * "is_premium": "Yes",
                            * "content": "<p>vcb cb</p>"
                        * }
                    * ]
                * }
            * ]
        * }
     * }
     */
    public function homePosts(Request $request)
    {
        $lang = $request->header('x-language') ?? 'en';

        $premiumPost = $this->postWith($lang)->where('is_premium', 'Yes')->orderBy('id', 'DESC')->limit(10)->get();

        $sql = ClassifiedCategory::where('status', 'Active')
        ->orderBy('sorting', 'ASC');
        if ($lang == 'bn') {
            $sql->select('id', 'slug_bn AS slug', 'name_bn AS name');
        } else {
            $sql->select('id', 'slug_en AS slug', 'name_en AS name');
        }
        $categories = $sql->get();

        $categories->each(function ($category) use($lang) {
            $category->load(['posts' => function ($q) use($lang) {
                $q->select('id', 'category_id', 'is_premium')
                    ->where('published_date', '<=', date('Y-m-d'))
                    ->where('status', 'Published')
                    ->whereNotNull('approved_at')
                    ->where(function ($r) {
                        $r->whereNull('expired_date');
                        $r->orWhere('expired_date', '>=', date('Y-m-d'));
                    })
                    ->limit(20)
                    ->orderBy('id', 'DESC');

                if ($lang == 'bn') {
                    $q->addSelect('content_bn AS content');
                } else {
                    $q->addSelect('content_en AS content');
                }
            }]);
        });

        $data = [
            'premium_post' => $premiumPost,
            'category_post' => $categories,
        ];

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
        * "message": "Category posts Provided.",
        * "data": [
            * {
                * "id": 1,
                * "category_id": 1,
                * "is_premium": "Yes",
                * "content": "<p>vcb cb</p>",
                * "category": {
                    * "id": 1,
                    * "name": "Constance Ryan",
                    * "slug": "constance-ryan"
                * }
            * }
        * ]
     * }
     */
    public function categoryPosts(Request $request, $slug)
    {
        $lang = $request->header('x-language') ?? 'en';

        $posts = $this->postWith($lang)
        ->whereHas('category', function($q) use($slug, $lang) {
            if ($lang == 'bn') {
                $q->where('slug_bn', $slug);
            } else {
                $q->where('slug_en', $slug);
            }
        })
        ->get();

        if (empty($posts) && $posts->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Category post not found!',
                'data' => null,
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Category posts Provided.',
            'data' => $posts,
        ], 200);
    }

    /**
     * @header x-language [en, bn]
     * @queryParam filter string required (premium, new, old, general)
     * @response {
        * "success": true,
        * "message": "Filter posts Provided.",
        * "data": [
            * {
                * "id": 1,
                * "category_id": 1,
                * "is_premium": "Yes",
                * "content": "<p>vcb cb</p>",
                * "category": {
                    * "id": 1,
                    * "name": "Constance Ryan",
                    * "slug": "constance-ryan"
                * }
            * }
        * ]
     * }
     */
    public function filterPosts(Request $request)
    {
        $lang = $request->header('x-language') ?? 'en';

        $sql = $this->postWith($lang);

        if ($request->filter == 'premium') {
            $sql->where('is_premium', 'Yes');
            $sql->orderBy('id', 'DESC');
        } elseif ($request->filter == 'new') {
            $sql->orderBy('id', 'DESC');
        } elseif ($request->filter == 'old') {
            $sql->orderBy('id', 'ASC');
        } elseif ($request->filter == 'general') {
            $sql->where('is_premium', '!=', 'Yes');
            $sql->orderBy('id', 'ASC');
        }

        $posts = $sql->get();

        if (empty($posts) && $posts->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Filter post not found!',
                'data' => null,
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Filter posts Provided.',
            'data' => $posts,
        ], 200);
    }

    protected function postWith($lang)
    {
        $data = ClassifiedPost::select('id', 'category_id', 'is_premium')
        ->with(['category' => function($q) use($lang) {
            if ($lang == 'bn') {
                $q->select('id', 'name_bn AS name', 'slug_bn AS slug');
            } else {
                $q->select('id', 'name_en AS name', 'slug_en AS slug');
            }
        }])
        ->where('published_date', '<=', date('Y-m-d'))
        ->where('status', 'Published')
        ->whereNotNull('approved_at')
        ->where(function($q) {
            $q->whereNull('expired_date');
            $q->orWhere('expired_date', '>=', date('Y-m-d'));
        });

        if ($lang == 'bn') {
            $data->addSelect('content_bn AS content');
        } else {
            $data->addSelect('content_en AS content');
        }

        return $data;
    }
}
