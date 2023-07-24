var thePage = {};

// thePage.fullname = $("#infoFullname");
// thePage.email = $("#infoEmail");
// thePage.mobile = $("#infoMobile");
// thePage.content = $("#infoContent");

$(function() {

});

$('#contact_form').validate({
    rules:{
        name:{
            required:true,
        },
        email:{
            required: true,
            email: true
        },
        message:{
            required: true
        }
    }
})

$(document).on('click', '#send', function(e) {
    e.preventDefault();
    if($("#contact_form").valid())
    {
        let formData = new FormData(document.getElementById('contact_form'));
        _doAjaxNod("POST", formData, "home", "contact", "send", true, (res) => {
            if(res.status == 200)
            {
                swal({
                    title: "Success",
                    text: "Thanks for your contact",
                    icon: "success",
                })
            }
        })
    }
})
// $('body').on('click', '#submitInfo', function(e) {

//     let status_error = false;
//     $(".err-modify-tv").remove();

//     var mobile = thePage.mobile.val().replace(/ +/g, "");

//     if (thePage.fullname.val() == '') {
//         thePage.fullname.after(`<span class="err-modify-tv color-red">Vui lòng nhập Họ và Tên.</span>`);
//         status_error = true;
//     }
//     if (thePage.email.val() != '' && emailIsValid(thePage.email.val()) == false) {
//         thePage.email.after(`<span class="err-modify-tv color-red">Email không đúng định dạng.</span>`);
//         status_error = true;
//     }
//     if (mobile == '') {
//         thePage.mobile.after(`<span class="err-modify-tv color-red">Vui lòng nhập số điện thoại.</span>`);
//         status_error = true;
//     }
//     if (mobile != '' && mobileIsValid(mobile) == false) {
//         thePage.mobile.after(`<span class="err-modify-tv color-red">Số điện thoại không đúng định dạng.</span>`);
//         status_error = true;
//     }
//     if (thePage.content.val() == '') {
//         thePage.content.after(`<span class="err-modify-tv color-red">Nội dung không được để trống.</span>`);
//         status_error = true;
//     }

//     if (status_error) {
//         return false;
//     } else {
//         var data = new FormData();
//         data.append('fullname', thePage.fullname.val());
//         data.append('mobile', mobile);
//         data.append('email', thePage.email.val());
//         data.append('content', thePage.content.val());
        
//         _doAjaxNodCustom('POST', data, 'home_contact', 'save', 'save', true, (res) => {
//             if(res.status!=200){
//                 $("#error_contact").html(res.message);
//                 $("#error_contact").addClass('color-red');
//                 $("#error_contact").removeClass('hide');
//             }else{
//                 $("#error_contact").html('Đã gửi thông tin thành công. Chúng tôi sẽ sớm liên hệ với bạn.');
//                 $("#error_contact").addClass('color-green');
//                 $("#error_contact").removeClass('hide');
//             }
//         });
//     }

// });