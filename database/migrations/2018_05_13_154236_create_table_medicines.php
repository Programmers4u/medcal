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
            $table->string('shortname');
            $table->string('power');
            $table->string('shape');
            $table->string('no_permission');
            $table->string('permission_expaired');
            $table->string('company');
            $table->string('type');
            $table->string('code');
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
