
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
            <button class="btn btn-primary" id="add_categories" style="width: 20%; margin-left: 10px;">Add</button>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">id</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category Name</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    {foreach $categories['data'] as $key=>$item}
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{$item.categoryId}</h6>
                            
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{$item.categoryName}</p>
                        <p class="text-xs text-secondary mb-0">{$item.createdDate}</p>
                      </td>
                      
                      <td class="align-middle">
                        <a href="javascript:;" id="detail_categories" data-category-id="{$item.categoryId}" class="text-secondary font-weight-bold text-xs">
                          Sửa
                        </a>
                        <a href="javascript:;" id="delete_categories" data-category-id="{$item.categoryId}" class="text-secondary font-weight-bold text-xs">
                          Xóa
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