<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\RouteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getRoute = DB::table('routes')->get();

        if ($getRoute->count() > 0) {

            return response()->json([
                'status' => 200,
                'data' => RouteResource::collection($getRoute),
                'message' => 'Güzargah eklendi başarıyla getirildi.',
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
                'route_name' => 'required|string|max:65',
                'area_id' => 'required'
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $routePost = DB::table('routes')->insert([
                'route_name' => $request->route_name,
                'area_id' => $request->area_id
            ]);

            if ($routePost) {

                $lastRouteInsert = DB::table('routes')
                    ->orderBy('id', 'desc')
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new RouteResource($lastRouteInsert),
                    'message' => 'Güzargah Eklendi'
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
                'route_name' => 'required|string|max:65',
                'area_id' => 'required|unique:routes,area_id,' . $id
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $updateRoute = DB::table('routes')
                ->where('id', $id)
                ->update([
                    'route_name' => $request->route_name,
                    'area_id' => $request->area_id
                ]);

            if ($updateRoute) {

                $lastRouteUpdate = DB::table('client')
                    ->where('id', $id)
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new RouteResource($lastRouteUpdate),
                    'message' => 'Belirtilen Güzergah Güncellendi'
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
        $deleteRoute = DB::table('routes')
            ->where('id', $id)
            ->delete();

        if ($deleteRoute) {

            return response()->json([
                'status' => 200,
                'message' => 'Belirtilen Güzergah Silindi'
            ], 200);

        } else {

            return response()->json([
                'status' => 500,
                'message' => 'Hata'
            ], 500);
        }
    }
}
