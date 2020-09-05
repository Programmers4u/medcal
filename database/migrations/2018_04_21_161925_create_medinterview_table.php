<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedinterviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('medical_interview', function(Blueprint $table){
            $table->timestamps();
            $table->softDeletes();
            $table->bigIncrements('id');

            $table->integer('contact_id')
                ->unsigned()->index()
                ->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onDelete('no action');

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
        Schema::dropIfExists('medical_interview');
    }
}
