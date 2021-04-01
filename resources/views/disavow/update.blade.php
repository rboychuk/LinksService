@extends('layouts.app')


@section('content')

    <style>
        .p_comment{
            font-style: italic;
            color: grey;
        }
        .p_comment strong {
            font-size: 14pt;
            width: 130px;
            display: inline-block;
        }
        .get-result{
            margin: 0 10px !important;
        }
    </style>

    <div class="container">
        <p class="p_comment"><strong>{{ count($google_links) }}</strong> Ссылки которые вы загрузили из файла Google Domains</p>
        <p class="p_comment"><strong>{{ count($ahrefs_links) }}</strong> Ссылки которые вы загрузили из файла Ahref Domains</p>
        <p class="p_comment"><strong>{{ $count_unique }}</strong> Уникальных ссылок из google и ahrefs, которые есть в обоих списках</p>
        <p class="p_comment"><strong>{{ count($disavow_links) }} / {{ count($links_in_disavow)}}</strong> Ссылки которые вы загрузили из файла Disavow / Совпадений со списком google+ahrefs
            <a href="{{ $links_in_disavow_url }}">
                <button type="button" class="btn get-result">Скачать совпадения</button>
            </a>
        </p>

        <p class="p_comment"><strong>{{ count($domains) }} / {{count($links_in_domain)}}</strong> Количество доменов, добавленных при загрузке линков / Совпадений со списком google+ahrefs</p>
        <p class="p_comment"><strong>{{ count($gray_domains) }} / {{count($links_in_gray)}}</strong> "Серые" домены, которые были добавлены вручную / Совпадений со списком google+ahrefs
            <a href="{{ $links_in_gray_url }}">
                <button type="button" class="btn get-result">Скачать совпадения</button>
            </a>
        </p>

        <p class="p_comment"><strong>{{ count($diff) }}</strong> Новые домены (из google,ahrefs доменов, которых нет в серых, уникальных доменах, disavow файле)</p>
        <div class="row">
        </div>
        <div class="row">
            <div class="col-sm-6">
                @if($url)
                    <a href="{{ $url }}">
                        <button type="button" class="btn btn-success">Link with results</button>
                    </a>
                @else
                    <div class="alert alert-danger" role="alert">
                        Something went wrong
                    </div>
                @endif
                <a href="{{ route('disavow_index') }}">
                    <button type="button" class="btn btn-info">Back to Disavow Page</button>
                </a>
            </div>
        </div>
    </div>

@endsection