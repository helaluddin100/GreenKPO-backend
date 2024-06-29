<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{


    public function getPosts(Request $request)
    {
        $perPage = $request->query('perPage', 10);
        $page = $request->query('page', 1);

        $posts = Post::orderBy('created_at', 'desc')
            ->skip(1)
            ->paginate($perPage, ['*'], 'page', $page);

        // Append tag names to each post
        $posts->getCollection()->transform(function ($post) {
            $post->tag_names = $post->tag_names;
            return $post;
        });

        return response()->json($posts);
    }

    public function getLastPost()
    {
        $lastPost = Post::orderBy('created_at', 'desc')->first();

        if ($lastPost) {
            $lastPost->tag_names = $lastPost->tag_names;
        }

        return response()->json($lastPost);
    }


    public function getPostBySlug($slug)
    {
        $post = Post::where('slug', $slug)->first();

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }       

        return response()->json($post);
    }
}
