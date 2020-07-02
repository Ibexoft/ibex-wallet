@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Categories
                    <a href="categories/create" class="small float-right">New Category</a>
                </div>

                <div class="card-body">
                    @foreach ($categories as $category)
                    <div class="row">
                        <div class="col-md-6">
                            {{ $category->name }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection