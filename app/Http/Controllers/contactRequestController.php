<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class contactRequestController extends Controller
{
    public function store(Request $request)
    {
        try {
            $userId = Auth::id();
            
            $contactForm = new ContactRequest();
            $contactForm->name = $request->input('name');
            $contactForm->phone = $request->input('phone');
            $contactForm->email = $request->input('email');
            $contactForm->message = $request->input('message');
            $contactForm->user_id = $userId;
            $contactForm->save();

            return response()->json(['message' => 'request created successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating user', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
