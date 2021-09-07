<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\BaseFailedValidation;

class CategoryRequest extends FormRequest
{
    use BaseFailedValidation;
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
            'name' => 'required|unique:categories,name',
        ];

        if ($this->getMethod() == "PUT") {
            $rules['name'] = 'required|unique:categories,name,'.$this->id;
        }

        return $rules;
    }
    
}
