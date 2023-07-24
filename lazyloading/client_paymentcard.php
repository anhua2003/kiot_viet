<?php
$nod        = $main->get('nod');

if ($act == 'idx') {
    if ($nod == 'list_bank') {

        $bank_list = new bank_list();

        $kq['l'] = $bank_list->list_all_item();

        echo 'done##', $main->toJsonData(200, 'success', $kq);
    } else if ($nod == 'list_bank_info') {
        $bank_list = new bank_list();
        $members   = new members();
        // $bank_info->set('client_id', $_SESSION['username_client']);
        // $lItems = $bank_info->list_by('', ''); //lấy hình avatar ra

        $members->set('user_id', isset($_SESSION['username_client']) ? $_SESSION['username_client'] : '');
        $dM = $members->get_detail();
        $kq['list_bank'] = $bank_list->list_all_item();
        $kq['info'] = $dM;
        if (isset($dM['user_id'])) {
            echo 'done##', $main->toJsonData(200, 'success', $kq);
        } else {
            echo 'done##', $main->toJsonData(403, 'Không tìm thấy người dùng', null);
        }
    } else {
        echo 'Missing action';
        $db->close();
        exit();
    }
} else if ($act == 'save') {
    if ($nod == 'bank_info') {
        $bank_list = new bank_list();
        $members   = new members();

        $members->set('user_id', isset($_SESSION['username_client']) ? $_SESSION['username_client'] : '');
        $dClient = $members->get_detail();

        $number     = $main->post('number');
        $fullname   = $main->post('fullname');
        $branch     = $main->post('branch');
        $city       = $main->post('city');
        $bank_id    = $main->post('bank_id');

        $bank_list->set('id', $bank_id);
        $bank = $bank_list->get_by_id();

        if (!isset($dClient['user_id'])) {
            echo 'done##', $main->toJsonData(403, 'Người dùng không tồn tại.', null);
        } else {
            if (!isset($bank['id'])) {
                echo 'done##', $main->toJsonData(403, 'Ngân hàng không tồn tại', null);
            } else {
                $members->set('user_id', $dClient['user_id']);
                $members->set('bank_name', $bank['name']);
                $members->set('bank_account', $number);
                $members->set('bank_fullname', $fullname);
                $members->set('bank_branch', $bank_branch);
                $members->set('bank_city', $bank_city);
                $members->update_bank_info();
                if (!isset($id)) {
                    echo 'done##', $main->toJsonData(403, 'Đăng ký không thành công', null);
                } else {
                    echo 'done##', $main->toJsonData(200, 'success', null);
                }
            }
        }
    } else if ($nod == 'update_bank_info') {
        $members = new members();

        $members->set('user_id', isset($_SESSION['username_client']) ? $_SESSION['username_client'] : '');
        $dClient = $members->get_detail();

        $bank_name          =  $main->post('bank_name');
        $bank_account       =  $main->post('bank_account');
        $bank_fullname      =  $main->post('bank_fullname');
        $bank_branch        =  $main->post('bank_branch');
        $bank_city          =  $main->post('bank_city');
        $password           =  $main->post('password');

        if (!isset($dClient['user_id'])) {
            echo "done##", $main->toJsonData(403, 'Người dùng không tồn tại.', null);
        } else {
            $salt   =   $dClient['salt'];
            $pw     =   md5(md5($password) . $salt);

            if ($pw != $dClient['password']) {
                echo "done##", $main->toJsonData(403, 'Xác nhận mật khẩu không đúng', null);
            } else {

                $members->set('user_id', $_SESSION['username_client']);
                $members->set('bank_name', $bank_name);
                $members->set('bank_account', $bank_account);
                $members->set('bank_fullname', $bank_fullname);
                $members->set('bank_branch', $bank_branch);
                $members->set('bank_city', $bank_city);
                $members->update_bank_info();

                echo "done##", $main->toJsonData(200, 'success', null);
            }
        }
    } else {
        echo 'Missing action';
        $db->close();
        exit();
    }
} else if ($act == 'delete') {
    if ($nod == 'delete_bank_info') {

        $id    = $main->post('id');

        $bank_info->set('id', $id);
        $bank_info->set('client_id', $_SESSION['username_client']);
        $bank_info->delete_by();

        echo 'done##', $main->toJsonData(200, 'success', null);
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
