<div class="container" style="margin-top: 10px;">
    <div class="card" style="margin-bottom: 10px;">
        <div class="card-header">
            Shipment Details
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                    <tr>
                        <th>Name:</th>
                        <td>{$list_order[0]['name']}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{$list_order[0]['email']}</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>{$list_order[0]['address']}</td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td>{$list_order[0]['phone']}</td>
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
                            <th>Rating</th>
                        </tr>
                        </thead>
                        <tbody id="render_invoice">
                            {foreach $list_order as $key=>$item}
                            <tr>
                                <td>{$key+1}</td>
                                <td><a href="/detail/{$item.id_product}/{$item.name_product}">{$item.name_product}</a></td>
                                <td>{number_format($item.price)}đ</td>
                                <td>{$item.quantity}</td>
                                {if $item.status != 4}
                                <td><button class="btn btn-primary" style="border-radius: 0; background-color: #D10024; border: none;" disabled>Rate</button></td>
                                {else}
                                {if $item.c_rate == 1}
                                <td><button class="btn btn-primary" style="border-radius: 0; background-color: #D10024; border: none;" disabled>Rate</button></td>
                                {else}
                                <td><button class="btn btn-primary" id="rating_order" style="border-radius: 0; background-color: #D10024; border: none;" data-product-id="{$item.id_product}" data-order-id="{$order_id}">Rate</button></td>
                                {/if}
                                {/if}
                            </tr>
                        {/foreach}
                        </tbody>
                </table>
            </div>
            <div class="container">
                <h5>Sale: 0%</h5>
                <h5>Total: {number_format($total)}đ</h5>
            </div>
        </div>
    </div>
</div>