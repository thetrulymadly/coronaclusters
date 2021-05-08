<?php

namespace Api\Http\Requests\Plasma;

use Illuminate\Foundation\Http\FormRequest;

class DeletePlasmaRequest extends FormRequest
{
    public function rules()
    {
        return [
            'delete_reason' => 'required|string',
            'delete_reason_other' => 'nullable|string',
        ];
    }
}