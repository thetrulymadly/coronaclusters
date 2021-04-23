<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     23 April 2021
 */

namespace Api\Http\Controllers\Geo;

use Api\Http\Resources\Geo\CitiesResource;
use Api\Http\Resources\Geo\StatesResource;
use App\Models\Geo\City;
use App\Models\Geo\State;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;

/**
 * Class GeoController
 * @package Api\Http\Controllers\Geo
 */
class GeoController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchState(Request $request)
    {
        $states = State::ofIndia()->where('name', 'like', '%' . $request->term . '%');
        if (empty($request->term)) {
            $states = $states->whereIn('state_id', State::TOP_CITIES);
        }
        $states = $states->select(['state_id', 'name'])
            ->orderBy('name', 'asc')
            ->get();

        return Response::json([
            'results' => StatesResource::collection($states),
            'pagination' => ['more' => false],
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchCity(Request $request)
    {
        $cities = City::ofIndia()
            ->where('state_id', (int)$request->state_id)
            ->where('name', 'like', '%' . $request->term . '%')
            ->select(['city_id', 'name'])
            ->orderBy('name', 'asc')
            ->get();

        return Response::json([
            'results' => CitiesResource::collection($cities),
            'pagination' => ['more' => false],
        ]);
    }
}
