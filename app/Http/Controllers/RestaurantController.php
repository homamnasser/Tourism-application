<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Hotel;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    /*
    * اضافة مطعم
    * */
    public function addRestaurant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'food_type' => 'required|string',
            'city_id' => 'required|integer',
        ]);
        $city = City::find($request->city_id);
        if (!$city) {
            return response()->json([
                'message' => 'city not found'
            ], 400);

        }
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $restaurant = Restaurant::create(
            $validator->validated()
        );

        return response()->json([
            'code' => '0',
            'message' => 'Restaurant added successfully ',
            'result' => [
                'restaurant_name' => $restaurant->name,
                'description' => $restaurant->description,
                'price' => $restaurant->price,
                'food_type' => $restaurant->food_type,
                'city_name' => $restaurant->city->name,
                'country_name' => $restaurant->city->country->name,

            ]
        ], 201);
    }

    /*
    * تعديل معلومات المطعم
   */

    public function updateRestaurant(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return response()->json([
                'message' => 'Restaurant not found'
            ], 400);

        }
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'description' => 'string',
            'price' => 'integer',
            'food_type' => 'string',
            'city_id' => 'integer',
        ]);
        $city = City::find($request->city_id);
        if (!$city) {
            return response()->json([
                'message' => 'city not found'
            ], 400);
        }


        if ($validator->fails()) {

            return response()->json($validator->errors()->toJson(), 400);
        }
        $restaurant->update($request->all());


        return response()->json([
                'message' => 'Hotel updated successfully ',
                'result' => [
                    'restaurant_name' => $restaurant->name,
                    'description' => $restaurant->description,
                    'price' => $restaurant->price,
                    'food_type' => $restaurant->food_type,
                    'city_name' => $restaurant->city->name,
                    'country_name' => $restaurant->city->country->name,

                ]
            ]
            , 201);
    }

    /*
        حذف مطعم
        */
    public function deleteRestaurant($id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return response()->json([
                'message' => 'Restaurant not found',
            ], 404);
        }

        $restaurant->delete();

        return response()->json([
            'message' => 'Restaurant deleted successfully ',
        ], 201);

    }

    /*
    * البحث عن مطعم
     * */
    public function searchRestaurant($name)
    {

        $restaurant = Restaurant::where('name', 'like', '%' . $name . '%')->get();
        $restaurants = [];
        foreach ($restaurant as $data) {

            array_push($restaurants, [
                'name' => $data->name,
                'description' => $data->description,
                'food_type' => $data->food_type,
                'city_name' => $data->city->name,
                'country_name' => $data->city->country->name,
            ]);
        }

        if ($restaurant->isEmpty()) {
            return response()->json([
                'message' => 'Restaurant not found',
            ], 404);
        }


        return response()->json([
                'message' => 'Restaurant as name ',
                'result' => [
                    'data' => $restaurants,
                ]
            ]
            , 201);
    }

    /*
     عرض الفندق
 */
    public function getRestaurant($id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return response()->json([
                'message' => 'Restaurant not found',
            ], 404);
        }
        return response()->json([
                'code' => '0',
                'message' => 'This is Restaurant ',
                'result' => [
                    'restaurant_name' => $restaurant->name,
                    'description' => $restaurant->description,
                    'food_type'=>$restaurant->food_type,
                    'city_name' => $restaurant->city->name,
                    'country_name' => $restaurant->city->country->name,
                ]
            ]
            , 201);
    }

    /*
   عرض كل الفنادق
  */
    public function getAllRestaurant()
    {
        $restaurants = [];
        $data = Restaurant::get();
        foreach ($data as $data1) {

            array_push($restaurants, [
                'name' => $data1->name,
                'description' => $data1->description,
                'food_type'=>$data1->food_type,
                'city_name' => $data1->city->name,
                'country_name' => $data1->city->country->name,
            ]);
        }

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Restaurant not found',
            ], 404);
        }
        return response()->json([
                'code' => '0',
                'message' => 'All hotels',
                'result' => [
                    'country' => $restaurants,
                ]
            ]
            , 201);
    }
/*
 * جلب المطاعم حسب المدينة
 * */
    public function getRestaurantByCity($id)
    {
        $city = City::find($id);
        if (!$city) {
            return response()->json([
                'message' => 'city not found'
            ], 400);
        }

        $restaurant = Restaurant::where('city_id', $id)->get();
        $restaurants = [];
        foreach ($restaurant as $data) {

            array_push($restaurants, [
                'name' => $data->name,
                'description' => $data->description,
                'food_type'=>$data->food_type,
                'city_name' => $data->city->name,
                'country_name' => $data->city->country->name,
            ]);
        }

        if ($restaurant->isEmpty()) {
            return response()->json([
                'message' => 'Hotel not found',
            ], 404);
        }


        return response()->json([
                'message' => 'Restaurants as city ',
                'result' => [
                    'data' => $restaurants,
                ]
            ]
            , 201);
    }
}
