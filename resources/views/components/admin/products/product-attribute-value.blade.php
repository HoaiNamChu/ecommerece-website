<div id="block-attribute-{{ $attribute->id }}" class="block-attributes">
    <h4 class="d-inline-block">{{ $attribute->attribute_name }}</h4>
    <button type="button" class="btn btn-sm btn-danger float-end btn-remove-attribute" id="btn-remove-{{ $attribute->id }}">
        Remmove
    </button>
    <hr>
    <div>
        <table style="width: 100%;">
            <thead>
            <tr>
                <th style="width: 30%;">Name:</th>
                <th style="width: 70%;">Values:</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <strong>{{ $attribute->attribute_name }}</strong>
                </td>
                <td>
                    <select id="select-{{ $attribute->id }}" style="width: 100%" multiple>
                       @foreach($attribute->attributeValues as $item)
                            <option value="{{ $item->id }}">{{ $item->attribute_value_name }}</option>
                       @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <button type="button"
                            class="btn btn-sm btn-primary btn-selectAll-attribute float-start"
                            id="btn-selectAll-{{ $attribute->id }}">Select
                        all
                    </button>
                    <button type="button"
                            class="btn btn-sm btn-warning btn-selectNone-attribute float-start"
                            id="btn-selectNone-{{ $attribute->id }}">Select
                        none
                    </button>
                    <button type="button"
                            class="btn btn-sm btn-primary btn-create-attribute float-end" id="btn-create-{{ $attribute->id }}">
                        Create
                        value
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <hr>
</div>
