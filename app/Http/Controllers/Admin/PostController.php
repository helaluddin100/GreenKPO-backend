<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Auth;
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
        $uploadedFile = $request->file('file'); // 'file' is the name attribute in the FormData sent by TinyMCE
        $filename = $uploadedFile->getClientOriginalName(); // Get the original file name
        $path = $uploadedFile->storeAs('public/uploads', $filename); // Store the file in storage/app/public/uploads folder

        // Generate URL for the uploaded file
        $url = asset('storage/uploads/' . $filename);

        return response()->json(['location' => $url]); // Respond with the location URL
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

        return view('admin.post.edit', compact('post','tags'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'author' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'small_title' => 'nullable|string|max:255',
            'image' => 'required|string',
            'description' => 'required',
            'tag_id' => 'nullable|json',
            'slug' => 'required|string|unique:posts,slug,' . $id,
            'meta_title' => 'nullable|string|max:255',
            'meta_descriptions' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'view_count' => 'nullable|string|max:255',
            'status' => 'boolean',
        ]);

        $post = Post::findOrFail($id);
        $post->author = $request->get('author');
        $post->title = $request->get('title');
        $post->small_title = $request->get('small_title');
        $post->image = $request->get('image');
        $post->description = $request->get('description');
        $post->tag_id = $request->get('tag_id');
        $post->slug = Str::slug($request->get('slug'));
        $post->meta_title = $request->get('meta_title');
        $post->meta_descriptions = $request->get('meta_descriptions');
        $post->meta_keyword = $request->get('meta_keyword');
        $post->view_count = $request->get('view_count');
        $post->status = $request->get('status', true);

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}