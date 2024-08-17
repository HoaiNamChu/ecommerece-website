<?php

namespace App\Http\Requests\Admin\Tags;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreTagRequest extends FormRequest
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
            'tag_name' => 'required|string|max:255',
            'tag_slug' => 'nullable|unique:tags',
        ];
    }

    protected function prepareForValidation()
    {
        if (request('tag_slug')) {
            $tagSlug = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('tag_slug')));
        }else{
            $tagSlug = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('tag_name')));
        }

        $this->merge([
            'tag_slug' => $tagSlug,
        ]);
    }
}
