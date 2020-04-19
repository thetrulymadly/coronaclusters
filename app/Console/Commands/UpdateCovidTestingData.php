<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     20 April 2020
 */

namespace App\Console\Commands;

use App\Models\CovidTesting;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

/**
 * Class UpdateCovidTestingData
 * @package App\Console\Commands
 */
class UpdateCovidTestingData extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid:update_testing_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update COVID testing data in the country';

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
            $response = $client->get(config('corona.api.testing_data'));
        } catch (Exception $exception) {
            $this->warn('Failed to fetch data');
            $this->error('Following error occurred: ' . $exception->getMessage());

            return 1;
        }

        $response = json_decode($response->getBody()->getContents(), true);

        if (!empty($response) && !empty($testingData = $response['tested'])) {
            $count = 0;
            foreach ($testingData as $data) {

                $dateTime = explode(' ', $data['updatetimestamp']);
                if (count($dateTime) === 3) {
                    $dateTime = Carbon::createFromFormat('d/m/Y h:i: a', $data['updatetimestamp'])->toDateTimeString();
                } elseif (count($dateTime) === 2) {
                    $dateTime = Carbon::createFromFormat('d/m/Y H:i:s', $data['updatetimestamp'])->toDateTimeString();
                } else {
                    $dateTime = Carbon::createFromFormat('d/m/Y', $data['updatetimestamp'])->setTime(0, 0, 0)->toDateTimeString();
                }

                CovidTesting::updateOrCreate(['updatetimestamp' => $dateTime], [
                    'testsconductedbyprivatelabs' => (int)$data['testsconductedbyprivatelabs'],
                    'totalindividualstested' => (int)$data['totalindividualstested'],
                    'totalpositivecases' => (int)$data['totalpositivecases'],
                    'totalsamplestested' => (int)$data['totalsamplestested'],
                    'source' => $data['source'],
                    'updatetimestamp' => $dateTime,
                ]);
                $count++;
            }

            $this->info('Testing data updated: Updated: ' . $count);
        } else {
            $this->warn('No data found in api. Either endpoints have moved or response structure has changed');

            return 1;
        }

        return 0;
    }
}
