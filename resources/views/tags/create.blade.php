@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Add Tag</h1>

        @if(count($errors))
            <div class="alert alert-danger">
                <ul>            
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
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
    </div>

@endsection