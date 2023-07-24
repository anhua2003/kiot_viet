var thePage = {}

$(document).on('submit', '#login_action', function (e) {
    e.preventDefault();
    thePage.funcsSave();
});

thePage.funcsSave = () => {
    let email = $('#email').val();
    let password = $('#password').val();
    let formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
    _doAjaxNod('POST', formData, 'login', 'save', 'save', true, (res) => {
        if (res.status == 200) {
            alert_void(res.message, 1);
            setTimeout(function() {
                location.href = "/trang-chu";
                // location.reload();
            }, 1000);
        } else {
            alert('1');
        }
    });
}