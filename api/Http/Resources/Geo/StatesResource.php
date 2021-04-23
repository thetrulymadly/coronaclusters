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
 * Class StatesResource
 * @package Api\Http\Resources\Geo
 */
class StatesResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->state_id,
            'text' => $this->name,
        ];
    }
}