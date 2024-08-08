<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        try {
            // $request->validate([
            //     'title' => 'required|string',
            //     'type' => 'required|string',
            //     'icon' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            // ]);

            $photo = $request->file('icon');

            // $photoName = time() . '_' . $photo->getClientOriginalName();
            // // $request->icon->move(public_path('images'), $photoName);
            // $photoPath = $photo->storeAs('public/photos', $photoName);
            // $photoUrl = Storage::url($photoPath);

            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photoPath = '/photos/categories/' . $photoName;
            $photo->move(public_path('photos/categories'), $photoName);
            $photoUrl = $photoPath;

            $category = new Category();
            $category->icon = $photoUrl;
            $category->title = $request->title;
            $category->title_ar = $request->title_ar;
            $category->type = $request->type;
            $category->save();

            return response()->json(['message' => 'Category added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            if (!$category) {
                return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
            }

            $photo = $request->file('icon');

            if ($photo) {
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photoPath = '/photos/categories/' . $photoName;
                $photo->move(public_path('photos/categories'), $photoName);
                $category->icon = $photoPath;
            }

            $category->title = $request->title ?? $category->title;
            $category->title_ar = $request->title_ar ?? $category->title_ar;
            $category->type = $request->type ?? $category->type;
            $category->save();
            return response()->json(['message' => 'Category updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

        public function destroy($id)
        {
            try {
                $category = Category::findOrFail($id);

                if (!$category) {
                    return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
                }

                if (!empty($category->icon)) {
                    $filePath = public_path($category->icon);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                $category->delete();
                return response()->json(['message' => 'Category deleted successfully'], Response::HTTP_OK);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
            }
        }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);

            if (!$category) {
                return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
            }

            return response()->json($category, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function index(Request $request)
    {
        try {

            $language = $request->input('language', 'en');
            $titleColumn = $language == 'ar' ? 'title_ar' : 'title';

            $categories = Category::select('id', "$titleColumn AS title", 'icon', 'type')->get();
            return response()->json($categories, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAllDependingOnType(Request $request)
    {
        try {

            $language = $request->input('language', 'en');
            $titleColumn = $language == 'ar' ? 'title_ar' : 'title';

            $type = $request->query('type');
            $categories = Category::where('type', $type)->select('id', "$titleColumn AS title", 'icon', 'type')->get();
            return response()->json($categories, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getPlacesForOneCategory($id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
            }

            $places = $category->places;

            return response()->json($places, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getServicesForOneCategory($id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
            }

            $services = $category->services;

            return response()->json($services, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
