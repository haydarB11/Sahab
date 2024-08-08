<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!auth('admin')->user()->hasPermissionTo('place-list'))
          abort(403);

        $places = Place::all();
        return view('admin.places.list', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.places.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {
        return view('admin.places.view', compact('place'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Place $place)
    {

        return view('admin.places.edit', compact('place'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {

        $place->title = $request->title;
        $place->category_id = $request->category;
        $place->address = $request->address;
        $place->description = $request->description;
        $place->weekday_price = $request->weekday_price;
        $place->weekend_price = $request->weekend_price;
        $place->tag = $request->tag;

        if ($request->available)
            $place->available = $request->available;
        else
            $place->available = 0;

        if ($request->bookable)
            $place->bookable = $request->bookable;
        else
            $place->bookable = 0;

        if ($request->featured)
            $place->featured = $request->featured;
        else
            $place->featured = 0;

        $selectedAmenities = $request->input('amenities', []);
        $place->availablePlaceAmenities()->sync($selectedAmenities);

        $place->save();

        return response()->json(['message' => 'place updated successfully'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {

        $place->delete();

        return response()->json(['message' => 'place deleted successfully'], Response::HTTP_OK);
    }
}
