var thePage = {}

$.validator.addMethod("noNumberOrSpecialChar", function(value, element) {
    return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);
  }, "Please enter only letters and spaces");
$('#form_checkout').validate({
    rules:{
        name:{
            required:true,
            noNumberOrSpecialChar: true
        },
        telephone:{
            required:true,
            minlength: 10,
            maxlength: 10,
            digits: true
        },
        email:{
            required: true,
            email: true
        },
        address:{
            required: true
        },
        city:{
            required: true
        },
        country:{
            required: true
        },
    }
})

$(document).on('click', '.order-submit', function() {
    if($("#form_checkout").valid()){
        let localStorage = getLocalStorage(keyLocalStorageItemCart);
        let list_cart = localStorage.filter(function(item) {
            return item.unique_id == $("#user_id").val();
        })
        let data = new FormData(document.getElementById("form_checkout"));
        data.append("unique_id", $("#user_id").val());
        list_cart.forEach(function(item) {
            data.append('list_cart[]', JSON.stringify(item));
        })
        _doAjaxNod("POST", data, "checkout", "save", "save", true, (res)=>{
            if(res.status == 200)
            {
                removeLocalStorageAll_id($("#user_id").val());
                swal({
                    title: "Success",
                    text: "Order Success",
                    icon: "success"
                }).then(response=>{
                    if(response)
                    {
                        location.href = "/trang-chu";
                    }
                })
            }
        })
    }
    
})