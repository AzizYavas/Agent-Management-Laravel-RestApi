<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AreaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getArea = DB::table('areas')->get();

        if ($getArea->count() > 0) {

            return response()->json([
                'status' => 200,
                'data' => AreaResource::collection($getArea),
                'message' => 'Bölgeler başarıyla getirildi.',
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
                'area_name' => 'required|string|max:65|unique:areas',
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $areaPost = DB::table('areas')->insert([
                'area_name' => $request->area_name,
            ]);

            if ($areaPost) {

                $lastAreaInsert = DB::table('areas')
                    ->orderBy('id', 'desc')
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new AreaResource($lastAreaInsert),
                    'message' => 'Müşteri Eklendi'
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'area_name' => 'required|unique:areas,area_name,' . $id
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $updateClient = DB::table('areas')
                ->where('id', $id)
                ->update([
                    'area_name' => $request->area_name
                ]);

            if ($updateClient) {

                $lastAreaUpdate = DB::table('areas')
                    ->where('id', $id)
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new AreaResource($lastAreaUpdate),
                    'message' => 'Belirtilen Bölge Güncellendi'
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
        $deleteArea = DB::table('areas')
            ->where('id', $id)
            ->delete();

        if ($deleteArea) {

            return response()->json([
                'status' => 200,
                'message' => 'Belirtilen Bölge Silindi'
            ], 200);

        } else {

            return response()->json([
                'status' => 500,
                'message' => 'Hata'
            ], 500);
        }
    }



}
