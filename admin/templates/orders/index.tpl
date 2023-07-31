
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
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Order id</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    {foreach $orders['data'] as $key=>$item}
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{$item.customerName}</h6>
                            
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{$item.id}</p>
                        <p class="text-xs text-secondary mb-0">{$item.code}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                      <span class="text-secondary text-xs font-weight-bold">{number_format($item.total)}đ</span>
                      
                        
                      </td>
                      <td class="align-middle text-center">
                      {if $item.status == 4}
                      <span class="badge badge-sm bg-gradient-danger">{$item.statusValue}</span>
                      {else if $item.status == 3}
                      <span class="badge badge-sm bg-gradient-success">{$item.statusValue}</span>
                      {else}
                      <span class="badge badge-sm bg-gradient-warning">{$item.statusValue}</span>
                      {/if}
                      
                      </td>
                      <td class="align-middle">
                        <a href="/admin/?m=orders&act=detail&id={$item.id}" class="text-secondary font-weight-bold text-xs">
                          View
                        </a>
                        {if $item.status == 1 || $item.status == 2}
                        <a href="javascript:;" id="delete_order" data-order-id="{$item.id}" class="text-secondary font-weight-bold text-xs">
                          Hủy
                        </a>
                        {/if}
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