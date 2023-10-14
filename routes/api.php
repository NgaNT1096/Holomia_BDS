<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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
Route::post('/post/create', [PostController::class,'store']);
Route::get('/post/edit/{id}', [PostController::class,'edit']);
Route::post('/post/update/{id}', [PostController::class,'update']);
Route::delete('/post/delete/{id}',[PostController::class,'delete']);
Route::get('/posts',[PostController::class,'index']);
