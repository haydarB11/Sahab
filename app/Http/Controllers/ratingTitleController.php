<?php

namespace App\Http\Controllers;

use App\Models\RatingTitle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RatingTitleController extends Controller
{
    public function store(Request $request)
    {
        try {
            $ratingTitle = new RatingTitle();
            $ratingTitle->title = $request->title;
            $ratingTitle->save();
            return response()->json(['message' => 'Rating title added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $ratingTitle = RatingTitle::findOrFail($id);
            $ratingTitle->title = $request->title ?? $ratingTitle->title;
            $ratingTitle->save();
            return response()->json(['message' => 'Rating title updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $ratingTitle = RatingTitle::findOrFail($id);
            $ratingTitle->delete();
            return response()->json(['message' => 'Rating title deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function index()
    {
        try {
            $ratings = RatingTitle::all();
            return response()->json($ratings, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
