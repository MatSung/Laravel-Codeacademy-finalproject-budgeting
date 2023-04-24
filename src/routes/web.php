<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\EntryCategoryController;
use App\Http\Controllers\EntrySubcategoryController;
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

Route::Get('/dashboard', DashboardController::class)->name('dashboard');

Route::resource('/entries', EntryController::class, [
    'names' => [
        'index' => 'entries.index',
        'store' => 'entries.store',
        'show' => 'entries.show',
        'destroy' => 'entries.destroy',
        'update' => 'entries.update'
    ]
])->except(['save', 'edit']);

Route::resource('/categories', EntryCategoryController::class, [
    'names' => [
        'index' => 'categories.index',
        'store' => 'categories.store',
        'show' => 'categories.show',
        'destroy' => 'categories.destroy',
        'update' => 'categories.update'
    ]
])->except(['save', 'edit']);

Route::resource('/subcategories', EntrySubcategoryController::class, [
    'names' => [
        'index' => 'subcategories.index',
        'store' => 'subcategories.store',
        'show' => 'subcategories.show',
        'destroy' => 'subcategories.destroy',
        'update' => 'subcategories.update'
    ]
])->except(['save', 'edit']);

Route::get('/about', function () {
    return Inertia::render('Budgeting/About');
});
