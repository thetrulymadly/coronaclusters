<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     29 April 2021
 */

namespace App\Http\Controllers\Plasma\DTO;

use App\Dictionary\PlasmaDonorType;
use App\Models\PlasmaDonor;

/**
 * Class DonorRequestParamsDTO
 * @package App\Http\Controllers\Plasma\DTO
 */
class DonorRequestParamsDTO
{

    /**
     * @var string
     */
    public $uuidHex;

    /**
     * @var string
     */
    public $state;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $gender;

    /**
     * @var string
     */
    public $age;

    /**
     * @var string
     */
    public $bloodGroup;

    /**
     * @var string
     */
    public $donorType;

    /**
     * DonorRequestParamsDTO constructor.
     *
     * @param string $uuidHex
     * @param string $state
     * @param string $city
     * @param string $gender
     * @param string $age
     * @param string $bloodGroup
     * @param string $donorType
     */
    private function __construct(string $uuidHex, string $state, string $city, string $gender, string $age, string $bloodGroup, string $donorType)
    {
        $this->uuidHex = $uuidHex;
        $this->state = $state;
        $this->city = $city;
        $this->gender = $gender;
        $this->age = $age;
        $this->bloodGroup = $bloodGroup;
        $this->donorType = $donorType;
    }

    /**
     * @param string $requestId
     *
     * @return \App\Http\Controllers\Plasma\DTO\DonorRequestParamsDTO|null
     */
    public static function getParams(string $requestId)
    {
        $request = explode('-', $requestId);

        if (sizeof($request) < 7) {
            return null;
        }

        return new self(
            $request[0],
            $request[1],
            $request[2],
            $request[3],
            $request[4],
            $request[5],
            $request[6]
        );
    }

    public static function getTitle(self $request)
    {
        $donor = $request->donorType === PlasmaDonorType::REQUESTER ? 'Plasma Request' : 'Plasma Donor';
        return trans('plasma.request');
    }

    /**
     * @param \App\Models\PlasmaDonor $donor
     *
     * @return string
     */
    public static function makeUrl(PlasmaDonor $donor)
    {
        $url = $donor->donor_type === PlasmaDonorType::REQUESTER ? 'plasma/requests/' : 'plasma/donors/';

        return config('app.url') . $url .
            $donor->uuid_hex . '-' .
            $donor->geoState->name . '-' .
            $donor->geoCity->name . '-' .
            $donor->gender . '-' .
            $donor->age . '-' .
            $donor->blood_group . '-' .
            $donor->donor_type;
    }

    /**
     * @param \App\Models\PlasmaDonor $donor
     * @param \App\Http\Controllers\Plasma\DTO\DonorRequestParamsDTO $request
     *
     * @return bool
     */
    public static function validateParams(PlasmaDonor $donor, self $request)
    {
        if ($donor->geoState->name === $request->state &&
            $donor->geoCity->name === $request->city &&
            $donor->gender === $request->gender &&
            $donor->age === $request->age &&
            $donor->blood_group === $request->bloodGroup &&
            $donor->donor_type === $request->donorType
        ) {
            return true;
        }

        return false;
    }
}