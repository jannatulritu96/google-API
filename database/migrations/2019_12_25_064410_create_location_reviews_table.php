<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('place_id');
            $table->string('author_name');
            $table->string('author_url');
            $table->string('profile_photo_url');
            $table->double('rating', 8, 2)->nullable();
            $table->string('relative_time_description');
            $table->string('text');
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
        Schema::dropIfExists('location_reviews');
    }
}
