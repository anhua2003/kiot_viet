<div class="container" style="margin-top: 10px;">
    <div class="card" style="margin-bottom: 10px;">
        <div class="card-header">
            Shipment Details
        </div>
        <div class="card-body">
        </prev>
            <table class="table table-bordered">
                    <tr>
                        <th>Name:</th>
                        <td>{$orderDetail['order_list'][0]['recipient_address']['name']}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>?</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>{$orderDetail['order_list'][0]['recipient_address']['full_address']}</td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td>?</td>
                    </tr>
            </table>  
        </div>
    </div>
    <div class="card" id="show_item_cart">
        <div class="card-header">
            Invoice information
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Product name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Sale</th>
                        </tr>
                        </thead>
                        <tbody id="render_invoice">
                            {foreach $orderDetail['order_list'][0]['item_list'] as $key=>$item}
                            <tr>
                                <td>{$key+1}</td>
                                <td><a href="/detail/{$item.product_id}/{$item.product_name}"><img src="{$item.sku_image}" width="10%" />{$item.product_name}</a></td>
                                <td>{number_format($item.sku_original_price)}đ</td>
                                <td>{$item.quantity}</td>
                                <td>{$item.sku_seller_discount}</td>
                            </tr>
                        {/foreach}
                        </tbody>
                </table>
            </div>
            <div class="container">
                <h5>Sale: 0%</h5>
                <h5>Total: {number_format($orderDetail['order_list'][0]['payment_info']['total_amount'])}đ</h5>
            </div>
        </div>
    </div>
</div>