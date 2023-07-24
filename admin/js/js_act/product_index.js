var thePage = {};

$(document).on('click', '#edit_product', function() {
    BootstrapDialog.show({
        title: "Xác nhận",
        message: `Bạn muốn xóa sản phẩm này khỏi giỏ hàng?`,
        buttons: [{
            label: 'Hủy',
            cssClass: 'btn-secondary btn-width',
            action: function (dialogItself) {
                dialogItself.close();
            }
        }, {
            label: ' Xác nhận',
            cssClass: 'btn-key btn-width',
            action: function (dialogItself) {
                dialogItself.close();
            }
        }]
    });
})