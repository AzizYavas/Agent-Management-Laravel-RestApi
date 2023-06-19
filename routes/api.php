<?php

use App\Http\Controllers\Api\AllCarController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\CarCategoryController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\HotelNameController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\SetTransferController;
use App\Http\Controllers\Api\TransferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->group(function () {
    
    /* ------- MÜŞTERİLER -------  */

    Route::get('client', [ClientController::class, 'index']);
    Route::post('client', [ClientController::class, 'store']);

    Route::get('client/{id}', [ClientController::class, 'show']);
    Route::post('client/{id}', [ClientController::class, 'update']);

    Route::get('client/{id}', [ClientController::class, 'destroy']);

    /* ------- MÜŞTERİLER -------  */


    /* ------- OTELLER -------  */

    Route::get('hotel', [HotelController::class, 'index']);
    Route::post('hotel', [HotelController::class, 'store']);

    Route::get('hotel/{id}', [HotelController::class, 'show']);
    Route::post('hotel/{id}', [HotelController::class, 'update']);

    Route::get('hotel/{id}', [HotelController::class, 'destroy']);

    /* ------- OTELLER -------  */


    /* ------- BÖLGE -------  */

    Route::get('area', [AreaController::class, 'index']);
    Route::post('area', [AreaController::class, 'store']);
    Route::post('area/{id}', [AreaController::class, 'update']);
    Route::get('area/{id}', [AreaController::class, 'destroy']);

    /* ------- BÖLGE -------  */

    /* ------- ARAÇLAR -------  */

    Route::get('allcar', [AllCarController::class, 'index']);
    Route::post('allcar', [AllCarController::class, 'store']);

    Route::get('allcar/{id}', [AllCarController::class, 'show']);
    Route::post('allcar/{id}', [AllCarController::class, 'update']);

    Route::get('allcar/{id}', [AllCarController::class, 'destroy']);

    /* ------- ARAÇLAR -------  */

    /* ------- ARAÇ KATEGORİLERİ -------  */

    Route::get('carcategory', [CarCategoryController::class, 'index']);
    Route::post('carcategory', [CarCategoryController::class, 'store']);

    Route::get('carcategory/{id}', [CarCategoryController::class, 'show']);
    Route::post('carcategory/{id}', [CarCategoryController::class, 'update']);

    Route::get('carcategory/{id}', [CarCategoryController::class, 'destroy']);

    /* ------- ARAÇ KATEGORİLERİ -------  */

    /* ------- OTEL İSİMLERİ -------  */

    Route::get('hotelname', [HotelNameController::class, 'index']);
    Route::post('hotelname', [HotelNameController::class, 'store']);

    Route::get('hotelname/{id}', [HotelNameController::class, 'show']);
    Route::post('hotelname/{id}', [HotelNameController::class, 'update']);

    Route::get('hotelname/{id}', [HotelNameController::class, 'destroy']);

    /* ------- OTEL İSİMLERİ -------  */

    /* ------- GÜZERGAH İSİMLERİ -------  */

    Route::get('route', [RouteController::class, 'index']);
    Route::post('route', [RouteController::class, 'store']);

    Route::post('route/{id}', [RouteController::class, 'update']);

    Route::get('route/{id}', [RouteController::class, 'destroy']);

    /* ------- GÜZERGAH İSİMLERİ -------  */

    /* ------- TRANSFER AYARLARI -------  */

    Route::get('settransfer', [SetTransferController::class, 'index']);
    Route::post('settransfer', [SetTransferController::class, 'store']);

    Route::get('settransfer/{id}', [SetTransferController::class, 'show']);
    Route::post('settransfer/{id}', [SetTransferController::class, 'update']);

    Route::get('settransfer/{id}', [SetTransferController::class, 'destroy']);

    /* ------- TRANSFER AYARLARI -------  */

    /* ------- TRANSFER TÜRLERİ -------  */

    Route::get('transferler', [TransferController::class, 'index']);
    Route::post('transferler', [TransferController::class, 'store']);

    Route::get('transferler/{id}', [TransferController::class, 'show']);
    Route::post('transferler/{id}', [TransferController::class, 'update']);

    Route::get('transferler/{id}', [TransferController::class, 'destroy']);

    /* ------- TRANSFER TÜRLERİ -------  */
});
