<form method="POST" action="/report">
    {{ csrf_field() }}
    <div class="col-sm-12">
        <div class="form-group">
            <label for="sel2">Select User Name:</label>
            <select name="user_email" class="form-control" id="sel2" required>
                @if(Auth::user()->role=='superuser')
                <option selected></option>
                    @foreach($users as $user)
                        <option value="{{ $user->email }}">{{$user->email}}</option>
                    @endforeach
                @else
                    <option selected value="{{ Auth::user()->email }}">{{Auth::user()->email}}</option>
                @endif
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
    {{--@if(isset($results))--}}
    {{--@foreach($results as $site=>$link)--}}
    {{--<div class="col-sm-12">--}}
    {{--<div class="form-group">--}}
    {{--<a href="{{ $link }}">--}}
    {{--Domain list for {{ $site }}--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@endforeach--}}
    {{--@endif--}}
</form>