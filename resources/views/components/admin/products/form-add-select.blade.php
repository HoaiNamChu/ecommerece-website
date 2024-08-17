<div class="form-check mb-2" style="margin-left: {{ $marginLeft }}px ">
    <input class="form-check-input" name="category_id[]" value="{{ $category->id }}" type="checkbox" id="{{ $category->category_slug }}">
    <label class="form-check-label" for="{{ $category->category_slug }}">
        {{ $category->category_name }}
    </label>
</div>
@if($category->children->count())
    @php
        $marginLeft += 15;
    @endphp
    @foreach($category->children as $childItem)
        @include('components.admin.products.form-add-select',['category'=>$childItem, 'marginLeft' => $marginLeft])
    @endforeach
@endif
