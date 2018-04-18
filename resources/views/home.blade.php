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
                        {{--<div class="col-sm-12">--}}
                        {{--<div class="form-group">--}}
                        {{--@if(isset($current_site))--}}
                        {{--<form method="POST" action="/delete_site">--}}
                        {{--{{ csrf_field() }}--}}
                        {{--<input type="hidden" name="site_id" value="{{ $current_site->id }}">--}}
                        {{--<button class="form-control btn-danger" class="">Delete site</button>--}}
                        {{--</form>--}}
                        {{--@endif--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-sm-12">
                            <form method="POST" action="/add_site">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input type="text" name='site_name' class="form-control"
                                           @if (session('site_url'))
                                           value="{{ session('site_url') }}"
                                           @endif placeholder="Add new site...">
                                    <span class="input-group-btn">
                                <button type="submit" class="btn btn-default" data-toggle="confirmation">Add!</button>
                            </span>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-12">
                            @if (session('incorrect_site'))
                                <div class="alert alert-danger">
                                    {{ session('incorrect_site') }}
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-sm-9">
                @if(isset($links))
                    <div class="row">
                        @if(isset($current_site))
                            <div class="col-sm-12">
                                <form method="POST" action="/search">
                                    {{ csrf_field() }}
                                    <div class="input-group">
                                        <input type="hidden" name="site_id" value="{{$current_site->id}}">
                                        <input type="text" name="search_url" class="form-control"
                                               placeholder="Search for..."
                                               @if (session('url'))
                                               value="{{ session('url') }}"
                                               @endif
                                               required>
                                        <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Search!</button>
                                </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12">
                                @if (session('incorrect_search'))
                                    <div class="alert alert-danger">
                                        {{ session('incorrect_search') }}
                                    </div>
                                @endif
                            </div>
                            @if(isset($empty) and $empty)
                                <form method="POST" action="/add_link">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="site_id" value="{{ $current_site->id }}">
                                    <input type="hidden" name="search_url" value="{{ $empty }}">
                                    <div class="col-sm-12">
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <h4>Link <strong>{{ $empty }}</strong> is not available now!</h4>
                                            <p>Do you want to add this link</p>
                                            <p>
                                                <button type="submit" class="btn btn-danger">Add the link</button>
                                                <button type="button" class="btn btn-default"
                                                        onclick="$('.alert').hide()">
                                                    Not now!
                                                </button>
                                            </p>
                                        </div>
                                    </div>

                                </form>
                            @endif
                        @endif
                        @endif
                    </div>
                    <div id="table">
                        @include('components.table')
                    </div>
            </div>
        </div>
    </div>
@endsection
