<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassifiedCategory extends Model
{
    protected $fillable = [
        'slug_en', 'slug_bn', 'name_en', 'name_bn', 'sorting', 'status', 'created_by', 'updated_by',
    ];

    public function posts()
    {
        return $this->hasMany(ClassifiedPost::class, 'category_id');
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
