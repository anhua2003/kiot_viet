var thePage = {};

$(function () {

})

$('body').on('click', '#btn_update_info', function(e) {
    thePage.funcsSave();
});

thePage.funcsSave = () => {

    let _oldPass = $("#infoOldPass");
    let _newPass = $('#infoNewPass');
    let _reNewPass = $('#infoReNewPass');

    let status_error = false;
    $(".err-modify-tv").remove();

    if (_oldPass.val() == '') {
        _oldPass.after(`<span class="err-modify-tv color-red">Vui lòng nhập mật khẩu cũ.</span>`);
        status_error = true;
    }
    if (_newPass.val() == '') {
        _newPass.after(`<span class="err-modify-tv color-red">Vui lòng nhập mật khẩu mới.</span>`);
        status_error = true;
    }
    if (_reNewPass.val() == '') {
        _reNewPass.after(`<span class="err-modify-tv color-red">Vui lòng nhập lại mật khẩu mới.</span>`);
        status_error = true;
    }
    if (_newPass.val() != _reNewPass.val()) {
        _reNewPass.after(`<span class="err-modify-tv color-red">Mật khẩu không trùng khớp.</span>`);
        status_error = true;
    }

    if (status_error) {
        return false;
    } else {
        let data = new FormData();
        data.append('oldPass', _oldPass.val());
        data.append('newPass', _newPass.val());
        data.append('reNewPass', _reNewPass.val());

        _doAjaxNodCustomClient('POST', data, 'client_change_password', 'update', 'change_password', true, (res) => {
            if (res.status == 200) {
                _oldPass.val('');
                _newPass.val('');
                _reNewPass.val('');
                $("#noti_change_password").html('Cập nhật thành công.');
                $("#noti_change_password").removeClass('hide');
                $("#noti_change_password").addClass('color-green');
            } else {
                $("#noti_change_password").html(res.message);
                $("#noti_change_password").removeClass('hide');
                $("#noti_change_password").addClass('color-red');
                return false;
            }
        })
    }

}