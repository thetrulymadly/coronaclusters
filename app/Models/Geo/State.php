<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 *
 * @property int $state_id
 * @property int $country_id
 * @property string $name
 * @property int $zone_id
 * @property Country $country
 *
 * @package App\Models
 */
class State extends Model
{

    /**
     * @var string
     */
    protected $table = 'geo_state';

    /**
     * @var string
     */
    protected $primaryKey = 'state_id';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var bool
     */
    public $timestamps = false;

    public const TOP_CITIES = [
        2168, // Delhi
        2182, // Maharashtra
        2191, // Tamil Nadu
        2194, // West Bengal
        2185, // Karnataka
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'state_id', 'state_id');
    }

    /**
     * @param $query
     */
    public function scopeOfIndia($query)
    {
        $query->where('country_id', 113);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }
}

