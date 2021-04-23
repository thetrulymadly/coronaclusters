<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     23 April 2021
 */

namespace App\Http\Controllers\Plasma;

use App\Http\Controllers\Controller;
use App\Models\PlasmaDonor;

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
            'requests_delta' => PlasmaDonor::requester()->where('created_at', now()->toDateString())->count(),
            'donors' => PlasmaDonor::donor()->count(),
            'donors_delta' => PlasmaDonor::donor()->where('created_at', now()->toDateString())->count(),
        ];

        return view('plasma.index', [
            'breadcrumbs' => $this->getBreadcrumbs(),
            'title' => trans('corona.page.plasma.title'),
            'description' => trans('corona.page.plasma.meta.description'),
            'url' => request()->url(),
            'keywords' => trans('corona.page.plasma.meta.keywords'),
            'plasmaCount' => $plasmaCount,
        ]);
    }
}
