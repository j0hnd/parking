<?php

namespace App\Http\Requests;

use App\Models\Airports;
use Illuminate\Foundation\Http\FormRequest;

class AirportRequestForm extends FormRequest
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
            'airport_code' => 'string|min:3',
            'description' => 'string',
            'address' => 'required|string',
            'city' => 'required|string',
            'county_state' => 'required|string',
            'zipcode' => 'required',
            'country_id' => 'required',
            'image' => 'mimetypes:image/*'
        ];

        if (!empty($input['id'])) {
            $airport = Airports::find($input['id']);
            $rules['airport_name'] = 'required|string|unique:airports,airport_name,'.$airport->id;
        } else {
            $rules['airport_name'] = 'required|string|unique:airports,airport_name';
        }

        return $rules;
    }
}
