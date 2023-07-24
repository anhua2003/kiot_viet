var thePage = {};

thePage.user_id = $("#user_id");

$(document).on('click', '.update_image', function() {
    let avatar = $("#file_avatar").prop("files")[0];
    thePage.update_avatar(avatar);
    $("#file_avatar").val('');
})

$(document).on('click', '#update_profile', function() {
    thePage.update_profile();
})

$(document).on('click', '#detail_invoice', function() {
    let order_id = $(this).data("order-id");
    thePage.detail_invoice(order_id);
})

$(document).on('click', '#change_pass', function() {
    let old_pass = $("#old_pass").val();
    let new_pass = $("#new_pass").val();
    thePage.change_pass(old_pass, new_pass);
})

$(document).on('click', '#rating_order', function() {
    let order_id = $(this).data("order-id");
    thePage.rating_order(order_id);
})

$(document).on('click', '#rating_this', function(e) {
    e.preventDefault();
    let product_id = $(this).data("product-id");
    alert(product_id);
})

$(document).on('click', '#cancel_order', function() {
    let formData = new FormData();
    let order_id = $(this).data("order-id-tiktok");
    let order_status = $(this).data("order-status");
    _doAjaxNod("POST", formData, "user", "index", "getList_reverse_key", true, (res) => {
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
                        dialogItself.close();
                    }
                }]
            });
        }
    })
})

$(document).on('click', '.confirm_cancel', function() {
    let selected_value = $("#selected_reason").val();
    if(selected_value == "")
    {
        alert("Please dung de trong");
    } else {
        let order_id = $("#order_id_tiktok").val();
        let formData = new FormData();
        formData.append("order_id", order_id);
        formData.append("reason_key", selected_value);
        _doAjaxNod("POST", formData, "user", "index", "cancel_order_tiktok", true, (res) => {
            if(res.status == 200)
            {
                alert_void(res.message, 1);
            }
        })
    }
})

thePage.update_avatar = (avatar) => {
    let formData = new FormData();
    formData.append('id', thePage.user_id.val())
    formData.append('avatar', avatar);
    _doAjaxNod("POST", formData, "user", "index", "update_avatar", true, (res) => {
        if(res.status == 200)
        {
            alert_void(res.message, 1);
            let timestamp = new Date().getTime();
            let html1 = '<img class="img-profile img-circle img-responsive center-block" src="./public/img/user/'+thePage.user_id.val()+'/'+thePage.user_id.val()+'.jpg?'+timestamp+'" alt="">';
            let html2 = '<img class="img-rounded img-responsive" src="./public/img/user/'+thePage.user_id.val()+'/'+thePage.user_id.val()+'.jpg?'+timestamp+'" alt="">';
            $("#img_avatar1").html(html1);
            $("#img_avatar2").html(html2);
        }
    })
}

thePage.update_profile = () =>{
    let user_name = $("#user_name").val();
    let address = $("#address").val();
    let phone = $("#phone").val();
    if(user_name == '')
    {
        alert_void('Vui lòng nhập tên ');
    } else {
        let formData = new FormData();
        formData.append('user_name', user_name);
        formData.append('address', address);
        formData.append('phone', phone);
        formData.append('id', thePage.user_id.val());
        _doAjaxNod("POST", formData, "user", "index", "update_profile", true, (res) => {
            if(res.status == 200)
            {
                alert_void(res.message, 1);
                $("#show_name").text(user_name);
            }
        })
    }
    
}

thePage.detail_invoice = (order_id) => {
    let formData = new FormData();
    formData.append('order_id', order_id);
    _doAjaxNod("POST", formData, "user", "index", "detail_invoice", true, (res)=>{
        if(res.status == 200)
        {
            console.log(res.data[0]['order_id']);
            let content = '';
            let j = 0;
            let total = 0;
            res.data.forEach(function(item) {
                j++;
                total += item.price*item.quantity;
                content += `<tr>
                    <td>${j}</td>
                    <td>${item.name_product} <br> <small>${item.unique_txt}</small></td>
                    <td>${number_format(item.price)}đ</td>
                    <td>${item.quantity}</td>
                    <td>${number_format(item.price*item.quantity)}đ</td>
                </tr>`
            })
            BootstrapDialog.show({
                title: 'Hóa đơn: ' + res.data[0]['order_id'],
                message: `
                <p>Tên người nhận: ${res.data[0]['name']}</p>  
                <p>Email: ${res.data[0]['email']}</p>
                <p>Địa chỉ: ${res.data[0]['address']}</p>
                <p>Số điện thoại: ${res.data[0]['phone']}</p>
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </thead>
                    <tbody>
                        ${content}
                    </tbody>
                </table>
                <h4>Tổng tiền: ${number_format(total)}đ</h4>`,
                buttons: [{
                    label: 'Đóng',
                    cssClass: 'btn-key btn-width',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
            });
        }
    })
}

thePage.change_pass = (old_pass, new_pass) => {
    let formData = new FormData();
    formData.append('old_pass', old_pass);
    formData.append('new_pass', new_pass);
    _doAjaxNod("POST", formData, "user", "index", "change_password", true, (res) => {
        if(res.status == 200)
        {
            alert_void(res.message, 1);
        }
    })
}

thePage.rating_order = (order_id) => {
    let formData = new FormData();
    formData.append('order_id', order_id);
    _doAjaxNod("POST", formData, "user", "index", "rating_order", true, (res) => {
        if(res.status == 200)
        {
            let content = '';
            res.data.forEach(function(item) {
                content += `
                <p>${item.name_product} - ${item.unique_txt}</p>
                <form class="review-form" style="margin-bottom: 10px;">	
                <textarea class="input" placeholder="Your Review"></textarea>
                <div class="input-rating">
                    <span>Your Rating: </span>
                    <div class="rateyo1 pb-2" id="rating" data-rateyo-rating="0" data-rateyo-num-stars="5" data-rateyo-score="3"></div>
                    <input type="hidden" id="rating" name="rating">
                </div>
                <button class="primary-btn" id="rating_this" data-product-id="${item.id_product}">Submit</button>
            </form>
            `;
            })
            BootstrapDialog.show({
                title: 'Hóa đơn: ' + res.data[0]['order_id'],
                message: `${content}`,
                buttons: [{
                    label: 'Đóng',
                    cssClass: 'btn-key btn-width',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
            });
        }
        $.getScript("./js/jquery.rateyo.js");
        
    })
}



