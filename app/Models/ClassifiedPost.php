<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassifiedPost extends Model
{
    protected $fillable = [
        'category_id', 'editor_id', 'content_en', 'content_bn', 'published_date', 'expired_date', 'approved_at', 'status', 'is_premium', 'approved_by', 'created_by', 'updated_by',
    ];

    public function category()
    {
        return $this->belongsTo(ClassifiedCategory::class, 'category_id');
    }

    public function editor()
    {
        return $this->belongsTo(Admin::class, 'editor_id');
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
