$(document).on('click', '#cancel_order', function() {
    // alert("Hello");
    let formData = new FormData();
    let order_id = $(this).data("order-id-tiktok");
    let order_status = $(this).data("order-status");
    _doAjaxNod("POST", formData, "orders_tiktok", "cancel", "getList_reverse_key", true, (res) => {
        if(res.status == 200)
        {
            let ListArray = res.data['reverse_reason_list'];
            // console.log(ListArray);
            let content = '';
            const filteredData = ListArray.filter(item => item.available_order_status_list);
            filteredData.forEach(function(item) {
                if(item.available_order_status_list.includes(order_status))
                {
                    content += `<option value="${item.reverse_reason_key}">${item.reverse_reason}</option>`;
                }
            })
            BootstrapDialog.show({
                title: "Cancel Order",
                message: `
                <input id="order_id_tiktok" type="hidden" value="${order_id}" />
                <p>Why ?</p>
                <select id="selected_reason">
                    <option value="" selected>Choose your reason</option>
                    ${content}
                </select>`,
                buttons: [{
                    label: 'confirm',
                    cssClass: 'btn-key btn-width confirm_cancel',
                    action: function (dialogItself) {
                        let selected_value = $("#selected_reason").val();
                        if(selected_value == "")
                        {
                            alert("Please dung de trong");
                        } else {
                            let order_id = $("#order_id_tiktok").val();
                            let formData = new FormData();
                            formData.append("order_id", order_id);
                            formData.append("reason_key", selected_value);
                            _doAjaxNod("POST", formData, "orders_tiktok", "cancel", "cancel_order_tiktok", true, (res) => {
                                if(res.status == 200)
                                {
                                    alert("Hủy thành công !");
                                    window.location.reload();
                                }
                            })
                        }
                    }
                }]
            });
        }
    })
})

$(document).on('click', '.confirm_cancel', function() {
    
})