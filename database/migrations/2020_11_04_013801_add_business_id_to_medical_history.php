<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBusinessIdToMedicalHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('medical_history', function($table){
            $table->bigInteger('business_id')
                ->index()
                ->foregin('business_id')
                ->references('id')
                ->on('businesses')
                ->onDelete('no action')
                ->onUpdate('cascade')
            ;
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
        Schema::table('medical_history', function($table){
            $table->dropColumn('business_id');
        });

    }
}
