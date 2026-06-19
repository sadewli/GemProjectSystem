<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaUploadController;

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

// Media Upload Routes
Route::post('/upload-photos', [MediaUploadController::class, 'uploadPhotos']);
Route::post('/upload-video', [MediaUploadController::class, 'uploadVideo']);
Route::delete('/delete-photo', [MediaUploadController::class, 'deletePhoto']);
Route::delete('/delete-video', [MediaUploadController::class, 'deleteVideo']);

// 360° View Routes
Route::post('/upload-360view', [MediaUploadController::class, 'upload360View']);
Route::delete('/delete-360view', [MediaUploadController::class, 'delete360View']);

// Create New Certificate Lab
Route::post('/create-certificate-lab', [MediaUploadController::class, 'createCertificateLab']);

// Create New Photo Type
Route::post('/create-photo-type', [MediaUploadController::class, 'createPhotoType']);
