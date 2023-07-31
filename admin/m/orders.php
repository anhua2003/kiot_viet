<?php
    $kiotviet = new kiotviet();
    if($act == 'index')
    {
        $orders = $kiotviet->getList('orders');
        $st->assign('orders', $orders);
    } else if ($act == 'detail') {
        $id = $main->get('id');
        $orders_detail = $kiotviet->get_instance('orders', $id);
        $st->assign('orders_detail', $orders_detail);
    }
?>