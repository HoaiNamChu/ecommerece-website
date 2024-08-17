@extends('admin.layouts.master')

@section('links')
    <!-- Sweet Alert css-->
    <link href="{{ asset('theme/admin/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
          type="text/css"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Product Categories</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item active">Product Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="row">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-4">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Add new category</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="category-name">Name</label>
                            <input type="text" class="form-control" name="category_name"
                                   id="category-name" value="{{ $category->category_name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="category-slug">Slug</label>
                            <input type="text" class="form-control" name="category_slug"
                                   id="category-slug" value="{{ $category->category_slug }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="parent-id">Parent category</label>
                            <select name="parent_id" id="parent-id" class="form-select">
                                <option value="" selected>None</option>
                                @foreach($categories as $item)
                                    @php
                                        $dash = ' ';
                                    @endphp
                                    @include('components.admin.categories.form-edit-select', ['item'=>$item, 'dash'=>$dash, 'category'=>$category])
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="category-description">Description</label>
                            <textarea type="text" class="form-control" rows="5" name="category_description"
                                      id="category-description">{!! $category->category_description !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="image">Thumbnail</label>
                            <input type="file" class="form-control" name="category_image"
                                   id="image">
                            <div class="align-items-center">
                                @if($category->category_image)
                                    <img src="{{ Storage::url($category->category_image) }}" class="avatar-md" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="text-start mb-3">
                            <button type="submit" class="btn btn-success w-sm">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('libs-script')
    <!-- prismjs plugin -->
    <script src="{{ asset('theme/admin/assets/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!-- listjs init -->
    <script src="{{ asset('theme/admin/assets/js/pages/listjs.init.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('theme/admin/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection


