if ($('#chart_nganh_1').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_nganh_1");

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root),
        ]);

        // Create wrapper container
        var container = root.container.children.push(
            am5.Container.new(root, {
                width: am5.percent(100),
                height: am5.percent(100),
                layout: root.verticalLayout
            })
        );

        // Create series
        // https://www.amcharts.com/docs/v5/charts/hierarchy/#Adding
        var series = container.children.push(
            am5hierarchy.Treemap.new(root, {
                singleBranchOnly: false,
                downDepth: 1,
                upDepth: -1,
                initialDepth: 2,
                valueField: "value",
                categoryField: "name",
                childDataField: "children",
                nodePaddingOuter: 0,
                nodePaddingInner: 0
            })
        );
        series.get("colors").set("colors", [
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050),
            am5.color(0x92d050)
        ]);

        series.rectangles.template.setAll({
            strokeWidth: 1,
        });

        var data = {
            children: [{
                    name: "Họ VIN",
                    value: 235,
                    nodeSettings: {
                      fill: am5.color(0x297373)
                    }
                },
                {
                    name: "Ngân hàng",
                    value: 235
                },
                {
                    name: "Họ FLC",
                    value: 235
                },
                {
                    name: "Dầu khí",
                    value: 148
                },
                {
                    name: "Dịch vụ hàng không",
                    value: 126
                },
                {
                    name: "Xây dựng dân dụng",
                    value: 66
                },
                {
                    name: "Bất động sản",
                    value: 148
                },
                {
                    name: "Bán lẻ",
                    value: 126
                },
                {
                    name: "Thực phẩm - bánh kẹo",
                    value: 66
                },
                {
                    name: "Chứng khoáng",
                    value: 166
                },
                {
                    name: "Vận tải đường bộ",
                    value: 148
                },
                {
                    name: "Hóa chất",
                    value: 126
                },
                {
                    name: "Gỗ",
                    value: 66
                }
            ]
        };

        series.data.setAll([data]);
        series.set("selectedDataItem", series.dataItems[0]);

        // Make stuff animate on load
        series.appear(1000, 100);

    }); // end am5.ready()
}
if ($('#chart_nganh_2').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_nganh_2");


        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);


        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: "none",
            wheelY: "none"
        }));

        // We don't want zoom-out button to appear while animating, so we hide it
        chart.zoomOutButton.set("forceHidden", true);


        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var yRenderer = am5xy.AxisRendererY.new(root, {
            minGridDistance: 30
        });

        var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
            maxDeviation: 0,
            categoryField: "network",
            renderer: yRenderer,
            tooltip: am5.Tooltip.new(root, { themeTags: ["axis"] })
        }));

        var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
            maxDeviation: 0,
            min: 0,
            extraMax: 0.1,
            renderer: am5xy.AxisRendererX.new(root, {})
        }));


        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: "Series 1",
            xAxis: xAxis,
            yAxis: yAxis,
            valueXField: "value",
            categoryYField: "network",
            tooltip: am5.Tooltip.new(root, {
                pointerOrientation: "left",
                labelText: "{valueX}"
            })
        }));


        // Rounded corners for columns
        series.columns.template.setAll({
            cornerRadiusTR: 0,
            cornerRadiusBR: 0
        });

        // Make each column to be of a different color
        series.columns.template.adapters.add("fill", function(fill, target) {
            return am5.color(0xffc000);
        });

        series.columns.template.adapters.add("stroke", function(stroke, target) {
            return am5.color(0xffc000);
        });


        // Set data
        var data = [{
                "network": "Bất động sản",
                "value": 2255250000
            },
            {
                "network": "Năng lượng",
                "value": 430000000
            },
            {
                "network": "Công nghiệp",
                "value": 1000000000
            },
            {
                "network": "Hàng hóa không thiết yếu",
                "value": 246500000
            },
            {
                "network": "Hàng hóa thiết yếu",
                "value": 355000000
            },
            {
                "network": "Chăm sóc sức khỏe",
                "value": 500000000
            },
            {
                "network": "Công nghệ",
                "value": 624000000
            },
            {
                "network": "Tiện ích",
                "value": 329500000
            },
            {
                "network": "Tài chính",
                "value": 1000000000
            },
            {
                "network": "Ngành vật liệu",
                "value": 431000000
            }
        ];

        yAxis.data.setAll(data);
        series.data.setAll(data);
        sortCategoryAxis();

        // Get series item by category
        function getSeriesItem(category) {
            for (var i = 0; i < series.dataItems.length; i++) {
                var dataItem = series.dataItems[i];
                if (dataItem.get("categoryY") == category) {
                    return dataItem;
                }
            }
        }

        chart.set("cursor", am5xy.XYCursor.new(root, {
            behavior: "none",
            xAxis: xAxis,
            yAxis: yAxis
        }));


        // Axis sorting
        function sortCategoryAxis() {

            // Sort by value
            series.dataItems.sort(function(x, y) {
                return x.get("valueX") - y.get("valueX"); // descending
                //return y.get("valueY") - x.get("valueX"); // ascending
            })

            // Go through each axis item
            am5.array.each(yAxis.dataItems, function(dataItem) {
                // get corresponding series item
                var seriesDataItem = getSeriesItem(dataItem.get("category"));

                if (seriesDataItem) {
                    // get index of series data item
                    var index = series.dataItems.indexOf(seriesDataItem);
                    // calculate delta position
                    var deltaPosition = (index - dataItem.get("index", 0)) / series.dataItems.length;
                    // set index to be the same as series data item index
                    dataItem.set("index", index);
                    // set deltaPosition instanlty
                    dataItem.set("deltaPosition", -deltaPosition);
                    // animate delta position to 0
                    dataItem.animate({
                        key: "deltaPosition",
                        to: 0,
                        duration: 1000,
                        easing: am5.ease.out(am5.ease.cubic)
                    })
                }
            });

            // Sort axis items by index.
            // This changes the order instantly, but as deltaPosition is set,
            // they keep in the same places and then animate to true positions.
            yAxis.dataItems.sort(function(x, y) {
                return x.get("index") - y.get("index");
            });
        }

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        chart.appear(1000, 100);

    }); // end am5.ready()
}