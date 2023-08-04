var thePage = {};

$(document).on('click', '#add_categories', function() {
    BootstrapDialog.show({
        title: "Add category",
        message: `
        <form id="category_form">
            <label>Category name:</label>
            <div class="input-group input-group-outline">
                <input type="text" name="category_name" value="" class="form-control">
            </div>
        </form>
        `,
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
                let formData = new FormData(document.getElementById('category_form'));
                _doAjaxNod("POST", formData, "categories", "add", "add", true, (res) => {
                    if(res.status == 200)
                    {
                        window.location.reload();
                    }
                })
                // dialogItself.close();
            }
        }]
    });
})

$(document).on('click', '#delete_categories', function() {
    let id = $(this).data("category-id");
    BootstrapDialog.show({
        title: "Xóa",
        message: `
        Are you sure to xóa this nhóm hàng ?
        `,
        size: 'size-wide',
        buttons: [{
            label: ' Hủy',
            cssClass: 'btn-secondary btn-width',
            action: function (dialogItself) {
                dialogItself.close();
            }
        }, {
            label: ' Xóa',
            cssClass: 'btn bg-gradient-primary btn-width',
            action: function (dialogItself) {
                let formData = new FormData(document.getElementById('category_form'));
                formData.append('categoryId', id);
                _doAjaxNod("POST", formData, "categories", "delete", "delete", true, (res) => {
                    if(res.status == 200)
                    {
                        window.location.reload();
                    }
                })
                // dialogItself.close();
            }
        }]
    });
})

$(document).on('click', '#detail_categories', function() {
    let id = $(this).data("category-id");
    let formData = new FormData();
    formData.append('categoryId', id);
    _doAjaxNod("POST", formData, "categories", "edit", "detail", true, (res) => {
        if(res.status == 200) 
        {
            console.log(res.data);
            BootstrapDialog.show({
                title: "Xóa",
                message: `
                <form id="category_form">
                    <label>Category name:</label>
                    <div class="input-group input-group-outline">
                        <input type="text" name="category_name" value="" class="form-control">
                    </div>
                </form>
                `,
                size: 'size-wide',
                buttons: [{
                    label: ' Hủy',
                    cssClass: 'btn-secondary btn-width',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }, {
                    label: ' Xóa',
                    cssClass: 'btn bg-gradient-primary btn-width',
                    action: function (dialogItself) {
                        let formData = new FormData();
                        formData.append('categoryId', id);
                        _doAjaxNod("POST", formData, "categories", "delete", "delete", true, (res) => {
                            if(res.status == 200)
                            {
                                window.location.reload();
                            }
                        })
                        // dialogItself.close();
                    }
                }]
            });
        }
    })
})