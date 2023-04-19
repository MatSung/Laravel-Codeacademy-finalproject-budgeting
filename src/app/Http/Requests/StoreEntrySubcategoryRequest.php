<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEntrySubcategoryRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:20',
                // check that an identical subcategory does not exist with the same parent id
                Rule::unique('entry_subcategories')->where('parent_id', request('parent_id')),
                // 'regex:/^[\w-()]*$/'
            ],
            'parent_id' => 'required|numeric|exists:entry_categories,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'name.unique' => 'Subcategory for given parent category already exists',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not be longer than 20 symbols',
            'parent_id.required' => 'Parent_id is required',
            'parent_id.exists' => 'Provided parent category does not exist',
            // 'name.regex' => 'Name may only contain alphanumerics or brackets ()',
        ];
    }
}
