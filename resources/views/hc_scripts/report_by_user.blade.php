<script>
    Highcharts.chart("{{ $id }}", {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Monthly Average Rainfall'
        },
        subtitle: {
            text: 'Source: WorldClimate.com'
        },
        xAxis: {
            categories: [
                @foreach($user as $date=>$value)
                    "{{ $date }}",
                @endforeach
            ],
            crosshair: true
        },
        yAxis: {},
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'New Links',
            data: [
                @foreach($user as $value)
                {{ count($value) }},
                @endforeach
            ]

        }, {
            name: 'Duplicate',
            data: [
                @foreach($user as $value)
                {{ count( $value->filter(function($item){ return $item->dublicate_domain; }))}},
                @endforeach
            ]

        }]
    });
</script>