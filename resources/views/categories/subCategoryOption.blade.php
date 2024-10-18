@foreach($subcategories as $subcategory)
    <option value="{{ $subcategory->id }}" {{ isset($category) && $category->id == $subcategory->id ? "disabled" : '' }}>
            @for ($i = 0; $i < $indent; $i++)
                &nbsp;-
            @endfor
            &nbsp;{{ $subcategory->name }}
    </option>
    
    @if (count($subcategory->subcategories))
        @include ('categories.subCategoryOption',['subcategories' => $subcategory->subcategories, 'indent' => ($indent+1)])
    @endif
@endforeach