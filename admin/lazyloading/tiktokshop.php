<?php
$nod        = $main->get('nod');

if(isset($_SESSION['token']))
    {
        $client->setAccessToken($_SESSION['token']);
    }
if ($act == 'product') {
    if($nod == 'edit') {
        $product_id = $main->post('product_id');
        // $data = array('product_name' => $main->post('product_name'), 
        // 'stock_infos' => $main->post('stock'), 'price' => $main->post('price'), 'description' => 'adu');
        $data['product_name'] = $main->post('product_name');
        $data['description'] = 'adu';
        $data['category_id'] = '601213';
        // $data['brand_id'] = '7158094830659340038';
        $data['package_weight'] = '0.01';
        $data['skus'] = array(  'id'=> 1729671560796277504, 
                                'price' => array('currency' => 'VND', 'original_price' => 1), 
                                // 'sales_attributes' => array(array(   'id'=>7262242688203310854, 
                                //                                     'name' => 'Specification', 
                                //                                     'value_id' => 7262242688203327238, 
                                //                                     'value_name' => 'Default')), 
                                'seller_sku' => null, 
                                'stock_infos' => array(array('warehouse_id' =>"7261661409196427013",
                                                            'available_stock' => 1)),
                                'original_price' => 100
                            );
        echo '<pre>';
        print_r($data);
        // exit();
        $result = $client->Product->editProduct($product_id, $data);
        if($result){
        echo 'done##'.$main->toJsonData(200, null, $result);
        }
    }
 } else {
    echo 'Missing action';
    $db->close();
    exit();
}
