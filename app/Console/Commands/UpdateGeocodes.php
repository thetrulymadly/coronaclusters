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
 * Class UpdateGeocodes
 * @package App\Console\Commands
 */
class UpdateGeocodes extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid:update_geocodes {?--errors}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update COVID patients data';

    /**
     * @var string
     */
    protected $api_url;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var int
     */
    protected $updates = 0;

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
        if (empty(config('corona.google_api_key'))) {
            $this->error('Google API key is required');

            return 1;
        } else {
            $this->api_url = config('corona.api.google_geocode_api');
        }

        $data = CovidRawData::where('geo_updated', false)->chunk(500, function ($data) {
            // Get location data from google
            $geoCodes = [];
            foreach ($data as $patient) {
                if (count($this->errors) > 5) {
                    break;
                }
                if (!empty($patient->detectedcity)) {
                    $geoCodes[$patient->id]['geo_city'] = $this->getGeocode($patient->detectedcity);
                } elseif (!empty($patient->detecteddistrict)) {
                    $geoCodes[$patient->id]['geo_district'] = $this->getGeocode($patient->detectedstate);
                } elseif (!empty($patient->detectedstate)) {
                    $geoCodes[$patient->id]['geo_state'] = $this->getGeocode($patient->detectedstate);
                } else {
                    $geoCodes[$patient->id]['geo_country'] = $this->getGeocode('India');
                }
            }

            // Save to DB
            foreach ($geoCodes as $id => $geoCode) {
                $column = key($geoCode);
                $value = $geoCode[$column];
                if (empty($value)) {
                    continue;
                }

                $patient = $data->where('id', $id)->first();
                $patient->$column = array_values($geoCode);
                $patient->geo_updated = true;
                $patient->save();
                $this->updates++;
            }
        });

        $this->info('Updates: ' . $this->updates . ' / ' . $data->count());

        if ($this->option('errors') && count($this->errors)) {
            $this->warn('Error: ' . json_encode($this->errors[0]));
        }

        return 0;
    }

    /**
     * @param $address
     *
     * @return bool|array
     */
    private function getGeocode($address)
    {
        $client = new Client();
        try {
            $response = $client->get($this->api_url . $address);
        } catch (Exception $exception) {
            $this->warn('Failed to fetch data');
            $this->error('Following error occurred: ' . $exception->getMessage());

            return [];
        }

        $response = json_decode($response->getBody()->getContents(), true);

        if ($response['status'] === 'OK') {
            return $response['results'][0]['geometry']['location']; // output => {"lat" : 37.4224764, "lng" : -122.0842499 }
        } else {
            if ($this->option('errors')) {
                $this->errors[] = $response;
            }

            return [];
        }
    }
}
