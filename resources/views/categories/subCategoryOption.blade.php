@foreach($subcategories as $subcategory)
    <option value="{{ $subcategory->id }}" @if (!empty($transaction) && !empty($transaction->category)) {{ $transaction->category->id == $subcategory->id ? 'selected' : '' }} @endif>
        @for ($i = 0; $i < $indent; $i++)
            &nbsp;-
        @endfor
        &nbsp;{{ $subcategory->name }}
    </option>
    
    @if (count($subcategory->subcategories))
        @include ('categories.subCategoryOption',['subcategories' => $subcategory->subcategories, 'indent' => ++$indent])
    @endif
@endforeach