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
            $table->timestamps();
            $table->softDeletes();
            $table->bigIncrements('id');

            $table->bigInteger('appointment_id')
                ->index()
                ->foregin('appointment_id')
                ->references('id')
                ->on('appointments')
                ->onDelete('no action')
                ->nullable();
            
            $table->bigInteger('business_id')
                ->index()
                ->foregin('business_id')
                ->references('id')
                ->on('businesses')
                ->onDelete('no action');
            
            $table->bigInteger('contact_id')
                ->index()
                ->foregin('contact_id')
                ->references('id')
                ->on('contacts')
                ->onDelete('no action');

            $table->string('note',960);
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
