@extends('layouts.app')

@section('content')

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
                
@endsection