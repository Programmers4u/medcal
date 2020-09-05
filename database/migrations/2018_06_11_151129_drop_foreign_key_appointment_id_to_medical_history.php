<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignKeyAppointmentIdToMedicalHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('medical_history', function(Blueprint $table){
            // $table->dropForeign(['appointment_id']);
            // $table->dropIndex(['appointment_id']);
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
        Schema::table('medical_history', function(Blueprint $table){
            // $table->integer('appointment_id')->unsigned()->index();
            // $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
        });        
    }
}
