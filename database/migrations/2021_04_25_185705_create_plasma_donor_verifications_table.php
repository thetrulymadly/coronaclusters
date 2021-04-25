<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlasmaDonorVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plasma_donor_verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('donor_id');
            $table->string('phone_number')->nullable();
            $table->string('otp')->nullable();
            $table->string('gateway_name')->nullable();
            $table->string('gateway_response')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plasma_donor_verifications');
    }
}
