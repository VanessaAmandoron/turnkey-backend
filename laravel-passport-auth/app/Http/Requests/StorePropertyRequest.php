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
                "title" => "required|max:70",
                "price" => "required",
                "type" => "required|integer",
                "area" => "required",
                "bathroom" => "integer",
                "bedroom" => "integer",
                "description" => "nullable",
                "address_1" => "required",
                "address_2" => "required",
                "city" => "required",
                "zip_code" => "required|integer",
                // "img" => "nullable",
                "availability" => "required",
        ];
    }
}
