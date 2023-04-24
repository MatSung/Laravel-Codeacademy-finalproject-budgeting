<?php

use App\Http\Controllers\Api\ApiEntryCategoryController;
use App\Http\Controllers\Api\ApiEntryController;
use App\Http\Controllers\Api\ApiEntrySubcategoryController;
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

Route::apiResource('/entries', ApiEntryController::class,[
    'names' => [
        'store' => 'apiEntries.store',
        'index' => 'apiEntries.index',
        'show' => 'apiEntries.show',
        'update' => 'apiEntries.update',
        'destroy' => 'apiEntries.destroy'
    ]
]);
Route::apiResource('/categories', ApiEntryCategoryController::class,[
    'names' => [
        'store' => 'apiEntryCategories.store',
        'index' => 'apiEntryCategories.index',
        'show' => 'apiEntryCategories.show',
        'update' => 'apiEntryCategories.update',
        'destroy' => 'apiEntryCategories.destroy'
    ]
]);
Route::apiResource('/subcategories', ApiEntrySubcategoryController::class);

