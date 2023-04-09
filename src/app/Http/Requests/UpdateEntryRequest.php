<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEntryRequest extends FormRequest
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
            'amount' => 'numeric|between:-99999999,99999999',
            'transaction_date' => 'date_format:Y-m-d H:i:s',
            'category_id' => 'exists:App\Models\EntryCategory,id',
            'subcategory_id' => [
                'nullable',
                Rule::exists('entry_subcategories','id')->where('parent_id', request('category_id'))
            ],
            'note' => 'nullable|string|max:255'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'transaction_date' => date("Y-m-d H:i:s", strtotime($this->transaction_date))
        ]);
    }
}
