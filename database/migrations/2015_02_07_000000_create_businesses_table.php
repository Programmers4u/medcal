<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('description');
            $table->string('postal_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('timezone');
            $table->string('strategy', 15)->default('timeslot'); /* Appointment Booking Strategy */
            $table->string('plan', 20);
            $table->softDeletes();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('businesses');
    }
}
