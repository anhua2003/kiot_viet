<?php
$nod        = $main->get('nod');

if ($act == 'save') {
    if ($nod == 'save') {
        $name = $main->post("name");
        $email = $main->post("email");
        $address = $main->post("address");
        $city = $main->post("city");
        $country = $main->post("country");
        $phone = $main->post("telephone");
        $user_id = $main->post("unique_id");
        $list_cart = $main->post("list_cart");
        $total = 0;
        foreach($list_cart as $item)
        {
            $item_array = json_decode($item, true);
            $total += $item_array['quantity'] * ($item_array['price']*(100-$item_array['decrement'])/100);
        }
        // print_r($user_id);
        $cart = new cart();
        $cart->set('user_id', $user_id);
        $cart->set('total', $total);
        $cart->set('name', $name);
        $cart->set('email', $email);
        $cart->set('address', $address);
        $cart->set('city', $city);
        $cart->set('country', $country);
        $cart->set('phone', $phone);
        $cart->set('array', $list_cart);
        $cart->insert_information();
        echo 'done##'.$main->toJsonData(200, 'Đặt hàng thành công', null);
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
