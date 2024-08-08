<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth('admin')->user()->hasPermissionTo('categories_list'))
            abort(403);

        $categories = Category::where('type',request('type'))->get();
        return view( 'admin.categories.list',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.categories.add');
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

        $category = new Category();
        $category->title = $request->title;
        $category->title_ar = $request->title_ar;
        $category->type = $request->type;
        $category->icon = $iconPath;
        $category->save();
        return response()->json(['message' => 'category created successfully'], Response::HTTP_OK);

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
    public function edit(Category $category)
    {
        return view('admin.categories.edit',compact('category'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        $iconPath = $category->icon;
        if ($request->hasFile('icon')) {
            $photo =  $request->file('icon');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $iconPath = $photo->storeAs('photos', $photoName, 'public');
        }

        $category->title = $request->title;
        $category->title_ar = $request->title_ar;
        $category->icon = $iconPath;
        $category->save();

        return response()->json(['message' => 'category updated successfully'], Response::HTTP_OK);

    }

    public function updateStatus(Request $request, Category $category)
    {
        $status = $request->query('status');
        $category->status = $status;
        $category->save();

        return response()->json(['message' => 'category status updated successfully'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'category deleted successfully'], Response::HTTP_OK);



    }
}
