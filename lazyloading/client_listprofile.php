<?php
$nod        = $main->get('nod');

if ($act == 'save') {
    if ($nod == 'save') {

        $members            = new members();

        $client_id          = $_SESSION['usernameClient'];
        $avatar             = $main->post('avatar');

        $members->set('user_id', $client_id);
        $dClient = $members->get_detail();

        if (isset($dClient['user_id'])) {

            $members->set('user_id', $dClient['user_id']);
            $members->set('avatar', $avatar);
            $members->update_info();

            echo 'done##', $main->toJsonData(200, 'success', null);
        }else{
            echo 'done##', $main->toJsonData(403, 'Không tìm thấy người dùng.', null);
        }
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
