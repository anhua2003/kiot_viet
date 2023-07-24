var thePage = {};

thePage.lMember = $("#list_members");

thePage.current_member_history_user_id = '';
thePage.current_page_history_orders = '1';

thePage.current_member_booking_user_id = '';
thePage.current_page_booking_orders = '1';

thePage.current_liabilities_user_id = '';
thePage.current_page_liabilities = '1';

thePage.liabilities_shop_id = 1;

var filter_joined_at = $("#filter_joined_at");
var filter_txt = $("#filter_txt");
var filter_member_group_id = $("#filter_member_group_id");
var filter_btn_view = $("#filter_btn_view");
var recent_page = $("#recent_page");
var page_html = $("#page_html");

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
    filter_joined_at.datepicker({
        dateFormat: "dd/mm/yy"
    });
    filter_btn_view.click(function() {
        recent_page = 1;
        thePage.filter();
    })
    thePage.filter();
})

function paging_members(_page) {
    recent_page = _page;
    thePage.filter();
}

thePage.filter = () => {

    let data = new FormData();
    let sortBy = getSortField('sortBy');

    data.append('field', sortBy.field);
    data.append('sort', sortBy.sort);
    data.append('keyword', filter_txt.val());
    data.append('joined_at', filter_joined_at.val());
    data.append('member_group_id', filter_member_group_id.val());
    data.append('page', recent_page);

    _doAjaxNod('POST', data, 'user_member', 'idx', 'filter', true, (res) => {
        // console.log(res.data);
        $("#total_member").html('(' + res.data.total_record + ')');
        page_html.html(res.data.page_html);
        thePage.lMember.html(thePage.render_lMember(res.data));
        thePage.lMember.after(thePage.render_rMember(res.data));
    })
}

thePage.render_lMember = (l) => {
    let h = `<tr>
                <th></th>
                <th></th>
                <th></th>
                <th>Tổng:</th>
                <th class="color-red" id="tpl_total_debt">${number_format_replace_cog(l.total_spent)}</th>
                <th id="tpl_total_spent">${number_format_replace_cog(l.total_liabilities)}</th>
            </tr>`;
    return h;
}

thePage.render_rMember = (l) => {
    let h = '';
    $(".row-members").remove();
    l.list_members.forEach(item => {
        // console.log(item);
        h += `<tbody class="row-members">
                <tr id="profile_click_${item.user_id}" class="profile_click" members_id="${item.user_id}">
                    <td>${item.fullname}</td>
                    <td>${item.member_group_name}</td>
                    <td>${date_format('d/m/Y H:i', item.joined_at)}</td>
                    <td>${item.mobile}</td>
                    <td>${number_format_replace_cog(item.total_liabilities)}</td>
                    <td><b>${number_format_replace_cog(item.total_spent)}</b></td>
                </tr>
            <t/body>`;
    });
    return h;
}


thePage.customerDetail = (_id) => {
    thePage.getDetail(_id, function(_data) {
        $(".profile_info").remove();
        let h = thePage.renderCustomerDetail(_data);
        $("#profile_click_" + _id).after(h);
    })
}

thePage.getDetail = (_id, _cb) => {
    var data = new FormData();
    data.append('user_id', _id);
    _doAjaxNod('POST', data, 'user_member', 'idx', 'get_detail_member', true, function(response) {
        _cb(response.data);
    });
}

thePage.renderCustomerDetail = (d) => {
        let h = `<tr class="profile_info">
        <td colspan="9">
            <ul class="nav nav-tabs">
                <li class="p_tab_pro p_tab_members_profile active"><a user_id="${d.user_id}" data-toggle="tab_infomation_profile">Thông tin</a></li>
                <li class="p_tab_pro p_tab_members_history "><a user_id="${d.user_id}" data-toggle="tab_infomation_history">Lịch sử bán/trả hàng</a></li>
                <li class="p_tab_pro p_tab_infomation_order_booking "><a user_id="${d.user_id}" data-toggle="tab_infomation_order_booking">Đơn đặt hàng</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab_pro tab_infomation_profile active top15">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <div class="img_avatar_profile">
                                <i class="fa fa-camera" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-md-10 col-sm-10 col-xs-10">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">

                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Mã khách hàng:</label>
                                        <div class="form-wrap"><strong>${d.code}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Tên khách:</label>
                                        <div class="form-wrap"><strong>${d.fullname}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">CMND:</label>
                                        <div class="form-wrap"><strong>${d.cmnd}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Điện thoại:</label>
                                        <div class="form-wrap"><strong>${d.mobile}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Email:</label>
                                        <div class="form-wrap"><strong>${d.email}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Website: <span>${d.facebook == '' ? `<a class="create_web_id" user_id="${d.user_id}">Tạo Web</a>` : ''}</span></label>
                                        <div class="form-wrap"><strong>${d.facebook}</strong></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Web ID:</label>
                                        <div class="form-wrap"><strong>${d.web_id > 0 ? d.web_id : '-'}</strong></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Ngày sinh:</label>
                                        <div class="form-wrap"><strong title="${d.day + '/' + d.month + '/' + d.year}">${d.day != '' && d.day != '0' ? d.day + '/' + d.month + '/' + d.year : '-'}</strong></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Tỉnh Thành:</label>
                                        <div class="form-wrap"><strong>${d.city}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Quận/ Huyện:</label>
                                        <div class="form-wrap"><strong>${d.district}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Phường xã:</label>
                                        <div class="form-wrap"><strong>${d.ward}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Địa chỉ:</label>
                                        <div class="form-wrap"><strong>${d.address}</strong></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Tên ngân hàng:</label>
                                        <div class="form-wrap"><strong>${d.bank_name}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Số tài khoản ngân hàng:</label>
                                        <div class="form-wrap"><strong>${d.bank_account}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Tên chủ tài khoản ngân hàng:</label>
                                        <div class="form-wrap"><strong>${d.bank_fullname}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Chi nhánh tài khoản ngân hàng:</label>
                                        <div class="form-wrap"><strong>${d.bank_branch}</strong></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Tỉnh thành tài khoản ngân hàng:</label>
                                        <div class="form-wrap"><strong>${d.bank_city}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Nhóm khách hàng:</label>
                                        <div class="form-wrap"><strong>${d.member_group_name}</strong></div>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="form-label control-label ng-binding">Chức danh:</label>
                                        <div class="form-wrap"><strong>${d.member_title_name}</strong></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="tab_pro tab_infomation_history" id="member_transaction_${d.user_id}">
                    <div class="notfoundIcon">
                        <img src="${domain}/images/notfoundIcon.png" width="50" style="margin: 20px 0px 10px;">
                        <p>Không tìm thấy kết quả nào phù hợp</p>
                    </div>
                </div>
                <div class="tab_pro tab_infomation_order_booking" id="member_booking_${d.user_id}">
                    <div class="notfoundIcon">
                        <img src="${domain}/images/notfoundIcon.png" width="50" style="margin: 20px 0px 10px;">
                        <p>Không tìm thấy kết quả nào phù hợp</p>
                    </div>
                </div>
            </div>
        </td>
    </tr>`;
    return h;
}

thePage.toStringLocationAllowed = (_l, _class_css) => {
    let h = '';
    if (_l)
        _l.forEach((it) => {
            h += `<span item-id="${it.id}" class="${_class_css} parent-location-${it.city_id ? it.city_id : '0'}">${it.type} ${it.name} <i class="x-close">x</i></span>`;
        })
    return h;
}

//change tab
$('body').on('click', '.profile_info .nav li a', function () {
    var data_toggle = $(this).attr('data-toggle');
    if (data_toggle == 'tab_infomation_history') {
        thePage.current_member_history_user_id = $(this).attr("user_id");
        thePage.current_page_history_orders = 1;
        thePage.member_history_orders();
    } else if (data_toggle == 'tab_infomation_order_booking') {
        thePage.current_member_booking_user_id = $(this).attr("user_id");
        thePage.current_page_booking_orders = 1;
        thePage.member_order_booking();
    }

    $(this).parents('.profile_info').find('.tab-content .tab_pro').removeClass('active');
    $(this).parents('.profile_info').find('.tab-content .' + data_toggle).addClass('active');
    $(this).parents('.nav').find('li').removeClass('active');
    $(this).parent().addClass('active');
});

$('body').on('click', 'table.members tbody tr.profile_click', function () {
    if ($(this).parent().hasClass('active')) {
        $(this).parent().removeClass('active');
    } else {
        $(".row-members").removeClass("active");
        thePage.customerDetail($(this).attr('members_id'));
        $(this).parent().addClass('active');
    }
});
//end change tab

// history order by user

function paging_history_order(_page) {
    thePage.current_page_history_orders = _page;
    thePage.member_history_orders();
}

thePage.member_history_orders = () => {
    var data = new FormData();
    data.append('members_id', thePage.current_member_history_user_id);
    data.append('page', thePage.current_page_history_orders);
    data.append('is_booking', 0);
    _doAjaxNod('POST', data, 'user_member', 'idx', 'member_history_order', true, function (res) {
        let h = thePage.renderHistoryOrder(res.data);
        $("#member_transaction_" + thePage.current_member_history_user_id).html(h);
    });
}

thePage.renderHistoryOrder = (l) => {
    let h = '';
    if (l.lItems) {
        l.lItems.forEach(function (item) {
            h += `<tr>
						<td><a class="open-order-member" is_from_warehouse="0" order_id="${item.order_id}" shop_id="${item.shop_id}" created_at="${item.order_created_at}" href="javascript:;">${item.order_id}</a></td>
						<td>${item.shop_name}</td>
						<td>${item.created_by}</td>
						<td>${date_format("d/m/Y H:i", item.order_created_at)}</td>
						<td>${number_format_replace_cog(item.sum)}</td>
						<td>${number_format_replace_cog(item.cost)}</td>
						<td>${number_format_replace_cog(parseFloat(item.sum) - parseFloat(item.cost))}</td>
					</tr>`;
        })
    }

    if (h != '') {
        h = `<table class="table table-responsive table-striped table-bordered text-center table-bg-no">
					<thead>
						<tr>
							<th>Mã HĐ</th>
							<th>Chi nhánh</th>
							<th>Người tạo</th>
							<th>Ngày tạo</th>
							<th>Tổng tiền</th>
							<th>Giá vốn</th>
							<th>Lãi BH</th>
						</tr>
					</thead>
					</body>
						${h}
					</tbody>
			</table>
			<span>${l.page_html}</span>`;
    } else {
        h = `<div class="notfoundIcon" style="color: #666;">
				<img src="${domain}/images/notfoundIcon.png" width="50" style="margin: 20px 0px 10px;">
				<p>Không tìm thấy kết quả nào phù hợp</p>
			</div>`;
    }
    return h;
}
// end history order by user

/*
- BEGIN History booking order
*/
function paging_booking_order(_page) {
    thePage.current_page_booking_orders = _page;
    thePage.member_order_booking();
}

thePage.member_order_booking = () => {
    var data = new FormData();
    data.append('members_id', thePage.current_member_booking_user_id);
    data.append('page', thePage.current_page_booking_orders);
    data.append('is_booking', 1);
    _doAjaxNod('POST', data, 'user_member', 'idx', 'member_booking_order', true, function (res) {
        let h = thePage.renderBookingOrder(res.data);
        $("#member_booking_" + thePage.current_member_booking_user_id).html(h);
    });
}

thePage.renderBookingOrder = (l) => {
    let h = '';
    if (l.lItems) {
        l.lItems.forEach(function (item) {
            h += `<tr>
						<td><a class="open-order-member" is_from_warehouse="0" order_id="${item.order_id}" shop_id="${item.shop_id}"  href="javascript:;" >${item.order_id}</a></td>
						<td>${item.shop_name}</td>
						<td>${item.created_by}</td>
						<td>${date_format("d/m/Y H:i", item.order_created_at)}</td>
						<td>${number_format_replace_cog(item.sum)}</td>
						<td>${number_format_replace_cog(item.cost)}</td>
						<td>${number_format_replace_cog(parseFloat(item.sum) - parseFloat(item.cost))}</td>
						<td>${item.is_completed_booking && item.is_completed_booking == 1 ? `<span class="color-green">Hoàn thành</span>` : `<span class="color-red">Đang giao</span>`}</td>
					</tr>`;
        })
    }

    if (h != '') {
        h = `<table class="table table-responsive table-striped table-bordered text-center table-bg-no">
					<thead>
						<tr>
							<th>Mã HĐ</th>
							<th>Chi nhánh</th>
							<th>Người tạo</th>
							<th>Ngày tạo</th>
							<th>Tổng tiền</th>
							<th>Giá Vốn</th>
							<th>Lãi BH</th>
							<th>Trạng thái</th>
						</tr>
					</thead>
					</body>
						${h}
					</tbody>
			</table>
			<span>${l.page_html}</span>`;
    } else {
        h = `<div class="notfoundIcon" style="color: #666;">
				<img src="${domain}/images/notfoundIcon.png" width="50" style="margin: 20px 0px 10px;">
				<p>Không tìm thấy kết quả nào phù hợp</p>
			</div>`;
    }
    return h;
}
/*
- END History booking order
*/

// coppy link giới thiệu
var body = document.getElementsByTagName('body')[0];
var btnCopy = document.getElementById('btnCopy');
var link = $('#link_referral').val();

var copyToClipboard = function (link) {
    var tempInput = document.createElement('INPUT');
    body.appendChild(tempInput);
    tempInput.setAttribute('value', link)
    tempInput.select();
    document.execCommand('copy');
    body.removeChild(tempInput);
}

$('body').on('click', '#btnCopy', function (e) {
    // e.preventDefault();
    copyToClipboard(link);
    alert_void("Đã copy thành công!", 1);
    return false;
});
// end coppy link giới thiệu