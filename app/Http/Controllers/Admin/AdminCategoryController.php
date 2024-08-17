<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function Laravel\Prompts\error;

class AdminCategoryController extends Controller
{

    const PATH_VIEW = 'admin.categories.';
    const PATH_UPLOAD = 'categories';

    public function index()
    {
        $categories = Category::query()->whereNull('parent_id')->with(['children', 'products'])->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

        $data = [
            'category_name' => request('category_name'),
            'parent_id' => request('parent_id'),
            'category_description' => request('category_description'),
        ];
        if (request('category_slug') == null) {
            if ($data['parent_id']) {
                $data['category_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('category_name'))) . '-' . Category::query()->where('id', $data['parent_id'])->first()->category_slug;
            } else {
                $data['category_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('category_name')));
            }
        } else {
            $data['category_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('category_slug')));
        }
        if (request()->hasFile('category_image')) {
            $data['category_image'] = Storage::put(self::PATH_UPLOAD, request()->file('category_image'));
        }

        $res = Category::query()->create($data);
        if ($res) {
            return back()->with('success', 'Category created successfully.');
        } else {
            if ($res->category_image && Storage::exists($res->category_image)) {
                Storage::delete($res->category_image);
            }
            return back()->with('error', 'Category created fail.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::query()->whereNull('parent_id')->with('children')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('category', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $currentImage = $category->category_image;
        $data = [
            'category_name' => request('category_name'),
            'parent_id' => request('parent_id'),
            'category_description' => request('category_description'),
        ];
        if (request('category_slug') == null) {
            $data['category_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('category_name')));
        } else {
            $data['category_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('category_slug')));
        }
        if (Category::query()->whereNot('id', $category->id)->where('category_slug', $data['category_slug'])->exists()) {
            return back()->withErrors('The category slug has already been taken.');
        }
        if (request()->hasFile('category_image')) {
            $data['category_image'] = Storage::put(self::PATH_UPLOAD, request()->file('category_image'));
        }
        $data['category_image'] ??= $currentImage;

        $res = $category->update($data);
        if ($res) {
            if ($category->category_image != $currentImage && Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }
            return back()->with('success', 'Category created successfully.');
        } else {
            if ($category->category_image && Storage::exists($category->category_image)) {
                Storage::delete($category->category_image);
            }
            return back()->with('error', 'Category created fail.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            DB::transaction(function () use ($category) {
                $category->children()->update([
                    'parent_id' => $category->parent_id,
                ]);
                $category->delete();
            });
            if ($category->category_image && Storage::exists($category->category_image)) {
                Storage::delete($category->category_image);
            }
            return back()->with('success', 'Category deleted successfully.');
        } catch (\Exception $exception) {
            return back(back())->with('error', 'Category deleted fail.');
        }
    }
}
