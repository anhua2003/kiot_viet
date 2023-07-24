var m = {};

m.list_product = $("#product_list");

m.total = $("#total");

m.total_cart = $("#total_cart");

m.user_id = $("#user_id");

m.list_cart = $("#show_cart_detail");
m.empty_cart = $("#empty-cart");

m.checkout = $(".order-products");

m.checkout_total = $(".order-total");
$(function () {
    $(document).on('click', '.add-to-cart-btn', function () {
        removeLocalStorage();
        m.filterItemCart();
    })
    m.filterItemCart();
    // removeDataLocalStorage(keyLocalStorageItemCart);
})
m.filterItemCart = () => {
    var itemCart = getLocalStorage(keyLocalStorageItemCart);
    console.log(itemCart);
    if(m.user_id.val() == "none")
    {
        m.list_product.html('You are not logged in');
        m.total.html('0');
    } else {
        let count = 0;
        if(itemCart == null) 
        {
            count = 0;
        } else {
            count = itemCart.reduce((acc, item) => {
                return acc + (item.unique_id === m.user_id.val() ? 1 : 0);
              }, 0);
        }
          if(count == 0)
          {
            m.list_product.html('No products');
            m.total.html('0');
            m.empty_cart.html('No products');
            m.total_cart.text('')
          } else {
              m.list_product.html(m.render(itemCart)[0]);
              m.total.html(m.render(itemCart)[1]);
              m.list_cart.html(m.render(itemCart)[2]);
              m.checkout.html(m.render(itemCart)[3]);
              m.checkout_total.html(m.render(itemCart)[1])
              m.total_cart.html(m.render(itemCart)[1]);
              console.log(m.render(itemCart))
          }
    }
    countItemCart(m.user_id.val());
    countSelect(m.user_id.val());
}

m.render = (itemCart) => {
    let h = '';
    let t = '';
    let c = '';
    let checkout = '';
if (itemCart != null && itemCart.length > 0) {
  let total = 0;
  itemCart.forEach(function (item) {
    if (item.unique_id == m.user_id.val()) {
      let calculatedPrice = item.price * (100 - item.decrement) / 100;
      let prop = item.prop_id.map(i => i.value.split('-')[1]).join('-');
      total += calculatedPrice * item.quantity;

      h += `<div class="product-widget">
        <div class="product-img">
            <img src="${item.link_img}" alt="">
        </div>
        <div class="product-body">
            <h3 class="product-name"><a href="/detail/${item.product_id}/${item.title}">${item.title}</a></h3>
            <h4 class="product-price"><span class="qty">${item.quantity}x</span>${number_format_replace_cog(calculatedPrice)}đ</h4>
            total: ${total}
        </div>
        <button class="delete" id="delete_sp" data-product-id="${item.product_id}" data-prop="${prop}">x</button>
    </div>`;

      c += `<tr>
        <td>
            <div class="product-item">
                <a class="product-thumb" href="/detail/${item.product_id}/${item.title}"><img src="${item.link_img}" alt="Product"></a>
                <div class="product-info">
                    <h4 class="product-title"><a href="#">${item.title}</a></h4>
                    <p>${prop}</p>
                </div>
            </div>
        </td>
        <td class="text-center">
        <div class="input-number" style="width: 100px;">
            <input type="number" id="quantity_number" class="${item.product_id}-${prop}" data-product-id="${item.product_id}" data-prop="${prop}" value="${item.quantity}">
            <span class="qty-up" id="up-${item.product_id}-${prop}" data-product-id="${item.product_id}" data-prop="${prop}">+</span>
            <span class="qty-down" id="down-${item.product_id}-${prop}" data-product-id="${item.product_id}" data-prop="${prop}">-</span>
        </div>
        <script>
        $('.input-number').each(function() {
            var $this = $(this),
            $input = $this.find('.${item.product_id}-${prop}'),
            up = $this.find('#up-${item.product_id}-${prop}'),
            down = $this.find('#down-${item.product_id}-${prop}');
        
            down.on('click', function () {
                var value = parseInt($input.val()) - 1;
                value = value < 1 ? 1 : value;
                $input.val(value);
                $input.change();
                updatePriceSlider($this , value)
            })
        
            up.on('click', function () {
                var value = parseInt($input.val()) + 1;
                $input.val(value);
                $input.change();
                updatePriceSlider($this , value)
            })
        });

            function updatePriceSlider(elem , value) {
                if ( elem.hasClass('price-min') ) {
                    console.log('min')
                    priceSlider.noUiSlider.set([value, null]);
                } else if ( elem.hasClass('price-max')) {
                    console.log('max')
                    priceSlider.noUiSlider.set([null, value]);
                }
            }
        </script>
            
        </td>
        <td class="text-center text-lg text-medium">${number_format(calculatedPrice * item.quantity)}đ </td>
        <td class="text-center text-lg text-medium">${item.decrement}%</td>
        <td class="text-center"><a class="remove-from-cart" id="delete_sp" data-prop="${prop}" data-product-id="${item.product_id}" style="cursor: pointer;" data-toggle="tooltip" title="" data-original-title="Remove item"><i class="fa fa-trash"></i></a></td>
    </tr>`;

      checkout += `<div class="order-col">
        <div>${item.quantity}x ${item.title} ${prop}</div>
        <div>${number_format(calculatedPrice * item.quantity)}đ</div>
    </div>`;
    }
  })

  t += `${number_format(total)}
        <input type="text" id="payment_cod" class="hide" value="${total}">
    `;
} else {
  h += `<tr>
        <td colspan="3"><b style="display: block;margin: 20px 0px 0px 0px;text-align: center;">Không có sản phẩm nào trong giỏ hàng</b></td>
    </tr>`;
  t += `Tổng tiền: 0đ`;
}

return [h, t, c, checkout];


}

m.list_product.on("click", "#delete_sp", function () {
    let id = $(this).data("product-id");
    let prop = $(this).data("prop");
    removeLocalStorage(id, m.user_id.val(), prop);
    m.filterItemCart();
});

m.list_cart.on("click", "#delete_sp", function () {
    // alert("Hello");
    let id = $(this).data("product-id");
    let prop = $(this).data("prop");
    BootstrapDialog.show({
        title: "Xác nhận",
        message: `Bạn muốn xóa sản phẩm này khỏi giỏ hàng?`,
        buttons: [{
            label: 'Hủy',
            cssClass: 'btn-secondary btn-width',
            action: function (dialogItself) {
                dialogItself.close();
            }
        }, {
            label: ' Xác nhận',
            cssClass: 'btn-key btn-width',
            action: function (dialogItself) {
                removeLocalStorage(id, m.user_id.val(), prop);
                m.filterItemCart();
                dialogItself.close();
            }
        }]
    });
});
m.list_cart.on('click', '.qty-up, .qty-down', function() {
    let product_id = $(this).data("product-id");
    let prop = $(this).data("prop");
    let quantity_id = $("."+product_id+"-"+prop).data("product-id");
    // alert(quantity_id);
    if(product_id == quantity_id)
    {
        let quantity = $("."+product_id+"-"+prop).val();
        if(quantity == 0)
        {
            BootstrapDialog.show({
                title: "Xác nhận",
                message: `Bạn muốn xóa sản phẩm này khỏi giỏ hàng?`,
                buttons: [{
                    label: 'Hủy',
                    cssClass: 'btn-secondary btn-width',
                    action: function (dialogItself) {
                        m.filterItemCart();
                        dialogItself.close();
                    }
                }, {
                    label: ' Xác nhận',
                    cssClass: 'btn-key btn-width',
                    action: function (dialogItself) {
                        removeLocalStorage(product_id, m.user_id.val());
                        m.filterItemCart();
                        dialogItself.close();
                    }
                }]
            });
        } else {
            editItemCart(product_id, quantity, m.user_id.val(), prop);
            m.filterItemCart();
        }
    }
})
m.list_cart.on('input', 'input[type="number"]', function() {
    var _this = $(this);
    let user_id = m.user_id.val();
    let product_id = _this.data("product-id");
    let prop = _this.data("prop");
    let quantity = _this.val();
    if(quantity == 0)
    {
        BootstrapDialog.show({
            title: "Xác nhận",
            message: `Bạn muốn xóa sản phẩm này khỏi giỏ hàng?`,
            buttons: [{
                label: 'Hủy',
                cssClass: 'btn-secondary btn-width',
                action: function (dialogItself) {
                    m.filterItemCart();
                    dialogItself.close();
                }
            }, {
                label: ' Xác nhận',
                cssClass: 'btn-key btn-width',
                action: function (dialogItself) {
                    removeLocalStorage(product_id, m.user_id.val(),prop);
                    m.filterItemCart();
                    dialogItself.close();
                }
            }]
        });
    } else {
        editItemCart(product_id, quantity, user_id, prop);
        m.filterItemCart();
    }
    // alert(product_id);
})

$("#detele_all_cart").on('click', function() {
    BootstrapDialog.show({
        title: "Xác nhận",
        message: `Bạn muốn xóa hết sản phẩm khỏi giỏ hàng?`,
        buttons: [{
            label: 'Hủy',
            cssClass: 'btn-secondary btn-width',
            action: function (dialogItself) {
                m.filterItemCart();
                dialogItself.close();
            }
        }, {
            label: ' Xác nhận',
            cssClass: 'btn-key btn-width',
            action: function (dialogItself) {
                removeLocalStorageAll_id(m.user_id.val());
                m.filterItemCart();
                dialogItself.close();
            }
        }]
    });
})

$("#place_order").on('click', function(e) {
    e.preventDefault();
    let itemCart = getLocalStorage(keyLocalStorageItemCart);
    let i = 0;
    itemCart.forEach(function(item) {
        if(item.unique_id == m.user_id.val())
        {
            i++;
        }
    })
    if(i == 0)
    {
        alert_void("Giỏ hàng chưa có sản phẩm nào", 403);
    } else {
        location.href = "/checkout";
    }
})
