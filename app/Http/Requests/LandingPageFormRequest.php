<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\LandingPages;


class LandingPageFormRequest extends FormRequest
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
            'description_1' => 'required|string'
        ];

        if (!empty($input['id'])) {
            $page = LandingPages::findOrFail($input['id']);
            $rules['airport_id'] = 'required|integer|unique:landing_pages,airport_id,'.$page->id;
        } else {
            $rules['airport_id'] = 'required|integer|unique:landing_pages';
        }

        return $rules;
    }
}
