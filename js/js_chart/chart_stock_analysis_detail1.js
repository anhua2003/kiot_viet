if ($('#chart_ptkt_ct_1').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_ptkt_ct_1");

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

if ($('#chart_ptkt_ct_2').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_ptkt_ct_2");

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
if ($('#chart_ptkt_ct_3').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_ptkt_ct_3");

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
                value = 5;
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

if ($('#chart_ptkt_ct_4').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_ptkt_ct_4");

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
                value = 3;
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
if ($('#chart_ptkt_ct_5').length > 0) {
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chart_ptkt_ct_5");

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
                value = 5;
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