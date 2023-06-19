<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transferset', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('route_id')->comment('routes tablosundaki id');
            $table->date('arrival_date')->nullable()->comment('geliş tarihi');
            $table->string('fly_id',25)->comment('uçuş no');
            $table->time('transfer_time')->comment('transfer saati');
            $table->integer('car_id')->comment('allcar tablosundaki id');
            $table->integer('price')->comment('transfer ücreti');
            $table->integer('client_id')->comment('Yolcu Idsi');
            $table->tinyInteger('toaccept')->default(0)->comment('onaylandın mı');
            $table->timestamp('update_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP on UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('delete_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferset');
    }
};
