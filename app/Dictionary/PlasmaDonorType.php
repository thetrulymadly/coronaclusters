<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     22 April 2021
 */

namespace App\Dictionary;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * Class PlasmaDonorType
 * @package App\Dictionary
 */
class PlasmaDonorType extends Enum implements LocalizedEnum
{

    const DONOR = 'donor';

    const REQUESTER = 'requester';
}
