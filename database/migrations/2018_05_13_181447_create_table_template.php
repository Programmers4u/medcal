<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('medical_template', function(Blueprint $table){
            $table->timestamps();
            $table->softDeletes();
            $table->bigIncrements('id');
            $table->string('name');

            $table->string('type');//A - Answer; Q - Question 
            $table->longText('desc');
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
        Schema::dropIfExists('medical_template');                
    }
}
