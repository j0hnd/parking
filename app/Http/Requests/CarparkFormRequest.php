<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Carpark;

class CarparkFormRequest extends FormRequest
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
            'description' => 'string',
            'address' => 'required|string',
            'city' => 'required|string',
            'county_state' => 'required|string',
            'zipcode' => 'required',
            'country_id' => 'required',
            'company_name' => 'required|string',
            'email' => 'required|email',
            'image' => 'mimetypes:image/*',
            'poc_name' => 'string',
            'poc_contact_email' => 'email',
            'park_mark' => 'mimetypes:image/*,application/pdf',
            'insurance_policy' => 'mimetypes:image/*,application/pdf'
        ];

        if (!empty($input['id'])) {
            $carpark = Carpark::find($input['id']);
            $rules['name'] = 'required|string|unique:carparks,name,'.$carpark->id;
        } else {
            $rules['name'] = 'required|string|unique:carparks,name';
        }

        return $rules;
    }
}
