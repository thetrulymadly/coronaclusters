<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     02 May 2021
 */

namespace Api\Http\Controllers\Plasma;

use Api\Helpers\ResponseHelper;
use App\Dictionary\DeletedBy;
use App\Models\PlasmaDonor;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

/**
 * Class PlasmaAccountController
 * @package Api\Http\Controllers\Plasma
 */
class PlasmaAccountController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return ResponseHelper::success()
            ->withCookie(\cookie()->forget('logged_in', '/', config('app.cookie_domain')))
            ->withCookie(\cookie()->forget('phone_number', '/', config('app.cookie_domain')));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteRegistration()
    {
        if (empty($phoneNumber = Cookie::get('phone_number'))) {
            return ResponseHelper::failure();
        }

        $donor = PlasmaDonor::where('phone_number', $phoneNumber)->first();

        $deleted = DB::transaction(function () use ($donor) {
            $donor->deleted_by = DeletedBy::USER;
            $donor->save();

            return $donor->delete();
        });

        if (!$deleted) {
            return ResponseHelper::failure();
        }

        return ResponseHelper::success()
            ->withCookie(\cookie()->forget('logged_in', '/', config('app.cookie_domain')))
            ->withCookie(\cookie()->forget('phone_number', '/', config('app.cookie_domain')));
    }
}