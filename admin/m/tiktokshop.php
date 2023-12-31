<?php
    $auth = $client->auth();
    try {
        $authorization_code =  isset($_SESSION['token']) ? $_SESSION['token'] : '';
        $token = $auth->getToken($authorization_code);
        $_SESSION['token'] = $token['access_token'];
    
        $_SESSION['refresh_token'] = $token['refresh_token'];
    } catch (Exception $e) {
        
        if (!isset($_SESSION['token'])) {
            $_SESSION['state'] = $state = $main->str_rand(40);
            $authUrl = $auth->createAuthRequest($state, true);
    
    
            if (isset($_GET['code'])) {
    
                $_SESSION['token'] = $_GET['code'];
                setcookie('token', $_SESSION['token']);
                header('Location: http://demo.local/admin/?m=tiktokshop&act=orders');
            } else {
                header('Location: ' . $authUrl);
            }
        } else {
            $new_token = $auth->refreshNewToken($_SESSION['refresh_token']);
    
            $_SESSION['token'] = $new_token['access_token'];
            $_SESSION['refresh_token'] = $new_token['refresh_token'];
        }
    }
    $access_token = isset($_SESSION['token']) ? $_SESSION['token'] : '';
    if(isset($_SESSION['token']))
    {
        $client->setAccessToken($access_token);
    }
    if($act == 'orders')
    {
        
        // echo $result;
        // // print_r($result);
        // exit();
        $orders = $client->Order->getOrderList([
            // 'order_status' => 100, // Unpaid order
            'page_size' => 50,
        ]);
        
        $id = [];
        foreach($orders['order_list'] as $item)
        {
        
            array_push($id,$item['order_id']);
        }
        
        $orderDetail = $client->Order->getOrderDetail($id);
        // echo '<pre>';
        // print_r($orderDetail);
        // exit();
        foreach($orderDetail['order_list'] as $item)
        {
            // $create_at = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
            // $created_at = $create_at->format('Y-m-d H:i:s');
            // $timestamp = strtotime();
            $order = new order();
            $order->set('shop_id', 41);
            $order->set('order_id', $item['order_id']);
            $order->set('created_at', $item['create_time']/1000);
            $order->set('user_add', $item['recipient_address']['name']);
            $order->set('total_paid', $item['payment_info']['total_amount']);
            $order->set('order_status', $item['order_status']);
            $order->set('last_update', $item['update_time']);
            $result = $order->clonex();
            foreach($item['item_list'] as $x)
            {
                $detail_order->set('product_id', $x['product_id']);
                $detail_order->set('sku_id', $x['sku_id']);
                $detail_order->set('quantity', $x['quantity']);
                $detail_order->set('name', $x['product_name']);
                $detail_order->set('price', $x['sku_original_price']);
                $detail_order->set('default_price', $x['sku_original_price']);
                $detail_order->set('root_price', $x['sku_original_price']);
                $detail_order->set('decrement', $x['sku_seller_discount']);
                $detail_order->set('order_id', $item['order_id']);
                $detail_order->add(41,$item['create_time']/1000);
            }
        }
        // echo '<pre>';
        // print_r($orderDetail['order_list']);
        // exit();
        for ($i = 0; $i < count($orders['order_list']); $i++) {
            $order = $orders['order_list'][$i];
            $orders['order_list'][$i]['update_time'] = date('d/m/Y H:i:s',  $order['update_time']);

            $status = $order['order_status']; // Giá trị trạng thái
            $statusName = ""; // Biến để lưu tên trạng thái

            switch ($status) {
                default:
                    $statusName = "CHƯA THANH TOÁN";
                    break;
                case 105:
                    $statusName = "ĐANG GIỮ";
                    break;
                case 111:
                    $statusName = "CHỜ GIAO HÀNG";
                    break;
                case 112:
                    $statusName = "CHỜ LẤY HÀNG";
                    break;
                case 114:
                    $statusName = "ĐANG GIAO HÀNG MỘT PHẦN";
                    break;
                case 121:
                    $statusName = "ĐANG VẬN CHUYỂN";
                    break;
                case 122:
                    $statusName = "ĐÃ GIAO HÀNG";
                    break;
                case 130:
                    $statusName = "ĐÃ HOÀN THÀNH";
                    break;
                case 140:
                    $statusName = "ĐÃ HỦY";
                    break;
            }


            $orders['order_list'][$i]['order_status_detail'] = $statusName;
        }
        
        $st->assign('orderList', $orders);
    }
    if($act == 'detail')
    {
        $id = $main->get('id');
        $orders = $client->Order->getOrderDetail($id);
        $st->assign('orderDetail', $orders);
    } else if($act == 'products') {
        $products = $client->Product->getProductList();
        $st->assign('product_list', $products);
        // echo '<pre>';
        // print_r($products);
        // exit();
    } else if($act == 'detail_product')
    {
        $id_products = $main->get('id');
        $product_detail = $client->Product->getProductDetail($id_products);
        $st->assign('product_detail', $product_detail);
    }
?>