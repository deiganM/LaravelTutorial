<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // Show all listings
    // Dependency Injection way -> Request $request
    // public function index(Request $request) {
    //     dd($request);
    //     return view('listings.index', [
    //         // 'Listing' is coming from the DB, then the all() method
    //         'listings' => Listing::all()
    //     ]);
    // }
    // OR, you can use the request helper function
    public function index() {
        return view('listings.index', [
            // 'Listing' is coming from the DB, then the all() method
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
        ]);
    }
    // Show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }
}
