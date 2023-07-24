<?php
$nod        = $main->get('nod');

if ($act == 'register') {

    if ($nod == 'register') {
        $members = new members();

        $fullname   = $main->post('fullname');
        $email      = $main->post('email');
        $mobile     = $main->post('mobile');
        $password   = $main->post('password');

        if ($main->post('mobile') != '' && $members->is_exist_mobile_or_email($main->post('mobile'))) {
            echo 'done##', $main->toJsonData(403, 'Số điện thoại này đã được sử dụng', null);
        } else if ($main->post('email') != '' && $members->is_exist_mobile_or_email($main->post('email'))) {
            echo 'done##', $main->toJsonData(403, 'Email này đã được sử dụng', null);
        } else {
            $members->set('created_by', 'Tự đăng ký');
            $members->set('user_id', '');
            $members->set('shop_id', 1);
            $members->set('fullname', $fullname);
            $members->set('mobile', $mobile);
            $members->set('email', $email);
            $members->set('password', $password);
            $user_id = $members->add();

            $members->set('user_id', $user_id);
            $dLogin = $members->get_detail();

            if (isset($dLogin['user_id'])) {

                $_SESSION['usernameClient']     = $dLogin['user_id'];
                $_SESSION['fullnameClient']     = $dLogin['fullname'];
                $_SESSION['passwordClient']     = $dLogin['password'];

                setcookie('usernameClient', $_SESSION['usernameClient'], time() + 640000);
                setcookie('passwordClient', $_SESSION['passwordClient'], time() + 640000);

                echo 'done##', $main->toJsonData(200, 'success', null);
            } else {
                echo 'done##', $main->toJsonData(403, 'Lỗi trong quá trình đăng ký.', null);
            }
        }
    } else {
        echo 'Missing Nod';
        $db->close();
    }
} elseif ($act == 'login') {
    if ($nod == 'login') {

        $members = new members();
        $username         = $main->post('username');
        $password         = $main->post('password');

        if (isset($_SESSION['usernameClient']) && isset($_SESSION['passwordClient'])) {

            $members->set('user_id', $_SESSION['usernameClient']);
            $members->set('password', $_SESSION['passwordClient']);
            $dClientLogin = $members->check_login();

            if (isset($dClientLogin['user_id'])) {
                echo 'done##', $main->toJsonData(200, 'success', null);
            }
        }

        $members->set('email', $username);
        $salt = $members->get_salt();
        $pw = md5($password);
        $pw = $pw . $salt;
        $pw = md5($pw);

        $members->set('password', $pw);
        $dClientLogin = $members->check_login();

        if (isset($dClientLogin['user_id']) && $dClientLogin['user_id'] != '') {

            $_SESSION['usernameClient']     = $dClientLogin['user_id'];
            $_SESSION['fullnameClient']     = $dClientLogin['fullname'];
            $_SESSION['passwordClient']     = $dClientLogin['password'];

            setcookie('usernameClient', $_SESSION['usernameClient'], time() + 640000);
            setcookie('passwordClient', $_SESSION['passwordClient'], time() + 640000);
            echo 'done##', $main->toJsonData(200, 'success', null);
        } else {
            echo 'done##', $main->toJsonData(403, 'Sai tên đăng nhập hay mật khẩu truy cập.', null);
        }
    } else {
        echo 'Missing Nod';
        $db->close();
    }
} else {
    echo 'Missing action';
    $db->close();
}
