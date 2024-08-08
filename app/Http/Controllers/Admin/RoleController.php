<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth('admin')->user()->hasPermissionTo('role-list'))
            abort(403);
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.admins.roles', compact('roles', 'permissions'));
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
        $request->validate([
            'role_name' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->role_name, 'guard_name' => 'admin']);
        $permissions = Permission::whereIn('id', $request->permissions)->pluck('id')->toArray();
        $role->syncPermissions($permissions);

        return response()->json(['message' => 'role created successfully'], Response::HTTP_OK);
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
    public function update(Request $request, Role  $role)
    {
        $request->validate([
            'role_name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->name = $request->role_name;
        $permissions = Permission::whereIn('id', $request->permissions)->pluck('id')->toArray();
        $role->syncPermissions($permissions);

        $role->save();
        return response()->json(['message' => 'role updated successfully'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
