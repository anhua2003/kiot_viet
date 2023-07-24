<?php
$nod        = $main->get('nod');

if ($act == 'save') {
    if ($nod == 'save') {
        $category_list = $main->post('category_list');
        $product = new product();
        $result = $product->filterProduct($category_list);
        echo 'done##'.$main->toJsonData(200, null, $result);
        $db->close();
        exit();
    } else if($nod == 'pagination') {
        $page = $main->post('page');
        $limit = $main->post('limit');
        $key = $main->post('key');
        $product = new product();
        if($key == '')
        {
            $result = $product->paginationProduct($page, $limit);
        } else {
            $result = $product->paginationProduct_search($page, $limit, $key);

        }
        echo 'done##'.$main->toJsonData(200, null, $result);
        $db->close();
        exit();
    } else if ($nod == 'price') {
        $price_min = $main->post('price_min');
        $price_max = $main->post('price_max');
        $product = new product();
        $result = $product->filter_price($price_min, $price_max);
        echo 'done##'.$main->toJsonData(200, null, $result);
        $db->close();
        exit();
    } else {
        echo 'Missing action';
        $db->close();
        exit();
    }
} else {
    echo 'Missing action';
    $db->close();
    exit();
}