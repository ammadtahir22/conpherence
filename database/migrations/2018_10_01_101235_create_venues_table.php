<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('category_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->text('images')->nullable();
            $table->text('location');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('country');
            $table->string('city');
            $table->text('cancellation_policy')->nullable();
            $table->integer('status');
            $table->text('food_array')->nullable();
            $table->float('reviews')->nullable();
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
        Schema::dropIfExists('venues');
    }
}
