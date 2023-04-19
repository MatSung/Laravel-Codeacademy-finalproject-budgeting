<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEntrySubcategoryRequest extends FormRequest
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
                'required_without:parent_id',
                'string',
                'max:20',
                Rule::unique('entry_subcategories')
                    ->where(
                        'parent_id',
                        request('parent_id') ?? $this->route('entry_subcategory')->id
                    ),
                // 'regex:/^[\w-()]*$/'
            ],
            'parent_id' => [
                'required_without:name',
                'numeric',
                'exists:entry_categories,id',
                Rule::unique('entry_subcategories')
                    ->where(
                        'name',
                        request('name') ?? $this->route('entry_subcategory')->name
                    )
            ]
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
            'parent_id.unique' => 'A subcategory with the same name for the provided parent_id already exists',
            // 'name.regex' => 'Name may only contain alphanumerics or brackets ()',
        ];
    }
}
