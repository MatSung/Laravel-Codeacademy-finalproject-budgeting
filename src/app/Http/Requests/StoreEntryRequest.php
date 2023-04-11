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
            'amount' => 'required|numeric|between:-99999999,99999999',
            'transaction_date' => 'nullable|date',
            //https://laravel.com/docs/10.x/validation#rule-exists
            'category_id' => 'required|exists:App\Models\EntryCategory,id',
            // if category has subcategories, force it to choose a subcategory?
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
            'amount.between' => 'The amount must not have more than 10 digits',
            'transaction_date.date_format' => 'The provided DateTime format is incorrect, the correct format is Y-m-d H:i:s',
            'category_id.required' => 'A category is required',
            'category_id.exists' => 'The specified category does not exist',
            'subcategory_id.exists' => 'The specified subcategory does not exist'
        ];
    }

}
