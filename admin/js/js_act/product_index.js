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
                img += '<img src="'+item+'" style="padding-right: 4px;" width="20%" height="20%"/>';
            })
            BootstrapDialog.show({
                title: "Id:"+res.data['id'],
                message: `<form id="update_form">
                <label class="form-label">Name</label>
                <div class="input-group input-group-outline">
                  <input type="text" name="Name" value="${res.data['fullName']}" class="form-control">
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
                ${img}
                </form>`,
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
                        let formData = new FormData(document.getElementById('update_form'));
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
        <br>
        <input type="file" name="imgs"/>
        </form>`,
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
                let formData = new FormData(document.getElementById('add_form'));
                _doAjaxNod("POST", formData, "products", "add", "add", true, (res) => {
                    if(res.status == 200)
                    {
                        // window.location.reload();
                    }
                })
                // dialogItself.close();
            }
        }]
    });
})

thePage.update = (formData) => {
    _doAjaxNod("POST", formData, "products", "product_detail", "update", true, (res) => {
        
    })
}