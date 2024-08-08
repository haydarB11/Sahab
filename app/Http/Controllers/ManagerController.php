<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function login(Request $request)
    {
        try {
            $manager = Manager::where('email', $request->email)
                ->where('password', $request->password)
                ->first();

            if ($manager) {
                $token = $manager->createToken('admin-token')->plainTextToken;

                return response()->json(['token' => $token, 'manager' => $manager], 200);
            }

            return response()->json(['message' => 'Manager not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(Request $request)
    {
        try {
            $manager = new Manager();
            $manager->name = $request->name;
            $manager->email = $request->email;
            $manager->password = $request->password;
            $manager->save();

            return response()->json(['message' => 'Manager added successfully', 'manager' => $manager], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $manager = Manager::findOrFail($id);

            if (!$manager) {
                return response()->json(['message' => 'Manager not found'], Response::HTTP_NOT_FOUND);
            }

            $manager->name = $request->name ?? $manager->name;
            $manager->email = $request->email ?? $manager->email;
            $manager->password = $request->password ?? $manager->password;
            $manager->save();

            return response()->json(['message' => 'Manager updated successfully', 'manager' => $manager], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $manager = Manager::findOrFail($id);

            if (!$manager) {
                return response()->json(['message' => 'Manager not found'], Response::HTTP_NOT_FOUND);
            }

            $manager->delete();
            return response()->json(['message' => 'Manager deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function index()
    {
        try {
            $managers = Manager::all();
            return response()->json($managers, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
