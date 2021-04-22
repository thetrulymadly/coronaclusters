<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     22 April 2021
 */

namespace App\Models;

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
	protected $dates = [
		'date_of_positive',
		'date_of_negative'
	];

	protected $fillable = [
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
		'date_of_negative'
	];
}
