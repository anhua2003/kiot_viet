if ($('#chart_ptcb_ct_1').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_ptcb_ct_1");

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
            text: "BÁN\nMẠNH",
            forceHidden: false,
            fontSize: "0.7em",
            fontWeight: "600",
            lineHeight: 1.2,
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
        yesDataItem1.get("label").setAll({ text: "BÁN", forceHidden: false, fontSize: "0.7em", fontWeight: "600" });
        yesDataItem1.get("axisFill").setAll({
            visible: true,
            fillOpacity: 1,
            fill: "#f4959d",
        });

        var yesDataItem2 = xAxis.makeDataItem({});
        yesDataItem2.set("value", 4);
        yesDataItem2.set("endValue", 6);
        xAxis.createAxisRange(yesDataItem2);
        yesDataItem2.get("label").setAll({ text: "TRUNG\nLẬP", forceHidden: false, fontSize: "0.7em", fontWeight: "600", lineHeight: 1.2 });
        yesDataItem2.get("axisFill").setAll({
            visible: true,
            fillOpacity: 1,
            fill: "#d3d6db",
        });

        var yesDataItem3 = xAxis.makeDataItem({});
        yesDataItem3.set("value", 6);
        yesDataItem3.set("endValue", 8);
        xAxis.createAxisRange(yesDataItem3);
        yesDataItem3.get("label").setAll({ text: "MUA", forceHidden: false, fontSize: "0.7em", fontWeight: "600", });
        yesDataItem3.get("axisFill").setAll({
            visible: true,
            fillOpacity: 1,
            fill: "#569ac7",
        });

        var yesDataItem4 = xAxis.makeDataItem({});
        yesDataItem4.set("value", 8);
        yesDataItem4.set("endValue", 10);
        xAxis.createAxisRange(yesDataItem4);
        yesDataItem4.get("label").setAll({ text: "MUA\nMẠNH", forceHidden: false, fontSize: "0.7em", fontWeight: "600", lineHeight: 1.2 });
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
                pinRadius: am5.percent(7),
                bottomWidth: 7,
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
                value = 7;
            }
            axisDataItem.animate({
                key: "value",
                to: value,
                duration: 800,
                easing: am5.ease.out(am5.ease.cubic)
            });
        }, 1000);

        // Make stuff animate on load
        chart.appear(1000, 100);

    }); // end am5.ready()
}
if ($('#chart_ptcb_ct_2').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_ptcb_ct_2");

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
            text: "BÁN\nMẠNH",
            forceHidden: false,
            fontSize: "0.7em",
            fontWeight: "600",
            lineHeight: 1.2,
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
        yesDataItem1.get("label").setAll({ text: "BÁN", forceHidden: false, fontSize: "0.7em", fontWeight: "600" });
        yesDataItem1.get("axisFill").setAll({
            visible: true,
            fillOpacity: 1,
            fill: "#f4959d",
        });

        var yesDataItem2 = xAxis.makeDataItem({});
        yesDataItem2.set("value", 4);
        yesDataItem2.set("endValue", 6);
        xAxis.createAxisRange(yesDataItem2);
        yesDataItem2.get("label").setAll({ text: "TRUNG\nLẬP", forceHidden: false, fontSize: "0.7em", fontWeight: "600", lineHeight: 1.2 });
        yesDataItem2.get("axisFill").setAll({
            visible: true,
            fillOpacity: 1,
            fill: "#d3d6db",
        });

        var yesDataItem3 = xAxis.makeDataItem({});
        yesDataItem3.set("value", 6);
        yesDataItem3.set("endValue", 8);
        xAxis.createAxisRange(yesDataItem3);
        yesDataItem3.get("label").setAll({ text: "MUA", forceHidden: false, fontSize: "0.7em", fontWeight: "600", });
        yesDataItem3.get("axisFill").setAll({
            visible: true,
            fillOpacity: 1,
            fill: "#569ac7",
        });

        var yesDataItem4 = xAxis.makeDataItem({});
        yesDataItem4.set("value", 8);
        yesDataItem4.set("endValue", 10);
        xAxis.createAxisRange(yesDataItem4);
        yesDataItem4.get("label").setAll({ text: "MUA\nMẠNH", forceHidden: false, fontSize: "0.7em", fontWeight: "600", lineHeight: 1.2 });
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
                pinRadius: am5.percent(7),
                bottomWidth: 7,
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
                value = 9;
            }
            axisDataItem.animate({
                key: "value",
                to: value,
                duration: 800,
                easing: am5.ease.out(am5.ease.cubic)
            });
        }, 1000);

        // Make stuff animate on load
        chart.appear(1000, 100);

    }); // end am5.ready()
}
if ($('#chart_ptcb_ct_3').length > 0) {
    Highcharts.chart('chart_ptcb_ct_3', {
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: 'Average Monthly Weather Data for Tokyo',
            align: 'left',
            style: { "display": "none" }
        },
        subtitle: {
            text: 'Source: WorldClimate.com',
            align: 'left',
            style: { "display": "none" }
        },
        xAxis: [{
            categories: ['Q1 2020', 'Q2 2020', 'Q3 2020', 'Q4 2020', 'Q1 2021', 'Q2 2021',
                'Q3 2021', 'Q4 2021'
            ],
            crosshair: true,
            lineWidth: 0,
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value}°C',
                style: {
                    color: Highcharts.getOptions().colors[2],
                    "display": "none"
                }
            },
            title: {
                text: 'Temperature',
                style: {
                    color: Highcharts.getOptions().colors[2],
                    "display": "none"
                }
            },
            opposite: false,
            lineWidth: 0,

        }, { // Secondary yAxis
            gridLineWidth: 0,
            title: {
                text: 'Rainfall',
                style: {
                    color: Highcharts.getOptions().colors[0],
                    "display": "none"
                }
            },
            labels: {
                format: '{value} mm',
                style: {
                    color: Highcharts.getOptions().colors[0],
                    "display": "none"
                }
            }

        }, { // Tertiary yAxis
            gridLineWidth: 0,
            title: {
                text: 'Sea-Level Pressure',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            labels: {
                format: '{value} mb',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        colors: ['#92d050', '#813E99', '#ffc000'],
        series: [{
            name: 'Lợi nhuận gộp',
            type: 'column',
            yAxis: 1,
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5],
            tooltip: {
                valueSuffix: ''
            },
            dataLabels: {
                enabled: true
            }

        }, {
            name: 'Lợ nhuận ròng',
            type: 'spline',
            yAxis: 2,
            data: [1016, 1016, 1015, 1015, 1012, 1009, 1009, 1010],
            marker: {
                // enabled: false
                radius: 3,
            },
            // dashStyle: 'shortdot',
            tooltip: {
                valueSuffix: ''
            },
            dataLabels: {
                enabled: true,
            }

        }, {
            name: 'Biên lợi nhuận gộp',
            type: 'spline',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5],
            marker: {
                // enabled: false
                radius: 3,
            },
            tooltip: {
                valueSuffix: ''
            },
            // dashStyle: 'shortdot',
            dataLabels: {
                // enabled: true
            }
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        floating: false,
                        align: 'left',
                        x: 0,
                        verticalAlign: 'top',
                        y: -15,
                        backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'rgba(255,255,255,0.25)'
                    },
                    yAxis: [{
                        labels: {
                            align: 'right',
                            x: 0,
                            y: -6
                        },
                        showLastLabel: false
                    }, {
                        labels: {
                            align: 'left',
                            x: 0,
                            y: -6
                        },
                        showLastLabel: false
                    }, {
                        visible: false
                    }]
                }
            }]
        }
    });
}
if ($('#chart_ptcb_ct_4').length > 0) {
    Highcharts.chart('chart_ptcb_ct_4', {
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: 'Average Monthly Weather Data for Tokyo',
            align: 'left',
            style: { "display": "none" }
        },
        subtitle: {
            text: 'Source: WorldClimate.com',
            align: 'left',
            style: { "display": "none" }
        },
        xAxis: [{
            categories: ['2018', '2019', '2020', '2021'],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value}°C',
                style: {
                    color: Highcharts.getOptions().colors[2],
                    "display": "none"
                }
            },
            title: {
                text: 'Temperature',
                style: {
                    color: Highcharts.getOptions().colors[2],
                    "display": "none"
                }
            },
            opposite: true

        }, { // Secondary yAxis
            gridLineWidth: 0,
            title: {
                text: 'Rainfall',
                style: {
                    color: Highcharts.getOptions().colors[0],
                    "display": "none"
                }
            },
            labels: {
                format: '{value} mm',
                style: {
                    color: Highcharts.getOptions().colors[0],
                    "display": "none"
                }
            }

        }, { // Tertiary yAxis
            gridLineWidth: 0,
            title: {
                text: 'Sea-Level Pressure',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            labels: {
                format: '{value} mb',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        colors: ['#92d050', '#ffc000', '#813E99'],
        series: [{
            name: 'Lợ nhuận ròng',
            type: 'column',
            yAxis: 1,
            data: [49.9, 71.5, 106.4, 129.2],
            tooltip: {
                valueSuffix: ' mm'
            },
            dataLabels: {
                enabled: true
            }

        }, {
            name: 'Biên lợi nhuận gộp',
            type: 'spline',
            yAxis: 2,
            data: [516, 616, 715, 615],
            marker: {
                // enabled: false
                radius: 3,
            },
            // dashStyle: 'shortdot',
            tooltip: {
                valueSuffix: ' mb'
            },
            dataLabels: {
                enabled: true,
            }
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        floating: false,
                        align: 'left',
                        x: 0,
                        verticalAlign: 'top',
                        y: -15,
                        backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'rgba(255,255,255,0.25)'
                    },
                    yAxis: [{
                        labels: {
                            align: 'right',
                            x: 0,
                            y: -6
                        },
                        showLastLabel: false
                    }, {
                        labels: {
                            align: 'left',
                            x: 0,
                            y: -6
                        },
                        showLastLabel: false
                    }, {
                        visible: false
                    }]
                }
            }]
        }
    });
}



var i1 = 0;
var $ppc1 = $('.chart_percent_1');
var j1 = $('.chart_percent_1').attr('data-per');

function pie_load1() {
    if (i1 <= j1) {
        var percent1 = i1,
        deg1 = 360 * percent1 / 100;
        if (percent1 > 50) {
            $ppc1.addClass('gt-50');
        }
        $('.chart_percent_1 .ppc-progress-fill').css('transform', 'rotate(' + deg1 + 'deg)');
        $('.chart_percent_1 .ppc-percents span').html(percent1+'%');
        i1++;
        var t1 = setTimeout(function() { pie_load1() }, 30)
    }
}
pie_load1();

var i2 = 0;
var $ppc2 = $('.chart_percent_2');
var j2 = $('.chart_percent_2').attr('data-per');

function pie_load2() {
    if (i2 <= j2) {
        var percent2 = i2,
        deg2 = 360 * percent2 / 100;
        if (percent2 > 50) {
            $ppc2.addClass('gt-50');
        }
        $('.chart_percent_2 .ppc-progress-fill').css('transform', 'rotate(' + deg2 + 'deg)');
        $('.chart_percent_2 .ppc-percents span').html(percent2+'%');
        i2++;
        var t2 = setTimeout(function() { pie_load2() }, 30)
    }
}
pie_load2();