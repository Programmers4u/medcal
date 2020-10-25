<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMedicines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('medical_medicines', function(Blueprint $table){
            $table->timestamps();
            $table->softDeletes();

            $table->bigIncrements('id');
            $table->string('name');
            $table->string('shortname')->nullable();
            $table->string('power')->nullable();
            $table->string('shape')->nullable();
            $table->string('no_permission')->nullable();
            $table->string('permission_expaired')->nullable();
            $table->string('company')->nullable();
            $table->string('type')->nullable();
            $table->string('code')->nullable();
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
        Schema::dropIfExists('medical_medicines');                
    }
}
