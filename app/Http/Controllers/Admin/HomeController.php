<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\DeviceToken;
use App\Models\Place;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {

        $today = Carbon::today();
        $total = Booking::all()->count();
        $totalMonthly = Booking::sum('payment');
        $totalToday = Booking::whereDate('created_at', $today)->count();
        $totalDay = Booking::whereDate('created_at', $today)->sum('payment');
        $priceServices = Booking::where('place_id', '=', null)->sum('payment');
        $pricePlaces = Booking::where('service_id', '=', null)->sum('payment');
        $totalUsers = User::count();
        $totalPlaces = Place::count();
        $totalServices = Service::count();
        $lastUsers = User::orderByDesc('created_at')->take(5)->get();
        $totalPlaced = Booking::where('status', 'placed')->count();
        $totalCanceled = Booking::where('status', 'canceled')->count();

        //** charts data **//
        // chart widget 20 data
        $now = Carbon::now();
        $endDateTime =  new \DateTime($now);
        $end = $endDateTime->format('Y-m-d');
        $last30Days = $now->subDays(30);
        $start = $last30Days->format('Y-m-d');
        $request = request()->merge([
            'start' => $start,
            'end' => $end
        ]);
        $response = $this->updateWidget20($request);
        $content = $response->getContent(); // Get the JSON content from the JsonResponse object
        $data = json_decode($content, true);
        $days_20 = $data['data'];
        $sums_20 = $data['bookings'];
        $total_sums_20 = $data['total_sums'];

        // chart widget 38
        $request_1 = request()->merge([
            'start' => $start,
            'end' => $end,
        ]);
        $response_1 = $this->updateWidget38($request_1);
        $content_1 = $response_1->getContent(); // Get the JSON content from the JsonResponse object
        $data_1 = json_decode($content_1, true);
        $data_38 = $data_1['data'];
        $sums_38 = $data_1['bookings'];

        return view('admin.home', compact('pricePlaces', 'priceServices', 'total', 'totalToday', 'totalUsers', 'lastUsers',
            'totalPlaces', 'totalServices', 'totalDay', 'totalMonthly', 'totalPlaced', 'totalCanceled','days_20', 'sums_20', 'total_sums_20','data_38', 'sums_38'));
    }

    public function profile()
    {

        return view('admin.profile.edit');
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::guard('admin')->user();

        if (Hash::check($request->old_pass,$user->password)) {

            $user->email = $request->email;
            if (!empty($request->new_pass)) {
                $user->password = bcrypt($request->new_pass);
            }
            $user->save();

            return response()->json(['message' => 'profile updated successfully'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'old password is not correct'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateToken(Request $request)
    {
        try {
            Auth::guard('admin')->user()->update(['fcm_token' => $request->token]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function getAllNotification(Request $request)
    {
        try {
            $user =  Auth::guard('admin')->user();

            $result = DB::table('notifications')->where('notifiable_id', $user->id)->orderByDesc('created_at')->take(5)->get();
            return response()->json([
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    // widgets data
    // update widget 20
    public function updateWidget20(Request $request) {
        $start = $request->input('start');
        $end = $request->input('end');

        $startDateTime = new \DateTime($start);
        $endDateTime = new \DateTime($end);

        $startDay = $startDateTime->format('j'); // Extract start day
        $endDay = $endDateTime->format('j'); // Extract end day

        $startMonth = $startDateTime->format('n'); // Extract the month (1-12) from the start date
        $startYear = $startDateTime->format('Y'); // Extract the year from the start date

        $endMonth = $endDateTime->format('n'); // Extract the month (1-12) from the start date
        $endYear = $endDateTime->format('Y'); // Extract the year from the start date

        // return hours if start day = end day
        if($start == $end){
            $bookings = Booking::where('status', '!=', 'canceled')
                ->whereDate('created_at', $start)
                ->select(DB::raw("DATE_FORMAT(created_at, '%H') as formatted_date"), DB::raw('SUM(payment) as sum_amount'))
                ->groupBy('formatted_date')
                ->get();

            $startDate = new \DateTime("$startYear-$startMonth-$startDay 00:00:00");
            $endDate = new \DateTime("$endYear-$endMonth-$endDay 23:59:59");
            $interval = new \DateInterval('PT1H');
            $period = new \DatePeriod($startDate, $interval, $endDate);

            $allHours = [];
            $total_sums = 0;
            foreach ($period as $date) {
                $allHours[] = $date->format('H');
            }
            // Iterate over all hours in the day and populate the $hours and $sums arrays
            foreach ($allHours as $hour) {
                $hourFound = false;
                foreach ($bookings as $booking) {
                    if ($booking->formatted_date === $hour) {
                        $hours[] = $booking->formatted_date;
                        $sums[] = $booking->sum_amount;
                        $total_sums += $booking->sum_amount;
                        $hourFound = true;
                        break;
                    }
                }
                if (!$hourFound) {
                    $hours[] = $hour;
                    $sums[] = 0;
                }
            }
            $hours[] = "";
            return response()->json([
                'bookings' => $sums,
                'data' => $hours,
                'total_sums' => $total_sums
            ]);
        }

        $bookings = Booking::where('status', '!=', 'canceled')
            ->whereBetween('created_at', [$start, $end])
            ->select(DB::raw("DATE_FORMAT(created_at, '%b %e') as formatted_date"), DB::raw('SUM(payment) as sum_amount'))
            ->groupBy('formatted_date')
            ->get();

        $startDate = new \DateTime("$startYear-$startMonth-$startDay");
        $endDate = new \DateTime("$endYear-$endMonth-$endDay");

        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($startDate, $interval, $endDate);

        $days = [];
        $sums = [];

        $days[] = "";
        $allDays = [];
        $total_sums = 0;
        foreach ($period as $date) {
            $allDays[] = $date->format('M j');
        }

        // Iterate over all days in the month and populate the $days and $sums arrays
        foreach ($allDays as $day) {
            $dayFound = false;
            foreach ($bookings as $booking) {
                if ($booking->formatted_date === $day) {
                    $days[] = $booking->formatted_date;
                    $sums[] = $booking->sum_amount;
                    $total_sums += $booking->sum_amount;
                    $dayFound = true;
                    break;
                }
            }
            if (!$dayFound) {
                $days[] = $day;
                $sums[] = 0;
            }
        }
        $days[] = "";

        return response()->json([
            'bookings' => $sums,
            'data' => $days,
            'total_sums' => $total_sums
        ]);
    }

    // update widget 38
    public function updateWidget38(Request $request) {
        $start = $request->input('start');
        $end = $request->input('end');

        if($start == $end){
            $services = Service::with(['bookings' => function ($query) use ($start){
                    $query->whereDate('created_at', $start)->where('status', '!=', 'canceled');
            }])->get();
        } else {
            $services = Service::with(['bookings' => function ($query) use ($start, $end) {
                    $query->whereBetween('created_at', [$start, $end])->where('status', '!=', 'canceled');
            }])->get();
        }
        $names = [];
        $sums = [];

        foreach ($services as $service) {
            $names[] = $service->title;
            $total = 0;
            foreach ($service->bookings as $booking) {
                $total += $booking->sum('payment');
            }
            $sums[] = round($total, 2);
        }
        return response()->json([
            'bookings' => $sums,
            'data' => $names,
        ]);
    }

    // display notifications view
    public function notifications(){
        return view('admin.settings.notifications');
    }

    // push notification
    public function pushNotification(Request $request) {
        $title = $request->title;
        $body = $request->body;
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAA0FMLOcg:APA91bE3ZnLsY5JQPTx9qDghvzR8GjzlRbZazhDhO_AQiJvVZNjBRi5tpgBodyJ0L7YVFkY6Io3oyAmnZPHwq04Dj9KsiIKwv6r-xlv_k_ReP9hI3ygdL7h_gT7WQ0ezW_FLL19Iu1DS';
        $tokens = DeviceToken::where('is_allowed', 1)->pluck('token')->toArray();

        $data =  [
            "registration_ids" => $tokens,
            "notification"=>[
                "title" => $title,
                "body" => htmlspecialchars(trim(strip_tags($body))),
                "sound" => "default"
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        curl_close($ch);
        return response()->json([
            'status' => 200,
            'message' => 'notification sent'
        ]);
    }
}
