<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class SettingController extends Controller
{

    
    public function index()
    {
        $setting = Setting::first();

        return view('admin.settings.index', compact('setting'));
    }
   


    public function create()
    {
        return view('admin.settings.create');
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'home_video' => 'nullable|string',
            'right_image' => 'nullable|string',
            'left_image' => 'nullable|string',
            'banner_title_a' => 'required|string',
            'banner_title_b' => 'required|string',
            'banner_description' => 'required|string',
        ]);

        Setting::create($request->all());

        return redirect()->route('admin.settings.index')->with('success', 'Setting created successfully.');
    }


    public function edit(Setting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }


    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        $request->validate([
            'banner_title_a' => 'required|string|max:255',
            'banner_title_b' => 'required|string|max:255',
            'home_video' => 'nullable|string',
            'banner_description' => 'nullable|string',
            'right_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'left_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $setting->banner_title_a = $request->input('banner_title_a');
        $setting->banner_title_b = $request->input('banner_title_b');
        $setting->home_video = $request->input('home_video');
        $setting->banner_description = $request->input('banner_description');

        if ($request->hasFile('right_image')) {
            // Delete old right image if it exists
            if (File::exists(public_path($setting->right_image))) {
                File::delete(public_path($setting->right_image));
            }

            // Upload new right image
            $rightImage = $request->file('right_image');
            $rightImageName = time() . '_right_' . $rightImage->getClientOriginalName();
            $rightImage->move(public_path('uploads'), $rightImageName);
            $setting->right_image = 'uploads/' . $rightImageName;
        }

        if ($request->hasFile('left_image')) {
            // Delete old left image if it exists
            if (File::exists(public_path($setting->left_image))) {
                File::delete(public_path($setting->left_image));
            }

            // Upload new left image
            $leftImage = $request->file('left_image');
            $leftImageName = time() . '_left_' . $leftImage->getClientOriginalName();
            $leftImage->move(public_path('uploads'), $leftImageName);
            $setting->left_image = 'uploads/' . $leftImageName;
        }

        $setting->save();

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully');
    }

   
}