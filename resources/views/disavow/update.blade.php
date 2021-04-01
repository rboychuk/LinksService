@extends('layouts.app')


@section('content')

    <style>
        .p_comment{
            font-style: italic;
            color: grey;
        }
        .p_comment strong {
            font-size: 14pt;
            width: 50px;
            display: inline-block;
        }
    </style>

    <div class="container">
        <p class="p_comment"><strong>{{ count($google_links) }}</strong> Ссылки которые вы загрузили из файла Google Domains</p>
        <p class="p_comment"><strong>{{ count($ahrefs_links) }}</strong> Ссылки которые вы загрузили из файла Ahref Domains</p>
        <p class="p_comment"><strong>{{ $count_not_unique }}</strong> Уникальных ссылок из google и ahrefs, которых нет одновременно в двух списках</p>
        <p class="p_comment"><strong>{{ count($disavow_links) }}</strong> Ссылки которые вы загрузили из файла Disavow</p>
        <p class="p_comment"><strong>{{ count($domains) }}</strong> Количество доменов, добавленных при загрузке линков</p>
        <p class="p_comment"><strong>{{ count($disavow_domains) }}</strong> "Серые" домены, которые были добавлены вручную</p>
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