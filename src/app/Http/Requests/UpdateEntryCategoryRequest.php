<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEntryCategoryRequest extends FormRequest
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
                'unique:App\Models\EntryCategory,name',
                'max:20',
                // 'regex:/^[\w-()]*$/'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'name.unique' => 'Category already exists',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not be longer than 20 symbols',
            // 'name.regex' => 'Name may only contain alphanumerics or brackets ()',
        ];
    }
}
