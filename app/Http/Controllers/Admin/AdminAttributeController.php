<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Attributes\StoreAttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminAttributeController extends Controller
{
    const PATH_VIEW = 'admin.attributes.';

    public function index()
    {
        $attributes = Attribute::query()->with('attributeValues')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('attributes'));
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
    public function store(StoreAttributeRequest $request)
    {
        $data = [
            'attribute_name' => request('attribute_name'),
        ];

        if (request('attribute_slug')) {
            $data['attribute_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('attribute_slug')));
        }else{
            $data['attribute_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('attribute_name')));
        }

        $res = Attribute::query()->create($data);
        if ($res) {
            return redirect()->route('admin.attributes.index')->with('success', 'Add attribute successfully');
        }else{
            return redirect()->route('admin.attributes.index')->with('error', 'Add attribute fail');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $attribute)
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        $data = [
            'attribute_name' => request('attribute_name'),
        ];

        if (request('attribute_slug')) {
            $data['attribute_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('attribute_slug')));
        }else{
            $data['attribute_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('attribute_name')));
        }

        $res = $attribute->update($data);
        if ($res) {
            return back()->with('success', 'Update attribute successfully');
        }else{
            return back()->with('error', 'Update attribute fail');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        try {
            DB::transaction(function () use ($attribute) {
                $attribute->attributeValues()->delete();
                $attribute->delete();
            });
            return redirect()->route('admin.attributes.index')->with('success', 'Delete attribute successfully');
        }catch (\Exception $exception){
            return redirect()->route('admin.attributes.index')->with('error', $exception->getMessage());
        }
    }
}
