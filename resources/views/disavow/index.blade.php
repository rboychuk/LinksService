@extends('layouts.app')


@section('content')

    <div class="container">

        @if (session('uploaded_domains'))
            <div class="alert alert-success">
                <strong>{{ session('uploaded_domains') }}</strong> disavow domains was uploaded
            </div>
        @endif

        @include('forms.upload_disavow')
        <hr>

        @include('forms.disavow')
    </div>

@endsection