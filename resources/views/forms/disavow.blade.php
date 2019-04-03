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
    <div class="row" style="padding: 10px 0">
        <label for="ahrefl_list" class="col-sm-3">Ahrefs list</label>
        <input class="col-sm-2" name="ahrefs_list" id="ahrefs_list"
               type="file"/>
        <span class="col-sm-6"><i>Domains in Second Column</i></span>
    </div>
    <div class="row" style="padding: 10px 0">
        <label for="google_list" class="col-sm-3">Google list</label>
        <input class="col-sm-2" name="google_list" id="google_list"
               type="file"/>
        <span class="col-sm-6"><i>Domains in First Column</i></span>
    </div>
    <div class="row" style="padding: 10px 0">
        <label for="disavow_list" class="col-sm-3">Disavow</label>
        <input class="col-sm-2" name="disavow_list" id="disavow_list"
               type="file"/>
        <span class="col-sm-6"><i>Domains in First Column</i></span>
    </div>
    <span class="col-sm-12"><i>All files in CSV File. Domain Column have to be with some header('Ref domains'...) and domains</i></span>

    <button class="btn btn-default" type="submit">Upload</button>
</form>