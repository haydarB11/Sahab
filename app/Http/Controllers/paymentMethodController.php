<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class paymentMethodController extends Controller
{
    public function store(Request $request)
    {
        try {

            $photo = $request->file('photo');

            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photoPath = $photo->storeAs('public/payment-methods', $photoName);
            $photoUrl = Storage::url($photoPath);

            $paymentMethod = new PaymentMethod();
            $paymentMethod->photo = $photoUrl;
            $paymentMethod->payment_method = $request->payment_method;
            $paymentMethod->payment_method_id = $request->payment_method_id;
            $paymentMethod->service_charge = $request->service_charge;
            $paymentMethod->save();

            return response()->json(['message' => 'payment method added successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $payment = PaymentMethod::findOrFail($id);

            if (!$payment) {
                return response()->json(['message' => 'payment not found'], Response::HTTP_NOT_FOUND);
            }

            $payment->delete();
            return response()->json(['message' => 'payment deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function index()
    {
        try {
            $paymentMethods = PaymentMethod::all();
            return response()->json($paymentMethods, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
