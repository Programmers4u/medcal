<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSmsAppointmentSentToMedPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('med_permission', function (Blueprint $table) {
            $table->boolean('appo_sms_sent')->default(false);
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
        Schema::table('med_permission', function (Blueprint $table) {
            $table->dropColumn('appo_sms_sent');
        });
        
    }
}
