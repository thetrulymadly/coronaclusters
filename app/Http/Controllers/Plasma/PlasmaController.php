<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     23 April 2021
 */

namespace App\Http\Controllers\Plasma;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Plasma\DTO\DonorRequestParamsDTO;
use App\Models\PlasmaDonor;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PlasmaController
 * @package App\Http\Controllers\Plasma
 */
class PlasmaController extends Controller
{

    public function index()
    {
        $plasmaCount = [
            'requests' => PlasmaDonor::requester()->count(),
            'requests_delta' => PlasmaDonor::requester()->whereDate('created_at', now()->toDateString())->count(),
            'donors' => PlasmaDonor::donor()->count(),
            'donors_delta' => PlasmaDonor::donor()->whereDate('created_at', now()->toDateString())->count(),
        ];

        return view('plasma.index', [
            'breadcrumbs' => $this->getBreadcrumbs(),
            'title' => trans('plasma.page.plasma.title'),
            'description' => trans('plasma.page.plasma.meta.description'),
            'url' => request()->url(),
            'keywords' => trans('plasma.page.plasma.meta.keywords'),
            'plasmaCount' => $plasmaCount,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $requestId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function donorDetail(string $requestId)
    {
        $request = DonorRequestParamsDTO::getParams($requestId);

        if (empty($request)) {
            throw new NotFoundHttpException();
        }

        if (empty($donor = PlasmaDonor::with(['geoState', 'geoCity'])->uuidHex($request->uuidHex)->first())) {
            throw new NotFoundHttpException();
        }

        if (!DonorRequestParamsDTO::validateParams($donor, $request)) {
            throw new NotFoundHttpException();
        }

        $breadcrumbs = $this->getBreadcrumbs();
        array_pop($breadcrumbs);
        $breadcrumbs[] = [
            'url' => $request->uuidHex,
            'name' => $request->uuidHex,
        ];

        return view('plasma.detail', [
            'breadcrumbs' => $breadcrumbs,
            'title' => trans('plasma.page.' . $donor->donor_type . '_detail.title', [
                'state' => $request->state,
                'city' => $request->city,
                'gender' => $request->gender,
                'age' => $request->age,
                'blood_group' => $request->bloodGroup,
            ]),
            'description' => trans('plasma.page.' . $donor->donor_type . '_detail.meta.description', [
                'state' => $request->state,
                'city' => $request->city,
                'gender' => $request->gender,
                'age' => $request->age,
                'blood_group' => $request->bloodGroup,
            ]),
            'url' => request()->url(),
            'keywords' => trans('plasma.page.' . $donor->donor_type . '_detail.meta.keywords', [
                'state' => $request->state,
                'city' => $request->city,
                'gender' => $request->gender,
                'age' => $request->age,
                'blood_group' => $request->bloodGroup,
            ]),
            'donor' => $donor,
        ]);
    }
}
