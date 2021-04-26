<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPlasmaDonorVerificationsTableEdit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plasma_donor_verifications', function (Blueprint $table) {
            $table->timestamp('expires_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'))->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plasma_donor_verifications', function (Blueprint $table) {
            //
        });
    }
}
