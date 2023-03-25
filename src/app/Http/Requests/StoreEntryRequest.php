<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
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
            'amount' => 'required|numeric',
            'transaction_date' => 'nullable|date_format:Y-m-d H:i:s',
            //https://laravel.com/docs/10.x/validation#rule-exists
            'category_id' => 'required|exists:App\Models\EntryCategory,id',
            'subcategory_id' => [
                'nullable',
                Rule::exists('entry_subcategories', 'id')->where('parent_id', request('category_id'))
            ],
            'note' => 'nullable|string|max:255'
        ];
    }
    public function messages(): array
    {
        return [
            'amount.required' => 'An amount is required',
            'amount.numeric' => 'The amount must be a number',
            'transaction_date.date_format' => 'The provided format is incorrect, the correct format is Y-m-d H:i:s',
            'category_id.required' => 'A category is required',
            'category_id.exists' => 'The specified category does not exist',
            'subcategory_id.exists' => 'The specified subcategory does not exist'
        ];
    }
}
