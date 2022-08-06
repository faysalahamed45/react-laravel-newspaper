<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'id', 'category_id', 'editor_id', 'slug_en', 'slug_bn', 'title_en', 'title_bn', 'content_en', 'content_bn', 'image', 'video_url', 'image_url', 'published_at', 'approved_at', 'status', 'feature_post', 'feature_post_2', 'exclusive', 'total_view', 'approved_by', 'created_by', 'updated_by',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function editor()
    {
        return $this->belongsTo(Admin::class, 'editor_id');
    }

    public function medias()
    {
        return $this->hasMany(PostMedia::class);
    }

    public function postCategories()
    {
        return $this->hasMany(PostCategory::class);
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
