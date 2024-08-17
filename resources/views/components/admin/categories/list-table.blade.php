<tr>
    <th scope="row">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="id"
                   value="{{ $category->id }}">
        </div>
    </th>
    <td><img src="{{ Storage::url($category->category_image) }}" alt="" class="rounded-circle avatar-sm"></td>
    <td>{{ $dash }}{{ $category->category_name }}</td>
    <td>{{ $category->category_description }}</td>
    <td>{{ $category->category_slug }}</td>
    <td>{{ $category->products->count() }}</td>
    <td>
        <div class="d-flex gap-2">
            <div class="edit">
                <button class="btn btn-sm btn-info show-item-btn" data-bs-toggle="modal" data-bs-target="#showModal">
                    Show
                </button>
            </div>
            <div class="edit">
                <a href="{{ route('admin.categories.edit', $category) }}">
                    <button class="btn btn-sm btn-success edit-item-btn">
                        Edit
                    </button>
                </a>
            </div>
            <div class="remove">
                <form action="{{ route('admin.categories.destroy', $category) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger remove-item-btn" onclick="return confirm('Do you want to delete?')" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Remove
                    </button>
                </form>
            </div>
        </div>
    </td>
</tr>
@if($category->children->count())
    @php
        $dash .= '-';
    @endphp
    @foreach($category->children as $cateChild)
        @include('components.admin.categories.list-table', ['category'=>$cateChild, 'dash'=>$dash])
    @endforeach
@endif
