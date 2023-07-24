// Chart bộ lọc khuyến nghị
var thisPage = {};

$(function () {
    thisPage.load_chart();
})

thisPage.load_chart = () => {
    var data = new FormData();
    _doAjaxNodCustom('POST', data, 'chart_recommended', 'chart', 'load_chart', true, (res) => {
        render_chart(res.data);
    });
};

function render_chart(_l) {
    
    Highcharts.chart('chart_recommended', {
        chart: {
            type: 'packedbubble',
            //height: '100%'
        },
        title: {
            text: 'Bộ lọc khuyến nghị'
        },
        tooltip: {
            useHTML: true,
            pointFormat: '{point.industry}'
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            packedbubble: {
                minSize: '30%',
                maxSize: '120%',
                //zMin: 0,
                //zMax: 1000,
                layoutAlgorithm: {
                    splitSeries: false,
                    gravitationalConstant: 0.02
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}',
                    filter: {
                        property: 'y',
                        operator: '>',
                        value: 0
                    },
                    style: {
                        color: 'black',
                        textOutline: 'none',
                        fontWeight: 'normal'
                    }
                }
            }
        },
        series: _l
        // series: [{
        //     name: 'Europe',
        //     data: [{
        //         name: 'HAH',
        //         value: 760.1,
        //         color: '#eeee'
        //     }]
        // }]
    });
} 