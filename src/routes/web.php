<?php

// DONT FORGET TO REMOVE THIS
use App\Models\Entry;
////////////////////////////

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Budgeting/Dashboard',[
        'entries' => Entry::all()->toArray()
    ]);
});

Route::get('/tester', function() {
    return(asset('storage/public/edit.svg'));
});
