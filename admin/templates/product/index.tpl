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
            <button class="btn btn-primary" id="add_product" style="width: 20%; margin-left: 10px;">Add</button>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">SKU_ID</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Inventory</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    {foreach $list_product['data'] as $key=>$item}
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="{$item.images[0]}" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{$item.name}</h6>
                            
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{$item.code}</p>
                        <p class="text-xs text-secondary mb-0">{$item.categoryName}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-success">{number_format($item.basePrice)}đ</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">0</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" id="edit_product" data-product-id="{$item.id}" class="text-secondary font-weight-bold text-xs">
                          Edit
                        </a>
                        <a href="javascript:;" id="delete_product" data-product-id="{$item.id}" class="text-secondary font-weight-bold text-xs">
                          Delete
                        </a>
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