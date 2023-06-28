<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'title' => ['required', 'max:255', Rule::unique('projects')->ignore($this->project)],
            'description' => ['required'],
            'price' => ['required'],
            'project_image' => ['nullable', 'image'],
            'type_id' => ['nullable', 'exists:types,id'],
            'technologies' => ['exists:technologies,id']

        ];
    }
}
