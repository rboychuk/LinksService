<form action="/package_upload" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <hr>
    Choose the file with reports:
    <button type="button" class="btn btn-info" data-toggle="modal"
            data-target="#helper_upload"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
    </button>
    <input class="" style="margin: 10px 0 " name="file_report"
           type="file"/>
    @include('forms._components.type_select')

    <hr>
    <!-- Modal -->
    <div id="helper_upload" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Helper</h4>
                </div>
                <div class="modal-body">
                    <h4>File-name Format</h4>
                    <p>EMAIL__MONTH__YEAR.CSV</p>
                    <ul>
                        <li>Email - full email address ( alexandro_123@mail.com )</li>
                        <li>Month - Month in format Jan,Feb,Jun ......</li>
                        <li>Year - Year in format 2017, 2018 ...</li>
                        <li><strong>Be attentive!!! Delimiter is __ (double underscore)</strong></li>
                        <li><strong>File format is CSV</strong></li>
                    </ul>
                    <h4>File format</h4>
                    <ul>
                        <li>First column (A) - Page url with link</li>
                        <li>Second column (B) - Url (href to our site)</li>
                        <li>Third column (C) - Anchor</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @if(session('upload_error'))
        <div class="alert alert-danger" role="alert">
            {{ session('upload_error') }}
        </div>
    @endif
    @if(session('counter'))
        <div class="alert alert-success" role="alert">
            {{ session('counter'). ' links was uploaded' }}
        </div>
    @endif

    <input type="hidden" name="site_id" value="{{$current_site->id}}">
    <input class="btn btn-default" type="submit" value="Upload"/>
</form>