<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->nullableTimestamps();

            $table->increments('id');
            $table->integer('inherit_id')
                ->unsigned()->nullable()->index();
            $table->foreign('inherit_id')
                ->references('id')->on('permissions');
            $table->string('name')->index();
            $table->string('slug')->index();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permissions');
    }
}
