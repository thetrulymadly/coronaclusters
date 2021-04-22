<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlasmaDonorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plasma_donors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('donor_type');
            $table->string('name')->nullable();
            $table->string('gender');
            $table->string('age');
            $table->string('blood_group');
            $table->string('phone_number');
            $table->string('hospital');
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->timestamp('date_of_positive')->nullable();
            $table->timestamp('date_of_negative')->nullable();
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
        Schema::dropIfExists('plasma_donors');
    }
}
