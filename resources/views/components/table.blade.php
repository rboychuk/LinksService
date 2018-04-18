<table class="table table-responsive-sm" size="1">
    <thead>
    <tr>
        <th>Link</th>
        <th>Created at</th>
        <th>Created by</th>
        <th>
            Remove
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($links as $link)
        @if(Auth::user()->email==$link->creator || Auth::user()->role=='superuser')
            <tr>
                <td>{{ $link->link }}</td>
                <td>{{ $link->created_at }}</td>
                <td class="text-muted">{{ $link->creator }}</td>
                @if(Auth::user()->role=='superuser')
                    <td>
                        <form method='POST' action="/delete">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $link->id }}">
                            <input type="hidden" name="site_id" value="{{ $current_site->id }}">
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </button>
                        </form>
                    </td>
                @else
                    <td><p class="text-muted">Not permitted</p></td>
                @endif
            </tr>
        @endif
    @endforeach
    </tbody>
</table>