<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     23 April 2021
 */

namespace Api\Http\Resources\Geo;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CitiesResource
 * @package Api\Http\Resources\Geo
 */
class CitiesResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => (string)$this->city_id,
            'text' => (int)$request->with_state === 1 ? $this->name . ', ' . $this->state->name : $this->name,
        ];
    }
}