if ($('.flexslider').length > 0) {
    $('.flexslider').flexslider({
        animation: "slide",
        slideshow: true,
        controlNav: false,
        directionNav: true,
        slideshowSpeed: 5000,
        animationSpeed: 1000,
        pauseOnHover: true,
        start: function(slider) {
            $('body').removeClass('loading');
        }
    });
}

$('body').on('click', '.icon-cate-mobi', function(e) {
    $('.category-product-mobile').toggleClass('active');
    $('.menu-top').hide();
});
$('body').on('click', '.icon-menu-mobi', function(e) {
    $('.menu-top').slideToggle();
    $('.header-slider .left').removeClass('active');
});
$('body').on('click', '.advanced-click li', function(e) {
    $(this).toggleClass('active');
});
$('body').on('click', '.bankdefault li', function(e) {
    $('.bankdefault li').removeClass('active');
    $(this).toggleClass('active');
    $('.namebank').html($(this).attr('data-name')).show();
});
$('body').on('click', '.content-payment > ul li', function(e) {
    $('.content-payment ul li').removeClass('active');
    $(this).toggleClass('active');
    $('.content-payment .form').hide();
    $('.content-payment .form-detail').hide();
    var data_class = $(this).attr('data-class');
    $('.content-payment .form-' + data_class).show();
});
$('body').on('click', '.content-payment .form ul li', function(e) {
    $('.content-payment .form ul li').removeClass('active');
    $(this).toggleClass('active');
    $('.content-payment .form-detail').hide();
    var data_bank = $(this).attr('data-bank');
    $('.content-payment .form-bank-' + data_bank).show();
});
$('body').on('click', '.item-cate-product .icon-anvanced-search > span', function(e) {
    $(this).parent().toggleClass('active');
    $('.wrap-anvanced-search').toggleClass('active');
    $('.overlay-search-ad').toggle();
    var scroll = $('.wrap-anvanced-search').offset();
    $('body,html').animate({
        scrollTop: scroll.top + 10
    }, 600);
});
$('body').on('click', '.overlay-search-ad, .advanced-search .advanced-action a.cancel', function(e) {
    $('.overlay-search-ad').toggle();
    $('.wrap-anvanced-search').toggleClass('active');
    $('.item-cate-product .icon-anvanced-search').removeClass('active');
});
$('body').on('click', '.info-noti ul li .read', function(e) {
    $(this).parent().addClass('readed');
});
$('body').on('click', '.add-address', function(e) {
    $(this).parent().find('.form-add-address').slideToggle();
});
var screenWidth = $(window).width();
if (parseInt(screenWidth) < 768) {
    $('.profile .left .item ul').css('display', 'none');
    $('body').on('click', '.profile .left .item .wrap-info', function(e) {
        if ($('.profile .left .item ul').css('display') == 'none') {
            $('.profile .left .item ul').slideDown();
            return false;
        } else if ($('.profile .left .item ul').css('display') == 'block') {
            $('.profile .left .item ul').slideUp();
            return false;
        }
    });
}
$(window).resize(function() {
    var screenWidth = $(window).width();
    if (parseInt(screenWidth) < 768) {
        $('.profile .left .item ul').css('display', 'none');
        $('body').on('click', '.profile .left .item .wrap-info', function(e) {
            if ($('.profile .left .item ul').css('display') == 'none') {
                $('.profile .left .item ul').slideDown();
                return false;
            } else if ($('.profile .left .item ul').css('display') == 'block') {
                $('.profile .left .item ul').slideUp();
                return false;
            }
        });
    }
});
$('.video .iframe .play-video').click(function() {
    let youtube = $(this).attr("data-youtube");
    $(this).replaceWith('<iframe src="https://www.youtube.com/embed/' + youtube + '?rel=0&amp;showinfo=0&amp;autoplay=1&amp;iv_load_policy=3" frameborder="0" allowfullscreen></iframe>');
});
if ($('body').find('#range_price').length > 0) {
    $('#range_price').rangeSlider({
        settings: false,
        skin: 'green',
        type: 'interval',
        scale: true
    }, {
        min: 0,
        max: 999,
        step: 1
    });
}
/**/
$(function() {
    if ($('body').find('#zoom-fancybox').length > 0) {
        $.fn.CloudZoom.defaults.zoomSizeMode = 'image';
        $.fn.CloudZoom.defaults.autoInside = 750;
        CloudZoom.quickStart();
        $(function() {
            $('#zoom-fancybox').bind('click', function() {
                var cloudZoom = $(this).data('CloudZoom');
                //cloudZoom.closeZoom();
                $.fancybox.open(cloudZoom.getGalleryList());
                return false;
            });

            $('.cloudzoom-gallery').hover(function() {
                $(this).trigger('click');
            });
        });
        $(".content-product-detail .detail-product .images-product-detail .thumbs > div").owlCarousel({
            navigation: true,
            autoPlay: 8000,
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            items: 4,
            itemsDesktop: [1199, 4],
            itemsDesktopSmall: [979, 4],
            itemsTabletSmall: [864, 4],
            itemsTablet: [768, 4],
            itemsMobile: [479, 3]
        });
    }
    countItemCart();
});
$(".traning-lever > ul > li > .img").click(function() {
    if ($(this).parent().find('.traning-lever0').css('display') == 'block') {
        $(this).parent().find('.traning-lever0').css('display', 'none');
    } else {
        $('.traning-lever0').css('display', 'none');
        $(this).parent().find('.traning-lever0').css('display', 'block');
    }
    var scroll = $(this).offset();
    $('body,html').animate({
        scrollTop: scroll.top - 20
    }, 600);
});

$.urlParam = function(name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) {
        return null;
    } else {
        return results[1] || 0;
    }
}

/* Add Cart */
$('.btn-add-cart').on('click', function() {
    var cart = $('.cart-detail');
    var cartSuccess = $('.box_addcart_success');
    var imgtodrag = $('.img_add_cart img').eq(0);
    if (imgtodrag) {
        var imgclone = imgtodrag.clone().
        offset({
            top: imgtodrag.offset().top,
            left: imgtodrag.offset().left
        }).
        css({
            'opacity': '0.5',
            'position': 'absolute',
            'height': '150px',
            'width': '150px',
            'z-index': '1001'
        }).

        appendTo($('body')).
        animate({
                'top': cart.offset().top - 10,
                'left': cart.offset().left - 10,
                'width': 75,
                'height': 75
            },
            1000, 'easeInOutExpo');
        setTimeout(function() {
            cart.effect("shake", {
                    times: 2
                },
                200);
            cartSuccess.fadeIn();
        }, 1500);
        setTimeout(function() {
            cartSuccess.fadeOut();
        }, 2500);

        imgclone.animate({
                'width': 0,
                'height': 0,
                'top': cart.offset().top + 5,
                'left': cart.offset().left + 5,
            },
            function() {
                $(this).detach();
            });
    }
});

/* Add Cart */
$('#add-cart').on('click', function() {
    var cart = $('.cart-detail');
    var cartSuccess = $('.box_addcart_success');
    var imgtodrag = $(this).parents('.iframe').find('.img img').eq(0);
    if (imgtodrag) {
        var imgclone = imgtodrag.clone().
        offset({
            top: imgtodrag.offset().top,
            left: imgtodrag.offset().left
        }).
        css({
            'opacity': '0.5',
            'position': 'absolute',
            'height': '150px',
            'width': '150px',
            'z-index': '1001'
        }).

        appendTo($('body')).
        animate({
                'top': cart.offset().top - 10,
                'left': cart.offset().left - 10,
                'width': 75,
                'height': 75
            },
            1000, 'easeInOutExpo');
        setTimeout(function() {
            cart.effect("shake", {
                    times: 2
                },
                200);
            cartSuccess.fadeIn();
        }, 1500);
        setTimeout(function() {
            cartSuccess.fadeOut();
        }, 3500);

        imgclone.animate({
                'width': 0,
                'height': 0,
                'top': cart.offset().top + 5,
                'left': cart.offset().left + 5,
            },
            function() {
                $(this).detach();
            });
    }
});
/**/

// function paging_fund(_page) {
//     let url = window.location.href;
//     // let fid = $.urlParam("fid");
//     // window.location = url_domain+'/?m=pub&act=fund&fid='+fid+'&page='+_page;
//     let urlr = url.split('/');
//     urlr.pop();
//     let link = urlr.join('/');
//     window.location = link + '/' + _page;
// }

function deleteCookie(name) {
    document.cookie = name + '=; Max-Age=0; path=/;';
}


// key lưu LocalStorage
var keyLocalStorageItemCart = 'itemCart';
var keyLocalStorageItemCustomer = 'itemCustomer';

// lưu vào localStorage theo key
function saveLocalStorage(key, obj) {

    // Bước 1 chuyển thành chuỗi json
    var jsonObj = JSON.stringify(obj);

    // Bước 2 lưu vào LocalStorage
    localStorage.setItem(key, jsonObj);

}

// lấy dữ liệu LocalStorage theo key
function getLocalStorage(key) {

    //Bước 1 lấy  data
    var jsonItem = localStorage.getItem(key);

    // Bước 2 chuyển qua danh sách sản phẩm giỏ hàng.
    if (jsonItem != null) {
        return JSON.parse(jsonItem);
    } else {
        return null;
    }

}

// xóa dữ liệu LocalStorage theo key
function removeDataLocalStorage(key) {
    saveLocalStorage(key, []);
}

//tạo đối tượng giỏ hàng.
function created_cart(_product_id, _quantity, _title, _price, _decrement, _unique_id, _link_img, _prop_id) {
    var newCart = new Object();
    newCart.product_id = _product_id;
    newCart.quantity = _quantity;
    newCart.title = _title;
    newCart.price = _price;
    newCart.decrement = _decrement;
    newCart.unique_id = _unique_id;
    newCart.link_img = _link_img;
    newCart.prop_id = _prop_id;
    return newCart;
}

// xóa sản phẩm vào localStorage
function removeLocalStorage(_product_id, id, prop_array) {
    // console.log(_product_id);
    var jsonListItemCart = getLocalStorage(keyLocalStorageItemCart);
    if (jsonListItemCart != null) {
        var jsonNewListItemCart = jsonListItemCart.filter(function(item) {
            let prop = item.prop_id.map(i => i.value.split('-')[1]).join('-');
            return item.unique_id !== id || item.product_id !== _product_id || prop != prop_array;
        });
        console.log(jsonNewListItemCart);
        saveLocalStorage(keyLocalStorageItemCart, jsonNewListItemCart);
    }
}

//Xóa hết sản phẩm giỏ hàng
function removeLocalStorageAll_id(id) {
    // console.log(_product_id);
    var jsonListItemCart = getLocalStorage(keyLocalStorageItemCart);
    if (jsonListItemCart != null) {
        var jsonNewListItemCart = jsonListItemCart.filter(function(item) {
            return item.unique_id !== id;
        });
        console.log(jsonNewListItemCart);
        saveLocalStorage(keyLocalStorageItemCart, jsonNewListItemCart);
    }
}

// chỉnh sửa sản phẩm vào localStorage
function editItemCart(_product_id, _quantity, id, prop_array) {
    var jsonListItemCart = getLocalStorage(keyLocalStorageItemCart);
    if (jsonListItemCart != null) {
        var index = jsonListItemCart.findIndex(function(item) {
            let prop = item.prop_id.map(i => i.value.split('-')[1]).join('-')
            return item.product_id == _product_id && item.unique_id == id && prop == prop_array;
        });
        if (index > -1) {
            jsonListItemCart[index].quantity = parseFloat(_quantity);
            saveLocalStorage(keyLocalStorageItemCart, jsonListItemCart);
        }
    }
}

// đếm sản phẩm trong danh sách localStorage
function countItemCart(id) {
    var jsonListItemCart = getLocalStorage(keyLocalStorageItemCart);
    if(id != "none")
    {
        if (jsonListItemCart != null) {
            var result = jsonListItemCart.reduce(function(quantity, product) {
                if(product.unique_id === id)
                {
                    return parseFloat(quantity) + parseFloat(product.quantity);
                } else {
                    return parseFloat(quantity);
                }
            }, 0);
    
            if (result > 0) {
                //$("#quantity_cart").removeClass('hide');
                $("#quantity_cart").html(result);
            } else {
                $("#quantity_cart").html('0');
            }
        } else {
            $("#quantity_cart").html('0');
        }
    } else {
        $("#quantity_cart").html('0');
    }
    
}

function countSelect(id) {
    var jsonListItemCart = getLocalStorage(keyLocalStorageItemCart);
    if (jsonListItemCart != null) {
        var jsonNewListItemCart = jsonListItemCart.filter(function(item) {
            return item.unique_id == id;
        });
        let count = jsonNewListItemCart.length;
        $("#select_product").html(count + " selected product");
    } else {
        $("#select_product").html('0 selected product');
    }
}

//tạo đối tượng thông tin đặt hàng.
function created_customer(_fullname, _email, _mobile, _province, _district, _ward, _street, _address_id, _address, _note) {
    var newCustomer = new Object();
    newCustomer.fullname = _fullname;
    newCustomer.email = _email;
    newCustomer.mobile = _mobile;
    newCustomer.province = _province;
    newCustomer.district = _district;
    newCustomer.ward = _ward;
    newCustomer.street = _street;
    newCustomer.address = _address;
    newCustomer.address_id = _address_id;
    newCustomer.note = _note;

    return newCustomer;
}