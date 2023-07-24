var thePage = {};

$(function() {
    uploadMultipleFileType("#avatar_file", "#load_avatar", "image", "avatar", function(link_file, isImage) {
        $("#load_avatar").html(`<img id="avatar" src="${link_file}">`);
        $("#avatar_val").val(link_file);
        funcSave();
    });
})

function funcSave() {
    var data = new FormData();
    data.append('avatar', $("#avatar_val").val());
    _doAjaxNod('POST', data, 'client_menu', 'save', 'save', true, (res) => {

    })
};