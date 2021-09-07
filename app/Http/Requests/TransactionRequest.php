<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\BaseFailedValidation;

class TransactionRequest extends FormRequest
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
            'account_id' => 'required|integer|exists:accounts,id',
            'tanggal' => 'required|date|date_format:Y-m-d',
            'category_id' => 'required|integer|exists:categories,id',
            'subcategory_id' => 'required|integer|exists:sub_categories,id',
            'tag_id' => 'required|integer|exists:tags,id',
            'keterangan' => 'required',
            'nominal' => 'required'
        ];

        return $rules;
    }
}
