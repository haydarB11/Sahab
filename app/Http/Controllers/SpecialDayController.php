<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSpecialDayRequest;
use App\Http\Requests\UpdateSpecialDayRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\SpecialDay;

class SpecialDayController extends Controller
{

    public function store(Request $request)
    {
        try {
            $specialDay = SpecialDay::create([
                'title' => $request->title,
                'price' => $request->price,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'place_id' => $request->place_id,
            ]);

            return response()->json(['message' => 'Special day added successfully', 'data' => $specialDay], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create special day', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $specialDay = SpecialDay::findOrFail($id);

            $specialDay->update([
                'title' => $request->title,
                'price' => $request->price,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'place_id' => $request->place_id,
            ]);

            return response()->json(['message' => 'Special day updated successfully', 'data' => $specialDay], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update special day', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $specialDay = SpecialDay::findOrFail($id);
            $specialDay->delete();
            return response()->json(['message' => 'Special day deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete special day', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $specialDay = SpecialDay::findOrFail($id);
            return response()->json(['data' => $specialDay], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Special day not found', 'message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function index()
    {
        try {
            $specialDays = SpecialDay::all();
            return response()->json(['data' => $specialDays], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch special days', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
