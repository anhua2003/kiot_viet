var thisPage = {};

$(function() {
    $("#btn_update").click(function() {
        if ($("#btn_update").html() == 'Xong') {
            // $(".mce-tinymce").hide();
            // $(".nt_content_after").show();
            tinymce.remove();
            $(".option-list-all").prop("disabled", true);
            $("#btn_update").html("Cập nhật");
            $("#btn_cancel").hide();
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
            $("#btn_update").html("Xong");
        }
    })

    $("#btn_cancel").click(function() {
        tinymce.remove();
        $(".option-list-all").prop("disabled", true);
        $("#btn_cancel").hide();
        $("#btn_update").html("Cập nhật");
    })

    // $(".fees-setting").change(function(){
    //     thisPage.funcsFees();
    // })
})

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
    let data = new FormData();
    data.append('data', JSON.stringify(_data));
    _doAjaxNod('POST', data, 'setting_config', 'idx', 'save', true, (res) => {

    })
}

// $('body').on('click', 'input.fees-by-amount', function (e) {

// });

// $('body').on('click', 'input.fees-by-percent', function (e) {

// });

// $('body').on('click', 'input.fees-by-script', function (e) {

// });

// thisPage.funcsFees = () => {

//     let _data = [];
//     $(".item_settingbank").each(function () {
//         let _id = $(this).attr("fees-id");
//         if ( _id ){

//             let item            = {};
//             item.id             = _id;

//             item.amount_status  = $("#amount_status_"+_id).is(":checked") ? 1:0;
//             item.amount_value   = SplitNumber2( $("#amount_value_"+_id).val() );

//             item.percent_status  = $("#percent_status_" + _id).is(":checked") ? 1 : 0;
//             item.percent_value   = SplitNumber2($("#percent_value_" + _id).val());

//             item.script_status = $("#script_status_" + _id).is(":checked") ? 1 : 0;
//             item.script_value   = '';

//             _data.push(item);
//         }
//     })

//     let data = new FormData();
//     data.append('data', JSON.stringify(_data));
//     _doAjaxNod('POST', data, 'setting_config', 'idx', 'save_fee', false, (res) => {

//     })
// }