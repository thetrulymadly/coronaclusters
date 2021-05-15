<?php

namespace App\Http\Requests\Plasma;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DonorDetailRequest
 * @package App\Http\Requests\Plasma
 */
class DonorDetailRequest extends FormRequest
{

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'nearby_radius' => 'nullable|integer',
        ];
    }
}