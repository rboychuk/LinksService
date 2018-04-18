@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <form method="POST" action="/report">
                    {{ csrf_field() }}
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="sel2">Select User Name:</label>
                            <select name="user_email" class="form-control" id="sel2" required>
                                <option selected></option>
                                @foreach($users as $user)
                                    <option value="{{ $user->email }}">{{$user->email}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="sel3">Select site:</label>
                            <select name="site_id" class="form-control" id="sel3" required>
                                <option selected></option>
                                @foreach($sites as $site)
                                    <option value="{{ $site->id }}">{{$site->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <button type='submit' class="btn">Make report</button>
                        </div>
                    </div>
                    @if(isset($path))
                        <div class="col-sm-12">
                            <div class="form-group">
                                <a href="{{ $path }}">
                                    Download report
                                </a>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
            <div class="col-sm-9">
                @if(isset($links) && $links->count())
                    <table class="table table-responsive-sm" size="1">
                        <thead>
                        <tr>
                            <th>Site</th>
                            <th>Link</th>
                            <th>Created at</th>
                            <th>Created by</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($links as $link)
                            @if(Auth::user()->email==$link->creator || Auth::user()->role=='superuser')
                                <tr>
                                    <td>{{ $link->name }}</td>
                                    <td>{{ $link->link }}</td>
                                    <td>{{ $link->created_at }}</td>
                                    <td class="text-muted">{{ $link->creator }}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
