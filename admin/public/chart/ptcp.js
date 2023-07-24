if ($('#chart_ptcp_1').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_ptcp_1");

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
if ($('#chart_ptcp_9').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_ptcp_9");

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(
            am5xy.XYChart.new(root, {
                focusable: true,
                panX: true,
                panY: true,
                wheelX: "panX",
                wheelY: "zoomX"
            })
        );

        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, {
            minGridDistance: 30
        });
        xRenderer.labels.template.setAll({
            rotation: -90,
            centerY: am5.p50,
            centerX: 0,
            paddingRight: 15,
            visible: false
        });
        // xRenderer.grid.template.set("visible", false);

        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            // maxDeviation: 0.3,
            // categoryField: "country",
            renderer: xRenderer,
        }));
        var xAxis = chart.xAxes.push(
            am5xy.DateAxis.new(root, {
                baseInterval: { timeUnit: "day", count: 1 },
                renderer: am5xy.AxisRendererX.new(root, {

                }),
                tooltip: am5.Tooltip.new(root, {}),
            })
        );

        var yAxis = chart.yAxes.push(
            am5xy.ValueAxis.new(root, {
                renderer: am5xy.AxisRendererY.new(root, {})
            })
        );

        var color = root.interfaceColors.get("background");

        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(
            am5xy.CandlestickSeries.new(root, {
                fill: color,
                stroke: color,
                name: "MDXI",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "close",
                openValueYField: "open",
                lowValueYField: "low",
                highValueYField: "high",
                valueXField: "date",
                tooltip: am5.Tooltip.new(root, {
                    pointerOrientation: "horizontal",
                    labelText: "open: {openValueY}\nlow: {lowValueY}\nhigh: {highValueY}\nclose: {valueY},\nmediana: {mediana}"
                })
            })
        );

        // mediana series
        var medianaSeries = chart.series.push(
            am5xy.StepLineSeries.new(root, {
                stroke: root.interfaceColors.get("background"),
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "mediana",
                valueXField: "date",
                noRisers: true
            })
        );

        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
            xAxis: xAxis
        }));
        cursor.lineY.set("visible", false);

        var data = [{
                date: "2019-08-01",
                open: 132.3,
                high: 136.96,
                low: 131.15,
                close: 136.49
            },
            {
                date: "2019-08-02",
                open: 135.26,
                high: 135.95,
                low: 131.5,
                close: 131.85
            },
            {
                date: "2019-08-03",
                open: 129.9,
                high: 133.27,
                low: 128.3,
                close: 132.25
            },
            {
                date: "2019-08-04",
                open: 132.94,
                high: 136.24,
                low: 132.63,
                close: 135.03
            },
            {
                date: "2019-08-05",
                open: 136.76,
                high: 137.86,
                low: 132.0,
                close: 134.01
            },
            {
                date: "2019-08-06",
                open: 131.11,
                high: 133.0,
                low: 125.09,
                close: 126.39
            },
            {
                date: "2019-08-07",
                open: 130.11,
                high: 133.0,
                low: 125.09,
                close: 127.39
            },
            {
                date: "2019-08-08",
                open: 125.11,
                high: 126.0,
                low: 121.09,
                close: 122.39
            },
            {
                date: "2019-08-09",
                open: 131.11,
                high: 133.0,
                low: 122.09,
                close: 124.39
            }
        ];

        addMediana();

        function addMediana() {
            for (var i = 0; i < data.length; i++) {
                var dataItem = data[i];
                dataItem.mediana =
                    Number(dataItem.low) + (Number(dataItem.high) - Number(dataItem.low)) / 2;
            }
        }

        series.data.processor = am5.DataProcessor.new(root, {
            dateFields: ["date"],
            dateFormat: "yyyy-MM-dd"
        });

        series.data.setAll(data);
        medianaSeries.data.setAll(data);

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000, 100);
        medianaSeries.appear(1000, 100);
        chart.appear(1000, 100);

    }); // end am5.ready()
}
if ($('#chart_ptcp_7').length > 0) {
    Highcharts.chart('chart_ptcp_7', {
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
if ($('#chart_ptcp_2').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_ptcp_2");

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
// am5.ready(function() {

//     // Create root element
//     // https://www.amcharts.com/docs/v5/getting-started/#Root_element
//     var root = am5.Root.new("chart_ptcp_3");


//     // Set themes
//     // https://www.amcharts.com/docs/v5/concepts/themes/
//     root.setThemes([
//         am5themes_Animated.new(root)
//     ]);


//     // Create chart
//     // https://www.amcharts.com/docs/v5/charts/radar-chart/
//     var chart = root.container.children.push(am5radar.RadarChart.new(root, {
//         panX: false,
//         panY: false,
//         wheelX: "panX",
//         wheelY: "zoomX"
//     }));

//     // Add cursor
//     // https://www.amcharts.com/docs/v5/charts/radar-chart/#Cursor
//     var cursor = chart.set("cursor", am5radar.RadarCursor.new(root, {
//         behavior: "zoomX"
//     }));

//     cursor.lineY.set("visible", false);


//     // Create axes and their renderers
//     // https://www.amcharts.com/docs/v5/charts/radar-chart/#Adding_axes
//     var xRenderer = am5radar.AxisRendererCircular.new(root, {});
//     xRenderer.labels.template.setAll({
//         radius: 8,
//         fontSize: 11,
//         lineHeight: 1.5
//     });

//     var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
//         maxDeviation: 0,
//         categoryField: "country",
//         renderer: xRenderer,
//         tooltip: am5.Tooltip.new(root, {})
//     }));

//     var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
//         visible: false,
//         renderer: am5radar.AxisRendererRadial.new(root, {})
//     }));


//     // Create series
//     // https://www.amcharts.com/docs/v5/charts/radar-chart/#Adding_series
//     var series = chart.series.push(am5radar.RadarLineSeries.new(root, {
//         name: "Series",
//         xAxis: xAxis,
//         yAxis: yAxis,
//         valueYField: "litres",
//         categoryXField: "country",
//         fill: am5.color(0x92D050),
//         stroke: am5.color(0x92D050),
//         tooltip: am5.Tooltip.new(root, {
//             labelText: "{valueY}"
//         })
//     }));

//     series.strokes.template.setAll({
//         strokeWidth: 1,
//     });
//     series.fills.template.setAll({
//         stroke: am5.color(0x92D050),
//         fillOpacity: 0.3,
//         visible: true
//     });

//     series.bullets.push(function() {
//         return am5.Bullet.new(root, {
//             sprite: am5.Circle.new(root, {
//                 radius: 3,
//                 fill: series.get("fill"),
//                 strokeWidth: 1,
//                 // stroke: root.interfaceColors.get("background")
//             })
//         });
//     });


//     // Set data
//     // https://www.amcharts.com/docs/v5/charts/radar-chart/#Setting_data
//     var data = [{
//         "country": "Working\nCapital",
//         "litres": 501
//     }, {
//         "country": "Ratio on\nDebt",
//         "litres": 301
//     }, {
//         "country": "Operating\nActivities",
//         "litres": 266
//     }, {
//         "country": "Return on\nInvestment",
//         "litres": 165
//     }, {
//         "country": "Market\nValuation",
//         "litres": 139
//     }];
//     series.data.setAll(data);
//     xAxis.data.setAll(data);


//     // Animate chart and series in
//     // https://www.amcharts.com/docs/v5/concepts/animations/#Initial_animation
//     series.appear(1000);
//     chart.appear(1000, 100);

// }); // end am5.ready()



if ($('#chart_ptcp_3').length > 0) {
    var data1 = [33000, 19000, 30000, 25000, 17000];
    Highcharts.chart('chart_ptcp_3', {

        chart: {
            polar: true,
            type: "area",
        },

        accessibility: {
            description: 'a',
            enabled: false,
        },

        title: {
            text: 'Budget vs spending',
            x: 0,
            style: { "display": "none" }
        },

        // pane: {
        //     size: '80%'
        // },

        xAxis: {
            categories: ['Working Capital', 'Ratio on Debt', 'Operating Activities', 'Return on Investment',
                'Market Valuation'
            ],
            tickmarkPlacement: 'on',
            lineWidth: 0,
            title: {
                enabled: false,
            },
        },

        yAxis: {
            gridLineInterpolation: 'polygon',
            lineWidth: 1,
            min: 0,
            gridLineWidth: 1,
            // visible: false,
            labels: {
                enabled: false,
            }
        },

        tooltip: {
            shared: false,
            pointFormat: '<span style="color:{series.color}"><b>{point.y:,.0f}</b>'
        },

        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            enabled: false,
        },
        // plotOptions: {
        //     series: {
        //         dataLabels: {
        //             backgroundColor: "#f00000",
        //         }
        //     }
        // },
        series: [{
            data: data1,
            pointPlacement: 'on',
            lineWidth: 1,
            color: "#92D050",
            fillOpacity: 0.3,
            marker: {
                radius: 3,
            },
        }, ],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        align: 'center',
                        verticalAlign: 'bottom',
                        layout: 'horizontal'
                    },
                    pane: {
                        size: '70%'
                    }
                }
            }]
        }

    });
}
if ($('#chart_ptcp_4').length > 0) {
    Highcharts.chart('chart_ptcp_4', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart',
            style: { "display": "none" }

        },
        xAxis: {
            categories: ['FE', 'FB', 'EPS', 'Grapes', 'Bananas', "ROE"]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total fruit consumption',
                enabled: false,
            },
            // stackLabels: {
            //     enabled: true,
            //     style: {
            //         fontWeight: 'bold',
            //         // color: ( // theme
            //         //     Highcharts.defaultOptions.title.style &&
            //         //     Highcharts.defaultOptions.title.style.color
            //         // ) || 'red'
            //     }
            // },
            visible: false
        },
        legend: {
            align: 'right',
            x: 10,
            verticalAlign: 'top',
            y: -15,
            floating: true,
            // backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
            // borderColor: '#CCC',
            // borderWidth: 1,
            // shadow: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        colors: ['#ffc000', '#92D050'],
        series: [{
            name: 'Sector',
            data: [5, 3, 4, 7, 2, 5]
        }, {
            name: 'Stock',
            data: [2, 2, 3, 2, 1, 1]
        }]
    });
}
if ($('#chart_ptcp_5').length > 0) {
    Highcharts.chart('chart_ptcp_5', {
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
                format: '{value}',
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
                format: '{value}',
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
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 80,
            verticalAlign: 'top',
            y: 55,
            floating: true,
            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || // theme
                'rgba(255,255,255,0.25)'
        },
        colors: ['#92d050', '#813E99', '#ffc000'],
        series: [{
            name: 'Gross Profit',
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
            name: 'Net Profit',
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
            name: 'Gross Profit Margin',
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
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom',
                        x: 0,
                        y: 0
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
if ($('#chart_ptcp_6').length > 0) {
    Highcharts.chart('chart_ptcp_6', {
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
                text: 'Gross Profit Margin',
                style: {
                    color: Highcharts.getOptions().colors[2],
                    "display": "none"
                }
            },
            opposite: true

        }, { // Secondary yAxis
            gridLineWidth: 0,
            title: {
                text: 'Gross Profit',
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
                text: 'Sea-Level Pressure1',
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
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 80,
            verticalAlign: 'top',
            y: 55,
            floating: true,
            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || // theme
                'rgba(255,255,255,0.25)'
        },
        colors: ['#92d050', '#ffc000', '#813E99'],
        series: [{
            name: 'Net Profit',
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
            name: 'Gross Profit Margin',
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
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom',
                        x: 0,
                        y: 0
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