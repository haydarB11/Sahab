<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\areaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\contactRequestController;
use App\Http\Controllers\deviceTokenController;
use App\Http\Controllers\homeImageController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\paymentMethodController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PlaceImageController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\pushNotificationController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ratingMessageController;
use App\Http\Controllers\ratingTitleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceImageController;
use App\Http\Controllers\SpecialDayController;
use App\Http\Controllers\StaticContentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('categories')->group(function () {
        Route::post('/', [CategoryController::class, 'store']);
        Route::get('/type', [CategoryController::class, 'getAllDependingOnType']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
        Route::get('/{id}/places', [PlaceController::class, 'getPlacesForOneCategory']);
        Route::get('/{id}/services', [ServiceController::class, 'getServicesForOneCategory']);
        Route::get('/{id}', [CategoryController::class, 'show']);
        // Route::get('/', [CategoryController::class, 'index']);
        Route::get('/', [CategoryController::class, 'index'])->name('categories.All');
});

Route::prefix('area')->group(function () {
        Route::post('/', [areaController::class, 'store']);
        Route::delete('/{id}', [areaController::class, 'destroy']);
        Route::get('/', [areaController::class, 'index']);
});

Route::prefix('home-images')->group(function () {
        Route::post('/', [homeImageController::class, 'store']);
        Route::delete('/', [homeImageController::class, 'destroy']);
        Route::get('/', [homeImageController::class, 'index']);
});

Route::prefix('places')->group(function () {
    Route::get('/count', [PlaceController::class, 'getNumberOfPlaces'])->middleware('auth:sanctum', 'role:admin');
    Route::post('/', [PlaceController::class, 'store']);
    Route::get('/search', [PlaceController::class, 'search']);
    Route::post('/{id}', [PlaceController::class, 'update']);
    Route::delete('/{id}', [PlaceController::class, 'destroy']);
    Route::get('/{id}', [PlaceController::class, 'show']);
    Route::get('/{id}/bookings', [BookingController::class, 'getAllBookingsForOnePlace']);
    Route::get('/', [PlaceController::class, 'index']);
    Route::get('/featured/get', [PlaceController::class, 'getAllFeatured']);
    Route::get('/users/get-all', [PlaceController::class, 'getPlacesForOneUser'])->middleware('auth:sanctum', 'role:vendor');

    Route::prefix('/images')->group(function () {
        Route::post('/', [PlaceImageController::class, 'store']);
        Route::delete('/delete-many', [PlaceImageController::class, 'deleteMany']);
        Route::delete('/{id}', [PlaceImageController::class, 'destroy']);
        Route::get('/{id}', [PlaceImageController::class, 'getAllForOnePlace']);
    });

});

Route::prefix('services')->group(function () {
    Route::get('/count', [ServiceController::class, 'getNumberOfServices'])->middleware(['admin', 'auth:sanctum', 'role:admin']);
    Route::post('/', [ServiceController::class, 'store']);
    Route::get('/search', [ServiceController::class, 'search']);
    Route::post('/{id}', [ServiceController::class, 'update']);
    Route::delete('/{id}', [ServiceController::class, 'destroy']);
    Route::get('/{id}', [ServiceController::class, 'show']);
    Route::get('/', [ServiceController::class, 'index']);
    Route::get('/{id}/bookings', [BookingController::class, 'showAvailableTimeSlots']);
    Route::get('/featured', [ServiceController::class, 'getAllFeatured']);
    Route::get('/users/{id}', [ServiceController::class, 'getServicesForOneUser']);

    Route::prefix('/images')->group(function () {
        Route::delete('/delete-many', [ServiceImageController::class, 'deleteMany']);
        Route::post('/', [ServiceImageController::class, 'store']);
        Route::delete('/{id}', [ServiceImageController::class, 'destroy']);
        Route::get('/{id}', [ServiceImageController::class, 'getAllForOneService']);
    });

});

Route::prefix('amenities')->group(function () {
    Route::post('/', [AmenityController::class, 'store']);
    Route::put('/{id}', [AmenityController::class, 'update']);
    Route::delete('/{id}', [AmenityController::class, 'destroy']);
    Route::get('/{id}', [AmenityController::class, 'show']);
    Route::get('/', [AmenityController::class, 'index']);
});

Route::prefix('special-days')->group(function () {
    Route::post('/', [SpecialDayController::class, 'store']);
    Route::put('/{id}', [SpecialDayController::class, 'update']);
    Route::delete('/{id}', [SpecialDayController::class, 'destroy']);
    Route::get('/{id}', [SpecialDayController::class, 'show']);
    Route::get('/', [SpecialDayController::class, 'index']);
});

Route::prefix('ratings')->group(function () {
    Route::post('/', [RatingController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/', [RatingController::class, 'store'])->middleware('auth:sanctum', 'role:user,vendor');
    Route::put('/{id}', [RatingController::class, 'update']);
    Route::delete('/{id}', [RatingController::class, 'destroy']);
    Route::get('/{id}', [RatingController::class, 'show']);
    Route::get('/', [RatingController::class, 'index']);
});

Route::prefix('promo-codes')->group(function () {
    Route::post('/', [PromoCodeController::class, 'store']);
    Route::post('/add-many', [PromoCodeController::class, 'storeMany']);
    Route::put('/apply', [PromoCodeController::class, 'apply']);
    Route::put('/{id}', [PromoCodeController::class, 'update']);
    Route::delete('/{id}', [PromoCodeController::class, 'destroy']);
    Route::get('/{id}', [PromoCodeController::class, 'show']);
    Route::get('/', [PromoCodeController::class, 'index']);
});

Route::prefix('users')->group(function () {

    Route::prefix('tokens')->group(function () {
        Route::post('/', [deviceTokenController::class, 'store']);
        Route::put('/', [deviceTokenController::class, 'update']);
        Route::delete('/', [deviceTokenController::class, 'destroy']);
    });

    Route::get('/check-role', [UserController::class, 'getUser'])->middleware('auth:sanctum', 'role:user,vendor');
    Route::get('/check-role', [UserController::class, 'getUser'])->middleware('auth:sanctum');
    Route::get('/count', [UserController::class, 'getNumberOfUsers'])->middleware('auth:sanctum', 'role:admin');
    Route::get('/statistics', [BookingController::class, 'getReservationStatisticsForOneVendor'])->middleware('auth:sanctum');
    Route::post('/', [UserController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'getAllForAuthUser'])->middleware('auth:sanctum', 'role:user')->withoutMiddleware('admin');
    Route::delete('/{id}', [UserController::class, 'destroy']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/', [UserController::class, 'index']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/get-otp', [UserController::class, 'sendOtp']);
    Route::post('/resend-otp', [UserController::class, 'resendOtp']);
    Route::post('/{id}', [UserController::class, 'update'])->withoutMiddleware('admin');
    Route::get('/places/get-all', [PlaceController::class, 'getPlacesForOneUser'])->middleware('auth:sanctum')->withoutMiddleware('admin');
    Route::get('/services/get-all', [ServiceController::class, 'getServicesForOneUser'])->middleware('auth:sanctum');
    Route::get('/reservations/count', [BookingController::class, 'getSumOfAllReservationForOneVendor'])->middleware('auth:sanctum');
    Route::get('/reservations/today-sum', [BookingController::class, 'getAmountOfTodayReservationsForOneVendor'])->middleware('auth:sanctum');
    Route::get('/reservations/last-month-sum', [BookingController::class, 'getAmountOfLastMonthReservationsForOneVendor'])->middleware('auth:sanctum');
    Route::get('/reservations/upcoming', [BookingController::class, 'getAmountOfUpcomingReservationsForOneVendor'])->middleware('auth:sanctum');
    Route::get('/reservations/{id}', [BookingController::class, 'getReservationById'])->middleware('auth:sanctum');
    Route::get('/bookings/{id}', [BookingController::class, 'getBookingById'])->middleware('auth:sanctum');
    Route::get('/places/bookings/get-all', [BookingController::class, 'getAllPlaceBookingsForOneUser'])->middleware('auth:sanctum')->withoutMiddleware('admin');
    Route::get('/services/bookings/get-all', [BookingController::class, 'getAllServiceBookingsForOneUser'])->middleware('auth:sanctum')->withoutMiddleware('admin');
    Route::get('/services/bookings/get-all', [BookingController::class, 'getAllServiceBookingsForOneUser'])->middleware('auth:sanctum', 'role:user,vendor')->withoutMiddleware('admin');
    Route::get('/places/reservations/get-all', [BookingController::class, 'getAllPlaceReservationsForOneVendor'])->middleware('auth:sanctum');
    Route::get('/services/reservations/get-all', [BookingController::class, 'getAllServiceReservationsForOneVendor'])->middleware('auth:sanctum');
});

Route::prefix('static-contents')->group(function () {
    Route::post('/', [StaticContentController::class, 'store']);
    Route::put('/{id}', [StaticContentController::class, 'update']);
    Route::get('/', [StaticContentController::class, 'index']);
    Route::get('/get', [StaticContentController::class, 'getForOneTitle']);
});

Route::prefix('static-contents')->group(function () {
    Route::post('/', [StaticContentController::class, 'store']);
    Route::put('/{id}', [StaticContentController::class, 'update']);
    Route::get('/', [StaticContentController::class, 'index']);
    Route::get('/get', [StaticContentController::class, 'getForOneTitle']);
});

Route::prefix('contact-requests')->group(function () {
    Route::post('/', [contactRequestController::class, 'store'])->middleware('auth:sanctum', 'role:user,vendor');
});

Route::prefix('bookings')->group(function () {
    Route::post('/', [BookingController::class, 'store'])->middleware('auth:sanctum', 'role:user,vendor')->withoutMiddleware('admin');
    Route::get('/today/count', [BookingController::class, 'getNumberOfTodayReservationsForManager'])->middleware('auth:sanctum', 'role:admin');
    Route::get('/get-all', [BookingController::class, 'getNumberOfAllReservations'])->middleware('auth:sanctum', 'role:admin');
    Route::get('/commission/today', [BookingController::class, 'getAmountOfTodayReservationsOnlyCommission'])->middleware('auth:sanctum', 'role:admin');
    Route::get('/commission/month', [BookingController::class, 'getAmountOfLastMonthReservationsOnlyCommission'])->middleware('auth:sanctum', 'role:admin');
    Route::put('/{id}', [BookingController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{id}', [BookingController::class, 'destroy']);
    Route::get('/{id}', [BookingController::class, 'show']);
    Route::get('/future', [BookingController::class, 'getAllForFuture']);
    Route::get('/user', [BookingController::class, 'getAllForAuthUser'])->middleware('auth:api', 'role:user');
    Route::get('/cancel/{id}', [BookingController::class, 'cancelBooking'])->middleware('auth:sanctum');
    Route::get('/services/available-time-slots', [BookingController::class, 'showAvailableTimeSlots']);
});

Route::prefix('managers')->group(function () {
    Route::post('/', [ManagerController::class, 'store']);
    Route::put('/{id}', [ManagerController::class, 'update']);
    Route::delete('/{id}', [ManagerController::class, 'destroy']);
    Route::get('/', [ManagerController::class, 'index']);
    Route::post('/login', [ManagerController::class, 'login']);
});

Route::prefix('rating-titles')->group(function () {
    Route::post('/', [ratingTitleController::class, 'store']);
    Route::put('/{id}', [ratingTitleController::class, 'update']);
    Route::delete('/{id}', [ratingTitleController::class, 'destroy']);
    Route::get('/', [ratingTitleController::class, 'index']);
});

Route::prefix('rating-messages')->group(function () {
    Route::post('/', [ratingMessageController::class, 'store']);
    Route::put('/{id}', [ratingMessageController::class, 'update']);
    Route::delete('/{id}', [ratingMessageController::class, 'destroy']);
    Route::get('/', [ratingMessageController::class, 'index']);
});

Route::prefix('notifications')->group(function () {
    Route::post('/', [NotificationController::class, 'store']);
    Route::get('/', [NotificationController::class, 'index']);
});

Route::prefix('push-notifications')->group(function () {
    Route::post('/', [pushNotificationController::class, 'pushNotification']);
});

Route::prefix('hb')->group(function () {
    Route::post('/', [NotificationController::class, 'sendBookingEmail']);
});

Route::prefix('payment-methods')->group(function () {
    Route::post('/', [paymentMethodController::class, 'store']);
    Route::delete('/', [paymentMethodController::class, 'destroy']);
    Route::get('/', [paymentMethodController::class, 'index']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
