var thePage = {};

var recent_page = 1;
var department_from = $("#department_from");
var department_keyword = $("#department_keyword");
var department_btn_view = $("#department_btn_view");
var page_html = $("#department_page_html");
var department_list = $("#department_list");
var type_page = 'comm_department';

$(function() {
    $('.sortBy').click(function() {
        $('.sortBy').removeClass('active');
        var id_status = $(this);
        id_status.addClass('active');
        if (id_status.hasClass('glyphicon-chevron-down')) {
            id_status.removeClass('glyphicon-chevron-down');
            id_status.addClass('glyphicon-chevron-up');
        } else {
            id_status.removeClass('glyphicon-chevron-up');
            id_status.addClass('glyphicon-chevron-down');
        }
        thePage.filter();
    });
    department_from.datepicker({
        dateFormat: "dd/mm/yy"
    });
    department_btn_view.click(function() {
        recent_page = 1;
        thePage.filter();
    })
    thePage.filter();
})

function paging_tdis(_page) {
    recent_page = _page;
    thePage.filter();
}

thePage.filter = () => {

    let data = new FormData();
    let sortBy = getSortField('sortBy');

    data.append('field', sortBy.field);
    data.append('sort', sortBy.sort);
    data.append('keyword', department_keyword.val());
    data.append('from', department_from.val());
    data.append('type', type_page);
    data.append('page', recent_page);

    _doAjaxNod('POST', data, 'user_departmental_roses', 'idx', type_page, true, (res) => {
        // console.log(res.data);
        $("#department_total_record").html(number_format_replace_cog(res.data.info.total_record));
        $("#department_total_order_real").html(number_format_replace_cog(res.data.info.total_order_real));
        $("#department_total_order").html(number_format_replace_cog(res.data.info.total_order));
        $("#department_total_commission").html(number_format_replace_cog(res.data.info.total_commission));
        department_list.html(thePage.render(res.data.l));
        page_html.html(res.data.page_html);
    })
}

thePage.render = (l) => {
    let h = '';
    let i = 1;
    l.forEach(item => {
        h += `<tr>
                <td>${i++}</td>
                <td>${date_format('d/m/Y: H:i', item.order_created_at)}</td>
                <td>${item.fullname}</td>
                <td>${item.mobile}</td>
                <td>${item.code}</td>
                <td>${item.member_department_name}</td>
                <td>${item.fitler_id}</td>
                <td>${item.order_id}</td>
                <td>${number_format_replace_cog(item.total_order_real)}</td>
                <td>${number_format_replace_cog(item.total_order)}</td>
                <td>${number_format_replace_cog(item.value)}</td>
            </tr>`;
    });
    return h;
}