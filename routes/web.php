<?php

use App\Http\Controllers\AgencyController;
use App\Http\Middleware\EnsureAgencyHasProfile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;


Route::get('/',[HomeController::class, 'display']) ->name('home.display');

Route::get('/register', [RegisterController::class, 'display'])->name('register');
Route::post('/register', [RegisterController::class, 'registerUser'])->name('user.add');

Route::get('/login', [LoginController::class, 'display'])->name('login');
Route::post('/login', [LoginController::class, 'loginUser'])->name('login.post');


Route::get('/tour', [TourController::class, 'displayTour'])->name('tour.index');



Route::middleware(['auth'])->group(function () {

    Route::get('/home', function () { return view('home'); });

    Route::get('/my-account', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/my-trips', function() { return view('my-trips'); })->name('tourist.trips');
    Route::get('/agency/setup', [AgencyController::class, 'create'])->name('agency.setup')->middleware('auth');
});

// Rutas exclusivas de Agencia
Route::middleware(['auth', EnsureAgencyHasProfile::class])->group(function () {
    Route::get('/places', [PlaceController::class, 'display'])->name('places.index');
    Route::post('/places', [PlaceController::class, 'processSelection'])->name('places.add');

    Route::get('/create-tour', [CategoryController::class, 'display'])->name('tour.create');
    Route::post('/create-tour', [TourController::class, 'add'])->name('tour.store');

    Route::get('/my-tours', [TourController::class, 'display'])->name('agency.index');


    Route::get('/payment', function () { return view('payment'); });
    Route::post('payment', [PaymentController::class, 'managePay']) ->name('payment.manage');
});
