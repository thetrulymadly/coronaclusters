<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 *
 * @property int $country_id
 * @property string $name
 * @property \Illuminate\Database\Eloquent\Collection $states
 *
 * @package App\Models
 */
class Country extends Model
{

    protected $table = 'geo_country';

    protected $primaryKey = 'country_id';

    public $timestamps = false;

    const INDIA = 113;

    const US = 254;

    public function states()
    {
        return $this->hasMany(State::class, 'country_id', 'country_id');
    }
}
