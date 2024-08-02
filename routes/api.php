<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TransportationCompanyController;
use App\Http\Controllers\TripController;
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
    Route::get('/user-profile', [AuthController::class, 'userProfile'])->middleware('auth');
    Route::post('/updateWallet/{id}', [AuthController::class, 'updateWallet'])->middleware('auth');
    Route::post('email_verification', [EmailVerificationController::class, 'email_verification']);
    Route::get('email_verification', [EmailVerificationController::class, 'sendEmailVerification']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'country'
], function ($router) {
    Route::post('addCountry', [CountryController::class, 'addCountry'])->middleware('auth');
    Route::post('updateCountry/{id}', [CountryController::class, 'updateCountry'])->middleware('auth');
    Route::post('deleteCountry/{id}', [CountryController::class, 'deleteCountry'])->middleware('auth');
    Route::post('searchCountry/{name}', [CountryController::class, 'searchCountry'])->middleware('auth');
    Route::post('getCountry/{id}', [CountryController::class, 'getCountry'])->middleware('auth');
    Route::get('getAllCountries', [CountryController::class, 'getAllCountries'])->middleware('auth');
    Route::post('updatePhoto/{id}', [CountryController::class, 'updatePhoto'])->middleware('auth');

});
Route::group([
    'middleware' => 'api',
    'prefix' => 'city'
], function ($router) {
    Route::post('addCity', [CityController::class, 'addCity'])->middleware('auth');
    Route::post('updateCity/{id}', [CityController::class, 'updateCity'])->middleware('auth');
    Route::post('deleteCity/{id}', [CityController::class, 'deleteCity'])->middleware('auth');
    Route::post('searchCity/{name}', [CityController::class, 'searchCity'])->middleware('auth');
    Route::post('getCity/{id}', [CityController::class, 'getCity'])->middleware('auth');
    Route::get('getAllCities', [CityController::class, 'getAllCities'])->middleware('auth');
    Route::post('updatePhoto/{id}', [CityController::class, 'updatePhoto'])->middleware('auth');

});
Route::group([
    'middleware' => 'api',
    'prefix' => 'facility'
], function ($router) {
    Route::post('addFacility', [FacilityController::class, 'addFacility'])->middleware('auth');
    Route::post('updateFacility/{id}', [FacilityController::class, 'updateFacility'])->middleware('auth');
    Route::post('deleteFacility/{id}', [FacilityController::class, 'deleteFacility'])->middleware('auth');
    Route::post('searchFacility/{name}', [FacilityController::class, 'searchFacility'])->middleware('auth');
    Route::post('getFacility/{id}', [FacilityController::class, 'getFacility']);
    Route::get('getAllFacility', [FacilityController::class, 'getAllFacility']);
    Route::post('getFacilityByCity/{id}', [FacilityController::class, 'getFacilityByCity'])->middleware('auth');
    Route::post('updatePhoto/{id}', [FacilityController::class, 'updatePhoto']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'hotel'
], function ($router) {
    Route::post('addHotel', [HotelController::class, 'addHotel'])->middleware('auth');
    Route::post('updateHotel/{id}', [HotelController::class, 'updateHotel'])->middleware('auth');
    Route::post('deleteHotel/{id}', [HotelController::class, 'deleteHotel'])->middleware('auth');
    Route::post('searchHotel/{name}', [HotelController::class, 'searchHotel'])->middleware('auth');
    Route::post('getHotel/{id}', [HotelController::class, 'getHotel'])->middleware('auth');
    Route::get('getAllHotel', [HotelController::class, 'getAllHotel'])->middleware('auth');
    Route::post('getHotelByCity/{id}', [HotelController::class, 'getHotelByCity'])->middleware('auth');
    Route::post('updatePhoto/{id}', [HotelController::class, 'updatePhoto'])->middleware('auth');


});
Route::group([
    'middleware' => 'api',
    'prefix' => 'restaurant'
], function ($router) {
    Route::post('addRestaurant', [RestaurantController::class, 'addRestaurant'])->middleware('auth');
    Route::post('updateRestaurant/{id}', [RestaurantController::class, 'updateRestaurant'])->middleware('auth');
    Route::post('deleteRestaurant/{id}', [RestaurantController::class, 'deleteRestaurant'])->middleware('auth');
    Route::post('searchRestaurant/{name}', [RestaurantController::class, 'searchRestaurant'])->middleware('auth');
    Route::post('getRestaurant/{id}', [RestaurantController::class, 'getRestaurant'])->middleware('auth');
    Route::get('getAllRestaurant', [RestaurantController::class, 'getAllRestaurant'])->middleware('auth');
    Route::post('getRestaurantByCity/{id}', [RestaurantController::class, 'getRestaurantByCity'])->middleware('auth');
    Route::post('updatePhoto/{id}', [RestaurantController::class, 'updatePhoto'])->middleware('auth');

});
Route::group([
    'middleware' => 'api',
    'prefix' => 'company'
], function ($router) {
    Route::post('addCompany', [TransportationCompanyController::class, 'addCompany'])->middleware('auth');
    Route::post('updateCompany/{id}', [TransportationCompanyController::class, 'updateCompany'])->middleware('auth');
    Route::post('deleteCompany/{id}', [TransportationCompanyController::class, 'deleteCompany'])->middleware('auth');
    Route::post('searchCompany/{name}', [TransportationCompanyController::class, 'searchCompany'])->middleware('auth');
    Route::post('getCompany/{id}', [TransportationCompanyController::class, 'getCompany'])->middleware('auth');
    Route::get('getAllCompany', [TransportationCompanyController::class, 'getAllCompany'])->middleware('auth');
    Route::post('updatePhoto/{id}', [TransportationCompanyController::class, 'updatePhoto'])->middleware('auth');

});
Route::group([
    'middleware' => 'api',
    'prefix' => 'trip'
], function ($router) {
    Route::post('addTrip', [TripController::class, 'addTrip'])->middleware('auth');
    Route::post('updateTrip/{id}', [TripController::class, 'updateTrip'])->middleware('auth');
    Route::post('deleteTrip/{id}', [TripController::class, 'deleteTrip'])->middleware('auth');
    Route::post('getTrip/{id}', [TripController::class, 'getTrip'])->middleware('auth');
    Route::get('getAllTrips', [TripController::class, 'getAllTrips'])->middleware('auth');
    Route::post('updatePhoto/{id}', [TripController::class, 'updatePhoto'])->middleware('auth');
    Route::get('getAdminTrips', [TripController::class, 'getAdminTrips'])->middleware('auth');
    Route::get('getUserTrips', [TripController::class, 'getUserTrips'])->middleware('auth');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'activity'
], function ($router) {
    Route::post('addActivity', [ActivityController::class, 'addActivity'])->middleware('auth');
    Route::post('updateActivity/{id}', [ActivityController::class, 'updateActivity'])->middleware('auth');
    Route::post('deleteActivity/{id}', [ActivityController::class, 'deleteActivity'])->middleware('auth');
    Route::post('getActivity/{id}', [ActivityController::class, 'getActivity'])->middleware('auth');
    Route::post('getTripActivity/{id}', [ActivityController::class, 'getTripActivity'])->middleware('auth');

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'booking'
], function ($router) {
    Route::post('addBook', [BookingController::class, 'addBook'])->middleware('auth');
    Route::post('updateBook/{id}', [BookingController::class, 'updateBook'])->middleware('auth');
    Route::post('getUserBook/{id}', [BookingController::class, 'getUserBook'])->middleware('auth');
    Route::get('getAllUserBookings', [BookingController::class, 'getAllUserBookings'])->middleware('auth');
    Route::get('getAllBookings', [BookingController::class, 'getAllBookings'])->middleware('auth');

    Route::post('deleteBook/{id}', [BookingController::class, 'deleteBook'])->middleware('auth');

});
