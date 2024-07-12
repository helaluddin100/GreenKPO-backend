<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Product;
use App\Models\Contact;
use Carbon\Carbon;
class DashboardController extends Controller
{
    

    public function index()
    {
        // Get today's date and yesterday's date
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
    
        // Count new posts created today
        $newPost = Post::whereDate('created_at', $today)->count();
    
        // Count total posts
        $totalPost = Post::count();
    
        // Count new products created today
        $newProduct = Product::whereDate('created_at', $today)->count();
    
        // Count total products
        $totalProduct = Product::count();
    
        // Sum of view counts for all posts
        $totalPostView = Post::sum('view_count');

        $latestContacts = Contact::where('status', 0)
        ->latest()
        ->take(5)
        ->get();
       

        $latestPosts = Post::where('status', 1)
        ->latest()
        ->take(5)
        ->get();
       
        // Return view with compacted data
        return view('dashboard', compact('totalPost', 'newPost', 'newProduct', 'totalProduct', 'totalPostView','latestContacts','latestPosts'));
    }
    

}