<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     01 May 2021
 */

namespace App\Services\Plasma;

use App\Models\PlasmaDonor;

class PlasmaServiceImpl implements PlasmaService
{

    /**
     * @param string|null $state
     * @param string|null $city
     * @param int $limit
     * @param bool $paginated
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getEligibleDonors(?string $state = null, ?string $city = null, int $limit = 10, bool $paginated = true)
    {
        // Get donors
        $donors = PlasmaDonor::with(['geoCity', 'geoState']);

        // State query
        if (!empty($state)) {
            $donors->where('state', $state);
        }

        // City query
        if (!empty($city)) {
            $donors->where('city', $city);
        }

        // Donor eligibility criteria:
        // Show donors who got positive more than 28 days days ago
        $donors->where('date_of_positive', '<=', now()->subDays(28)->toDateString());
        // Show donors who donated more than 2 weeks ago
        $donors->where(function ($query) {
            $query->whereNull('last_donated_on');
            $query->orWhere('last_donated_on', '<=', now()->subWeeks(2)->toDateString());

            return $query;
        });

        // Latest donors whose details are not invalid
        $donors->latest()->donor()->notInvalid();

        // Send paginated results
        if (!$paginated) {
            return $donors->limit($limit)->get();
        }

        return $donors->paginate($limit);
    }
}