@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h1>Tags</h1>
            </div>
            <div class="col-4">
                <span><a class="btn btn-primary" href="/tags/create">Add Tag</a></span>
            </div>
        </div>

        <div class="row">
            <ul>
                @foreach ($tags as $tag)
                    <li> 
                        {{ $tag->name }} 
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection