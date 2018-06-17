<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupFormRequest extends FormRequest
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
		$rules = [
			'first_name'   => 'required|string',
			'last_name'    => 'required|string',
			'email'        => 'email'
		];

		$input = $this->all();
		if (isset($input['company_name'])) {
			$rules['company_name'] = 'string';
		}

		return $rules;
    }
}
