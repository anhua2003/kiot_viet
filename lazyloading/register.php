<?php
$nod        = $main->get('nod');

if ($act == 'save') {
    if ($nod == 'save') {
        $user = new user1();
        $username = $main->post('username');
        $email = $main->post('email');
        $password = $main->post('password');
        $confirmpassword = $main->post('confirmpassword');
        

        if($email == '' || $password == '')
        {
            echo 'done##'.$main->toJsonData(403, 'Vui lòng nhập đủ dữ liệu', null);
        } else if($password != $confirmpassword) {
            echo 'done##'.$main->toJsonData(403, 'Nhập lại mật khẩu không khớp với mật khẩu trên', null);
        } else {
            $user->setUsername($username);
            $user->setEmail($main->post('email'));
            $user->setPassword($main->post('password'));
            $kq = $user->checkEmail();
            if($kq == true)
            {
                echo 'done##'.$main->toJsonData(403, 'Email trùng rồi', null);
            } else {
                $user->add_account();
                echo 'done##'.$main->toJsonData(200, 'Đăng ký thành công', null);
            }
        }
        $db->close();
        exit();
        
        // $main->redirect('/dang-nhap');
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
