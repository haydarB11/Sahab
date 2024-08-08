<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function store(Request $request)
    {
        try {

            // $request->validate([
            //     'area' => 'required|string|max:255',
            // ]);

            $validator = Validator::make($request->all(), [
                'area' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
            }

            $area = new Area();
            $area->area = $request->area;
            $area->area_ar = $request->area_ar;
            $area->save();

            return response()->json(['message' => 'area added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $area = Area::where('id', $id)->first();

            if (!$area) {
                return response()->json(['message' => 'area not found'], Response::HTTP_NOT_FOUND);
            }

            $area->delete();
            return response()->json(['message' => 'area deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(Request $request)
    {
        try {
            $language = $request->input('language', 'en');
            $titleColumn = $language === 'ar' ? 'area_ar' : 'area';
            $areas = Area::select('id', "$titleColumn As area")->get();
            return response()->json($areas, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
