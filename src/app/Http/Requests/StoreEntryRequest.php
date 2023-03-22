<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|float|max:10',
            // 'transaction_date' => '',
            'category_id' => 'required',
            'note' => 'string"|max:255'
        ];
    }
    public function messages(): array
{
    return [
        'amount.required' => 'An amount is required',
        'category_id.required' => 'A category is required',
    ];
}
}
