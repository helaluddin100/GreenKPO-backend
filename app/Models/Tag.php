<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Relationship to posts
    public function posts()
    {
        // Assuming your tag_id is stored in the `posts` table as JSON
        return Post::whereJsonContains('tag_id', $this->id)->get();
    }
}
