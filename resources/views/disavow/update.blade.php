@extends('layouts.app')


@section('content')

    <div class="container">
        <p>Ahrefs <strong>{{ count($ahrefs_links) }}</strong></p>
        <p>Google <strong>{{ count($google_links) }}</strong></p>
        <p>Disavow <strong>{{ count($disavow_links) }}</strong></p>
        <p>Our Domains <strong>{{ count($domains) }}</strong></p>
        <p>Our Checked Good domains <strong>{{ count($disavow_domains) }}</strong></p>
        <p>New Disavow <strong>{{ count($diff) }}</strong></p>
        <div class="row">
        </div>
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
                <a href="{{ route('disavow_index') }}">
                    <button type="button" class="btn btn-info">Back to Disavow Page</button>
                </a>
            </div>
        </div>
    </div>

@endsection