<?php
    if($act == 'detail')
    {
        
    } else if($act == 'index') {
        $kiotviet = new kiotviet();
        $list_product = $kiotviet->getList('products');
        // $list_branch = $kiotviet->getList('branches');
        // echo '<pre>';
        // print_r($list_branch);
        // exit();
        $st->assign('list_product', $list_product);
    }
?>