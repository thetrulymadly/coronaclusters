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
 * Class CreateCovidStateDataTable
 */
class CreateCovidStateDataTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_state_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('state');
            $table->integer('active');
            $table->integer('confirmed');
            $table->integer('deaths');
            $table->integer('recovered');
            $table->integer('delta_active');
            $table->integer('delta_confirmed');
            $table->integer('delta_deaths');
            $table->integer('delta_recovered');
            $table->timestamp('lastupdatedtime');
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
        Schema::dropIfExists('covid_state_data');
    }
}
