<?php
$nod        = $main->get('nod');

if ($act == 'add') {
    if ($nod == 'add') {
        $user_id = $main->post('user_id');
        $product_id = $main->post('id_product');
        $user1 = new user1();
        $check = $user1->check_wishlist($product_id, $user_id);
        $wishlist = new wishlist();
        if($check == true)
        {
            $user1->insert_wishlist($product_id, $user_id);
            $result = $wishlist->getMyWishlist($user_id);
            echo 'done##'.$main->toJsonData(200, 'Đã thêm vào danh sách yêu thích', $result);
        } else {
            echo 'done##'.$main->toJsonData(403, 'Đã có trong danh sách yêu thích', null);
        }
        $db->close();
        exit();
    } else if($nod == 'remove') {
        $user_id = $main->post('user_id');
        $product_id = $main->post('id_product');
        $user1 = new user1();
        $user1->delete_wishlist($product_id, $user_id);
        $wishlist = new wishlist();
        $result = $wishlist->getMyWishlist($user_id);
        echo 'done##'.$main->toJsonData(200, 'Đã xóa khỏi danh sách yêu thích', $result);
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
