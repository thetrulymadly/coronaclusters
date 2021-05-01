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
use Illuminate\Database\Eloquent\Builder;
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
            $loggedInDonor = PlasmaDonor::where('phone_number', $phoneNumber)->first();
            if (!empty($loggedInDonor)) {
                // if logged in: show user's state/city donors by default
                $state = $loggedInDonor->state;
                $city = $loggedInDonor->city;
            }
        }

        // Get eligible donors
        $donors = $this->plasmaService->getEligibleDonors(
            $request->state ?? $state ?? null,
            $request->city ?? $city ?? null,
            20
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        if (!empty($phoneNumber = Cookie::get('phone_number'))) {
            $loggedInDonor = PlasmaDonor::where('phone_number', $phoneNumber)->first();
        }

        $donors = PlasmaDonor::with(['geoState', 'geoCity'])->requester();

        if (!empty($loggedInDonor)) {
            $donors->where('state', $loggedInDonor->state);
        }

        $donors = $donors->latest()->limit(10)->get();

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
     * @return string
     */
    public function store(Request $request)
    {
        if (PlasmaDonor::donor()->where('phone_number', $request->phone_number)->exists()) {
            toastr()->success('Please check the request list to help save lives.', 'Already Registered');

            return back()->withCookie(\cookie()->make('logged_in', 'true', (int)config('app.cookie_expire_minutes'), '/', config('app.cookie_domain'),
                true, false, false, 'None'));
        }

        $uuidHex = PlasmaHelper::generateHexUUID();

        PlasmaDonor::create([
            'uuid' => PlasmaHelper::generateUUID(PlasmaDonorType::DONOR),
            'uuid_hex' => $uuidHex,
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

        // Send OTP
        $this->otpService->send($request->phone_number);

        toastr()->success('Please check the request list and help someone in need.', 'Donor registered successfully');

        return redirect('plasma/requests')->with('verify_otp', true)->with('phone_number', $request->phone_number);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $donors
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getDonorEligibilityQuery(Builder $donors)
    {
        // Donor eligibility criteria:
        // Show donors who got positive more than 28 days days ago
        $donors->where('date_of_positive', '<=', now()->subDays(28)->toDateString());
        // Show donors who donated more than 2 weeks ago
        $donors->where(function ($query) {
            $query->whereNull('last_donated_on');
            $query->orWhere('last_donated_on', '<=', now()->subWeeks(2)->toDateString());

            return $query;
        });

        return $donors;
    }
}
