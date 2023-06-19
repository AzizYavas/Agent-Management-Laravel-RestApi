<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\HotelNameResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HotelNameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getHotelName = DB::table('hotelname')->get();

        if ($getHotelName->count() > 0) {

            return response()->json([
                'status' => 200,
                'data' => HotelNameResource::collection($getHotelName),
                'message' => 'Otel başarıyla getirildi.',
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
                'name' => 'required|string|max:65'
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $hotelNamePost = DB::table('hotelname')->insert([
                'name' => $request->name
            ]);

            if ($hotelNamePost) {

                $lastHotelNameInsert = DB::table('hotelname')
                    ->orderBy('id', 'desc')
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new HotelNameResource($lastHotelNameInsert),
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
        $takeHotelNameForId = DB::table('hotelname')
            ->where('id', $id)
            ->first();

        if ($takeHotelNameForId) {

            return response()->json([
                'status' => 200,
                'data' => new HotelNameResource($takeHotelNameForId),
                'message' => 'Otel Bulundu'
            ], 200);
        } else {

            return response()->json([
                'status' => 500,
                'message' => 'Otel Bulunamadı'
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
                'name' => 'required|string|max:45||unique:hotelname,name,' . $id,
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $updateHotelName = DB::table('hotelname')
                ->where('id', $id)
                ->update([
                    'name' => $request->name
                ]);

            if ($updateHotelName) {

                $lastHotelNameUpdate = DB::table('hotelname')
                    ->where('id', $id)
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new HotelNameResource($lastHotelNameUpdate),
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
        $deleteHotelName = DB::table('hotelname')
            ->where('id', $id)
            ->delete();

        if ($deleteHotelName) {

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
