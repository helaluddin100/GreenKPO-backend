<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.post.index', compact('posts'));
    }


    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/uploads'), $imageName);

            return response()->json(['location' => url('assets/images/uploads/' . $imageName)]);
        }

        return response()->json(['error' => 'No image file found'], 400);
    }







    public function create()
    {
        $tags = Tag::where('status', 1)->get();
        return view('admin.post.create', compact('tags'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'small_title' => 'nullable|string|max:255',
            'image' => 'required',
            'description' => 'required',
            'tag_id' => 'required|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_descriptions' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'read_time' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);


        // dd($validatedData);
        // Replace ../../../ with your app URL
        $description = str_replace(['../../..', '../..'], config('app.url'), $request->get('description'));


        $slug = Str::slug($validatedData['title']);
        $status = $request->has('status') ? true : false;

        $post = new Post([
            'user_id' => Auth::user()->id,
            'title' => $validatedData['title'],
            'small_title' => $validatedData['small_title'],
            'description' => $description, // Use the modified description
            'tag_id' => json_encode($validatedData['tag_id']),
            'slug' => $slug,
            'meta_title' => $validatedData['meta_title'],
            'meta_descriptions' => $validatedData['meta_descriptions'],
            'meta_keyword' => $validatedData['meta_keyword'],
            'read_time' => $validatedData['read_time'],
            'category' => $validatedData['category'],
            'status' => $status,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/post'), $imageName);
            $post->image = 'assets/images/post/' . $imageName;
        }

        $post->save();

        return redirect()->route('admin.post.index')->with('success', 'Post created successfully.');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.post.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $tags = Tag::where('status', 1)->get();

        return view('admin.post.edit', compact('post', 'tags'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'small_title' => 'nullable',
            'image' => 'nullable',
            'description' => 'required',
            'tag_id' => 'required|array',
            'meta_title' => 'nullable',
            'meta_descriptions' => 'nullable',
            'meta_keyword' => 'nullable',
            'read_time' => 'nullable',
            'category' => 'nullable',
        ]);

        // dd($validatedData);
        $description = str_replace(['../../..', '../..'], config('app.url'), $validatedData['description']);

        $status = $request->has('status') ? true : false;

        $post = Post::findOrFail($id);
        $post->title = $validatedData['title'];
        $post->small_title = $validatedData['small_title'];
        $post->description = $description; // Use the modified description
        $post->tag_id = json_encode($validatedData['tag_id']);
        $post->meta_title = $validatedData['meta_title'];
        $post->meta_descriptions = $validatedData['meta_descriptions'];
        $post->meta_keyword = $validatedData['meta_keyword'];
        $post->read_time = $validatedData['read_time'];
        $post->category = $validatedData['category'];
        $post->status = $status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/post'), $imageName);
            $post->image = 'assets/images/post/' . $imageName;
        }

        $post->save();

        return redirect()->route('admin.post.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.post.index')->with('success', 'Post deleted successfully.');
    }
}