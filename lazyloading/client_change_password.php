<?php
$nod        = $main->get('nod');

if ($act == 'update') {
    if ($nod == 'change_password') {

        $oldPass                = $main->post('oldPass');
        $newPass                = $main->post('newPass');
        $reNewPass              = $main->post('reNewPass');

        $members = new members();

        $members->set('user_id', isset($_SESSION['usernameClient']) ? $_SESSION['usernameClient'] : '');
        $dM = $members->get_detail();

        if (isset($dM['user_id'])) {
            if (md5(md5($oldPass) . $dM['salt']) == $dM['password']) {
                $members->set('password', md5(md5($newPass) . $dM['salt']));
                $members->update_info();

                $_SESSION['passwordClient'] = md5(md5($newPass) . $dM['salt']);
                echo "done##", $main->toJsonData(200, 'success', null);
            } else {
                echo "done##", $main->toJsonData(403, 'Mật khẩu cũ không đúng.', null);
            }
        } else {
            echo "done##", $main->toJsonData(403, 'Người dùng không tồn tại', null);
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
