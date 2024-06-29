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
        // Validate the file upload
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size as necessary
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $path = $uploadedFile->storeAs('public/uploads', $filename); // Store in 'storage/app/public/uploads'

            // Generate URL for the uploaded file
            $url = asset('storage/uploads/' . $filename); // Adjust as per your storage configuration

            return response()->json(['location' => $url]);
        }

        return response()->json(['error' => 'File upload failed.']);
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        // dd($request);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'small_title' => 'nullable|string|max:255',
            'image' => 'required',
            'description' => 'required',
            'tag_id' => 'required|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_descriptions' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
        ]);

        $slug = Str::slug($validatedData['title']);
        $status = $request->has('status') ? true : false;

        $post = new Post([
            'author' => Auth::user()->id,
            'title' => $validatedData['title'],
            'small_title' => $validatedData['small_title'],
            'description' => $validatedData['description'],
            'tag_id' => json_encode($validatedData['tag_id']),
            'slug' => $slug,
            'meta_title' => $validatedData['meta_title'],
            'meta_descriptions' => $validatedData['meta_descriptions'],
            'meta_keyword' => $validatedData['meta_keyword'],
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
            'title' => 'required|string|max:255',
            'small_title' => 'nullable|string|max:255',
            'image' => 'nullable|image',
            'description' => 'required',
            'tag_id' => 'required|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_descriptions' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
        ]);

        // Find the post by ID
        $post = Post::findOrFail($id);

        // Update post fields
        $post->title = $validatedData['title'];
        $post->small_title = $validatedData['small_title'];
        $post->description = $validatedData['description'];
        $post->tag_id = json_encode($validatedData['tag_id']);
        $post->meta_title = $validatedData['meta_title'];
        $post->meta_descriptions = $validatedData['meta_descriptions'];
        $post->meta_keyword = $validatedData['meta_keyword'];
        $post->status = $request->has('status') ? true : false;

        // Handle the image update
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }

            // Save the new image
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

        if ($post->image && file_exists(public_path($post->image))) {
            unlink(public_path($post->image));
        }
        $post->delete();

        return redirect()->route('admin.post.index')->with('success', 'Post deleted successfully.');
    }
}
