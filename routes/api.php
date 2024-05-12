<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\TwoFactorController;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('email_verification',[EmailVerificationController::class,'email_verification']);
    Route::get('email_verification',[EmailVerificationController::class,'sendEmailVerification']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'country'
], function ($router) {
    Route::post('addCountry', [countryController::class, 'addCountry']);
    Route::post('updateCountry/{id}', [countryController::class, 'updateCountry']);
    Route::post('deleteCountry/{id}', [countryController::class, 'deleteCountry']);
    Route::post('searchCountry/{name}', [countryController::class, 'searchCountry']);
    Route::post('getCountry/{id}', [countryController::class, 'getCountry']);
    Route::get('getAllCountries',[countryController::class,'getAllCountries']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'city'
], function ($router) {
    Route::post('addCity', [cityController::class, 'addCity']);
    Route::post('updateCity/{id}', [cityController::class, 'updateCity']);
    Route::post('deleteCity/{id}', [cityController::class, 'deleteCity']);
    Route::post('searchCity/{name}', [cityController::class, 'searchCity']);
    Route::post('getCity/{id}', [cityController::class, 'getCity']);
    Route::get('getAllCities',[cityController::class,'getAllCities']);
});
