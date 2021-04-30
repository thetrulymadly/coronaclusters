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
 * Class Gender
 * @package App\Dictionary
 */
class Gender extends Enum
{

    const MALE = 'male';

    const FEMALE = 'female';

    const OTHER = 'other';
}
