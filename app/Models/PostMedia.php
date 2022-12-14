<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostMedia extends Model
{
    protected $fillable = [
        'post_id', 'type', 'file_name', 'file_url', 'sorting',
    ];
}
