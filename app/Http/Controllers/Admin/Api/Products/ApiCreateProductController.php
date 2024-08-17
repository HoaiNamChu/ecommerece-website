<?php

namespace App\Http\Controllers\Admin\Api\Products;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class ApiCreateProductController extends Controller
{
    public function addAttribute(Request $request){
        $attribute = Attribute::query()->where('id', request('id'))->with('attributeValues')->first();
        return view('components.admin.products.product-attribute-value', compact('attribute'));
    }

    public function addAttributeValue(Request $request){
        $attributeValueIds = request()->input('attributeValueIds');
        $attributeIds = request()->input('attributeIds');

        $attributes = Attribute::query()->whereIn('id', $attributeIds)->with(['attributeValues'=>function ($query) use($attributeValueIds) {
            $query = $query->whereIn('id', $attributeValueIds);
        }])->get();

        $productVariants = $this->generateCombinations($attributes);

        return view('components.admin.products.product-variant', compact( 'productVariants'));
    }
    private function generateCombinations($productAttributes)
    {
        $arrays = [];
        foreach ($productAttributes as $productAttribute) {
            $values = $productAttribute->attributeValues;
            $arrays[] = $values;
        }
//        unset($arrays);
        $filteredArray = array_filter($arrays, function($collection) {
            return !$collection->isEmpty();
        });
        $results = [[]];
        foreach ($filteredArray as $propertyValues) {
            $newResults = [];
            foreach ($results as $result) {
                foreach ($propertyValues as $value) {
                    $newResults[] = array_merge($result, [$value]);
                }
            }
            $results = $newResults;
        }

        return $results;
    }
}
