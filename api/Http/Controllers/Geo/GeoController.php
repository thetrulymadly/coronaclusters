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
     * @return \Api\Http\Resources\Geo\StatesResource|\Illuminate\Http\JsonResponse
     */
    public function searchState(Request $request)
    {
        $states = State::ofIndia()->where('name', 'like', '%' . $request->term . '%');

        if (!empty($request->state_id)) {
            $states->where('state_id', (int)$request->state_id);
        } elseif (empty($request->term)) {
            $states = $states->whereIn('state_id', State::TOP_STATES);
        }
        $states = $states->select(['state_id', 'name'])
            ->orderBy('name', 'asc')
            ->get();

        if (!empty($request->state_id)) {
            return StatesResource::make($states->first());
        }

        return Response::json([
            'results' => StatesResource::collection($states),
            'pagination' => ['more' => false],
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Api\Http\Resources\Geo\CitiesResource|\Illuminate\Http\JsonResponse
     */
    public function searchCity(Request $request)
    {
        $cities = City::ofIndia();
        if ((int)$request->with_state === 1) {
            $cities->with('state');
        }

        if (!empty($request->city_id)) {
            $cities->where('city_id', (int)$request->city_id);
        } elseif (!empty($request->state_id)) {
            $cities->where('state_id', (int)$request->state_id);
        } elseif (empty($request->state_id) & empty($request->term)) {
            $cities->whereIn('city_id', City::TOP_CITIES);
        }

        if (!empty($request->term)) {
            $cities->where('name', 'like', '%' . $request->term . '%');
        }

        $cities = $cities->orderBy('name', 'asc')->get();

        if (!empty($request->city_id)) {
            return CitiesResource::make($cities->first());
        }

        return Response::json([
            'results' => CitiesResource::collection($cities),
            'pagination' => ['more' => false],
        ]);
    }
}
