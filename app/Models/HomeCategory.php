<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeCategory extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'category_id', 'sorting',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
