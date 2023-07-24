<?php
$nod        = $main->get('nod');

if ($act == 'save') {
    if ($nod == 'save') {
        $email = $main->post('email');
        $user1 = new user1();
        $user1->setEmail($email);
        $result = $user1->checkEmail();
        if($result == false)
        {
            echo 'done##'.$main->toJsonData(403, 'Email không tồn tại', null);
        } else {
            $code = rand(0,9999);
            $message = "có mật khẩu cũng quên mật khẩu mới nè->".$code;
            $mailer = new mailer();
            $mailer->sendMail_an($email, $message);
            $kq = $user1->saveNewPassword($code);
            if($kq == true)
            {
                echo 'done##'.$main->toJsonData(200, 'Đã đổi password vui lòng check email', null);
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
