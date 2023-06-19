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
        Schema::create('allcar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->comment('carcategory tablosundaki id');
            $table->string('brand',65)->comment('araç modeli');
            $table->string('model',65)->comment('araç modeli');
            $table->unsignedInteger('capacity')->nullable()->unique()->comment('araç yolcu kapasitesi');
            $table->unsignedInteger('luggage')->nullable()->unique()->comment('araç bagaj kapasitesi');
            $table->tinyInteger('clima')->default(0)->comment('araç klimalı mı?');
            $table->tinyInteger('charge')->default(0)->comment('araç usb sarj var mı?');
            $table->integer('price')->comment('transfer ücreti');
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
        Schema::dropIfExists('allcar');
    }
};
