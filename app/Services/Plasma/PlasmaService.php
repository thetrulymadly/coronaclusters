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
    public function getEligibleDonors(string $donorType, ?string $state = null, ?string $city = null, int $limit = 10, bool $paginated = true, bool $nearby = false, ?int $radiusInKM = null);
}