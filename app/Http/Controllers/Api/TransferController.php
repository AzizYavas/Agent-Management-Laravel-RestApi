<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TransferResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getTransferKind = DB::table('transfer')->get();

        if ($getTransferKind->count() > 0) {

            return response()->json([
                'status' => 200,
                'data' => TransferResource::collection($getTransferKind),
                'message' => 'Transferler başarıyla getirildi.',
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
                'area_id' => 'required|integer',
                'route_id' => 'required|integer',
                'car_id' => 'required|integer',
                'price' => 'required|integer'
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $transferPost = DB::table('transfer')->insert([
                'area_id' => $request->area_id,
                'route_id' => $request->route_id,
                'car_id' => $request->car_id,
                'price' => $request->price
            ]);

            if ($transferPost) {

                $lastTransferInsert = DB::table('transfer')
                    ->orderBy('id', 'desc')
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new TransferResource($lastTransferInsert),
                    'message' => 'Transfer Eklendi'
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
        $takeTransferForId = DB::table('transfer')
            ->where('id', $id)
            ->first();

        if ($takeTransferForId) {

            return response()->json([
                'status' => 200,
                'data' => new TransferResource($takeTransferForId),
                'message' => 'Transfer Bulundu'
            ], 200);
        } else {

            return response()->json([
                'status' => 500,
                'message' => 'Transfer Bulunamadı'
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
                'area_id' => 'required|integer',
                'route_id' => 'required|integer',
                'car_id' => 'required|integer',
                'price' => 'required|integer'
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $updateTransfer = DB::table('transfer')
                ->where('id', $id)
                ->update([
                    'area_id' => $request->area_id,
                    'route_id' => $request->route_id,
                    'car_id' => $request->car_id,
                    'price' => $request->price
                ]);

            if ($updateTransfer) {

                $lastClientUpdate = DB::table('trasnfer')
                    ->where('id', $id)
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new TransferResource($lastClientUpdate),
                    'message' => 'Belirtilen Transfer Güncellendi'
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
        $deleteTransfer = DB::table('transfer')
            ->where('id', $id)
            ->delete();

        if ($deleteTransfer) {

            return response()->json([
                'status' => 200,
                'message' => 'Belirtilen Transfer Silindi'
            ], 200);

        } else {

            return response()->json([
                'status' => 500,
                'message' => 'Hata'
            ], 500);
        }
    }
}
