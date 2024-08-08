<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth('admin')->user()->hasPermissionTo('admins_list'))
            abort(403);
        $admins = Manager::where('id', '!=', Auth::guard('admin')->user()->id)->get();
        $roles = Role::all();

        return view('admin.admins.list', compact('admins', 'roles'));
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

        DB::beginTransaction();
        $admin = Manager::create([
            'name' => $request->user_name,
            'email' => $request->user_email,
            'password' => bcrypt($request->password),
        ]);
        $role = Role::where('id', $request->user_role)->pluck('id');

        $admin->assignRole($role);

        DB::commit();
        return response()->json(['message' => 'Admin created successfully'], Response::HTTP_OK);
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
    public function update(Request $request, Manager $admin)
    {
        DB::beginTransaction();
        $admin->update([
            'name' => $request->user_name,
            'email' => $request->user_email,
        ]);
        $role = Role::where('id', $request->user_role)->pluck('id');

        $admin->roles()->detach();

        $admin->assignRole($role);

        DB::commit();
        return response()->json(['message' => 'Admin updated successfully'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manager $admin)
    {

        //$admin->roles()->detach();
        $admin->delete();

        return response()->json(['message' => 'admin deleted successfully'], Response::HTTP_OK);
    }
}
