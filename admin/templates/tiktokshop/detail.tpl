<pre>
{print_r($orderDetail)}
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Kiot_shop</h6>
              </div>
            </div>
            <br>
            
            <div class="card-body px-0 pb-2">
                <div class="container">
                    <h4>Information</h4>
                    <div class="table-responsive p-0">
                        <table class="table table-bordered align-items-center mb-0">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Receiver</th>
                                <td>{$orderDetail['order_list'][0]['recipient_address']['name']}</td>
                            </tr>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                                <td>{$orderDetail['order_list'][0]['recipient_address']['full_address']}</td>
                            </tr>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total product price</th>
                                <td>{number_format($orderDetail['order_list'][0]['payment_info']['original_total_product_price'])}đ</td>
                            </tr>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fee Shipping</th>
                                <td>{number_format($orderDetail['order_list'][0]['payment_info']['original_shipping_fee'])}đ</td>
                            </tr>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                <td>{number_format($orderDetail['order_list'][0]['payment_info']['total_amount'])}đ</td>
                            </tr>
                        </table>
                    </div>
                    <h4>List orders</h4>
                </div>
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Product id</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Discount</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                    </tr>
                  </thead>
                  <tbody>
                  {foreach $orderDetail['order_list'][0]['item_list'] as $key=>$item}
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <div>
                                <img src="{$item.sku_image}" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">{$item.product_name}</h6>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{$item.product_id}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                      <span class="text-secondary text-xs font-weight-bold">{$item.quantity}</span>
                      
                        
                      </td>
                      <td class="align-middle text-center text-sm">
                      <span class="text-secondary text-xs font-weight-bold">{$item.sku_seller_discount}%    </span>
                      
                        
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-secondary text-xs font-weight-bold">{number_format($item.sku_original_price)}đ</span>
                      </td>
                    </tr>
                    {/foreach}
                    
                  </tbody>
                </table>
                
              </div>
            </div>
          </div>
        </div>
      </div>