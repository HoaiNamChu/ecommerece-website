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
                <h4 class="mb-sm-0">Product attributes</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item active">Product attributes</li>
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
            <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit tag</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="tag-name">Name</label>
                            <input type="text" class="form-control" name="tag_name"
                                   id="tag-name" value="{{ $tag->tag_name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tag-slug">Slug</label>
                            <input type="text" class="form-control" name="tag_slug"
                                   id="tag-slug" value="{{ $tag->tag_slug }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tag-description">Description</label>
                            <textarea class="form-control" type="text" rows="5" id="tag-description" name="tag_description">{!! $tag->tag_description !!}</textarea>
                        </div>
                        <div class="text-start mb-3">
                            <button type="submit" class="btn btn-success w-sm">Update tag</button>
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

