<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('medical_file', function(Blueprint $table){
            $table->timestamps();
            $table->softDeletes();
            $table->bigIncrements('id');

            $table->integer('contact_id')
                ->unsigned()->index()
                ->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('no action');

            $table->bigInteger('medical_history_id')
                ->index()
                ->foregin('medical_history_id')
                ->references('id')
                ->on('medical_history')
                ->onDelete('no action');

            $table->string('type');
            $table->string('file');
            $table->string('original_name');
            $table->text('description');
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
        Schema::dropIfExists('medical_file');
    }
}
