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