<button type="button" class="btn @if($link->ahref)btn-success @else btn-danger @endif" data-toggle="modal"
        data-target="#hrefModal{{$k}}">?
</button>

<!-- Modal -->
<div id="hrefModal{{$k}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ahref validation</h4>
            </div>
            <div class="modal-body">
                @if($link->ahref)
                    <ul>
                        @foreach($link->ahref as $key=>$value)
                            <li>{{ $key .' - '.$value }}</li>
                        @endforeach
                    </ul>
                @else
                    <h4>No link found!!</h4>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


