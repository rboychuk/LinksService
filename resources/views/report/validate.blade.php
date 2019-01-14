<button type="button" class="btn @if($link->enabled) btn-success @else btn-warning @endif" data-toggle="modal"
        data-target="#validateModal{{$k}}"><span class="glyphicon glyphicon-check" aria-hidden="true"></span>
</button>

<!-- Modal -->
<div id="validateModal{{$k}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Validation</h4>
            </div>
            <div class="modal-body">
                @include('forms.edit')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


