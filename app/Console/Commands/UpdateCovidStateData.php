<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     20 April 2020
 */

namespace App\Console\Commands;

use App\Models\CovidStateData;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

/**
 * Class UpdateCovidStateData
 * @package App\Console\Commands
 */
class UpdateCovidStateData extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid:update_state_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update COVID state-wise data';

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
        $client = new Client();
        try {
            $response = $client->get(config('corona.api.data'));
        } catch (Exception $exception) {
            $this->warn('Failed to fetch data');
            $this->error('Following error occurred: ' . $exception->getMessage());

            return 1;
        }

        $response = json_decode($response->getBody()->getContents(), true);

        if (!empty($response) && !empty($stateData = $response['statewise'])) {
            $stateData = collect($stateData);
            foreach ($stateData as $item) {
                CovidStateData::updateOrCreate(['state' => $item['state']], [
                    'active' => (int)$item['active'],
                    'confirmed' => (int)$item['confirmed'],
                    'deaths' => (int)$item['deaths'],
                    'recovered' => (int)$item['recovered'],
//                    'delta_active' => (int)$item['deltaactive'],
                    'delta_confirmed' => (int)$item['deltaconfirmed'],
                    'delta_deaths' => (int)$item['deltadeaths'],
                    'delta_recovered' => (int)$item['deltarecovered'],
                    'lastupdatedtime' => $item['lastupdatedtime'],
                ]);
            }

            $this->info('State-wise data updated');
        } else {
            $this->warn('No data found in api. Either endpoints have moved or response structure has changed');

            return 1;
        }

        return 0;
    }
}
