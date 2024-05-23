<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Facility;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /*
    * اضافة فندق
    * */
    public function addHotel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'availability' => 'required|integer',
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
        $hotel = Hotel::create(
            $validator->validated()
        );

        return response()->json([
            'code' => '0',
            'message' => 'Hotel added successfully ',
            'result' => [
                'hotel_name' => $hotel->name,
                'description' => $hotel->description,
                'price' => $hotel->price,
                'availability' => $hotel->availability,
                'city_name' => $hotel->city->name,
                'country_name' => $hotel->city->country->name,

            ]
        ], 201);
    }

    /*
     * تعديل معلومات الفندق
    */

    public function updateHotel(Request $request, $id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) {
            return response()->json([
                'message' => 'Hotel not found'
            ], 400);

        }
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'description' => 'string',
            'price' => 'integer',
            'availability' => 'integer',
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
        $hotel->update($request->all());


        return response()->json([
                'message' => 'Hotel updated successfully ',
                'result' => [
                    'hotel_name' => $hotel->name,
                    'description' => $hotel->description,
                    'price' => $hotel->price,
                    'availability' => $hotel->availability,
                    'city_name' => $hotel->city->name,
                    'country_name' => $hotel->city->country->name,

                ]
            ]
            , 201);
    }

    /*
    حذف فندق
    */
    public function deleteHotel($id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json([
                'message' => 'Hotel not found',
            ], 404);
        }

        $hotel->delete();

        return response()->json([
            'message' => 'Hotel deleted successfully ',
        ], 201);

    }
    /*
     * البحث عن فندق*/
    public function searchHotel($name)
    {

        $hotel = Hotel::where('name', 'like', '%' . $name . '%')->get();
        $hotels = [];
        foreach ($hotel as $data) {

            array_push($hotels, [
                'name' => $data->name,
                'description' => $data->description,
                'city_name' => $data->city->name,
                'country_name' => $data->city->country->name,
            ]);
        }

        if ($hotel->isEmpty()) {
            return response()->json([
                'message' => 'Hotel not found',
            ], 404);
        }


        return response()->json([
                'message' => 'Hotel as name ',
                'result' => [
                    'data' => $hotels,
                ]
            ]
            , 201);
    }
    /*
     عرض الفندق
 */
    public function getHotel($id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) {
            return response()->json([
                'message' => 'Hotel not found',
            ], 404);
        }
        return response()->json([
                'code' => '0',
                'message' => 'This is Hotel ',
                'result' => [
                    'facility_name' => $hotel->name,
                    'description' => $hotel->description,
                    'city_name' => $hotel->city->name,
                    'country_name' => $hotel->city->country->name,
                ]
            ]
            , 201);
    }

    /*
   عرض كل الفنادق
  */
    public function getAllHotel()
    {
        $hotels = [];
        $data = Hotel::get();
        foreach ($data as $data1) {

            array_push($hotels, [
                'name' => $data1->name,
                'description' => $data1->description,
                'city_name' => $data1->city->name,
                'country_name' => $data1->city->country->name,
            ]);
        }

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Hotel not found',
            ], 404);
        }
        return response()->json([
                'code' => '0',
                'message' => 'All hotels',
                'result' => [
                    'country' => $hotels,
                ]
            ]
            , 201);
    }
}
