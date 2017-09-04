@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Tag</div>

                <div class="panel-body">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection