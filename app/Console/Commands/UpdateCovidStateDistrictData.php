<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     20 April 2020
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class UpdateCovidStateDistrictData
 * @package App\Console\Commands
 */
class UpdateCovidStateDistrictData extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid:update_state_district_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update COVID state-district-wise data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
