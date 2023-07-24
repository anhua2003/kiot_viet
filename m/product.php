<?php
    $id = $main->get('id');
    $home = new home();
    $product = new product();
    if($act == 'detail')
    {
        $result = $home->getDetailProduct($id);
        function smarty_getProperties($params, $smarty)
        {
            global $product,$id;
            $id_product = $params['id'];
            $result = $product->getProperties($id_product);
            foreach ($result as $item)
            {
                $name = $product->getName($item['id_properties']);
                echo '<label>'.$name[0]['properties_name'].'</label>';
                echo '<label>';
                echo '<select class="input-select" id="select-'.$item['id_properties'].'">';
                $option = $product->getOption($item['id_properties'], $id_product);
                foreach($option as $i)
                {
                    echo '<option value="'.$i['unique_id'].'-'.$i['properties_p'].'">'.$i['properties_p'].'</option>';
                }
                echo '</select>';
                echo '</label>';
            }
        }
        $rating = new rating();
        $list_rating = $rating->getRating($id);
        $st->registerPlugin('function', 'getProperties', 'smarty_getProperties');
        $st->assign('product', $result);
        $st->assign('list_rating', $list_rating[0]);
        $st->assign('rate', $list_rating[1]);
        $st->assign('average_star', $list_rating[2]);
        $title .= $result['name'];
    } else if($act == 'index') {
        $limit = $main->get('limit') ? $main->get('limit') : 6;
        $key = $main->get('key') ? $main->get('key') : '';
        if($key == '')
        {
            $list_product = $product->getAllProduct();
            $list_product_page = $product->getAllProductPage($limit);
            $st->assign('list_product', $list_product_page);
        } else {
            $title .= $key;
            $list_product = $product->searchProduct($key);
            $list_product_page = $product->searchProduct_page($key, $limit);
            $st->assign('list_product', $list_product_page);
        }
        $paging->total = count($list_product);
        $paging->limit = $limit;
        $result=$paging->display_ajax();
        if(count($list_product) <= $limit)
        {
            $result = '';
        }
        $st->assign('key', $key);
        $st->assign('pagination', $result);
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : "";
        $user1 = new user1();
        $wishlist = $user1->get_wishlist($user_id);
        $st->assign('wishlist', $wishlist);
        $list_product_page1 = $product->getAllProductPage(3);
        $st->assign('list_product1', $list_product_page1);
    }
?>