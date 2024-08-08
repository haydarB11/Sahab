<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Place;
use App\Models\PromoCode;
use App\Models\Rating;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {

        try {

            $userId = Auth::id();

            $promoCodeId = PromoCode::where('code', $request->code)->value('id');
            $booking = new Booking();
            // $booking->payment_method = $request->payment_method;
            $booking->payment_method_id = $request->payment_method_id;
            $booking->total_price = $request->total_price;
            $booking->payment = $request->payment; // un comment
            $booking->place_id = $request->place_id;
            $booking->service_id = $request->service_id;
            $booking->promo_code_id = $promoCodeId;
            $booking->user_id = $userId;
            if ($request->service_id) {
                $availableTimeSlots = $this->showAvailableTimeSlotsHB($request->service_id);
                if ($this->checkTimeForBookingService($availableTimeSlots[$request->date], $request->starting_time)) {
                    return response()->json(['message' => 'there is reservation in this time'], Response::HTTP_BAD_REQUEST);
                }
                $booking->starting_date = Carbon::parse($request->date . ' ' . $request->starting_time)->toDateTimeString();
                $booking->ending_date = Carbon::parse($request->date . ' ' . $request->ending_time)->subMinute()->toDateTimeString();
                $booking->address = $request->address;
            } else {
                $dates = $this->getAllBookingsForOnePlaceHB($request->place_id);
                $booking->starting_date = Carbon::parse($request->starting_date)->toDateTimeString();
                $booking->ending_date = Carbon::parse($request->ending_date)->toDateTimeString();
                if ($this->checkSingleDateBetween($dates, $booking->starting_date, $booking->ending_date)) {
                    return response()->json(['message' => 'there is reservation in this date'], Response::HTTP_BAD_REQUEST);
                }
            }

            $booking->save();

            // dd($booking);

            $myFatoorahController = new MyFatoorahController();

            $response = $myFatoorahController->index($booking->id);

            // dd($response);
            $responseData = $response->getData();
            // dd($responseData->Data);

            return response()->json(['message' => 'Booking added successfully', 'invoice_data' => $responseData->Data], Response::HTTP_OK);
        } catch (\Exception $e) {
            $booking->delete();
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => 'Booking added successfully'], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            if (!$booking) {
                return response()->json(['message' => 'booking not found'], Response::HTTP_NOT_FOUND);
            }

            $created_at = $booking->created_at;
            $currentDateTime = now();
            $diff = $currentDateTime->diff($created_at);
            $remainingSeconds = $diff->days * 86400 + $diff->h * 3600 + $diff->i * 60 + $diff->s;
            if ($remainingSeconds >= 86400) {
                return response()->json(['message' => 'booking cannot be canceled'], Response::HTTP_BAD_REQUEST);
            } else {
                $booking->status = $request->status;
                $booking->save();
                $pushNotification = new pushNotificationController();
                $title = "booking status updated";
                $body = "";
                $user_id = $booking->user_id;
                if ($booking->place_id) {
                    // $place = Place::where('id', $booking->place_id)->first();
                    $body = "your booking status for place $booking->place->title is updated to $booking->status";
                } else {
                    // $service = Service::where('id', $booking->service_id)->first();
                    $body = "your booking status for service $booking->service->title is updated to $booking->status";
                }
                $pushNotification->pushNotificationForSpecificUser($title, $body, $user_id);
                return response()->json(['message' => 'booking updated successfully'], Response::HTTP_OK);
            }


        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getReservationById(Request $request, $id)
    {
        try {
            $language = $request->input('language', 'en');
            $titleColumn = $language == 'ar' ? 'title_ar' : 'title';

            $query = Booking::where('bookings.id', $id);
            // dd($query->place_id);
            $placeBooking = $query->pluck('place_id')->first();
            $serviceBooking = $query->pluck('service_id')->first();

            if (!$placeBooking && !$serviceBooking) {
                return response()->json(['message' => 'Booking not found'], Response::HTTP_NOT_FOUND);
            }

            if ($placeBooking) {
                $reservation = $query->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id')
                ->leftJoin('places', 'places.id', '=', 'bookings.place_id')
                // ->leftJoin('places', function ($join) {
                //     $join->on('places.id', '=', 'bookings.place_id')
                //         ->withTrashed();
                // })
                ->leftJoin('payment_methods', 'payment_methods.id', '=', 'bookings.payment_method_id')
                ->leftJoin('categories', 'categories.id', '=', 'places.category_id')
                ->leftJoin('users', 'users.id', '=', 'bookings.user_id')
                // ->leftJoin('users', function ($join) {
                //     $join->on('users.id', '=', 'bookings.user_id')
                //         ->withTrashed();
                // })
                ->leftJoin('promo_codes', 'promo_codes.id', '=', 'bookings.promo_code_id')
                ->leftJoin('place_images', 'place_images.place_id', '=', 'places.id')
                ->select(
                    'bookings.id',
                    'bookings.created_at',
                    'bookings.status',
                    'bookings.total_price',
                    'bookings.starting_date',
                    'bookings.ending_date',
                    'bookings.total_price',
                    'bookings.transaction_id',
                    'bookings.invoice_reference',
                    'bookings.reference_id',
                    'bookings.payment',
                    'payment_methods.payment_method',
                    'places.title AS place_title',
                    'places.tag',
                    'places.weekday_price',
                    'places.weekend_price',
                    'places.address',
                    "categories.$titleColumn AS category_title",
                    'users.name',
                    'users.phone',
                    DB::raw('COALESCE((promo_codes.discount * bookings.total_price / 100), 0) AS discount'),
                    DB::raw('COALESCE(total_price - promo_codes.discount * bookings.total_price / 100, total_price) AS total'),
                    DB::raw('GROUP_CONCAT(place_images.image) AS images'),
                    DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
                )
                // ->withTrashed(['places', 'users'])
                // ->withTrashed()
                // ->with(['places' => function ($query) {
                //     $query->withTrashed();
                // }])
                // ->with(['users' => function ($query) {
                //     $query->withTrashed();
                // }])
                ->groupBy(
                    'bookings.id',
                    'bookings.created_at',
                    'bookings.status',
                    'bookings.total_price',
                    'bookings.starting_date',
                    'bookings.ending_date',
                    'bookings.total_price',
                    'bookings.transaction_id',
                    'bookings.invoice_reference',
                    'bookings.reference_id',
                    'bookings.payment',
                    'payment_methods.payment_method',
                    'place_title',
                    'places.tag',
                    'places.weekday_price',
                    'places.weekend_price',
                    'places.address',
                    'category_title',
                    'users.name',
                    'users.phone',
                    'discount',
                    'total'
                )
                ->first();
            } else {
                $reservation = $query->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id')
                ->leftJoin('services', 'services.id', '=', 'bookings.service_id')
                // ->leftJoin('services', function ($join) {
                //     $join->on('services.id', '=', 'bookings.service_id')
                //          ->withTrashed(); // Include soft-deleted records
                // })
                ->leftJoin('payment_methods', 'payment_methods.id', '=', 'bookings.payment_method_id')
                ->leftJoin('categories', 'categories.id', '=', 'services.category_id')
                ->leftJoin('users', 'users.id', '=', 'bookings.user_id')
                // ->leftJoin('users', function ($join) {
                //     $join->on('users.id', '=', 'bookings.user_id')
                //         ->withTrashed();
                // })
                ->leftJoin('promo_codes', 'promo_codes.id', '=', 'bookings.promo_code_id')
                ->leftJoin('service_images', 'service_images.service_id', '=', 'services.id')
                ->select(
                    'bookings.id',
                    'bookings.created_at',
                    'bookings.status',
                    'bookings.address',
                    'bookings.total_price',
                    'bookings.starting_date',
                    'bookings.ending_date',
                    'bookings.transaction_id',
                    'bookings.invoice_reference',
                    'bookings.reference_id',
                    'bookings.payment',
                    'payment_methods.payment_method',
                    'services.title AS service_title',
                    'services.price',
                    "categories.$titleColumn AS category_title",
                    'users.name',
                    'users.phone',
                    DB::raw('COALESCE((promo_codes.discount * bookings.total_price / 100), 0) AS discount'),
                    DB::raw('COALESCE(total_price - promo_codes.discount * bookings.total_price / 100, total_price) AS total'),
                    DB::raw('GROUP_CONCAT(service_images.image) AS images'),
                    DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
                )
                // ->withTrashed(['services', 'users'])
                // ->withTrashed()

                // ->with(['service' => function ($query) {
                //     $query->withTrashed();
                // }])
                // ->with(['user' => function ($query) {
                //     $query->withTrashed();
                // }])
                ->groupBy(
                    'bookings.id',
                    'bookings.created_at',
                    'bookings.status',
                    'bookings.address',
                    'bookings.total_price',
                    'bookings.starting_date',
                    'bookings.ending_date',
                    'bookings.transaction_id',
                    'bookings.invoice_reference',
                    'bookings.reference_id',
                    'bookings.payment',
                    'payment_methods.payment_method',
                    'service_title',
                    'category_title',
                    'services.price',
                    'users.name',
                    'users.phone',
                    'discount',
                    'total'
                )
                ->first();
            }

            if ($reservation->images) {
                $reservation->images = explode(',', $reservation->images);
            } else {
                $reservation->images = [];
            }

            // $reservation->transform(function ($item, $key) {
            //     $item->images = explode(',', $item->images);
            //     return $item;
            // });

            return response()->json($reservation, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getBookingById(Request $request, $id)
    {
        try {
            $userId = Auth::id();

            $language = $request->input('language', 'en');
            $titleColumn = $language == 'ar' ? 'title_ar' : 'title';

            $rating = Rating::where('user_id', $userId)
                ->where('booking_id', $id)
                ->first();

            $useRating = null;

            if ($rating) {
                $useRating = $rating->rate;
            }

            $query = Booking::where('bookings.id', $id);
            $created_at = $query->pluck('created_at')->first();

            $currentDateTime = now();
            $diff = $currentDateTime->diff($created_at);
            $remainingSeconds = $diff->days * 86400 + $diff->h * 3600 + $diff->i * 60 + $diff->s;
            $showButton = false;
            if ($remainingSeconds >= 86400) {
                $showButton = false;
            } else {
                $showButton = true;
            }

            $placeBooking = $query->pluck('place_id')->first();
            $serviceBooking = $query->pluck('service_id')->first();

            if (!$placeBooking && !$serviceBooking) {
                return response()->json(['message' => 'Booking not found'], Response::HTTP_NOT_FOUND);
            }

            if ($placeBooking) {
                $reservation = $query->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id')
                ->leftJoin('places', 'places.id', '=', 'bookings.place_id')
                // ->leftJoin('places', function ($join) {
                //     $join->on('places.id', '=', 'bookings.place_id')
                //         ->withTrashed();
                // })
                // ->leftJoin('users', function ($join) {
                //     $join->on('users.id', '=', 'bookings.user_id')
                //         ->withTrashed();
                // })
                ->leftJoin('payment_methods', 'payment_methods.id', '=', 'bookings.payment_method_id')
                ->leftJoin('categories', 'categories.id', '=', 'places.category_id')
                ->leftJoin('users', 'users.id', '=', 'bookings.user_id')
                ->leftJoin('promo_codes', 'promo_codes.id', '=', 'bookings.promo_code_id')
                ->leftJoin('place_images', 'place_images.place_id', '=', 'places.id')
                ->select(
                    'bookings.id',
                    'bookings.created_at',
                    'bookings.status',
                    'bookings.total_price',
                    'bookings.starting_date',
                    'bookings.ending_date',
                    'bookings.total_price',
                    'bookings.transaction_id',
                    'bookings.invoice_reference',
                    'bookings.reference_id',
                    'bookings.payment',
                    'payment_methods.payment_method',
                    'places.title AS place_title',
                    'places.tag',
                    'places.weekday_price',
                    'places.weekend_price',
                    'places.address',
                    "categories.$titleColumn AS category_title",
                    'users.name',
                    'users.phone',
                    DB::raw('COALESCE((promo_codes.discount * bookings.total_price / 100), 0) AS discount'),
                    DB::raw('COALESCE(total_price - promo_codes.discount * bookings.total_price / 100, total_price) AS total'),
                    DB::raw('GROUP_CONCAT(place_images.image) AS images'),
                    DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
                )
                ->groupBy(
                    'bookings.id',
                    'bookings.created_at',
                    'bookings.status',
                    'bookings.total_price',
                    'bookings.starting_date',
                    'bookings.ending_date',
                    'bookings.total_price',
                    'bookings.transaction_id',
                    'bookings.reference_id',
                    'bookings.invoice_reference',
                    'bookings.payment',
                    'payment_methods.payment_method',
                    'place_title',
                    'places.tag',
                    'places.weekday_price',
                    'places.weekend_price',
                    'places.address',
                    'category_title',
                    'users.name',
                    'users.phone',
                    'discount',
                    'total'
                )
                ->first();
            } else {
                $reservation = $query->leftJoin('ratings', 'bookings.id', '=', 'ratings.booking_id')
                ->leftJoin('services', 'services.id', '=', 'bookings.service_id')
                // ->leftJoin('services', function ($join) {
                //     $join->on('services.id', '=', 'bookings.service_id')
                //         ->withTrashed();
                // })
                ->leftJoin('payment_methods', 'payment_methods.id', '=', 'bookings.payment_method_id')
                ->leftJoin('categories', 'categories.id', '=', 'services.category_id')
                ->leftJoin('users', 'users.id', '=', 'bookings.user_id')
                // ->leftJoin('users', function ($join) {
                //     $join->on('users.id', '=', 'bookings.user_id')
                //         ->withTrashed();
                // })
                ->leftJoin('promo_codes', 'promo_codes.id', '=', 'bookings.promo_code_id')
                ->leftJoin('service_images', 'service_images.service_id', '=', 'services.id')
                ->select(
                    'bookings.id',
                    'bookings.created_at',
                    'bookings.status',
                    'bookings.address',
                    'bookings.total_price',
                    'bookings.transaction_id',
                    'bookings.reference_id',
                    'bookings.invoice_reference',
                    'bookings.payment',
                    'payment_methods.payment_method',
                    'bookings.starting_date',
                    'bookings.ending_date',
                    'services.title AS service_title',
                    'services.price',
                    "categories.$titleColumn AS category_title",
                    'users.name',
                    'users.phone',
                    DB::raw('COALESCE((promo_codes.discount * bookings.total_price / 100), 0) AS discount'),
                    DB::raw('COALESCE(total_price - promo_codes.discount * bookings.total_price / 100, total_price) AS total'),
                    DB::raw('GROUP_CONCAT(service_images.image) AS images'),
                    DB::raw('COALESCE(AVG(ratings.rate), 0) as rating')
                )
                ->groupBy(
                    'bookings.id',
                    'bookings.created_at',
                    'bookings.status',
                    'bookings.address',
                    'bookings.total_price',
                    'bookings.starting_date',
                    'bookings.ending_date',
                    'bookings.transaction_id',
                    'bookings.reference_id',
                    'bookings.invoice_reference',
                    'bookings.payment',
                    'payment_methods.payment_method',
                    'service_title',
                    'category_title',
                    'services.price',
                    'users.name',
                    'users.phone',
                    'discount',
                    'total'
                )
                ->first();
            }

            if ($reservation->images) {
                $reservation->images = explode(',', $reservation->images);
            } else {
                $reservation->images = [];
            }


            // $reservation->transform(function ($item, $key) {
            //     $item->images = explode(',', $item->images);
            //     return $item;
            // });

            return response()->json(['bookings' => $reservation, 'user_rating' => $useRating, 'showButton' => $showButton], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAllBookingsForOnePlace($id)
    {
        try {
            $today = new DateTime();
            $bookings = Booking::where('place_id', $id)->where('ending_date', '>', $today)->get();
            $dates = [];
            foreach ($bookings as $booking) {
                $currentDate = new DateTime($booking->starting_date);
                $endDate = new DateTime($booking->ending_date);
                while ($currentDate <= $endDate) {
                    $dates[] = $currentDate->format('Y-m-d');
                    $currentDate->modify('+1 day');
                }
            }

            $dates = array_unique($dates);
            sort($dates);

            return response()->json($dates, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    private function getAllBookingsForOnePlaceHB($id)
    {
        try {
            $today = new DateTime();
            $bookings = Booking::where('place_id', $id)->where('ending_date', '>', $today)->get();
            $dates = [];
            foreach ($bookings as $booking) {
                $currentDate = new DateTime($booking->starting_date);
                $endDate = new DateTime($booking->ending_date);
                while ($currentDate <= $endDate) {
                    $dates[] = $currentDate->format('Y-m-d');
                    $currentDate->modify('+1 day');
                }
            }

            $dates = array_unique($dates); // delete when at the last time
            sort($dates);

            return $dates;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAmountOfTodayReservationsForOneVendor()
    {
        try {
            $vendorId = Auth::id();
            $vendor = User::findOrFail($vendorId);

            $today = Carbon::today();

            $numberOfBookingsForServices = Booking::whereIn('service_id', $vendor->services->pluck('id'))
                ->whereDate('created_at', $today)
                ->where('payment', '!=', null)
                ->sum('payment');

            $numberOfBookingsForPlaces = Booking::whereIn('place_id', $vendor->places->pluck('id'))
                ->whereDate('created_at', $today)
                ->where('payment', '!=', null)
                ->sum('payment');

            $totalNumberOfBookings = $numberOfBookingsForServices + $numberOfBookingsForPlaces;

            return response()->json(['value' => $totalNumberOfBookings], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // manager
    public function getAmountOfTodayReservationsOnlyCommission()
    {
        try {
            $user = Auth::user();
            
            $today = Carbon::today();

            $payments = Booking::whereDate('created_at', $today)
                ->where('payment', '!=', null)
                ->sum('payment');

            $commission = $user->commission;

            $commission = $payments * $commission / 100;

            return response()->json(['value' => $commission], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // manager
    public function getNumberOfTodayReservationsForManager()
    {
        try {

            $today = Carbon::today();

            $numberOfBookings = Booking::whereDate('created_at', $today)->count();

            return response()->json(['value' => $numberOfBookings], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // manager
    public function getNumberOfAllReservations()
    {
        try {

            $numberOfBookings = Booking::count();

            return response()->json(['value' => $numberOfBookings], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // manager // is it last month or month from now ?
    public function getAmountOfLastMonthReservationsOnlyCommission()
    {
        try {
            $user = Auth::user();

            $startOfMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfMonth = Carbon::now()->subMonth()->endOfMonth();

            $payments = Booking::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('payment', '!=', null)
                ->sum('payment');

                $commission = $user->commission ?? 100;

                $commission = $payments * $commission / 100;

            return response()->json(['value' => $commission], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAmountOfLastMonthReservationsForOneVendor()
    {
        try {
            $vendorId = Auth::id();
            $vendor = User::findOrFail($vendorId);

            $startOfMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfMonth = Carbon::now()->subMonth()->endOfMonth();

            $numberOfBookingsForServices = Booking::whereIn('service_id', $vendor->services->pluck('id'))
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('payment', '!=', null)
                ->sum('payment');

            $numberOfBookingsForPlaces = Booking::whereIn('place_id', $vendor->places->pluck('id'))
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('payment', '!=', null)
                ->sum('payment');

            $totalNumberOfBookings = $numberOfBookingsForServices + $numberOfBookingsForPlaces;

            return response()->json(['value' => $totalNumberOfBookings], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAmountOfUpcomingReservationsForOneVendor() // upcoming
    {
        try {
            $vendorId = Auth::id();
            $vendor = User::findOrFail($vendorId);

            $amountOfUpcomingReservationsService = Booking::whereIn('service_id', $vendor->services->pluck('id'))
                ->where('status', '=', 'placed')
                ->where('payment', '!=', null)
                ->sum('payment');

            $amountOfUpcomingReservationsPlace = Booking::whereIn('place_id', $vendor->places->pluck('id'))
                ->where('status', '=', 'placed')
                ->where('payment', '!=', null)
                ->sum('payment');

            return response()->json(['value' => $amountOfUpcomingReservationsService + $amountOfUpcomingReservationsPlace], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getSumOfAllReservationForOneVendor()
    {
        try {
            $vendorId = Auth::id();
            $vendor = User::findOrFail($vendorId);

            $numberOfBookingsForServices = Booking::whereIn('service_id', $vendor->services->pluck('id'))->count();

            $numberOfBookingsForPlaces = Booking::whereIn('place_id', $vendor->places->pluck('id'))->count();

            $totalNumberOfBookings = $numberOfBookingsForServices + $numberOfBookingsForPlaces;

            return response()->json(['value' => $totalNumberOfBookings], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getReservationStatisticsForOneVendor()
    {
        try {
            $amountOfTodayReservations = $this->getAmountOfTodayReservationsForOneVendor();
            $amountOfLastMonthReservations = $this->getAmountOfLastMonthReservationsForOneVendor();
            $amountOfUpcomingReservations = $this->getAmountOfUpcomingReservationsForOneVendor();
            $sumOfAllReservations = $this->getSumOfAllReservationForOneVendor();

            $statistics = [
                'day' => $amountOfTodayReservations->original['value'],
                'month' => $amountOfLastMonthReservations->original['value'],
                'upcoming' => $amountOfUpcomingReservations->original['value'],
                'count' => $sumOfAllReservations->original['value']
            ];

            return response()->json($statistics, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAllPlaceReservationsForOneVendor(Request $request)
    {
        try {
            $language = $request->input('language', 'en');
            $titleColumn = $language == 'ar' ? 'title_ar' : 'title';

            $reservations = Booking::leftJoin('places', 'places.id', '=', 'bookings.place_id')
            // leftJoin('places', function ($join) {
            //     $join->on('places.id', '=', 'bookings.place_id')
            //         ->withTrashed();
            // })
                ->leftJoin('categories', 'categories.id', '=', 'places.category_id')
                ->select(
                    'bookings.id',
                    'bookings.status',
                    'bookings.total_price',
                    'bookings.invoice_reference',
                    'bookings.payment',
                    'bookings.starting_date',
                    'bookings.ending_date',
                    'places.title AS place_title',
                    "categories.$titleColumn AS category_title",
                )
                ->where('service_id', '=', null)
                ->get();

            return response()->json($reservations, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAllPlaceBookingsForOneUser(Request $request)
    {
        try {
            $userId = Auth::id();

            $language = $request->input('language', 'en');
            $titleColumn = $language == 'ar' ? 'title_ar' : 'title';
            // $user = User::findOrFail($userId);

            $reservations = Booking::leftJoin('places', 'places.id', '=', 'bookings.place_id')
                // leftJoin('places', function ($join) {
                //     $join->on('places.id', '=', 'bookings.place_id')
                //         ->withTrashed();
                // })
                ->leftJoin('categories', 'categories.id', '=', 'places.category_id')
                ->select(
                    'bookings.id',
                    'bookings.status',
                    'bookings.total_price',
                    'bookings.payment',
                    'bookings.invoice_reference',
                    // 'bookings.starting_date',
                    // 'bookings.ending_date',
                    'places.title AS place_title',
                    "categories.$titleColumn AS category_title",
                )
                ->where('service_id', '=', null)
                ->where('user_id', '=', $userId)
                ->get();

            return response()->json($reservations, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAllServiceReservationsForOneVendor(Request $request)
    {
        try {

            $language = $request->input('language', 'en');
            $titleColumn = $language == 'ar' ? 'title_ar' : 'title';

            $reservations = Booking::
            leftJoin('services', 'services.id', '=', 'bookings.service_id')
                // leftJoin('services', function ($join) {
                //     $join->on('services.id', '=', 'bookings.service_id')
                //         ->withTrashed();
                // })
                ->leftJoin('categories', 'categories.id', '=', 'services.category_id')
                ->select(
                    'bookings.id',
                    'bookings.status',
                    'bookings.total_price',
                    'bookings.payment',
                    'bookings.invoice_reference',
                    'bookings.starting_date',
                    'bookings.ending_date',
                    'services.title AS service_title',
                    "categories.$titleColumn AS category_title",
                )
                ->where('place_id', '=', null)
                ->get();

            return response()->json($reservations, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAllServiceBookingsForOneUser(Request $request)
    {
        try {
            $userId = Auth::id();

            $language = $request->input('language', 'en');
            $titleColumn = $language == 'ar' ? 'title_ar' : 'title';

            $user = User::findOrFail($userId);

            $reservations = Booking::
            leftJoin('services', 'services.id', '=', 'bookings.service_id')
                // leftJoin('services', function ($join) {
                //     $join->on('services.id', '=', 'bookings.service_id')
                //         ->withTrashed();
                // })
                ->leftJoin('categories', 'categories.id', '=', 'services.category_id')
                ->select(
                    'bookings.id',
                    'bookings.status',
                    'bookings.total_price',
                    'bookings.invoice_reference',
                    'bookings.payment',
                    // 'bookings.starting_date',
                    // 'bookings.ending_date',
                    'services.title AS service_title',
                    "categories.$titleColumn AS category_title",
                )
                ->where('place_id', '=', null)
                ->where('user_id', '=', $userId)
                ->get();

            return response()->json($reservations, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAllForAuthUser()
    {
        try {
            $userId = Auth::id();

            $bookings = Booking::leftJoin('places', 'booking.place_id', '=', 'places.id')
                ->leftJoin('services', 'services.id', '=', 'booking.service_id')
                ->select('services.title', 'places.title', 'bookings.id', 'bookings.status', 'bookings.amount')
                ->where('user_id', $userId)
                ->get();

            // $bookings->load(['place.averageRating', 'service.averageRating']);

            return response()->json($bookings, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAllForFuture()
    {
        try {
            $bookings = Booking::where('created_at', '>', Carbon::now())
                ->where('status', '!=', 'canceled')
                ->select('starting_date', 'ending_date')
                ->get();
            return response()->json($bookings, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // private function checkServiceAvailability($serviceId, $date, $startingTime, $endingTime) /////////
    // {
    //     $starting_date = Carbon::parse($date . ' ' . $startingTime)->toDateTimeString();
    //     $ending_date = Carbon::parse($date . ' ' . $endingTime)->subMinute()->toDateTimeString();
    //     $bookings = Booking::where('service_id', $serviceId)
    //         ->where('starting_date', '=', $starting_date)
    //         ->where('ending_date', '=', $ending_date)
    //         ->leftJoin('services', 'services.id', '=', 'bookings.service_id')
    //         ->get();

    //     $maxCapacity = $bookings[0]->max_capacity;
    //     $noticePeriodHours = $bookings[0]->notice_period;

    //     $bookingCount = $this->getBookingCount($bookings, $startingTime, $endingTime, $noticePeriodHours);
    //     if ($bookingCount < $maxCapacity && $this->isValidPeriodFromNow($startingTime, $noticePeriodHours)) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function showAvailableTimeSlots($serviceId)
    {
        try {
            $bookings = Booking::where('service_id', $serviceId)
            ->leftJoin('services', 'services.id', '=', 'bookings.service_id')
            ->get();

            // $count = count($bookings);
            // if ($count == 0) {

            // }

            // $maxCapacity = $bookings[0]->max_capacity;
            // $duration = $bookings[0]->duration;
            // $noticePeriodHours = $bookings[0]->notice_period;

            $service = Service::where('id', $serviceId)->first();
            $maxCapacity = $service->max_capacity;
            $duration = $service->duration;
            $noticePeriodHours = $service->notice_period;

            $availableSlots = $this->calculateAvailableSlots($bookings, $maxCapacity, $duration, $noticePeriodHours);

            return response()->json($availableSlots, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

    }

    public function showAvailableTimeSlotsHB($serviceId)
    {
        $bookings = Booking::where('service_id', $serviceId)
            ->leftJoin('services', 'services.id', '=', 'bookings.service_id')
            // ->leftJoin('services', function ($join) {
            //     $join->on('services.id', '=', 'bookings.service_id')
            //         ->withTrashed();
            // })
            ->get();

        $service = Service::where('id', $serviceId)->first();
        $maxCapacity = $service->max_capacity;
        $duration = $service->duration;
        $noticePeriodHours = $service->notice_period;

        $availableSlots = $this->calculateAvailableSlots($bookings, $maxCapacity, $duration, $noticePeriodHours);

        return $availableSlots;
    }

    private function calculateAvailableSlots($bookings, $maxCapacity, $duration, $noticePeriodHours)
    {
        $availableSlots = [];

        $currentDate = Carbon::now();
        $endDate = $currentDate->copy()->addMonth();

        while ($currentDate <= $endDate) {
            $startTime = $currentDate->copy()->startOfDay();
            $endTime = $currentDate->copy()->endOfDay();
            // if (!$bookings->isEmpty()) {
                $bookingsArray = $bookings->toArray();
                $currentDateBookings = array_filter($bookingsArray, function ($booking) use ($currentDate) {
                    $bookingDate = Carbon::parse($booking['starting_date'])->format('Y-m-d');
                    return $bookingDate === $currentDate->format('Y-m-d');
                });
            // }
            $slots = $this->generateSlots($currentDateBookings, $maxCapacity, $duration, $noticePeriodHours, $startTime, $endTime);

            if (!empty($slots)) {
                $availableSlots[$currentDate->format('Y-m-d')] = $slots;
            }

            $currentDate->addDay();
        }

        return $availableSlots;
    }

    private function generateSlots($bookings, $maxCapacity, $duration, $noticePeriodHours, $startTime, $endTime)
    {
        $slots = [];
        $currentSlot = $startTime->copy();

        while ($currentSlot <= $endTime) {
            $nextSlot = $currentSlot->copy()->addHours($duration);

            if ($nextSlot <= $endTime) {

                $bookingCount = $this->getBookingCount($bookings, $currentSlot, $nextSlot, $noticePeriodHours);

                if ($bookingCount < $maxCapacity && $this->isValidPeriodFromNow($currentSlot, $noticePeriodHours)) {
                    $slots[] = [$currentSlot->toDateTimeString(), $nextSlot->toDateTimeString()];
                }

            }

            $currentSlot->addHour();
        }

        return $slots;
    }

    private function getBookingCount($bookings, $startTime, $endTime, $noticePeriodHours)
    {
        $count = 0;

        foreach ($bookings as $booking) {

            $bookingStartTime = Carbon::parse($booking['starting_date'])->format('G:i:s');
            $bookingEndTime = Carbon::parse($booking['ending_date'])->format('G:i:s');

            $datetime1 = DateTime::createFromFormat('G:i:s', $bookingEndTime);
            $datetime2 = DateTime::createFromFormat('G:i:s', $noticePeriodHours);
            $datetime1->add(new DateInterval('PT' . $datetime2->format('H') . 'H' . $datetime2->format('i') . 'M' . $datetime2->format('s') . 'S'));
            $bookingEndTime = $datetime1->format('G:i:s');

            // dump(['bookingEndTime' => $bookingEndTime, 'bookingStartTime' => $bookingStartTime, 'startTime' => $startTime, 'endTime' => $endTime, 'condition' => ($startTime >= $bookingStartTime && $startTime < $bookingEndTime) || ($bookingEndTime >= $endTime && $bookingStartTime <= $endTime)]);
            if ( ($startTime->format('G:i:s') >= $bookingStartTime && $startTime->format('G:i:s') < $bookingEndTime) ||
                    ($bookingEndTime >= $endTime->format('G:i:s') && $bookingStartTime < $endTime->format('G:i:s')) ) {
                $count++;
            }

        }
        return $count;
    }

    private function isValidPeriodFromNow($startTime)
    {
        $now = Carbon::now();

        return $startTime >= $now;
    }

    private function checkSingleDateBetween($dateList, $startDate, $endDate) {
        $count = 0;
        foreach ($dateList as $date) {
            if ($date >= $startDate && $date <= $endDate) {
                $count++;
            }
        }

        return $count >= 1;
    }

    private function checkTimeForBookingService($dateTimeList, $startTime) {

        foreach ($dateTimeList as $date) {
            $date = new DateTime($date[0]);
            if ($date->format('H:i:s') == $startTime) {
                return false;
            }
        }

        return true;
    }
}


