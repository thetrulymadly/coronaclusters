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
 * Class CovidRawData
 *
 * @property int $id
 * @property string $patientnumber
 * @property string $agebracket
 * @property string $contractedfromwhichpatientsuspected
 * @property string $currentstatus
 * @property string $statepatientnumber
 * @property string $statuschangedate
 * @property string $dateannounced
 * @property string $detectedcity
 * @property string $detecteddistrict
 * @property string $detectedstate
 * @property string $estimatedonsetdate
 * @property string $gender
 * @property string $nationality
 * @property string $notes
 * @property string $backupnotes
 * @property string $source1
 * @property string $source2
 * @property string $source3
 * @property array $geo_city
 * @property array $geo_district
 * @property array $geo_state
 * @property array $geo_country
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * Class CovidRawData
 * @package App\Models
 */
class CovidRawData extends Model
{

    /**
     * @var string
     */
    protected $table = 'covid_raw_data';

    /**
     * @var array
     */
    protected $casts = [
        'geo_city' => 'json',
        'geo_district' => 'json',
        'geo_state' => 'json',
        'geo_country' => 'json',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'patientnumber',
        'agebracket',
        'contractedfromwhichpatientsuspected',
        'currentstatus',
        'statepatientnumber',
        'statuschangedate',
        'dateannounced',
        'detectedcity',
        'detecteddistrict',
        'detectedstate',
        'estimatedonsetdate',
        'gender',
        'nationality',
        'notes',
        'backupnotes',
        'source1',
        'source2',
        'source3',
        'geo_city',
        'geo_district',
        'geo_state',
        'geo_country',
    ];

    /**
     * @param $value
     *
     * @return string
     */
    public function getStatuschangedateAttribute($value)
    {
        if (!empty($value)) {
            return Carbon::createFromFormat('d/m/Y', $value)->toDateTimeString();
        } else {
            return $value;
        }
    }
}
