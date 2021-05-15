<?php

namespace App\Http\Requests\Plasma;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StorePlasmaRequest
 * @package App\Http\Requests\Plasma
 */
class StorePlasmaRequest extends FormRequest
{

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'phone_number' => 'required|string',
            'name' => 'required|string',
            'gender' => 'required|string',
            'age' => 'required|string',
            'blood_group' => 'required|string',
            'state' => 'required|integer',
            'city' => 'required|integer',
            'hospital' => 'nullable|string',
            'date_of_positive' => 'required|string',
            'prescription' => 'nullable|file|mimes:jpeg,jpg,png|max:5120',
        ];
    }
}