var thePage = {};
thePage.value = '';

$(function () {
    thePage.load_list_index($("#type_first_tab").val(), $("#id_first_tab").val());
});

// button chuyển giữ các tab chỉ số
$('.nav-tabs>li>a').click(function () {
    let _type = $(this).attr('data-type');
    let _id = $(this).attr('data-id');
    thePage.load_list_index(_type, _id);
});

// load danh sách
thePage.load_list_index = (_type, _id) => {
    var data = new FormData();
    data.append('type', _type);
    _doAjaxNod('POST', data, 'chart_market_trend', 'idx', 'list_index', true, (res) => {
        $("#list_index_" + _id).html(render_list_index(res.data.l));
        // sau khi đổ dữ liệu list các mã hàng thì gọi mã hàng đầu tiên click để chạy biểu đồ
        // setTimeout(function () {
        $('.tab-content>.active table tbody tr:first-child').trigger('click');
        // }, 10);
    });
};

// render danh sách
function render_list_index(_l) {
    let h = '';
    let i = 1;
    _l.forEach(function (it) {

        h += `<tr data-ticker="${it.ticker}" data-value="${it.overalltascore == 'Strong Sell' ? 1 : it.overalltascore == 'Sell' ? 3 : it.overalltascore == 'Neutral' ? 5 : it.overalltascore == 'Buy' ? 7 : it.overalltascore == 'Strong Buy' ? 9 : ''}" class="list_index ${i > 1 ? '' : 'active '}">
                <td>${it.ticker}</td>
                <td>${number_format_replace_cog(it.close)}</td>
                <td><span class="${number_format_replace_cog(it.change) >= 0 ? 'green' : 'red'}">${number_format_replace_cog(it.change)}</span></td>
                <td><span class="${number_format_replace_cog(it.change) >= 0 ? 'green' : 'red'}">${number_format_replace_cog(it.percent_change)}%</span></td>
                <td class="hide"><span class="red">${number_format_replace_cog(it.volume)}</span></td>
                <td class="hide"><span class="red">${number_format_replace_cog(it.volumevst_1)}</span></td>
                <td class="hide"><span class="red">${number_format_replace_cog(it.volumevsma20)}</span></td>
            </tr>`;

        { i++ };
    })
    return h;
}

// chart giá
function chart_thitruong_1(_ticker) {
    var data = new FormData();
    data.append('ticker', _ticker);
    _doAjaxNod('POST', data, 'chart_market_trend', 'chart', 'load_chart', true, (res) => {
        render_chart_market_trend(res.data.date, res.data.value, res.data.name)
    });
}

function render_chart_market_trend(_date, _value, _name) {
    Highcharts.chart('chart_thitruong_1', {
        chart: {
            type: 'areaspline'
        },
        title: {
            text: 'Average fruit consumption during one week',
            style: { "display": "none" }
        },
        xAxis: {
            categories: _date,
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
            valueSuffix: ''
        },
        credits: {
            enabled: false
        },
        colors: ['#f1cffc'],
        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            }
        },
        series: [{
            name: _name,
            data: _value,
            marker: {
                enabled: false
            },
        }]
    });
}

// chart đánh giá 
if ($('#chart_thitruong_2').length > 0) {
    am5.ready(function () {

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

        axisDataItem.animate({
            key: "value",
            to: 0,
            duration: 800,
            easing: am5.ease.out(am5.ease.cubic)
        });

        // $('.table_in tbody tr').click(function(){
        $('body').on('click', '.table_in tbody tr', function () {
            let _value = parseInt($(this).attr('data-value'));
            let _ticker = $(this).attr('data-ticker');
            $('.table_in tbody tr').removeClass('active');
            $(this).addClass('active');
            axisDataItem.animate({
                key: "value",
                to: _value,
                duration: 800,
                easing: am5.ease.out(am5.ease.cubic)
            });
            chart_thitruong_1(_ticker);
        });
        // Make stuff animate on load
        chart.appear(1000, 100);

    }); // end am5.ready()
}
