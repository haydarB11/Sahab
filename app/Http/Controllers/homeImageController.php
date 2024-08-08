<?php

namespace App\Http\Controllers;

use App\Models\HomeImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class HomeImageController extends Controller
{
    public function store(Request $request)
    {
        try {
            // $userId = Auth::id();

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $photo) {
                    $photoName = time() . '_' . $photo->getClientOriginalName();
                    $photoPath = $photo->storeAs('public/photos', $photoName);
                    $photoUrl = Storage::url($photoPath);
                    $homeImage = new HomeImage();
                    $homeImage->image = $photoUrl;
                    $homeImage->save();
                }
            }

            return response()->json(['message' => 'Images added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $deletedImages = HomeImage::whereIn('id', $request->ids)->delete();
            if ($deletedImages > 0) {
                return response()->json(['message' => 'Images deleted successfully'], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Images not found'], Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function index()
    {
        try {
            $images = HomeImage::where('status',1)->get();
            return response()->json($images, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
