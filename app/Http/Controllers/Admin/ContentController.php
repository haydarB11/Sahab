<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeImage;
use App\Models\StaticContent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContentController extends Controller
{
    public function index()
    {
        if (!auth('admin')->user()->hasPermissionTo('banners_manage'))
            abort(403);

        $images = HomeImage::all();
        return view('admin.content.banners', compact('images'));
    }
    public function create()
    {
        $content = StaticContent::all();
        return view('admin.content.all', compact('content'));
    }

    public function updateAll(Request $request)
    {

        $contentTitles = StaticContent::pluck('title')->toArray();

        foreach ($contentTitles as $title) {
            // Update content if the request contains the title
            if ($request->has($title)) {
                StaticContent::where('title', $title)->update(['content' => $request->input($title)]);
            }
        }
        return response()->json(['message' => 'content updated successfully'], Response::HTTP_OK);
    }
    public function store(Request $request)
    {

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $photo =  $request->file('icon');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $iconPath = $photo->storeAs('photos', $photoName, 'public');
        }

        $image = new HomeImage();
        $image->image = $iconPath;
        $image->save();
        return response()->json(['message' => 'banner created successfully'], Response::HTTP_OK);
    }
    public function updateStatus(Request $request, HomeImage $image, $status)
    {
        $image->status = $status;
        $image->save();
        return response()->json(['success' => 'status updated successfully']);
    }
    public function destroy(HomeImage $static_content)
    {
        $static_content->delete();

        return response()->json(['message' => 'banner deleted successfully'], Response::HTTP_OK);
    }
}
