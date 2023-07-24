<?php
$nod        = $main->get('nod');

if ($act == 'index') {
    if ($nod == 'update_avatar') {
        $avatar = $main->post('avatar');
        $img = $_FILES['avatar'];
        $id = $main->post('id');
        $web_root = $_SERVER['DOCUMENT_ROOT'];
        $dir_path = $web_root.'/public/img/user/'.$id;
        if (!is_dir($dir_path)) {
            mkdir($dir_path);
        }
        $file_name = $id.'.'.pathinfo($img['name'], PATHINFO_EXTENSION);
        $target_file = $dir_path.'/'.$file_name;
        if (move_uploaded_file($img["tmp_name"], $target_file)) {
            $user1 = new user1();
            if($user1->update_avatar($file_name, $id) == true)
            {
                echo 'done##'.$main->toJsonData(200, 'Upload thành công', null);
            }
        } else {
            echo 'done##'.$main->toJsonData(403, 'Upload thất bại', null);
        }
        $db->close();
        exit();
    } else if($nod == 'update_profile') {
        $user_name = $main->post('user_name');
        $address = $main->post('address');
        $phone = $main->post('phone');
        $id = $main->post('id');
        $user1 = new user1();
        $user1->set('user_name', $user_name);
        $user1->set('address', $address);
        $user1->set('phone', $phone);
        if($user1->update_profile($id) == true)
        {
            echo 'done##'.$main->toJsonData(200, 'Cập nhật thành công', null);
        }
    } else if($nod == 'detail_invoice') {
        $order_id = $main->post('order_id');
        $user1 = new user1();
        $result = $user1->get_detail_invoice($order_id);
        echo 'done##'.$main->toJsonData(200, null, $result);
        $db->close();
        exit();
    } else if($nod == 'change_password') {
        $old_pass = $main->post('old_pass');
        $new_pass = $main->post('new_pass');
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
        $user1 = new user1();
        $check = $user1->checkPass($old_pass, $id);
        if($check == false)
        {
            echo 'done##'.$main->toJsonData(403, 'Mật khẩu không hợp lệ', null);
        } else {
            $user1->updatePassword($new_pass, $id);
            echo 'done##'.$main->toJsonData(200, 'Đã thay đổi password', null);
        }
        $db->close();
        exit();
    } else if($nod == 'rating_order') {
        $order_id = $main->post('order_id');
        $user1 = new user1();
        $result = $user1->get_detail_invoice($order_id);
        echo 'done##'.$main->toJsonData(200, null, $result);
        $db->close();
    } else if ($nod == 'cancel_order_tiktok') {
        $order_id = $main->post('order_id');
        $reason = $main->post('reason_key');
        $cancelOrder = $client->Reverse->cancelOrder($order_id, $reason);
        echo 'done##'.$main->toJsonData(200, 'Success', null);
    } else if($nod == 'getList_reverse_key') {
        $reverse = $client->Reverse->getRejectReasonList();
        echo 'done##'.$main->toJsonData(200, null, $reverse);
    } else {
        echo 'Missing action';
        $db->close();
        exit();
    }
} else if($act == 'rating_order') {
    if($nod == 'insert')
    {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
        $id_product = $main->post('id_product');
        $order_id = $main->post('order_id');
        $content = $main->post('content');
        $ratingVal = $main->post('rating');
        $imgArray = $main->post('img_list');
        // $stringImg = implode(",", $imgArray);
        print_r($imgArray);
        exit();
        $rating = new rating();
        $rating->set('order_id', $order_id);
        $rating->set('product_id', $id_product);
        $rating->set('user_id', $id);
        $rating->set('content', $content);
        $rating->set('rating', $ratingVal);
        $rating->insert_rating();
        $user1 = new user1();
        $result = $user1->get_detail_invoice($order_id);
        echo 'done##'.$main->toJsonData(200, 'Đã đánh giá', $result[0]);
    }
} else {
    echo 'Missing action';
    $db->close();
    exit();
}
