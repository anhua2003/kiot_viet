if ($('#chart_bctc_chart_1').length > 0) {
    Highcharts.chart('chart_bctc_chart_1', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart',
            style: { "display": "none" }
        },
        xAxis: {
            categories: ['Q1 2021', 'Q2 2021', 'Q3 2021', 'Q4 2021']
        },
        yAxis: {
            allowDecimals: true,
            // min: 0,
            title: {
                text: 'Total fruit consumption',
                style: { "display": "none" }
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color};">{series.name}</span>: <b>{point.y}</b><br/>',
            shared: true
        },
        plotOptions: {
            column: {
                // stacking: 'percent'
                stacking: 'normal'
            }
        },
        colors: ['#3869bd', '#eb7a37', '#a5a5a5', '#fdbd27', '#5a99d2'],
        legend: {
            // floating: true,
            itemStyle: { "fontWeight": "nomal" },
            margin: 10,
            itemMarginBottom: 2,
        },
        series: [{
            name: 'Các khoảng phải thu',
            data: [5000, 3000, 4000, 700]
        }, {
            name: 'Đầu tư ngắn hạn',
            data: [2000, 2000, 3000, 2000]
        }, {
            name: 'Tiền và tương đương tiền',
            data: [3000, 4000, 4000, 2000]
        }, {
            name: 'Hàng tồn kho',
            data: [3000, 4000, 4000, 2000]
        }, {
            name: 'Tài sản ngắn hạn khác',
            data: [12000, 15000, 20000, 10000]
        }]
    });
}
if ($('#chart_bctc_chart_2').length > 0) {
    Highcharts.chart('chart_bctc_chart_2', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart',
            style: { "display": "none" }
        },
        xAxis: {
            categories: ['Q1 2021', 'Q2 2021', 'Q3 2021', 'Q4 2021']
        },
        yAxis: {
            allowDecimals: true,
            // min: 0,
            title: {
                text: 'Total fruit consumption',
                style: { "display": "none" }
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color};">{series.name}</span>: <b>{point.y}</b><br/>',
            shared: true
        },
        plotOptions: {
            column: {
                // stacking: 'percent'
                stacking: 'normal'
            }
        },
        colors: ['#3869bd', '#eb7a37', '#a5a5a5'],
        legend: {
            // floating: true,
            itemStyle: { "fontWeight": "nomal" },
            margin: 10,
            itemMarginBottom: 2,
        },
        series: [{
            name: 'Nợ ngắn hạn',
            data: [5000, 3000, 4000, 700]
        }, {
            name: 'Nợ dài hạn',
            data: [2000, 2000, 3000, 2000]
        }, {
            name: 'Vốn chủ sở hữu',
            data: [3000, 4000, 4000, 2000]
        }]
    });
}
if ($('#chart_bctc_chart_3').length > 0) {
    Highcharts.chart('chart_bctc_chart_3', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart',
            style: { "display": "none" }
        },
        xAxis: {
            categories: ['Q1 2021', 'Q2 2021', 'Q3 2021', 'Q4 2021']
        },
        yAxis: {
            // min: 0,
            title: {
                text: 'Total fruit consumption',
                style: { "display": "none" }
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color};">{series.name}</span>: <b>{point.y}</b><br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'normal'
            }
        },
        colors: ['#3869bd', '#eb7a37', '#a5a5a5', '#fdbd27', '#5a99d2'],
        legend: {
            // floating: true,
            itemStyle: { "fontWeight": "nomal" },
            margin: 10,
            itemMarginBottom: 2,
        },
        series: [{
            name: 'Lợi nhuận gộp từ hoạt động kinh doanh',
            data: [5, 3, 4, 7]
        }, {
            name: 'Lời nhuận từ hoạt động tài chính',
            data: [-2, -2, -3, -2]
        }, {
            name: 'Lãi/lỗ trong cty liên doanh liên kết',
            data: [3, 4, 4, 2]
        }, {
            name: 'Lợi nhuận thuần từ hoạt động kinh doanh',
            data: [3, 4, 4, 2]
        }]
    });
}
if ($('#chart_bctc_chart_4').length > 0) {
    Highcharts.chart('chart_bctc_chart_4', {
        title: {
            text: 'Combination chart',
            style: { "display": "none" }
        },
        xAxis: {
            categories: ['Q1 2021', 'Q2 2021', 'Q3 2021', 'Q4 2021']
        },
        yAxis: {
            title: {
                style: { "display": "none" }
            }
        },
        plotOptions: {
            column: {
                // stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            },
            spline: {
                dataLabels: {
                    enabled: true
                },
            }
        },
        colors: ['#3869bd', '#fdbd27', '#eb7a37'],
        series: [{
            type: 'column',
            name: 'Doanh thu thuần',
            data: [6000, 7000, 9000, 13000]
        }, {
            type: 'column',
            name: 'Tổng lợi nhuận kế toán trước thuế',
            data: [700, 1500, 2000, 1000]
        }, {
            type: 'spline',
            name: 'Lợi nhuận gộp',
            data: [3000, 2607, 3000, 6033],
            marker: {
                lineWidth: 2,
            }
        }]
    });
}
if ($('#chart_bctc_chart_5').length > 0) {
    Highcharts.chart('chart_bctc_chart_5', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart',
            style: { "display": "none" }
        },
        xAxis: {
            categories: ['Q1 2021', 'Q2 2021', 'Q3 2021', 'Q4 2021']
        },
        yAxis: {
            // min: 0,
            title: {
                text: 'Total fruit consumption',
                style: { "display": "none" }
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color};">{series.name}</span>: <b>{point.y}</b><br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'normal'
            }
        },
        colors: ['#3869bd', '#eb7a37', '#a5a5a5', '#fdbd27', '#5a99d2'],
        legend: {
            // floating: true,
            itemStyle: { "fontWeight": "nomal" },
            margin: 10,
            itemMarginBottom: 2,
        },
        series: [{
            name: 'Lưu chuyển tiền thuần từ hoạt động tài chính',
            data: [5, 3, 4, 7]
        }, {
            name: 'Lưu chuyển tiền thuần từ hoạt động đầu tư',
            data: [-2, -2, -3, -2]
        }, {
            name: 'Lưu chuyển tiền thuần từ hoạt động kinh doanh',
            data: [3, 4, 4, 2]
        }]
    });
}
if ($('#chart_bctc_chart_6').length > 0) {
    Highcharts.chart('chart_bctc_chart_6', {
        title: {
            text: 'Combination chart',
            style: { "display": "none" }
        },
        xAxis: {
            categories: ['Q1 2021', 'Q2 2021', 'Q3 2021', 'Q4 2021']
        },
        yAxis: {
            title: {
                style: { "display": "none" }
            }
        },
        plotOptions: {
            column: {
                // stacking: 'normal',
                dataLabels: {
                    enabled: false
                }
            },
            spline: {
                dataLabels: {
                    enabled: true
                },
            }
        },
        legend:{
            enabled: false,
        },
        colors: ['#eb7a37'],
        series: [{
            type: 'spline',
            name: 'Lợi nhuận gộp',
            data: [3000, -2607, 3000, 6033],
            marker: {
                lineWidth: 2,
            }
        }]
    });
}