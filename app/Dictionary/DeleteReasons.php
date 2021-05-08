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
 * Class DeleteReasons
 * @package App\Dictionary
 */
class DeleteReasons extends Enum
{

    const ALREADY_DONATED = 'already donated';

    const NOT_INTERESTED = 'not interested';

    const DID_NOT_REGISTER = 'did not register';

    const NO_COVID = 'no covid';

    const OTHER = 'other';
}
