<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\SmsServer as ServerSMS;

class SmsServer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sms_server', function(Blueprint $table){
            $table->timestamps();
            $table->softDeletes();
            $table->bigIncrements('id');

            $table->string('client_id', 80);
            $table->tinyInteger('status')->default(ServerSMS::$STATUS_TOSEND);
            $table->string('to',16);
            $table->string('msg',960);
            $table->string('msg_id', 120);
            $table->dateTimeTz('date_start');            

            $table->index(['client_id', 'created_at', 'date_start', 'status']);
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
        Schema::table('sms_server', function (Blueprint $table) {
            $table->dropIndex(['client_id', 'created_at', 'date_start', 'status']);
        });
        Schema::dropIfExists('sms_server');   
    }
}
