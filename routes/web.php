<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Models\Appointment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Models\Service;
use Intervention\Image\Facades\Image;


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

Route::get('/', function () {
    return redirect('/login');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/appointments', [AppointmentController::class, 'index'])
->middleware(['auth'])
->name('appointments.index');
Route::get('/appointments/create', [AppointmentController::class, 'create'])
->middleware(['auth'])
->name('appointments.create');
Route::get('/appointments', [AppointmentController::class, 'store'])
->middleware(['auth'])
->name('appointments.store');
Route::patch('/appointments/{appointment}/complete', [AppointmentController::class, 'complete'])
->name('appointments.complete');
Route::patch('/appointments/{appointment}/cancel', 
    [AppointmentController::class, 'cancel'])
    ->name('appointments.cancel');
Route::post('/dashboard-action', [DashboardController::class, 'someAction'])
     ->name('dashboard.action');

Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::post('/notifications/mark-read', function() {
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['status' => 'success']);
})->name('notifications.markRead');


Route::get('/services', [ServiceController::class, 'index'])
->middleware(['auth', 'admin'])
->name('services.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('services',ServiceController::class);
    Route::resource('appointments', AppointmentController::class);
});

// Only admin can access services routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::patch('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
});

Route::middleware(['auth','admin'])->group(function () {

    Route::get('/admin/settings', [SettingController::class, 'edit'])
        ->name('admin.settings.edit');

    Route::post('/admin/settings', [SettingController::class, 'update'])
        ->name('admin.settings.update');

});

Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/resize-images', function () {
    $services = Service::whereNotNull('image')->get();
    foreach ($services as $service) {
        $imagePath = public_path('images/' . $service->image);
        if (file_exists($imagePath)) {
            try {
                Image::make($imagePath)
                     ->fit(128, 128)
                     ->save($imagePath);  // Overwrites with resized version
            } catch (\Exception $e) {
                // Log error if needed: Log::error('Image resize failed: ' . $e->getMessage());
            }
        }
    }
    return 'All images resized to 128x128px!';
});
require __DIR__.'/auth.php';
