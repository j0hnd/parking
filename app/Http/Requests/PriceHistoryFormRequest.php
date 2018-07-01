<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceHistoryFormRequest extends FormRequest
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
            'price_id'    => 'required|integer',
			'no_of_days'  => 'required|integer',
			'price_value' => 'required',
			'changed_by'  => 'exists:users'
        ];
    }
}
