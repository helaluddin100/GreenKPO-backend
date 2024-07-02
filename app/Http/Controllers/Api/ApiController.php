<?php

namespace App\Http\Controllers\Api;

use App\Models\Faq;


use App\Models\Slider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{


    public function slider()
    {
        $slider = Slider::where('status', 1)->get();
        return response()->json($slider);
    }


    public function carbon_faq()
    {
        $faqs = Faq::where('category', 'Carbon Democratisation')->get();
        return response()->json($faqs);
    }



    public function considerGreenKpo()
    {
        $faqs = Faq::where('category', 'Why should I consider Green KPO?')->get();
        return response()->json($faqs);
    }


    public function faqProduct()
    {
        $faqs = Faq::where('category', 'Product')->get();
        return response()->json($faqs);
    }
}
