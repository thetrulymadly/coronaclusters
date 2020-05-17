<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     04 May 2020
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
class UpdateCovidRawDataLive extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid:update_raw_data_live';

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
            $response = $client->get(config('corona.api.raw_data_4'));
        } catch (Exception $exception) {
            $this->warn('Failed to fetch data');
            $this->error('Following error occurred: ' . $exception->getMessage());

            return 1;
        }

        $response = json_decode($response->getBody()->getContents(), true);

        if (!empty($response) && !empty($response['raw_data'])) {
            $newPatients = 0;
            foreach ($response['raw_data'] as $item) {
                CovidRawData::updateOrCreate(['patientnumber' => 27891 + (int)$item['entryid']], [
                    'numcases' => $item['numcases'],
                    'agebracket' => $item['agebracket'],
                    'backupnotes' => '',
                    'contractedfromwhichpatientsuspected' => $item['contractedfromwhichpatientsuspected'],
                    'currentstatus' => $item['currentstatus'],
                    'dateannounced' => $item['dateannounced'],
                    'detectedcity' => $item['detectedcity'],
                    'detecteddistrict' => $item['detecteddistrict'],
                    'detectedstate' => $item['detectedstate'],
                    'estimatedonsetdate' => '',
                    'gender' => $item['gender'],
                    'nationality' => $item['nationality'],
                    'notes' => $item['notes'],
                    'source1' => $item['source1'],
                    'source2' => $item['source2'],
                    'source3' => $item['source3'],
                    'statecode' => $item['statecode'],
                    'statepatientnumber' => $item['statepatientnumber'],
                    'statuschangedate' => $item['statuschangedate'],
                    'typeoftransmission' => $item['typeoftransmission'],
                ]);
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
