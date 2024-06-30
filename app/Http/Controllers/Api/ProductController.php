<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{




    public function getAllProducts()
    {
        $products = Product::all();
        return response()->json($products);
    }



    public function getProductId($id)
    {
        $product = Product::where('id', $id)->first();

        if (!$product) {
            return response()->json(['message' => 'product not found'], 404);
        }
        $blogKey = 'product' . $product->id;
        if (!Session::has($blogKey)) {
            $product->increment('view_count');
            Session::put($blogKey, 1);
        }

        return response()->json($product);
    }
}
