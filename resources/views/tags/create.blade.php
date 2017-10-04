@extends('layouts.app')

@section('content')

@include('layouts.errors')

<form method="POST" action="/tags">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="name">Tag</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" placeholder="Enter tag" required>
        <small id="nameHelp" class="form-text text-muted">Name of your tag</small>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Add Tag</button>
    </div>
</form>
                
@endsection