<?php
    if($act == 'detail')
    {
        
    } else if($act == 'index') {
        $kiotviet = new kiotviet();
        $list_product = $kiotviet->getList('products');
        // echo '<pre>';
        // print_r($list_product['data']);
        // exit();
        $st->assign('list_product', $list_product);
    }
?>