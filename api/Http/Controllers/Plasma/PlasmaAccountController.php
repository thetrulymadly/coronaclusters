<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     02 May 2021
 */

namespace Api\Http\Controllers\Plasma;

use Api\Helpers\ResponseHelper;
use Api\Http\Requests\Plasma\DeletePlasmaRequest;
use App\Dictionary\DeletedBy;
use App\Models\PlasmaDonor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param \Api\Http\Requests\Plasma\DeletePlasmaRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteRegistration(DeletePlasmaRequest $request): JsonResponse
    {
        if (empty($phoneNumber = Cookie::get('phone_number'))) {
            return ResponseHelper::failure();
        }

        $donor = PlasmaDonor::where('phone_number', $phoneNumber)->first();

        $deleted = DB::transaction(function () use ($donor, $request) {
            $donor->deleted_by = DeletedBy::USER;
            $donor->delete_reason = $request->delete_reason;
            $donor->delete_reason_other = $request->delete_reason_other;
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