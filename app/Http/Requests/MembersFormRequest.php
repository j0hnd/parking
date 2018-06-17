<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class MembersFormRequest extends FormRequest
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
			'first_name'   => 'required|string',
			'last_name'    => 'required|string',
			'company_name' => 'string',
			'email_add'    => 'email'
		];

		if (!empty($input['id'])) {
			if (!empty($input['new_password'])) {
				$rules['new_password'] = 'string|min:4|max:12';
				$rules['confirm_password'] = 'same:new_password';
			}
		}

		return $rules;
    }
}
