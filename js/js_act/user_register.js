var thePage = {};

$(function() {

})

$('body').on('click', '#btn_submit', function(e) {
    thePage.funcsSave();
});

thePage.funcsSave = () => {

    let _referral_by = $('#referral_by');
    let _see_name = $('#see_name');
    let _see_phone = $('#see_phone');
    let _see_email = $('#see_email');
    let _form_password = $('#form_password');
    let _form_re_password = $('#form_re_password');

    var mobile = _see_phone.val().replace(/ +/g, "");

    let status_error = false;
    $(".err-modify-tv").remove();

    if (_see_name.val() == '') {
        _see_name.after(`<span class="err-modify-tv color-red">Vui lòng nhập Họ và Tên.</span>`);
        status_error = true;
    }
    if (_see_email.val() != '' && emailIsValid(_see_email.val()) == false) {
        _see_email.after(`<span class="err-modify-tv color-red">Email không đúng định dạng.</span>`);
        status_error = true;
    }
    if (mobile == '') {
        _see_phone.after(`<span class="err-modify-tv color-red">Vui lòng nhập số điện thoại.</span>`);
        status_error = true;
    }
    if (mobile != '' && mobileIsValid(mobile) == false) {
        _see_phone.after(`<span class="err-modify-tv color-red">Số điện thoại không đúng định dạng.</span>`);
        status_error = true;
    }
    if (_form_password.val() == '') {
        _form_password.after(`<span class="err-modify-tv color-red">Vui lòng nhập mật khẩu.</span>`);
        status_error = true;
    }
    if (_form_re_password.val() == '' || _form_password.val() != _form_re_password.val()) {
        _form_re_password.after(`<span class="err-modify-tv color-red">Xác nhận mật khẩu không đúng.</span>`);
        status_error = true;
    }

    if (status_error) {
        return false;
    } else {
        let data = new FormData();
        data.append('fullname', _see_name.val());
        data.append('email', _see_email.val());
        data.append('mobile', _see_phone.val());
        data.append('password', _form_password.val());
        data.append('referral_by', _referral_by.val());
        _doAjaxNod('POST', data, 'user_register', 'save', 'save', true, (res) => {
            if (res.status == 200) {
                alert_void(res.message, 1);
                setTimeout(function() {
                    location.href = "/dang-nhap";
                }, 1000);
            }
        })
    }

}