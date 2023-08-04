var thePage = {}

$(document).on('click', '#delete_order', function() {
    let id = $(this).data("order-id");
    let formData = new FormData();
    formData.append("order_id", id);
    _doAjaxNod("POST", formData, "orders_kiot", "cancel", "cancel", true, (res) => {
        if(res.status == 200)
        {
            // window.location.reload();
        }
    })
})

$(document).on('click', '#confirm_orders', function() {
    alert("Hello");
})