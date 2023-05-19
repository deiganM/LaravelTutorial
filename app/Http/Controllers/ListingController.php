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
            // 'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
            // showing 2 items per page with paginate
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6) // simplePaginate
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

        // have to run artisan command <php artisan storage:link> to create a simlink from the public storage folder
        // to public folder? after this you can search for photos in url /storage/logos/<logo string from DB>
        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public'); // this is creating a folder named 'logos'?
        }

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!
        ');
    }
}
