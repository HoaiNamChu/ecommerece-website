<option value="{{ $item->id }}"
    @selected($category->parent_id == $item->id)
>{{ $dash }}{{ $item->category_name }}</option>
@if($item->children->count())
    @php
        $dash .= '-';
    @endphp
    @foreach($item->children as $childItem)
        @include('components.admin.categories.form-edit-select', ['item'=>$childItem, 'dash'=>$dash, 'category'=>$category])
    @endforeach
@endif
