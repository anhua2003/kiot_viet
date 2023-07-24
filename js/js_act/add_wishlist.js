var wishlist = {}

wishlist.user_id = $("#user_id");

wishlist.show = $("#m_wishlist");

wishlist.qty = $("#qty_wishlist");

$(document).on('click', '.add-to-wishlist', function() {
    if(wishlist.user_id.val() == 'none')
    {
        alert("Bạn cần đăng nhập để tiếp tục");
    } else {
        wishlist.add_wishlist($(this).data("product-id"));
        $(this).toggleClass("add-to-wishlist remove-to-wishlist");
        $(this).find("i").toggleClass("fa-heart-o fa-heart");
        $(this).find(".tooltipp").html("remove to wishlist");
    }
})

$(document).on('click', '.remove-to-wishlist', function() {
    $(this).toggleClass("remove-to-wishlist add-to-wishlist");
    $(this).find("i").toggleClass("fa-heart fa-heart-o");
    $(this).find(".tooltipp").html("add to wishlist");
    wishlist.remove_wishlist($(this).data("product-id"));
});

$('#m_wishlist').on('click', '#del_wishlist', function() {
    let id_product = $(this).data("product-id");
    wishlist.remove_wishlist(id_product);
})
wishlist.add_wishlist = (id_product) => {
    let formData = new FormData();
    formData.append("id_product", id_product);
    formData.append("user_id", wishlist.user_id.val());
    _doAjaxNod("POST", formData, "add_wishlist", "add", "add", true, (res) => {
        if(res.status == 200)
        {
            wishlist.render(res.data);
        }
    })
}

wishlist.remove_wishlist = (id_product) => {
    let formData = new FormData();
    formData.append("id_product", id_product);
    formData.append("user_id", wishlist.user_id.val());
    _doAjaxNod("POST", formData, "add_wishlist", "add", "remove", true, (res)=> {
        if(res.status == 200)
        {
            wishlist.render(res.data);
        }
    })
}

wishlist.render = (myWishlist) => {
    let html = '';
    if(myWishlist.length == 0)
    {
        html = 'Không có sản phẩm nào';
    } else {
        myWishlist.forEach(function(item) {
            html += `<div class="product-widget">
            <div class="product-img">
                <img src="${item.img[0]}" alt="">
            </div>
            <div class="product-body">
                <h3 class="product-name"><a href="/detail/${item.id_product}/${item.name}">${item.name}</a></h3>
                <h4 class="product-price">${number_format(item.price)}đ</h4>
            </div>
            <button class="delete" id="del_wishlist" data-product-id="${item.id_product}">x</button>
        </div>`;
        });
    }
    wishlist.qty.html(myWishlist.length);
    wishlist.show.html(html);
}