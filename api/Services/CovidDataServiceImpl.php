<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     21 April 2020
 */

namespace Api\Services;

use App\Models\CovidRawData;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CovidDataServiceImpl
 * @package Api\Services
 */
class CovidDataServiceImpl implements CovidDataService
{

    /**
     * @param \Illuminate\Database\Eloquent\Builder|null $data
     * @param string $state
     * @param string $city
     * @param bool $paginate
     * @param int $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getRawData(?Builder $data, string $state = '', string $city = '', $paginate = false, int $perPage = 10)
    {
        $query = $this->makeRawDataQuery($data, $state, $city);

        return $paginate ? $query->paginate($perPage) : $query->get();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|null $data
     * @param string|null $state
     * @param string|null $city
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function makeRawDataQuery(?Builder $data, string $state = '', string $city = ''): Builder
    {
        if ($data === null) {
            $data = CovidRawData::query();
        }

        if (empty($state) && empty($city)) {
            return $data;
        }

        if (!empty($city)) {
            $data->where(function ($q) use ($city) {
                $q->where('detectedcity', $city);
                $q->where('detectedDistrict', $city);
            });
        }
        if (!empty($state)) {
            $data->where('detectedstate', $state);
        }

        return $data;
    }

    public function getGeoJson($state = '', $city = '')
    {
        $rawData = CovidRawData::where('geo_updated', 1);

        $rawData = $this->getRawData($rawData, $state, $city);

        $geoData = [];
        foreach ($rawData as $data) {
            $location = $data->geo_city ?? $data->geo_district ?? $data->geo_state ?? $data->geo_country ?? [];

            $geoData[] = [
                'type' => 'feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$location[0]['lng'], $location[0]['lat']],
                ],
                'properties' => [
                    'name' => $data->patientnumber,
                ],
            ];
        }

        $geoJson = [
            'type' => 'FeatureCollection',
            'features' => $geoData,
        ];
    }
}
