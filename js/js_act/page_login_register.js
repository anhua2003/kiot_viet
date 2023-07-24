var thisPage = {};
$(function () {
    var account_client = localStorage.getItem('accountClient');
    if (account_client && account_client != '') {
        $("#username").val(account_client);
        $('#remember').prop('checked',true);
    }
    $('#remember').change(function(){
        if ($('#remember').is(':checked')) {
            $('#remember').prop('checked',true);
        }else{
            $('#remember').prop('checked',false);
        }
    })
})

//tạo tài khoản mới
$('body').on('click', '#btn_register', function () {
    let status_error = false;
    $(".err-modify-tv").remove();

    if ($("#referral").val() == '') {
        $("#referral").after(`<span class="err-modify-tv color-red">* Vui lòng nhập tên tài khoản.</span>`);
        status_error = true;
    }
    if ($("#fullname").val() == '') {
        $("#fullname").after(`<span class="err-modify-tv color-red">* Vui lòng nhập Họ và Tên.</span>`);
        status_error = true;
    }
    if ($("#email").val() == '') {
        $("#email").after(`<span class="err-modify-tv color-red">* Vui lòng nhập email.</span>`);
        status_error = true;
    }
    if ($("#mobile").val() == '') {
        $("#mobile").after(`<span class="err-modify-tv color-red">* Vui lòng nhập số điện thoại.</span>`);
        status_error = true;
    }
    if ($("#pass").val() == '') {
        $("#pass").after(`<span class="err-modify-tv color-red">* Vui lòng nhập mật khẩu.</span>`);
        status_error = true;
    }
    if ($("#repassword").val() == '') {
        $("#repassword").after(`<span class="err-modify-tv color-red">* Vui lòng nhập lại mật khẩu.</span>`);
        status_error = true;
    }
    if ($("#repassword").val() != $("#pass").val()) {
        $("#repassword").after(`<span class="err-modify-tv color-red">Mật khẩu không trùng khớp.</span>`);
        status_error = true;
    }

    if (status_error) return false;

    var data = new FormData();
    data.append('fullname', $("#fullname").val());
    data.append('email', $("#email").val());
    data.append('mobile', $("#mobile").val());
    data.append('password', $("#pass").val());
    _doAjaxNodCustom('POST', data, 'page_login_register', 'register', 'register', true, (res) => {
        // console.log(res);
        if (res.status == 200) {
            window.location = domain;
        } else {
            $("#error_register").html(res.message);
            $("#error_register").removeClass('hide');
            return false;
        }
    })

});

//đăng nhập
$('body').on('click', '#btn_login', function () {
    let status_error = false;
    $(".err-modify-tv").remove();

    if ($("#username").val() == '') {
        $("#username").after(`<span class="err-modify-tv color-red"> * Vui lòng nhập email hoặc số điện thoại.</span>`);
        status_error = true;
    }
    if ($("#password").val() == '') {
        $("#password").after(`<span class="err-modify-tv color-red"> * Vui lòng nhập mật khẩu.</span>`);
        status_error = true;
    }
    
    if (status_error) return false;

    var data = new FormData();

    data.append('username', $("#username").val());
    data.append('password', $("#password").val());
    _doAjaxNodCustom('POST', data, 'page_login_register', 'login', 'login', true, (res) => {
        // console.log(res);
        if (res.status == 200) {
            window.location = domain + '/trang-chu';
            localStorage.clear();
            if ($('#remember').is(':checked')) {
                localStorage.setItem('accountClient', $("#username").val());
            }
        } else {
            $("#error_login").html(res.message);
            $("#error_login").removeClass('hide');
            return false;
        }
    })

});


