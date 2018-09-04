<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingFormRequest extends FormRequest
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
            'order_title'    => 'required',
            // 'price_value'    => 'required',
            'drop_off_date'  => 'date_format:d/m/Y',
            'return_at_date' => 'date_format:d/m/Y'
        ];
    }
}
