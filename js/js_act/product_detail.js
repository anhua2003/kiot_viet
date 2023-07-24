var thePage = {};

$(function () {

    // thePage.filter();
})
var selected_array = [];
$('.input-select').each(function () {
    var select_id = $(this).attr('id');
    var select_value = $(this).val();
    if (select_value != 0) {
        selected_array.push({ select_id: select_id,value: select_value });
    }
    $(this).change(function () {
        let selected = $(this).val();
        let select_id = $(this).attr('id');
        $('#' + select_id + ' option:selected').prop('selected', false);
        $(this).find('option:selected').prop('selected', true);
        if ($(this).find('option:selected').length > 0) {
            var index = selected_array.findIndex(x => x.select_id === select_id);
            if (index === -1) {
                selected_array.push({ select_id: select_id,value: selected });
            } else {
                selected_array[index].value = selected;
            }
            $(this).val(selected); // Gán lại giá trị đã chọn cho select box
        } else {
            $(this).val(0); // Gán giá trị mặc định cho select box khi không có giá trị nào được chọn
        }
        console.log(selected_array);
    });
});
// $('.input-select').change(function() {
//     let selected = $(this).val();
//     let select_id = $(this).attr('id');
//     $('#' + select_id + ' option:selected').prop('selected', false);
//    $(this).find('option:selected').prop('selected', true);
//    if ($(this).find('option:selected').length > 0) {
//       var index = selected_array.findIndex(x => x.select_id === select_id);
//       if (index === -1) {
//          selected_array.push({select_id: select_id, value: selected});
//       } else {
//          selected_array[index].value = selected;
//       }
//    }
//    console.log(selected_array);
// })
$(document).on('click', '.add-to-cart-btn', function () {
    let product_id = $(this).data("product-id");
    let title = $(this).data("title");
    let price = $(this).data("price");
    let category = $(this).data("category");
    let sale = $(this).data("sale");
    let img = '';
    const hasNoSelect2 = selected_array.every(item => item.select_id !== 'select-2');
    const selectedItem = selected_array.find(item => item.select_id === 'select-2');
    if(selected_array.length == 0 || hasNoSelect2)
    {
        img = $(this).data("img");
    } else {
        let newImg = selectedItem.value.split('-');
        img = 'http://demo.local/public/img/products/'+category+'/'+product_id+'/'+newImg[0]+'.jpg';
    }
    let unquid = $("#user_id").val();
    let quantity = $("#quantity_number").val() ? $("#quantity_number").val() : 1;
    // removeDataLocalStorage(keyLocalStorageItemCart);

    if (unquid == 'none') {
        alert("Vui lòng đăng nhập");
    } else {
        var listItemCart = getLocalStorage(keyLocalStorageItemCart);
        var existItemCart = false; //đã tồn tại sản phẩm trong giỏ hàng chưa. mặc định là chưa.
        if (listItemCart != null) { //check giỏ hàng có sản phẩm chưa
            var index = listItemCart.findIndex(function (item) {
                return item.product_id == product_id && item.unique_id == unquid && JSON.stringify(item.prop_id) == JSON.stringify(selected_array);
            });
            if (index > -1) {
                if(listItemCart[index].unique_id == unquid)
                {
                    if(JSON.stringify(listItemCart[index].prop_id) == JSON.stringify(selected_array))
                    {
                        console.log(JSON.stringify(listItemCart[index].prop_id));
                        listItemCart[index].quantity = parseFloat(listItemCart[index].quantity) + parseFloat(quantity);
                        saveLocalStorage(keyLocalStorageItemCart, listItemCart);
                        existItemCart = true;
                    } else {
                        console.log(JSON.stringify(listItemCart[index].prop_id));
                    }
                }
            }
        }
        // nếu sản phẩm không tồn tại trong giỏ hàng -> tạo đối tượng thêm vào giỏ hàng
        if (existItemCart == false) {
            var itemCart = created_cart(product_id, quantity, title, price, sale, unquid, img, selected_array);
            if (listItemCart == null) {
                listItemCart = [];
            }
            listItemCart.push(itemCart);
            saveLocalStorage(keyLocalStorageItemCart, listItemCart)
        }
        console.log(listItemCart);
        countItemCart(unquid);
        countSelect(unquid);
    }

    
})



