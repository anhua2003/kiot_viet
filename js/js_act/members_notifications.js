var thisPage = {};

thisPage.btn_view = $("#btn_view");
thisPage.filter_notify_group_id = $("#filter_notify_group_id");

thisPage.list_members = $("#list_members");
thisPage.tplContent = $("#tpl_content");
thisPage.globalID = '';
thisPage.sendChannel = '';

thisPage.inpTo = $("#to_holder");
thisPage.toHolderSearch = $("#to_holder_search");
thisPage.inpSubject = $("#inp_subject");
thisPage.inpSubjectApp = $("#inp_subject_app");
thisPage.inpContentApp = $("#inp_content_app");
thisPage.inp_searching = $("#inp_searching");

thisPage.addNotification = $("#addNotification");
thisPage.current_page = $("#current_page");

var page_html = $("#page_html");
var nt_content = $('#nt_content');


thisPage.shop_id = $("#shop_id");
thisPage.member_group_id = $("#member_group_id");
thisPage.member_department_id = $("#member_department_id");
thisPage.member_title_id = $("#member_title_id");
//selectbox multi shop_id
selectBoxTest = new vanillaSelectBox("#shop_id", {
    "minWidth": 200,
    "maxHeight": 300,
    "search": true,
    "translations": { "all": "Tất cả", "items": "Lựa chọn", "selectAll": "Chọn tất cả chi nhánh", "clearAll": "Xóa tất cả chi nhánh" },
    "placeHolder": "Chọn chi nhánh",
    "disableSelectAll": false,
});
$('#btn-group-shop_id .multi li:nth-child(2)').trigger('click');
$('#btn-group-shop_id button .title').html('Tất cả chi nhánh');

//selectbox multi member_group_id
selectBoxTest = new vanillaSelectBox("#member_group_id", {
    "minWidth": 200,
    "maxHeight": 300,
    "search": true,
    "translations": { "all": "Tất cả", "items": "Lựa chọn", "selectAll": "Chọn tất cả nhóm thành viên", "clearAll": "Xóa tất cả nhóm thành viên" },
    "placeHolder": "Chọn nhóm thành viên",
    "disableSelectAll": false,
});
$('#btn-group-member_group_id .multi li:nth-child(2)').trigger('click');
$('#btn-group-member_group_id button .title').html('Tất cả nhóm thành viên');

//selectbox multi member_group_id
selectBoxTest = new vanillaSelectBox("#member_department_id", {
    "minWidth": 200,
    "maxHeight": 300,
    "search": true,
    "translations": { "all": "Tất cả", "items": "Lựa chọn", "selectAll": "Chọn tất cả nhóm phòng ban", "clearAll": "Xóa tất cả nhóm phòng ban" },
    "placeHolder": "Chọn nhóm phòng ban",
    "disableSelectAll": false,
});
$('#btn-group-member_department_id .multi li:nth-child(2)').trigger('click');
$('#btn-group-member_department_id button .title').html('Tất cả nhóm phòng ban');

//selectbox multi member_group_id
selectBoxTest = new vanillaSelectBox("#member_title_id", {
    "minWidth": 200,
    "maxHeight": 300,
    "search": true,
    "translations": { "all": "Tất cả", "items": "Lựa chọn", "selectAll": "Chọn tất cả nhóm chức danh", "clearAll": "Xóa tất cả nhóm chức danh" },
    "placeHolder": "Chọn nhóm chức danh",
    "disableSelectAll": false,
});
$('#btn-group-member_title_id .multi li:nth-child(2)').trigger('click');
$('#btn-group-member_title_id button .title').html('Tất cả nhóm chức danh');
$('body').trigger('click');

$(function() {

    $("#inp_scheduled_at_0").click(function() {
        $(".scheduled-time").prop("disabled", true);
    })
    $("#inp_scheduled_at_1").click(function() {
        $(".scheduled-time").prop("disabled", false);
    })
    $("#scheduled_date").datepicker();

    $("#inp_send_to_0").click(function() {
        $(".input_send_to").hide();
    })
    $("#inp_send_to_1").click(function() {
        $(".input_send_to").show();
    })

    $("#btn_delete_by_client").click(function() {
        thisPage.funcsDelete();
    })

    $('.add_notification').click(function() {
        $("#ck_all_investor").prop("checked", false);
        thisPage.resetForm();
        thisPage.funcsToggle();

    })

    $('.close_noti').click(function() {
        thisPage.funcsToggle();
    })


    $(".send_notification").click(function() {
        thisPage.funcsSave(1);
    })

    thisPage.btn_view.click(function() {
        thisPage.funcsFilter();
    })

    thisPage.funcsFilter();

    $(".close_sub_addContact").click(function() {

        $(".input_name .sub").toggle();
        $('.overlay_newnoti').toggle();

    })

    tinymce.init({
        height: 300,
        selector: "#nt_content",
        language: 'vi_VN',
        theme: "modern",
        plugins: [
            "advlist fullpage print preview autolink link image code charmap visualblocks visualchars fullscreen media pagebreak pagebreak wordcount textpattern noneditable insertdatetime",
            "searchreplace",
            "lioniteimages",
            "nonbreaking save table directionality",
            "emoticons paste textcolor "
        ],
        // plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        // content_css : domain+"/css/bootstrap.css",
        menubar: 'file edit view insert format tools table tc help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | code | lioniteimages',
        // toolbar1: "undo redo | table | fontsizeselect | styleselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | bold italic | forecolor backcolor emoticons | lioniteimages",
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        image_advtab: true,
        relative_urls: false,
        toolbar_items_size: 'small',
        remove_script_host: false,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ]
    });



})

thisPage.toHolderSearch.autocomplete({
    minLength: 0,
    option: 'appendTo',
    source: function(request, response) {

        let _except = '';
        $(".l-allowed.edit").each(function() {
            let _id = $(this).attr("item-id");
            if (_id && _id != '')
                _except += _id + ';';
        })

        var data = new FormData();
        data.append('except', _except);
        data.append('keyword', thisPage.toHolderSearch.val());
        _doAjaxNod('POST', data, 'members_notification', 'search_members', 'search_members', false, function(res) {
            response($.map(res.data, function(el) {
                return {
                    label: el.fullname,
                    name: el.fullname,
                    id: el.user_id
                };
            }));
        });
    },
    select: function(e, ui) {
        setTimeout(() => {
            thisPage.inpTo.append(`<span item-id="${ui.item.id}" to_id="${ui.item.id}"  fullname="${ui.item.name}" class="to-item l-allowed edit">${ui.item.name}<b class="to-item-remove">x</b></span>`);
            thisPage.toHolderSearch.val('');
        }, 20);
    }
});

function paging_noti(_page) {
    thisPage.current_page.val(_page);
    thisPage.funcsFilter();
}

$(document).on("click", ".to-item-remove", function() {
    $(this).parent().remove();
})

thisPage.resetForm = () => {
    $("#inp_scheduled_at_0").prop("checked", true);
    $(".scheduled-time").prop("disabled", true);
    $("#inp_send_to_0").prop("checked", true);
    $(".input_send_to").hide();
    thisPage.globalID = '';
    thisPage.inpTo.html('');
    $("#inp_subject").val('');
    $("#inp_subject_app").val('');
    $("#inp_content_app").val('');
    $("#scheduled_date").val('');
    $("#scheduled_hour").val(0);
    $("#scheduled_minute").val(0);
    $("#notify_group_id").val(1);
    tinymce.get('nt_content').setContent('');
};

thisPage.funcsFilter = () => {
    $('.progress_bar').addClass('hide');
    let data = new FormData();
    data.append('page', thisPage.current_page.val());
    data.append('notify_group_id', thisPage.filter_notify_group_id.val());
    _doAjaxNod('POST', data, 'members_notification', 'idx', 'filter', true, (res) => {
        // console.log(res.data.list_notification);
        let _html = thisPage.funcsTPL(res.data.list_notification);
        thisPage.list_members.html(_html);
        page_html.html(res.data.page_html);
    })
}

thisPage.funcsTPL = (l) => {
    let _html = '';
    let i = 1;
    $(".row-members").remove();
    if (l) {
        l.forEach(function(item) {
            _html += `
			<tr id="profile_click" class="profile_click">
				<td>${item.id}</td>
				<td>${item.notify_group_name}</td>
				<td>    
                    <p>${item.subject_app}</p>
                    <p>${item.content_app}</p>
                </td>
				<td>${item.subject}</td>
				<td>${item.content}</td>
				<td>${item.create_by == '' ? 'Tự động' : item.create_by}</td>
				<td>${date_format("d/m/Y H:i", item.created_at)}</td>
				<td>
				<img src="${domain}/public/images/edit.png" width="24" class="img_edit_noti" notification-id="${item.id}">
				<img src="${domain}/public/images/delete.png" width="24" class="img_delete_noti" notification-id="${item.id}">
				</td>
			</tr>`;
        })
    }
    return _html;
}

$('body').on('click', '.img_edit_noti', function(e) {
    let _notification_id = $(this).attr("notification-id");
    thisPage.resetForm();
    thisPage.funcsDetail(_notification_id);
    $('.detailNotification').toggle();
    $('.notification').toggle();
});

$('body').on('click', '.close_detail_noti', function(e) {
    thisPage.funcsToggle();
});

$('body').on('click', '.overlay_newnoti', function(e) {
    //$(".input_name .sub").toggle();
    //$('.overlay_newnoti').toggle();
});

thisPage.funcsDetail = (_id) => {
    let data = new FormData();
    data.append('id', _id);
    _doAjaxNod('POST', data, 'members_notification', 'idx', 'detail', true, (res) => {
        let d = res.data;
        var to = d.to.split(';');
        var to_label = d.to_label.split(';');
        let to_html = '';

        to.pop(); // bỏ phần cuối mãng của to
        to_label.pop(); //bỏ phần cuối mãng của to_label
        if (to == 0) {
            $("#inp_send_to_0").prop("checked", true);
            $(".input_send_to").hide();
        } else {
            console.log(to);
            $("#inp_send_to_1").prop("checked", true);
            $(".input_send_to").show();
            let num2 = "";
            to.forEach((num1, index) => {
                if (to_label[index]) {
                    num2 = to_label[index];
                } else {
                    num2 = "Không có tên";
                }

                to_html += `<span item-id="${num1}" to_id="${num1}" fullname="${num2}" class="to-item l-allowed edit">${num2}<b class="to-item-remove">x</b></span>`;

            });
        }

        thisPage.globalID = d.id;
        thisPage.inpTo.html(to_html);
        $("#inp_subject").val(d.subject);
        $("#inp_subject_app").val(d.subject_app);
        $("#inp_content_app").val(d.content_app);
        if (d.scheduled_at > 0) {
            $("#inp_scheduled_at_1").prop("checked", true);
            $(".scheduled-time").prop("disabled", false);
            $("#scheduled_date").val(d.scheduled_date);
            $("#scheduled_hour").val(d.scheduled_hour.replace(/^0+/, ''));
            $("#scheduled_minute").val(d.scheduled_minute.replace(/^0+/, '') == '' ? 0 : d.scheduled_minute.replace(/^0+/, ''));
        }
        $("#notify_group_id").val(d.notify_group_id);
        tinymce.get('nt_content').setContent(d.content);
        thisPage.addNotification.toggle();
    })
}

thisPage.funcsToggle = () => {
    $('.notification').toggle();
    $('.addNotification').toggle();

}

thisPage.funcsSave = (_page) => {

    let _condition = 0;

    if (document.getElementById('inp_send_to_1').checked == true && (thisPage.shop_id.val() != '' || thisPage.member_group_id.val() != '' || thisPage.member_department_id.val() != '' || thisPage.member_title_id.val() != '')) {
        _condition = 1;
    }

    let _to = '';
    let _to_label = '';
    let _to_group = '';
    if ($("span.to-item").length > 0) {
        $("span.to-item").each(function() {
            if ($(this).attr("to_id") != '') {
                _to += $(this).attr("to_id") + ';';
                _to_label += $(this).attr("fullname") + ';';
            }
        })
    } else if (_condition == 1) {
        _to = '';
    } else {
        _to = "all;";
        _to_label = "";
    }

    let _subject = thisPage.inpSubject.val();
    let _subjectApp = thisPage.inpSubjectApp.val();
    let _contentApp = thisPage.inpContentApp.val();
    var _content = tinymce.get('nt_content').getContent();
    var _scheduled_date = $('#scheduled_date').val();
    var _scheduled_hour = $('#scheduled_hour').val();
    var _scheduled_minute = $('#scheduled_minute').val();
    var _notify_group_id = $('#notify_group_id').val();
    let _id = thisPage.globalID;

    if (_to == '' && _condition != 1) {
        alert_dialog("Vui lòng nhập thông tin người nhận");
        // } else if (_subject == '') {
        //     alert_dialog("Vui lòng nhập tiêu đề");
        // } else if (_content == '') {
        //     alert_dialog("Vui lòng nhập nội dung tin nhắn");
    } else {

        let data = new FormData();
        data.append('id', _id);
        data.append('to', _to);
        data.append('to_label', _to_label);
        data.append('subject', _subject);
        data.append('content', _content);
        data.append('content_app', _contentApp);
        data.append('subject_app', _subjectApp);
        data.append('scheduled_date', _scheduled_date != '' ? _scheduled_date : '');
        data.append('scheduled_hour', _scheduled_date != '' ? _scheduled_hour : '');
        data.append('scheduled_minute', _scheduled_date != '' ? _scheduled_minute : '');
        data.append('notify_group_id', _notify_group_id);
        data.append('lShop', thisPage.shop_id.val() != null && thisPage.shop_id.val() != '' ? thisPage.shop_id.val().join(';') : '');
        data.append('lGroup', thisPage.member_group_id.val() != null && thisPage.member_group_id.val() != '' ? thisPage.member_group_id.val().join(';') : '');
        data.append('lDepartment', thisPage.member_department_id.val() != null && thisPage.member_department_id.val() != '' ? thisPage.member_department_id.val().join(';') : '');
        data.append('lTitle', thisPage.member_title_id.val() != null && thisPage.member_title_id.val() != '' ? thisPage.member_title_id.val().join(';') : '');
        data.append('page', _page);

        _doAjaxNod('POST', data, 'members_notification', 'save', 'save', true, (res) => {
            if (_condition == 1 && _to == '') {
                $('.progress_bar').removeClass('hide');
                let _quantily = res.data.quantity;
                let _width = _quantily * 100 / res.data.count;

                $('.progress_bar').html('<span style="width: ' + _width + '%;">Đang gửi ' + _quantily + '/' + res.data.count + '</span>');
                setTimeout(function() {
                    if (res.data.page > 0 && _quantily < res.data.count) {
                        thisPage.funcsSave(res.data.page);
                    } else {
                        thisPage.funcsToggle();
                        thisPage.funcsFilter();
                    }
                }, 1200);
            } else {
                thisPage.funcsToggle();
                thisPage.funcsFilter();
            }
        })
        $('.progress_bar').removeClass('hide');
    }
}

$('body').on('click', 'img.img_delete_noti', function(e) {
    let _notification_id = $(this).attr("notification-id");
    thisPage.globalID = _notification_id;
    // $("#modal_subject").html($("#subject-" + _notification_id).html());
    $("#modal_subject").html(_notification_id);
    $("#deleteNotification").modal("show");
});

thisPage.funcsDelete = () => {
    let data = new FormData();
    data.append('id', thisPage.globalID);
    _doAjaxNod('POST', data, 'members_notification', 'delete', 'delete', true, (res) => {
        thisPage.globalID = '';
        $("#deleteNotification").modal("hide");
        thisPage.funcsFilter();
    })
}