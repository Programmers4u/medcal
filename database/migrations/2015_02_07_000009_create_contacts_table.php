<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('no action')
                ->onUpdate('cascade');
            $table->string('nin')->nullable()->index();
            $table->enum('gender', ['M', 'F']);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('occupation')->nullable();
            $table->string('martial_status')->nullable();
            $table->string('postal_address')->nullable();
            $table->date('birthdate')->nullable();
            $table->char('mobile', 15)->nullable();
            $table->char('mobile_country', 2)->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contacts');
    }
}
