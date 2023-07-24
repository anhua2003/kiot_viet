<?php
    if($act == 'index')
    {
        $user1 = new user1();
        $title .= "Account";
        $id = $_SESSION['id'];
        $result = $user1->getInfoAccount($id);
        $list_invoice = $user1->getOrder_id($id);
        $st->assign('account', $result);
        $st->assign('list_invoice', $list_invoice);
        $orders = $client->Order->getOrderList([
            // 'order_status' => 100, // Unpaid order
            'page_size' => 50,
        ]);
        $st->assign('orderList', $orders);
    } else if($act == 'rating_order')
    {
        $title .= 'Order detail';
        $id = $main->get('order_id');
        $user1 = new user1();
        $result = $user1->get_detail_invoice($id);
        $st->assign('list_order', $result[0]);
        $st->assign('total', $result[1]['total']);
        $st->assign('order_id', $id);
    } else if($act == 'order_tiktok_detail')
    {
        $title .= 'Order_tiktok_detail';
        $id = $main->get('order_id');
        $orders = $client->Order->getOrderDetail($id);
        $st->assign('orderDetail', $orders);
    }
?>   