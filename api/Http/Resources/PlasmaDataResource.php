<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     23 April 2021
 */

namespace Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CitiesResource
 * @package Api\Http\Resources\Geo
 */
class PlasmaDataResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'location' => $this->geoCity->name . ', ' . $this->geoState->name,
            'donor' => $this->gender . '/ ' . $this->age,
            'requester' => $this->gender . '/ ' . $this->age,
            'blood_group' => $this->blood_group,
            'phone_number' => $this->phone_number,
            'date_of_negative' => $this->date_of_negative,
            'date_of_positive' => $this->date_of_positive,
            'created_at' => $this->created_at,
        ];
    }
}