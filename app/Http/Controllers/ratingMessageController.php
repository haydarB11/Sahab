<?php

namespace App\Http\Controllers;

use App\Models\RatingMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RatingMessageController extends Controller
{
    public function store(Request $request)
    {
        try {
            $ratingMessage = new RatingMessage();
            $ratingMessage->message = $request->message;
            $ratingMessage->save();
            return response()->json(['message' => 'Message added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $ratingMessage = RatingMessage::findOrFail($id);
            $ratingMessage->message = $request->message ?? $ratingMessage->message;
            $ratingMessage->save();
            return response()->json(['message' => 'Message updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $ratingMessage = RatingMessage::findOrFail($id);
            $ratingMessage->delete();
            return response()->json(['message' => 'Message deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function index()
    {
        try {
            $ratings = RatingMessage::all();
            return response()->json($ratings, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
