<form method="POST" action="/upload_gray_domains" class="form-inline" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="row" style="padding: 10px 0">
        <input required class="col-sm-2" name="gray_domain" id="gray_domain"
               type="file"/>
    </div>

    <button class="btn btn-warning" type="submit">Добавление доменов, которые не получилось отфильтровать</button>
</form>