var thePage = {};

$(document).on('click', '#edit_product', function() {
    let product_id = $(this).data('product-id');
    let formData = new FormData();
    formData.append("product_id", product_id);
    _doAjaxNod("POST", formData, "products", "product_detail", "get", true, (res) => {
        if(res.status == 200)
        {
            console.log(res.data);
            let onHand = 0;
            let img = '';
            res.data['inventories'].forEach(function(item) {
                onHand += item.onHand;
            })
            res.data['images'].forEach(function(item) {
                img += `<span class='pip'>
                <img class='imageThumb' src='${item}'/>
                <br/><span class='remove'>x</span>
                </span>`;
            })
            BootstrapDialog.show({
                title: "Id:"+res.data['id'],
                message: `<form id="update_form">
                <label class="form-label">Name</label>
                <div class="input-group input-group-outline">
                  <input type="text" name="Name" value="${res.data['name']}" class="form-control">
                </div>
                <label class="form-label">Code</label>
                <div class="input-group input-group-outline">
                  <input type="text" name="Code" value="${res.data['code']}" class="form-control">
                </div>
                <label class="form-label">Price</label>
                <div class="input-group input-group-outline">
                  <input type="number" name="Price" value="${res.data['basePrice']}" class="form-control">
                </div>
                <label class="form-label">onHand</label>

                <div class="input-group input-group-outline">
                  <input type="number" name="onHand" value="${onHand}" class="form-control">
                </div>
                <br>
                <label class="upload_label" style="margin-top: 20px;">Tải lên
                <input type='file' id='upload' name='files[]' multiple />
                </label>
                <div class="show_img">
                    ${img}
                </div>
                </form>
    <style>        
    .upload_label {
        color: #111;
        text-transform: uppercase;
        font-size: 14px;
        cursor: pointer;
        white-space: nowrap;
        padding: 4px;
        border-radius: 3px;
        min-width: 60px;
        width: 100%;
        max-width: 80px;
        
        font-weight: 400;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        background: #fff;
        animation: popDown 300ms 1 forwards;
        transform: translateY(-10px);
        opacity: 1;
        display: block;
        transition: background 200ms, color 200ms;
      }
      
      
      .upload_label:hover {
        color: #fff;
        background: #222;
      }
      
      
      #upload {
        width: 100%;
        opacity: 0;
        height: 0;
        overflow: hidden;
        display: block;
        padding: 0;
        
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
    </style>`,
                size: 'size-wide',
                buttons: [{
                    label: ' Hủy',
                    cssClass: 'btn-secondary btn-width',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }, {
                    label: ' Update',
                    cssClass: 'btn bg-gradient-primary btn-width',
                    action: function (dialogItself) {
                        let imageArray = [];
                        // Lặp qua từng thẻ <span> có lớp 'pip' và lấy đường dẫn ảnh
                        $('.pip').each(function() {
                        let img = $(this).find('img');
                        let imgData = img.attr('src');
                        
                        // Thêm đường dẫn ảnh vào mảng
                        imageArray.push(imgData);
                        });
                        let formData = new FormData(document.getElementById('update_form'));
                        imageArray.forEach(function(item) {
                            formData.append("img[]", item);
                        })
                        formData.append('id_product', product_id);
                        thePage.update(formData);
                        window.location.reload();
                        // dialogItself.close();
                    }
                }]
            });
        }
    })
})

$(document).on('click', '#delete_product', function() {
    let id_product = $(this).data('product-id');
    let formData = new FormData();
    formData.append("id_product", id_product);
    _doAjaxNod("POST", formData, "products", "delete", "delete", true, (res) => {
        if(res.status == 200)
        {
            window.location.reload();
        }
    })
})

$(document).on('click', '#add_product', function() {
    let formData = new FormData();
    _doAjaxNod("POST", formData, "products", "categories", "get", true, (res) => {
        if(res.status == 200)
        {
            
            let option = '';
            // let data = res.data;
            res.data.data.forEach(function(item) {
                option += `<option value="${item.categoryId}">${item.categoryName}</option>`;
            })
            BootstrapDialog.show({
                title: "Add product",
                message: `<form id="add_form">
                <label class="form-label">Name</label>
                <div class="input-group input-group-outline">
                  <input type="text" name="Name" value="" class="form-control">
                </div>
                <label class="form-label">Code</label>
                <div class="input-group input-group-outline">
                  <input type="text" name="Code" value="" class="form-control">
                </div>
                <label class="form-label">Price</label>
                <div class="input-group input-group-outline">
                  <input type="number" name="Price" value="" class="form-control">
                </div>
                <label class="form-label">onHand</label>
                <div class="input-group input-group-outline">
                  <input type="number" name="onHand" value="" class="form-control">
                </div>
                <label class="form-label">Categories</label>
                <div class="input-group input-group-outline">
                  <select name="selected_category">
                    <option>Choose your categories</option>
                    ${option}
                  </select>
                </div>
                <br>
                
               
                    
        
                    <label class="upload_label">Tải lên
                        <input type='file' id='upload' name='files[]' multiple />
                    </label>
                
                    <div class="show_img">
                   
                    </div>
                    
                    
                </form>
                <style>        
                .upload_label {
                    color: #111;
                    text-transform: uppercase;
                    font-size: 14px;
                    cursor: pointer;
                    white-space: nowrap;
                    padding: 4px;
                    border-radius: 3px;
                    min-width: 60px;
                    width: 100%;
                    max-width: 80px;
                    
                    font-weight: 400;
                    -webkit-font-smoothing: antialiased;
                    -moz-osx-font-smoothing: grayscale;
                    background: #fff;
                    animation: popDown 300ms 1 forwards;
                    transform: translateY(-10px);
                    opacity: 1;
                    display: block;
                    transition: background 200ms, color 200ms;
                  }
                  
                  
                  .upload_label:hover {
                    color: #fff;
                    background: #222;
                  }
                  
                  
                  #upload {
                    width: 100%;
                    opacity: 0;
                    height: 0;
                    overflow: hidden;
                    display: block;
                    padding: 0;
                    
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
                </style>`,
                size: 'size-wide',
                buttons: [{
                    label: ' Hủy',
                    cssClass: 'btn-secondary btn-width',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }, {
                    label: ' Add',
                    cssClass: 'btn bg-gradient-primary btn-width',
                    action: function (dialogItself) {
                        let imageArray = [];
                        // Lặp qua từng thẻ <span> có lớp 'pip' và lấy đường dẫn ảnh
                        $('.pip').each(function() {
                        let img = $(this).find('img');
                        let imgData = img.attr('src');
                        
                        // Thêm đường dẫn ảnh vào mảng
                        imageArray.push(imgData);
                        });
                        let formData = new FormData(document.getElementById('add_form'));
                        imageArray.forEach(function(item) {
                            formData.append("img[]", item);
                        })
                        if(imageArray.length == 0)
                        {
                            alert("Please choose image");
                        } else {
                            _doAjaxNod("POST", formData, "products", "add", "add", true, (res) => {
                                if(res.status == 200)
                                {
                                    window.location.reload();
                                }
                            })
                            // dialogItself.close();
                        }
                    }
                }]
            });
            console.log(res.data);
        }
    })
    
})
// $(document).on('click', '#fopen_btn', function() {
//     $("#upload").click();
// })

    if (window.File && window.FileList && window.FileReader) {
        
        $(document).on("change", "#upload", function(e) {
            var files = e.target.files,
                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i];
                var fileReader = new FileReader();
                fileReader.onload = function(e) {
                    var file = e.target;
                    $('.show_img').append("<span class='pip'>" +
                    "<img class='imageThumb' src='" + e.target.result + "' title='" + file.name + "'/>" +
                    "<br/><span class='remove'>x</span>" +
                    "</span>");
                    $(".remove").click(function(){
                        var pip = $(this).closest(".pip");
                        var inputFiles = $("#upload")[0].files;
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

    $(document).on('click', '.remove', function(){
        var pip = $(this).closest(".pip");
        var inputFiles = $("#upload")[0].files;
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
            $("#upload")[0].files = dt.files;
        } else {
            $("#upload").val(null);
        }

        pip.remove();
        console.log(newFiles);
    });


thePage.update = (formData) => {
    _doAjaxNod("POST", formData, "products", "product_detail", "update", true, (res) => {
        
    })
}