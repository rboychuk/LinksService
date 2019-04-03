@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <form action="/disavow"></form>
                @include('forms.disavow')
            </div>
        </div>
    </div>

@endsection