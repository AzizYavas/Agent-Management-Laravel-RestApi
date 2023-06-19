<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SetTransferResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SetTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getTransferSet = DB::table('transferset')->get();

        if ($getTransferSet->count() > 0) {

            return response()->json([
                'status' => 200,
                'data' => SetTransferResource::collection($getTransferSet),
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
                'route_id' => 'required',
                'arrival_date' => 'required',
                'fly_id' => 'required',
                'transfer_time' => 'required',
                'car_id' => 'required',
                'price' => 'required',
                'client_id' => 'required',
                'toaccept' => 'required'
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $setTransferPost = DB::table('transferset')->insert([
                'route_id' => $request->route_id,
                'arrival_date' => $request->arrival_date,
                'fly_id' => $request->fly_id,
                'transfer_time' => $request->transfer_time,
                'car_id' => $request->car_id,
                'price' => $request->price,
                'client_id' => $request->client_id,
                'toaccept' => $request->toaccept
            ]);

            if ($setTransferPost) {

                $lastTransferInsert = DB::table('transferset')
                    ->orderBy('id', 'desc')
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new SetTransferResource($lastTransferInsert),
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
        $takeSetTransferForId = DB::table('transferset')
            ->where('id', $id)
            ->first();

        if ($takeSetTransferForId) {

            return response()->json([
                'status' => 200,
                'data' => new SetTransferResource($takeSetTransferForId),
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
                'route_id' => 'required',
                'arrival_date' => 'required',
                'fly_id' => 'required',
                'transfer_time' => 'required',
                'car_id' => 'required',
                'price' => 'required',
                'client_id' => 'required',
                'toaccept' => 'required'
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $updateSetTransfer = DB::table('transferset')
                ->where('id', $id)
                ->update([
                    'route_id' => $request->route_id,
                    'arrival_date' => $request->arrival_date,
                    'fly_id' => $request->fly_id,
                    'transfer_time' => $request->transfer_time,
                    'car_id' => $request->car_id,
                    'price' => $request->price,
                    'client_id' => $request->client_id,
                    'toaccept' => $request->toaccept
                ]);

            if ($updateSetTransfer) {

                $lastTransferSetUpdate = DB::table('transferset')
                    ->where('id', $id)
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new SetTransferResource($lastTransferSetUpdate),
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
        $deleteTransfer = DB::table('transferset')
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
