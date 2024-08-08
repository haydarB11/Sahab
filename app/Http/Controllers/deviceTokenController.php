<?php

namespace App\Http\Controllers;

use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class deviceTokenController extends Controller
{
    public function store(Request $request)
    {
        try {
            $token = new DeviceToken();
            $token->user_id = $request->user_id;
            $token->token = $request->token;
            $token->save();

            return response()->json(['message' => 'token added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        try {
            $token = DeviceToken::where('token', $request->token)->first();

            $token->is_allowed = $request->is_allowed;

            $token->save();

            return response()->json(['message' => 'token updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update token', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $token = DeviceToken::where('token', $request->token)->first();

            if (!$token) {
                return response()->json(['message' => 'token not found'], Response::HTTP_NOT_FOUND);
            }

            $token->delete();
            return response()->json(['message' => 'token deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
