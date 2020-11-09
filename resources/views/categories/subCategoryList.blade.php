@foreach($subcategories as $subcategory)
    <ul>
        <li>
            <a href="{{ route('categories.edit', ['category' => $subcategory->id]) }}">{{ $subcategory->name }}</a>
        </li>
        
        @if(count($subcategory->subcategories))
            @include('categories.subCategoryList',['subcategories' => $subcategory->subcategories])
        @endif
    </ul>
@endforeach