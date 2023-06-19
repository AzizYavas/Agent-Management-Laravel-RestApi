<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ClientResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getClient = DB::table('client')->get();

        if ($getClient->count() > 0) {

            return response()->json([
                'status' => 200,
                'data' => ClientResource::collection($getClient),
                'message' => 'Kullanıcı başarıyla getirildi.',
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
                'name' => 'required|string|max:65',
                'surname' => 'required|string|max:65',
                'email' => 'required|email|unique:client|max:65',
                'title' => 'required|max:65',
                'phone' => 'required|unique:client|digits:10'
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $clientPost = DB::table('client')->insert([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'title' => $request->title,
                'phone' => $request->phone
            ]);

            if ($clientPost) {

                $lastClientInsert = DB::table('client')
                    ->orderBy('id', 'desc')
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new ClientResource($lastClientInsert),
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $takeClientForId = DB::table('client')
            ->where('id', $id)
            ->first();

        if ($takeClientForId) {

            return response()->json([
                'status' => 200,
                'data' => new ClientResource($takeClientForId),
                'message' => 'Müşteri Bulundu'
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
                'name' => 'required|string|max:45',
                'surname' => 'required|string|max:45',
                'title' => 'required|string|max:45',
                'email' => 'required|max:191|unique:client,email,' . $id,
                'phone' => 'required|digits:11|unique:client,phone,' . $id
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $updateClient = DB::table('client')
                ->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email,
                    'title' => $request->title,
                    'phone' => $request->phone
                ]);

            if ($updateClient) {

                $lastClientUpdate = DB::table('client')
                    ->where('id', $id)
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new ClientResource($lastClientUpdate),
                    'message' => 'Belirtilen Müşteri Güncellendi'
                ], 200);
            } else {

                return response()->json([
                    'status' => 500,
                    'message' => 'Hata Var'
                ], 500);
            }
        }
    }


    /**s
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteClient = DB::table('client')
            ->where('id', $id)
            ->delete();

        if ($deleteClient) {

            return response()->json([
                'status' => 200,
                'message' => 'Belirtilen Müşteri Silindi'
            ], 200);

        } else {

            return response()->json([
                'status' => 500,
                'message' => 'Hata'
            ], 500);
        }
    }
}
