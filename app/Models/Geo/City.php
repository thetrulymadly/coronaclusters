<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class City
 *
 * @property int $id
 * @property int $city_id
 * @property int $country_id
 * @property int $state_id
 * @property string $name
 * @property string $lat
 * @property string $lon
 * @property string $display_name
 * @property float $latitude
 * @property float $longitude
 * @property int $tier
 * @property string $status
 *
 * @package App\Models
 */
class City extends Eloquent
{
    /**
     * @var string
     */
    protected $table = 'geo_city';
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = [
        'city_id' => 'int',
        'country_id' => 'int',
        'state_id' => 'int',
        'latitude' => 'float',
        'longitude' => 'float',
        'tier' => 'int'
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOfIndia($query)
    {
        return $query->where('country_id', 113);
    }
}
