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

    const A_PLUS = 'A+';

    const A_MINUS = 'A-';

    const B_PLUS = 'B+';

    const B_MINUS = 'B-';

    const O_PLUS = 'O+';

    const O_MINUS = 'O-';

    const AB_PLUS = 'AB+';

    const AB_MINUS = 'AB-';

    const DONT_KNOW = 'Don\'t Know';
}
