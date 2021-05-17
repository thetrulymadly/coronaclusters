<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     23 April 2021
 */

namespace App\Http\Controllers\Plasma;

use Api\Services\Otp\OtpVerificationService;
use App\Dictionary\PlasmaDonorType;
use App\Helpers\PlasmaHelper;
use App\Http\Controllers\Controller;
use App\Models\PlasmaDonor;
use App\Services\Plasma\PlasmaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

/**
 * Class PlasmaDonorController
 * @package App\Http\Controllers\Plasma
 */
class PlasmaDonorController extends Controller
{

    /**
     * @var \Api\Services\Otp\OtpVerificationService
     */
    private $otpService;

    /**
     * @var \App\Services\Plasma\PlasmaService
     */
    private $plasmaService;

    /**
     * PlasmaDonorController constructor.
     *
     * @param \App\Services\Plasma\PlasmaService $plasmaService
     * @param \Api\Services\Otp\OtpVerificationService $otpService
     */
    public function __construct(PlasmaService $plasmaService, OtpVerificationService $otpService)
    {
        $this->otpService = $otpService;
        $this->plasmaService = $plasmaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Check if logged in
        if (!empty($phoneNumber = Cookie::get('phone_number'))) {
            $loggedInDonor = PlasmaDonor::with(['geoState', 'geoCity'])->where('phone_number', $phoneNumber)->first();
        }

        // Requested state/city will be prioritized over default logged in user's state/city
        if (!empty($request->city) && $request->city === 'all') {
            $city = null;
        } elseif (!empty($request->state) || !empty($request->city)) {
            $state = $request->state;
            $city = $request->city;
        } elseif (!empty($loggedInDonor)) {
            // if logged in: show user's state/city donors by default
            $state = $loggedInDonor->state;
            $city = $loggedInDonor->city;
        }

        // Get eligible donors
        $donors = $this->plasmaService->getEligibleDonors(
            PlasmaDonorType::DONOR,
            $state ?? null,
            $city ?? null,
            20,
            true,
            isset($loggedInDonor) || !empty($city),
            $request->nearby_radius
        );

        return view('plasma.donors', [
            'breadcrumbs' => $this->getBreadcrumbs(),
            'title' => trans('plasma.page.plasma_donors.title'),
            'description' => trans('plasma.page.plasma_donors.meta.description'),
            'url' => request()->url(),
            'keywords' => trans('plasma.page.plasma_donors.meta.keywords'),
            'donors' => $donors,
            'donorType' => PlasmaDonorType::DONOR,
            'loggedInDonor' => $loggedInDonor ?? null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if (!empty($phoneNumber = Cookie::get('phone_number'))) {
            $loggedInDonor = PlasmaDonor::with(['geoState', 'geoCity'])->where('phone_number', $phoneNumber)->first();
            if (!empty($loggedInDonor)) {
                // if logged in: show user's state/city donors by default
                $city = $loggedInDonor->city;
            }
        }

        // Get eligible donors
        $donors = $this->plasmaService->getEligibleDonors(
            PlasmaDonorType::REQUESTER,
            null,
            $city ?? null,
            10,
            false,
            isset($loggedInDonor),
            $request->nearby_radius
        );

        return view('plasma.plasma_form', [
            'breadcrumbs' => $this->getBreadcrumbs(),
            'title' => trans('plasma.page.donate_plasma.title'),
            'description' => trans('plasma.page.donate_plasma.meta.description'),
            'url' => request()->url(),
            'keywords' => trans('plasma.page.donate_plasma.meta.keywords'),
            'donors' => $donors,
            'donorType' => PlasmaDonorType::DONOR,
            'loggedInDonor' => $loggedInDonor ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function store(Request $request)
    {
        if (PlasmaDonor::donor()->where('phone_number', $request->phone_number)->exists()) {
            toastr()->success('Please check the request list to help save lives.', 'Already Registered');

            return back()->withCookie(\cookie()->make('logged_in', 'true', (int)config('app.cookie_expire_minutes'), '/', config('app.cookie_domain'),
                true, false, false, 'None'));
        }

        $uuidHex = PlasmaHelper::generateHexUUID();

        $donor = PlasmaDonor::create([
            'uuid' => PlasmaHelper::generateUUID(PlasmaDonorType::DONOR),
            'uuid_hex' => $uuidHex,
            'donor_type' => PlasmaDonorType::DONOR,
            'name' => $request->name,
            'gender' => $request->gender,
            'age' => $request->age > 60 ? 60 : $request->age, // Don't let the age be greater than 60
            'blood_group' => $request->blood_group,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'district' => $request->district,
            'state' => $request->state,
            'date_of_positive' => Carbon::parse($request->date_of_positive)->toDateString(),
            'date_of_negative' => Carbon::parse($request->date_of_negative)->toDateString(),
        ]);

        // Send OTP
        $this->otpService->send($request->phone_number);

        toastr()->success('Please check the request list and help someone in need.', 'Donor registered successfully');

        return redirect($donor->url)->with('verify_otp', true)->with('phone_number', $request->phone_number);
    }
}
