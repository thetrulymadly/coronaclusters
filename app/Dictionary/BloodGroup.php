<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     29 April 2021
 */

namespace App\Dictionary;

use BenSampo\Enum\Enum;

/**
 * Class BloodGroup
 * @package App\Dictionary
 */
class BloodGroup extends Enum
{

    const A_POSITIVE = 'A+';

    const A_NEGATIVE = 'A-';

    const B_POSITIVE = 'B+';

    const B_NEGATIVE = 'B-';

    const O_POSITIVE = 'O+';

    const O_NEGATIVE = 'O-';

    const AB_POSITIVE = 'AB+';

    const AB_NEGATIVE = 'AB-';

    const DONT_KNOW = 'Don\'t Know';

    /**
     * @param string $value
     *
     * @return string
     */
    public static function getUrlName(string $value): string
    {
        if (strstr($value, '+')) {
            return str_replace('+', 'positive', $value);
        }
        if (strstr($value, '-')) {
            return str_replace('-', 'negative', $value);
        }

        return 'plasma';
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public static function getValueFromUrl(string $url): string
    {
        if (strstr($url, 'positive')) {
            return str_replace('positive', '+', $url);
        }
        if (strstr($url, 'negative')) {
            return str_replace('negative', '-', $url);
        }

        return 'Don\'t Know';
    }
}
