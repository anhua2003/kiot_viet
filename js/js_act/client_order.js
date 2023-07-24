var thePage = {};

thePage.lOrder = $("#lOrder");
thePage.lProduct = $("#lProduct");
thePage.totalRecordOrder = $("#totalRecordOrder");
thePage.orderID = $("#orderID");

$(function() {

    thePage.listOrder();

})

thePage.listOrder = () => {

    let data = new FormData();

    _doAjaxNod('POST', data, 'user_order', 'idx', 'list_order', true, (res) => {
        // console.log(res.data);
        thePage.totalRecordOrder.html('Đơn hàng của tôi (' + res.data.dInfo.total_record + ')');
        thePage.lOrder.after(thePage.render(res.data.lItems));
    })
}

thePage.render = (l) => {
    let h = '';
    l.forEach(function(item) {
        h += `<ul>
                <li class="img"><img src="${item.lItems[0].image}" /></li>
                <li class="code" id="detailOrder" order-id="${item.id}" shop-id="${item.shop_id}" order-created-at="${item.created_at}"><span class="mobile">Mã ĐH:</span><a style="color:#f859b7; cursor:pointer;">${item.id}</a></li>
                <li class="date"><span class="mobile">Ngày mua:</span>${date_format('d/m/Y', item.created_at)}</li>
                <li class="price"><span class="mobile">Tổng tiền:</span>${number_format_replace_cog(item.total)}</li>
                <li class="status"><span class="mobile">Trạng thái:</span><span class="${item.shipper_status > 3?'success':item.shipper_status==-1?'cancel': 'pending'}">${item.shipper_status_label}</span></li>
            </ul>`;
    })
    return h;
}

$('body').on('click', '#formDetail > i, .btn-close-infomation_code.cancel', function(e) {
    thePage.toggleForm();
});

$('body').on('click', '#detailOrder', function(e) {
    $(".lProduct").remove();
    thePage.toggleForm();

    let _order_id = $(this).attr('order-id');
    let _shop_id = $(this).attr('shop-id');
    let _order_created_at = $(this).attr('order-created-at');
    let data = new FormData();
    data.append('order_id', _order_id);
    data.append('shop_id', _shop_id);
    data.append('order_created_at', _order_created_at);

    _doAjaxNod('POST', data, 'user_order', 'idx', 'detail', true, (res) => {
        // console.log(res.data);
        thePage.orderID.html('Đơn hàng <span style="color:#f859b7;">' + res.data.id + '</span>');
        thePage.lProduct.after(thePage.renderDetail(res.data));
    })
});

thePage.renderDetail = (l) => {
    let h = '';
    l.lItems.forEach(function(item) {
        h += `<ul class="lProduct">
                <li class="img"><img src="${item.image}" /></li>
                <li class="content">
                    <a href="#" title="">${item.name}</a>
                    <span>Số lượng: ${number_format_replace_cog(item.quantity)}</span>
                </li>
                <li class="price">${number_format_replace_cog(item.price)} đ</li>
                <li class="date"><span class="mobile">Ngày mua:</span>${date_format('d/m/Y', item.date_add)}</li>
                <li class="code"><span class="mobile">Mã ĐH:</span>${item.order_id}</li>
            </ul>`;
    })
    return h;
}

thePage.toggleForm = () => {
    $('#formOrder').toggle();
    $('#formDetail').toggle();
}