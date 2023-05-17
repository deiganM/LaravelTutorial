<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Need to bring in the model I want to use
use App\Models\Listing;

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

// All listings
Route::get('/', function () {
    return view('listings', [
        // 'heading' is '$heading in the blade
        'heading' => 'Latest Listings',
        // 'Listing' is coming from the DB, then the all() method
        'listings' => Listing::all()
    ]);
});

// Single listings
// Route::get('/listings/{id}', function ($id) {
//     return view('listing', [
//         'listing' => Listing::find($id)
//     ]);
// });

// ROUTE MODEL BINDING
// function (Listing $listing) -> passing in the Listing Model, type-hinting (Listing) and a variable ($listing)
// what's in the {} of the get, should match, minus the $
Route::get('/listings/{listing}', function (Listing $listing) {
    return view('listing', [
        'listing' => $listing
    ]);
});

