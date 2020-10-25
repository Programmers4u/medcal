<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('medical_templates', function(Blueprint $table){
            $table->timestamps();
            $table->softDeletes();
            $table->bigIncrements('id');
            $table->bigInteger('business_id')
                ->index()
                ->foregin('business_id')
                ->on('businesses')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('no action')
                ;
            $table->string('name');

            $table->string('type');//A - Answer; Q - Question 
            $table->text('description');
            $table->bigInteger('depends')->nullable();
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
        Schema::dropIfExists('medical_templates');                
    }
}
