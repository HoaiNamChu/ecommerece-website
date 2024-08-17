<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    const PATH_VIEW = 'admin.products.';
    public function index()
    {
        $products = Product::query()->with(['categories','tags','inventory'])->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::query()->pluck('tag_name', 'id');
        $attributes = Attribute::query()->pluck('attribute_name', 'id');
        $categories = Category::query()->whereNull('parent_id')->with('children')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('tags', 'categories', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        if ($request->product_type == 'simple'){
            $dataProduct = [
                'product_name' => request('product_name'),
                'product_description' => request('product_description'),
                'product_price' => request('product_price'),
                'product_price_sale' => request('product_price_sale'),
                'product_sku' => request('product_sku'),
                'is_active' => request('is_active') ?? 0,
                'is_on_sale' => request('is_on_sale') ?? 0,
                'is_featured' => request('is_featured') ?? 0,
                'is_new' => request('is_new') ?? 0,
                'is_home' => request('is_home') ?? 0,
            ];
            $dataProduct['product_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('product_name'))).'-'.$dataProduct['product_sku'];;
            if (request()->hasFile('product_image')){
                $dataProduct['product_image'] = Storage::put('products', $request->file('product_image'));
            }
            $dataProduct['product_image'] ??= null;
            $dataGallery = request('product_galleries');
            $dataCategory = request('category_id');
            $dataTag = request('tag_id');

            try {
                DB::transaction(function () use ($dataProduct, $dataGallery, $dataCategory, $dataTag) {

                    $product = Product::query()->create($dataProduct);

                    $product->categories()->sync($dataCategory);

                    $product->tags()->sync($dataTag);

                    $product->inventory()->create([
                        'product_id'=>$product->id,
                        'quantity'=>request('product_quantity'),
                    ]);

                    if (!empty($dataGallery)){
                        foreach ($dataGallery as $gallery){
                            ProductGallery::query()->create([
                               'product_id' => $product->id,
                               'gallery_image' => Storage::put('galleries', $gallery)
                            ]);
                        }
                    }
                });
                return redirect()->route('admin.products.index')->with('success', 'Add product successfully');
            }catch (\Exception $exception){
                DB::rollBack();
                return back()->with('error', $exception->getMessage());
            }
        }elseif (request('product_type') == 'variable'){
            dd(request()->all());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view(self::PATH_VIEW . __FUNCTION__);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
