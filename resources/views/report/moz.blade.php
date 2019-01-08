<button type="button" class="btn @if(count($link->moz)>5) btn-info @else btn-danger @endif" data-toggle="modal"
        data-target="#myModal{{$k}}">?
</button>

<!-- Modal -->
<div id="myModal{{$k}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Metrics</h4>
            </div>
            <div class="modal-body">
                @if($link->moz)
                    <ul>
                        @foreach($link->moz as $key=>$moz)
                            @if($moz)
                                <li>{{ $key.' - '.$moz }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


