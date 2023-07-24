$(document).on('click', '.quick-view', function() {
    let id = $(this).data("product-id");
    let formData = new FormData();
    formData.append('id', id);
    _doAjaxNod("POST", formData, 'quick_view', 'view', 'view', true, (res)=>{
        if(res.status == 200) {
            console.log(res.data);
            if(res.data.sale != 0)
            {
                sale = '<p>Giảm còn: '+number_format(res.data.price*(100-res.data.sale)/100)+'đ</p>';
            } else {
                sale = '';
            }
            BootstrapDialog.show({
                title: res.data['name'],
                message: `  <p>Mã sản phẩm: ${res.data['id_product']}</p>
                            <p>Giá: ${number_format(res.data['price'])}đ</p>
                            ${sale}
                            <div style="overflow: auto; max-height: 200px;">${res.data['detail_long']}</div>`,
                buttons: [{
                    label: 'Đóng',
                    cssClass: 'btn-secondary btn-width',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
            });
        }
    })
})