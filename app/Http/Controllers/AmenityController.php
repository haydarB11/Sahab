<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAmenityRequest;
use App\Http\Requests\UpdateAmenityRequest;
use App\Models\Amenity;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AmenityController extends Controller
{

    public function store(Request $request)
    {
        try {

            $photo = $request->file('icon');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photoPath = '/photos/amenities' . $photoName;
            // $photoPath = public_path('photos/' . $photoName);
            $photo->move(public_path('photos'), $photoName);
            $photoUrl = $photoPath;
            // $photoUrl = asset('photos/' . $photoName);

            $amenity = new Amenity();
            $amenity->title = $request->title;
            $amenity->title_ar = $request->title_ar;
            $amenity->icon = $photoUrl;
            $amenity->save();

            return response()->json(['message' => 'amenity added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $amenity = Amenity::findOrFail($id);

            if (!$amenity) {
                return response()->json(['message' => 'amn$amenity not found'], Response::HTTP_NOT_FOUND);
            }

            $photo = $request->file('icon');
            if ($photo) {
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photoPath = '/photos/amenities' . $photoName;
                $photo->move(public_path('photos'), $photoName);
                $amenity->icon = $photoPath ?? $amenity->icon;
            }

            $amenity->title = $request->title ?? $amenity->title;
            $amenity->title_ar = $request->title_ar ?? $amenity->title_ar;
            $amenity->save();

            return response()->json(['message' => 'Amenity updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $amenity = Amenity::findOrFail($id);

            if (!$amenity) {
                return response()->json(['message' => 'amenity not found'], Response::HTTP_NOT_FOUND);
            }

            $amenity->delete();
            return response()->json(['message' => 'amenity deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $amenity = Amenity::findOrFail($id);

            if (!$amenity) {
                return response()->json(['message' => 'amenity not found'], Response::HTTP_NOT_FOUND);
            }

            return response()->json($amenity, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(Request $request)
    {
        try {
            $language = $request->input('language', 'en');
            $titleColumn = $language === 'ar' ? 'title_ar' : 'title';
            $amenities = Amenity::select('id', "$titleColumn as title", 'icon')->get();
            return response()->json($amenities, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getPlacesForOneAmenity($id)
    {
        try {
            $amenity = Amenity::find($id);

            if (!$amenity) {
                return response()->json(['message' => 'Amenity not found'], Response::HTTP_NOT_FOUND);
            }

            $places = $amenity->places;

            return response()->json($places, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
