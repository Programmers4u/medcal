<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MedPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('med_permission', function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
            $table->bigIncrements('id');
            
            $table->integer('business_id')
                ->unsigned()
                ->index()
                ->foreign('business_id')
                ->references('id')
                ->on('businesses')
                ->onDelete('no action');

            $table->integer('contact_id')
                ->unsigned()
                ->index()
                ->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onDelete('no action');
            
            $table->boolean('appo_sms')->default(true);
            $table->boolean('appo_email')->default(true);
            $table->boolean('news_email')->default(false);
            $table->boolean('news_sms')->default(false);

            $table->text('json');
            
            $table->unique(['business_id', 'contact_id']);

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
        Schema::dropIfExists('med_permission');
    }
}
