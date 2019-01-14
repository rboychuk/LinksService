@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <label>Your Name:</label>
                            <p class="text-muted">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="sel1">Select Site Name:</label>
                            <select class="form-control" id="sel1">
                                @if(isset($current_site))
                                    <option selected value="{{ $current_site->id }}">{{ $current_site->name }}</option>
                                @else
                                    <option selected value="0">Choose the site..</option>
                                @endif
                                @if(isset($sites))
                                    @foreach($sites as $site)
                                        @if(!isset($current_site))
                                            <option value="{{ $site->id }}">{{$site->name}}</option>
                                        @else
                                            @if($current_site->id!=$site->id)
                                                <option value="{{ $site->id }}">{{$site->name}}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    @if(Auth::user()->role=='superuser')
                        <div class="col-sm-12">
                            @include('forms.add_site')
                        </div>
                        <div class="col-sm-12">
                            @if (session('incorrect_site'))
                                <div class="alert alert-danger">
                                    {{ session('incorrect_site') }}
                                </div>
                            @endif
                        </div>
                    @endif
                    @if(isset($current_site))
                        <div class="col-sm-12">
                            @include('forms.package_upload')
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-sm-9">
                @if(isset($links))
                    <div class="row">
                        @if(isset($current_site))
                            <div class="col-sm-12">
                                @include('forms.search')
                            </div>
                            <div class="col-sm-12">
                                @if (session('incorrect_search'))
                                    <div class="alert alert-danger">
                                        {{ session('incorrect_search') }}
                                    </div>
                                @endif
                            </div>
                            @if(isset($empty) and $empty)
                                @include('forms.add_link')
                            @endif
                        @endif
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="table">
                                @include('components.table')
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
