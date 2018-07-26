<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
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
            'carpark_id'              => 'required|numeric',
            'airport_id'              => 'required',
			'short_description'       => 'required|string',
            'description'             => 'required|string',
            'on_arrival'              => 'required|string',
            'on_return'               => 'required|string',
            'directions'              => 'required|string',
			'revenue_share'           => 'required',
            'contact_person_name'     => 'required',
            'contact_person_email'    => 'required|email',
            'contact_person_phone_no' => 'required',
        ];
    }
}
