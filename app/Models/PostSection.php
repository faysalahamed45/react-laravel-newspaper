<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostSection extends Model
{
    protected $fillable = [
        'post_id', 'type', 'sorting',
    ];
}
