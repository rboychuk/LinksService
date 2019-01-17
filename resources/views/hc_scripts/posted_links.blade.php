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