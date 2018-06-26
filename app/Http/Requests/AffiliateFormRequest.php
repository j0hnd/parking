<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AffiliateFormRequest extends FormRequest
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
		$input = $this->all();
        $rules = [
			'travel_agent_id' => 'required|numeric',
			'percent_admin' => 'required|numeric',
			'percent_vendor' => 'required|numeric',
			'percent_travel_agent' => 'required|numeric'
        ];

        if (isset($input['id'])) {
			$rules['code'] = 'max:8|min:8|unique:affiliates,code,' . $input['id'];
		} else {
        	$rules['code'] = 'max:8|min:8';
		}

        return $rules;
    }
}
