<?php
$nod        = $main->get('nod');

if ($act == 'save') {
    if ($nod == 'save') {
        $keyword = $main->post('keyword');
        $product = new product();
        $result = $product->searchProduct($keyword);
        echo 'done##'.$main->toJsonData(200, null, $result);
        $db->close();
        exit();
        
        // $main->redirect('/dang-nhap');
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
