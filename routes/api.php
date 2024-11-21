<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UrlShortenerController;
use Illuminate\Support\Facades\Route;
/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

    Route::post('url', [UrlShortenerController::class, 'store']);
    Route::get('url', [UrlShortenerController::class, 'index']);
    Route::delete('url/{id}', [UrlShortenerController::class, 'delete']);

    Route::get('/{code}', [UrlShortenerController::class, 'show']);
