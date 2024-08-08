<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePromoCodeRequest;
use App\Http\Requests\UpdatePromoCodeRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\PromoCode;

class PromoCodeController extends Controller
{
    public function store(Request $request)
    {
        try {
            $promoCode = new PromoCode();
            $promoCode->discount = $request->discount;
            $promoCode->save();
            return response()->json(['message' => 'Promo code added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function storeMany(Request $request)
    {
        try {
            $promoCodesToInsert = [];
            for ($i = 0; $i < $request->number; $i++) {
                $promoCodesToInsert[] = ['discount' => $request->discount];
            }
            PromoCode::insert($promoCodesToInsert);
            return response()->json(['message' => 'Promo codes added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $promoCode = PromoCode::findOrFail($id);
            $promoCode->discount = $request->discount ?? $promoCode->discount;
            $promoCode->is_active = $request->is_active ?? $promoCode->is_active;
            $promoCode->save();
            return response()->json(['message' => 'Promo code updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function apply(Request $request)
    {
        try {
            $promoCode = PromoCode::where('code', $request->code)->first();
            if (!$promoCode) {
                return response()->json(['message' => 'Promo code not found'], Response::HTTP_NOT_FOUND);
            } else if (!$promoCode->is_active){
                return response()->json(['message' => 'promo code is not active'], Response::HTTP_BAD_REQUEST);
            }
            return response()->json(['message' => $promoCode], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $promoCode = PromoCode::findOrFail($id);
            $promoCode->delete();
            return response()->json(['message' => 'Promo code deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        try {
            $promoCode = PromoCode::findOrFail($id);
            return response()->json($promoCode, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function index()
    {
        try {
            $promoCodes = PromoCode::all();
            return response()->json($promoCodes, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
