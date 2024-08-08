<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth('admin')->user()->hasPermissionTo('service_list'))
            abort(403);
        $services = Service::all();
        return view('admin.services.list', compact('services'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('admin.services.view', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $service->title = $request->title;
        $service->category_id = $request->category;
        $service->description = $request->description;
        $service->duration = $request->duration;
        $service->max_capacity = $request->capacity;
        $service->price = $request->price;
        $service->notice_period = $request->notice_period;

        if ($request->available)
            $service->available = $request->available;
        else
            $service->available = 0;

        if ($request->bookable)
            $service->bookable = $request->bookable;
        else
            $service->bookable = 0;

        if ($request->featured)
            $service->featured = $request->featured;
        else
            $service->featured = 0;

        $service->save();

        return response()->json(['message' => 'service updated successfully'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json(['message' => 'service deleted successfully'], Response::HTTP_OK);
    }

    public function addImages(Request $request)
    {


        $iconPath = null;
        if ($request->hasFile('file')) {
            $photo =  $request->file('file');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $iconPath = $photo->storeAs('photos', $photoName, 'public');
        }
    }
}
