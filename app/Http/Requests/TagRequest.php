<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\BaseFailedValidation;

class TagRequest extends FormRequest
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
            'name' => 'required|unique:tags,name',
        ];

        if ($this->getMethod() == "PUT") {
            $id=$this->tag;
            $rules['name'] = 'required|unique:tags,name,'.$id;
        }

        return $rules;
    }
}
