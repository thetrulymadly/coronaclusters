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
 * Class RequestStatus
 * @package App\Dictionary
 */
class RequestStatus extends Enum
{

    const ACTIVE = 'active';

    const FULFILLED_TM = 'fulfilled_tm';

    const FULFILLED_EXTERNAL = 'fulfilled_external';

    const PENDING = 'pending';
}
