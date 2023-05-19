<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
    // show Create Form
    public function create() {
        return view('listings.create');
    }
    // store listing data
    public function store(Request $request) {
        $formFields = $request->validate([
            // validation of form fields (submission)
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        Listing::create($formFields);

        return redirect('/');
    }
}
