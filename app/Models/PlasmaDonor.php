<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     22 April 2021
 */

namespace App\Models;

use App\Dictionary\PlasmaDonorType;
use App\Models\Geo\City;
use App\Models\Geo\State;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlasmaDonor
 *
 * @property int $id
 * @property string $donor_type
 * @property string $name
 * @property string $gender
 * @property string $age
 * @property string $blood_group
 * @property string $phone_number
 * @property string $hospital
 * @property string $city
 * @property string $district
 * @property string $state
 * @property \Carbon\Carbon $date_of_positive
 * @property \Carbon\Carbon $date_of_negative
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class PlasmaDonor extends Model
{

    /**
     * @var array
     */
    protected $dates = [
        'date_of_positive',
        'date_of_negative',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'uuid',
        'donor_type',
        'name',
        'gender',
        'age',
        'blood_group',
        'phone_number',
        'hospital',
        'city',
        'district',
        'state',
        'date_of_positive',
        'date_of_negative',
    ];

    /**
     * @return string
     */
    public function getDateOfPositiveAttribute()
    {
        return $this->attributes['date_of_positive'] ? Carbon::parse($this->attributes['date_of_positive'])->toDateString() : '';
    }

    /**
     * @return string
     */
    public function getDateOfNegativeAttribute()
    {
        return $this->attributes['date_of_negative'] ? Carbon::parse($this->attributes['date_of_negative'])->toDateString() : '';
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeDonor($query)
    {
        return $query->where('donor_type', PlasmaDonorType::DONOR);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeRequester($query)
    {
        return $query->where('donor_type', PlasmaDonorType::REQUESTER);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function geoState()
    {
        return $this->hasOne(State::class, 'state_id', 'state');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function geoCity()
    {
        return $this->hasOne(City::class, 'city_id', 'city');
    }
}
