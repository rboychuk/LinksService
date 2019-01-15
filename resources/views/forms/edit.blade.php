<form method="POST" action="/update">
    {{ csrf_field() }}
    <input type="hidden" name="id" value={{ $link->id }}>
    @if($link->dublicate_domain)
        <div class="alert alert-warning" role="alert">
            Dublicate link!
        </div>
    @endif

    @if(!$link->ahref)
        <div class="alert alert-warning" role="alert">
            Link not Found
        </div>
    @endif

    <div class="form-group row">
        <label for="link" class="col-sm-1 col-form-label">URL</label>
        <div class="col-sm-11">
            <input type="text" readonly class="form-control" id="link" name="link" value={{ $link->link }}>
        </div>
    </div>
    <div class="form-group row">
        <label for="target_url" class="col-sm-1 col-form-label">Link to</label>
        <div class="col-sm-11">
            <input type="text" readonly class="form-control" id="target_url" name="target_url"
                   value={{ $link->target_url }}>
        </div>
    </div>

    <div class="form-group row">
        <label for="anchor" class="col-sm-1 col-form-label">Posted Anchor</label>
        <div class="col-sm-11">
            <input type="text" class="form-control" id="anchor" name="anchor"
                   value={{$link->anchor}}>
        </div>
    </div>

    @if(isset($link->ahref) && isset($link->ahref['anchor']) && $link->ahref['anchor']!=$link->anchor)
        <div class="form-group row">
            <label for="ahref_anchor" class="col-sm-1 col-form-label">Anchor</label>
            <div class="col-sm-11">
                <input type="text" class="form-control" id="ahref_anchor"
                       style="background-color: red; color: white; font-weight: bold"
                       value={{$link->ahref['anchor']}} >
            </div>
        </div>
    @endif

    <div class="form-group row">
        <label for="meta" class="col-sm-1 col-form-label">Rel</label>
        <div class="col-sm-11">
            <input type="text" class="form-control" id="anchor" name="meta"
                   value=@if(isset($link->ahref) && isset($link->ahref['rel'])) {{$link->ahref['rel']}} @else '' @endif>
        </div>
    </div>

    <div class="form-group row">
        <label for="pa" class="col-sm-2 col-form-label">PA</label>
        <div class="col-sm-3">
            <input type="text" readonly class="form-control" id="pa" name="pa"
                   value={{ count($link->moz)??$link->moz['upa'] }}>
        </div>
        <div class="col-sm-1">
        </div>
        <label for="ref_domain" class="col-sm-2 col-form-label">Ref domain</label>
        <div class="col-sm-3">
            <input type="text" readonly class="form-control" id="ref_domain" name="ref_domain"
                   value={{ count($link->moz)??$link->moz['pda'] }}>
        </div>
    </div>

    <div class="form-group row">
        <label for="out_links" class="col-sm-2 col-form-label">Внешних ссылок</label>
        <div class="col-sm-3">
            <input type="text" readonly class="form-control" id="out_links" name="out_links"
                   value={{ count($link->moz)??$link->moz['ueid'] }}>
        </div>
        <div class="col-sm-1">
        </div>
        <label for="in_links" class="col-sm-2 col-form-label">Внутренних ссылок</label>
        <div class="col-sm-3">
            <input type="text" readonly class="form-control" id="in_links" name="in_links"
                   value={{ count($link->moz)??$link->moz['uid'] }}>
        </div>
    </div>

    <div class="form-group row">
        <label for="theme" class="col-sm-2 col-form-label">Тематичность</label>
        <div class="col-sm-3">
            <select class="form-control" name="theme" id="theme">
                <option value="1">Да</option>
                <option value="0" @if(!$link->theme) selected @endif>Нет</option>
            </select>
        </div>
        <div class="col-sm-1">
        </div>
        <label for="theme_domain" class="col-sm-2 col-form-label">Тем. Домен</label>
        <div class="col-sm-3">
            <select class="form-control" name="theme_domain" id="theme_domain">
                <option value="1">Да</option>
                <option value="0" @if(!$link->theme_damain) selected @endif>Нет</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="position" class="col-sm-2 col-form-label">Позиция</label>
        <div class="col-sm-3">
            <select class="form-control" name="position" id="position">
                <option value="top">Top</option>
                <option value="middle" @if($link->position=='middle') selected @endif>Middle</option>
                <option value="bottom" @if($link->position=='bottom') selected @endif>Bottom</option>
            </select>
        </div>
        <div class="col-sm-1">
        </div>
        <label for="price" class="col-sm-2 col-form-label">Цена</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="price" id="price" value={{ $link->price }}>
        </div>
    </div>

    <div class="form-group row">
        <label for="link_in_search" class="col-sm-2 col-form-label">Ссылка на результат</label>
        <div class="col-sm-3">
            <select class="form-control" name="link_in_search" id="link_in_search">
                <option value="1">Да</option>
                <option value="0" @if(!$link->link_in_search) selected @endif>Нет</option>
            </select>
        </div>

        <div class="col-sm-1">
        </div>
        <label for="resource" class="col-sm-2 col-form-label">Источник ссылки</label>
        <div class="col-sm-3">
            <select class="form-control" name="resource" id="resource">
                <option value="">...</option>
                <option value="google" @if($link->resource=='google') selected @endif>Google</option>
                <option value="yandex" @if($link->resource=='yandex') selected @endif>Yandex</option>
                <option value="facebook" @if($link->resource=='facebook') selected @endif>Facebook</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="comment" class="col-sm-2 col-form-label">Комментарий:</label>
        <div class="col-sm-9">
            <textarea class="form-control" name="comment" id="comment" cols="10" rows="10">{{$link->comment}}</textarea>
        </div>
    </div>

    @if($link->dublicate_domain)
        <div class="form-group row">
            <div class="col-sm-12 text-right">
                <input type="checkbox" class="" name="dublicate_domain" checked>
                Dublicate domain
                </input>
            </div>
        </div>
    @endif

    <div class="form-group row">
        <div class="col-sm-12 text-center">
            <input type="checkbox" id='validate' class="" name="validate" @if($link->enabled) checked @endif>
            Validate this link
            </input>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-lg btn-success">SAVE</button>
        </div>
    </div>


</form>