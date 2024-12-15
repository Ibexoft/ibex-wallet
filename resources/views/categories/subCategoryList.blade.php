@foreach ($subcategories as $subcategory)
    <div class="subcategory-card row mx-auto ps-md-3 ps-2 position-relative align-items-center justify-content-between rounded px-0 my-3 mb-0 py-1"
        style="display:{{$expendAll ? '' : 'none'}};" id="category-{{ $subcategory->id }}">
        <!-- Column 1: Category Info -->
        <div onclick="toggleCategory.call(this)" class="dropdown-toggler col-lg-5 col-md-5 col-10 opacity-50 d-flex align-items-center"
            style="{{ count($subcategory->subcategories) ? 'cursor: pointer;' : '' }}">
            <div class="col-auto icon icon-sm icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fa {{ $subcategory->icon }} opacity-10" aria-hidden="true" style="font-size: 0.85rem;"></i>
            </div>
            <div class="mx-md-2 ms-2 me-1 col">
                <h6 class="mb-0 fw-bold d-flex align-items-center text-muted category-title">
                    <span id="category-{{$subcategory->id}}-name">{{ $subcategory->name }}</span>
                    @if (count($subcategory->subcategories))
                        <i class="fa fa-chevron-down ms-2 category-toggle-icon" style="font-size: 10px"></i>
                    @endif
                </h6>
            </div>
        </div>

        <!-- Column 2: Progress Bar -->
        <div class="col-lg-2 col-md-3 col-0 text-center d-md-block d-none" title="Category Share">
            <!-- Progress bar content here -->
        </div>

        <!-- Column 3: Options Dropdown -->
        <div class="col-lg-5 col-md-4 col-2 text-end category-options">
            <div class="filter">
                <a class="icon text-primary" href="#" data-bs-toggle="dropdown">
                    <i class="fa fa-ellipsis-h py-1"></i>
                </a>
                @include('categories.dropdownMenu', [
                    'categoryId' => $subcategory->id,
                    'categoryName' => $subcategory->name,
                    'isSubcategory' => false,
                    'subcategories' => $subcategory->subcategories,
                    'canDelete' => !count($subcategory->subcategories),
                    'isParentable' => $isParentable,
                    'parentId' => $subcategory->parent_category_id
                ])
            </div>
        </div>

        @if (count($subcategory->subcategories))
            @include('categories.subCategoryList', [
                'subcategories' => $subcategory->subcategories,
                'isParentable' => false,
            ])
        @endif
    </div>
@endforeach
