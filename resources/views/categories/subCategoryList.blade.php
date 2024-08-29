@foreach ($subcategories as $subcategory)
    <div class="subcategory-card row mx-auto ps-md-3 ps-2 position-relative align-items-center justify-content-between rounded px-0 my-3 mb-0 py-1"
        style="display:none;" id="category-{{ $subcategory->id }}">
        <!-- Column 1: Category Info -->
        <div onclick="toggleCategory.call(this)" class="col-lg-5 col-md-5 col-10 opacity-50 d-flex align-items-center"
            style="cursor: pointer;">
            <div class="col-auto icon icon-sm icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fa {{ $subcategory->icon }} opacity-10" aria-hidden="true" style="font-size: 0.85rem;"></i>
            </div>
            <div class="mx-md-2 ms-2 me-1 col">
                <h6 class="mb-0 fw-bold d-flex align-items-center text-muted">
                    {{ $subcategory->name }}
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
                <ul class="dropdown-menu shadow-md">
                    @if ($isParentable)
                        <li>
                            <a class="dropdown-item py-1" href="#" style="font-size: 12px;" data-bs-toggle="modal"
                                data-bs-target="#exampleModalMessage"
                                onclick="setCategory({{ $subcategory->id }}, null, true)">
                                Add sub category
                            </a>
                        </li>
                    @endif
                    <li data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                        onclick="setCategory({{ $subcategory->id }}, '{{$subcategory->name}}', true)">
                        <a class="dropdown-item py-1" href="#" style="font-size: 12px;">
                            Edit
                        </a>
                    </li>
                    @if (!count($subcategory->subcategories))
                        <li onclick="deleteCategory({{ $subcategory->id }})">
                            <a class="dropdown-item py-1" href="#" style="font-size: 12px;">
                                Delete
                            </a>
                        </li>
                    @endif
                </ul>
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
