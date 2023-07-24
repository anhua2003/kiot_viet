var thisPage = {};

$(function() {
    $("#btn_update").click(function() {
        if ($("#btn_update").html() == 'Xong') {
            $(".option-list-all").prop("disabled", true);
            thisPage.funcsSave();
            $("#btn_update").html("Cập nhật");
        } else {
            $(".option-list-all").prop("disabled", false);
            $("#btn_update").html("Xong");
        }
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
    _doAjaxNod('POST', data, 'setting', 'idx', 'save', true, (res) => {

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
//     _doAjaxNod('POST', data, 'setting', 'idx', 'save_fee', false, (res) => {

//     })
// }