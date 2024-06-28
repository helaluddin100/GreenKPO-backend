<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    protected $fillable = [
        'author',
        'title',
        'small_title',
        'image',
        'description',
        'tag_id',
        'slug',
        'meta_title',
        'meta_descriptions',
        'meta_keyword',
        'view_count',
        'status',
    ];
}
