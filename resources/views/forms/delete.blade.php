<form method='POST' action="/delete">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $link->id }}">
    <input type="hidden" name="site_id" value="{{ $current_site->id }}">
    <button type="submit" class="btn btn-default">
        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
    </button>
</form>