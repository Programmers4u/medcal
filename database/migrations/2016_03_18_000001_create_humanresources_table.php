<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHumanresourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('humanresources', function (Blueprint $table) {
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->increments('id');
            $table->string('name');
            $table->string('slug', 50)->index();
            $table->integer('capacity')->unsigned()->default(1);
            $table->integer('contact_id')->unsigned()->nullable();
            $table->foreign('contact_id')
                ->references('id')->on('contacts')->onDelete('set null');
            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')
                ->references('id')->on('businesses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('humanresources');
    }
}
