<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStaticContentRequest;
use App\Http\Requests\UpdateStaticContentRequest;
use App\Models\StaticContent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StaticContentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $staticContent = new StaticContent();
            $staticContent->title = $request->title;
            $staticContent->description = $request->description;
            $staticContent->content = $request->content;
            $staticContent->save();

            return response()->json(['message' => 'Content added successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add content', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $staticContent = StaticContent::findOrFail($id);

            $staticContent->title = $request->title;
            $staticContent->description = $request->description;
            $staticContent->content = $request->content;
            $staticContent->save();

            return response()->json(['message' => 'Content updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update content', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index()
    {
        try {
            $staticContents = StaticContent::all();
            return response()->json($staticContents, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch static content', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getForOneTitle(Request $request)
    {
        try {
            $title = $request->query('title');
            $staticContent = StaticContent::where('title', $title)->first();
            return response()->json($staticContent, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch static content for the given title', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
