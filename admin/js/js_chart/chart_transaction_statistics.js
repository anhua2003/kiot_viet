var thisPage = {};

$(function () {
    load_chart_transaction_statistics_4();
    load_chart_transaction_statistics_5();
});

function load_chart_transaction_statistics_4(){
    var data = new FormData();
    _doAjaxNod('POST', data, 'chart_transaction_statistics', 'chart', 'load_chart4', true, (res) => {
        // console.log(res.data)
        // if ($('#chart_transaction_statistics_4').length > 0) {
            Highcharts.chart('chart_transaction_statistics_4', {
                chart: {
                    zoomType: 'xy',
                    type: 'column',
                },
                title: {
                    text: 'Average Monthly Weather Data for Tokyo',
                    align: 'left',
                    style: { "display": "none" }
                },
                xAxis: [{
                    categories: res.data.date,
                    crosshair: true,
                    lineWidth: 0,
                    visible: true,
                }],
                yAxis: {
                    allowDecimals: true,
                    // min: 0,
                    title: {
                        text: 'Total fruit consumption',
                        style: { "display": "none" }
                    }
                },
                tooltip: {
                    shared: true
                },
                legend: {
                    enabled: false,
                },
                colors: ['#ffc000'],
                series: [{
                    name: 'Đầu tư',
                    data: res.data.value,
                    dataLabels: {
                        enabled: true
                    }
                }],
            });
        // }
    });
}

function load_chart_transaction_statistics_5(){
    var data = new FormData();
    _doAjaxNod('POST', data, 'chart_transaction_statistics', 'chart', 'load_chart5', true, (res) => {
        // console.log(res.data)
        // if ($('#chart_transaction_statistics_5').length > 0) {
            Highcharts.chart('chart_transaction_statistics_5', {
                chart: {
                    zoomType: 'xy',
                    type: 'column',
                },
                title: {
                    text: 'Average Monthly Weather Data for Tokyo',
                    align: 'left',
                    style: { "display": "none" }
                },
                xAxis: [{
                    categories: res.data.date,
                    crosshair: true,
                    lineWidth: 0,
                    visible: true,
                }],
                yAxis: {
                    allowDecimals: true,
                    // min: 0,
                    title: {
                        text: 'Total fruit consumption',
                        style: { "display": "none" }
                    }
                },
                tooltip: {
                    shared: true
                },
                legend: {
                    enabled: false,
                },
                colors: ['#ffc000'],
                series: [{
                    name: 'Đầu tư',
                    data: res.data.value,
                    dataLabels: {
                        enabled: true
                    }
                }],
            });
        // }
    });
}