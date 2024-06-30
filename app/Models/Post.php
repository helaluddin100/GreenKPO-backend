<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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





    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define an accessor to retrieve tag names
    public function getTagNamesAttribute()
    {
        if (empty($this->tag_id)) {
            return [];
        }

        // Ensure tag_id is an array (this should be handled by the cast, but it's a safety check)
        $tagIds = is_array($this->tag_id) ? $this->tag_id : json_decode($this->tag_id, true);

        // Return an empty array if tagIds is not an array or empty
        if (!is_array($tagIds) || empty($tagIds)) {
            return [];
        }

        // Fetch tag names based on tagIds
        return Tag::whereIn('id', $tagIds)->pluck('name')->toArray();
    }
}
