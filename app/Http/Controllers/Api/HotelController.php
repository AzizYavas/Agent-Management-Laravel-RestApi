<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\HotelResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getHotel = DB::table('hotel')->get();

        if ($getHotel->count() > 0) {

            return response()->json([
                'status' => 200,
                'data' => HotelResource::collection($getHotel),
                'message' => 'Tüm oteller başarıyla getirildi.',
            ], 200);
        } else {

            return response()->json([
                'status' => 404,
                'message' => 'Kayıt Yok'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'hotel_id' => 'required',
                'room_detail' => 'required|string|max:100',
                'service_type' => 'required|string|max:100',
                'price' => 'required|max:20',
                'reservation_userid' => 'required',
                'checkin_date' => 'required|date',
                'checkout_date' => 'required|date|after:checkin_date'
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $hotelPost = DB::table('hotel')->insert([
                'hotel_id' => $request->hotel_id,
                'room_detail' => $request->room_detail,
                'service_type' => $request->service_type,
                'price' => $request->price,
                'reservation_userid' => $request->reservation_userid,
                'checkin_date' => $request->checkin_date,
                'checkout_date' => $request->checkout_date
            ]);

            if ($hotelPost) {

                $lastHotelInsert = DB::table('hotel')
                    ->orderBy('id', 'desc')
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new HotelResource($lastHotelInsert),
                    'message' => 'Otel Eklendi'
                ], 200);
            } else {

                return response()->json([
                    'status' => 500,
                    'message' => 'Hata Var'
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $takeHotelForId = DB::table('hotel')
            ->where('id', $id)
            ->first();

        if ($takeHotelForId) {

            return response()->json([
                'status' => 200,
                'data' => new HotelResource($takeHotelForId),
                'message' => 'Otel Bulundu'
            ], 200);
        } else {

            return response()->json([
                'status' => 500,
                'message' => 'Müşteri Bulunamadı'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'hotel_id' => 'required|max:45',
                'room_detail' => 'required|string|max:100',
                'service_type' => 'required|string|max:100',
                'price' => 'required|max:20',
                'reservation_userid' => 'required',
                'checkin_date' => 'required|date',
                'checkout_date' => 'required|date|after:checkin_date'
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $updateHotel = DB::table('hotel')
                ->where('id', $id)
                ->update([
                    'hotel_id' => $request->hotel_id,
                    'room_detail' => $request->room_detail,
                    'service_type' => $request->service_type,
                    'price' => $request->price,
                    'reservation_userid' => $request->reservation_userid,
                    'checkin_date' => $request->checkin_date,
                    'checkout_date' => $request->checkout_date
                ]);

            if ($updateHotel) {

                $lastHotelUpdate = DB::table('hotel')
                    ->where('id', $id)
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new HotelResource($lastHotelUpdate),
                    'message' => 'Belirtilen Otel Güncellendi'
                ], 200);
            } else {

                return response()->json([
                    'status' => 500,
                    'message' => 'Hata Var'
                ], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteHotel = DB::table('hotel')
            ->where('id', $id)
            ->delete();

        if ($deleteHotel) {

            return response()->json([
                'status' => 200,
                'message' => 'Belirtilen Otel Silindi'
            ], 200);
        } else {

            return response()->json([
                'status' => 500,
                'message' => 'Hata'
            ], 500);
        }
    }
}
