var thePage = {};

$(function() {

    // thePage.filter();

})

$('body').on('click', '#add_cart', function() {
    var _product_id = $(this).attr('product_id');
    var _quantity = parseFloat($("#quantity").val());
    var _title = $("#title").val();
    var _price = $("#price").val();
    var _unique_id = $("#unique_id").val();
    var _decrement = $("#decrement").val();
    var _link_img = $("#link_img").val();
    var listItemCart = getLocalStorage(keyLocalStorageItemCart);

    var existItemCart = false; //đã tồn tại sản phẩm trong giỏ hàng chưa. mặc định là chưa.
    if (listItemCart != null) { //check giỏ hàng có sản phẩm chưa
        var index = listItemCart.findIndex(function(item) {
            return item.product_id == _product_id;
        });
        if (index > -1) {
            listItemCart[index].quantity = parseFloat(listItemCart[index].quantity) + _quantity;
            saveLocalStorage(keyLocalStorageItemCart, listItemCart);
            existItemCart = true;
        }
    }

    // nếu sản phẩm không tồn tại trong giỏ hàng -> tạo đối tượng thêm vào giỏ hàng
    if (existItemCart == false) {
        var itemCart = created_cart(_product_id, _quantity, _title, _price, _decrement, _unique_id, _link_img);
        if (listItemCart == null) {
            listItemCart = [];
        }
        listItemCart.push(itemCart);
        saveLocalStorage(keyLocalStorageItemCart, listItemCart);
    }
    countItemCart();
});

$('body').on('click', '#buy_now', function() {
    var _product_id = $(this).attr('product_id');
    var _quantity = parseFloat($("#quantity").val());
    var _title = $("#title").val();
    var _price = $("#price").val();
    var _unique_id = $("#unique_id").val();
    var _decrement = $("#decrement").val();
    var _link_img = $("#link_img").val();
    var listItemCart = getLocalStorage(keyLocalStorageItemCart);

    var existItemCart = false; //đã tồn tại sản phẩm trong giỏ hàng chưa. mặc định là chưa.
    if (listItemCart != null) { //check giỏ hàng có sản phẩm chưa
        var index = listItemCart.findIndex(function(item) {
            return item.product_id == _product_id;
        });
        if (index > -1) {
            listItemCart[index].quantity = parseFloat(listItemCart[index].quantity) + _quantity;
            saveLocalStorage(keyLocalStorageItemCart, listItemCart);
            existItemCart = true;
        }
    }

    // nếu sản phẩm không tồn tại trong giỏ hàng -> tạo đối tượng thêm vào giỏ hàng
    if (existItemCart == false) {
        var itemCart = created_cart(_product_id, _quantity, _title, _price, _decrement, _unique_id, _link_img);
        if (listItemCart == null) {
            listItemCart = [];
        }
        listItemCart.push(itemCart);
        saveLocalStorage(keyLocalStorageItemCart, listItemCart);
    }

    window.location = url_domain + '/gio-hang';

});

// btn chia sẻ
var body = document.getElementsByTagName('body')[0];
var btnCopy = document.getElementById('btnCopy');
var link = $('#link').val();

var copyToClipboard = function(link) {
    var tempInput = document.createElement('INPUT');
    body.appendChild(tempInput);
    tempInput.setAttribute('value', link)
    tempInput.select();
    document.execCommand('copy');
    body.removeChild(tempInput);
}

$('body').on('click', '#btnCopy', function(e) {
    // e.preventDefault();
    copyToClipboard(link);
    alert_dialog("Đã copy thành công!");
    return false;
});