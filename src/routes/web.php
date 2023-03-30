<?php

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\EntryController;
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

Route::get('/', function (): RedirectResponse {
    return redirect(route('entries.index'));
});

Route::resource('/dashboard', EntryController::class,[
    'names' => [
        'index' => 'entries.index',
        'store' => 'entries.store',
        'show' => 'entries.show',
        'destroy' => 'entries.destroy',
        'update' => 'entries.update'
    ]
])->except(['edit','create']);
