<script>
    Highcharts.chart("{{ $id }}", {
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
                @if($goals)
            {
                name: 'Goals',
                data: [
                    @foreach($goals as $count)
                    {{ $count }},
                    @endforeach
                ]

            },
                @endif
            {
                name: 'TOTAL',
                data: [
                    @foreach($results_service->getAllReports() as $count)
                    {{ $count }},
                    @endforeach
                ]

            },
        ]
    });
</script>