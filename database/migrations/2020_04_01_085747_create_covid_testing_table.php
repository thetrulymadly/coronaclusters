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
 * Class CreateCovidTestingTable
 */
class CreateCovidTestingTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_testing', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('testsconductedbyprivatelabs')->nullable();
            $table->integer('totalindividualstested')->nullable();
            $table->integer('totalpositivecases')->nullable();
            $table->integer('totalsamplestested')->nullable();
            $table->string('source')->nullable();
            $table->dateTime('updatetimestamp');

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
        Schema::dropIfExists('covid_testing');
    }
}
