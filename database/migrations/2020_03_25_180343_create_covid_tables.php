<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     20 April 2020
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateCovidTables
 */
class CreateCovidTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_raw_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patientnumber')->nullable();
            $table->string('agebracket')->nullable();
            $table->string('contractedfromwhichpatientsuspected')->nullable();
            $table->string('currentstatus')->nullable();
            $table->string('statepatientnumber')->nullable();
            $table->string('statuschangedate')->nullable();
            $table->string('dateannounced')->nullable();
            $table->string('detectedcity')->nullable();
            $table->string('detecteddistrict')->nullable();
            $table->string('detectedstate')->nullable();
            $table->string('estimatedonsetdate')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->text('notes')->nullable();
            $table->text('backupnotes')->nullable();
            $table->text('source1')->nullable();
            $table->text('source2')->nullable();
            $table->text('source3')->nullable();

            $table->json('geo_city')->nullable();
            $table->json('geo_district')->nullable();
            $table->json('geo_state')->nullable();
            $table->json('geo_country')->nullable();

            $table->boolean('geo_updated')->default(false);

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
        Schema::dropIfExists('covid_raw_data');
    }
}
