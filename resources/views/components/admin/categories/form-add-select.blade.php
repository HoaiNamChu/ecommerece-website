<option value="{{ $item->id }}">{{ $dash }}{{ $item->category_name }}</option>
@if($item->children->count())
    @php
    $dash .= '-';
    @endphp
    @foreach($item->children as $childItem)
        @include('components.admin.categories.form-add-select', ['item'=>$childItem, 'dash'=>$dash])
    @endforeach
@endif
