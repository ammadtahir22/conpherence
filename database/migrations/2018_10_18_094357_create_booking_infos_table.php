<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('booking_number');
            $table->integer('user_id');
            $table->integer('venue_id');
            $table->integer('space_id');
            $table->integer('hotel_owner_id');
            $table->string('booking_firstname');
            $table->string('booking_lastname');
            $table->text('booking_address');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('no_of_days');
            $table->text('purpose');
            $table->double('grand_total');
            $table->integer('status');
            $table->double('review_status');
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
        Schema::dropIfExists('booking_infos');
    }
}
