<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string("acreage")->nullable();
            $table->bigInteger("price_range_start")->nullable();
            $table->bigInteger("price_range_end")->nullable();
            $table->bigInteger("numberOfBedRooms")->nullable();
            $table->bigInteger("numberOfBathrooms")->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_surveys');
    }
};
