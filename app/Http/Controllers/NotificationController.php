<?php

namespace App\Http\Controllers;

use App\Mail\BookingData;
use App\Mail\VendorBookingData;
use App\Notifications\sendEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    /**
     * Send a notification to other users.
     */
    public function sendNotification(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $recipient = User::findOrFail($request->input('user_id'));
        $message = $request->input('message');

        Notification::send($recipient, new sendEmail($message));

        return response()->json(['message' => 'Notification sent successfully']);
    }

    public function sendBookingEmail($user, $booking) {
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['booking_id'] = $booking->id;
        $array['title'] = "";
        if ($booking->service_id) {
            $array['title'] = $booking->service->title;
        } else {
            $array['title'] = $booking->place->title;
        }
        $array['payment'] = $booking->payment;
        $array['starting_date'] = $booking->starting_date;
        $array['ending_date'] = $booking->ending_date;
        Mail::to($user->email)->send(new BookingData($array));
    }

    public function sendBookingEmailForVendor($booking) {
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['booking_id'] = $booking->id;
        $array['title'] = "";
        $user = "";
        if ($booking->service_id) {
            $array['title'] = $booking->service->title;
            $user = $booking->service->vendor;
        } else {
            $array['title'] = $booking->place->title;
            $user = $booking->place->vendor;
        }
        $array['payment'] = $booking->payment;
        $array['starting_date'] = $booking->starting_date;
        $array['ending_date'] = $booking->ending_date;
        $array['name'] = $booking->user->name;
        Mail::to($user->email)->send(new VendorBookingData($array));
    }
}
