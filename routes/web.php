<?php

use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ListingController::class, 'index'])->name('home');

Route::get('/listing/{listingId}', [ListingController::class, 'show'])->name('listing');
