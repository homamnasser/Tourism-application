<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    /*
اضافة دولة
    */

    public function addCountry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:countries',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $country = Country::create(
            $validator->validated()
        );

        return response()->json([
                'code' => '0',
                'message' => 'Country added successfully ',
                'result' => [
                    'country_name' => $country->name,
                    'description' => $country->description,
                ]
            ]
            , 201);
    }

    /*
تعديل معلومات الدولة
    */

    public function updateCountry(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:countries',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {

            return response()->json($validator->errors()->toJson(), 400);
        }

        $country = Country::find($id);

        if (!$country) {
            return response()->json([
                'message' => 'Country not found',
            ], 404);

        }


        $country->update($request->all());

        return response()->json([
                'code' => '0',
                'message' => 'Country added successfully ',
                'result' => [
                    'country_name' => $country->name,
                    'description' => $country->description,
                ]
            ]
            , 201);
    }

    /*
        حذف الدولة
    */
    public function deleteCountry($id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json([
                'message' => 'Country not found',
            ], 404);
        }


        $country->delete();

        return response()->json([
            'message' => 'Country deleted successfully ',
        ], 201);

    }

    /*
    البحث حسب اسم الدولة
    */
    public function searchCountry($name)
    {

        $country = Country::where('name', 'like', '%' . $name . '%')->get();
        $countries = [];

        foreach ($country as $data) {

            array_push($countries, [
                'name' => $data->name,
                'description' => $data->description
            ]);
        }

        if ($country->isEmpty()) {
            return response()->json([
                'message' => 'Country not found',
            ], 404);
        }

        return response()->json([
                'code' => '0',
                'message' => 'Country as name',
                'result' => [
                    'data' => $countries,
                ]

            ]
            , 201);
    }


    /*
    عرض المدينة
    */
    public function getCountry($id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json([
                'message' => 'Country not found',
            ], 404);
        }
        return response()->json([
                'code' => '0',
                'message' => 'This is Country ',
                'result' => [
                    'country_name' => $country->name,
                    'description' => $country->description
                ]
            ]
            , 201);
    }

    /*
     عرض كل الدول
    */
    public function getAllCountries()
    {
        $countries = [];

        $data = Country::all();
        foreach ($data as $data1) {

            array_push($countries, [
                'name' => $data1->name,
                'description' => $data1->description
            ]);
        }

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Countries not found',
            ], 404);
        }
        return response()->json([
                'code' => '0',
                'message' => 'All countries',
                'result' => [
                    'country' => $countries,
                ]
            ]
            , 201);
    }
}
