<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->nullableTimestamps();

            $table->increments('id');
            $table->date('date');
            $table->timestamp('start_at')->nullable()->index();
            $table->timestamp('finish_at')->nullable()->index();
            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')
                ->references('id')->on('businesses')->onDelete('cascade');
            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')
                ->references('id')->on('services')->onDelete('cascade');
            $table->integer('capacity')->unsigned()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vacancies');
    }
}
