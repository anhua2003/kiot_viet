<?php
$nod        = $main->get('nod');

if ($act == 'save') {
    if ($nod == 'save') {
        $user = new user1();
        $email = $main->post('email');
        $password = $main->post('password');
        
        if($email == '' || $password == '')
        {
            echo 'done##'.$main->toJsonData(403, 'Vui lòng nhập đủ dữ liệu', null);
        } else {
            $user->setEmail($main->post('email'));
            $user->setPassword($main->post('password'));
            $result = $user->login();
            if($result != false) {
                $_SESSION['email'] = $main->post('email');
                $_SESSION['id'] = $result['id'];
                // setcookie('email', $_SESSION['email'], time() + 640000);
                // $main->redirect('/trang-chu');
                echo 'done##'.$main->toJsonData(200, 'Đăng nhập thành công', null);
            } else {
                echo 'done##'.$main->toJsonData(403, 'Sai tên đăng nhập hay mật khẩu truy cập.', null);
            }
        }
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
