<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
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
        $sliders = Slider::all();
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
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
        'small_title' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $status = $request->has('status') ? true : false;

    $slider = new Slider([
        'title' => $validatedData['title'],
        'small_title' => $validatedData['small_title'],
        'status' => $status,
    ]);

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('assets/images/slider'), $imageName);
        $slider->image = 'assets/images/slider/' . $imageName;
    }

    if ($request->hasFile('mobile_image')) {
        $mobile_image = $request->file('mobile_image');
        $mobileImageName = time() . '_' . $mobile_image->getClientOriginalName();
        $mobile_image->move(public_path('assets/images/slider'), $mobileImageName);
        $slider->mobile_image = 'assets/images/slider/' . $mobileImageName;
    }

    $slider->save();

    return redirect()->route('admin.slider.index')->with('success', 'Slider created successfully.');
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    // Retrieve the existing slider using the given ID
    $slider = Slider::findOrFail($id);

    // Pass the slider data to the edit view
    return view('admin.slider.edit', compact('slider'));
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'small_title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $status = $request->has('status') ? true : false;
    
        $slider = Slider::findOrFail($id);
        $slider->title = $validatedData['title'];
        $slider->small_title = $validatedData['small_title'];
        $slider->status = $status;
    
        if ($request->hasFile('image')) {
            // Remove old image
            if ($slider->image) {
                unlink(public_path($slider->image));
            }
    
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/slider'), $imageName);
            $slider->image = 'assets/images/slider/' . $imageName;
        }
    
        if ($request->hasFile('mobile_image')) {
            // Remove old mobile image
            if ($slider->mobile_image) {
                unlink(public_path($slider->mobile_image));
            }
    
            $mobile_image = $request->file('mobile_image');
            $mobileImageName = time() . '_' . $mobile_image->getClientOriginalName();
            $mobile_image->move(public_path('assets/images/slider'), $mobileImageName);
            $slider->mobile_image = 'assets/images/slider/' . $mobileImageName;
        }
    
        $slider->save();
    
        return redirect()->route('admin.slider.index')->with('success', 'Slider updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Retrieve the existing slider using the given ID
        $slider = Slider::findOrFail($id);
    
        // Delete the associated image files if they exist
        if ($slider->image && file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }
    
        if ($slider->mobile_image && file_exists(public_path($slider->mobile_image))) {
            unlink(public_path($slider->mobile_image));
        }
    
        // Delete the slider record from the database
        $slider->delete();
    
        // Redirect to the slider index route with a success message
        return redirect()->route('admin.slider.index')->with('success', 'Slider deleted successfully.');
    }
    
}
