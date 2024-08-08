<?php

namespace App\Http\Controllers;

use App\Models\ServiceImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ServiceImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'service_id' => 'required|exists:services,id',
        ]);

        $serviceImage = new ServiceImage();

        $photo = $request->file('image');
        $photoName = time() . '_' . $photo->getClientOriginalName();
        $photoPath = $photo->storeAs('public/photos', $photoName);
        $photoUrl = Storage::url($photoPath);

        $serviceImage->service_id = $request->service_id;
        $serviceImage->image = $photoUrl;

        $serviceImage->save();

        return response()->json(['message' => 'Image added successfully'], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $serviceImage = ServiceImage::findOrFail($id);

        if (!$serviceImage) {
            return response()->json(['message' => 'Image not found'], Response::HTTP_NOT_FOUND);
        }

        $photo = $request->file('image');
        if ($photo) {
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photoPath = $photo->storeAs('public/photos', $photoName);
            $photoUrl = Storage::url($photoPath);
            $serviceImage->image = $photoUrl;
        }

        $serviceImage->save();

        return response()->json(['message' => 'Image updated successfully'], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $serviceImage = ServiceImage::findOrFail($id);

        if (!$serviceImage) {
            return response()->json(['message' => 'Image not found'], Response::HTTP_NOT_FOUND);
        }

        $serviceImage->delete();
        return response()->json(['message' => 'Image deleted successfully'], Response::HTTP_OK);
    }

    public function deleteMany(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:service_images,id',
        ]);

        ServiceImage::whereIn('id', $request->ids)->delete();

        return response()->json(['message' => 'Images deleted successfully'], Response::HTTP_OK);
    }

    public function getAllForOneService($id)
    {
        $serviceImages = ServiceImage::where('service_id', $id)->get();
        return response()->json($serviceImages, Response::HTTP_OK);
    }
}
