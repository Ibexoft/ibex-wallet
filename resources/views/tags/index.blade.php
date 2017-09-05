@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Tags</div>

                <div class="panel-body">
                    
                    <div>
                    @foreach ($tags as $tag)
                        <a href="/tags/{{ $tag->name }}">
                            <span class="badge badge-pill badge-primary">{{ $tag->name }}</span>
                        </a>
                    @endforeach
                    </div>
                    <hr/>
                    <div>
                        <a class="btn btn-primary" href="/tags/create"><small>Add</small></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection