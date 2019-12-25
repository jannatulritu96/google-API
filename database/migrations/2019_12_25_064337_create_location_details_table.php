<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('place_id');
            $table->string('name');
            $table->string('formatted_address');
            $table->string('formatted_phone_number');
            $table->string('international_phone_number');
            $table->dateTime('opening_hours');
            $table->double('rating', 8, 2)->nullable();
            $table->integer('user_ratings_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_details');
    }
}
