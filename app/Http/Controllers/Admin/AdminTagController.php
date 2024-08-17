<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tags\StoreTagRequest;
use App\Http\Requests\Admin\Tags\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminTagController extends Controller
{

    const PATH_VIEW = 'admin.tags.';

    public function index()
    {
        $tags = Tag::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        $data = [
            'tag_name' => request('tag_name'),
            'tag_description' => request('tag_description'),
        ];

        if (request('tag_slug')) {
            $data['tag_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('tag_slug')));
        } else {
            $data['tag_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('tag_name')));
        }

        $res = Tag::query()->create($data);
        if ($res) {
            return redirect()->route('admin.tags.index')->with('success', 'Add tag successfully');
        } else {
            return redirect()->route('admin.tags.index')->with('error', 'Add tag fail');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return view(self::PATH_VIEW . __FUNCTION__);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('tag'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $data = [
            'tag_name' => request('tag_name'),
            'tag_description' => request('tag_description'),
        ];

        if (request('tag_slug')) {
            $data['tag_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('tag_slug')));
        } else {
            $data['tag_slug'] = Str::slug(preg_replace('/[^A-Za-z0-9\s]/', '-', request('tag_name')));
        }

        $res = $tag->update($data);
        if ($res) {
            return back()->with('success', 'Update tag successfully');
        } else {
            return back()->with('error', 'Update tag fail');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $res = $tag->delete();
        if ($res) {
            return redirect()->route('admin.tags.index')->with('success', 'Delete tag successfully');
        }else{
            return redirect()->route('admin.tags.index')->with('error', 'Delete tag fail');
        }
    }
}
