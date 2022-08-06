<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Post;
use App\Models\Category;
use App\Models\HomeCategory;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Sudip\MediaUploder\Facades\MediaUploader;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryArr = [
            [
                'name_bn' => 'আমেরিকা',
                'type' => 'news',
                'show_in_home' => 'Yes',
                'childs' => [
                    ['name_bn' => 'আমেরিকা পরিক্রমা'],
                    ['name_bn' => 'নিউইয়র্ক পরিক্রমা'],
                    ['name_bn' => 'আমেরিকার অন্দরে'],
                ]
            ],
            [
                'name_bn' => 'প্রবাস',
                'type' => 'news',
                'show_in_home' => 'No',
                'childs' => [
                    ['name_bn' => 'এশিয়া'],
                    ['name_bn' => 'মধ্য প্রাচ্য'],
                    ['name_bn' => 'আফ্রিকা'],
                    ['name_bn' => 'অস্ট্রেলিয়া'],
                    ['name_bn' => 'ইউরোপ'],
                ]
            ],
            [
                'name_bn' => 'বাংলাদেশ',
                'type' => 'news',
                'show_in_home' => 'No',
            ],
            [
                'name_bn' => 'বিশ্বচরাচর',
                'type' => 'news',
                'show_in_home' => 'No',
            ],
            [
                'name_bn' => 'সম্পাদকীয়',
                'type' => 'news',
                'show_in_home' => 'No',
                'childs' => [
                    ['name_bn' => 'উপ-সম্পাদকীয়'],
                    ['name_bn' => 'মুক্তাঙ্গন'],
                ]
            ],
            [
                'name_bn' => 'চালচিত্র',
                'type' => 'news',
                'show_in_home' => 'No',
            ],
            [
                'name_bn' => 'খেলাধুলা',
                'type' => 'news',
                'show_in_home' => 'No',
                'childs' => [
                    ['name_bn' => 'ক্রিকেট'],
                    ['name_bn' => 'ফুটবল'],
                    ['name_bn' => 'অন্যান্য'],
                ]
            ],
            [
                'name_bn' => 'ইমিগ্রেশন',
                'type' => 'news',
                'show_in_home' => 'No',
            ],
            [
                'name_bn' => 'সাহিত্যের খোলা জানালা',
                'type' => 'news',
                'show_in_home' => 'No',
            ],
            [
                'name_bn' => 'আনন্দলোক',
                'type' => 'news',
                'show_in_home' => 'No',
            ],
            [
                'name_bn' => 'রাজনীতি',
                'type' => 'news',
                'show_in_home' => 'Yes',
            ],
            [
                'name_bn' => 'করোনাভাইরাস',
                'type' => 'news',
                'show_in_home' => 'No',
            ],
            [
                'name_bn' => 'প্রযুক্তি',
                'type' => 'news',
                'show_in_home' => 'No',
            ],
            [
                'name_bn' => 'শিক্ষা',
                'type' => 'news',
                'show_in_home' => 'No',
            ],
            [
                'name_bn' => 'ধর্ম',
                'type' => 'news',
                'show_in_home' => 'No',
            ],
            [
                'name_bn' => 'ছবি',
                'type' => 'gallery',
                'show_in_home' => 'No',
            ],
            [
                'name_bn' => 'ভিডিও',
                'type' => 'video',
                'show_in_home' => 'No',
            ],
            [
                'name_bn' => 'চাকরি',
                'type' => 'news',
                'show_in_home' => 'No',
            ],
        ];

        $homeCatSort = 1;
        foreach ($categoryArr as $key => $cat) {
            $data = Category::create([
                'parent_id' => 0,
                'slug_en' => Str::slug($cat['name_bn']),
                'slug_bn' => Str::slug($cat['name_bn']),
                'name_en' => ucwords(str_replace('-', ' ', Str::slug($cat['name_bn']))),
                'name_bn' => $cat['name_bn'],
                'sorting' => ($key + 1),
                'type' => $cat['type'],
                'status' => 'Active',
                'created_by' => 1,
            ]);

            if ($cat['show_in_home'] == 'Yes') {
                HomeCategory::create([
                    'category_id' => $data->id,
                    'sorting' => ($homeCatSort + 1),
                ]);
            }
            
            if (isset($cat['childs'])) {
                foreach ($cat['childs'] as $key => $chld) {
                    Category::create([
                        'parent_id' => $data->id,
                        'slug_en' => Str::slug($chld['name_bn']),
                        'slug_bn' => Str::slug($chld['name_bn']),
                        'name_en' => ucwords(str_replace('-', ' ', Str::slug($chld['name_bn']))),
                        'name_bn' => $chld['name_bn'],
                        'sorting' => ($key + 1),
                        'status' => 'Active',
                        'created_by' => 1,
                    ]);
                }
            }
        }

        $menuArr = [
            'header' => [
                'আমেরিকা',
                'প্রবাস',
                'বাংলাদেশ',
                'বিশ্বচরাচর',
                'সম্পাদকীয়',
                'চালচিত্র',
                'খেলাধুলা',
                'ইমিগ্রেশন',
                'সাহিত্যের খোলা জানালা',
                'আনন্দলোক',
            ],
            'footer' => [
                'আমেরিকা',
                'প্রবাস',
                'বাংলাদেশ',
                'বিশ্বচরাচর',
                'সম্পাদকীয়',
                'চালচিত্র',
                'খেলাধুলা',
                'ইমিগ্রেশন',
            ],
            'hamburger' => [
                'আমেরিকা',
                'প্রবাস',
                'রাজনীতি',
                'বাংলাদেশ',
                'বিশ্বচরাচর',
                'সম্পাদকীয়',
                'চালচিত্র',
                'করোনাভাইরাস',
                'খেলাধুলা',
                'প্রযুক্তি',
                'শিক্ষা',
                'ধর্ম',
                'ছবি',
                'ভিডিও',
                'চাকরি',
            ]
        ];

        $category = Category::pluck('id', 'name_bn')->toArray();
        foreach ($menuArr as $key => $arr) {
            foreach ($arr as $k => $val) {
                Menu::create([
                    'parent_id' => 0,
                    'position' => $key,
                    'taggable_id' => $category[$val],
                    'taggable_type' => Category::class,
                    'sorting' => ($k + 1),
                    'status' => 'Active',
                    'created_by' => 1,
                ]);
            }
        }

        if (Storage::exists('posts')) {
            Storage::delete('posts');
        }

        $faker = Faker::create();
        $categories = Category::get();
        foreach ($categories as $cat) {
            for ($i=0; $i <= 10; $i++) { 
                $title = $faker->sentence(15);
                $post = Post::create([
                    'category_id' => $cat->id,
                    'editor_id' => 1,
                    'slug_en' => Str::slug($title),
                    'slug_bn' => Str::slug($title),
                    'title_en' => $title,
                    'title_bn' => $title,
                    'content_en' => $faker->paragraph(10),
                    'content_bn' => $faker->paragraph(10),
                    'video_url' => ($cat->type == 'video' ? 'https://www.youtube.com/watch?v=euutjIUIXTY' : null),
                    'published_at' => now(),
                    'approved_at' => now(),
                    'status' => 'Published',
                    'created_by' => 1,
                    'approved_by' => 1,
                ]);

                $image = $faker->imageUrl($width = 640, $height = 480);
                $context = stream_context_create(array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n")));
                $up = file_get_contents(str_replace('https', 'http', $image), false, $context);
                $img = MediaUploader::contentUpload($up, 'posts/' . $post->id, Str::slug($title) . '.jpg');
                
                Storage::makeDirectory('posts/' . $post->id .'/thumb', 0777);
                $thumb = Image::make('public/storage/posts/' . $post->id .'/'. $img['name']);

                $thumb->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $background = Image::canvas(200, 200);
                $background->insert($thumb, 'center');
                $background->save('public/storage/posts/' . $post->id .'/thumb/'.$img['name']);

                $post->update([
                    'image' => $img['name'],
                    'image_url' => $img['url'],
                ]);
            }
            
        }
    }
}
