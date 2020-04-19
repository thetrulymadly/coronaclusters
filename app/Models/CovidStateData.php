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
 * Class CovidStateData
 *
 * @property int $id
 * @property string $state
 * @property int $active
 * @property int $confirmed
 * @property int $deaths
 * @property int $recovered
 * @property int $delta_active
 * @property int $delta_confirmed
 * @property int $delta_deaths
 * @property int $delta_recovered
 * @property Carbon $lastupdatedtime
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class CovidStateData extends Model
{

    /**
     * @var string
     */
    protected $table = 'covid_state_data';

    /**
     * @var array
     */
    protected $casts = [
        'active' => 'int',
        'confirmed' => 'int',
        'deaths' => 'int',
        'recovered' => 'int',
        'delta_active' => 'int',
        'delta_confirmed' => 'int',
        'delta_deaths' => 'int',
        'delta_recovered' => 'int',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'lastupdatedtime',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'state',
        'active',
        'confirmed',
        'deaths',
        'recovered',
        'delta_active',
        'delta_confirmed',
        'delta_deaths',
        'delta_recovered',
        'lastupdatedtime',
    ];

    /**
     * @param $value
     */
    public function setLastupdatedtimeAttribute($value)
    {
        $this->attributes['lastupdatedtime'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->toDateTimeString();
    }
}
