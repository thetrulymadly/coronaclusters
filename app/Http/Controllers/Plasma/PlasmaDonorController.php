<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     23 April 2021
 */

namespace App\Http\Controllers\Plasma;

use App\Dictionary\PlasmaDonorType;
use App\Helpers\PlasmaHelper;
use App\Http\Controllers\Controller;
use App\Models\PlasmaDonor;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class PlasmaDonorController
 * @package App\Http\Controllers\Plasma
 */
class PlasmaDonorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $donors = PlasmaDonor::with(['geoCity', 'geoState'])->donor()->latestFirst()->get();

        return view('plasma.donors', [
            'breadcrumbs' => $this->getBreadcrumbs(),
            'title' => trans('plasma.page.plasma_donors.title'),
            'description' => trans('plasma.page.plasma_donors.meta.description'),
            'url' => request()->url(),
            'keywords' => trans('plasma.page.plasma_donors.meta.keywords'),
            'donors' => $donors,
            'donorType' => PlasmaDonorType::DONOR,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $donors = PlasmaDonor::requester()->latestFirst()->get();

        return view('plasma.plasma_form', [
            'breadcrumbs' => $this->getBreadcrumbs(),
            'title' => trans('plasma.page.donate_plasma.title'),
            'description' => trans('plasma.page.donate_plasma.meta.description'),
            'url' => request()->url(),
            'keywords' => trans('plasma.page.donate_plasma.meta.keywords'),
            'donors' => $donors,
            'donorType' => PlasmaDonorType::DONOR,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    public function store(Request $request)
    {
        PlasmaDonor::create([
            'uuid' => PlasmaHelper::generateUUID(PlasmaDonorType::DONOR),
            'donor_type' => PlasmaDonorType::DONOR,
            'name' => $request->name,
            'gender' => $request->gender,
            'age' => $request->age,
            'blood_group' => $request->blood_group,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'district' => $request->district,
            'state' => $request->state,
            'date_of_positive' => Carbon::parse($request->date_of_positive)->toDateString(),
            'date_of_negative' => Carbon::parse($request->date_of_negative)->toDateString(),
        ]);

        return redirect('plasma/requests');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\PlasmaDonor $plasmaDonor
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PlasmaDonor $plasmaDonor)
    {
        //
    }
}
