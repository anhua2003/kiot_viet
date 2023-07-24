<?php
$nod        = $main->get('nod');

if ($act == 'idx') {
    if ($nod == 'filter') {

        $keyword    = $main->post('keyword');
        $page       = $main->post('page');
        $cat_id     = $main->post('cat_id');
        $type       = $main->post('type');
        $for_point  = $main->post('for_point');

        $shop_id        = 1;
        $member_group_id = 0;
        if (isset($dClient['shop_id'])) {
            $shop_id = $dClient['shop_id'];
            $member_group_id = $dClient['member_group_id'];
        }

        if (!isset($setup['theme_customize_allowed']) || $setup['theme_customize_allowed'] == 0) {

            //none theme
            $kq['theme']        = array();
            $kq['category']     = array();

            if ($for_point == 1) {
                $for_point = '1;2';
            } else {
                $for_point = '0;2';
            }

            $product->set('cat_id', $cat_id);
            $product->set('for_point', $for_point);

            if ($page < 1) $page = 1;
            $limit                  = 20;
            $offset                 = ($page - 1) * $limit;
            $kq['page']             = $page;
            $kq['perpage']          = $limit + 0;
            $kq['total_record']     = $product->list_all_product_count($keyword, $shop_id);
            $kq['l']                = $product->list_all_product($keyword, $shop_id, $member_group_id, $offset, $limit, '');

            echo 'done##', $main->toJsonData(200, 'success', $kq);
            unset($kq);
        } else { //Theme theme_customize_allowed = 1 
            $theme_cat_id   = $cat_id; //Cat_id lúc này là của theme_category


            $theme          = new theme();
            $theme_product  = new theme_product();
            $theme_category = new theme_category();

            $kq['theme']        = array();
            $kq['category']     = array();

            /**
             * BEGIN get theme
             */
            if ($type == '' || $type == 'theme') {
                // $theme->set('shop_id', $shop_id);
                // $dTheme = $theme->get_activate_theme( $member_group_id );
                $theme->set('id', 1);
                $theme->set('shop_id', $shop_id);
                $dTheme = $theme->get_activate_theme_by_id($member_group_id);

                if (isset($dTheme['id'])) {
                    $kq['theme'] = $dTheme['content'];
                }
            }
            /**
             * END get theme
             */

            /**
             * BEGIN get sản phẩm 
             */

            if ($for_point == 1) {
                $for_point = '1;2'; //Loại sản phẩm 1;2 => = 1 thuộc kho điểm; 2 tất cả kho hàng
            } else {
                $for_point = '0;2'; //Loại sản phẩm 0;2 => = 0 thuộc kho hàng; 2 thuộc 2 kho hàng/ điểm
            }

            $theme_product->set('theme_cat_id', $theme_cat_id);
            $theme_product->set('for_point', $for_point);

            if ($page < 1) $page = 1;
            $limit              = 20;
            $offset             = ($page - 1) * $limit;
            $kq['page']         = $page;
            $kq['perpage']      = $limit + 0;
            $kq['total_record'] = $theme_product->list_all_product_count($keyword, $shop_id);
            $kq['l']            = $theme_product->list_all_product($keyword, $shop_id, $member_group_id, $offset, $limit);

            /**
             * END get sản phẩm 
             */

            /**
             * BEGIN get detail a theme category => have slide => sub category
             */
            if ($theme_cat_id > 0) {
                $theme_category->set('id', $theme_cat_id);
                $theme_category->set('hidden', 0);
                $kq['category'] = $theme_category->get_detail_item();
            }
            /**
             * BEGIN get detail a theme category => have slide => sub category
             */

            echo 'done##', $main->toJsonData(200, 'success', $kq);
            unset($kq);
        }
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
