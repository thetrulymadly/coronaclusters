<?php

namespace Api\Services;

use App\Models\Geo\City;
use App\Models\PlasmaDonor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class PlasmaDataServiceImpl implements PlasmaDataService
{

    const MIN_NEGATIVE_DAYS = 10;

    const MAX_DISTANCE = 100 * 1000; // 100 km

    const LOCATION_SCORE = "GREATEST(0, 5 - (coalesce(round((ST_Distance_Sphere(POINT(?, ?), POINT(us.lon, us.lat)) / ?)), 5)))";

    public function getTotalCount()
    {
        return Cache::remember('plasma:total:count', Carbon::now()->addMinutes('5'), function () {
            $requesters = PlasmaDonor::requester()->count();
            $donors = PlasmaDonor::donor()->count();

            return [
                'requests' => $requesters,
                'donors' => $donors,
            ];
        });
    }

    public function getActiveCount()
    {
        return Cache::remember('plasma:active:count', Carbon::now()->addMinutes('5'), function () {
            $requesters = PlasmaDonor::requester()->where('status', 'active')->count();
            $donors = PlasmaDonor::donor()->where('status', 'active')->count();

            return [
                'requests' => $requesters,
                'donors' => $donors,
            ];
        });
    }

    /**
     * @param string $type
     * @param array $bloodGroups
     * @param null $gender
     * @param null $negativeDate
     *
     * @return   \Illuminate\Database\Eloquent\Builder
     */
    public function getAllActiveUsers($type = 'donor', $bloodGroups = [], $gender = null, $negativeDate = null)
    {
        return $this->getActiveUsersQuery($type, $bloodGroups, $gender, $negativeDate);
    }

    /**
     * @param $cityId
     * @param string $type
     * @param array $bloodGroups
     * @param null $gender
     * @param null $negativeDate
     *
     * @return   \Illuminate\Database\Eloquent\Builder
     */
    public function getNearbyActiveUsers($cityId, $type = 'donor', $bloodGroups = [], $gender = null, $negativeDate = null)
    {
        $query = $this->getActiveUsersQuery($type, $bloodGroups, $gender, $negativeDate);
        $city = City::where('city_id', '=', $cityId)->first();

        if ($city) {
            $query->join('geo_city', 'geo_city.city_id', '=', 'plasma_donors.city');
            $query->whereRaw('round((ST_Distance_Sphere(POINT(?, ?), POINT(geo_city.lon, geo_city.lat)) )) <= ?', [
                $city->lon,
                $city->lat,
                self::MAX_DISTANCE,
            ]);
        }

        return $query;
    }

    /**
     * @param string $type
     * @param array $bloodGroups
     * @param null $gender
     * @param null $negativeDate
     *
     * @return   \Illuminate\Database\Eloquent\Builder
     */
    private function getActiveUsersQuery($type = 'donor', $bloodGroups = [], $gender = null, $negativeDate = null)
    {
        $query = PlasmaDonor::where('status', 'active')
            ->where('donor_type', $type)
            ->whereIn('blood_group', $bloodGroups);

        if ($gender) {
            $query->where('gender', $gender);
        }

        if ($negativeDate) {
            $query->where('date_of_negative', '<=', Carbon::now()->subDays(self::MIN_NEGATIVE_DAYS));
        }

        return $query;
    }
}