<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|unique:categories,title,' . $this->category->id,
            'description' => "string"
        ];
    }


    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'description.required_with' => 'The description is required when the title is present.',
        ];
    }
}
