var shop_master_device = $("#shop_master_device");
var ckb_set_master_device = $("#set_master_device");

// var btn_submit_timezone = $("#btn-submit-timezone");
var time_zone = $("#sl-time-zone");
var btn_connect_app_signin = $("#btn_connect_app_signin");
var btn_connect_app_signout = $("#btn_connect_app_signout");
var btn_connect_app_signin_click = false;
var btn_update_printer_id = $("#btn_update_printer_id");
var btn_update_printer_epson = $("#btn_update_printer_epson");
var btn_lang_region = $("#btn_lang_region");

$(function() {
    $("#reset_form_change_password").click(function() { //Reset form ve che do mat dinh

        $("#password").val('');
        $("#new_password").val('');
        $("#confirm_password").val('');

        $("#btn_change_pass").html(lang.jslb_update);
        $("#password").prop("disabled", true);
        $("#new_password").prop("disabled", true);
        $("#confirm_password").prop("disabled", true);
        $(this).prop("disabled", true);

    });

    $("#btn_change_pass").click(function() {
        status_change_password(); //click nut cap nhat de mo chuc nang cap nhat mat khau
    });

    btn_lang_region.click(function() {
        update_lang_region();
    });

    $("#list_shop_id").change(function() {
        load_shop_info();
    });
    load_shop_info();

    $("#allow_zero_sell").click(function() {
        if ($(this).is(":checked")) {
            update_zero_sell(1);
        } else {
            update_zero_sell(0);
        }
    });

    surcharge_reset_form(true);
    $(".surcharge_on").click(function() {
        surcharge_reset_content(!$(this).is(":checked"), $(this).attr('rel-id'));
    });
    $("#btn_surcharge_edit").click(function() {
        surcharge_edit();
    });

    btn_connect_app_signin.click(function() {
        btn_connect_app_signin_click = true;
        $("#hide_btn_google_connect :first").click();
    });

    btn_connect_app_signout.click(function() {
        onSignOut();
    });

    btn_update_printer_id.click(function() {
        update_printer_id();
    });

    btn_update_printer_epson.click(function() {
        update_printer_epson();
    });

    $("#local_printer").change(function() {
        updateIsCloudPrinter();
    });

    $("#cloud_printer").click(function() {
        updateIsCloudPrinter();
    });

    $("#epson_printer").click(function() {
        updateIsCloudPrinter();
    });

    if ($("#cloud_printer").is(":checked"))
        update_printer_id();

    $("#taxs").blur(function() {
        update_taxs();
    })
});

//Cap nhat status cua trang thai cap nhat mat khau
function status_change_password() {
    if ($("#password").is(":disabled")) {
        $("#btn_change_pass").html(lang.jslb_done);
        $("#password").prop("disabled", false);
        $("#new_password").prop("disabled", false);
        $("#confirm_password").prop("disabled", false);
        $("#reset_form_change_password").prop("disabled", false);
        return;
    } else {
        change_password_opt();
        return;
    }
}

function change_password_opt() {
    var password = $("#password").val();
    var new_password = $("#new_password").val();
    var confirm_password = $("#confirm_password").val();

    if (password == "") {
        alert_dialog(lang.lb_recentPass); //Vui lòng nhập mật khẩu hiện tại
    } else if (new_password.length < 5) {
        alert_dialog(lang.lb_min5Pass);
    } else if (confirm_password != new_password) {
        alert_dialog(lang.lb_missMatche);
    } else {
        var data = new FormData();
        data.append('password_old', password);
        data.append('password_new', new_password);

        _doAjaxModule('POST', data, 'user', 'ajax_change_pass', false, function(res) {
            $("#password").val('');
            $("#new_password").val('');
            $("#confirm_password").val('');

            $("#btn_change_pass").html(lang.jslb_update);
            $("#password").prop("disabled", true);
            $("#new_password").prop("disabled", true);
            $("#confirm_password").prop("disabled", true);
            $("#reset_form_change_password").prop("disabled", true);
            $("#change_pass_success").removeClass("hide");
        });

    }
}

$(document).on("change", ".enabled_offline:checkbox", function() {
    var shop_id = $(this).val();
    enable_offline(shop_id);
});

function load_shop_info() {
    var shop_id = $("#list_shop_id").val();

    var data = new FormData();
    data.append('shop_id', shop_id);
    _doAjaxNod('POST', data, 'setting', 'idx', 'info_shop', false, function(res) {
        if (res.data.note_in_bill == '1') {
            $("#status_bill_in_note").prop('checked', true);
        } else {
            $("#status_bill_in_note").prop('checked', false);
        }
    });

}

function enable_offline(_shop_id) {
    if ($("#enable_offline_" + _shop_id).is(':checked')) {
        $("#btn_sl_master_device_" + _shop_id).prop('disabled', false);
        return;
    } else {
        if (!$("#btn_sl_master_device_" + _shop_id).length) {
            $("#enable_offline_" + _shop_id).prop('checked', true);
            BootstrapDialog.show({
                title: lang.jstt_noti,
                message: '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> Mật khẩu xác nhận:</div><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><input id="inp_password" class="form-control" type="password"/></div>',
                buttons: [{
                    label: 'Cancel',
                    cssClass: 'btn-default btn-width',
                    action: function(dialogItself) {
                        $("#enable_offline_" + _shop_id).prop('checked', true);
                        dialogItself.close();
                    }
                }, {
                    label: 'OK',
                    cssClass: 'btn-primary btn-width',
                    hotkey: '13',
                    action: function(dialogItself) {
                        var password = $("#inp_password").val();
                        if (password == '') return;
                        var data = new FormData();
                        data.append('shop_id', _shop_id);
                        data.append('password', password);
                        _doAjaxNod('POST', data, 'setting', 'idx', 'disable_offline', false, function(response) {
                            if (response.status == 200) {
                                if (response.message == 'disabled') {
                                    $("#list_shop_master").html(response.data.html);
                                    dialogItself.close();
                                } else {
                                    alert_dialog(response.data);
                                }
                            }
                        });
                    }
                }]
            });
        } else {
            $("#btn_sl_master_device_" + _shop_id).prop('disabled', true);
        }
    }
}

function select_master_device(_shop_id) {
    $("#master_name").val('');
    $("#master_shop_id").val(_shop_id);
    $("#master_this_device").prop('checked', true);
    $("#modal_select_device").modal('show');
    return;
}

function set_master_device() {
    var shop_id = $("#master_shop_id").val();
    var master_name = $("#master_name").val();
    var master_this_device = $("#master_this_device").is(':checked');
    var master_info = _getOSName() + '/' + _getBrowserName();
    var master_id = getCookie('MB360POS_master_id');
    if (shop_id == '') return;

    if (master_this_device) {
        var data = new FormData();
        data.append('shop_id', shop_id);
        data.append('master_name', master_name);
        data.append('master_info', master_info);
        data.append('master_id', master_id);
        _doAjaxNod('POST', data, 'setting', 'idx', 'enable_offline', false, function(response) {
            if (response.status == 200) {
                $("#list_shop_master").html(response.data.html);
                $("#modal_select_device").modal('hide');
            }
        });
        return;
    } else {
        alert_dialog('Bạn phải chọn thiết bị này là máy chủ!');
        return;
    };
}

function update_zero_sell(value) {
    BootstrapDialog.show({
        title: lang.lb_cfPassWord,
        message: '- Admin:<br><input type="text" class="form-control" name="" id="zero_username"/><br>\
				  - ' + lang.lb_passWord + ' <br><input type="password" class="form-control" name="" id="zero_password"/><br>',
        buttons: [{
                label: lang.jslb_cancel,
                cssClass: 'btn btn-default btn-width',
                hotkey: 27,
                action: function(dialogItself) {
                    dialogItself.close();
                    if ($("#allow_zero_sell").is(":checked")) {
                        $("#allow_zero_sell").prop("checked", false);
                    } else {
                        $("#allow_zero_sell").prop("checked", true);
                    }
                }
            },
            {
                label: lang.jslb_update, //'Cập nhật'
                cssClass: 'btn btn-primary btn-width',
                hotkey: 13,
                action: function(dialogItself) {
                    var username = $("#zero_username").val();
                    var password = $("#zero_password").val();

                    var data = new FormData();
                    data.append('value', value);
                    data.append('username', username);
                    data.append('password', password);
                    _doAjaxNod('POST', data, 'setting', 'idx', 'zerosell', true, function(response) {
                        dialogItself.close();
                    });

                }
            }
        ]
    });
}

//for company setting
var company_title = $('#company_title');
var company_sort = $('#company_sort');
var company_address = $('#company_address');
var company_tax = $('#company_tax');
var company_fax = $('#company_fax');
var company_phone = $('#company_phone');
var company_email = $('#company_email');

var btn_company_reset = $('#btn_company_reset');
var btn_company_update = $('#btn_company_update');

$(function() {
    btn_company_reset.click(function() {
        reset_company(true);
    });
    btn_company_update.click(function() {
        if (company_title.is(':disabled')) {
            reset_company(false);
        } else {
            update_company();
        }
    });
});

function reset_company(_status) {

    //Status is true or false
    company_title.prop('disabled', _status);
    company_sort.prop('disabled', _status);
    company_address.prop('disabled', _status);
    company_tax.prop('disabled', _status);
    company_fax.prop('disabled', _status);
    company_phone.prop('disabled', _status);
    company_email.prop('disabled', _status);
    btn_company_reset.prop('disabled', _status);
    if (_status == true) {
        btn_company_update.html('Cập nhật');
    } else {
        btn_company_update.html('Hoàn tất');
    }

    return;
}

function update_company() {
    if (company_title.val() == '') {
        alert_dialog('Vui lòng nhập tên công ty.');
    } else if (company_sort.val() == '') {
        alert_dialog('Vui lòng nhập tên giao dịch viết tắt.');
    } else if (company_address.val() == '') {
        alert_dialog('Vui lòng nhập địa chỉ công ty.');
    } else {
        var data = new FormData();
        data.append('company_title', company_title.val());
        data.append('company_sort', company_sort.val());
        data.append('company_address', company_address.val());
        data.append('company_tax', company_tax.val());
        data.append('company_fax', company_fax.val());
        data.append('company_phone', company_phone.val());
        data.append('company_email', company_email.val());
        _doAjaxNod('POST', data, 'setting', 'idx', 'company', true, function(response) {
            reset_company(true);
        });
    }
    return;
}

function change_show_vat() {
    if ($("#show_vat").is(":checked")) {
        var show_vat = 1;
    } else {
        var show_vat = 0;
    }
    var data = new FormData();
    data.append('show_vat', show_vat);
    _doAjaxNod('POST', data, 'setting', 'idx', 'show_vat', false, function(response) {
        if (response.status == 200) {

        }
    });
}

function change_note_in_bill(_shop_id) {

    if ($("#note_in_bill_" + _shop_id).is(":checked")) {
        var note_in_bill = 1;
    } else {
        var note_in_bill = 0;
    }

    var data = new FormData();
    data.append('shop_id', _shop_id);
    data.append('note_in_bill', note_in_bill);

    _doAjaxNod("POST", data, "setting", 'idx', "note_in_bill", false, function() {
        printLog("Updated");
    });
}

function change_printing_on_cashed() {
    if ($("#printing_on_cashed_yes").is(":checked")) {
        var printing_on_cashed = 1;
    } else {
        var printing_on_cashed = 0;
    }
    var data = new FormData();
    data.append('printing_on_cashed', printing_on_cashed);
    _doAjaxNod('POST', data, 'setting', 'idx', 'printing_on_cashed', false, function(response) {
        if (response.status == 200) {

        }
    });
}

function surcharge_update() {
    $(".surcharge_on").each(function() {
        var shop_id = $(this).attr('rel-id');

        if ($(this).is(":checked"))
            var surcharge_on = 1;
        else
            var surcharge_on = 0;

        var surcharge_percent = $("#surcharge_percent_" + shop_id).val();
        var surcharge_from_hour = $("#surcharge_from_hour_" + shop_id).val();
        var surcharge_from_minute = $("#surcharge_from_minute_" + shop_id).val();
        var surcharge_to_hour = $("#surcharge_to_hour_" + shop_id).val();
        var surcharge_to_minute = $("#surcharge_to_minute_" + shop_id).val();

        var data = new FormData();
        data.append("shop_id", shop_id);
        data.append("surcharge_on", surcharge_on);
        data.append("surcharge_percent", surcharge_percent);
        data.append("surcharge_from", surcharge_from_hour + ':' + surcharge_from_minute);
        data.append("surcharge_to", surcharge_to_hour + ':' + surcharge_to_minute);

        _doAjaxNod('POST', data, 'setting', 'idx', 'surcharge_update', false, function(response) {
            if (response.status == 200) {}
        });
    });
    return;
}

function surcharge_edit() {
    if ($("#btn_surcharge_edit").html() == lang.jslb_done) {
        surcharge_reset_form(true);
        surcharge_update();
    } else {
        surcharge_reset_form(false);
    }
    return;
}

function surcharge_reset_form(_status) {
    if (_status)
        $("#btn_surcharge_edit").html(lang.jslb_apply); //cap nhat
    else
        $("#btn_surcharge_edit").html(lang.jslb_done); //hoan tat

    $(".surcharge_on").prop("disabled", _status);

    $(".surcharge_on").each(function() {
        if ($(this).is(":disabled")) {
            surcharge_reset_content(true, $(this).attr('rel-id'));
        } else {
            if ($(this).is(":checked"))
                surcharge_reset_content(false, $(this).attr('rel-id'));
            else
                surcharge_reset_content(true, $(this).attr('rel-id'));
        }
    });
    return;
}

function surcharge_reset_content_all(_status) {
    $(".surcharge_percent").prop("disabled", _status);
    $(".surcharge_from_hour").prop("disabled", _status);
    $(".surcharge_from_minute").prop("disabled", _status);
    $(".surcharge_to_hour").prop("disabled", _status);
    $(".surcharge_to_minute").prop("disabled", _status);
    return;
}

function surcharge_reset_content(_status, _shop_id) {
    $("#surcharge_percent_" + _shop_id).prop("disabled", _status);
    $("#surcharge_from_hour_" + _shop_id).prop("disabled", _status);
    $("#surcharge_from_minute_" + _shop_id).prop("disabled", _status);
    $("#surcharge_to_hour_" + _shop_id).prop("disabled", _status);
    $("#surcharge_to_minute_" + _shop_id).prop("disabled", _status);
    return;
}

function onSignIn(googleUser) {
    if (btn_connect_app_signin_click) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        // The ID token you need to pass to your backend:
        var access_token = googleUser.getAuthResponse().access_token;
        // console.log("ID Token: " + access_token);
        var data = new FormData();
        data.append('google_access_token', access_token)
        _doAjaxNod('POST', data, 'setting', 'idx', 'google_cloud_access_token', false, function(response) {
            if (response.status == 200) {
                window.location.reload();
            }
        });
    }
};

function onSignOut() {
    _doAjaxNod('POST', '', 'setting', 'idx', 'disconnect_google_cloud', false, function(response) {
        window.location.reload();
    });
};

function updateIsCloudPrinter() {
    BootstrapDialog.show({
        title: lang.jstt_noti,
        message: lang.msg_changePrintSetting,
        buttons: [{
            label: lang.jslb_cancel,
            cssClass: 'btn-default btn-width',
            action: function(dialogItself) {
                dialogItself.close();
                window.location.reload();
            }
        }, {
            label: lang.jslb_apply,
            cssClass: 'btn-primary btn-width',
            action: function(dialogItself) {
                dialogItself.close();
                if ($("#local_printer").is(":checked")) {
                    is_cloud_printer = 0;
                } else if ($("#cloud_printer").is(":checked")) {
                    is_cloud_printer = 1;
                } else { //epson_printer
                    is_cloud_printer = 2;
                }
                if (is_cloud_printer == '0') {
                    $("#hd-google-cloud-printer").addClass("hide");
                    $("#hd-epson-printer").addClass("hide");
                } else if (is_cloud_printer == '1') {
                    $("#hd-google-cloud-printer").removeClass("hide");
                    $("#hd-epson-printer").addClass("hide");
                } else {
                    $("#hd-google-cloud-printer").addClass("hide");
                    $("#hd-epson-printer").removeClass("hide");
                }
                var data = new FormData();
                data.append('is_cloud_printer', is_cloud_printer);
                _doAjaxNod('POST', data, 'setting', 'idx', 'is_cloud_printer', false, function(response) {
                    window.location.reload();
                });
            }
        }]
    });
};

function update_printer_id() {
    if ($(".option-shop-cloud-printer").first().length) {
        if ($(".option-shop-cloud-printer").first().is(":disabled")) {
            $(".option-shop-cloud-printer").prop("disabled", false);
            btn_update_printer_id.html(lang.jslb_save);
        } else {
            var lShop = [];
            $(".option-shop-cloud-printer").each(function() {
                var item = {};
                item.id = $(this).attr("shop-id");
                item.printer_id = $(this).val();
                item.printer_name = $(this).find('option:selected').text();
                lShop.push(item);
            });
            var data = new FormData();
            data.append('data', JSON.stringify(lShop));
            _doAjaxNod('POST', data, 'setting', 'idx', 'update_printer_info', false, function(response) {
                $(".option-shop-cloud-printer").prop("disabled", true);
                btn_update_printer_id.html(lang.jslb_edit);
            });
        }
    }
}
//btn_update_printer_epson
function update_printer_epson() {
    if ($(".info-epson-printer").first().length) {
        if ($(".info-epson-printer").first().is(":disabled")) {
            $(".inp-epson").prop("disabled", false);
            btn_update_printer_epson.html(lang.jslb_save);
        } else {
            var lShop = [];
            $(".info-epson-printer").each(function() {
                var item = {};
                item.id = $(this).attr("shop-id");
                item.printer_id = $(this).val();
                item.printer_name = $("#epson-printer-name-" + item.id).val();
                lShop.push(item);
            });
            var data = new FormData();
            data.append('data', JSON.stringify(lShop));
            _doAjaxNod('POST', data, 'setting', 'idx', 'update_printer_info', false, function(response) {
                $(".inp-epson").prop("disabled", true);
                btn_update_printer_epson.html(lang.jslb_edit);
            });
        }
    }
}

function test_connect(_shop_id) {
    var IP = $("#epson-printer-id-" + _shop_id).val();
    var name = $("#epson-printer-name-" + _shop_id).val();
    if (IP != '') {
        var printer = null;
        var ePosDev = new epson.ePOSDevice();
        ePosDev.connect(IP, 8008, function(data) {
            if (data == 'OK' || data == 'SSL_CONNECT_OK') {
                ePosDev.createDevice(name, ePosDev.DEVICE_TYPE_PRINTER, { 'crypto': true, 'buffer': true }, function(devobj, retcode) {
                    printer = devobj;
                    printer.timeout = 8000;
                    printer.onreceive = function(res) { alert_dialog(res.success); };
                    printer.oncoveropen = function() { alert_dialog('coveropen'); };
                });
                alert_dialog("<span class='color-success'>" + lang.nt_printSucc + "</span>"); //Successfully connected!
            } else {
                alert_dialog("<span class='color-red'>" + lang.nt_printFail + "</span>"); //Could not be connected!
            }
        });
    } else {
        alert_dialog("<span class='color-red'>" + lang.nt_requiredIP + "</span>"); //Please enter printer IP.
    }
}

function update_lang_region() {
    if ($(".lang-region").first().is(":disabled")) {
        $(".lang-region").prop("disabled", false);
        btn_lang_region.html(lang.jslb_save);
    } else {

        var country = $("#country").val();
        var language = $("#language").val();
        var currency = $("#current_unit").val();
        var time_zone = $("#time_zone").val();

        var data = new FormData();
        data.append('country', country);
        data.append('lang', language);
        data.append('currency', currency);
        data.append('time_zone', time_zone);
        _doAjaxNod("POST", data, "setting", "idx", "update_lang_region", true, function() {
            $(".lang-region").prop("disabled", true);
            btn_lang_region.html(lang.jslb_update);
        });
    }
}

function update_taxs() {

    let taxs = $("#taxs").val();

    if (taxs < 0 || taxs > 100) {
        alert_dialog("Giá trị thuế chỉ cho phép từ 0 đến 100");
    } else {
        var data = new FormData();
        data.append('taxs', taxs);
        _doAjaxNod("POST", data, "setting", 'idx', "taxs", false, function() {});
    }

}

$("#txt_treasurer").autocomplete({
    minLength: 1,
    option: 'appendTo',
    source: function(request, response) {
        var data = new FormData();
        data.append('keyword', $("#txt_treasurer").val());
        data.append('is_for', 1);
        _doAjaxNod('POST', data, 'setting', 'treasurer', 'auto_treasurer', false, function(res) {
            response($.map(res.data, function(el) {
                return {
                    label: el.name + (el.code != '' ? (' (' + el.code + ')') : ''),
                    treasurer_id: el.id,
                };
            }));
        });
    },
    select: function(e, ui) {
        $("#txt_treasurer").attr('treasurer_id', ui.item.treasurer_id);
        $("#txt_treasurer").prop('disabled', true);
        $("#txt_treasurer").next().find('span').removeClass("hidden");
        let _title = "ID lí do thu của shop ";
        save_treasurer('treasurer_id', ui.item.treasurer_id, _title);
    }
});

function save_treasurer(_name, _treasurer_id, _title) {
    var data = new FormData();
    data.append('id', _treasurer_id);
    data.append('shop_id', $("#shop_id").val());
    data.append('name', _name);
    data.append('title', _title);
    _doAjaxNod('POST', data, 'setting', 'treasurer', 'add', false, function(res) {
        alert_void('Thành công', 1);
    });
}

$("#btn_treasurer").click(function() {
    $("#txt_treasurer").val('');
    $("#txt_treasurer").attr('treasurer_id', '');
    $("#txt_treasurer").prop('disabled', false);
    $("#txt_treasurer").next().find('span').addClass("hidden");
})

$("#txt_treasurer_group").autocomplete({
    minLength: 1,
    option: 'appendTo',
    source: function(request, response) {
        var data = new FormData();
        data.append('keyword', $("#txt_treasurer_group").val());
        data.append('is_for', 0);
        _doAjaxNod('POST', data, 'setting', 'treasurer', 'auto_treasurer', false, function(res) {
            response($.map(res.data, function(el) {
                return {
                    label: el.name + (el.code != '' ? (' (' + el.code + ')') : ''),
                    treasurer_id: el.id,
                };
            }));
        });
    },
    select: function(e, ui) {
        $("#txt_treasurer_group").attr('treasurer_group_id', ui.item.treasurer_id);
        $("#txt_treasurer_group").prop('disabled', true);
        $("#txt_treasurer_group").next().find('span').removeClass("hidden");
        let _title = "ID lí do xuất của shop ";
        save_treasurer('treasurer_group_id', ui.item.treasurer_id, _title);
    }
});

$("#btn_treasurer_group").click(function() {
    $("#txt_treasurer_group").val('');
    $("#txt_treasurer_group").attr('client_id', '');
    $("#txt_treasurer_group").prop('disabled', false);
    $("#txt_treasurer_group").next().find('span').addClass("hidden");
});

$("#shop_id").change(function() {
    var data = new FormData();
    data.append('shop_id', $("#shop_id").val());
    data.append('treasurer_id', 'treasurer_id');
    data.append('treasurer_group_id', 'treasurer_group_id');
    _doAjaxNod('POST', data, 'setting', 'treasurer', 'load', false, function(res) {
        $("#txt_treasurer").val(res.data.treasurer_name + (res.data.treasurer_code != '' ? (' (' + res.data.treasurer_code + ')') : ''));
        $("#txt_treasurer").attr('treasurer_id', res.data.treasurer_id);
        $("#txt_treasurer").prop('disabled', true);
        $("#txt_treasurer").next().find('span').removeClass("hidden");

        $("#txt_treasurer_group").val(res.data.treasurer_group_name + (res.data.treasurer_group_code != '' ? (' (' + res.data.treasurer_group_code + ')') : ''));
        $("#txt_treasurer_group").attr('treasurer_id', res.data.treasurer_group_id);
        $("#txt_treasurer_group").prop('disabled', true);
        $("#txt_treasurer_group").next().find('span').removeClass("hidden");
    });
});