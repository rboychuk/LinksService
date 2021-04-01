@extends('layouts.app')


@section('content')

    <div class="container">

        @if (session('uploaded_domains'))
            <div class="alert alert-success">
                <strong>{{ session('uploaded_domains') }}</strong> Домены добавлены
            </div>
        @endif

        <diw class="row">
            @include('forms.upload_disavow')
            @include('forms.extract_domains')
        </diw>

        <hr>

        @include('forms.disavow')
    </div>

@endsection