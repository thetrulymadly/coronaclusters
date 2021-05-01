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
 * Class PlasmaRequestController
 * @package App\Http\Controllers\Plasma
 */
class PlasmaRequestController extends Controller
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
     * PlasmaRequestController constructor.
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
        if (!empty($phoneNumber = Cookie::get('phone_number'))) {
            $loggedInDonor = PlasmaDonor::where('phone_number', $phoneNumber)->first();
        }

        $donors = PlasmaDonor::with(['geoState', 'geoCity'])->requester();

        if (!empty($state = $request->state)) {
            $donors->where('state', $state);
        } elseif (!empty($loggedInDonor)) {
            $donors->where('state', $loggedInDonor->state);
        }

        if (!empty($city = $request->city)) {
            $donors->where('city', $city);
        }

        $donors = $donors->latest()->paginate(20);

        return view('plasma.donors', [
            'breadcrumbs' => $this->getBreadcrumbs(),
            'title' => trans('plasma.page.plasma_requests.title'),
            'description' => trans('plasma.page.plasma_requests.meta.description'),
            'url' => request()->url(),
            'keywords' => trans('plasma.page.plasma_requests.meta.keywords'),
            'donors' => $donors,
            'donorType' => PlasmaDonorType::REQUESTER,
            'loggedInDonor' => $loggedInDonor ?? null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // Check if logged in
        if (!empty($phoneNumber = Cookie::get('phone_number'))) {
            $loggedInDonor = PlasmaDonor::where('phone_number', $phoneNumber)->first();
            if (!empty($loggedInDonor)) {
                // if logged in: show user's state/city donors by default
                $state = $loggedInDonor->state;
                $city = $loggedInDonor->city;
            }
        }

        // Get eligible donors
        $donors = $this->plasmaService->getEligibleDonors(
            $state ?? null,
            $city ?? null,
            10
        );

        return view('plasma.plasma_form', [
            'breadcrumbs' => $this->getBreadcrumbs(),
            'title' => trans('plasma.page.request_plasma.title'),
            'description' => trans('plasma.page.request_plasma.meta.description'),
            'url' => request()->url(),
            'keywords' => trans('plasma.page.request_plasma.meta.keywords'),
            'donors' => $donors,
            'donorType' => PlasmaDonorType::REQUESTER,
            'loggedInDonor' => $loggedInDonor ?? null,
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
        if (PlasmaDonor::requester()->where('phone_number', $request->phone_number)->exists()) {
            toastr()->success('Please check the donors list for suitable donors', 'Already Registered');

            return back()->withCookie(\cookie()->make('logged_in', 'true', 0, '/', config('app.cookie_domain'), true, false, false, 'None'));
        }

        $uuidHex = PlasmaHelper::generateHexUUID();

        PlasmaDonor::create([
            'uuid' => PlasmaHelper::generateUUID(PlasmaDonorType::REQUESTER),
            'uuid_hex' => $uuidHex,
            'donor_type' => PlasmaDonorType::REQUESTER,
            'name' => $request->name,
            'gender' => $request->gender,
            'age' => $request->age,
            'blood_group' => $request->blood_group,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'district' => $request->district,
            'state' => $request->state,
            'hospital' => $request->hospital,
            'date_of_positive' => Carbon::parse($request->date_of_positive)->toDateString(),
        ]);

        // Send OTP
        $this->otpService->send($request->phone_number);

        toastr()->success('Here is a list of donors suitable for you.', 'Request registered successfully!');

        return redirect('plasma/donors')->with('verify_otp', true)->with('phone_number', $request->phone_number);
    }
}
