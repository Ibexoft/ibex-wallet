@extends('layouts.app')

@section('sidebar')
    <div class="col-lg-3 mb-4 mb-lg-0">
        <div class="card">
            <form id="category-filter-form" action="{{ route('categories.index') }}" method="GET">
                <div class="card-header pb-0 px-3">
                    <span class="text-dark px-2 d-flex justify-content-between w-100 align-items-center"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true"
                        aria-controls="filterCollapse">
                        <h6 class="mb-0">Filter Categories</h6>
                        <i class="fas fa-angle-down" id="filterIcon"></i>
                    </span>
                </div>
                <div class="card-body pb-0">
                    <div id="filterCollapse" class="pt-0 collapse show" data-bs-parent="#accordionExample">

                        <!-- Search Field -->
                        <div class="mb-3">
                            <label for="categoriesearch" class="form-label">Search Categories</label>
                            <input type="text" class="form-control" id="categoriesearch" name="search"
                                placeholder="Search by name" value="{{ request('search') }}">
                        </div>

                        <!-- Sort Options -->
                        <div class="mb-3">
                            <label for="sortOrder" class="form-label">Sort By</label>
                            <select class="form-select" id="sortOrder" name="sort">
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name (A-Z)
                                </option>
                                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name (Z-A)
                                </option>
                            </select>
                        </div>

                        <!-- Submit and Clear Buttons -->
                        <button type="submit" class="btn bg-gradient-primary w-100 my-2">Apply Filters</button>
                        <a href="{{ route('categories.index') }}" class="btn bg-gradient-secondary w-100">Clear All
                            Filters</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('content')
    <div class="col mb-4">
        <div class="card">
            <div class="card-header pb-0 mt-4 d-flex justify-content-between">
                <h6 class="mb-0">Categories</h6>
                <button type="button" class="btn btn-sm btn-block bg-gradient-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#addCategoryModal" onclick="setCategory(null, false)">+ Add Category</button>
            </div>

            <div class="category-list p-3">
                @if ($categories->isEmpty())
                    <div class="d-flex flex-column align-items-center justify-content-center text-center py-5">
                        <i class="fas fa-layer-group mb-3 fs-1"></i>
                        <h6 class="mb-2">No Categories Found</h6>
                        <p class="text-muted mb-0">You have no categories to display at the moment.</p>
                    </div>
                @endif
                @foreach ($categories as $category)
                    {{-- Parent Category --}}
                    <div class="category-card  m-auto position-relative row align-items-center justify-content-between py-3 px-0 rounded my-3 bg-gray-100"
                        id="category-{{ $category->id }}">
                        <!-- Column 1: Category Info -->
                        <div onclick="toggleCategory.call(this)"
                            class="dropdown-toggler col-lg-6 col-md-8 col-10 d-flex align-items-center opacity-10"
                            style="{{ count($category->subcategories) ? 'cursor: pointer;' : '' }}">
                            <div
                                class="col-auto icon icon-sm icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fa {{ $category->icon }} opacity-10" aria-hidden="true"
                                    style="font-size: 0.85rem;"></i>
                            </div>
                            <div class="mx-2 col">
                                <h6 class="mb-0 fw-bold d-flex align-items-center text-muted category-title">
                                    <span id="category-{{ $category->id }}-name">{{ $category->name }}</span>
                                    @if (count($category->subcategories))
                                        <i class="fa fa-chevron-down ms-2 category-toggle-icon" style="font-size: 10px"></i>
                                    @endif
                                </h6>
                            </div>
                        </div>

                        <!-- Column 2: Options Dropdown -->
                        <div class="col-lg-6 col-md-4 col-2 text-end category-options">
                            <div class="filter z-5">
                                <a class="icon text-primary" href="#" data-bs-toggle="dropdown">
                                    <i class="fa fa-ellipsis-h py-1"></i>
                                </a>
                                @include('categories.dropdownMenu', [
                                    'categoryId' => $category->id,
                                    'categoryName' => $category->name,
                                    'isSubcategory' => false,
                                    'subcategories' => $category->subcategories,
                                    'canDelete' => !count($category->subcategories),
                                    'isParentable' => true,
                                    'parentId' => null,
                                ])
                            </div>
                        </div>

                        @if (count($category->subcategories))
                            @include('categories.subCategoryList', [
                                'subcategories' => $category->subcategories,
                                'isParentable' => true,
                            ])
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="modalDiv">
        @include('categories.addCategoryForm')
        @include('categories.updateCategoryForm')
    </div>
@endsection
