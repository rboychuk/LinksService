<form method="POST" action="/upload_disavow_file" class="form-inline" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="row" style="padding: 10px 0">
        <input required class="col-sm-2" name="disavow_file" id="disavow_list"
               type="file"/>
    </div>

    <button class="btn btn-warning" type="submit">Upload file with "good" domains</button>
</form>