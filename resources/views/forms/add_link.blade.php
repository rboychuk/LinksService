<form method="POST" action="/add_link">
    {{ csrf_field() }}
    <input type="hidden" name="site_id" value="{{ $current_site->id }}">
    <input type="hidden" name="search_url" value="{{ $empty }}">
    <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible" role="alert">
            @if(isset($domain) && !is_null($domain))
                <h4>Domain <strong>{{ $domain->domain }}</strong> was found</h4>
            @endif

            <h4>Link <strong>{{ $empty }}</strong> is not available now!</h4>
            <p>Do you want to add this link?</p>
            @if(isset($domain) && !$domain->multiple && Auth::user()->role=='superuser')
                <input type="checkbox" id='multidomain' name="multiple"
                       value="{{ $links->count() }}">
                <label for="multidomain">Make this domain available for the several
                    links</label>
            @endif
            <div class="row">
                @if(!$links->count() || (isset($domain) && $domain->multiple))
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-danger" id="add_link">Add
                        </button>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="meta" required>
                            <option readonly selected></option>
                            <option value="Blog Post">Blog Post</option>
                            <option value="Comment">Comment</option>
                            <option value="Web 2.0">Web 2.0</option>
                            <option value="PBN">PBN</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                @endif
                <div></div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-default"
                            onclick="$('.alert').hide()">
                        Not now!
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>