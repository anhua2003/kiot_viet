<?php
$nod        = $main->get('nod');

if ($act == 'login') {

    if ($nod == 'login') {
        $members = new members();

        $username              = $main->post('username');
        $password              = $main->post('password');

        if (isset($_SESSION['username_client']) && isset($_SESSION['password_client'])) {

            $members->set('user_id', $_SESSION['username_client']);
            $members->set('password', $_SESSION['password_client']);
            $dClientLogin = $members->check_login();

            if (isset($dClientLogin['username'])) {
                $main->redirect("/trang-chu");
            }

        }else if ($username == '') {
            echo 'done##', $main->toJsonData(403, 'Vui lòng nhập thông tin đăng nhập.', null);
        }else if ($password == '') {
            echo 'done##', $main->toJsonData(403, 'Vui lòng nhập mật khẩu.', null);
        }else{

            $members->set('email', $username);
            $salt = $members->get_salt();
            $pw = md5($password);
            $pw = $pw . $salt;
            $pw = md5($pw);
            $members->set('password', $pw);
            $dClientLogin = $members->check_login();

            if (isset($dClientLogin['user_id']) && $dClientLogin['user_id'] != '') {

                $_SESSION['username_client']             = $dClientLogin['user_id'];
                $_SESSION['fullname_client']             = $dClientLogin['fullname'];
                $_SESSION['email_client']                = $dClientLogin['email'];
                $_SESSION['mobile_client']               = $dClientLogin['mobile'];
                $_SESSION['password_client']             = $dClientLogin['password'];
                $_SESSION['birthday_client']             = $dClientLogin['year'] . '-' . $dClientLogin['month'] . '-' . $dClientLogin['day'];
                
                setcookie('username', $_SESSION['username_client'], time() + 640000);
                setcookie('password', $_SESSION['password_client'], time() + 640000);
                setcookie('email', $_SESSION['email_client'], time() + 640000);
                setcookie('mobile', $_SESSION['mobile_client'], time() + 640000);
                
                echo 'done##', $main->toJsonData(200, 'success.', null);
            } else {
                echo 'done##', $main->toJsonData(403, 'Sai tên đăng nhập hay mật khẩu truy cập.', null);
            }

        }
    } else {
        echo 'Missing Nod';
        $db->close();
    }

} else {
    echo 'Missing action';
    $db->close();
}
