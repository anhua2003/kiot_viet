var thePage = {}

var selectedCategories = [];
var listAll1 = $("#show_product_list").html();
var listAll2 = $(".list_product2").html();
var unique_id = $("#user_id").val();
var pagination = $(".store-pagination").html();

if($("#key").val() == '')
{
    history.pushState(null, null, "/san-pham");
}


$('.filter_category').change(function() {
  let arr = $("#wishlist_arr").val();
  let wishlist = arr.split(",");
  var category = $(this).val();
  if ($(this).is(':checked')) {
    selectedCategories.push(category);
  } else {
    var index = selectedCategories.indexOf(category);
    if (index !== -1) {
      selectedCategories.splice(index, 1);
    }
  }

  
  let formData = new FormData();
  formData.append('category_list', selectedCategories);
  if(selectedCategories.length != 0)
  {
    let newUrl = window.location.pathname + "?filter=" + selectedCategories.join("-") ;
      window.history.pushState({ path: newUrl }, "", newUrl);
    _doAjaxNod('POST', formData, 'filter_product', 'save', 'save', true, (res) => {
        if (res.status == 200) {
            console.log(res.data);
            let filter = res.data;
            let html1 = '';
            let html2 = '';
            filter.forEach(function(item) {
                if(item.sale != 0)
                {
                    sale = '<span class="sale">-'+item.sale+'%</span>';
                    price = '<h4 class="product-price">'+number_format(item.price*(100-item.sale)/100)+'đ <del class="product-old-price">'+number_format(item.price)+'đ</del></h4>';
                } else {
                    sale = '';
                    price = '<h4 class="product-price">'+number_format(item.price)+'đ</h4>';
                }
                if(item.name.length > 10)
                {
                    name = item.name.substr(0,18)+'...';
                } else {
                    name = item.name
                }
                if(wishlist.includes(item.id_product))
                {
                    wishlistBtn = '<button class="remove-to-wishlist" data-product-id="'+item.id_product+'"><i class="fa fa-heart"></i><span class="tooltipp">remove to wishlist</span></button>';
                } else {
                    wishlistBtn = '<button class="add-to-wishlist" data-product-id="'+item.id_product+'"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>';
                }
                html1 += `<!-- product -->
                <div class="col-md-4 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="${item.img[0]}" alt="">
                            <div class="product-label">
                                ${sale}
                                <span class="new">NEW</span>
                            </div>
                        </div>
                        <div class="product-body">
                            <p class="product-category">${item.category_name}</p>
                            <h3 class="product-name"><a href="/detail/${item.id_product}/${item.name}">${name}</a></h3>
                            ${price}
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-btns">
                                ${wishlistBtn}
                                <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                <button class="quick-view" data-product-id="${item.id_product}"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /product -->
                `
                html2 += `<div class="product-widget">
                <div class="product-img">
                    <img src="${item.img[0]}" alt="">
                </div>
                <div class="product-body">
                    <p class="product-category">${item.category_name}</p>
                    <h3 class="product-name"><a href="/detail/${item.id_product}/${item.name}">${item.name}</a></h3>
                    ${price}
                </div>
            </div>`
            })
            $(".store-pagination").html('')
            $("#show_product_list").html(html1);
            $(".list_product2").html(html2);
            // alert_void(res.message, 1);
            // setTimeout(function() {
            //     location.href = "/trang-chu";
            //     // location.reload();
            // }, 1000);
        } else {
            alert('1');
        }
    });
  } else {
    let newUrl = window.location.pathname;
      window.history.pushState({ path: newUrl }, "", newUrl);
    $(".store-pagination").html(pagination)
    $("#show_product_list").html(listAll1);
    $(".list_product2").html(listAll2);
  }
});



function paging_ajax(page) {
    let arr = $("#wishlist_arr").val();
    let wishlist = arr.split(",");
    if (page != "undefined") {
      let newUrl = window.location.pathname + "?page=" + page;
      window.history.pushState({ path: newUrl }, "", newUrl);
    }
    let data = new FormData();
    let limit = 6;
    let key = $("#key").val();
    data.append("page", page);
    data.append("limit", limit);
    data.append("key", key);
    _doAjaxNod(
      "POST",
      data,
      "filter_product",
      "save",
      "pagination",
      true,
      (res) => {
        if(res.status == 200) {
            let filter = res.data;
            let html1 = '';
            let html2 = '';
            filter.forEach(function(item) {
                if(item.sale != 0)
                {
                    sale = '<span class="sale">-'+item.sale+'%</span>';
                    price = '<h4 class="product-price">'+number_format(item.price*(100-item.sale)/100)+'đ <del class="product-old-price">'+number_format(item.price)+'đ</del></h4>';
                } else {
                    sale = '';
                    price = '<h4 class="product-price">'+number_format(item.price)+'đ</h4>';
                }
                if(item.name.length > 10)
                {
                    name = item.name.substr(0,18)+'...';
                } else {
                    name = item.name
                }
                if(wishlist.includes(item.id_product))
                {
                    wishlistBtn = '<button class="remove-to-wishlist" data-product-id="'+item.id_product+'"><i class="fa fa-heart"></i><span class="tooltipp">remove to wishlist</span></button>';
                } else {
                    wishlistBtn = '<button class="add-to-wishlist" data-product-id="'+item.id_product+'"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>';
                }
                html1 += `<!-- product -->
                <div class="col-md-4 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="${item.img[0]}" alt="">
                            <div class="product-label">
                                ${sale}
                                <span class="new">NEW</span>
                            </div>
                        </div>
                        <div class="product-body">
                            <p class="product-category">${item.category_name}</p>
                            <h3 class="product-name"><a href="/detail/${item.id_product}/${item.name}">${name}</a></h3>
                            ${price}
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-btns">
                                ${wishlistBtn}
                                <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                <button class="quick-view" data-product-id="${item.id_product}"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /product -->
                `
                html2 += `<div class="product-widget">
                <div class="product-img">
                    <img src="${item.img[0]}" alt="">
                </div>
                <div class="product-body">
                    <p class="product-category">${item.category_name}</p>
                    <h3 class="product-name"><a href="/detail/${item.id_product}/${item.name}">${item.name}</a></h3>
                    ${price}
                </div>
            </div>`
            })
            $("#show_product_list").html(html1);
            $(".list_product2").html(html2);
        }
      }
    );
}
// $(document).on('click', '.demtrang', function() {
//     alert("Hello");
// })

$(document).on('click', '#filter-btn', function() {
    let arr = $("#wishlist_arr").val();
    let wishlist = arr.split(",");
    let price_min = $("#price-min").val();
    let price_max = $("#price-max").val();
    let formData = new FormData();
    formData.append('price_min', price_min);
    formData.append('price_max', price_max);
    _doAjaxNod("POST", formData, "filter_product", "save", "price", true, (res) => {
        let filter = res.data;
            let html1 = '';
            let html2 = '';
            filter.forEach(function(item) {
                if(item.sale != 0)
                {
                    sale = '<span class="sale">-'+item.sale+'%</span>';
                    price = '<h4 class="product-price">'+number_format(item.price*(100-item.sale)/100)+'đ <del class="product-old-price">'+number_format(item.price)+'đ</del></h4>';
                } else {
                    sale = '';
                    price = '<h4 class="product-price">'+number_format(item.price)+'đ</h4>';
                }
                if(item.name.length > 10)
                {
                    name = item.name.substr(0,18)+'...';
                } else {
                    name = item.name
                }
                if(wishlist.includes(item.id_product))
                {
                    wishlistBtn = '<button class="remove-to-wishlist" data-product-id="'+item.id_product+'"><i class="fa fa-heart"></i><span class="tooltipp">remove to wishlist</span></button>';
                } else {
                    wishlistBtn = '<button class="add-to-wishlist" data-product-id="'+item.id_product+'"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>';
                }
                html1 += `<!-- product -->
                <div class="col-md-4 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="${item.img[0]}" alt="">
                            <div class="product-label">
                                ${sale}
                                <span class="new">NEW</span>
                            </div>
                        </div>
                        <div class="product-body">
                            <p class="product-category">${item.category_name}</p>
                            <h3 class="product-name"><a href="/detail/${item.id_product}/${item.name}">${name}</a></h3>
                            ${price}
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-btns">
                                ${wishlistBtn}
                                <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                <button class="quick-view" data-product-id="${item.id_product}"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /product -->
                `
                html2 += `<div class="product-widget">
                <div class="product-img">
                    <img src="${item.img[0]}" alt="">
                </div>
                <div class="product-body">
                    <p class="product-category">${item.category_name}</p>
                    <h3 class="product-name"><a href="/detail/${item.id_product}/${item.name}">${item.name}</a></h3>
                    ${price}
                </div>
            </div>`
            })
            $(".store-pagination").html('')
            $("#show_product_list").html(html1);
            $(".list_product2").html(html2);
    })
})
