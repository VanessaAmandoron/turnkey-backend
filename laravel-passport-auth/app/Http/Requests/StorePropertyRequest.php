<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
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
                "p_title" => "required|max:70",
                "price" => "required",
                "p_type" => "required",
                "area" => "required",
                "bathroom" => "required",
                "bedroom" => "required",
                "p_info" => "required",
                "loc_a" => "required",
                "loc_b" => "required",
                "city" => "required",
                "z_code" => "required"
        ];
    }
}
