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