<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UserFormRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'role_id' => 'required|string'
        ];

        if (!empty($input['id'])) {
            $user = User::find($input['id']);
            $rules['email'] = 'required|email|unique:users,email,'.$user->id;
            if (!empty($input['password'])) {
                $rules['password'] = 'string|min:4|max:12';
                $rules['confirm_passwod'] = 'same:password';
            }
        } else {
            $rules['email'] = 'required|email|unique:users,email';
        }

        return $rules;
    }
}
