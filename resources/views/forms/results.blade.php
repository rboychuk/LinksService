<form method="POST" action="/results" class="form-inline">
    {{ csrf_field() }}
        <select name="site_id" class="form-control" id="sel3" required>
            <option selected></option>
            @foreach($sites as $site)
                <option value="{{ $site->id }}">{{$site->name}}</option>
            @endforeach
        </select>

        @include('forms._components.type_select')
        <button class="btn btn-default" type="submit">Get Results</button>
</form>