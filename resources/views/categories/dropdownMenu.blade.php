<ul class="dropdown-menu shadow-md">
    <!-- Add Subcategory if parentable -->
    @if ($isParentable ?? false)
        <li>
            <a class="dropdown-item py-1" href="#" data-bs-toggle="modal"
               data-bs-target="#addCategoryModal"
               onclick="setCategory({{ $categoryId }}, null, true)">
               Add subcategory
            </a>
        </li>
    @endif

    <!-- Edit Category -->
    <li data-bs-toggle="modal" data-bs-target="#editCategoryModal"
        onclick="setCategory({{ $categoryId }}, '{{ $categoryName }}', {{ $isSubcategory }})">
        <a class="dropdown-item py-1" href="#">
            Edit
        </a>
    </li>

    <!-- Delete Category -->
    <li onclick="deleteCategory({{ $categoryId }}, {{ $parentId ?? 'null' }})" class="delete-option {{count($subcategories) ? 'd-none' : ''}}" >
        <a class="dropdown-item py-1" href="#">
                Delete
        </a>
    </li>
</ul>