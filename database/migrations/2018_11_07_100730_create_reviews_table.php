<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('space_id');
            $table->integer('booking_id');
            $table->text('feedback')->nullable();
            $table->integer('customer_service_rate');
            $table->integer('amenities_rate');
            $table->integer('meeting_facility_rate');
            $table->integer('food_rate');
            $table->integer('total_stars');
            $table->string('r_status');
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
        Schema::dropIfExists('reviews');
    }
}
