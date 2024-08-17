<?php

namespace App\Http\Requests\Admin\Attributes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreAttributeRequest extends FormRequest
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
            'attribute_name' => 'required|string|max:255',
            'attribute_slug' => 'nullable|unique:attributes',
        ];
    }

    protected function prepareForValidation()
    {
        if (request('attribute_slug')) {
            $attributeSlug = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('attribute_slug')));
        }else{
            $attributeSlug = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('attribute_name')));
        }

        $this->merge([
            'attribute_slug' => $attributeSlug,
        ]);
    }

}
