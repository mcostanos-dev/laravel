<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//All Listing
Route::get('/', [ListingController::class, 'index']);

//Create Listing
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Show Edit Form
Route::get('listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Delete Listing
Route::delete('listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//update Form
Route::put('listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Single Listing
Route::get('/listing/{listingId}', [ListingController::class, 'show']);

//Store Listing
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//Show Registration Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//Create User
Route::post('/users', [UserController::class, 'store']);

//logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//login
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//login
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
