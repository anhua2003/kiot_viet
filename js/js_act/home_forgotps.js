var thePage = {}

$(document).on('submit', '#forgotps_form', function(e) {
    e.preventDefault();
    thePage.funcsSave();
})

thePage.funcsSave = () => {
    let email = $("#email").val();
    let formData = new FormData();
    formData.append("email", email);
    _doAjaxNod("POST", formData, "forgot_ps", "save", "save", true, (res) => {
        if(res.status == 200)
        {
            alert_void(res.message, 1);
            setTimeout(function () {
                location.href = "/dang-nhap";
            }, 1000);
        }
    })
}