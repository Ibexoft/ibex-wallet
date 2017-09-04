@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Tags | <a href="/tags/create"><small>Add</small></a></div>

                <div class="panel-body">
                    <ul>
                    @foreach ($tags as $tag)
                        <li><a href="/tags/{{ $tag->name }}">{{ $tag->name }}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection