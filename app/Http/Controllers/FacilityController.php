<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FacilityController extends Controller
{
    /*
    * اضافة منشأة
    * */
    public function addFacility(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
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
        $facility = Facility::create(
            $validator->validated()
        );

        return response()->json([
            'code' => '0',
            'message' => 'Facility added successfully ',
            'result' => [
                'facility_name' => $facility->name,
                'city_name' => $facility->city->name,
                'country_name' => $facility->city->country->name,
                'description' => $facility->description,

            ]
        ], 201);
    }

    /*
     * تعديل معلومات المنشأة
    */

    public function updateFacility(Request $request, $id)
    {
        $facility = Facility::find($id);
        if (!$facility) {
            return response()->json([
                'message' => 'Facility not found'
            ], 400);

        }
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'description' => 'string',
            'city_id' => 'integer'
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
        $facility->update($request->all());


        return response()->json([
                'message' => 'City updated successfully ',
                'result' => [
                    'name' => $facility->name,
                    'city_name' => $facility->city->name,
                    'country_name' => $facility->city->country->name,
                    'description' => $facility->description,

                ]
            ]
            , 201);
    }

    /*
    حذف منشأة
    */
    public function deleteFacility($id)
    {
        $facility = Facility::find($id);

        if (!$facility) {
            return response()->json([
                'message' => 'Facility not found',
            ], 404);
        }


        $facility->delete();

        return response()->json([
            'message' => 'Facility deleted successfully ',
        ], 201);

    }

    public function searchFacility($name)
    {

        $facility = Facility::where('name', 'like', '%' . $name . '%')->get();
        $facilities = [];
        foreach ($facility as $data) {

            array_push($facilities, [
                'name' => $data->name,
                'description' => $data->description,
                'city_name' => $data->city->name,
                'country_name' => $data->city->country->name,
            ]);
        }

        if ($facility->isEmpty()) {
            return response()->json([
                'message' => 'Facility not found',
            ], 404);
        }


        return response()->json([
                'message' => 'Facility as name ',
                'result' => [
                    'data' => $facilities,
                ]
            ]
            , 201);
    }

    /*
         عرض المنشأة
     */
    public function getFacility($id)
    {
        $facility = Facility::find($id);
        if (!$facility) {
            return response()->json([
                'message' => 'Facility not found',
            ], 404);
        }
        return response()->json([
                'code' => '0',
                'message' => 'This is Facility ',
                'result' => [
                    'facility_name' => $facility->name,
                    'description' => $facility->description,
                    'city_name' => $facility->city->name,
                    'country_name' => $facility->city->country->name,
                ]
            ]
            , 201);
    }

    /*
   عرض كل المدن
  */
    public function getAllFacility()
    {
        $facilities = [];
        $data = Facility::get();
        foreach ($data as $data1) {

            array_push($facilities, [
                'name' => $data1->name,
                'description' => $data1->description,
                'city_name' => $data1->city->name,
                'country_name' => $data1->city->country->name,
            ]);
        }

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'facilities not found',
            ], 404);
        }
        return response()->json([
                'code' => '0',
                'message' => 'All facilities',
                'result' => [
                    'country' => $facilities,
                ]
            ]
            , 201);
    }

}
