var theGlobalConfig = {};

$(document).on("click", "button.wallet_config_save", function() {
    let control_by = $(this).attr("control-by")
    if ($(this).hasClass("btn-primary")) {
        $(this).removeClass("btn-primary");
        $(this).addClass("btn-success");
        $(`.${control_by}`).prop("disabled", false);
    } else {
        $(this).addClass("btn-primary");
        $(this).removeClass("btn-success");
        theGlobalConfig.save(control_by);
    }

})

theGlobalConfig.save = (control_by) => {
    let lItems = [];
    $(`.${control_by}`).each(function() {
        let item = {}
        if ($(this).attr("type") == 'checkbox') {
            //
            item.value = 0;
            if ($(this).is(":checked")) {
                item.value = 1;
            }
        } else {
            //
            item.value = $(this).val();
        }
        item.varname = $(this).attr("id");
        lItems.push(item);

    })

    var data = new FormData();
    data.append("control_by", control_by);
    data.append("lItems", JSON.stringify(lItems));

    _doAjaxNodAdmin('POST', data, 'setting_gb', 'modify', 'save', true, function(res) {
        $(`.${control_by}`).prop("disabled", true);
        $("button.wallet_config_save").addClass("btn-primary");
        $("button.wallet_config_save").removeClass("btn-success");
        $("#btn_theme_default_config").addClass("hide");
    });
}

$(document).on("click", "label.ace.theme_config_value", function() {
    let file = $(this).find("input").val();
    $("#theme_setup").attr("href", domain + '/css/theme/' + file + '.css');
    $("#theme_default_config").val(file);
    $("#btn_theme_default_config").removeClass("hide");
    $("#btn_theme_default_config").removeClass("btn-primary");
    $("#btn_theme_default_config").addClass("btn-success");
})

theGlobalConfig.autocompleteClient = (_keyword, _except, _cb) => {
    var data = new FormData();
    data.append('keyword', _keyword);
    data.append('except', _except);
    _doAjaxNodAdmin('POST', data, 'setting_gb', 'idx', 'auto_cus', false, function(res) {
        _cb(res.data);
    });
}

/**
 * BEGIN quản lý tài khoản nhận thông báo khi có đơn hàng mới: Payment Order Tab
 */
var thePaymentOrder = {};

thePaymentOrder.tab = $("#tab_payment_order");
thePaymentOrder.po_shop_id = $("#po_shop_id");
thePaymentOrder.po_notification = $("#po_notification");
thePaymentOrder.list = $("#po_notification_list");
$(function() {

    thePaymentOrder.tab.click(function() {
        thePaymentOrder.loadPONotification();
    })

    thePaymentOrder.po_shop_id.change(function() {
        thePaymentOrder.loadPONotification();
    })

})

thePaymentOrder.loadPONotification = () => {

    let data = new FormData();
    data.append('shop_id', thePaymentOrder.po_shop_id.val());
    _doAjaxNodAdmin('POST', data, 'setting_gb', 'idx', 'noti_new_order', true, function(res) {
        thePaymentOrder.po_notification.val('');
        thePaymentOrder.list.html(thePaymentOrder.renderPONotification(res.data));
    });

}

thePaymentOrder.renderPONotification = (l) => {
    let h = '';
    if (l && l.length > 0) {
        l.forEach(function(el) {
            h += `<span item-id="${el.id}" title="${el.code}" class="l-allowed po-notification">
                    ${el.name} (${el.mobile})
                    <i item-id="${el.id}" class="x-close">x</i>
                </span>`;
        })
    }
    return h;
}

$(document).on("click", ".l-allowed.po-notification i.x-close", function() {
    $(this).parent().remove();
    thePaymentOrder.updatePONotification();
})

thePaymentOrder.updatePONotification = () => {

    let shop_id = thePaymentOrder.po_shop_id.val();
    let _value = '';
    $(".l-allowed.po-notification").each(function() {
        _value += $(this).attr("item-id") + ';';
    })

    let lItems = [];
    let item = {};
    item.varname = 'noti_client_new_order_' + shop_id;
    item.value = _value;
    lItems.push(item);

    var data = new FormData();
    data.append("control_by", 'payment_order');
    data.append("lItems", JSON.stringify(lItems));
    _doAjaxNodAdmin('POST', data, 'setting_gb', 'modify', 'save', true, function(res) {});

}

thePaymentOrder.po_notification.autocomplete({
    minLength: 1,
    delay: 66,
    option: 'appendTo',
    source: function(request, response) {

        let _except = '';
        $(".l-allowed.po-notification").each(function() {
            _except += $(this).attr("item-id") + ';';
        })

        theGlobalConfig.autocompleteClient(request.term, _except, (dt) => {
            response($.map(dt, function(el) {
                el.label = el.fullname + ' (' + el.mobile + ')';
                return el;
            }));
        });
    },
    select: function(e, ui) {
        let el = ui.item;

        let h = '';
        h = `<span item-id="${el.user_id}" title="${el.code}" class="l-allowed po-notification">
                    ${el.fullname} (${el.mobile})
                    <i item-id="${el.user_id}" class="x-close">x</i>
                </span>`;

        thePaymentOrder.list.append(h);

        setTimeout(() => {
            thePaymentOrder.po_notification.val('');
        }, 80)

        thePaymentOrder.updatePONotification();
    },
    create: function() {
        $(this).data('ui-autocomplete')._renderItem = function(ul, item) {
            return $("<li role='presentation'>")
                .addClass("item-searching ui-menu-item")
                .data("item.autocomplete", item)
                .append(`<a class="col-sm-12" class="ui-corner-all" tabindex="-1">
                                    <div class="img">
                                        <img src="${item.avatar != '' ? item.avatar : domain + '/images/no_joined.png'}" alt="" width="50">
                                    </div>
                                    <div class="name">
                                        <strong>
                                            ${item.fullname} - (${item.mobile})
                                        </strong>
                                        <p>Email: <b>${item.email}</b></p>
                                    </div>
                                </a>`).appendTo(ul);
        };
    }
})

/**
 * END quản lý tài khoản nhận thông báo khi có đơn hàng mới: Payment Order Tab
 */

/**
 * BEGIN quản lý cài đặt thuế thu nhập cá nhân từ hoa hồng bán hàng của thành viên
 */
var theTaxPersonalIncome = {};

theTaxPersonalIncome.tab = $("#tab_wallet_config_auto");
theTaxPersonalIncome.shop_id = $("#tax_shop_id");
theTaxPersonalIncome.client = $("#tax_income_receive_by");
theTaxPersonalIncome.tax = $("#tax_income_percent");
theTaxPersonalIncome.btn = $("#btn_tax_personal_income");
theTaxPersonalIncome.remove = $("#btn_tax_remove");

$(function() {
    theTaxPersonalIncome.load();

    theTaxPersonalIncome.btn.click(function() {
        if (theTaxPersonalIncome.tax.is(":disabled")) {
            if (theTaxPersonalIncome.client.val() == '')
                theTaxPersonalIncome.client.prop("disabled", false);

            theTaxPersonalIncome.tax.prop("disabled", false);
        } else {
            theTaxPersonalIncome.update();
        }
    })

    theTaxPersonalIncome.shop_id.change(function() {
        theTaxPersonalIncome.load();
    })

    theTaxPersonalIncome.remove.click(function() {
        if (!theTaxPersonalIncome.tax.is(":disabled")) {
            theTaxPersonalIncome.client.attr("client_id", "");
            theTaxPersonalIncome.client.val("");
            theTaxPersonalIncome.client.prop("disabled", false);
        } else {
            theTaxPersonalIncome.btn.hide().fadeIn(150);
        }
    })

})

theTaxPersonalIncome.load = () => {

    let data = new FormData();
    data.append('shop_id', theTaxPersonalIncome.shop_id.val());
    _doAjaxNodAdmin('POST', data, 'setting_gb', 'idx', 'tax_load', true, function(res) {

        if (res.data.dClient && res.data.dClient.user_id) {
            theTaxPersonalIncome.client.val(res.data.dClient.fullname + ' (' + res.data.dClient.mobile + ')');
            theTaxPersonalIncome.client.attr('client_id', res.data.dClient.user_id);
        } else {
            theTaxPersonalIncome.client.val('');
            theTaxPersonalIncome.client.attr('client_id', '');
        }

        theTaxPersonalIncome.tax.val(res.data.tax_income_percent);
        theTaxPersonalIncome.client.prop("disabled", true);
        theTaxPersonalIncome.tax.prop("disabled", true);

    });

}

theTaxPersonalIncome.update = () => {

    let shop_id = theTaxPersonalIncome.shop_id.val();

    let lItems = [];

    let item1 = {};
    item1.varname = 'tax_income_receive_by_' + shop_id;
    item1.value = theTaxPersonalIncome.client.attr("client_id");

    let item2 = {};
    item2.varname = 'tax_income_percent_' + shop_id;
    item2.value = theTaxPersonalIncome.tax.val();

    if (item2.value != '' && (parseFloat(SplitNumber2(item2.value)) > 100 || parseFloat(SplitNumber2(item2.value)) < 0)) {
        alert_void("% thuế không hợp lệ. Giá trị phải từ 0 đến 100.");
    } else {
        lItems.push(item1);
        lItems.push(item2);

        var data = new FormData();
        data.append("control_by", 'tax_personal_income');
        data.append("lItems", JSON.stringify(lItems));
        _doAjaxNodAdmin('POST', data, 'setting_gb', 'modify', 'save', true, function(res) {
            theTaxPersonalIncome.client.prop("disabled", true);
            theTaxPersonalIncome.tax.prop("disabled", true);
        });
    }

}

theTaxPersonalIncome.client.autocomplete({
        minLength: 1,
        delay: 66,
        option: 'appendTo',
        source: function(request, response) {
            theGlobalConfig.autocompleteClient(request.term, '', (dt) => {
                response($.map(dt, function(el) {
                    el.label = el.fullname + ' (' + el.mobile + ')';
                    return el;
                }));
            });
        },
        select: function(e, ui) {
            let el = ui.item;
            theTaxPersonalIncome.client.attr("client_id", el.user_id);
            theTaxPersonalIncome.client.prop("disabled", true);
        },
        create: function() {
            $(this).data('ui-autocomplete')._renderItem = function(ul, item) {
                return $("<li role='presentation'>")
                    .addClass("item-searching ui-menu-item")
                    .data("item.autocomplete", item)
                    .append(`<a class="col-sm-12" class="ui-corner-all" tabindex="-1">
                                     <div class="img">
                                         <img src="${item.avatar != '' ? item.avatar : domain + '/images/no_joined.png'}" alt="" width="50">
                                     </div>
                                     <div class="name">
                                         <strong>
                                             ${item.fullname} - (${item.mobile})
                                         </strong>
                                         <p>Email: <b>${item.email}</b></p>
                                     </div>
                                 </a>`).appendTo(ul);
            };
        }
    })
    /**
     * END quản lý cài đặt thuế thu nhập cá nhân từ hoa hồng bán hàng của thành viên
     */

/**
 * BEGIN cập nhật favi icon
 */

var theFaviIcon = {};

$(function() {

    // upload ảnh favi_erp
    uploadMultipleFileType("#favi_erp_file", "#load_favi_erp", "image", "favi_erp", function(link_file, isImage) {
        $("#load_favi_erp").html(`<img id="favi_erp" src="${link_file}">`);
        $("#favi_erp_val").val(link_file);
        theFaviIcon.save('favi_erp');
    });

    // upload ảnh favi_web
    uploadMultipleFileType("#favi_web_file", "#load_favi_web", "image", "favi_web", function(link_file, isImage) {
        $("#load_favi_web").html(`<img id="favi_web" src="${link_file}">`);
        $("#favi_web_val").val(link_file);
        theFaviIcon.save('favi_web');
    });

})

theFaviIcon.save = (_varname) => {
    var data = new FormData();
    data.append("varname", _varname);
    data.append("img", $("#" + _varname + "_val").val());
    _doAjaxNodAdmin('POST', data, 'setting_gb', 'favi_icon', 'save', true, function(res) {
        alert_void('Cập nhật thành công.', 1);
    });
}

/**
 * END cập nhật favi icon
 */