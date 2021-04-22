<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     22 April 2021
 */

namespace App\Helpers;

use App\Dictionary\PlasmaDonorType;

/**
 * Class PlasmaHelper
 * @package App\Helpers
 */
final class PlasmaHelper
{

    /**
     * Generates a unique id for plasma donor/requester
     *̀
     *
     * @param string $donorType
     *
     * @return string
     */
    public static function generateUUID(string $donorType): string
    {
        // TODO: Put current year in uuid
        $random_id = 'CC' . (string)now()->year;
        $random_id .= rand(pow(10, 5 - 1), pow(10, 5) - 1);
        $random_id .= $donorType === PlasmaDonorType::DONOR ? 'DNR' : 'REQ';
        $random_id .= round(microtime(true));

        return $random_id;
    }
}
