<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RestaurantController;
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
    Route::post('addCountry', [CountryController::class, 'addCountry'])->middleware('auth');
    Route::post('updateCountry/{id}', [CountryController::class, 'updateCountry']);
    Route::post('deleteCountry/{id}', [CountryController::class, 'deleteCountry']);
    Route::post('searchCountry/{name}', [CountryController::class, 'searchCountry']);
    Route::post('getCountry/{id}', [CountryController::class, 'getCountry']);
    Route::get('getAllCountries',[CountryController::class,'getAllCountries']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'city'
], function ($router) {
    Route::post('addCity', [CityController::class, 'addCity']);
    Route::post('updateCity/{id}', [CityController::class, 'updateCity']);
    Route::post('deleteCity/{id}', [CityController::class, 'deleteCity']);
    Route::post('searchCity/{name}', [CityController::class, 'searchCity']);
    Route::post('getCity/{id}', [CityController::class, 'getCity']);
    Route::get('getAllCities',[CityController::class,'getAllCities']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'facility'
], function ($router) {
    Route::post('addFacility', [FacilityController::class, 'addFacility']);
    Route::post('updateFacility/{id}', [FacilityController::class, 'updateFacility']);
    Route::post('deleteFacility/{id}', [FacilityController::class, 'deleteFacility']);
    Route::post('searchFacility/{name}', [FacilityController::class, 'searchFacility']);
    Route::post('getFacility/{id}', [FacilityController::class, 'getFacility']);
    Route::get('getAllFacility',[FacilityController::class,'getAllFacility']);
    Route::post('getFacilityByCity/{id}', [FacilityController::class, 'getFacilityByCity']);

});
Route::group([
    'middleware' => 'api',
    'prefix' => 'hotel'
], function ($router) {
    Route::post('addHotel', [HotelController::class, 'addHotel']);
    Route::post('updateHotel/{id}', [HotelController::class, 'updateHotel']);
    Route::post('deleteHotel/{id}', [HotelController::class, 'deleteHotel']);
    Route::post('searchHotel/{name}', [HotelController::class, 'searchHotel']);
    Route::post('getHotel/{id}', [HotelController::class, 'getHotel']);
    Route::get('getAllHotel',[HotelController::class,'getAllHotel']);
    Route::post('getHotelByCity/{id}', [HotelController::class, 'getHotelByCity']);

});
Route::group([
    'middleware' => 'api',
    'prefix' => 'restaurant'
], function ($router) {
    Route::post('addRestaurant', [RestaurantController::class, 'addRestaurant']);
    Route::post('updateRestaurant/{id}', [RestaurantController::class, 'updateRestaurant']);
    Route::post('deleteRestaurant/{id}', [RestaurantController::class, 'deleteRestaurant']);
    Route::post('searchRestaurant/{name}', [RestaurantController::class, 'searchRestaurant']);
    Route::post('getRestaurant/{id}', [RestaurantController::class, 'getRestaurant']);
    Route::get('getAllRestaurant',[RestaurantController::class,'getAllRestaurant']);
    Route::post('getRestaurantByCity/{id}', [RestaurantController::class, 'getRestaurantByCity']);

});
