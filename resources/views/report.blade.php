@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('forms.report')
            </div>
            <div class="col-sm-9">
                @if(isset($links_collection) && $links_collection->count())
                    <ul class="nav nav-tabs">
                        @foreach($links_collection as $date=>$value)
                            <li @if($date==$links_collection->keys()[0]) class="active" @endif><a data-toggle="tab"
                                                                                                  href="#report-{{ $date }}">{{ $date }}</a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($links_collection as $date=>$links)
                            <div id="report-{{ $date }}"
                                 class="tab-pane fade in @if($date==$links->keys()[0]) active @endif">
                                <table class="table table-responsive-sm" size="1">
                                    <thead>
                                    <tr>
                                        <th>Validate</th>
                                        <th>Site</th>
                                        <th>Link</th>
                                        <th>Created by</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($links as $k=>$link)
                                        @if(Auth::user()->email==$link->creator || Auth::user()->role=='superuser')
                                            <tr>
                                                <td>
                                                    @include('report.validate')
                                                </td>
                                                <td>{{ $link->name }}</td>
                                                <td style="max-width: 450px;overflow-x: auto;"><a
                                                        @if($link->ahref)
                                                        @if($link->ahref['link'])
                                                        class="text-info"
                                                        @elseif(!$link->ahref['domain'])
                                                        class="text-danger"
                                                        @elseif($link->ahref['domain'])
                                                        class="text-muted"
                                                        @endif
                                                        @endif
                                                        href="{{ $link->link }}">{{ $link->link }}</a></td>
                                                <td class="text-muted">{{ $link->creator }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <!-- Trigger the modal with a button -->
                                    </tbody>
                                </table>
                            </div>

                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
