<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\BaseFailedValidation;

class SubCategoryRequest extends FormRequest
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
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|unique:sub_categories,name',
        ];

        if ($this->getMethod() == "PUT") {
            $id = $this->sub;
            $rules = ['name' => 'required|unique:sub_categories,name,'.$id];
        }

        return $rules;
    }
}
