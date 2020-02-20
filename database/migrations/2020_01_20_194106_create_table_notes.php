<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('notes', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('appointment_id');
            $table->string('note',960);

            $table->timestamps();
            $table->softDeletes();
            $table->index(['appointment_id']);
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
        Schema::table('notes', function (Blueprint $table) {
            $table->dropIndex(['appointment_id']);
        });
        Schema::dropIfExists('notes');
    }
}
