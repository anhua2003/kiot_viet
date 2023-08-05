$(document).on('click', '#edit_product', function (e) {
    e.preventDefault();
    let id = $(this).data('product-id')
    let formData = new FormData(document.getElementById('edit_form'));
    let imageArray = [];
    // Lặp qua từng thẻ <span> có lớp 'pip' và lấy đường dẫn ảnh
    $('.pip').each(function () {
        let img = $(this).find('img');
        let imgData = img.attr('src');

        // Thêm đường dẫn ảnh vào mảng
        imageArray.push(imgData);
    });
    imageArray.forEach(function(item) {
        formData.append("img[]", item);
    })
    formData.append('product_id', id);
    _doAjaxNod('POST', formData, "tiktokshop", "product", "edit", true, (res) => {
        if (res.status == 200) {
            setTimeout(() => { window.location.reload() }, 4000);

            // console.log(res.data);
        }
    })
})

if (window.File && window.FileList && window.FileReader) {

    $(document).on("change", "#upload", function (e) {
        var files = e.target.files,
            filesLength = files.length;
        for (var i = 0; i < filesLength; i++) {
            var f = files[i];
            var fileReader = new FileReader();
            fileReader.onload = function (e) {
                var file = e.target;
                $('.show_img').append("<span class='pip'>" +
                    "<img class='imageThumb' src='" + e.target.result + "' title='" + file.name + "'/>" +
                    "<br/><span class='remove'>x</span>" +
                    "</span>");
                $(".remove").click(function () {
                    var pip = $(this).closest(".pip");
                    var inputFiles = $("#upload")[0].files;
                    var index = pip.index();
                    var newFiles = Array.from(inputFiles).filter(function (_, i) {
                        return i !== index;
                    });

                    var dt = new DataTransfer();
                    var hasFiles = false;

                    for (var i = 0; i < newFiles.length; i++) {
                        dt.items.add(newFiles[i]);
                        hasFiles = true;
                    }


                    if (hasFiles) {
                        $("#upload")[0].files = dt.files;
                    } else {
                        $("#upload").val(null);
                    }

                    pip.remove();
                    console.log(newFiles);
                });
            };
            fileReader.readAsDataURL(f);
        }
        console.log(files);
    });
}