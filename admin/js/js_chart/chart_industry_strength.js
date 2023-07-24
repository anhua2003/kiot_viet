$(function () {
    function ac_add_to_head(el) {
        var head = document.getElementsByTagName('head')[0];
        head.insertBefore(el, head.firstChild);

    }
    function ac_add_link(url) {
        var el = document.createElement('link');
        el.rel = 'stylesheet'; el.type = 'text/css'; el.media = 'all'; el.href = url;
        ac_add_to_head(el);
    }
    function ac_add_style(css) {
        var ac_style = document.createElement('style');
        if (ac_style.styleSheet) ac_style.styleSheet.cssText = css;
        else ac_style.appendChild(document.createTextNode(css));
        ac_add_to_head(ac_style);
    }

    load_chart_industry_strength();

});

function load_chart_industry_strength() {
    var data = new FormData();
    _doAjaxNodCustom('POST', data, 'chart_industry_strength', 'chart', 'load_chart', true, (res) => {
        // console.log(res.data);
        render_chart_industry_strength(res.data);
    });
}

function render_chart_industry_strength(_l) {
    anychart.onDocumentReady(function () {
        // create data for the second series
        let map_chart = _l.map(x => {
            return {
                data: [

                    // { x: x.rs, y: x.rm },
                    // { x: x.rs_t_1, y: x.rm_t_1 },
                    // { x: x.rs_t_2, y: x.rm_t_2 },
                    // { x: x.rs_t_3, y: x.rm_t_3 },
                    // { x: x.rs_t_4, y: x.rm_t_4 },
                    // { x: x.rs_t_5, y: x.rm_t_5 },
                    // { x: x.rs_t_6, y: x.rm_t_6 },
                    // { x: x.rs_t_7, y: x.rm_t_7 },
                    // { x: x.rs_t_8, y: x.rm_t_8 },
                    // { x: x.rs_t_9, y: x.rm_t_9 },
                    // { x: x.rs_t_10, y: x.rm_t_10 },
                    // { x: x.rs_t_11, y: x.rm_t_11 },
                    // { x: x.rs_t_12, y: x.rm_t_12 },

                    { x: x.rs_t_12, y: x.rm_t_12 },
                    { x: x.rs_t_11, y: x.rm_t_11 },
                    { x: x.rs_t_10, y: x.rm_t_10 },
                    { x: x.rs_t_9, y: x.rm_t_9 },
                    { x: x.rs_t_8, y: x.rm_t_8 },
                    { x: x.rs_t_7, y: x.rm_t_7 },
                    { x: x.rs_t_6, y: x.rm_t_6 },
                    { x: x.rs_t_5, y: x.rm_t_5 },
                    { x: x.rs_t_4, y: x.rm_t_4 },
                    { x: x.rs_t_3, y: x.rm_t_3 },
                    { x: x.rs_t_2, y: x.rm_t_2 },
                    { x: x.rs_t_1, y: x.rm_t_1 },
                    { x: x.rs, y: x.rm },

                ],
                color: x.color
            }
        });

        const max_y = Math.max(...map_chart.map(item => {
            return Math.max(...item.data.map(o => o.y))
        }))

        const max_x = Math.max(...map_chart.map(item => {
            return Math.max(...item.data.map(o => o.x))
        }))

        const min_y = Math.min(...map_chart.map(item => {
            return Math.min(...item.data.map(o => o.y))
        }))

        const min_x = Math.min(...map_chart.map(item => {
            return Math.min(...item.data.map(o => o.x))
        }))

        //data mẫu
        // var data_2 = [
        //     { x: 106.38, value: 98.35 },
        //     { x: 106.38, value: 98.35 },
        //     { x: 106.88, value: 101.26 },
        //     { x: 107.4, value: 101.35 },
        //     { x: 107.25, value: 98.14 },
        // ];

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
        chart.xAxis(0, { ticks: false, labels: false, stroke: "0  #000000" });
        chart.yAxis(0, { ticks: false, labels: false, stroke: "0 #000000" });
        chart.xAxis(1, { ticks: false, labels: false, stroke: "0  #000000" });
        chart.yAxis(1, { ticks: false, labels: false, stroke: "0 #000000" });

        chart.yScale().maximum(max_y);
        chart.xScale().maximum(max_x);
        chart.yScale().minimum(min_y);
        chart.xScale().minimum(min_x);

        // chart.yScale().maximum(150);
        // chart.xScale().maximum(120);

        // chart.yScale(anychart.scales.log());

        //tạo marker là dấu chấm
        map_chart.forEach(function (item) {
            chart.spline().data(item.data).labels(false).markers(false).tooltip(false).stroke('1 ' + item.color).hovered({ stroke: '1 ' + item.color }).selected({ stroke: '1 ' + item.color });
            // chart.marker().data(item.data).zIndex(99).fill(item.color).type("circle").stroke('0.5 ' + item.color).size(4).selectionMode('none');
        });
        // chart.spline().data(data_2).labels(false).markers(false).tooltip(false).stroke('1 #2BD784').hovered({ stroke: '1 #2BD784' }).selected({ stroke: '1 #2BD784' });
        // chart.marker().data(data_2).zIndex(99).fill('#2BD784').type("circle").stroke('0.5 #3A3B3C').size(4).selectionMode('none');

        // chart.spline().data(data_3).labels(false).markers(false).tooltip(false).stroke('1 #FFD200').hovered({ stroke: '1 #FFD200' }).selected({ stroke: '1 #2BD784' });
        // chart.marker().data(data_3).zIndex(99).fill('#FFD200').type("circle").stroke('0.5 #3A3B3C').size(4).selectionMode('none');

        // chart.spline().data(data_4).labels(false).markers(false).tooltip(false).stroke('1 #EEE').hovered({ stroke: '1 #EEE' }).selected({ stroke: '1 #2BD784' });
        // chart.marker().data(data_4).zIndex(99).fill('#FFD200').type("circle").stroke('0.5 #3A3B3C').size(4).selectionMode('none');
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
}
