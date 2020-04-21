<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     21 April 2020
 */

namespace Api\Http\Controllers;

use Api\Http\Requests\RawDataRequest;
use Api\Http\Resources\RawDataResourceCollection;
use Api\Services\CovidDataService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

/**
 * Class CoronaApiController
 * @package Api\Http\Controllers
 */
class CoronaApiController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \Api\Services\CovidDataService
     */
    private $covidDataService;

    /**
     * CoronaApiController constructor.
     *
     * @param \Api\Services\CovidDataService $covidDataService
     */
    public function __construct(CovidDataService $covidDataService)
    {
        $this->covidDataService = $covidDataService;
    }

    /**
     * @param \Api\Http\Requests\RawDataRequest $request
     *
     * @return \Api\Http\Resources\RawDataResourceCollection
     */
    public function getRawData(RawDataRequest $request)
    {
        $data = $this->covidDataService->getRawData(null, $request->state ?? '', $request->city ?? '', true);

        return new RawDataResourceCollection($data);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getGeoJson()
    {
        return response(Storage::get('geoData.json'))->withHeaders(['Content-Type' => 'application/json']);
    }
}
