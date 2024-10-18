{{-- subCategoryList.blade.php --}}
@foreach($subcategories as $subcategory)
    <li>
        <div class="form-check" style="margin-left: {{ $indent * 20 }}px;">
            <input type="checkbox" class="form-check-input category-checkbox" id="category{{ $subcategory->id }}" name="categories[]" value="{{ $subcategory->id }}" {{ isset($filters['categories']) && in_array($subcategory->id,  $filters['categories']) ? 'checked' : '' }}>
            <label class="form-check-label" for="category{{ $subcategory->id }}">
                @if (count($subcategory->subcategories))
                    <i class="fa fa-caret-right toggle-icon" onclick="toggleSubcategories('subcategory-category{{ $subcategory->id }}', this, event)"></i>
                @endif
                {{ $subcategory->name }}
            </label>
        </div>
        <ul id="subcategory-category{{ $subcategory->id }}" class="collapse" style="list-style: none; padding-left: 20px;">
            @if (count($subcategory->subcategories))
                @include('categories.subCategoryCheckbox', ['subcategories' => $subcategory->subcategories, 'indent' => $indent + 1])
            @endif
        </ul>
    </li>
@endforeach
