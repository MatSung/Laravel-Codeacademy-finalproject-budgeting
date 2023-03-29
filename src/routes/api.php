<?php

use App\Http\Controllers\Api\EntryCategoryController;
use App\Http\Controllers\Api\EntryController;
use App\Http\Controllers\Api\EntrySubcategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/entries', EntryController::class);
Route::apiResource('/categories', EntryCategoryController::class,[
    'names' => [
        'store' => 'apiEntry.store',
        'index' => 'apiEntry.index',
        'show' => 'apiEntry.show',
        'update' => 'apiEntry.update',
        'destroy' => 'apiEntry.destroy'
    ]
])->parameters([
    'categories' => 'entry_category'
]);
Route::apiResource('/subcategories', EntrySubcategoryController::class)->parameters([
    'subcategories' => 'entry_subcategory'
]);

