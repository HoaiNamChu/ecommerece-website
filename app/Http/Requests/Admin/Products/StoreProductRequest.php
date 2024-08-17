<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'product_name' => 'required|string|min:2|max:100',
            'product_sku' => 'nullable|string|unique:products,product_sku',
            'product_quantity' => 'nullable|integer',
            'product_image' => 'nullable|image',
            'product_galleries' => 'nullable|array',
            'product_galleries*' => 'nullable|image',
            'category_id' => 'nullable|array',
            'category_id*' => 'nullable|integer|exists:categories,id',
            'tag_id' =>'nullable|array',
            'tag_id*' =>'nullable|integer|exists:tags,id',
        ];
    }

}
