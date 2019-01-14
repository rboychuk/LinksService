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