
    <div class="view-account">
        <section class="module">
            <div class="module-inner">
                <div class="side-bar">
                    <div class="user-info">
                        <div id="img_avatar1">
                        {if $account.avatar == ''}
                            <img class="img-profile img-circle img-responsive center-block" src="./public/img/user/user.jpg" alt="">
                        {else}
                            <img class="img-profile img-circle img-responsive center-block" src="./public/img/user/{$smarty.session.id}/{$account.avatar}?{time()}" alt="">
                        {/if}
                        </div>
                        <ul class="meta list list-unstyled">
                            <li class="name" id="show_name">
                                {$account.user_name}
                            </li>
                        </ul>
                    </div>
            		<nav class="side-menu">
        				<ul class="nav">
        					<li class="active"><a data-toggle="tab" href="#tab1"><span class="fa fa-user"></span> Information</a></li>
        					<li><a data-toggle="tab" href="#tab2"><span class="fa fa-credit-card"></span> My order</a></li>
        					<li><a data-toggle="tab" href="#tab3"><span class="fa fa-lock"></span> Change password</a></li>
        				</ul>
        			</nav>
                </div>
                <div class="content-panel">
                    <div class="products-tabs">
                        <div id="tab1" class="tab-pane active" style="overflow-x: hidden;">
                                <h2 class="title">Personal information</h2>
                                <form class="form-horizontal">
                                    <fieldset class="fieldset">
                                        <h3 class="fieldset-title">Personal Info</h3>
                                        <div class="form-group avatar">
                                            <figure class="figure col-md-2 col-sm-3 col-xs-12" id="img_avatar2">
                                                {if $account.avatar == ''}
                                                <img class="img-rounded img-responsive" src="./public/img/user/user.jpg" alt="">
                                                {else}
                                                <img class="img-rounded img-responsive" src="./public/img/user/{$smarty.session.id}/{$account.avatar}?{time()}" alt="">
                                                {/if}
                                            </figure>
                                            <div class="form-inline col-md-10 col-sm-9 col-xs-12">
                                                <input type="file" id="file_avatar" accept="image/*" style="display: none;" class="file-uploader pull-left">
                                                <button type="button" class="btn btn-sm btn-default-alt pull-left" id="pick_img">Choose images</button>
                                                <button type="button" style="display: none;" id="update_img" class="btn btn-sm btn-default-alt pull-left update_image">Update Image</button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-3 col-xs-12 control-label">Name</label>
                                            <div class="col-md-10 col-sm-9 col-xs-12">
                                                <input type="text" id="user_name" class="form-control" value="{$account.user_name}">
                                            </div>
                                        </div>
                    
                                        
                                    </fieldset>
                                    <fieldset class="fieldset">
                                        <h3 class="fieldset-title">Contact Info</h3>
                                        <div class="form-group">
                                            <label class="col-md-2  col-sm-3 col-xs-12 control-label">Email</label>
                                            <div class="col-md-10 col-sm-9 col-xs-12">
                                                <input type="email" id="email" class="form-control" value="{$account.email}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2  col-sm-3 col-xs-12 control-label">Address</label>
                                            <div class="col-md-10 col-sm-9 col-xs-12">
                                                <input type="text" id="address" class="form-control" value="{$account.address}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2  col-sm-3 col-xs-12 control-label">Phone</label>
                                            <div class="col-md-10 col-sm-9 col-xs-12">
                                                <input type="text" id="phone" class="form-control" value="{$account.phone}">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <hr>
                                    <div class="form-group">
                                        <div class="col-md-10 col-sm-9 col-xs-12 col-md-push-2 col-sm-push-3 col-xs-push-0">
                                            <input class="btn btn-primary" style="background-color: #D10024; border: 0px; border-radius: 0px;" type="button" id="update_profile" value="Update profile">
                                        </div>
                                    </div>
                                </form>
                            
                        </div>

                        <div id="tab2" class="tab-pane">
                            <!-- Billing history card-->
                            <div class="card mb-4">
                                <div class="card-header">My Order</div>
                                <div class="card-body p-0">
                                    <!-- Billing history table-->
                                    <div class="table-responsive table-billing-history">
                                    {if $list_invoice|count == 0}
                                                    Không có hóa đơn nào
                                    {else}
                                        <table class="table mb-0">
                                            
                                                <tr>
                                                    <th class="border-gray-200" scope="col">#</th>
                                                    <th class="border-gray-200" scope="col">Date</th>
                                                    <th class="border-gray-200" scope="col">Total</th>
                                                    <th class="border-gray-200" scope="col">Status</th>
                                                </tr>
                                            
                                            
                                                
                                                {foreach $list_invoice as $item}
                                                <tr>
                                                    <td>#{$item.order_id}</td>
                                                    <td>{$item.date_buy}</td>
                                                    <td>{number_format($item.total)}đ</td>
                                                    <td><span class="badge bg-primary text-dark">{$item.status_name}</span></td>
                                                    <td><a href="/order-detail/id={$item.order_id}">Detail</a></td>
                                                </tr>
                                                {/foreach}
                                                
                                            
                                        </table>
                                    {/if}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="tab3" class="tab-pane" style="overflow-x: hidden;">
                            <div class="card">
                                <div class="card-header">
                                    Change Password
                                </div>
                                <div class="card-body">
                                    <div class="container d-flex" style="padding: 10px;">
                                        <h6>Current password: </h6>
                                        <input type="password" id="old_pass" class="form-control" style="width: auto;" placeholder="Your current password">
                                        </br>
                                        <h6>New password: </h6>
                                        <input type="password" id="new_pass" class="form-control" style="width: auto;" placeholder="Your new password">
                                        <button class="btn btn-primary" id="change_pass" style="margin-top: 10px; background-color: #D10024; border: 0px; border-radius: 0px;">Save</button>
                                    </div>
                                </div>
                                <div class="card-footer">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


<script>
    var fileInput = document.getElementById('file_avatar');
    var fileLabel = document.getElementById('pick_img');
    var uploadButton = document.getElementById('update_img');
    fileLabel.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        if(fileInput.value)
        {
            uploadButton.style.display = 'block';
        } else {
            uploadButton.style.display = 'none';
        }
    })

    uploadButton.addEventListener('click', function() {
        uploadButton.style.display = 'none';
    })
</script>