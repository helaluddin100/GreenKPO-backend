<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
class SettingController extends Controller
{
    
    public function index()
    {
        $settings = Setting::first(); // Assuming you have only one row of settings
        return response()->json(['settings' => $settings]);
    }

    
}