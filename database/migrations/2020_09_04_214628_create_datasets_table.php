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
            $table->bigIncrements('id')
                ->index();
            $table->string('sex');
            $table->date('birthday');
            $table->date('date_of_examination');
            $table->text('diagnosis');
            $table->text('procedures');
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
