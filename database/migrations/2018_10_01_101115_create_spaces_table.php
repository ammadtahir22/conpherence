<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spaces', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('venue_id');
            $table->integer('user_id');
            $table->string('free_amenities');
            $table->string('amenities');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->text('cancellation_policy');
            $table->integer('hours');
            $table->integer('cancel_cost');
            $table->text('reviews_count');
            $table->float('reviews_total');
            $table->integer('price');
            $table->string('image');
            $table->tinyInteger('status', false, true)->default(1)->length(2);
            $table->tinyInteger('top_rate', false, true)->default(0)->length(2);
            $table->tinyInteger('verified', false, true)->default(0)->length(2);
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
        Schema::dropIfExists('spaces');
    }
}
