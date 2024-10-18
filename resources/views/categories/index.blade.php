@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card-header pb-0 mt-4 d-flex justify-content-between">
            <h6 class="mb-0">Categories</h6>
            <button type="button" class="btn btn-sm btn-block bg-gradient-primary mb-3" data-bs-toggle="modal"
                data-bs-target="#addCategoryModal" onclick="setCategory(null, false)">+ Add Category</button>
        </div>

        <div class="category-list pb-2">
            @foreach ($categories as $category)
                {{-- Parent Category --}}
                <div class="category-card bg-white m-auto position-relative row align-items-center justify-content-between py-2 px-0 rounded my-3 shadow-sm" id="category-{{$category->id}}">
                    <!-- Column 1: Category Info -->
                    <div onclick="toggleCategory.call(this)"
                        class="dropdown-toggler col-lg-6 col-md-8 col-10 d-flex align-items-center opacity-10"
                        style="{{ count($category->subcategories) ? 'cursor: pointer;' : '' }}">
                        <div class="col-auto icon icon-sm icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="fa {{$category->icon}} opacity-10" aria-hidden="true" style="font-size: 0.85rem;"></i>
                        </div>
                        <div class="mx-2 col">
                            <h6 class="mb-0 fw-bold d-flex align-items-center text-muted category-title">
                                <span id="category-{{$category->id}}-name">{{ $category->name }}</span>
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
                                'parentId' => null
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


    @include('categories.addCategoryForm')
    @include('categories.updateCategoryForm')
@endsection
