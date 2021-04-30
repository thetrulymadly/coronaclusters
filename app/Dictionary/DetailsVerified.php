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
 * Class DetailVerified
 * @package App\Dictionary
 */
class DetailsVerified extends Enum
{

    const UNVERIFIED = 'unverified';

    const VERIFIED = 'verified';

    const INVALID = 'invalid';
}
