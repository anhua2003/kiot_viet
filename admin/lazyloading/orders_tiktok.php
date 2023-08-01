<?php
$nod        = $main->get('nod');
if(isset($_SESSION['token']))
    {
        $client->setAccessToken($_SESSION['token']);
    }
if ($act == 'cancel') {
    if ($nod == 'cancel_order_tiktok') {
        $order_id = $main->post('order_id');
        $reason = $main->post('reason_key');
        $cancelOrder = $client->Reverse->cancelOrder($order_id, $reason);
        echo 'done##'.$main->toJsonData(200, 'Success', null);
    } else if($nod == 'getList_reverse_key') {
        $reverse = $client->Reverse->getRejectReasonList();
        echo 'done##'.$main->toJsonData(200, null, $reverse);
    }
} else {
    echo 'Missing action';
    $db->close();
    exit();
}
