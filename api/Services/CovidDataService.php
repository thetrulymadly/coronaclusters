<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     21 April 2020
 */

namespace Api\Services;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface CovidDataService
 * @package Api\Services
 */
interface CovidDataService
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
    public function getRawData(?Builder $data, string $state = '', string $city = '', $paginate = false, int $perPage = 10);

    /**
     * @param \Illuminate\Database\Eloquent\Builder|null $data
     * @param string|null $state
     * @param string|null $city
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function makeRawDataQuery(?Builder $data, string $state = '', string $city = ''): Builder;
}
