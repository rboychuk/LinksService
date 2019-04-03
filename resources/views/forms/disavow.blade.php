<form method="POST" action="/disavow" class="form-inline" enctype="multipart/form-data">
    {{ csrf_field() }}
<div class="row">
    <label for="site_id" class="col-sm-3">Choose the site</label>
    <select class="form-control" name="site_id" id="site_id" required>
        <option selected></option>
        @foreach($sites as $site)
            <option value="{{ $site->id }}">{{$site->name}}</option>
        @endforeach
    </select>
</div>
    <label for="ahrefl_list" class="col-sm-3">Ahrefs list</label>
    <input style="margin: 10px 0 " name="ahrefs_list" id="ahrefs_list"
           type="file"/>

    <label for="google_list" class="col-sm-3">Google list</label>
    <input style="margin: 10px 0 " name="google_list" id="google_list"
           type="file"/>



    <button class="btn btn-default" type="submit">Upload</button>
</form>