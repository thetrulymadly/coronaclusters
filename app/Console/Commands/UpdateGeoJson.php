<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     21 April 2020
 */

namespace App\Console\Commands;

use App\Models\CovidRawData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UpdateGeoJson extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid:update_geojson';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update geoJson for locations of COVID patients from raw data';

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
        $tempFile = 'geoData_temp.json';
        if (Storage::exists($tempFile)) {
            Storage::delete($tempFile);
        }
        Storage::put($tempFile, '{"type": "FeatureCollection", "features": [ ');

        $latestId = CovidRawData::where('geo_updated', true)->max('id');
        CovidRawData::where('geo_updated', true)->limit(10)
            ->chunk(1000, function ($rawData) use ($tempFile, $latestId) {
                foreach ($rawData as $data) {
                    $location = $data->geo_city ?? $data->geo_district ?? $data->geo_state ?? $data->geo_country ?? [];

                    if (!empty($location)) {
                        if (!empty($data->numcases)) {
                            for ($i = 1; $i <= $data->numcases; $i++) {
                                $this->createFeature($tempFile, $location, $data, $latestId);
                            }
                        } else {
                            $this->createFeature($tempFile, $location, $data, $latestId);
                        }
                    }
                }
            });

        Storage::append($tempFile, ']}');

        $validator = Validator::make(['file' => Storage::get($tempFile)], [
            'file' => 'required|json',
        ]);

        // Throw validation error if validation fails
        if ($validator->fails()) {
            $this->error('Invalid Json');
        }

        $fileName = 'geoData.json';

        if (Storage::exists($fileName)) {
            Storage::delete($fileName);
        }

        $created = Storage::copy($tempFile, $fileName);
        Storage::delete($tempFile);

        if ($created) {
            $this->comment($fileName . ' created');
        }

        return 0;
    }

    private function createFeature($tempFile, $location, $data, $latestId)
    {
        $json = '{"type": "Feature","geometry": {"type": "Point","coordinates": [' . $location[0]['lng'] . ', ' . $location[0]['lat'] . ']}, "properties": {"name": "' . 'P' . $data->patientnumber . '"}}';
        if ($data->id !== $latestId) {
            $json .= ',';
        }
        Storage::append($tempFile, $json);
    }
}
