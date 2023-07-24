var thisPage = {};

$(function() {

    // upload ảnh logo
    uploadMultipleFileType("#logo_file", "#load_logo", "image", "logo", function(link_file, isImage) {
        $("#load_logo").html(`<img id="logo" src="${link_file}">`);
        $("#logo_val").val(link_file);
    });

    // upload ảnh icon
    uploadMultipleFileType("#icon_file", "#load_icon", "image", "icon", function(link_file, isImage) {
        $("#load_icon").html(`<img id="icon" src="${link_file}">`);
        $("#icon_val").val(link_file);
    });

    // upload ảnh background
    uploadMultipleFileType("#background_file", "#load_background", "image", "background", function(link_file, isImage) {
        $("#load_background").html(`<img id="background" src="${link_file}">`);
        $("#background_val").val(link_file);
    });

    // upload ảnh cover
    uploadMultipleFileType("#avatar_cover_file", "#load_avatar_cover", "image", "avatar_cover", function(link_file, isImage) {
        $("#load_avatar_cover").html(`<img id="avatar_cover" src="${link_file}">`);
        $("#avatar_cover_val").val(link_file);
    });

    $("#btn_update").click(function() {
        if ($("#btn_update").html() == 'Xong') {
            // $(".mce-tinymce").hide();
            // $(".nt_content_after").show();
            tinymce.remove();
            $(".delete_img").prop("disabled", true);
            $(".option-list-all").prop("disabled", true);
            $("#btn_update").html("Cập nhật");
            $("#btn_cancel").hide();
            $('.noupdate_img').removeClass('hide');
            thisPage.funcsSave();
        } else {
            
            tinymce.init({
                height: 300,
                menubar: false,
                selector: ".nt_content",
                theme: "modern",
                plugins: [
                    "advlist fullpage print preview autolink link image code charmap visualblocks visualchars fullscreen media pagebreak pagebreak wordcount textpattern noneditable insertdatetime",
                    "searchreplace",
                    "lioniteimages",
                    "nonbreaking save table directionality",
                    "emoticons paste textcolor "
                ],
                // plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                // content_css : domain+"/css/bootstrap.css",
                menubar: 'file edit view insert format tools table tc help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | code | lioniteimages',
                // toolbar1: "undo redo | table | fontsizeselect | styleselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | bold italic | forecolor backcolor emoticons | lioniteimages",
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                image_advtab: true,
                relative_urls: false,
                toolbar_items_size: 'small',
                remove_script_host: false

            });
            // $(".mce-tinymce").show();
            // $(".nt_content_after").hide();
            $("#btn_cancel").show();
            $(".option-list-all").prop("disabled", false);
            $(".delete_img").prop("disabled", false);
            $('.noupdate_img').addClass('hide');
            $("#btn_update").html("Xong");
        }
    })

    $("#btn_cancel").click(function() {
        tinymce.remove();
        $(".delete_img").prop("disabled", true);
        $(".option-list-all").prop("disabled", true);
        $("#btn_cancel").hide();
        $("#btn_update").html("Cập nhật");
    })

})

// Lưu các cài đặt
thisPage.funcsSave = () => {
    let _data = [];
    $(".option-list-all").each(function() {
        let item = {};
        if ($(this).attr("type") == 'checkbox') {
            item.varname = $(this).attr("varname");
            item.value = 0;
            if ($(this).is(":checked")) item.value = 1;
        } else {
            item.varname = $(this).attr("varname");
            item.value = $(this).val();
        }
        _data.push(item);
    })

    $(".img-list-all").each(function() {
        let img = {};
        img.varname = $(this).attr("varname");
        img.value = $(this).val();
        // alert(img.value);
        if (img.value != '') {
            _data.push(img);
        }
    })

    let data = new FormData();
    data.append('data', JSON.stringify(_data));
    data.append('logo', $("#logo_val").val());
    data.append('icon', $("#icon_val").val());
    data.append('background', $("#background_val").val());
    data.append('avatar_cover', $("#avatar_cover_val").val());
    _doAjaxNod('POST', data, 'setting_config', 'idx', 'save', true, (res) => {
        location.reload();
    })
}

function delete_img(_name) {
    let _link_not_img = domain + '/images/no_image.png';
    if ($("#" + _name + "_val").val() == _link_not_img) {
        $("#" + _name + "_val").val('');
    } else {
        $("#" + _name + "_val").val(domain + '/images/no_image.png');
    }
}