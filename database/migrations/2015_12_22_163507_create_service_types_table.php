<?php

use Illuminate\Database\Migrations\Migration;

class CreateServiceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_types', function ($table) {
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->increments('id');
            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')
                ->references('id')
                ->on('businesses')
                ->onDelete('no action');
            $table->string('slug')->index();
            $table->string('name');
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('service_types');
    }
}
