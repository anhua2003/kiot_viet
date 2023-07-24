// function checkTypeIMG(str_name){

// 	var stemp = str_name.split('.');
// 	var str = stemp[stemp.length-1];
// 	if(str=="jpg"||str=="gif"||str=="png"||str=="jpeg"||str=="JPG"||str=="GIF"||str=="PNG"||str=="JPEG"){
// 		return true;
// 	}else{
// 		alert('Chỉ cho phép định dạng png,jpeg,gif,jpg');
// 		return false;
// 	}
// }

function checkTypeIMG(str_name) {

    var stemp = str_name.split('/');
    var str = stemp[1];
    if (str == "jpg" || str == "gif" || str == "png" || str == "jpeg" || str == "JPG" || str == "GIF" || str == "PNG" || str == "JPEG") {
        return true;
    } else {
        alert('Chỉ cho phép định dạng png,jpeg,gif,jpg');
        return false;
    }
}

function isAllowType(str_name /**Type file*/ , type /*type: docs || multi || image*/ ) {

    var stemp = str_name.split('.');
    var str = stemp[stemp.length - 1];
    str = str.toLowerCase();

    let img = (str == "jpg" || str == "gif" || str == "png" || str == "jpeg" || str == "JPG" || str == "GIF" || str == "PNG" || str == "JPEG");
    let docs = (str == 'csv' || str == 'pdf' || str == 'xlsx' || str == 'xls' || str == 'docx' || str == 'doc' || str == 'ppt' || str == 'pptx');
    if (
        type == 'image' && img ||
        type == 'docs' && docs ||
        type == 'multi' && (docs || img)

    ) {
        return true;
    } else {
        alert_void("Định dạng không được phép:" + str);
        return false;
    }
}

function isImage(url) {
    return (url.match(/\.(jpeg|jpg|gif|png|svg)$/) != null); //return true;
}

function checkTypeExcel(str_name) {

    var stemp = str_name.split('.');
    var len = stemp.length;
    var str = stemp[(len - 1)];

    if (str == 'xlsx' || str == 'xls') {
        return true;
    } else {
        alert('Chỉ cho phép định dạng Excel');
        return false;
    }
}

function checkSizeIMG(sizeIMG) {

    if (sizeIMG < 8500000) {
        return true;
    } else {
        alert('Dung lượng tối đa cho phép là 8MB');
        return false;
    }
}

function checkSizeExcel(sizeIMG) {

    if (sizeIMG < 8500000) {
        return true;
    } else {
        alert('Dung lượng tối đa cho phép là 8MB');
        return false;
    }
}

function checkTypeChungTu(str_name) {

    var stemp = str_name.split('.');
    var str = stemp[1];
    str = str.toLowerCase();

    if (str == 'csv' || str == 'pdf' || str == 'xlsx' || str == 'xls' || str == 'docx' || str == 'doc' || str == 'ppt' || str == 'pptx') {
        return true;
    } else {
        alert('Chỉ cho phép tải lên định dạng csv, xlsx, xls, docx, doc, ppt, pptx, pdf');
        return false;
    }

    // var stemp = str_name.split('.');
    // var len = stemp.length;
    // var str = stemp[(len-1)];

    // if(str=='xlsx'||str=='xls'||str=='docx'||str=='doc'||str=='ppt'||str=='pptx'){
    // 	return true;
    // }else{
    // 	alert('Chỉ cho phép định dạng pptx,ppt,docx,doc,xlsx,xls');
    // 	return false;
    // }
}

function uploadFile(input_img, output_img, loading) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";

    $(input_img).fileupload({
        add: function(e, data) {
            if (checkSizeIMG(data.originalFiles[0]['size'])) {
                $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                data.formData = { import_code: $("#import_code").val(), wh_id: $("#import_wh_id").val() };
                data.submit();
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/uploadfile.php',
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        global: false,
        done: function(e, data) {

            $.each(data.result.files, function(index, file) {
                $(loading).html('<a target="_blank" href="' + file.name + '"><img src="' + file.name + '" name="" class=""/></a><span onclick="click_update_img()" class=" img_func btn_edit_icon"></span><span onclick="click_delete_img()" class=" img_func btn_delete_icon"></span>');
            });

        },
        fail: function(e, data) {
            $.each(data.result.files, function(index, file) {
                $(loading).html('<a target="_blank" href="' + file.name + '"><img src="' + file.name + '" name="" class=""/></a><span onclick="click_update_img()" class=" img_func btn_edit_icon"></span><span onclick="click_delete_img()" class=" img_func btn_delete_icon"></span>');
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadFileAttach(input_img, output_img, loading) {

    var barId = loading.split("#");
    barId = barId['1'] + " process";
    var pro_bar = "#" + barId + " .progress-bar";

    $(input_img).fileupload({
        add: function(e, data) {
            if (checkSizeIMG(data.originalFiles[0]['size'])) {
                if (checkTypeIMG(data.originalFiles[0]['type'])) {
                    data.formData = { import_code: $("#add_code").val(), wh_id: $("#add_sl_warehouse_id").val() };
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/uploadfile.php?m=storing',
        dataType: 'json',
        pasteZone: null,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        global: true,
        done: function(e, data) {
            $.each(data.result.files, function(index, file) {
                $(loading).html('<img id="holder_review_img" onclick="review_img();" src="' + file.name + '">');
                $(input_img).val('');
                $(output_img).val(file.name);
            });
        },
        fail: function(e, data) {
            alert("Lỗi upload file!");
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadFileExcel(input_img, output_img, loading) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";

    $(input_img).fileupload({
        add: function(e, data) {
            if (checkSizeIMG(data.originalFiles[0]['size'])) {
                if (checkTypeExcel(data.originalFiles[0]['name'])) {
                    $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                    data.formData = { import_code: $("#import_code").val(), wh_id: $("#import_wh_id").val() };
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/uploadfileexcel.php',
        dataType: 'json',
        pasteZone: null,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        done: function(e, data) {
            var link = '';
            $.each(data.result.files, function(index, file) {
                link = file.name;
            });
            get_importfile(link);
        },
        fail: function(e, data) {
            var link = '';
            $.each(data.result.files, function(index, file) {
                link = file.name;
            });
            get_importfile(link);
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadIMG_product(input_img, output_img, loading) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";
    $(input_img).fileupload({
        add: function(e, data) {
            if (checkTypeIMG(data.originalFiles[0]['type'])) {
                if (checkSizeIMG(data.originalFiles[0]['size'])) {
                    $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/upload.php',
        dataType: 'json',
        pasteZone: null,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        done: function(e, data) {
            $.each(data.result.files, function(index, file) {
                $(loading).html("<img  src='" + file.name + "' />");
                $(output_img).val(file.name);
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadIMG_product2(input_img, output_img, loading) {

    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";
    $(input_img).fileupload({
        add: function(e, data) {
            if (checkTypeIMG(data.originalFiles[0]['type'])) {
                if (checkSizeIMG(data.originalFiles[0]['size'])) {
                    $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/upload.php',
        dataType: 'json',
        pasteZone: null,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        done: function(e, data) {
            // var linkimg = domain + '/';
            $.each(data.result.files, function(index, file) {
                $(loading).html("<img  src='" + file.name + "' />");
                $(output_img).val(file.name);
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadIMG_register(input_img, output_img, loading) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";
    $(input_img).fileupload({
        add: function(e, data) {
            if (checkTypeIMG(data.originalFiles[0]['type'])) {
                if (checkSizeIMG(data.originalFiles[0]['size'])) {
                    $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/upload.php',
        dataType: 'json',
        pasteZone: null,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        done: function(e, data) {
            $.each(data.result.files, function(index, file) {
                $(loading).html("<img  src='" + file.name + "' />");
                $(output_img).val(file.name);
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadIMG_support_post(input_img, output_img, loading) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";
    $(input_img).fileupload({
        add: function(e, data) {
            if (checkTypeIMG(data.originalFiles[0]['type'])) {
                if (checkSizeIMG(data.originalFiles[0]['size'])) {
                    $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/upload_support_post.php',
        dataType: 'json',
        pasteZone: null,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        done: function(e, data) {
            $.each(data.result.files, function(index, file) {
                $(loading).html("<img  src='" + file.name + "' />");
                $(output_img).val(file.name);
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadIMG_Quick(input_img, output_img, loading, show, out_link) {
    /*
    @ input_img is input tag change event
    @outupt_img is input tag content kq
    @loading is loading bar
    @show is where to show img
    @out_link is input tag hold link
    */
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";
    $(input_img).fileupload({
        add: function(e, data) {
            if (checkTypeIMG(data.originalFiles[0]['type'])) {
                if (checkSizeIMG(data.originalFiles[0]['size'])) {
                    $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/uploadimg_quick.php',
        dataType: 'json',
        pasteZone: null,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        done: function(e, data) {
            $.each(data.result.files, function(index, file) {
                $(loading).html("");
                $(show).html("<img  src='" + file.name + "' />");
                $(out_link).val(file.name);
                $(output_img).val(file.name);
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadIMG_Transfer(input_img, output_img, loading) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";
    $(input_img).fileupload({
        add: function(e, data) {
            if (checkTypeIMG(data.originalFiles[0]['type'])) {
                if (checkSizeIMG(data.originalFiles[0]['size'])) {
                    $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/index.php?act=uploadimg_transfer',
        dataType: 'json',
        pasteZone: null,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        done: function(e, data) {
            $.each(data.result.files, function(index, file) {
                if (file.name != '') {
                    $(loading).html("<img  src='" + file.name + "' />");
                    $(output_img).val(file.name);
                } else {
                    $(loading).html("B?n kh�ng du?c ph�p c?p nh?t h�a don.");
                }
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadFile2(input_img, loading) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";

    $(input_img).fileupload({
        add: function(e, data) {
            if (checkSizeIMG(data.originalFiles[0]['size']) && checkTypeIMG(data.originalFiles[0]['type'])) {
                $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                data.submit();
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/uploadfile.php',
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        global: false,
        done: function(e, data) {

            $.each(data.result.files, function(index, file) {
                $(loading).html(`<img src="${domain}/images/add_pro.png" style="opacity:0.3;cursor:pointer;" class="img-responsive">`);
                $(loading).after(`<div class="col-md-3 col-sm-3 col-xs-6 item"><a class="img"><img src="${file.name}" class="img-responsive img picscreen picscreen-upload"><i class="delete">x</i></a></div>`);
            });

            $(input_img).val('');

        },
        fail: function(e, data) {
            var linkimg = domain;
            $.each(data.result.files, function(index, file) {
                $(loading).html('<a target="_blank" href="' + file.name + '"><img src="' + file.name + '" name="" class=""/></a><i title="update" onclick="return click_update_url();" class="glyphicon glyphicon-edit edit_url_update"></i>');
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadFileImgTreasurer(input_img, loading) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";

    $(input_img).fileupload({
        add: function(e, data) {
            if (checkSizeIMG(data.originalFiles[0]['size']) && checkTypeIMG(data.originalFiles[0]['type'])) {
                $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                data.submit();
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/uploadfile.php',
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        global: false,
        done: function(e, data) {

            $.each(data.result.files, function(index, file) {
                $(loading).html(`<img src="${domain}/images/clicktoup.jpg" style="opacity:0.3;cursor:pointer;" class="img-responsive">`);
                $(loading).after(`<div class="col-md-3 col-sm-3 col-xs-6 item"><a class="img"><img src="${file.name}" class="img-responsive img picscreen picscreen-upload"><i class="delete">x</i></a></div>`);
            });

            $(input_img).val('');

        },
        fail: function(e, data) {
            var linkimg = domain;
            $.each(data.result.files, function(index, file) {
                $(loading).html('<a target="_blank" href="' + file.name + '"><img src="' + file.name + '" name="" class=""/></a><i title="update" onclick="return click_update_url();" class="glyphicon glyphicon-edit edit_url_update"></i>');
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}
/**UPLOAD MULTIPLE FILE TYPE */
function uploadMultipleFileType(input_img /** input type="file" */ , loading /*Loading h*/ , fileType /**: multi|docs|image */ , where /**Where to save in server */ , cb) {

    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";

    $(input_img).fileupload({
        add: function(e, data) {
            if (checkSizeIMG(data.originalFiles[0]['size']) &&
                isAllowType(data.originalFiles[0]['name'], fileType)
            ) {
                $(loading).html('<div class="progress" style="max-height:10px;" width="100%" id="' + barId + '"><div class="progress-bar progress-bar-success">0%</div></div>');
                data.submit();
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/uploadfile.php?m=multiple&w=' + where,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|csv|xls|xlsx|doc|docx|ppt|pptx|pdf)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        global: false,
        pasteZone: null,
        done: function(e, data) {
            let url_file = '';
            $.each(data.result.files, function(index, file) {
                if (url_file == '') url_file = file.name;
            });
            $(loading).html('');
            $(input_img).val('');
            cb(url_file, isImage(url_file)); //isImage(url_file) = true is image; isImage(url_file) = false is file
        },
        fail: function(e, data) {
            let url_file = '';
            $.each(data.result.files, function(index, file) {
                if (url_file == '') url_file = file.name;
            });
            $(loading).html('');
            $(input_img).val('');
            cb(url_file, isImage(url_file));
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
}

function uploadFileExcelOnly(input_img, loading) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";

    $(input_img).fileupload({
        add: function(e, data) {
            if (checkSizeExcel(data.originalFiles[0]['size']) && checkTypeExcel(data.originalFiles[0]['name'])) {
                $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                data.submit();
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/uploadfile.php',
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        global: false,
        done: function(e, data) {

            $.each(data.result.files, function(index, file) {
                $(loading).html(`<img src="${domain}/images/clicktoup.jpg" style="opacity:0.3;cursor:pointer; class="img-responsive">`);
                $("#hold_img_show").after(`<div class="col-md-3 col-sm-3 col-xs-6 item"><a class="img" ><img src="${file.name}" class="img-responsive img picscreen picscreen-upload"><i class="delete">x</i></a></div>`);
            });

            $(input_img).val('');

        },
        fail: function(e, data) {
            var linkimg = domain;
            $.each(data.result.files, function(index, file) {
                $(loading).html('<a target="_blank" href="' + file.name + '"><img src="' + file.name + '" name="" class=""/></a><i title="update" onclick="return click_update_url();" class="glyphicon glyphicon-edit edit_url_update"></i>');
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadFileChungTu(input_file, loading) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";
    $(input_file).fileupload({
        add: function(e, data) {
            if (checkSizeIMG(data.originalFiles[0]['size']) &&
                isAllowType(data.originalFiles[0]['name'], 'multi')
            ) {
                $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                data.submit();
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/uploadfile.php?m=file_chungtu',
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(docx|xlsx|pptx)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        global: false,
        done: function(e, data) {

            $.each(data.result.files, function(index, file) {
                $(loading).html(`<img src="${domain}/images/attachno.png" style="opacity:0.3;cursor:pointer;" class="file-responsive">`);
                $("#hold_file_show").after(`<div class="col-md-3 col-sm-3 col-xs-6 item"><a  class="file"><img linkfile="${file.name}" src="${domain}/images/attach.png" class="file-responsive file chungtu-download"><i class="delete">x</i></a></div>`);
            });

            $(input_file).val('');

        },
        fail: function(e, data) {
            var linkimg = domain;
            $.each(data.result.files, function(index, file) {
                $(loading).html('<a target="_blank" href="' + file.name + '"><img src="' + file.name + '" name="" class=""/></a><i title="update" onclick="return click_update_url();" class="glyphicon glyphicon-edit edit_url_update"></i>');
            });
        },

        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadFileExcelOnly(input_file, loading) { //Chỉ cho upload 1 file duy nhất
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";

    var text_input = input_file.split("#");
    text_input = text_input['1'];

    $(input_file).fileupload({
        add: function(e, data) {
            if (checkSizeIMG(data.originalFiles[0]['size'])) {
                $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                data.submit();
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/uploadfile.php?m=file_chungtu',
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(docx|xlsx|pptx)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        global: false,
        done: function(e, data) {

            $.each(data.result.files, function(index, file) {
                $(loading).html(`<img id="img_'${text_input}'" onclick="click_file('${text_input}');" src="${domain}/images/upload.png" style="opacity:0.3;cursor:pointer;" class="file-responsive">`);
                $(".excel-qrcode-file").remove();
                $("#hold_file_show").hide();
                $("#hold_file_show").after(`<div class="col-md-3 col-sm-3 col-xs-6 item"><a class="file excel-qrcode-file"><img linkfile="${file.name}" src="${domain}/images/excel.png" class="file-responsive file file-excel-download"><i class="delete delete_file_excel">x</i></a></div>`);
            });

            $(input_file).val('');

        },
        fail: function(e, data) {
            var linkimg = domain;
            $.each(data.result.files, function(index, file) {
                $(loading).html('<a target="_blank" href="' + file.name + '"><img src="' + file.name + '" name="" class=""/></a><i title="update" onclick="return click_update_url();" class="glyphicon glyphicon-edit edit_url_update"></i>');
            });
        },

        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadIMGFunction(input_img, output_img, loading) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";

    var text_input = input_img.split("#");
    text_input = text_input['1'];

    $(input_img).fileupload({
        add: function(e, data) {
            if (checkTypeIMG(data.originalFiles[0]['type'])) {
                if (checkSizeIMG(data.originalFiles[0]['size'])) {
                    $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/upload.php',
        dataType: 'json',
        autoUpload: true,
        pasteZone: null,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        done: function(e, data) {
            $.each(data.result.files, function(index, file) {
                $(loading).html("<img onclick=\"review_img('" + file.name + "')\"  src='" + file.name + "' />\
								 		<span onclick=\"click_file('" + text_input + "')\" class=\" img_func fa fa-pencil icon-cate icon-other-edit\"></span>\
			      	  					<span onclick=\"delete_file('" + text_input + "')\" class=\" img_func fa fa-trash-o icon-cate icon-other-x\"></span>");
                $(output_img).val(file.name);
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadIMGFunctionLogo(input_img, output_img, loading) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";

    var text_input = input_img.split("#");
    text_input = text_input['1'];

    $(input_img).fileupload({
        add: function(e, data) {
            if (checkTypeIMG(data.originalFiles[0]['type'])) {
                if (checkSizeIMG(data.originalFiles[0]['size'])) {
                    $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/upload.php',
        dataType: 'json',
        pasteZone: null,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        done: function(e, data) {
            $.each(data.result.files, function(index, file) {
                $(loading).html("<img onclick=\"review_img('" + file.name + "')\"  src='" + file.name + "' />\
								 		<span onclick=\"click_file('" + text_input + "')\" class=\" img_func btn_edit_icon\"></span>\
			      	  					<span onclick=\"delete_file('" + text_input + "')\" class=\" img_func btn_delete_icon hidden\"></span>");
                $(output_img).val(file.name);
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadIMGReview(input_img, output_img, loading, review_images) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";

    var text_input = input_img.split("#");
    text_input = text_input['1'];

    var text_out = output_img.split("#");
    text_out = text_out['1'];

    $(input_img).fileupload({
        add: function(e, data) {
            if (checkTypeIMG(data.originalFiles[0]['type'])) {
                if (checkSizeIMG(data.originalFiles[0]['size'])) {
                    $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/upload.php',
        dataType: 'json',
        autoUpload: true,
        pasteZone: null,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        done: function(e, data) {
            $.each(data.result.files, function(index, file) {
                $(loading).html("<img onclick=\"review_img(\'" + review_images + "\', \'" + file.name + "')\"  src='" + file.name + "' />\
								 		<span onclick=\"click_file('" + text_input + "')\" class=\" img_func btn_edit_icon\"></span>\
			      	  					<span onclick=\"delete_file('" + text_out + "')\" class=\" img_func btn_delete_icon\"></span>");
                $(output_img).val(file.name);
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadIMGSKU(input_img_id, sku_id, loading_holder, review_images) {
    var barId = loading_holder + sku_id + 'process'; //loading_holder = sku_holder_img_
    var pro_bar = "#" + barId;

    $("#" + input_img_id).fileupload({
        add: function(e, data) {
            if (checkTypeIMG(data.originalFiles[0]['type'])) {
                if (checkSizeIMG(data.originalFiles[0]['size'])) {
                    $("#" + loading_holder + sku_id).html('<div class="progress progress-bar" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        url: domain + '/lazyloading/upload.php',
        dataType: 'json',
        pasteZone: null,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        done: function(e, data) {
            $.each(data.result.files, function(index, file) {
                $("#" + loading_holder + sku_id).html("<img id=\"sku_img_" + sku_id + "\" onclick=\"review_img(\'" + review_images + "\', \'" + file.name + "')\"  src='" + file.name + "' class=\"img-responsive\" />\
								 		<span onclick=\"sku_click_img('" + sku_id + "' )\" class=\" img_func btn_edit_icon\"></span>\
			      	  					<span onclick=\"sku_delete_img('" + sku_id + "' )\" class=\" img_func btn_delete_icon\"></span>");
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}

function uploadIMGAvatar(input_img, output_img, loading, review_images) {
    var barId = loading.split("#");
    barId = barId['1'] + "process";
    var pro_bar = "#" + barId + " .progress-bar";

    var text_input = input_img.split("#");
    text_input = text_input['1'];

    var text_out = output_img.split("#");
    text_out = text_out['1'];

    $(input_img).fileupload({
        add: function(e, data) {
            if (checkTypeIMG(data.originalFiles[0]['type'])) {
                if (checkSizeIMG(data.originalFiles[0]['size'])) {
                    $(loading).html('<div class="progress" id="' + barId + '"> <div class="progress-bar progress-bar-success">0%</div> </div>');
                    data.submit();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        },
        pasteZone: null,
        url: domain + '/lazyloading/upload.php',
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 60,
        previewMaxHeight: 60,
        previewCrop: true,
        done: function(e, data) {
            $.each(data.result.files, function(index, file) {
                $(loading).html("<img src='" + file.name + "' />");
                $(output_img).val(file.name);
            });
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percent = "div ";
            $(pro_bar).css(
                'width',
                progress + '%'
            );
            $(pro_bar).html(progress + '%');
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

}