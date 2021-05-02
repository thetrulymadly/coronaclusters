<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     02 May 2021
 */

namespace Api\Http\Controllers\Plasma;

use Api\Http\Requests\PlasmaDataRequest;
use Api\Http\Resources\PlasmaDataResource;
use Api\Services\PlasmaDataServiceImpl;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * Class PlasmaApiController
 * @package Api\Http\Controllers
 */
class PlasmaApiController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param \Api\Services\PlasmaDataServiceImpl $plasmaDataService
     *
     * @return array
     */
    public function getCount(PlasmaDataServiceImpl $plasmaDataService)
    {
        return [
            'total_count' => $plasmaDataService->getTotalCount(),
            'active_count' => $plasmaDataService->getActiveCount(),
        ];
    }

    /**
     * @param \Api\Http\Requests\PlasmaDataRequest $plasmaDataRequest
     * @param \Api\Services\PlasmaDataServiceImpl $plasmaDataService
     *
     * @return array
     */
    public function getActiveUsers(PlasmaDataRequest $plasmaDataRequest, PlasmaDataServiceImpl $plasmaDataService)
    {
        $type = $plasmaDataRequest->type;
        $blood_groups = $plasmaDataRequest->blood_groups;
        $gender = $plasmaDataRequest->gender;
        $negativeDate = $plasmaDataRequest->negative_date;
        $cityId = $plasmaDataRequest->city_id;

        if ($cityId) {
            $query = $plasmaDataService->getNearbyActiveUsers($cityId, $type, $blood_groups, $gender, $negativeDate);

        } else {
            $query = $plasmaDataService->getAllActiveUsers($type, $blood_groups, $gender, $negativeDate);
        }

        //TODO implement pagination: For future backward compatibility wrap the collection

        $users = $query->with(['GeoCity', 'GeoState'])->get();

        return [
            'total' => count($users),
            'count' => count($users),
            'per_page' => count($users),
            'data' => PlasmaDataResource::collection($users),
        ];
    }
}
