<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'trams' => 'required|boolean',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $contact = Contact::create($request->all());

        return response()->json(['message' => 'Contact form submitted successfully.', 'contact' => $contact], 201);
    }
}
