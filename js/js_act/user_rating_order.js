var thePage = {}

$(document).on('click', '#rating_order', function() {
    let id_product = $(this).data("product-id");
    let order_id = $(this).data("order-id");
    thePage.openModal(id_product, order_id);
})

$(document).on('submit', '.review-form', function(e) {
    e.preventDefault();
    var imageArray = [];

    // Lặp qua từng thẻ <span> có lớp 'pip' và lấy đường dẫn ảnh
    $('.pip').each(function() {
    var img = $(this).find('img');
    var imgData = img.attr('src');
    
    // Thêm đường dẫn ảnh vào mảng
    imageArray.push(imgData);
    });

    // Gửi mảng chứa các đường dẫn ảnh qua Ajax hoặc thực hiện xử lý khác
    // console.log(imageArray); // Hiển thị mảng đường dẫn ảnh trong console
    if(imageArray.length == 0)
    {
        alert("Upload image please")
    }
    else {
        console.log(imageArray);
        let order_id = $("#_order_id").val();
        let formData = new FormData(document.getElementById("rating_form"));
        formData.append('img_list', imageArray);
        _doAjaxNod("POST", formData, "user", "rating_order", "insert", true, (res)=>{
            if(res.status == 200)
            {
                swal({
                    title: "Success",
                    text: "Thank you for your reviews",
                    icon: "success"
                }).then(response=>{
                    if(response) {
                        BootstrapDialog.closeAll();
                        thePage.render(res.data,order_id);
                    }
                });
            }
        })
    }
})

thePage.openModal = (id_product, order_id) => {
    BootstrapDialog.show({
        title: 'Product-id: ' + id_product,
        message: `<form class='review-form' id='rating_form'>
            <input type='hidden' name='order_id' id='_order_id' value='${order_id}'>
            <input type='hidden' name='id_product' value='${id_product}'>
            <textarea class='input' name='content' placeholder='Your Review'></textarea>
            <div class='input-rating'>
                <span>Your Rating: </span>
                <div class='stars'>
                    <input id='star5' class='rating_star' name='rating' value='5' type='radio'><label for='star5'></label>
                    <input id='star4' class='rating_star' name='rating' value='4' type='radio'><label for='star4'></label>
                    <input id='star3' class='rating_star' name='rating' value='3' type='radio'><label for='star3'></label>
                    <input id='star2' class='rating_star' name='rating' value='2' type='radio'><label for='star2'></label>
                    <input id='star1' class='rating_star' name='rating' value='1' type='radio'><label for='star1'></label>
                </div>
            </div>
            <div class='field' align='left' style='margin-bottom: 10px;'>
                <input type='file' id='files' name='files[]' multiple />
            </div>
            <button class='primary-btn'>Submit</button>
        </form>
        <style>
            input[type='file'] {
                display: block;
            }
            .imageThumb {
                max-height: 75px;
                border: 2px solid;
                padding: 1px;
                cursor: pointer;
            }
            .pip {
                display: inline-block;
                margin: 10px 10px 0 0;
            }
            .remove {
                display: block;
                background: #444;
                border: 1px solid black;
                color: white;
                text-align: center;
                cursor: pointer;
            }
            .remove:hover {
                background: white;
                color: black;
            }
        </style>
        <script>
        if (window.File && window.FileList && window.FileReader) {
            $("#files").on("change", function(e) {
                var files = e.target.files,
                    filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i];
                    var fileReader = new FileReader();
                    fileReader.onload = function(e) {
                        var file = e.target;
                        $("<span class='pip'>" +
                            "<img class='imageThumb' src='" + e.target.result + "' title='" + file.name + "'/>" +
                            "<br/><span class='remove'>x</span>" +
                            "</span>").insertAfter("#files");
                        $(".remove").click(function(){
                            var pip = $(this).closest(".pip");
                            var inputFiles = $("#files")[0].files;
                            var index = pip.index();
                            var newFiles = Array.from(inputFiles).filter(function(_, i) {
                                return i !== index;
                            });

                            var dt = new DataTransfer();
                            var hasFiles = false;

                            for (var i = 0; i < newFiles.length; i++) {
                                dt.items.add(newFiles[i]);
                                hasFiles = true;
                            }


                            if (hasFiles) {
                                $("#files")[0].files = dt.files;
                            } else {
                                $("#files").val(null);
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
        </script>`,
    });
        
}

thePage.render = (list_invoice, order_id) => {
    let content = '';
    let key = 0;
    list_invoice.forEach(function(item) {
        key++;
        if(item.status != 4)
        {
            rateBtn = '<td><button class="btn btn-primary" style="border-radius: 0; background-color: #D10024; border: none;" disabled>Rate</button></td>';
        } else {
            if(item.c_rate == 1)
            {
                rateBtn = '<td><button class="btn btn-primary" style="border-radius: 0; background-color: #D10024; border: none;" disabled>Rate</button></td>';
            } else {
                rateBtn = '<td><button class="btn btn-primary" id="rating_order" style="border-radius: 0; background-color: #D10024; border: none;" data-product-id="'+item.id_product+'" data-order-id="'+order_id+'">Rate</button></td>'
            }
        }
        content += `<tr>
        <td>${key}</td>
        <td><a href="/detail/${item.id_product}/${item.name_product}">${item.name_product}</a></td>
        <td>${number_format(item.price)}đ</td>
        <td>${item.quantity}</td>
        ${rateBtn}
        </tr>`;
    })
    $("#render_invoice").html(content)
}


  
//   function ImgUpload() {
//     var imgWrap = "";
//     var imgArray = [];
  
//     $('.upload__inputfile').each(function () {
//       $(this).on('change', function (e) {
//         imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
//         var maxLength = $(this).attr('data-max_length');
  
//         var files = e.target.files;
//         var filesArr = Array.prototype.slice.call(files);
//         var iterator = 0;
//         filesArr.forEach(function (f, index) {
  
//           if (!f.type.match('image.*')) {
//             return;
//           }
  
//           if (imgArray.length > maxLength) {
//             return false
//           } else {
//             var len = 0;
//             for (var i = 0; i < imgArray.length; i++) {
//               if (imgArray[i] !== undefined) {
//                 len++;
//               }
//             }
//             if (len > maxLength) {
//               return false;
//             } else {
//               imgArray.push(f);
  
//               var reader = new FileReader();
//               reader.onload = function (e) {
//                 var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
//                 imgWrap.append(html);
//                 iterator++;
//               }
//               reader.readAsDataURL(f);
//             }
//           }
//         });
//       });
//     });
  
//     $('body').on('click', ".upload__img-close", function (e) {
//       var file = $(this).parent().data("file");
//       for (var i = 0; i < imgArray.length; i++) {
//         if (imgArray[i].name === file) {
//           imgArray.splice(i, 1);
//           break;
//         }
//       }
//       $(this).parent().parent().remove();
//     });
//   }