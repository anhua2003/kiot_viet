// if ($('#chart_thitruong_1').length > 0) {
//     am5.ready(function() {
//         var root = am5.Root.new("chart_thitruong_1");
//         var data = [{
//                 date: 1167609600000,
//                 value: 0.7537
//             },
//             {
//                 date: 1167696000000,
//                 value: 0.7537
//             },
//             {
//                 date: 1167782400000,
//                 value: 0.7559
//             },
//             {
//                 date: 1167868800000,
//                 value: 0.7631
//             },
//             {
//                 date: 1167955200000,
//                 value: 0.7644
//             },
//             {
//                 date: 1168214400000,
//                 value: 0.769
//             },
//             {
//                 date: 1168300800000,
//                 value: 0.7683
//             },
//             {
//                 date: 1168387200000,
//                 value: 0.77
//             },
//             {
//                 date: 1168473600000,
//                 value: 0.7703
//             },
//             {
//                 date: 1168560000000,
//                 value: 0.7757
//             },
//             {
//                 date: 1168819200000,
//                 value: 0.7728
//             },
//             {
//                 date: 1168905600000,
//                 value: 0.7721
//             },
//             {
//                 date: 1168992000000,
//                 value: 0.7748
//             },
//             {
//                 date: 1169078400000,
//                 value: 0.774
//             },
//             {
//                 date: 1169164800000,
//                 value: 0.7718
//             },
//             {
//                 date: 1169424000000,
//                 value: 0.7731
//             },
//             {
//                 date: 1169510400000,
//                 value: 0.767
//             },
//             {
//                 date: 1169596800000,
//                 value: 0.769
//             },
//             {
//                 date: 1169683200000,
//                 value: 0.7706
//             },
//             {
//                 date: 1169769600000,
//                 value: 0.7752
//             },
//             {
//                 date: 1170028800000,
//                 value: 0.774
//             },
//             {
//                 date: 1170115200000,
//                 value: 0.771
//             },
//             {
//                 date: 1170201600000,
//                 value: 0.7721
//             },
//             {
//                 date: 1170288000000,
//                 value: 0.7681
//             },
//             {
//                 date: 1170374400000,
//                 value: 0.7681
//             },
//             {
//                 date: 1170633600000,
//                 value: 0.7738
//             },
//             {
//                 date: 1170720000000,
//                 value: 0.772
//             },
//             {
//                 date: 1170806400000,
//                 value: 0.7701
//             },
//             {
//                 date: 1170892800000,
//                 value: 0.7699
//             },
//             {
//                 date: 1170979200000,
//                 value: 0.7689
//             },
//             {
//                 date: 1171238400000,
//                 value: 0.7719
//             },
//             {
//                 date: 1171324800000,
//                 value: 0.768
//             },
//             {
//                 date: 1171411200000,
//                 value: 0.7645
//             },
//             {
//                 date: 1171497600000,
//                 value: 0.7613
//             },
//             {
//                 date: 1171584000000,
//                 value: 0.7624
//             },
//             {
//                 date: 1171843200000,
//                 value: 0.7616
//             },
//             {
//                 date: 1171929600000,
//                 value: 0.7608
//             },
//             {
//                 date: 1172016000000,
//                 value: 0.7608
//             },
//             {
//                 date: 1172102400000,
//                 value: 0.7631
//             },
//             {
//                 date: 1172188800000,
//                 value: 0.7615
//             },
//             {
//                 date: 1172448000000,
//                 value: 0.76
//             },
//             {
//                 date: 1172534400000,
//                 value: 0.756
//             },
//             {
//                 date: 1172620800000,
//                 value: 0.757
//             },
//             {
//                 date: 1172707200000,
//                 value: 0.7562
//             },
//             {
//                 date: 1172793600000,
//                 value: 0.7598
//             },
//             {
//                 date: 1173052800000,
//                 value: 0.7645
//             },
//             {
//                 date: 1173139200000,
//                 value: 0.7635
//             },
//             {
//                 date: 1173225600000,
//                 value: 0.7614
//             },
//             {
//                 date: 1173312000000,
//                 value: 0.7604
//             },
//         ]

//         // Set themes
//         // https://www.amcharts.com/docs/v5/concepts/themes/
//         root.setThemes([
//             am5themes_Animated.new(root)
//         ]);


//         // Create chart
//         // https://www.amcharts.com/docs/v5/charts/xy-chart/
//         var chart = root.container.children.push(am5xy.XYChart.new(root, {
//             panX: true,
//             panY: true,
//             wheelX: "panX",
//             wheelY: "zoomX",
//             pinchZoomX: true
//         }));

//         // Add cursor
//         // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
//         var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
//             behavior: "none"
//         }));
//         cursor.lineY.set("visible", true);

//         // Create axes
//         // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
//         var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
//             maxDeviation: 0.5,
//             baseInterval: {
//                 timeUnit: "day",
//                 count: 1
//             },
//             renderer: am5xy.AxisRendererX.new(root, {
//                 // pan:"zoom"
//                 inside: true
//             }),
//         }));

//         var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
//             maxDeviation: 1,
//             renderer: am5xy.AxisRendererY.new(root, {
//                 // pan:"zoom",
//                 inside: true,
//                 opposite: true
//             })
//         }));


//         // Add series
//         // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
//         let tooltip = am5.Tooltip.new(root, {
//             getFillFromSprite: false,
//             labelText: "{valueX.formatDate()}\nLast: [bold]{valueY}"
//         });

//         tooltip.get("background").setAll({
//             // fill: am5.color(0xffffff),
//             // fillOpacity: 1,
//         });
//         var series = chart.series.push(am5xy.SmoothedXLineSeries.new(root, {
//             //   name: "Series",
//             xAxis: xAxis,
//             yAxis: yAxis,
//             valueYField: "value",
//             valueXField: "date",
//         }));
//         series.set("tooltip", tooltip);
//         series.fills.template.setAll({
//             visible: true,
//             fillOpacity: 0.2
//         });

//         series.bullets.push(function() {
//             return am5.Bullet.new(root, {
//                 locationY: 0,
//                 sprite: am5.Circle.new(root, {
//                     radius: 3,
//                     stroke: root.interfaceColors.get("background"),
//                     strokeWidth: 0,
//                     fill: series.get("fill")
//                 })
//             });
//         });

//         series.data.setAll(data);

//         // Make stuff animate on load
//         // https://www.amcharts.com/docs/v5/concepts/animations/
//         series.appear(1000);
//         chart.appear(1000, 100);

//     }); // end am5.ready()
// }

$(function(){
    function ac_add_to_head(el){
        var head = document.getElementsByTagName('head')[0];
            head.insertBefore(el,head.firstChild);

    }
    function ac_add_link(url){
        var el = document.createElement('link');
        el.rel='stylesheet';el.type='text/css';el.media='all';el.href=url;
        ac_add_to_head(el);
    }
    function ac_add_style(css){
        var ac_style = document.createElement('style');
        if (ac_style.styleSheet) ac_style.styleSheet.cssText = css;
        else ac_style.appendChild(document.createTextNode(css));
        ac_add_to_head(ac_style);
    }
    }); 
    anychart.onDocumentReady(function () {
        // create data for the second series

        var data_2 = [
            {x: 94.89, value: 105.85},
            {x: 97.2, value: 105.95},
            {x: 99.53, value: 104.77},
            {x: 102.14, value: 108.06},
            {x: 104.73, value: 106.8},
        ];

        var data_3 = [
            {x: 106.49, value: 97.16},
            {x: 106.38, value: 98.35},
            {x: 106.88, value: 101.26},
            {x: 107.4, value: 101.35},
            {x: 107.25, value: 98.14},
        ];
    
        // create a chart
    var chart = anychart.quadrant();
    chart.quarters(
        {
            leftTop: {
                fill: "#e2ffd0",
            },
            rightTop: {
                fill: "#f1cffc",
            },
            leftBottom: {
                fill: "#b9d9f5",
            },
            rightBottom: {
                fill: "#f8e6ae",
            },
        });

    var labelLeftTop = chart.quarters().leftTop().label(0);
    labelLeftTop.text("Tích Luỹ");
    labelLeftTop.fontColor("#000000");
    labelLeftTop.fontSize(12);
    labelLeftTop.position("leftTop");
    labelLeftTop.offsetX(35);
    labelLeftTop.offsetY(15);

    var labelRightTop = chart.quarters().rightTop().label(0);
    labelRightTop.text("Tăng Giá");
    labelRightTop.fontColor("#000000");
    labelRightTop.fontSize(12);
    labelRightTop.position("rightTop");
    labelRightTop.offsetX(-35);
    labelRightTop.offsetY(15);


    var labelLeftBottom = chart.quarters().leftBottom().label(0);
    labelLeftBottom.text("Giảm Giá");
    labelLeftBottom.fontColor("#000000");
    labelLeftBottom.fontSize(12);
    labelLeftBottom.position("leftBottom");
    labelLeftBottom.offsetX(35);
    labelLeftBottom.offsetY(-15);


    var labelRightBottom = chart.quarters().rightBottom().label(0);
    labelRightBottom.text("Suy Yếu");
    labelRightBottom.fontColor("#000000");
    labelRightBottom.fontSize(12);
    labelRightBottom.position("rightBottom");
    labelRightBottom.offsetX(-35);
    labelRightBottom.offsetY(-15);

    // tạo dấu cộng ở giữa
    chart.crossing().stroke("gray", 0, "5 3", "round");
    // tạo các nét dọc ngang dạng grid background
    // chart.xMinorGrid().stroke({color: "#85adad", thickness: 0.1, dash: 2});
    // chart.yMinorGrid().stroke({color: "#85adad", thickness: 0.1, dash: 2});
    // background của chart
    chart.background().fill("#ffffff");
    //hiển thị cột X và cột Y
    // chart.xAxis(0, {ticks: false, labels: true, });
    // chart.yAxis(0, {ticks: true, labels: true});
    chart.xAxis(0, {ticks: false, labels: false, stroke:"0  #000000"});
    chart.yAxis(0, {ticks: false, labels: false, stroke:"0 #000000"});
    chart.xAxis(1, {ticks: false, labels: false, stroke:"0  #000000"});
    chart.yAxis(1, {ticks: false, labels: false, stroke:"0 #000000"});

    chart.yScale().maximum(116);
    chart.xScale().maximum(112);
    chart.yScale().minimum(84);
    chart.xScale().minimum(88);

        // chart.yScale().maximum(150);
        // chart.xScale().maximum(120);
    
    // chart.yScale(anychart.scales.log());
    
    


    //tạo marker là dấu chấm
    // chart.marker(data_2);
    // create the second series (line) and set the data
    chart.spline().data(data_2).labels(false).markers(false).tooltip(false).stroke('1 #2BD784').hovered({ stroke: '1 #2BD784' }).selected({ stroke: '1 #2BD784' });
    chart.marker().data(data_2).zIndex(99).fill('#2BD784').type("circle").stroke('0.5 #3A3B3C').size(4).selectionMode('none');

    chart.spline().data(data_3).labels(false).markers(false).tooltip(false).stroke('1 #FFD200').hovered({ stroke: '1 #FFD200' }).selected({ stroke: '1 #2BD784' });
    chart.marker().data(data_3).zIndex(99).fill('#FFD200').type("circle").stroke('0.5 #3A3B3C').size(4).selectionMode('none');
    // chart.line(data_2);
    //   // configure the visual settings of the second series
    // series2.normal().stroke("#00cc99", 1);
    
    

    // configure the visual settings of the first series


    
    // var series3 = chart.line(data_3);

    //   // configure the visual settings of the second series
    // series3.normal().stroke("#00cc99", 1);


        // set the chart title
    // chart.title("Quadrant Chart: Appearance");

        // set the container id
    chart.container("chart_home_2");

        // initiate drawing the chart
    chart.draw();
});


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
if ($('#chart_home_1').length > 0) {
    Highcharts.chart('chart_home_1', {
        chart: {
            type: 'packedbubble',
            //height: '100%'
        },
        title: {
            text: 'Biểu đồ chứng khoáng 3',
            style: { "display": "none" }
        },
        tooltip: {
            useHTML: true,
            pointFormat: '<b>{point.name}:</b> {point.value}'
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            packedbubble: {
                minSize: '40%',
                maxSize: '140%',
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
        // colors: ['#3869bd', '#eb7a37', '#a5a5a5', '#fdbd27', '#5a99d2'],
        series: [{
            name: 'Europe',
            data: [{
                name: 'HAH',
                value: 760.1,
                color: '#5CADC8',
            }]
        }, {
            name: 'Africa',
            data: [{
                name: "TTF",
                value: 5.2,
                color: '#f00000',
            }]
        }, {
            name: 'Oceania',
            data: [{
                name: "ANV",
                value: 90.4,
                color: '#5CADC8',
            }]
        }, {
            name: 'North America',
            data: [{
                name: "PSH",
                value: 7.6,
                color: '#5CADC8',
            }]
        }, {
            name: 'South America',
            data: [{
                name: "FRT",
                value: 7.2,
                color: '#5CADC8',
            }]
        }, {
            name: 'Asia',
            data: [{
                name: "ABN",
                value: 7.5,
                color: '#5CADC8',
            }]
        }, {
            name: 'Asia',
            data: [{
                name: "BNB",
                value: 7.5,
                color: '#5CADC8',
            }]
        }, {
            name: 'Asia1',
            data: [{
                name: "AKC",
                value: 30.5,
                color: '#5CADC8',
            }]
        }, {
            name: 'Asia2',
            data: [{
                name: "ALD",
                value: 190.5,
                color: '#5CADC8',
            }]
        }, {
            name: 'Asia3',
            data: [{
                name: "DDF",
                value: 190.5,
                color: '#5CADC8',
            }]
        }, {
            name: 'Asia4',
            data: [{
                name: "ERF",
                value: 590.5,
                color: '#5CADC8',
            }]
        }],
    });
}