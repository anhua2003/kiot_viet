var thePage = {};

$(document).on('click', '#sign', function() {
    let formData = new FormData(document.getElementById('sign_form'));
    _doAjaxNod("POST", formData, "home", "sign", "sign", true, (res) => {
        if(res.status == 200)
        {
            alert(res.message);
            setTimeout(function() {
                location.href = "/admin";
            }, 1000);
        }
    })
})