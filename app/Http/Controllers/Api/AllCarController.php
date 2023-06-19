<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AllCarResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AllCarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getCar = DB::table('allcar')->get();

        if ($getCar->count() > 0) {

            return response()->json([
                'status' => 200,
                'data' => AllCarResource::collection($getCar),
                'message' => 'Kullanıcı Araç getirildi.',
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
                'category_id' => 'required',
                'brand' => 'required|string|max:65',
                'model' => 'required|string|max:65',
                'capacity' => 'required',
                'luggage' => 'required',
                'price' => 'required'
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $carPost = DB::table('allcar')->insert([
                'category_id' => $request->category_id,
                'brand' => $request->brand,
                'model' => $request->model,
                'capacity' => $request->capacity,
                'luggage' => $request->luggage,
                'clima' => $request->clima,
                'charge' => $request->charge,
                'price' => $request->price
            ]);

            if ($carPost) {

                $lastCarInsert = DB::table('allcar')
                    ->orderBy('id', 'desc')
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new AllCarResource($lastCarInsert),
                    'message' => 'Araç Eklendi'
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
        $takeCarForId = DB::table('allcar')
            ->where('id', $id)
            ->first();

        if ($takeCarForId) {

            return response()->json([
                'status' => 200,
                'data' => new AllCarResource($takeCarForId),
                'message' => 'Araç Bulundu'
            ], 200);
        } else {

            return response()->json([
                'status' => 500,
                'message' => 'Araç Bulunamadı'
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
                'category_id' => 'required',
                'brand' => 'required|string|max:65',
                'model' => 'required|string|max:65',
                'capacity' => 'required',
                'luggage' => 'required',
                'price' => 'required'
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $updateCar = DB::table('allcar')
                ->where('id', $id)
                ->update([
                    'category_id' => $request->category_id,
                    'brand' => $request->brand,
                    'model' => $request->model,
                    'capacity' => $request->capacity,
                    'luggage' => $request->luggage,
                    'clima' => $request->clima,
                    'charge' => $request->charge,
                    'price' => $request->price
                ]);

            if ($updateCar) {

                $lastCarUpdate = DB::table('allcar')
                    ->where('id', $id)
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new AllCarResource($lastCarUpdate),
                    'message' => 'Belirtilen Araç Güncellendi'
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
        $deleteCar = DB::table('allcar')
            ->where('id', $id)
            ->delete();

        if ($deleteCar) {

            return response()->json([
                'status' => 200,
                'message' => 'Belirtilen Araç Silindi'
            ], 200);

        } else {

            return response()->json([
                'status' => 500,
                'message' => 'Hata'
            ], 500);
        }
    }
}
