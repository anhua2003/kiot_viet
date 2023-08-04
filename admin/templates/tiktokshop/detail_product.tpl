<pre>
{print_r($product_detail)}
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
            <form id="edit_form">
                Product name: <input type="text" name="product_name" value="{$product_detail['product_name']}" />
                Price: <input type="number" name="price" value="{$product_detail['skus'][0]['price']['original_price']}" />
                Stock:<input type="number" name="stock" value="{$product_detail['skus'][0]['stock_infos'][0]['available_stock']}" />
                <div class="d-flex">
                {foreach $product_detail['images'] as $item}
                <img src="{$item.thumb_url_list[0]}" class="w-10" />
                {/foreach}
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <button id="edit_product" data-product-id="{$product_detail['product_id']}">Edit</button>