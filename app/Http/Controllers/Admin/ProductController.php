<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Debugging: Dump all request data to ensure it is being received correctly
        // dd($request->all());

        $validatedData = $request->validate([
            'name' => 'required',
            'small_description' => 'nullable',
            'description' => 'required',
            'image' => 'nullable',
            'feature_list' => 'nullable|array',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keyword' => 'nullable',
            'status' => 'nullable',
        ]);

        // If validation passes, dump the validated data for further inspection
        // dd($validatedData);

        // Handle the description (if any replacement needed)
        $description = str_replace(['../../..', '../..'], config('app.url'), $request->get('description'));

        $status = $request->has('status') ? true : false;

        $product = new Product([
            'user_id' => Auth::user()->id,
            'name' => $validatedData['name'],
            'small_description' => $validatedData['small_description'],
            'description' => $description, // Use the modified description
            'feature_list' => json_encode($validatedData['feature_list']),
            'meta_title' => $validatedData['meta_title'],
            'meta_description' => $validatedData['meta_description'],
            'meta_keyword' => $validatedData['meta_keyword'],
            'status' => $status,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/product'), $imageName);
            $product->image = 'assets/images/product/' . $imageName;
        }

        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $product->feature_list = json_decode($product->feature_list, true); // Decode JSON to array

        return view('admin.product.edit', compact('product'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'small_description' => 'nullable',
            'description' => 'required',
            'image' => 'nullable',
            'feature_list' => 'nullable|array',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keyword' => 'nullable',
            'status' => 'nullable',
        ]);

        // Handle the description (if any replacement needed)
        $description = str_replace(['../../..', '../..'], config('app.url'), $request->get('description'));

        $product = Product::findOrFail($id);

        $product->name = $validatedData['name'];
        $product->small_description = $validatedData['small_description'];
        $product->description = $description;
        $product->feature_list = json_encode($validatedData['feature_list']);
        $product->meta_title = $validatedData['meta_title'];
        $product->meta_description = $validatedData['meta_description'];
        $product->meta_keyword = $validatedData['meta_keyword'];
        $product->status = $request->has('status') ? true : false;

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if (File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/product'), $imageName);
            $product->image = 'assets/images/product/' . $imageName;
        }

        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete the image file if it exists
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Delete the product
        $product->delete();

        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');
    }
}
