<?php

use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;


//All Listing
Route::get('/', [ListingController::class, 'index']);

//Create Listing
Route::get('/listings/create', [ListingController::class, 'create']);

//Single Listing
Route::get('/listing/{listingId}', [ListingController::class, 'show']);

//Store Listing
Route::post('/listings', [ListingController::class, 'store']);
