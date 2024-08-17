<?php

namespace App\Http\Requests\Admin\Categories;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

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
        $id = $this->route('category')->id;
        return [
            'category_name'     => 'required|string|max:255',
            'category_slug'     => 'nullable|string|unique:categories,category_slug,'.$id,
            'parent_id'         => 'nullable|integer',
            'category_image'    => 'nullable|image',
        ];
    }
    protected function prepareForValidation()
    {
        if (request('category_slug') == null) {
            if (request('parent_id')) {
                $categorySlug = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('category_name'))) . '-' . Category::query()->where('id', request('parent_id'))->first()->category_slug;
            } else {
                $categorySlug = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('category_name')));
            }
        } else {
            $categorySlug = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('category_slug')));
        }
        $this->merge([
            'category_slug' => $categorySlug,
        ]);
    }
}
