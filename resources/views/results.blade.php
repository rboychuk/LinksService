@extends('layouts.app')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                @include('forms.results')
            </div>
            <div class="col-sm-6">
                @include('forms.add_goals')
            </div>
        </div>
    </div>

    @if(isset($users))
        <div class="container">

            <h3>
                @if($site_name=$results_service->getSiteName())
                    Results for <strong>{{ $site_name->name }}</strong> and
                    <strong>{{ $results_service->getMetaName() }}</strong> type
                @else

                @endif
            </h3>
            <div class="row">
                <div class="col-sm-12">
                    <div id="container"></div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3"> <!-- required for floating -->
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tabs-left">
                        @foreach(array_keys($users) as $key=>$user)
                            <li @if($key==0)class="active"@endif><a href="#user_{{ $key }}"
                                                                    data-toggle="tab">{{$user}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-9">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        @foreach(array_keys($users) as $key=>$user)
                            <div class="tab-pane @if($key==0) active @endif" id="user_{{ $key }}">
                                <div id="bar_charts_{{ $key }}"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr>
        </div>

        @include('hc_scripts.posted_links',['id'=>'container'])

        @foreach(array_keys($users) as $key=>$user)
            @include('hc_scripts.report_by_user',['id'=>"bar_charts_$key",'user'=>$users[$user] ])
        @endforeach

    @endif

@endsection

