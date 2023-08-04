
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
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Id</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                      <th class="text-secondary opacity-7"></th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    {foreach $product_list['products'] as $key=>$item}
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"></h6>
                            {$item.id}
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{$item.name}</p>
                      </td>
                      <td class="align-middle text-center">
  
                        <p>{foreach $item.skus as $i} {number_format($i.price.original_price)} {$i.price.currency} {/foreach}</p>
                        
                        </td>
                      <td class="align-middle text-center">
  
                        <p>{foreach $item.skus as $i} {foreach $i.stock_infos as $x} {$x.available_stock} {/foreach} {/foreach}</p>
                        
                        </td>
                      <td><a href="/admin/?m=tiktokshop&act=detail_product&id={$item.id}" class="btn btn-primary">View</a></td>
                    </tr>
                    {/foreach}
                    
                    
                  </tbody>
                </table>
                
              </div>
            </div>
          </div>
        </div>
      </div>