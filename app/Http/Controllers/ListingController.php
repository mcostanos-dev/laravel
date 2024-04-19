<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //index- all
    //show- single
    //create - create new
    //store - store new
    //update - update
    //destroy - destroy

    //Show all listing
    public function index()
    {
        // dd(Listing::latest()->filter(request(['tag', 'search']))->paginate(2));
        return view(
            'listings.index',
            [
                'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
            ]
        );
    }

    //Single Listing
    public function show(Listing $listingId)
    {
        return view(
            'listings.show',
            [
                'listing' => $listingId
            ]
        );
    }

    //Create Listing
    public function create()
    {
        return view('listings.create');
    }

    //Store Listing
    public function store(Request $request)
    {

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file(('logo'))->store('logos', 'public');
        }

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created succesfully!');
    }
}
