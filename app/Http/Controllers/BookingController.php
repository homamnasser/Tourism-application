<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /*
       * الحجز
       * */
    public function addBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trip_id' => 'required|integer',
            'person_number' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $trip = Trip::find($request->trip_id);
        if (!$trip) {
            return response()->json([
                'message' => 'Trip not found'
            ], 400);
        }

        $user = Auth::user();

        if ($trip->capacity - $trip->current_number < $request->person_number) {
            return response()->json([
                'message' => 'There are no seats available for this number of people'
            ], 400);
        }
        $cost = $trip->cost * $request->person_number;

        if ($cost > $user->wallet) {
            return response()->json([
                'message' => 'You dont have enough money'
            ], 400);
        }
        if (Carbon::parse($trip->starting_date) < now()) {
            return response()->json([
                'message' => 'Your reservation time has expired'
            ], 400);
        }


        $booking = Booking::create([
            'trip_id' => $trip->id,
            'user_id' => $user->id,
            'person_number' => $request->person_number,
            'total_price' => $cost,

        ]);

        /*
        الدفع
        */
        $user->decrement('wallet', $cost);
        $admin = User::find(1);
        $admin->increment('wallet', $cost);
        /*
         * العدد المتاح
         * */
        $trip->increment('current_number', $request->person_number);

        return response()->json([

            'code' => '0',
            'message' => 'Your reservation has been completed successfully ',
            'result' => [
                'trip_name' => $trip->name,
                'cost' => $trip->cost,
                'person_number' => $booking->person_number,
                'total_price' => $booking->total_price,
            ]
        ], 201);
    }

    /*
     * حذف الحجز
     * */
    public function deleteBook($id)
    {
        $book = Booking::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Booking not found',
            ], 404);
        }

        if (Carbon::parse($book->trip->starting_date) < now()) {
            return response()->json([
                'message' => 'time has expired'
            ], 400);
        }

        /*
                الدفع
        */
        $book->user->increment('wallet', $book->total_price);
        $admin = User::find(1);
        $admin->decrement('wallet', $book->total_price);
        /*
         * العدد المتاح
         * */
        $book->trip->decrement('current_number', $book->person_number);


        $book->delete();
        return response()->json([
            'message' => 'Booking deleted successfully ',
        ], 201);
    }


    /*
           * تعديل الحجز
           * */

    public function updateBook(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'message' => 'Booking not found',
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'person_number' => 'integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }



        $cost = $booking->trip->cost * $booking->person_number;
        $cost1 = $booking->trip->cost * $request->person_number;

        $booking->user->increment('wallet', $cost);
        $admin = User::find(1);
        $admin->decrement('wallet', $cost);
        /*
         * العدد المتاح
         * */
        $booking->trip->decrement('current_number', $booking->person_number);

        if ($booking->trip->capacity - $booking->trip->current_number < $request->person_number) {
            return response()->json([
                'message' => 'There are no seats available for this number of people'
            ], 400);
        }

        if ($cost1 >  $booking->user->wallet) {
            return response()->json([
                'message' => 'You dont have enough money'
            ], 400);
        }
        if (Carbon::parse($booking->trip->starting_date) < now()) {
            return response()->json([
                'message' => 'Your reservation time has expired'
            ], 400);
        }


        $booking ->update([
            'person_number' => $request->person_number,
            'total_price' => $cost1,

        ]);

        /*
        الدفع
        */
        $booking->user->decrement('wallet', $cost1);
        $admin->increment('wallet', $cost1);
        /*
         * العدد المتاح
         * */
        $booking->trip->increment('current_number', $request->person_number);

        return response()->json([

            'code' => '0',
            'message' => 'Your reservation has been completed successfully ',
            'result' => [
                'trip_name' => $booking->trip->name,
                'cost' => $booking->trip->cost,
                'person_number' => $booking->person_number,
                'total_price' => $booking->total_price,
            ]
        ], 201);
    }/*
جلب رحلة*/
    public function getUserBook($id)
    {
        $user = Auth::user();

        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json([
                'message' => 'Booking not found',
            ], 404);
        }
        return response()->json([
                'code' => '0',
                'message' => 'This is booking ',
                'result' => [
                    'trip_name' => $booking->trip->name,
                    'cost' => $booking->trip->cost,
                    'person_number' => $booking->person_number,
                    'total_price' => $booking->total_price,
                ]
            ]
            , 201);
    }
    /*
    * جلب رحلات المستخدم
    * */
    public function getAllUserBookings()
    {
        $user = Auth::user();
        $booking = Booking::where('user_id', $user->id)->get();
        $bookings = [];
        foreach ($booking as $data1) {

            array_push($bookings, [
                'trip_name' => $data1->trip?->name,
                'cost' => $data1->trip?->cost,
                'person_number' => $data1->person_number,
                'total_price' => $data1->total_price
            ]);
        }

        if ($booking->isEmpty()) {
            return response()->json([
                'message' => 'Not found bookings',
            ], 404);
        }


        return response()->json([
                'message' => 'user trips',
                'result' => [
                    'data' => $bookings
                ]
            ]
            , 201);
    }
    /* جلب جميع الرحلات*/
    public function getAllBookings()
    {
        $bookings = [];
        $data = Booking::get();
        foreach ($data as $data1) {

            array_push($bookings, [
                'trip_name' => $data1->trip?->name,
                'cost' => $data1->trip?->cost,
                'person_number' => $data1->person_number,
                'total_price' => $data1->total_price
            ]);
        }

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Bookings not found',
            ], 404);
        }
        return response()->json([
                'code' => '0',
                'message' => 'All Bookings',
                'result' => [
                    'bookings' => $bookings,
                ]
            ]
            , 201);
    }
}
