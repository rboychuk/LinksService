@extends('layouts.app')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

@section('content')
    <div class="container">
        <div id="container"></div>
    </div>

    <script>
        Highcharts.chart('container', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Posted links Report'
            },
            xAxis: {
                categories: [
                    @foreach($dates as $date)
                        '{{ $date }}',
                    @endforeach
                ]
            },
            yAxis: {
                title: {}
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true
                    },
                    label: {
                        connectorAllowed: false
                    },
                }
            },
            series: [
                    @foreach($users as $name=>$dates)
                {
                    name: '{{$name}}',
                    data: [
                        @foreach($dates as $date)
                        {{ $date->count() }},
                        @endforeach
                    ]

                },
                    @endforeach
                {
                    name: 'TOTAL',
                    data: [
                        @foreach($all as $count)
                        {{ $count }},
                        @endforeach
                    ]

                },
            ]
        });
    </script>
@endsection

