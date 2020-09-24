<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MedicalHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('medical_history', function(Blueprint $table) {
            $table->softDeletes();
            $table->bigIncrements('id');
            $table->timestamps();

            $table->bigInteger('contact_id')
                ->index()
                ->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onDelete('no action');

            $table->bigInteger('appointment_id')
                ->index()
                ->foreign('appointment_id')
                ->references('id')
                ->on('appointments')
                ->onDelete('no action')
                ;
            $table->text('json_data');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('medical_history');
    }
}
