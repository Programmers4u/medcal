<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDatasetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('datasets', function(Blueprint $table){
            $table->softDeletes();
            $table->timestamps();
            $table->bigIncrements('id');

            $table->string('sex')->nullable();
            $table->date('birthday')->nullable();
            $table->date('date_of_examination')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('procedures')->nullable();
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
        Schema::dropIfExists('datasets');
    }
}
