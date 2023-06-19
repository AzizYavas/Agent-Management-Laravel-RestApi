<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CarCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CarCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getCategory = DB::table('carcategory')->get();

        if ($getCategory->count() > 0) {

            return response()->json([
                'status' => 200,
                'data' => CarCategoryResource::collection($getCategory),
                'message' => 'Kategori başarıyla getirildi.',
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
                'category' => 'required|string|max:30|unique:carcategory,category',
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $carCategoryPost = DB::table('client')->insert([
                'category' => $request->category,
            ]);

            if ($carCategoryPost) {

                $lastCategoryInsert = DB::table('carcategory')
                    ->orderBy('id', 'desc')
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new CarCategoryResource($lastCategoryInsert),
                    'message' => 'Kategori Eklendi'
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
        $takeCategoryForId = DB::table('carcategory')
            ->where('id', $id)
            ->first();

        if ($takeCategoryForId) {

            return response()->json([
                'status' => 200,
                'data' => new CarCategoryResource($takeCategoryForId),
                'message' => 'Kategori Bulundu'
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
                'category' => 'required|max:65|unique:carcategory,category,' . $id,
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {

            $updateCategory = DB::table('carcategory')
                ->where('id', $id)
                ->update([
                    'category' => $request->category,
                ]);

            if ($updateCategory) {

                $lastCategoryUpdate = DB::table('carcategory')
                    ->where('id', $id)
                    ->first();

                return response()->json([
                    'status' => 200,
                    'data' => new CarCategoryResource($lastCategoryUpdate),
                    'message' => 'Belirtilen Kategori Güncellendi'
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
        $deleteCategory = DB::table('carcategory')
            ->where('id', $id)
            ->delete();

        if ($deleteCategory) {

            return response()->json([
                'status' => 200,
                'message' => 'Belirtilen Kategori Silindi'
            ], 200);

        } else {

            return response()->json([
                'status' => 500,
                'message' => 'Hata'
            ], 500);
        }
    }
}
