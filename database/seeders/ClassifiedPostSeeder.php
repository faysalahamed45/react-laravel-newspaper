<?php

namespace Database\Seeders;

use App\Models\ClassifiedCategory;
use App\Models\ClassifiedPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClassifiedPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClassifiedCategory::firstOrCreate([
            'slug_en' => Str::slug('House Rent'),
            'slug_bn' => Str::slug('পরুম ভাড়া'),
            'name_en' => 'House Rent',
            'name_bn' => 'রুম ভাড়া',
            'status' => 'Active',
            'created_by' => 1,
        ])->posts()->saveMany($this->getPosts('বাফেলোতে নেয়ার বাস এন্ড ডাউন টাউনের কাছে একটি চার বেডরুমের বাড়ীর ভাড়া দেওয়া হবে। যোগযোগঃ <span class="fw-bold">646-240-3517</span>. টিসি-০৩৩৯/৪'));

        ClassifiedCategory::firstOrCreate([
            'slug_en' => Str::slug('Groom Bride'),
            'slug_bn' => Str::slug('পাত্র পাত্রী'),
            'name_en' => 'Groom Bride',
            'name_bn' => 'পাত্র পাত্রী',
            'status' => 'Active',
            'created_by' => 1,
        ])->posts()->saveMany($this->getPosts('পাত্র/পাত্রী চাই পাত্র-পাত্রী কানেকশন। সম্ভ্রান্ত, ভদ্র, মার্জিত ও শিক্ষিত পাত্র-পাত্রীর সন্ধান পেতে যোগাযোগ করুন। For educated, highly educated grown up boys & girls. Call: <span class="fw-bold">917-312-9170.</span> Tc-1218/8'));

        ClassifiedCategory::firstOrCreate([
            'slug_en' => Str::slug('Driver Wanted'),
            'slug_bn' => Str::slug('ড্রাইভার আবশ্যক'),
            'name_en' => 'Driver Wanted',
            'name_bn' => 'ড্রাইভার আবশ্যক',
            'status' => 'Active',
            'created_by' => 1,
        ])->posts()->saveMany($this->getPosts('জ্যামাইকা, জ্যাকসন হাইটস, উডসাইড যে কোন এরিয়ায় ২০১৭/২০১৮ সালের র‌্যাভ-৪ গাড়ির জন্য ড্রাইভার আবশ্যক। </div> <div class="text-center fw-bold driver">929-229-6836</div>'));

        ClassifiedCategory::firstOrCreate([
            'slug_en' => Str::slug('Recruitment'),
            'slug_bn' => Str::slug('নিয়োগ'),
            'name_en' => 'Recruitment',
            'name_bn' => 'নিয়োগ',
            'status' => 'Active',
            'created_by' => 1,
        ])->posts()->saveMany($this->getPosts('জ্যামাইকা, জ্যাকসন হাইটস, উডসাইড যে কোন এরিয়ায় ২০১৭/২০১৮ সালের র‌্যাভ-৪ গাড়ির জন্য ড্রাইভার আবশ্যক। </div> <div class="text-center fw-bold driver">929-229-6836</div>'));

        ClassifiedCategory::firstOrCreate([
            'slug_en' => Str::slug('Business Ad'),
            'slug_bn' => Str::slug('ব্যবসায়িক বিজ্ঞাপন'),
            'name_en' => 'Business Ad',
            'name_bn' => 'ব্যবসায়িক বিজ্ঞাপন',
            'status' => 'Active',
            'created_by' => 1,
        ])->posts()->saveMany($this->getPosts('জ্যামাইকা, জ্যাকসন হাইটস, উডসাইড যে কোন এরিয়ায় ২০১৭/২০১৮ সালের র‌্যাভ-৪ গাড়ির জন্য ড্রাইভার আবশ্যক। </div> <div class="text-center fw-bold driver">929-229-6836</div>'));
    }

    protected function getPosts($content_en = null, $content_bn = null)
    {
        $posts = [];
        for ($i = 0; $i < 30; $i++) {
            $posts[] = new ClassifiedPost([
                'editor_id' => 1,
                'content_en' => $content_en,
                'content_bn' => $content_bn ?: $content_en,
                'published_date' => now()->subDay(),
                'approved_at' => now()->subDay(),
                'status' => 'Published',
                'is_premium' => ['No', 'Yes'][array_rand(['No', 'Yes'])],
                'approved_by' => 1,
                'created_by' => 1,
            ]);
        }

        return $posts;
    }
}
