<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     01 May 2021
 */

namespace App\Services\Plasma;

interface PlasmaService
{

    /**
     * @param string|null $state
     * @param string|null $city
     * @param int $limit
     * @param bool $paginated
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getEligibleDonors(?string $state = null, ?string $city = null, int $limit = 10, bool $paginated = true);
}