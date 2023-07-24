var thePage = {}

$(document).on('submit', '#register_form_act', function (e) {
    e.preventDefault();
    thePage.funcsSave();
});

thePage.funcsSave = () => {
    let username = "user";
    let email = $('#email').val();
    let password = $('#password').val();
    let confirmpassword = $('#confirmpassword').val();
    let formData = new FormData();
    formData.append('username', username);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('confirmpassword', confirmpassword);
    _doAjaxNod('POST', formData, 'register', 'save', 'save', true, (res) => {
        if (res.status == 200) {
            alert_void(res.message, 1);
            setTimeout(function() {
                location.href = "/dang-nhap";
            }, 1000);
        }
    });
}