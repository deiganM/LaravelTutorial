<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Need to bring in the model I want to use
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing

// basic workflow of a new feature
//  - new route, new controller method, new view

// LISTING CONTROLLER ROUTES
// All listings
Route::get('/', [ListingController::class, 'index']);


// Show Create Form,
//  add '->middleware('auth');' to anywhere you don't want guests to access. LOGGED IN MEMBERS ONLY
Route::get('/listings/create', [ListingController::class, 'create'])
    ->middleware('auth');

// Store listing data
Route::post('/listings', [ListingController::class, 'store'])
    ->middleware('auth');

// Show Edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])
    ->middleware('auth');   

// Update listing. THIS IS AN ENDPOINT /listings/{listing}
Route::put('/listings/{listing}', [ListingController::class, 'update'])
    ->middleware('auth');

// Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])
    ->middleware('auth');

// Single listing
// WILDCARD ROUTES TO THE BOTTOM! WILDCARD PART CAUSES ISSUES
    // could not find </listings/create>
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// USER CONTROLLER ROUTES
// Show Register/Create form
Route::get('/register', [UserController::class, 'create'])
    // only access this if you are a guest
    ->middleware('guest');

// Create New User
Route::post('/users', [UserController::class, 'store']);

// Logout user
Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth');

// show login form. ->name('login') has to do with middleware/authenticate.php redirectTo()
Route::get('/login', [UserController::class, 'login'])
    ->name('login')
    ->middleware('guest');

// Log in User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);