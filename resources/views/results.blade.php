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
                text: 'Monthly Average Temperature'
            },
            xAxis: {
                categories: ['2018-Jan', '2018-Apr', '2018-May', '2018-Jun',]
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
            series: [{
                name: 'Iris Milton',
                data: [0, 128, 0, 0,]
            }, {
                name: 'London',
                data: [3.9, 4.2, 5.7, 8.5,]
            },
            {
                name: 'Timpao',
                data: [4.9, 5.2, 6.7, 7.5,]
            }]
        });
    </script>
@endsection

