<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     01 May 2021
 */

namespace App\Services\Plasma;

use App\Dictionary\DetailsVerified;
use App\Dictionary\PlasmaDonorType;
use App\Models\Geo\City;
use App\Models\PlasmaDonor;

class PlasmaServiceImpl implements PlasmaService
{

    /**
     * @param string $donorType
     * @param string|null $state
     * @param string|null $city
     * @param int $limit
     * @param bool $paginated
     * @param bool $nearby
     * @param int|null $radiusInKM
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|int
     */
    public function getEligibleDonors(
        string $donorType,
        ?string $state = null,
        ?string $city = null,
        int $limit = 10,
        bool $paginated = true,
        bool $nearby = false,
        ?int $radiusInKM = null
    ) {
        // Get donors
        $donors = PlasmaDonor::with(['geoCity', 'geoState'])->where('donor_type', $donorType);

        // Get nearby donors/requests
        if ($nearby && !empty($city)) {
            $this->nearbyUsers($donors, $city, $radiusInKM);
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

        if (!empty($city)) {
            $donors->orderByRaw('IF(city = ?, 1, 2) ASC', [$city]);
        }
        $donors->orderByRaw('FIELD(details_verified, "?", "?") ASC', [
            DetailsVerified::VERIFIED,
            DetailsVerified::UNVERIFIED,
        ]);
        $donors->latest();

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

    /**
     * @param $query
     * @param int $cityId
     * @param int|null $radiusInKM
     *
     * @return mixed
     */
    private function nearbyUsers($query, int $cityId, int $radiusInKM = null)
    {
        $city = City::where('city_id', '=', $cityId)->first();

        if (!empty($city)) {
            $operator = '<=';
            if (($radiusInKM ?? config('plasma_donor.default_nearby_distance')) > config('plasma_donor.max_nearby_distance')) {
                $operator = '>';
            }
            $query->join('geo_city', 'geo_city.city_id', '=', 'plasma_donors.city');
            $query->whereRaw('round((ST_Distance_Sphere(POINT(?, ?), POINT(geo_city.lon, geo_city.lat)) )) ' . $operator . ' ?', [
                $city->lon,
                $city->lat,
                $radiusInKM * 1000, // distance in meters ( km x 1000)
            ]);
        }

        return $query;
    }
}