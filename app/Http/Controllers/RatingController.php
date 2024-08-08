<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $userId = Auth::id();

            $booking = Booking::where('user_id', $userId)
                ->where('id', $request->booking_id)
                ->where(function ($query) {
                    $query->whereDate('ending_date', '<', now()->setTimezone('Asia/Kuwait')->toDateString())
                        ->orWhere(function ($query) {
                            $query->where('ending_date', '<', now()->setTimezone('Asia/Kuwait')->toDateTimeString());
                        });
                })
                ->first();

            if (!$booking) {
                return response()->json(['message' => 'You should have a completed booking to rate'], Response::HTTP_NOT_ACCEPTABLE);
            }
            $booking->status = 'completed';
            $existingRating = Rating::where('user_id', $userId)
                ->where('booking_id', $request->booking_id)
                ->first();

            if ($existingRating) {
                return response()->json(['message' => 'You have already rated this place or service'], Response::HTTP_NOT_ACCEPTABLE);
            }

            $rating = new Rating();
            $rating->rate = $request->rate;
            $rating->user_id = $userId;
            $rating->booking_id = $request->booking_id;

            $rating->save();

            return response()->json(['message' => 'Rated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateRatingRequest $request, $id)
    {
        try {
            $rating = Rating::findOrFail($id);

            $rating->rate = $request->rate ?? $rating->rate;
            $rating->user_id = $request->user_id ?? $rating->user_id;
            $rating->place_id = $request->place_id ?? $rating->place_id;
            $rating->service_id = $request->service_id ?? $rating->service_id;
            $rating->save();

            return response()->json(['message' => 'Rating updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $rating = Rating::findOrFail($id);
            $rating->delete();
            return response()->json(['message' => 'Rating deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        try {
            $rating = Rating::findOrFail($id);
            return response()->json($rating, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function index()
    {
        try {
            $ratings = Rating::all();
            return response()->json($ratings, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
