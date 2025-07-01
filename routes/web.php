<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AuctionController as AdminAuctionController; // Alias for clarity
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\DashboardController; // This import is important
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application.
|--------------------------------------------------------------------------
*/

// SECTION 1: GUEST & PUBLIC ROUTES
//==========================================================================

// The main welcome/login page.
Route::get('/', function () {
    return view('welcome');
})->middleware('guest')->name('welcome');

// Laravel's default authentication routes (e.g., /login, /logout).
Auth::routes(['register' => false]);

// Social Login Routes
Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('socialite.redirect');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('socialite.callback');


// SECTION 2: USER-FACING AUCTION ROUTES
//==========================================================================

// Shows a list of all active auctions.
Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');

// Shows the detail page for a single auction.
Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');

// Handles the form submission for placing a bid.
Route::post('/auctions/{auction}/bids', [BidController::class, 'store'])->middleware('auth')->name('bids.store');


// SECTION 3: GENERAL AUTHENTICATED ROUTES
//==========================================================================

Route::middleware(['auth'])->group(function () {
    // THIS ROUTE IS NOW CORRECTED to point to the DashboardController.
    // The controller will fetch the user's active bids and won auctions.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


// SECTION 4: PROTECTED ADMIN ROUTES
//==========================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Routes for creating and managing auctions
    Route::get('/auctions/create/{book}', [AdminAuctionController::class, 'create'])->name('auctions.create');
    Route::post('/auctions', [AdminAuctionController::class, 'store'])->name('auctions.store');
    Route::patch('/auctions/{auction}/close', [AdminAuctionController::class, 'close'])->name('auctions.close');
});