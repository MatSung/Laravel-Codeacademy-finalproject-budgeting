<?php

use App\Http\Controllers\EntryCategoryController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\EntrySubcategoryController;
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
Route::apiResource('/categories', EntryCategoryController::class)->parameters([
    'categories' => 'entry_category'
]);
Route::apiResource('/subcategories', EntrySubcategoryController::class)->parameters([
    'subcategories' => 'entry_subcategory'
]);