<?php

namespace App\Http\Controllers;

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
        $donors = PlasmaDonor::all();

        return view('plasma.donors', [
            'breadcrumbs' => $this->breadCrumbs,
            'title' => trans('corona.page.plasma_donor.title'),
            'description' => trans('corona.page.plasma_donor.meta.description'),
            'url' => request()->url(),
            'keywords' => trans('corona.page.plasma_donor.meta.keywords'),
            'donors' => $donors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $requests = PlasmaDonor::where('donor_type', 'requester')->get();

        return view('plasma.donate_plasma', [
            'breadcrumbs' => $this->breadCrumbs,
            'title' => trans('corona.page.plasma_donor.title'),
            'description' => trans('corona.page.plasma_donor.meta.description'),
            'url' => request()->url(),
            'keywords' => trans('corona.page.plasma_donor.meta.keywords'),
            'requests' => $requests,
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
            'donor_type' => 'Donor',
            'name' => $request->name,
            'gender' => $request->gender,
            'age' => $request->age,
            'blood_group' => $request->blood_group,
            'phone_number' => $request->phone_number,
            'hospital' => $request->hospital,
            'city' => $request->city,
            'district' => $request->district,
            'state' => $request->state,
            'date_of_positive' => Carbon::parse($request->date_of_positive)->toDateTimeString(),
            'date_of_negative' => Carbon::parse($request->date_of_negative)->toDateTimeString(),
        ]);

        return route('donate-plasma.index');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\PlasmaDonor $plasmaDonor
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PlasmaDonor $plasmaDonor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PlasmaDonor $plasmaDonor
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlasmaDonor $plasmaDonor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\PlasmaDonor $plasmaDonor
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlasmaDonor $plasmaDonor)
    {
        //
    }
}