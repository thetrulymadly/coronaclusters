<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     22 April 2021
 */

namespace App\Models;

use App\Dictionary\DetailsVerified;
use App\Dictionary\DonorStatus;
use App\Dictionary\PlasmaDonorType;
use App\Http\Controllers\Plasma\DTO\DonorRequestParamsDTO;
use App\Models\Geo\City;
use App\Models\Geo\State;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property \App\Models\Geo\State $geoState
 * @property \App\Models\Geo\City $geoCity
 *
 * @package App\Models
 */
class PlasmaDonor extends Model
{

    use SoftDeletes;

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
        'uuid_hex',
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
        'deleted_by',
    ];

    protected $appends = [
        'url',
    ];

    public function getUrlAttribute()
    {
        return DonorRequestParamsDTO::makeUrl($this);
    }

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
     * @param string $uuid
     *
     * @return mixed
     */
    public function scopeUuid($query, string $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    /**
     * @param $query
     * @param string $uuidHex
     *
     * @return mixed
     */
    public function scopeUuidHex($query, string $uuidHex)
    {
        return $query->where('uuid_hex', $uuidHex);
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
    public function scopeNotInvalid($query)
    {
        return $query->where('details_verified', '!=', DetailsVerified::INVALID);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotOnHold($query)
    {
        return $query->where('donor_status', '!=', DonorStatus::HOLD);
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
