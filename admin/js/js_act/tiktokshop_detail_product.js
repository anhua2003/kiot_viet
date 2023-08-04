$(document).on('click', '#edit_product', function(e) {
    e.preventDefault();
    let id = $(this).data('product-id')
    let formData = new FormData(document.getElementById('edit_form'));
    formData.append('product_id', id);
    _doAjaxNod('POST', formData, "tiktokshop", "product", "edit", true, (res) => {
        if(res.status == 200)
        {
            window.location.reload();
        }
    })
})