@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Income & Expenses <small>({{ $categories->count() }})</small>
                    <a href="categories/create" class="small float-right">Add Expense or Income</a>
                </div>

                <div class="card-body">
                    @foreach ($categories as $category)
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('categories.edit', ['category' => $category->id]) }}">{{ $category->name }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
