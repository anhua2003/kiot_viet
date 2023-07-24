var thePage         = {};

thePage.lProduct    = $("#lProduct");
thePage.fullname    = $("#fullname");
thePage.email       = $("#email");
thePage.phone       = $("#phone");
thePage.province    = $("#province");
thePage.district    = $("#district");
thePage.ward        = $("#ward");
thePage.street      = $("#street");
thePage.address_id  = $("#address_id");
thePage.note        = $("#note");
thePage.paymentCod  = $("#payment_cod");

$(function() {
    thePage.filterItemCart();
})

thePage.filterItemCart = () => {

    var itemCart = getLocalStorage(keyLocalStorageItemCart);
    if (itemCart != null && itemCart.length > 0) {
        thePage.lProduct.html(thePage.render(itemCart));
    } else {
        window.location = url_domain + '/san-pham';
    }

}

thePage.render = (itemCart) => {
    let h = '';
    let total = 0;
    if (itemCart != null && itemCart.length > 0) {
        itemCart.forEach(function(item) {
            let price_decrement = item.price - (item.price * item.decrement / 100);
            h += `<tr>
                    <td><img src="${item.link_img}" width="80"/></td>
                    <td><a title="${item.title}">${item.title}</a></td>
                    <td><input onchange="editQuantity('${item.product_id}')" type="number" min='1' id="quantity_${item.product_id}" name="quantity" data-id="${item.product_id}" data-size="0" data-manufacture="15147" value="${item.quantity}" style="border: 1px solid #ddd;padding: 4px 0px;width: 70px;min-width: inherit;text-align: center;"></td>
                    <td>${number_format_replace_cog(price_decrement)} đ</td>
                    <td><b>${number_format_replace_cog(price_decrement*item.quantity)} đ</b>&nbsp;&nbsp;<span class="fa-stack delete" data-id="${item.product_id}" data-size="0" data-manufacture="15147">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-close fa-stack-1x fa-inverse" id="delete_item" product_id=${item.product_id}></i>
                    </span></td>
                </tr>`;
            total = parseFloat(total) + parseFloat(price_decrement * item.quantity);
        })

        h += `<tr>
                <td colspan="4"><b>Tổng tiền</b></td>
                <td><b>${number_format_replace_cog(total)} đ</b></td>
                <input type="text" id="payment_cod" class="hide" value="${total}">
            </tr>`;
    } else {
        h += `<tr>
                <td colspan="3"><b style="display: block;margin: 20px 0px 0px 0px;text-align: center;">Không có sản phẩm nào trong giỏ hàng</b></td>
            </tr>`;
    }

    return h;

}
$('body').on('click', 'i#delete_item', function(e) {
    let _id = $(this).attr('product_id');
    BootstrapDialog.show({
        title: "Xác nhận",
        message: `Bạn muốn xóa sản phẩm này khỏi giỏ hàng?`,
        buttons: [{
            label: 'Hủy',
            cssClass: 'btn-secondary btn-width',
            action: function(dialogItself) {
                dialogItself.close();
            }
        }, {
            label: ' Xác nhận',
            cssClass: 'btn-key btn-width',
            action: function(dialogItself) {
                removeLocalStorage(_id);
                countItemCart();
                thePage.filterItemCart();
                dialogItself.close();
            }
        }]
    });
});

function editQuantity(_product_id) {
    let product_id = _product_id;
    let quantity = $("#quantity_" + _product_id).val();

    editItemCart(product_id, quantity);
    countItemCart();
    thePage.filterItemCart();
}

$('body').on('click', '#submitOrder', function(e) {
    window.location = url_domain + '/thanh-toan';

});
