<form method="POST" action="/disavow" class="form-inline" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label for="ahrefl_list" class="col-sm-3">Ahrefs list</label>
    <input style="margin: 10px 0 " name="ahrefs_list" id="ahrefs_list"
           type="file"/>

    <label for="google_list" class="col-sm-3">Google list</label>
    <input style="margin: 10px 0 " name="google_list" id="google_list"
           type="file"/>

    <button class="btn btn-default" type="submit">Upload</button>
</form>