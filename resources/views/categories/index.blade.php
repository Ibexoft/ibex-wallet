@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card-header pb-0 mt-4 d-flex justify-content-between">
            <h6 class="mb-0">Categories</h6>
            <button type="button" class="btn btn-sm btn-block bg-gradient-primary mb-3" data-bs-toggle="modal"
                data-bs-target="#exampleModalMessage" onclick="setCategory(null)">+ Add Category</button>
        </div>

        <div class="category-list pb-2">
            @foreach ($categories as $category)
                {{-- Parent Category --}}
                <div class="category-card bg-white m-auto position-relative row align-items-center justify-content-between py-2 px-0 rounded my-3 shadow-sm"
                    style="" id="category-{{$category->id}}">
                    <!-- Column 1: Category Info -->
                    <div onclick="toggleCategory.call(this)"
                        class="dropdown-toggler col-lg-5 col-md-5 col-10 d-flex align-items-center opacity-10"
                        style="cursor: pointer;">
                        <div class="col-auto icon icon-sm icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="fa {{$category->icon}} opacity-10" aria-hidden="true" style="font-size: 0.85rem;"></i>
                        </div>
                        <div class="mx-2 col">
                            <h6 class="mb-0 fw-bold d-flex align-items-center text-muted">
                                {{ $category->name }}
                                @if (count($category->subcategories))
                                    <i class="fa fa-chevron-down ms-2 category-toggle-icon" style="font-size: 10px"></i>
                                @endif
                            </h6>
                        </div>
                    </div>

                    <!-- Column 2: Progress Bar -->
                    <div class="col-lg-2 col-md-3 text-center d-md-block d-none" title="Category Share">
                        <p class="p-0 m-0 text-sm">40%</p>
                        <div class="progress d-flex align-items-center" style="height: 8px;">
                            <div class="progress-bar bg-gradient-primary" style="width: 40%; height: 100%;">
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Options Dropdown -->
                    <div class="col-lg-5 col-md-4 col-2 text-end category-options">
                        <div class="filter z-5">
                            <a class="icon text-primary" href="#" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-h py-1"></i>
                            </a>
                            <ul class="dropdown-menu shadow-md">
                                <li>
                                    <a class="dropdown-item py-1" href="#" style="font-size: 12px;"
                                        data-bs-toggle="modal" data-bs-target="#exampleModalMessage"
                                        onclick="setCategory({{ $category->id }})">
                                        Add subcategory
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-1" href="#" style="font-size: 12px;"
                                        data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                        onclick="setCategory({{ $category->id }}, '{{$category->name}}')">
                                        Edit
                                    </a>
                                </li>
                                {{-- {{dd(count($categories))}} --}}
                                @if (!count($category->subcategories) && count($categories) > 1)
                                    <li onclick="deleteCategory({{$category->id}})">
                                        <a class="dropdown-item py-1" href="#" style="font-size: 12px;">
                                            Delete
                                        </a>
                                    </li>
                                @endif
                            </ul>
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
    {{-- @include('categories.addSubCategoryForm') --}}
@endsection
