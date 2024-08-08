<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth('admin')->user()->hasPermissionTo('amenities_list'))
            abort(403);
        $amenities = Amenity::all();

        return view('admin.amenities.list', compact('amenities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $photo =  $request->file('icon');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $iconPath = $photo->storeAs('photos', $photoName, 'public');
        }
        $amenity = new Amenity();
        $amenity->title = $request->title;
        $amenity->title_ar = $request->title_ar;
        $amenity->icon = $iconPath;
        if ($request->status)
            $amenity->status = $request->status;
        else
            $amenity->status = 0;
        $amenity->save();
        return response()->json(['message' => 'amenity added successfully'], Response::HTTP_OK);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateStatus(Request $request, Amenity $amenity)
    {
        $status = $request->query('status');
        $amenity->status = $status;
        $amenity->save();

        return response()->json(['message' => 'amenity status updated successfully'], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Amenity $amenity)
    {
        $amenity->delete();
        return response()->json(['message' => 'amenity deleted successfully'], Response::HTTP_OK);



    }
}
