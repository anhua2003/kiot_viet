
// Highcharts.chart('chart-1', {
//     chart: {
//         type: 'packedbubble',
//         //height: '100%'
//     },
//     title: {
//         text: 'Biểu đồ chứng khoáng 3'
//     },
//     tooltip: {
//         useHTML: true,
//         pointFormat: '<b>{point.name}:</b> {point.value}m CO<sub>2</sub>'
//     },
//     legend: {
//         enabled: false
//     },
//     plotOptions: {
//         packedbubble: {
//             minSize: '30%',
//             maxSize: '120%',
//             //zMin: 0,
//             //zMax: 1000,
//             layoutAlgorithm: {
//                 splitSeries: false,
//                 gravitationalConstant: 0.02
//             },
//             dataLabels: {
//                 enabled: true,
//                 format: '{point.name}',
//                 filter: {
//                     property: 'y',
//                     operator: '>',
//                     value: 0
//                 },
//                 style: {
//                     color: 'black',
//                     textOutline: 'none',
//                     fontWeight: 'normal'
//                 }
//             }
//         }
//     },
//     series: [{
//         name: 'Europe',
//         data: [{
//             name: 'HAH',
//             value: 760.1,
//             color: '#f00000',
//         }]
//     }, {
//         name: 'Africa',
//         data: [{
//             name: "TTF",
//             value: 8.2
//         }]
//     }, {
//         name: 'Oceania',
//         data: [{
//             name: "ANV",
//             value: 90.4
//         }]
//     }, {
//         name: 'North America',
//         data: [{
//             name: "PSH",
//             value: 7.6
//         }]
//     }, {
//         name: 'South America',
//         data: [{
//             name: "FRT",
//             value: 7.2
//         }]
//     }, {
//         name: 'Asia',
//         data: [{
//             name: "ABN",
//             value: 7.5
//         }]
//     }, {
//         name: 'Asia',
//         data: [{
//             name: "BNB",
//             value: 7.5
//         }]
//     }, {
//         name: 'Asia1',
//         data: [{
//             name: "AKC",
//             value: 30.5
//         }]
//     }, {
//         name: 'Asia2',
//         data: [{
//             name: "ALD",
//             value: 190.5
//         }]
//     }, {
//         name: 'Asia3',
//         data: [{
//             name: "DDF",
//             value: 190.5
//         }]
//     }, {
//         name: 'Asia4',
//         data: [{
//             name: "ERF",
//             value: 590.5
//         }]
//     }]
// });


// var colors = Highcharts.getOptions().colors;

// Highcharts.chart('chart-2', {
//     chart: {
//         type: 'spline'
//     },

//     // legend: {
//     //     symbolWidth: 40
//     // },
//     legend: {
//         enabled: false
//     },

//     title: {
//         text: 'Biểu đồ chứng khoáng 4'
//     },

//     yAxis: {
//         title: {
//             text: 'Percentage usage'
//         },
//         accessibility: {
//             description: 'Percentage usage'
//         }
//     },

//     xAxis: {
//         title: {
//             text: 'Time'
//         },
//         accessibility: {
//             description: 'Time from December 2010 to September 2019'
//         },
//         categories: ['December 2010', 'May 2012', 'January 2014', 'July 2015', 'October 2017', 'September 2019']
//     },

//     tooltip: {
//         valueSuffix: '%'
//     },

//     plotOptions: {
//         series: {
//             point: {
//                 events: {
//                     click: function() {
//                         window.location.href = this.series.options.website;
//                     }
//                 }
//             },
//             cursor: 'pointer'
//         }
//     },

//     series: [{
//         name: 'NVDA',
//         data: [34.8, 43.0, 51.2, 41.4, 64.9, 72.4, 11.4],
//         color: colors[2],
//         accessibility: {
//             description: 'This is the most used screen reader in 2019'
//         }
//     }, {
//         name: 'JAWS',
//         data: [69.6, 63.7, 63.9, 43.7, 66.0, 61.7, 25.4],
//         dashStyle: 'ShortDashDot',
//         color: colors[0]
//     }, {
//         name: 'VoiceOver',
//         data: [20.2, 30.7, 36.8, 30.9, 39.6, 47.1, 45.4],
//         dashStyle: 'ShortDot',
//         color: colors[1]
//     }, {
//         name: 'Narrator',
//         data: [1.2, 3.4, 5.6, 9.3, 21.4, 30.3, 55.4],
//         dashStyle: 'Dash',
//         color: colors[9]
//     }, {
//         name: 'ZoomText/Fusion',
//         data: [6.1, 6.8, 5.3, 27.5, 6.0, 5.5, 75.4],
//         dashStyle: 'ShortDot',
//         color: colors[5]
//     }, {
//         name: 'Other',
//         data: [42.6, 51.5, 54.2, 45.8, 20.2, 15.4, 15.4],
//         dashStyle: 'ShortDash',
//         color: colors[3]
//     }],

//     responsive: {
//         rules: [{
//             condition: {
//                 maxWidth: 550
//             },
//             chartOptions: {
//                 chart: {
//                     spacingLeft: 3,
//                     spacingRight: 3
//                 },
//                 legend: {
//                     itemWidth: 150
//                 },
//                 xAxis: {
//                     categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7'],
//                     title: ''
//                 },
//                 yAxis: {
//                     visible: false
//                 }
//             }
//         }]
//     }
// });


// Highcharts.chart('chart-3', {
//     chart: {
//         type: 'pie',
//         options3d: {
//             enabled: true,
//             alpha: 45
//         }
//     },
//     title: {
//         text: 'Biểu đồ chứng khoáng 1',
//     },
//     plotOptions: {
//         pie: {
//             innerSize: 100,
//             depth: 45
//         }
//     },
//     series: [{
//         name: 'Delivered amount',
//         data: [
//             ['NAHS', 8],
//             ['DKFJ', 3],
//             ['EODO', 1],
//             ['PDPD', 6],
//             ['DNAD', 8],
//             ['WUQS', 4],
//             ['DJDU', 4],
//             ['CNSH', 1],
//             ['FHFY', 1]
//         ]
//     }]
// });

// Highcharts.chart('chart-4', {

//     chart: {
//         polar: true,
//         type: 'line'
//     },

//     title: {
//         text: 'Biểu đồ chứng khoáng 2',
//     },

//     pane: {
//         size: '80%'
//     },

//     xAxis: {
//         categories: ['ACAB', 'AKCH', 'DGHA', 'AUHS',
//             'EUDJ', 'FKSL'
//         ],
//         tickmarkPlacement: 'on',
//         lineWidth: 0
//     },

//     yAxis: {
//         gridLineInterpolation: 'polygon',
//         lineWidth: 0,
//         min: 0
//     },

//     tooltip: {
//         shared: true,
//         pointFormat: '<span style="color:{series.color}">{series.name}: <b>${point.y:,.0f}</b><br/>'
//     },

//     legend: {
//         align: 'right',
//         verticalAlign: 'middle',
//         layout: 'vertical',
//         enabled: false
//     },
//     series: [{
//         name: 'Allocated Budget',
//         data: [43000, 19000, 60000, 35000, 17000, 10000],
//         pointPlacement: 'on'
//     }, {
//         name: 'Actual Spending',
//         data: [50000, 39000, 42000, 31000, 26000, 14000],
//         pointPlacement: 'on'
//     }],

//     responsive: {
//         rules: [{
//             condition: {
//                 maxWidth: 500
//             },
//             chartOptions: {
//                 legend: {
//                     align: 'center',
//                     verticalAlign: 'bottom',
//                     layout: 'horizontal'
//                 },
//                 pane: {
//                     size: '70%'
//                 }
//             }
//         }]
//     }

// });





am5.ready(function() {

    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("chartdiv");
    
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
        max: 100,
        strictMinMax: true,
        renderer: axisRenderer
    }));
    
    
    // add yes and no labels
    var yesDataItem = xAxis.makeDataItem({
        
    });
    yesDataItem.set("value", 0);
    yesDataItem.set("endValue", 20);
    xAxis.createAxisRange(yesDataItem);
    yesDataItem.get("label").setAll({
        text: "STRONG\nSELL",
        forceHidden:false,
        fontSize:"0.7em",
        fontWeight: "600",
        lineHeight: 1.5,
        // transForm: rotate(20deg),
    });
    yesDataItem.get("axisFill").setAll({
        visible:true, fillOpacity:1,
        fill: "#f6433f",
    });

    var yesDataItem1 = xAxis.makeDataItem({
        
    });
    yesDataItem1.set("value", 20);
    yesDataItem1.set("endValue", 40);
    xAxis.createAxisRange(yesDataItem1);
    yesDataItem1.get("label").setAll({text: "SELL", forceHidden:false, fontSize:"0.7em", fontWeight: "600"});
    yesDataItem1.get("axisFill").setAll({
        visible:true, fillOpacity:1, 
        fill: "#f4959d",
    });

    var yesDataItem2 = xAxis.makeDataItem({
        
    });
    yesDataItem2.set("value", 40);
    yesDataItem2.set("endValue", 60);
    xAxis.createAxisRange(yesDataItem2);
    yesDataItem2.get("label").setAll({text: "NEUTRAL", forceHidden:false, fontSize:"0.7em", fontWeight: "600"});
    yesDataItem2.get("axisFill").setAll({
        visible:true, fillOpacity:1,
        fill: "#d3d6db",
    });

    var yesDataItem3 = xAxis.makeDataItem({
        
    });
    yesDataItem3.set("value", 60);
    yesDataItem3.set("endValue", 80);
    xAxis.createAxisRange(yesDataItem3);
    yesDataItem3.get("label").setAll({text: "BUY", forceHidden:false, fontSize:"0.7em", fontWeight: "600",});
    yesDataItem3.get("axisFill").setAll({
        visible:true, fillOpacity:1,
        fill: "#569ac7",
    });

    var yesDataItem4 = xAxis.makeDataItem({
        
    });
    yesDataItem4.set("value", 80);
    yesDataItem4.set("endValue", 100);
    xAxis.createAxisRange(yesDataItem4);
    yesDataItem4.get("label").setAll({text: "STRONG\nBUY", forceHidden:false, fontSize:"0.7em", fontWeight: "600",lineHeight: 1.5});
    yesDataItem4.get("axisFill").setAll({
        visible:true,
        fillOpacity:1,
        // fill:root.interfaceColors.get("positive"),
        fill: "#1468ef"
    });
    
    // Add clock hand
    // https://www.amcharts.com/docs/v5/charts/radar-chart/gauge-charts/#Clock_hands
    var axisDataItem = xAxis.makeDataItem({
        
    });
    axisDataItem.set("value", 0);
    
    var bullet = axisDataItem.set("bullet", am5xy.AxisBullet.new(root, {
        sprite: am5radar.ClockHand.new(root, {
            radius: am5.percent(70),
            pinRadius: am5.percent(8),
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
            value = 10;
        }
        axisDataItem.animate({
            key: "value",
            to: value,
            duration: 800,
            easing: am5.ease.out(am5.ease.cubic)
        });
    }, 1000);
    
    // $('.table_in tbody tr').click(function(){
    $('body').on('click', '.table_in tbody tr', function(){
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
am5.ready(function() {
    var root = am5.Root.new("chartdiv1");
    var data = [
        {
            date: 1167609600000,
            value: 0.7537
        },
        {
            date: 1167696000000,
            value: 0.7537
        },
        {
            date: 1167782400000,
            value: 0.7559
        },
        {
            date: 1167868800000,
            value: 0.7631
        },
        {
            date: 1167955200000,
            value: 0.7644
        },
        {
            date: 1168214400000,
            value: 0.769
        },
        {
            date: 1168300800000,
            value: 0.7683
        },
        {
            date: 1168387200000,
            value: 0.77
        },
        {
            date: 1168473600000,
            value: 0.7703
        },
        {
            date: 1168560000000,
            value: 0.7757
        },
        {
            date: 1168819200000,
            value: 0.7728
        },
        {
            date: 1168905600000,
            value: 0.7721
        },
        {
            date: 1168992000000,
            value: 0.7748
        },
        {
            date: 1169078400000,
            value: 0.774
        },
        {
            date: 1169164800000,
            value: 0.7718
        },
        {
            date: 1169424000000,
            value: 0.7731
        },
        {
            date: 1169510400000,
            value: 0.767
        },
        {
            date: 1169596800000,
            value: 0.769
        },
        {
            date: 1169683200000,
            value:  0.7706
        },
        {
            date: 1169769600000,
            value: 0.7752
        },
        {
            date: 1170028800000,
            value: 0.774
        },
        {
            date: 1170115200000,
            value: 0.771
        },
        {
            date: 1170201600000,
            value: 0.7721
        },
        {
            date: 1170288000000,
            value: 0.7681
        },
        {
            date: 1170374400000,
            value: 0.7681
        },
        {
            date: 1170633600000,
            value: 0.7738
        },
        {
            date: 1170720000000,
            value: 0.772
        },
        {
            date: 1170806400000,
            value: 0.7701
        },
        {
            date: 1170892800000,
            value: 0.7699
        },
        {
            date: 1170979200000,
            value: 0.7689
        },
        {
            date: 1171238400000,
            value: 0.7719
        },
        {
            date: 1171324800000,
            value: 0.768
        },
        {
            date: 1171411200000,
            value: 0.7645
        },
        {
            date: 1171497600000,
            value: 0.7613
        },
        {
            date: 1171584000000,
            value: 0.7624
        },
        {
            date: 1171843200000,
            value: 0.7616
        },
        {
            date: 1171929600000,
            value: 0.7608
        },
        {
            date: 1172016000000,
            value: 0.7608
        },
        {
            date: 1172102400000,
            value: 0.7631
        },
        {
            date: 1172188800000,
            value: 0.7615
        },
        {
            date: 1172448000000,
            value: 0.76
        },
        {
            date: 1172534400000,
            value: 0.756
        },
        {
            date: 1172620800000,
            value: 0.757
        },
        {
            date: 1172707200000,
            value: 0.7562
        },
        {
            date: 1172793600000,
            value: 0.7598
        },
        {
            date: 1173052800000,
            value: 0.7645
        },
        {
            date: 1173139200000,
            value: 0.7635
        },
        {
            date: 1173225600000,
            value: 0.7614
        },
        {
            date: 1173312000000,
            value: 0.7604
        },
    ]
    
    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
        am5themes_Animated.new(root)
    ]);
    
    
    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX",
        pinchZoomX:true
    }));
    
    // Add cursor
    // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
        behavior: "none"
    }));
    cursor.lineY.set("visible", false);
    
    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
        maxDeviation: 0.5,
        baseInterval: {
            timeUnit: "day",
            count: 1
        },
        renderer: am5xy.AxisRendererX.new(root, {
            // pan:"zoom"
            // inside: true
        }),
    }));
    
    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        maxDeviation:1,
        renderer: am5xy.AxisRendererY.new(root, {
            // pan:"zoom",
            inside: true,
        })
    }));
    
    
    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    let tooltip = am5.Tooltip.new(root, {
        getFillFromSprite: false,
        labelText: "{valueX.formatDate()}\nLast: [bold]{valueY}"
    });

    tooltip.get("background").setAll({
        fill: am5.color(0xffffff),
        fillOpacity: 1,
    });
    var series = chart.series.push(am5xy.SmoothedXLineSeries.new(root, {
        //   name: "Series",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        valueXField: "date",
    }));
    series.set("tooltip", tooltip);
    series.fills.template.setAll({
        visible: true,
        fillOpacity: 0.2
    });
    
    series.bullets.push(function() {
        return am5.Bullet.new(root, {
            locationY: 0,
            sprite: am5.Circle.new(root, {
                radius: 3,
                stroke: root.interfaceColors.get("background"),
                strokeWidth: 1,
                fill: series.get("fill")
            })
        });
    });
    
    series.data.setAll(data);
    
    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear(1000);
    chart.appear(1000, 100);

}); // end am5.ready()