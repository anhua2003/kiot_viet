
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
              <label class="upload_label">Tải lên
                        <input type='file' id='upload' name='files[]' multiple />
                    </label>
                
                    <div class="show_img">
                   
                    </div>
            </div>
          </div>
        </div>
      </div>
      <button id="edit_product" data-product-id="{$product_detail['product_id']}">Edit</button>
      <style>        
                .upload_label {
                    color: #111;
                    text-transform: uppercase;
                    font-size: 14px;
                    cursor: pointer;
                    white-space: nowrap;
                    padding: 4px;
                    border-radius: 3px;
                    min-width: 60px;
                    width: 100%;
                    max-width: 80px;
                    
                    font-weight: 400;
                    -webkit-font-smoothing: antialiased;
                    -moz-osx-font-smoothing: grayscale;
                    background: #fff;
                    animation: popDown 300ms 1 forwards;
                    transform: translateY(-10px);
                    opacity: 1;
                    display: block;
                    transition: background 200ms, color 200ms;
                  }
                  
                  
                  .upload_label:hover {
                    color: #fff;
                    background: #222;
                  }
                  
                  
                  #upload {
                    width: 100%;
                    opacity: 0;
                    height: 0;
                    overflow: hidden;
                    display: block;
                    padding: 0;
                    
                  }
                  
                
                    
                    .imageThumb {
                        max-height: 75px;
                        border: 2px solid;
                        padding: 1px;
                        cursor: pointer;
                    }
                    .pip {
                        display: inline-block;
                        margin: 10px 10px 0 0;
                    }
                    .remove {
                        display: block;
                        background: #444;
                        border: 1px solid black;
                        color: white;
                        text-align: center;
                        cursor: pointer;
                    }
                    .remove:hover {
                        background: white;
                        color: black;
                    }
                </style>