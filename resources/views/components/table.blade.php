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
                <td style="max-width: 500px;overflow-x: auto;">{{ $link->link }}</td>
                <td>{{ $link->created_at }}</td>
                <td class="text-muted">{{ $link->creator }}</td>
                @if(Auth::user()->role=='superuser')
                    <td>
                        @include('forms.delete')
                    </td>
                @else
                    <td><p class="text-muted">Not permitted</p></td>
                @endif
            </tr>
        @endif
    @endforeach
    </tbody>
</table>