var thePage = {};

thePage.lNoti = $("#lNoti");
thePage.dNoti = $("#dNoti");
thePage.totalNoti = $("#totalNoti");
thePage.page_html = $("#page_html");
thePage.current_page = 1;

$(function() {

    thePage.listNoti();

})

function paging_this(_page) {
    thePage.current_page = _page;
    thePage.listNoti();
}

thePage.listNoti = () => {

    let data = new FormData();
    data.append('page', thePage.current_page);
    _doAjaxNodClient('POST', data, 'client_notification', 'idx', 'list', true, (res) => {
        // console.log(res.data);
        thePage.totalNoti.html('Thông báo của tôi (' + res.data.total_record + ')');
        thePage.lNoti.html(thePage.render(res.data.l));
        thePage.page_html.html(res.data.page_html);
    })
}

thePage.render = (l) => {
    let h = '';
    l.forEach(function(item) {
        h += `<li class="${item.read_status==1?"readed":""}">
                <div class="date">${date_format("d/m/Y", item.created_at)}</div>
                <div class="content">${item.subject}<a style="cursor:pointer;" id="detailNoti" noti-id="${item.id}">Chi tiết</a></div>
                <a class="read hide" id="readNoti" noti-id="${item.id}">Đánh dấu đã đọc</a>
                <a class="delete" id="deleteNoti" noti-id="${item.id}">Xoá</a>
            </li>`;
    })
    return h;
}

$('body').on('click', '#formDetail > i, .btn-close-infomation_code.cancel', function(e) {
    thePage.toggleForm();
});

$('body').on('click', '#detailNoti', function(e) {
    // $(".lProduct").remove();
    thePage.toggleForm();

    let _noti_id = $(this).attr('noti-id');

    let data = new FormData();
    data.append('id', _noti_id);

    _doAjaxNodClient('POST', data, 'client_notification', 'idx', 'detail', true, (res) => {
        // console.log(res.data);
        thePage.dNoti.html(thePage.renderDetail(res.data));
        thePage.read_noti(_noti_id);
    })
});

thePage.renderDetail = (l) => {

    let h = `<h3>${l.subject}</h3>
            <span>${l.content}</span>`;
    return h;
}

$('body').on('click', '#readNoti', function(e) {

    let _noti_id = $(this).attr('noti-id');
    thePage.read_noti(_noti_id);

});

thePage.read_noti = (_noti_id) => {
    let data = new FormData();
    data.append('id', _noti_id);

    _doAjaxNodClient('POST', data, 'client_notification', 'idx', 'read', true, (res) => {
        // console.log(res.data);
        thePage.listNoti();
    })
}

$('body').on('click', '#deleteNoti', function(e) {
    let _noti_id = $(this).attr('noti-id');

    let data = new FormData();
    data.append('id', _noti_id);

    _doAjaxNodClient('POST', data, 'client_notification', 'delete', 'delete', true, (res) => {
        // console.log(res.data);
        thePage.listNoti();
    })
});

thePage.toggleForm = () => {
    $('#formNoti').toggle();
    $('#formDetail').toggle();
}