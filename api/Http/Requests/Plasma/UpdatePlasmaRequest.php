<?php

namespace Api\Http\Requests\Plasma;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdatePlasmaRequest
 * @package Api\Http\Requests\Plasma
 */
class UpdatePlasmaRequest extends FormRequest
{

    public function rules()
    {
        return [
            'state' => 'nullable|integer',
            'city' => 'nullable|integer',
            'blood_group' => 'nullable|string',
            'age' => 'nullable|string',
            'date_of_positive' => 'nullable|string',
            'date_of_negative' => 'nullable|string',
            'hospital' => 'nullable|string',
            'prescription' => 'nullable|file|mimes:jpeg,jpg,png|max:5120',
        ];
    }
}