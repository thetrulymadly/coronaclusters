<?php

namespace App\Http\Controllers;

use App\Dictionary\PlasmaDonorType;
use App\Helpers\PlasmaHelper;
use App\Models\PlasmaDonor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlasmaDonorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $donors = PlasmaDonor::donor()->get();

        return view('plasma.donors', [
            'breadcrumbs' => $this->breadCrumbs,
            'title' => trans('corona.page.plasma_donor.title'),
            'description' => trans('corona.page.plasma_donor.meta.description'),
            'url' => request()->url(),
            'keywords' => trans('corona.page.plasma_donor.meta.keywords'),
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
        $donors = PlasmaDonor::requester()->get();

        return view('plasma.plasma_form', [
            'breadcrumbs' => $this->breadCrumbs,
            'title' => trans('corona.page.donate_plasma.title'),
            'description' => trans('corona.page.donate_plasma.meta.description'),
            'url' => request()->url(),
            'keywords' => trans('corona.page.donate_plasma.meta.keywords'),
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

        return redirect('plasma-donors');
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
