if ($('#chart_thitruong_1').length > 0) {
    Highcharts.chart('chart_thitruong_1', {
        chart: {
            type: 'areaspline'
        },
        title: {
            text: 'Average fruit consumption during one week',
            style: { "display": "none" }
        },
        xAxis: {
            categories: [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12',
                '13',
                '14',
                '15',
                '16',
                '17',
                '18',
                '19',
                '20',
                '21',
                '22',
                '23',
                '24',
                '25',
                '26',
                '27',
                '28',
                '29',
                '30'
            ],
        },
        yAxis: {
            title: {
                text: 'Fruit units',
                enabled: false,
            },
            visible: false,
        },
        legend: {
            enabled: false
        },
        tooltip: {
            shared: true,
            valueSuffix: ' units'
        },
        credits: {
            enabled: false
        },
        colors: ['#f1cffc'],
        series: [{
            name: 'John',
            data: [3, 4, 3, 5, 4, 10, 12, 3, 4, 3, 5, 4, 10, 12, 3, 4, 3, 5, 4, 10, 12, 10, 12, 3, 4, 3, 5, 4, 10, 12],
            marker: {
                enabled: false
            },
        }]
    });
}
if ($('#chart_thitruong_2').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_thitruong_2");

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        // Create chart
        // https://www.amcharts.com/docs/v5/charts/radar-chart/
        var chart = root.container.children.push(am5radar.RadarChart.new(root, {
            panX: false,
            panY: false,
            startAngle: 180,
            endAngle: 360
        }));


        // Create axis and its renderer
        // https://www.amcharts.com/docs/v5/charts/radar-chart/gauge-charts/#Axes
        var axisRenderer = am5radar.AxisRendererCircular.new(root, {
            innerRadius: -6,
            strokeOpacity: 0
        });

        axisRenderer.labels.template.set("forceHidden", true);
        axisRenderer.grid.template.set("forceHidden", true);

        var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
            maxDeviation: 0,
            min: 0,
            max: 10,
            strictMinMax: true,
            renderer: axisRenderer
        }));


        // add yes and no labels
        var yesDataItem = xAxis.makeDataItem({});
        yesDataItem.set("value", 0);
        yesDataItem.set("endValue", 2);
        xAxis.createAxisRange(yesDataItem);
        yesDataItem.get("label").setAll({
            text: "STRONG\nSELL",
            forceHidden: false,
            fontSize: "0.7em",
            fontWeight: "600",
            lineHeight: 1.5,
            // transForm: rotate(20deg),
        });
        yesDataItem.get("axisFill").setAll({
            visible: true,
            fillOpacity: 1,
            fill: "#f6433f",
        });

        var yesDataItem1 = xAxis.makeDataItem({});
        yesDataItem1.set("value", 2);
        yesDataItem1.set("endValue", 4);
        xAxis.createAxisRange(yesDataItem1);
        yesDataItem1.get("label").setAll({ text: "SELL", forceHidden: false, fontSize: "0.7em", fontWeight: "600" });
        yesDataItem1.get("axisFill").setAll({
            visible: true,
            fillOpacity: 1,
            fill: "#f4959d",
        });

        var yesDataItem2 = xAxis.makeDataItem({});
        yesDataItem2.set("value", 4);
        yesDataItem2.set("endValue", 6);
        xAxis.createAxisRange(yesDataItem2);
        yesDataItem2.get("label").setAll({ text: "NEUTRAL", forceHidden: false, fontSize: "0.7em", fontWeight: "600" });
        yesDataItem2.get("axisFill").setAll({
            visible: true,
            fillOpacity: 1,
            fill: "#d3d6db",
        });

        var yesDataItem3 = xAxis.makeDataItem({});
        yesDataItem3.set("value", 6);
        yesDataItem3.set("endValue", 8);
        xAxis.createAxisRange(yesDataItem3);
        yesDataItem3.get("label").setAll({ text: "BUY", forceHidden: false, fontSize: "0.7em", fontWeight: "600", });
        yesDataItem3.get("axisFill").setAll({
            visible: true,
            fillOpacity: 1,
            fill: "#569ac7",
        });

        var yesDataItem4 = xAxis.makeDataItem({});
        yesDataItem4.set("value", 8);
        yesDataItem4.set("endValue", 10);
        xAxis.createAxisRange(yesDataItem4);
        yesDataItem4.get("label").setAll({ text: "STRONG\nBUY", forceHidden: false, fontSize: "0.7em", fontWeight: "600", lineHeight: 1.5 });
        yesDataItem4.get("axisFill").setAll({
            visible: true,
            fillOpacity: 1,
            // fill:root.interfaceColors.get("positive"),
            fill: "#1468ef"
        });

        // Add clock hand
        // https://www.amcharts.com/docs/v5/charts/radar-chart/gauge-charts/#Clock_hands
        var axisDataItem = xAxis.makeDataItem({});
        axisDataItem.set("value", 0);

        var bullet = axisDataItem.set("bullet", am5xy.AxisBullet.new(root, {
            sprite: am5radar.ClockHand.new(root, {
                radius: am5.percent(70),
                pinRadius: am5.percent(6),
                bottomWidth: 5,
            }),
        }));
        var label = chart.radarContainer.children.push(am5.Label.new(root, {
            fill: am5.color(0xffffff),
            centerX: am5.percent(50),
            textAlign: "center",
            centerY: am5.percent(50),
            fontSize: "3em"
        }));

        xAxis.createAxisRange(axisDataItem);

        axisDataItem.get("grid").set("visible", false);

        let value = 0;
        setTimeout(function() {
            if (value == 0) {
                value = 1;
            }
            axisDataItem.animate({
                key: "value",
                to: value,
                duration: 800,
                easing: am5.ease.out(am5.ease.cubic)
            });
        }, 1000);

        // $('.table_in tbody tr').click(function(){
        $('body').on('click', '.table_in tbody tr', function() {
            let value = parseInt($(this).attr('data-value'));
            $('.table_in tbody tr').removeClass('active');
            $(this).addClass('active');
            axisDataItem.animate({
                key: "value",
                to: value,
                duration: 800,
                easing: am5.ease.out(am5.ease.cubic)
            });
        });

        // Make stuff animate on load
        chart.appear(1000, 100);

    }); // end am5.ready()
}
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
if ($('#chart_thitruong_4').length > 0) {
    Highcharts.chart('chart_thitruong_4', {
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
            categories: ['Q1 2020', 'Q2 2020', 'Q3 2020', 'Q4 2020', 'Q1 2021', 'Q2 2021',
                'Q3 2021', 'Q4 2021'
            ],
            crosshair: true,
            lineWidth: 0,
            visible: false,
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
            data: [49, 71, 106, 129, 144, 176, -13, 148],
            dataLabels: {
                enabled: true
            }
        }],
    });
}