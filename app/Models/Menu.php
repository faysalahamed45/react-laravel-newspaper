<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'parent_id', 'position', 'taggable_id', 'taggable_type', 'sorting', 'status', 'created_by', 'updated_by',
    ];

    public function childs()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function taggable()
    {
        return $this->morphTo();
    }

    public function positions()
    {
        return $this->hasMany(Menu::class, 'position', 'position')->where('parent_id', 0);
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
