<form method="POST" action="/extract_domains" class="form-inline col-sm-6" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="row" style="padding: 10px 0">
        <input required class="col-sm-12" name="extract_domain" id="extract_domain"
               type="file"/>
    </div>

    <button class="btn btn-warning" type="submit">Извлечь домены из линков</button>
    @if($url = session('extractDomains'))
        <a href="{{ $url }}">
            <button type="button" class="btn btn-success">Скачать домены для линков</button>
        </a>
    @endif
</form>