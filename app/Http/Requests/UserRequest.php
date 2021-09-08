<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\BaseFailedValidation;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];

        if ($this->getMethod() == "PUT") {
            $id = $this->kelola_user;
            $rules['email'] = 'required|unique:users,email,'.$id;
        }

        return $rules;

        
    }
}
