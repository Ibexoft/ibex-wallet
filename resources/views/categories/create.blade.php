@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $category ?? '' ? 'Edit' : 'Add' }} Income & Expense</div>

                <div class="card-body">
                    <form method="POST" action="{{ $category ?? '' ? route('categories.update', ['category' => $category->id]) : route('categories.store') }}">
                        @if ($category ?? '') @method('PUT') @endif
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $category ?? '' ? $category->name : old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="parent_category_id" class="col-md-4 col-form-label text-md-right">Parent</label>

                            <div class="col-md-6">
                                <select name="parent_category_id" id="parent_category_id" class="form-control @error('parent_category_id') is-invalid @enderror" autocomplete="parent_category_id">
                                    <option></option>
                                    @foreach ($parentCategories as $cat)
                                        <option value="{{ $cat->id }}" {{ $category ?? '' ? $category->parent_category_id == $cat->id ? 'selected' : ($category->id == $cat->id ? "disabled" : '') : '' }}>{{ $cat->name }}</option>

                                        @if (count($cat->subcategories))
                                            @include ('categories.subCategoryOption', ['subcategories' => $cat->subcategories, 'indent' => 1])
                                        @endif
                                    @endforeach
                                </select>

                                @error('parent_category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="icon" class="col-md-4 col-form-label text-md-right">Icon</label>

                            <div class="col-md-6">
                                <input id="icon" type="file" class="form-control @error('icon') is-invalid @enderror" name="icon" autocomplete="icon">

                                @error('icon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ $category ?? '' ? 'Save' : 'Add' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
