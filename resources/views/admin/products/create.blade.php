@extends('admin.layouts.master')

@section('links')
    <!-- Plugins css -->
    <link href="{{ asset('theme/admin/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Create Product</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item active">Create Product</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
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
    <form id="createproduct-form" action="{{ route('admin.products.store') }}" method="POST"
          enctype="multipart/form-data"
          autocomplete="off" class="needs-validation" novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="product-title-input">Product Title</label>
                            <input type="text" class="form-control" id="product-title-input"
                                   placeholder="Enter product title" value="{{ old('product_name') }}"
                                   name="product_name" required>
                            <div class="invalid-feedback">Please Enter a product title.</div>
                        </div>
                        <div class="mb-3">
                            <label for="product-sku" class="form-label">SKU</label>
                            <input type="text" id="product-sku" name="product_sku"
                                   value="{{ strtoupper(\Illuminate\Support\Str::random(8)) }}"
                                   class="form-control">
                        </div>
                        <div>
                            <label>Product Description</label>

                            <textarea name="product_description" id="ckeditor-classic">
                                {!! old('product_description') !!}
                            </textarea>
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product data
                            <span>
                                -
                                <label for="product-type">
                                    <select name="product_type" id="product-type">
                                        <optgroup label="Product Type">
                                            <option value="simple" selected id="simple">Product simple</option>
                                            <option value="variable" id="variable">Variable product</option>
                                        </optgroup>
                                    </select>
                                </label>
                            </span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-md-3">
                                <ul class="list-group">
                                    <li class="list-group-item product-option" id="general">General</li>
                                    <li class="list-group-item product-option" id="inventory">Inventory</li>
                                    <li class="list-group-item product-option" id="attributes">Attributes</li>
                                    <li class="list-group-item product-option" id="variations">Variations</li>
                                </ul>
                            </div>
                            <!-- end col -->
                            <div class="col-md-9">
                                <div class="row pt-3 pb-3" id="general-item">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price-regular" class="form-label">Regular price</label>
                                            <input type="text" id="price-regular" value="{{ old('product_price') }}"
                                                   name="product_price"
                                                   class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="price-sale" class="form-label">Sale price</label>
                                            <input type="text" id="price-sale" value="{{ old('product_price_sale') }}"
                                                   name="product_price_sale"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-3 pb-3" id="inventory-item">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="product-quantity" class="form-label">Quantity</label>
                                            <input type="text" id="product-quantity"
                                                   value="{{ old('product_quantity') }}" name="product_quantity"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-3 pb-3" id="attributes-item">
                                    <div>
                                        <div class="col-md-6 mb-3 d-inline-block">
                                            <select id="select-attributes" class="form-select">
                                                <option value="">Select attributes</option>
                                                @foreach($attributes as $id => $name)
                                                    <option value="{{ $id }}"
                                                            id="attribute-option-{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" id="add-attribute" class="btn btn-sm btn-primary">Add
                                            attribute
                                        </button>
                                        <hr>
                                    </div>
                                    <div>
                                        <div id="product-attributes">

                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                    id="btn-save-attributes">Save attributes
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <div class="row pt-3 pb-3" id="variations-item">

                                </div>
                            </div>
                            <!--  end col -->
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Short Description</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">Add short description for product</p>
                        <textarea class="form-control" name="product_short_description"
                                  placeholder="Must enter minimum of a 100 characters"
                                  rows="10"></textarea>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                </div>
            </div>
            <!-- end col -->

            <div class="col-lg-3">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Publish</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-1">
                            <div class="form-check form-switch form-switch-custom form-switch-success">
                                <input class="form-check-input" value="1" name="is_active" type="checkbox" role="switch"
                                       id="SwitchCheck11" checked>
                                <label class="form-check-label" for="SwitchCheck11">Is Active</label>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="form-check form-switch form-switch-custom form-switch-primary">
                                <input class="form-check-input" value="1" name="is_on_sale" type="checkbox"
                                       role="switch" id="SwitchCheck9">
                                <label class="form-check-label" for="SwitchCheck9">Is on sale</label>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="form-check form-switch form-switch-custom form-switch-secondary">
                                <input class="form-check-input" value="1" name="is_featured" type="checkbox"
                                       role="switch" id="SwitchCheck10">
                                <label class="form-check-label" for="SwitchCheck10">Is featured</label>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="form-check form-switch form-switch-custom form-switch-warning">
                                <input class="form-check-input" value="1" name="is_new" type="checkbox" role="switch"
                                       id="SwitchCheck12">
                                <label class="form-check-label" for="SwitchCheck12">Is new</label>
                            </div>
                        </div>
                        <div>
                            <div class="form-check form-switch form-switch-custom form-switch-danger">
                                <input class="form-check-input" value="1" name="is_home" type="checkbox" role="switch"
                                       id="SwitchCheck13">
                                <label class="form-check-label" for="SwitchCheck13">Is show home</label>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product image</h5>
                    </div>
                    <!-- end card body -->
                    <div class="card-body">
                        <div>
                            <input type="file" name="product_image">
                        </div>
                    </div>
                </div>
                <!-- end card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product gallery</h5>
                    </div>
                    <!-- end card body -->
                    <div class="card-body">
                        <div>
                            <input type="file" name="product_galleries[]" multiple>
                        </div>
                    </div>
                </div>
                <!-- end card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Categories</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2"><a href="{{ route('admin.categories.index') }}"
                                                      class="float-end text-decoration-underline">Add
                                New</a>Select product category</p>
                        <div class="border" style="padding: 5px 10px; max-height: 200px; overflow: scroll;">
                            @foreach($categories as $item)
                                @php
                                    $marginLeft = 0;
                                @endphp
                                @include('components.admin.products.form-add-select', ['category'=>$item, 'marginLeft'=>$marginLeft])
                            @endforeach
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Tags</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2"><a href="{{ route('admin.tags.index') }}"
                                                      class="float-end text-decoration-underline">Add
                                New</a>Select product tag</p>
                        <select class="js-example-basic-multiple" name="tag_id[]" multiple="multiple">
                            @foreach($tags as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
@endsection

@section('libs-script')
    <!-- ckeditor -->
    <script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <!-- dropzone js -->
    <script src="{{ asset('theme/admin/assets/libs/dropzone/dropzone-min.js') }}"></script>

    <script src="{{ asset('theme/admin/assets/js/pages/ecommerce-product-create.init.js') }}"></script>

    <!--jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('theme/admin/assets/js/pages/select2.init.js') }}"></script>
@endsection

@section('script')
    <script>


        $(document).ready(function () {

            $('#product-type').change(function () {
                var productType = $('#product-type option:selected');
                if (productType.val() === 'simple') {
                    $('#variations, #attributes, #inventory-item, #attributes-item, #variations-item').hide();
                    $('#general, #inventory, #general-item').show();
                }
                if (productType.val() === 'variable') {
                    $('#variations, #attributes, #attributes-item').show();
                    $('#general, #inventory, #general-item, #inventory-item, #variations-item').hide();
                }
            })

            var productType = $('#product-type option:selected');
            if (productType.val() === 'simple') {
                $('#variations, #attributes').hide();
                $('#general, #inventory').show();
            }
            if (productType.val() === 'variable') {
                $('#variations, #attributes').show();
                $('#general, #inventory').hide();
            }

            $('#inventory-item, #attributes-item, #variations-item').hide();
            $('.product-option').click(function () {
                var selectedId = $(this).attr('id');
                $('#general-item, #inventory-item, #attributes-item, #variations-item').hide();
                $('#' + selectedId + '-item').show();
            });


            $('#product-type').change(function () {
                var productType = $('#product-type option:selected');
                if (productType.val() === 'simple') {
                    $('#variations, #attributes').hide();
                    $('#general, #inventory').show();
                }
                if (productType.val() === 'variable') {
                    $('#variations, #attributes').show();
                    $('#general, #inventory').hide();
                }
            });


            $('#add-attribute').click(function () {
                var attribute = $('#select-attributes option:selected').val();
                // var productAttributesHtml = ``
                if (attribute && $('#block-attribute-' + attribute).length === 0) {
                    $.ajax({
                        url: `/api/addAttribute/${attribute}`,
                        type: 'GET',
                        success: function (response) {
                            $('#product-attributes').append(response);
                            $('#attribute-option-' + attribute).prop('selected', false).prop('disabled', true);
                        },
                        error: function (xhr, status, error) {

                        }
                    });
                }

            });

        });
        $(document).on('click', '#btn-save-attributes', function () {
            if ($('#product-attributes').html().trim().length === 0) {
                console.log('No data');
            } else {
                var attributeValueIds = [];
                var attributeIds = [];
                $('.block-attributes').each(function () {
                    var arrId = $(this).attr('id').split('-');
                    attributeIds.push(arrId[2]);
                    $('#select-' + arrId[2] + ' option:selected').each(function () {
                        attributeValueIds.push($(this).val());
                    });
                });
                $('#variations-item').innerHTML = '';
                $.ajax({
                    url: '/api/addAttributeValue',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        attributeIds: attributeIds,
                        attributeValueIds: attributeValueIds
                    },
                    success: function (response) {
                        $('#variations-item').append(response);
                    },
                    error: function (response) {

                    }
                });

            }
        });

        $(document).on('click', '.btn-remove-variant', function () {
            var btnId = $(this).attr('id');
            $('#variant-' + btnId).remove();
        });

        $(document).on('click', '.btn-remove-attribute', function () {
            var btnId = $(this).attr('id').split('-');
            var attributeId = btnId[2]
            $('#block-attribute-' + attributeId).remove();
            $('#attribute-option-' + attributeId).prop('disabled', false)
        });


        $(document).on('click', '.btn-selectAll-attribute', function () {
            var btnId = $(this).attr('id').split('-');
            var attributeId = btnId[2]
            $('#select-' + attributeId + ' option').prop('selected', true);
        });


        $(document).on('click', '.btn-selectNone-attribute', function () {
            var btnId = $(this).attr('id').split('-');
            var attributeId = btnId[2]
            console.log(attributeId);
            $('#select-' + attributeId + ' option').prop('selected', false);
        });

    </script>
@endsection
