<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/test', function () {

//     $dd = new Controller();

//     $dd->sendPushNotification('fuh2qINZ1uq3kNI3h8nHvt:APA91bFhRM_q9JXKCBYFoFCXeHcamneDLv4nJnZP_MkuRCh44XkJCBOlCrWjFqyYgARA65bFykLM1dORNrjKVuLgjw4PoYhy9LOx2nAhoWOldaMiZFRwx9QevhJ-teo2VhbxRucApitY', 1, 'New Test ', 'hello My Name IS Basel', '/home');
// });
Route::get('/', function () {
    return redirect('admin/signin');
})->name('//');

Route::prefix('admin')->group(
    function () {


        Route::middleware(['guest'])->group(function () {

            Route::get('/signin', function () {
                return view('admin.auth.signin');
            })->name('admin-signin');
            Route::post('/signin', [AuthController::class, 'login'])->name('admin-signin-post');
        });

        Route::middleware(['admin'])->group(function () {

            Route::get('/', [HomeController::class, 'index'])->name('admin');
            Route::patch('/fcm-token', [HomeController::class, 'updateToken'])->name('fcmToken');
            Route::get('/notification/all', [HomeController::class, 'getAllNotification'])->name('notification');
            Route::resource('bookings', BookingController::class);
            Route::resource('admins', AdminController::class);
            Route::resource('roles', RoleController::class);
            Route::resource('amenities', AmenityController::class);
            Route::resource('customers', CustomerController::class);
            Route::resource('vendors', VendorController::class);
            Route::resource('categories', CategoryController::class);
            Route::resource('places', PlaceController::class);
            Route::resource('services', ServiceController::class);
            Route::resource('static-content', ContentController::class);
            Route::get('/bookings/status/{bookings}', [BookingController::class, 'updateStatus'])->name('bookings.update.status');
            Route::get('/banners/status/{image}/{status}', [ContentController::class, 'updateStatus'])->name('banners.update.status');
            Route::get('/categories/status/{category}', [CategoryController::class, 'updateStatus'])->name('categories.update.status');
            Route::get('/amenities/status/{amenity}', [AmenityController::class, 'updateStatus'])->name('amenity.update.status');
            Route::get('/customers/status/{customer}', [CustomerController::class, 'updateStatus'])->name('customer.update.status');
            Route::get('/vendors/status/{vendor}', [VendorController::class, 'updateStatus'])->name('vendor.update.status');
            Route::get('/customers/bookings/{customer}', [CustomerController::class, 'viewBookings'])->name('customer.bookings');
            Route::get('/vendors/places/{vendor}', [VendorController::class, 'viewPlaces'])->name('vendor.places');
            Route::get('/vendors/services/{vendor}', [VendorController::class, 'viewServices'])->name('vendor.services');
            Route::post('/services/images', [ServiceController::class, 'addImages'])->name('services.images');
            Route::get('/contact-us', [ContactUsController::class, 'index'])->name('messages.index');
            Route::get('/contact-us/status/{message}/{status}', [ContactUsController::class, 'update'])->name('message.update');
            Route::get('/admin/notification', [HomeController::class, 'notifications'])->name('admin.notifications');
            Route::post('/push/notification', [HomeController::class, 'pushNotification'])->name('admin.pushNotifications');

            // dashboard charts
            Route::get('update-widget-20', [HomeController::class, 'updateWidget20']);
            Route::get('update-widget-38', [HomeController::class, 'updateWidget38']);
            Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
            Route::post('/static-content/all', [ContentController::class, 'updateAll'])->name('static_content.update.all');
            Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
            Route::post('/profile/update', [HomeController::class, 'profileUpdate'])->name('profile.update');
        });
    }
);
