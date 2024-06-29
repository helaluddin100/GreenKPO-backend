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

    // Define a mutator to ensure tag_id is always cast to array
    protected $casts = [
        'tag_id' => 'array',
    ];

    // Define an accessor to retrieve tag names
    public function getTagNamesAttribute()
    {
        return Tag::whereIn('id', $this->tag_id)->pluck('name')->toArray();
    }
}
