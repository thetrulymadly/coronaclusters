<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     07 May 2020
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCovidStateDataTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('covid_state_data', function (Blueprint $table) {
            $table->integer('delta_active')->nullable()->change();
            $table->integer('delta_confirmed')->nullable()->change();
            $table->integer('delta_deaths')->nullable()->change();
            $table->integer('delta_recovered')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('covid_state_data', function (Blueprint $table) {
            $table->integer('delta_active')->change();
            $table->integer('delta_confirmed')->change();
            $table->integer('delta_deaths')->change();
            $table->integer('delta_recovered')->change();
        });
    }
}
