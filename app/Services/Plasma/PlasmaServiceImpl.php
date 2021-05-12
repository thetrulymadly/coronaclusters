<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     01 May 2021
 */

namespace App\Services\Plasma;

use App\Dictionary\PlasmaDonorType;
use App\Models\Geo\City;
use App\Models\PlasmaDonor;

class PlasmaServiceImpl implements PlasmaService
{

    const MAX_DISTANCE = 100 * 1000; // 100 km

    /**
     * @param string $donorType
     * @param string|null $state
     * @param string|null $city
     * @param int $limit
     * @param bool $paginated
     * @param bool $nearby
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|int
     */
    public function getEligibleDonors(string $donorType, ?string $state = null, ?string $city = null, int $limit = 10, bool $paginated = true, bool $nearby = false)
    {
        // Get donors
        $donors = PlasmaDonor::with(['geoCity', 'geoState'])->where('donor_type', $donorType)->latest();

        // Get nearby donors/requests
        if ($nearby && !empty($city) && empty($state)) {
            $this->nearbyUsers($donors, $city);
        } else {
            // State query
            if (!empty($state)) {
                $donors->where('state', $state);
            }

            // City query
            if (!empty($city)) {
                $donors->where('city', $city);
            }
        }

        // Donor eligibility criteria:
        if ($donorType === PlasmaDonorType::DONOR) {
            // Show donors who got positive more than 28 days days ago
            $donors->where('date_of_positive', '<=', now()->subDays(28)->toDateString());
            // Show donors who donated more than 2 weeks ago
            $donors->where(function ($query) {
                $query->whereNull('last_donated_on');
                $query->orWhere('last_donated_on', '<=', now()->subWeeks(2)->toDateString());

                return $query;
            });

            // Latest donors whose details are not invalid and not on hold
            $donors->notOnHold()->notInvalid();
        }

        // Send all results if not paginated
        if (!$paginated) {
            // Send only count if limit is set to 0
            if ($limit === 0) {
                return $donors->count();
            }

            return $donors->limit($limit)->get();
        }

        // Send paginated results
        return $donors->paginate($limit);
    }

    private function nearbyUsers($query, int $cityId)
    {
        $city = City::where('city_id', '=', $cityId)->first();

        if (!empty($city)) {
            $query->join('geo_city', 'geo_city.city_id', '=', 'plasma_donors.city');
            $query->whereRaw('round((ST_Distance_Sphere(POINT(?, ?), POINT(geo_city.lon, geo_city.lat)) )) <= ?', [
                $city->lon,
                $city->lat,
                self::MAX_DISTANCE,
            ]);
        }

        return $query;
    }
}