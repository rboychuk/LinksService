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

                                        {{--<select class="form-control" required>--}}
                                            {{--<option readonly selected></option>--}}
                                            {{--<option value="Blog Post">Blog Post</option>--}}
                                            {{--<option value="Comment">Comment</option>--}}
                                            {{--<option value="Web 2.0">Web 2.0</option>--}}
                                        {{--</select>--}}

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
                                            @if(isset($domain) && !is_null($domain))
                                                <h4>Domain <strong>{{ $domain->domain }}</strong> was found</h4>
                                            @endif

                                            <h4>Link <strong>{{ $empty }}</strong> is not available now!</h4>
                                            <p>Do you want to add this link?</p>
                                            @if(isset($domain) && !$domain->multiple && Auth::user()->role=='superuser')
                                                <input type="checkbox" id='multidomain' name="multiple"
                                                       value="{{ $links->count() }}">
                                                <label for="multidomain">Make this domain available for the several
                                                    links</label>
                                            @endif
                                            <p>
                                                @if(!$links->count() || (isset($domain) && $domain->multiple))
                                                    <button type="submit" class="btn btn-danger" id="add_link">Add the
                                                        link
                                                    </button>
                                                @endif
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
