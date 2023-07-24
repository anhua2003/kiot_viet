var thePage = {};

thePage.lAddress = $("#lAddress");

$(function() {

    thePage.getListAddress();

})

thePage.getListAddress = () => {

    _doAjaxNod('POST', '', 'user_address', 'idx', 'list', true, (res) => {
        // console.log(res.data);
        thePage.lAddress.html(thePage.render(res.data));
    })
}

thePage.render = (l) => {
    let h = '';
    l.forEach(function(item) {
        h += `<li>
                <div class="name">${item.fullname}<span>${item.is_default == 1 ? '<i class="fa fa-check-square-o" aria-hidden="true"></i> Địa chỉ mặc định</span>' : ''}</div>
                <div class="ad"><b>Địa chỉ:</b> ${item.address + ', ' + item.ward + ', ' + item.district + ', ' + item.city}</div>
                <div class="phone"><b>Điện thoại:</b> ${item.mobile}</div>
                <div class="action">
                    <a class="edit" id="editAddress" address-id="${item.id}">Chỉnh sửa</a>
                    ${item.is_default == 0 ? '<a class="delete" id="deleteAddress" address-id="' + item.id + '">Xoá</a>' : ''}
                </div>
            </li>`;
    })
    return h;
}

$('body').on('click', '#submitAddress', function(e) {
    thePage.funcsSave();
});

thePage.funcsSave = () => {

    let _id = $('#id');
    let _fullname = $('#fullname');
    let _mobile = $('#phone');
    let _province = $('#province');
    let _district = $('#district');
    let _ward = $('#ward');
    let _street = $('#street');
    var _is_default = 0;

    if ($("#is_default").is(":checked")) {
        _is_default = 1;
    }

    var mobile = _mobile.val().replace(/ +/g, "");

    let status_error = false;
    $(".err-modify-tv").remove();

    if (_fullname.val() == '') {
        _fullname.after(`<span class="err-modify-tv color-red">Vui lòng nhập Họ và Tên.</span>`);
        status_error = true;
    }
    if (mobile == '') {
        _mobile.after(`<span class="err-modify-tv color-red">Vui lòng nhập số điện thoại.</span>`);
        status_error = true;
    }
    if (mobile != '' && mobileIsValid(mobile) == false) {
        _mobile.after(`<span class="err-modify-tv color-red">Số điện thoại không đúng định dạng.</span>`);
        status_error = true;
    }
    if (_province.val() == '' || _district.val() == '' || _ward.val() == '' || _street.val() == '') {
        _street.after(`<span class="err-modify-tv color-red">Vui lòng nhập đầy đủ địa chỉ nhận hàng.</span>`);
        status_error = true;
    }

    if (status_error) {
        return false;
    } else {
        let data = new FormData();
        data.append('id', _id.val());
        data.append('fullname', _fullname.val());
        data.append('mobile', _mobile.val());
        data.append('province', _province.val());
        data.append('district', _district.val());
        data.append('ward', _ward.val());
        data.append('street', _street.val());
        data.append('is_default', _is_default);
        _doAjaxNod('POST', data, 'user_address', 'location', _id.val() == '' ? 'add' : 'update', true, (res) => {
            document.getElementById("form-add-address").style.display = "none";
            thePage.emptyForm();
            thePage.getListAddress();
            alert_void('Cập nhật thành công.', 1);
        })
    }

}

thePage.emptyForm = () => {
    $('#id').val('');
    $('#fullname').val('');
    $('#phone').val('');
    $('#street').val('');
    $('#is_default').prop('checked', false);
}

$('body').on('click', '#editAddress', function(e) {
    thePage.emptyForm();
    document.getElementById("form-add-address").style.display = "block";
    let _id = $(this).attr('address-id');
    let data = new FormData();
    data.append('id', _id);
    _doAjaxNod('POST', data, 'user_address', 'idx', 'detail', true, (res) => {
        $('#id').val(res.data.id);
        $('#fullname').val(res.data.fullname);
        $('#phone').val(res.data.mobile);
        if (res.data.is_default == 1) {
            $('#is_default').prop('checked', true);
        }
    })
});

$('body').on('click', '#deleteAddress', function(e) {
    let _id = $(this).attr('address-id');
    BootstrapDialog.show({
        title: "Xác nhận",
        message: `Bạn chắc chắn muốn xóa địa chỉ này?`,
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
                thePage.funcsDelete(_id);
                dialogItself.close();
            }
        }]
    });
});

thePage.funcsDelete = (_id) => {
    let data = new FormData();
    data.append('id', _id);
    _doAjaxNod('POST', data, 'user_address', 'delete', 'delete', false, (res) => {
        thePage.getListAddress();
    });
}

function loadDistrict() { // onchange district theo city tạo showroom mới
    var _city_id = $("#province").val();

    let data = new FormData();
    data.append('city_id', _city_id);
    _doAjaxNod('POST', data, 'user_address', 'idx', 'opt_district', false, (res) => {
        $("#district").html(res.data);
        loadWard();
    });
}

function loadWard() { // onchange district theo city tạo showroom mới

    var _district_id = $("#district").val();

    let data = new FormData();
    data.append('district_id', _district_id);
    _doAjaxNod('POST', data, 'user_address', 'idx', 'opt_ward', false, (res) => {
        $("#ward").html(res.data);
    });
}