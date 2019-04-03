@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                @if($url)
                    <a href="{{ $url }}">
                        <button type="button" class="btn btn-success">Link with results</button>
                    </a>
                @else
                    <div class="alert alert-danger" role="alert">
                        Something went wrong
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection