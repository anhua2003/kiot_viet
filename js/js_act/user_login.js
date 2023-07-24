var thePage = {};

$(function() {

})

$('body').on('click', '#btn_submit', function(e) {
    thePage.funcsLogin();
});

thePage.funcsLogin = () => {

    let _username = $('#username');
    let _password = $('#password');

    let status_error = false;
    $(".err-modify-tv").remove();

    if (_username.val() == '') {
        _username.after(`<span class="err-modify-tv color-red">Vui lòng nhập thông tin đăng nhập.</span>`);
        status_error = true;
    }
    if (_password.val() == '') {
        _password.after(`<span class="err-modify-tv color-red">Vui lòng nhập mật khẩu.</span>`);
        status_error = true;
    }

    if (status_error) {
        return false;
    } else {
        let data = new FormData();
        data.append('username', _username.val());
        data.append('password', _password.val());
        _doAjaxNod('POST', data, 'user_login', 'login', 'login', true, (res) => {
            if (res.status == 200) {
                location.href = "/trang-chu";
            }
        })
    }

}