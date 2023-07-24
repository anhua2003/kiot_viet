var thePage = {};

thePage.bankDefault = $("#bankdefault");
thePage.lBankInfo = $("#listBankInfo");
thePage.bankID = '';

$(function() {
    // setTimeout(function() {
    //     $(".bank_info").prop("disabled", true);
    // }, 200);

    thePage.listBankInfo();

})

thePage.listBankInfo = () => {

    let data = new FormData();

    _doAjaxNod('POST', data, 'user_paymentcard', 'idx', 'list_bank_info', true, (res) => {
        // console.log(res.data);
        if (res.data.bank_account != '') {
            thePage.lBankInfo.html(thePage.render_bank_info(res.data.info, res.data.list_bank));
            $("#add-address").addClass('hide');
        }
    })
}

// render danh sách ngân hàng để người dùng chọn ngân hàng thêm thẻ mới
thePage.render_bank_info = (item, list_bank) => {
    let h = `<li class="form-default">
                <div class="item">
                    <div class="img">
                        <img src="${domain}/images/bankdefault/bank_card.png" alt="${item.bank_fullname}">
                        <p class="name-bank">${item.bank_name}</p>
                        <p class="number-card">${item.bank_account}</p>
                        <p class="name-card">${item.bank_fullname}</p>
                    </div>
                    <div class="form-group">
                        <input type="text" disabled class="form-control bank_info" id="fullname_info" value="${item.bank_fullname}" placeholder="Họ &amp; tên">
                    </div>
                    <div class="form-group">
                        <select class="form-control bank_info" disabled id="bankname_info">
                            <option value="${item.bank_name}">${item.bank_name}</option>`;
                            list_bank.forEach(item => {
                                h += `<option value="${item.short}">${item.short}</option>`;
                            });
                            h += `</select>
                    </div>
                    <div class="form-group">
                        <input type="text" disabled class="form-control bank_info" id="bankaccount_info" value="${item.bank_account}" placeholder="Số tài khoản">
                    </div>
                    <div class="form-group">
                        <input type="text" disabled class="form-control bank_info" id="bankbrach_info" value="${item.bank_branch}" placeholder="Chi nhánh">
                    </div>
                    <div class="form-group">
                        <input type="text" disabled class="form-control bank_info" id="bankcity_info" value="${item.bank_city}" placeholder="Tỉnh thành">
                    </div>
                    <p><b>Lứu ý:</b> Để rút tiền <b>Họ &amp; tên</b> phải trùng với CMND/CCCD.</p>
                    <div class="form-group">
                        <button class="btn btn-key" id="btn_edit_bank_info">Cập nhật</button>
                    </div>
                </div>
            </li>`;
    return h;
}

$('body').on('click', '#btn_edit_bank_info', function(e) {
    $(".bank_info").prop("disabled", false);
    if ($("#btn_edit_bank_info").html() == 'Lưu') {
        BootstrapDialog.show({
            title: "Xác nhận",
            message: `<input type="text" class="form-control" placeholder="Xác nhận mật khẩu" id="confirmPass" value=""/>`,
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
                    if ($("#confirmPass").val() != '') {
                        dialogItself.close();
                    }
                    thePage.funcsEditBankInfo();
                }
            }]
        });
    } else {
        $(".bank_info").prop("disabled", false);
        $("#btn_edit_bank_info").html("Lưu");
    }
})

thePage.funcsEditBankInfo = () => {

    let _bank_fullname = $('#fullname_info');
    let _bank_name = $('#bankname_info');
    let _bank_account = $('#bankaccount_info');
    let _bank_branch = $('#bankbrach_info');
    let _bank_city = $('#bankcity_info');
    let _pass = $('#confirmPass');

    let status_error = false;
    $(".err-modify-tv").remove();

    if (_bank_fullname.val() == '') {
        _bank_fullname.after(`<span class="err-modify-tv color-red">Vui lòng nhập Họ và Tên.</span>`);
        status_error = true;
    }
    if (_bank_account.val() == '') {
        _bank_account.after(`<span class="err-modify-tv color-red">Vui lòng số tài khoản.</span>`);
        status_error = true;
    }
    if (_bank_branch.val() == '') {
        _bank_branch.after(`<span class="err-modify-tv color-red">Vui lòng nhập chi nhánh.</span>`);
        status_error = true;
    }
    if (_bank_city.val() == '') {
        _bank_city.after(`<span class="err-modify-tv color-red">Vui lòng nhập tỉnh thành.</span>`);
        status_error = true;
    }
    if (_pass.val() == '') {
        _pass.after(`<span class="err-modify-tv color-red">Vui lòng xác nhận mật khẩu.</span>`);
        status_error = true;
    }

    if (status_error) {
        return false;
    } else {
        let data = new FormData();
        data.append('bank_fullname', _bank_fullname.val());
        data.append('bank_name', _bank_name.val());
        data.append('bank_account', _bank_account.val());
        data.append('bank_branch', _bank_branch.val());
        data.append('bank_city', _bank_city.val());
        data.append('password', _pass.val());
        _doAjaxNod('POST', data, 'user_paymentcard', 'save', 'update_bank_info', true, (res) => {
            $(".bank_info").prop("disabled", true);
            $("#btn_edit_bank_info").html("Cập nhật");
            thePage.listBankInfo();
            alert_void('Cập nhật thành công.', 1);
        })
    }

}

// $('body').on('click', '#delete_bank_info', function(e) {
//     let _id = $(this).attr('id_bank_info');

//     BootstrapDialog.show({
//         title: "Xác nhận",
//         message: `Bạn muốn xóa thẻ thanh toán này?`,
//         buttons: [{
//             label: 'Hủy',
//             cssClass: 'btn-secondary btn-width',
//             action: function(dialogItself) {
//                 dialogItself.close();
//             }
//         }, {
//             label: ' Xác nhận',
//             cssClass: 'btn-key btn-width',
//             action: function(dialogItself) {
//                 thePage.delete_bank_info(_id);
//                 dialogItself.close();
//             }
//         }]
//     });
// });

thePage.delete_bank_info = (_id) => {
    let data = new FormData();
    data.append('id', _id);
    _doAjaxNod('POST', data, 'user_paymentcard', 'delete', 'delete_bank_info', true, (res) => {
        document.getElementById("form-add-address").style.display = "none";
        thePage.listBankInfo();
    });
}

$('body').on('click', '#btn_add_paymentcard', function(e) {
    // thePage.listBank();
    $("#fullname").val('');
    $("#number").val('');
    $("#city").val('');
    $("#branch").val('');
});

// thePage.listBank = () => {

//     let data = new FormData();

//     _doAjaxNod('POST', data, 'user_paymentcard', 'idx', 'list_bank', true, (res) => {
//         thePage.bankDefault.html(thePage.render_list_bank(res.data.l));
//     })
// }

// // render danh sách ngân hàng để người dùng chọn ngân hàng thêm thẻ mới
// thePage.render_list_bank = (l) => {
//     let h = '';
//     l.forEach(function(item) {
//         h += `<li onclick="thePage.selectBank(${item.id});" data-name=""><img src="${item.icon}" alt="#"></li>`;
//     })
//     return h;
// }

thePage.selectBank = (_id) => {
    thePage.bankID = _id;
}

$('body').on('click', '#btn_save_paymentcard', function(e) {

    document.getElementById("loading_bar").style.display = "block";

    var _fullname = $("#fullname");
    var _number = $("#number");
    var _city = $("#number");
    var _branch = $("#number");
    var _bank = thePage.bankID;

    let status_error = false;
    $(".err-modify-tv").remove();

    if (_fullname.val() == '') {
        _fullname.after(`<span class="err-modify-tv color-red">Vui lòng nhập Họ và Tên.</span>`);
        status_error = true;
    }
    if (_number.val() == '') {
        _number.after(`<span class="err-modify-tv color-red">Vui lòng nhập số tài khoản.</span>`);
        status_error = true;
    }
    if (_branch.val() == '') {
        _branch.after(`<span class="err-modify-tv color-red">Vui lòng nhập chi nhánh.</span>`);
        status_error = true;
    }
    if (_city.val() == '') {
        _city.after(`<span class="err-modify-tv color-red">Vui lòng nhập tỉnh thành.</span>`);
        status_error = true;
    }
    if (_bank == '') {
        $("#bank_id").after(`<span class="err-modify-tv color-red">Vui lòng chọn ngân hàng.</span>`);
        status_error = true;
    }

    if (status_error) {
        document.getElementById("loading_bar").style.display = "none";
        return false;
    } else {
        e.preventDefault();
        var data = new FormData();
        data.append('fullname', _fullname.val());
        data.append('number', _number.val());
        data.append('branch', _branch.val());
        data.append('city', _city.val());
        data.append('bank_id', _bank);
        _doAjaxNod('POST', data, 'user_paymentcard', 'save', 'bank_info', true, (res) => {
            BootstrapDialog.show({
                title: "Thông báo!",
                message: `Đã thêm thẻ thanh toán thành công.`,
                buttons: [{
                    label: 'Xác nhận',
                    cssClass: 'btn-key btn-width',
                    action: function(dialogItself) {
                        dialogItself.close();
                        document.getElementById("loading_bar").style.display = "none";
                        thePage.listBankInfo();
                        document.getElementById("form-add-address").style.display = "none";
                        // location.replace(url_domain + '/paymentcard');
                    }
                }]
            });
        });
    }
});