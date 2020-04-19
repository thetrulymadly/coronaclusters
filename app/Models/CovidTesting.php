<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     20 April 2020
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CovidTesting
 *
 * @property int $id
 * @property int $testsconductedbyprivatelabs
 * @property int $totalindividualstested
 * @property int $totalpositivecases
 * @property int $totalsamplestested
 * @property string $source
 * @property Carbon $updatetimestamp
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class CovidTesting extends Model
{

    /**
     * @var string
     */
    protected $table = 'covid_testing';

    /**
     * @var array
     */
    protected $casts = [
        'testsconductedbyprivatelabs' => 'int',
        'totalindividualstested' => 'int',
        'totalpositivecases' => 'int',
        'totalsamplestested' => 'int',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'updatetimestamp',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'testsconductedbyprivatelabs',
        'totalindividualstested',
        'totalpositivecases',
        'totalsamplestested',
        'source',
        'updatetimestamp',
    ];
}
