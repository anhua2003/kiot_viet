<?php
$nod        = $main->get('nod');

if ($act == 'product_detail') {
    if ($nod == 'get') {
        $product_id = $main->post('product_id');
        $kiotviet = new kiotviet();
        $result = $kiotviet->get_instance('products', $product_id);
        echo 'done##'.$main->toJsonData(200, null, $result);
        $db->close();
        exit();
    } else if($nod == 'update') {
        $id = $main->post('id_product');
        $name = $main->post('Name');
        $code = $main->post('Code');
        $price = $main->post('Price');
        $kiotviet = new kiotviet();
        $result = $kiotviet->update_products($id, $name, $code, $price);
        echo $result;
        $db->close();
        exit();
    }
} else if($act == 'delete') {
    if($nod == 'delete') {
        $id = $main->post('id_product');
        $kiotviet = new kiotviet();
        $kiotviet->Delete_product($id);
        echo 'done##'.$main->toJsonData(200, null, null);
    }
} else if($act == 'add') {
    if($nod == 'add') {
        $post = [];
        $post['name'] = $main->post('Name');
        $post['code'] = $main->post('Code');
        $post['price'] = $main->post('Price');
        $kiotviet = new kiotviet();
        $kiotviet->add_product($post);
        echo 'done##'.$main->toJsonData(200, null, null);
    }
} else {
    echo 'Missing action';
    $db->close();
    exit();
}
