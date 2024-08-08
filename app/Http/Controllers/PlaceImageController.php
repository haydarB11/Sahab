<?php

namespace App\Http\Controllers;

use App\Models\PlaceImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PlaceImageController extends Controller
{
    public function store(Request $request)
    {
        try {
            $placeImage = new PlaceImage();

            $photo = $request->file('image');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photoPath = $photo->storeAs('public/photos', $photoName);
            $photoUrl = Storage::url($photoPath);

            $placeImage->place_id = $request->place_id;
            $placeImage->image = $photoUrl;

            $placeImage->save();

            return response()->json(['message' => 'Image added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $placeImage = PlaceImage::findOrFail($id);

            if (!$placeImage) {
                return response()->json(['message' => 'Image not found'], Response::HTTP_NOT_FOUND);
            }

            $photo = $request->file('image');
            if ($photo) {
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photoPath = $photo->storeAs('public/photos', $photoName);
                $photoUrl = Storage::url($photoPath);
                $placeImage->image = $photoUrl;
            }

            $placeImage->title = $request->title ?? $placeImage->title;
            $placeImage->address = $request->address ?? $placeImage->address;

            $placeImage->save();

            return response()->json(['message' => 'Image updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $placeImage = PlaceImage::findOrFail($id);

            if (!$placeImage) {
                return response()->json(['message' => 'Image not found'], Response::HTTP_NOT_FOUND);
            }

            $placeImage->delete();
            return response()->json(['message' => 'Image deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteMany(Request $request)
    {
        try {
            $deletedImages = PlaceImage::whereIn('id', $request->ids)->delete();

            return response()->json(['message' => 'Images deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAllForOnePlace($id)
    {
        try {
            $placeImages = PlaceImage::where('place_id', $id)->get();
            return response()->json($placeImages, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
