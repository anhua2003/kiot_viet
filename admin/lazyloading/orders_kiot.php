<?php
$nod        = $main->get('nod');

if ($act == 'cancel') {
    if ($nod == 'cancel') {
        $order_id = $main->post('order_id');
        $kiotviet = new kiotviet();
        $kiotviet->Delete_orders($order_id);
        echo 'done##'.$main->toJsonData(200, null, null);
        $db->close();
        exit();
    }
} else {
    echo 'Missing action';
    $db->close();
    exit();
}
