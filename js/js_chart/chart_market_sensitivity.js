if ($('#chart_thitruong_3').length > 0) {
    Highcharts.chart('chart_thitruong_3', {
        chart: {
            type: 'areaspline',
        },
        title: {
            text: 'Area chart with negative values',
            style: { "display": "none" }
        },
        tooltip: {
            headerFormat: '',
            shared: true,
        },
        xAxis: {
            categories: ['Ngày 1', 'Ngày 2', 'Ngày 3', 'Ngày 4', 'Ngày 5', 'Ngày 6', 'Ngày 7', 'Ngày 8', 'Ngày 9', 'Ngày 10'],
            visible: false,
        },
        yAxis: {
            allowDecimals: true,
            // min: 0,
            title: {
                text: 'Total fruit consumption',
                style: { "display": "none" }
            }
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                opacity: 0.9,
                lineWidth: 3,
                marker: {
                    enabled: false,
                },
            }
        },
        series: [{
            name: 'Overbuy',
            color: "#ff621f",
            data: [2, 3, 1, 1.2, 2, 1, 3, 2.4, 2, 2, 3, 3, 3.2, 3, 2, 2, 3, 2.1, 1, 2, 1, 3, 2.4, 2, 2, 1, 3, 1.2, 1, 2, 2, 3, 2.5, 2, 2, 1, 3, 4, 1, 2]
        }, {
            name: 'Oversell',
            color: "#56BA47",
            data: [-2, -3, -1, -1.2, -2, -1, -3, -2.4, -2, -2, -3, -3, -3.2, -3, -2, -2, -3, -2.1, -1, -2, -1, -3, -2.4, -2, -2, -1, -3, -1.2, -1, -2, -2, -3, -2.5, -2, -2, -1, -3, -4, -1, -2]
        }]
    });
}