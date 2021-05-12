<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     21 April 2020
 */

namespace Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RawDataRequest
 * @package Api\Http\Requests
 */
class PlasmaDataRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:donor,requester',
            'blood_groups' => 'nullable|array',
            'negative_date' => 'nullable|date',
            'gender' => 'nullable|string',
            'city_id' => 'nullable|integer',
        ];
    }
}
