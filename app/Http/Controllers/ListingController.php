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

    //Create Listing
    public function edit(Listing $listing)
    {

        return view('listings.edit', ['listing' => $listing]);
    }

    //Delete Listing
    public function destroy(Listing $listing)
    {
        $listing->delete();
        return redirect('/')->with('message', "Succesfully deleted");
    }

    //Update Listing
    public function update(Request $request, Listing $listing)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validatedData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($validatedData);

        return back()->with('message', 'Listing Updated successfully!');
    }

    //Store Listing
    public function store(Request $request)
    {
        // Validate form fields
        $validatedData = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validatedData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $validatedData['user_id'] = auth()->user()->id;


        // Create new listing
        Listing::create($validatedData);

        // Redirect back with success message
        return redirect('/')->with('message', 'Listing created successfully!');
    }
}
