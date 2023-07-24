var thePage = {};

$(function () {

    $("#infoBirthday").datepicker({
        dateFormat: "dd/mm/yy"
    });

    $(".form-info").prop("disabled", true);
    $("#btn_update_info").click(function () {
        if ($("#btn_update_info").html() == 'Lưu thay đổi') {
            thePage.funcsSave();
        } else {
            $(".form-info").prop("disabled", false);
            $("#btn_update_info").html("Lưu thay đổi");
        }
    });

    // thePage.getInfo();

})

// thePage.getInfo = () => {

//     _doAjaxNodClient('POST', '', 'client_profile', 'idx', 'info', true, (res) => {
//         $('#fullname').val(res.data.fullname);
//         $('#email').val(res.data.email);
//         $('#mobile').val(res.data.mobile);
//         $('#birthday').val(res.data.day != '' && res.data.day != '0' ? res.data.day + '/' + res.data.month + '/' + res.data.year : "");
//         if (res.data.sex == 0) {
//             $("#female").prop("checked", true);
//         } else {
//             $("#male").prop("checked", true);
//         }
//     })
// }

thePage.funcsSave = () => {

    let _fullname = $("#infoFullname");
    let _mobile = $('#infoMobile');
    let _email = $('#infoEmail');
    let _birthday = $('#infoBirthday');
    let _address = $('#infoAddress');
    // let _oldPass = $('#oldPass');
    // let _newPass = $('#newPass');
    // let _confirmPass = $('#confirmPass');
    var _sex = $("input[name='radio_gt']:checked").val();

    var mobile = _mobile.val().replace(/ +/g, "");

    let status_error = false;
    $(".err-modify-tv").remove();

    if (_fullname == '') {
        _fullname.after(`<span class="err-modify-tv color-red">Vui lòng nhập Họ và Tên.</span>`);
        status_error = true;
    }
    if (_email.val() != '' && emailIsValid(_email.val()) == false) {
        _email.after(`<span class="err-modify-tv color-red">Email không đúng định dạng.</span>`);
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
    // if (_birthday.val() == '') {
    //     _birthday.after(`<span class="err-modify-tv color-red">Vui lòng nhập ngày sinh.</span>`);
    //     status_error = true;
    // }
    // if (_address.val() == '') {
    //     _address.after(`<span class="err-modify-tv color-red">Vui lòng nhập địa chỉ.</span>`);
    //     status_error = true;
    // }

    if (status_error) {
        return false;
    } else {
        let data = new FormData();
        data.append('fullname', _fullname.val());
        data.append('email', _email.val());
        data.append('mobile', _mobile.val());
        data.append('birthday', _birthday.val());
        data.append('address', _address.val());
        data.append('sex', _sex);

        _doAjaxNodCustomClient('POST', data, 'client_profile', 'update', 'info', true, (res) => {
            if (res.status == 200) {
                $(".form-info").prop("disabled", true);
                $("#btn_update_info").html("Cập nhật");
                $("#error_info").removeClass('hide');
                $("#error_info").addClass('color-green');
                $("#error_info").html(`Cập nhật thành công.`);
                setTimeout(()=>{
                    $("#error_info").html('');
                },3000)
            } else {
                $("#error_info").html(res.message);
                $("#error_info").addClass('color-red');
                $("#error_info").removeClass('hide');
                return false;
            }
        })
    }

}

// var body = document.getElementsByTagName('body')[0];
// var btnCopy = document.getElementById('btnCopy');
// var link = $('#link').val();

// var copyToClipboard = function(link) {
//     var tempInput = document.createElement('INPUT');
//     body.appendChild(tempInput);
//     tempInput.setAttribute('value', link)
//     tempInput.select();
//     document.execCommand('copy');
//     body.removeChild(tempInput);
// }

// $('body').on('click', '#btnCopy', function(e) {
//     // e.preventDefault();
//     copyToClipboard(link);
//     alert_void("Đã copy thành công!", 1);
//     return false;
// });