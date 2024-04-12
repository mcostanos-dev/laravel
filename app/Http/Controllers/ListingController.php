<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

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
                'listings' => Listing::all()
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
}
