<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Sudip\MediaUploder\Facades\MediaUploader;

class DataMigrationController extends Controller {

    //wp_users, wp_term_taxonomy, wp_terms, wp_posts, wp_postmeta, wp_term_relationships
    
    public function users()
    {
        $users = DB::table('wp_users')->get();
        foreach ($users as $user) {
            $admin = Admin::create([
                'id' => $user->ID,
                'name' => $user->user_nicename,
                'mobile' => null,
                'email' => $user->user_email,
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'status' => 'Active',
            ]);
    
            $admin->assignRole('Super Admin');
        }

        dd('User done!');
    }

    public function categories()
    {
        $categories = DB::table('wp_term_taxonomy')
            ->select('wp_terms.*', 'wp_term_taxonomy.term_taxonomy_id', 'wp_term_taxonomy.parent')
            ->join('wp_terms', 'wp_term_taxonomy.term_id', '=', 'wp_terms.term_id')
            ->where('taxonomy', 'category')
            ->get();

        foreach ($categories as $key => $cat) {
            $data = Category::create([
                'id' => $cat->term_taxonomy_id,
                'parent_id' => $cat->parent,
                // 'slug_en' => $cat->slug,
                // 'slug_bn' => $cat->slug,
                'slug_en' => Str::slug($cat->name),
                'slug_bn' => Str::slug($cat->name),
                'name_en' => $cat->name,
                'name_bn' => $cat->name,
                'sorting' => ($key + 1),
                'type' => 'news',
                'status' => 'Active',
                'created_by' => null,
            ]);
        }

        dd('Category done!');
    }

    public function posts()
    {
        $posts = DB::table('wp_posts')
            ->select('wp_posts.*', 'B.guid')
            ->leftJoin(DB::raw("(SELECT wp_postmeta.post_id, wp_posts.guid FROM wp_postmeta INNER JOIN wp_posts ON wp_posts.ID = wp_postmeta.meta_value AND wp_postmeta.meta_key = '_thumbnail_id') AS B"), function($q) {
                $q->on('wp_posts.ID', '=', 'B.post_id');
            })
            ->where('wp_posts.post_type', 'post')
            ->where('wp_posts.post_status', 'publish')
            ->whereDate('wp_posts.post_date', '>', '2022-06-10')
            ->orderBy('wp_posts.ID', 'ASC')
            ->get();
            
        foreach ($posts as $post) {
            $postCategories = DB::table('wp_term_relationships')
            ->select('wp_term_relationships.term_taxonomy_id')
            ->join('wp_term_taxonomy', function($q) {
                $q->on('wp_term_relationships.term_taxonomy_id', '=', 'wp_term_taxonomy.term_taxonomy_id');
                $q->where('wp_term_taxonomy.taxonomy', '=', 'category');
            })
            ->where('object_id', $post->ID)
            ->get();

            $postData = [
                'id' => $post->ID,
                'category_id' => $postCategories[0]->term_taxonomy_id ?? null,
                'editor_id' => $post->post_author,
                // 'slug_en' => $post->post_name,
                // 'slug_bn' => $post->post_name,
                'slug_en' => Str::slug($post->post_title),
                'slug_bn' => Str::slug($post->post_title),
                'title_en' => $post->post_title,
                'title_bn' => $post->post_title,
                'content_en' => $post->post_content,
                'content_bn' => $post->post_content,
                'video_url' => null,
                'published_at' => $post->post_date,
                'approved_at' => $post->post_date,
                'status' => 'Published',
                'created_by' => $post->post_author,
                'approved_by' => $post->post_author,
            ];

            if ($post->guid != null) {
                $image = $post->guid;
                $context = stream_context_create(array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n")));
                $up = file_get_contents(str_replace('https', 'http', $image), false, $context);
                $img = MediaUploader::contentUpload($up, 'posts/' . $post->ID, $post->ID . '.jpg');
                
                Storage::makeDirectory('posts/' . $post->ID .'/thumb', 0777);
                $thumb = Image::make('storage/posts/' . $post->ID .'/'. $img['name']);

                $thumb->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $background = Image::canvas(200, 200);
                $background->insert($thumb, 'center');
                $background->save('storage/posts/' . $post->ID .'/thumb/'.$img['name']);

                $postData['image'] = $img['name'];
                $postData['image_url'] = $img['url'];
            }

            $post = Post::create($postData);
            if ($post) {
                $pkIds = [];
                foreach ($postCategories as $k => $pk) {
                    if ($k != 0) {
                        $pkIds[] = [
                            'post_id' => $post->id, 
                            'category_id' => $pk->term_taxonomy_id,
                        ];
                    }
                }

                if (!empty($pkIds)) {
                    PostCategory::insert($pkIds);
                }
            }            
        }

        dd('Post done!');
    }
}
