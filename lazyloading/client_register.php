<?php
$nod        = $main->get('nod');

if ($act == 'save') {
    if ($nod == 'save') {

        $fullname           = $main->post('fullname');
        $email              = $main->post('email');
        $mobile             = $main->post('mobile');
        $pass               = $main->post('form_password');
        $rePass             = $main->post('form_re_password');
        $referral_by        = $main->post('referral_by');
        $code               = '';

        $members = new members();

        $members->set('fullname', $fullname);

        $members->set('email', $email);
        $dClientEmail = $members->get_by_email();

        $members->set('mobile', $mobile);
        $dClientMobile = $members->get_by_mobile();

        $members->set('code', $code);
        $dClientCode = $members->get_detail_by_code();

        $referral_user_id = "";
        
        if (isset($_COOKIE['referral_by']) && $_COOKIE['referral_by'] != '') {
            $referral_user_id = $_COOKIE['referral_by'];
        }
        
        if ($email != '' && isset($dClientEmail['user_id'])) {
            echo "done##", $main->toJsonData(403, "Email đã tồn tại vui lòng chọn email khác.", null);
            exit();
        }else if ($mobile != '' && isset($dClientMobile['user_id'])) {
            echo "done##", $main->toJsonData(403, "Số điện thoại đã tồn tại vui lòng chọn số khác.", null);
            exit();
        } else {
            $members->set('user_id', '');
            $members->set('is_local_created', 1);
            $members->set('created_by', 1);
            $members->set('fullname', $fullname);
            $members->set('mobile', $mobile);
            $members->set('email', $email);
            $members->set('password', $pass);
            $members->set('referral_by', $referral_by == '' ? $setup['default_referral_by'] : $referral_by);
            $members->set('member_group_id', $setup['member_group_trial']);

            $user_id = $members->add();
            if (isset($user_id) && $user_id != '') {
                $main->redirect('/dang-nhap');
                echo "done##", $main->toJsonData(200, "Đăng ký thành công.", null);
                $db->close();
                exit();
            } else {
                // $main->redirect('/dang-ky-tai-khoan/' . $referral_user_id);
                echo "done##", $main->toJsonData(403, "Đăng ký không thành công.", null);
                $db->close();
                exit();
            }
            
        }

        $_SESSION['members'] = serialize($members);
        $_SESSION['error'] = "error";
        $main->redirect('/dang-ky-tai-khoan/' . $referral_user_id);
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
