<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     20 April 2020
 */

namespace App\Console\Commands;

use App\Models\CovidRawData;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

/**
 * Class UpdateCovidRawData
 * @package App\Console\Commands
 */
class UpdateCovidRawData extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid:update_raw_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update COVID patients data';

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
            $response = $client->get(config('corona.api.raw_data'));
        } catch (Exception $exception) {
            $this->warn('Failed to fetch data');
            $this->error('Following error occurred: ' . $exception->getMessage());

            return 1;
        }

        $response = json_decode($response->getBody()->getContents(), true);

        if (!empty($response) && !empty($response['raw_data'])) {
            $newPatients = 0;
            foreach ($response['raw_data'] as $item) {
                CovidRawData::updateOrCreate(['patientnumber' => $item['patientnumber']], $item);
                $newPatients++;
            }

            $this->info($newPatients . ' patients added');
        } else {
            $this->warn('No data found in api. Either endpoints have moved or response structure has changed');

            return 1;
        }

        return 0;
    }
}
