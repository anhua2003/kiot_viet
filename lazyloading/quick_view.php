<?php
$nod        = $main->get('nod');

if ($act == 'view') {
    if ($nod == 'view') {
        $id = $main->post('id');
        $home = new home();
        $result = $home->getDetailProduct($id);
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
