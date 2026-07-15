<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerPortalController;
use App\Http\Controllers\Admin;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send')
    ->middleware('throttle:5,1');

Route::get('/locale/{locale}', [HomeController::class, 'setLocale'])->name('locale.set');

// Rooms
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms');
Route::get('/rooms/{roomType}', [RoomController::class, 'show'])->name('rooms.show');

// Restaurant & Bar
Route::get('/restaurant', [MenuController::class, 'restaurant'])->name('restaurant');
Route::get('/bar', [MenuController::class, 'bar'])->name('bar');

// Reservations
Route::post('/restaurant/reserve', [ReservationController::class, 'tableReserve'])->name('restaurant.reserve')
    ->middleware('throttle:10,1');
Route::post('/bar/vip-reserve', [ReservationController::class, 'vipReserve'])->name('bar.vip-reserve')
    ->middleware('throttle:10,1');

// Gallery
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{blogPost:slug}', [BlogController::class, 'show'])->name('blog.show');

// Careers
Route::get('/careers', [CareerController::class, 'index'])->name('careers');
Route::post('/careers/{careerPosition}/apply', [CareerController::class, 'apply'])->name('careers.apply')
    ->middleware('throttle:3,1');

// Booking Engine
Route::prefix('booking')->name('booking')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('');
    Route::post('/select-room', [BookingController::class, 'selectRoom'])->name('.select-room');
    Route::get('/guest-details', [BookingController::class, 'guestDetails'])->name('.guest-details');
    Route::post('/guest-details', [BookingController::class, 'storeGuestDetails'])->name('.guest-details.store');
    Route::get('/payment', [BookingController::class, 'paymentChoice'])->name('.payment-choice');
    Route::post('/payment', [BookingController::class, 'processPayment'])->name('.payment.process');
    Route::get('/confirmation/{reference}', [BookingController::class, 'confirmation'])->name('.confirmation');
    Route::get('/callback/{reference}', [BookingController::class, 'paymentCallback'])->name('.payment.callback');
});

// MoMo webhook
Route::post('/webhooks/momo', function (\Illuminate\Http\Request $request) {
    (new \App\Payments\MoMoGateway())->handleCallback($request->all());
    return response()->json(['status' => 'ok']);
})->name('webhooks.momo');

// Paypack webhook
Route::post('/webhooks/paypack', function (\Illuminate\Http\Request $request) {
    (new \App\Payments\PaypackGateway())->handleCallback($request->all());
    return response()->json(['status' => 'ok']);
})->name('webhooks.paypack');

// Fresh CSRF token (keeps long-open auth pages from expiring)
Route::get('/csrf-token', fn () => response()->json(['token' => csrf_token()]))->name('csrf.token');

// Serve uploaded files directly when the public/storage symlink is missing
// (shared hosting: symlinks don't survive FTP/zip uploads)
if (! is_link(public_path('storage')) && ! is_dir(public_path('storage'))) {
    Route::get('/storage/{path}', function (string $path) {
        $file = storage_path('app/public/' . $path);
        abort_unless(
            str_starts_with(realpath($file) ?: '', realpath(storage_path('app/public'))) && is_file($file),
            404
        );
        return response()->file($file);
    })->where('path', '.*');
}

/*
|--------------------------------------------------------------------------
| Customer Portal (logged-in customers)
|--------------------------------------------------------------------------
*/
Route::prefix('portal')->name('portal.')->middleware('auth')->group(function () {
    Route::get('/', [CustomerPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/booking/{reference}', [CustomerPortalController::class, 'booking'])->name('booking');
    Route::get('/profile', [CustomerPortalController::class, 'profile'])->name('profile');
    Route::post('/profile', [CustomerPortalController::class, 'updateProfile'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Admin Panel (director, manager, staff)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:director|manager|staff'])->group(function () {

    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Bookings
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [Admin\BookingAdminController::class, 'index'])->name('index');
        Route::get('/export', [Admin\BookingAdminController::class, 'export'])->name('export');
        Route::get('/{booking}', [Admin\BookingAdminController::class, 'show'])->name('show');
        Route::post('/{booking}/status', [Admin\BookingAdminController::class, 'updateStatus'])->name('status');
        Route::post('/{booking}/confirm-payment', [Admin\BookingAdminController::class, 'confirmPayment'])->name('confirm-payment');
    });

    // Transactions
    Route::get('/transactions', [Admin\TransactionAdminController::class, 'index'])->name('transactions.index');

    // Rooms
    Route::prefix('rooms')->name('rooms.')->group(function () {
        Route::get('/', [Admin\RoomAdminController::class, 'index'])->name('index');
        Route::get('/type/{roomType}/edit', [Admin\RoomAdminController::class, 'editType'])->name('type.edit');
        Route::post('/type/{roomType}', [Admin\RoomAdminController::class, 'updateType'])->name('type.update');
        Route::post('/', [Admin\RoomAdminController::class, 'storeRoom'])->name('store');
        Route::delete('/{room}', [Admin\RoomAdminController::class, 'destroyRoom'])->name('destroy');
        Route::post('/{room}/status', [Admin\RoomAdminController::class, 'updateRoomStatus'])->name('status');
    });

    // Menu (restaurant & bar)
    Route::prefix('menu')->name('menu.')->group(function () {
        Route::post('/category', [Admin\MenuAdminController::class, 'storeCategory'])->name('category.store');
        Route::put('/category/{menuCategory}', [Admin\MenuAdminController::class, 'updateCategory'])->name('category.update');
        Route::delete('/category/{menuCategory}', [Admin\MenuAdminController::class, 'destroyCategory'])->name('category.destroy');
        Route::post('/item', [Admin\MenuAdminController::class, 'storeItem'])->name('item.store');
        Route::put('/item/{menuItem}', [Admin\MenuAdminController::class, 'updateItem'])->name('item.update');
        Route::delete('/item/{menuItem}', [Admin\MenuAdminController::class, 'destroyItem'])->name('item.destroy');
        Route::get('/{type?}', [Admin\MenuAdminController::class, 'index'])->name('index');
    });

    // Gallery
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', [Admin\GalleryAdminController::class, 'index'])->name('index');
        Route::post('/', [Admin\GalleryAdminController::class, 'store'])->name('store');
        Route::delete('/{galleryPhoto}', [Admin\GalleryAdminController::class, 'destroy'])->name('destroy');
    });

    // Inventory
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [Admin\InventoryController::class, 'index'])->name('index');
        Route::post('/', [Admin\InventoryController::class, 'store'])->name('store');
        Route::put('/{inventoryItem}', [Admin\InventoryController::class, 'update'])->name('update');
    });

    // Blog
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [Admin\BlogAdminController::class, 'index'])->name('index');
        Route::get('/create', [Admin\BlogAdminController::class, 'create'])->name('create');
        Route::post('/', [Admin\BlogAdminController::class, 'store'])->name('store');
        Route::get('/{blogPost}/edit', [Admin\BlogAdminController::class, 'edit'])->name('edit');
        Route::put('/{blogPost}', [Admin\BlogAdminController::class, 'update'])->name('update');
        Route::delete('/{blogPost}', [Admin\BlogAdminController::class, 'destroy'])->name('destroy');
    });

    // Website images (manager & director only)
    Route::prefix('site-images')->name('site-images.')->middleware('role:director|manager')->group(function () {
        Route::get('/', [Admin\SiteImageAdminController::class, 'index'])->name('index');
        Route::post('/{slot}', [Admin\SiteImageAdminController::class, 'update'])->name('update');
        Route::delete('/{slot}', [Admin\SiteImageAdminController::class, 'destroy'])->name('destroy');
    });

    // Reports (manager & director only)
    Route::prefix('reports')->name('reports.')->middleware('role:director|manager')->group(function () {
        Route::get('/', [Admin\ReportController::class, 'index'])->name('index');
        Route::get('/export', [Admin\ReportController::class, 'export'])->name('export');
    });

    // Staff management (director only)
    Route::prefix('staff')->name('staff.')->middleware('role:director')->group(function () {
        Route::get('/', [Admin\StaffController::class, 'index'])->name('index');
        Route::post('/', [Admin\StaffController::class, 'store'])->name('store');
        Route::put('/{user}', [Admin\StaffController::class, 'update'])->name('update');
        Route::delete('/{user}', [Admin\StaffController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Auth redirect after login (role-based)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole(['director', 'manager', 'staff'])) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('portal.dashboard');
})->name('dashboard');

require __DIR__.'/auth.php';
