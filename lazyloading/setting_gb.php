<?php
$nod = $main->get('nod');
if ($act == 'idx') {
    $members        = new members();
    if ($nod == 'auto_cus') {

        $except         = $main->post('except');
        $keyword         = $main->post('keyword');

        $kq = $members->managers_showroom_by_keyword($keyword, $except);

        echo 'done##', $main->toJsonData(200, 'success', $kq);
    } else if ($nod == 'noti_new_order') { //get list member to noti when have new order

        $shop_id         = $main->post('shop_id');

        $kq = array();
        if (isset($setup['noti_client_new_order_' . $shop_id]) && $setup['noti_client_new_order_' . $shop_id] != '') {
            $members->set('user_id', $setup['noti_client_new_order_' . $shop_id]);
            $kq = $members->get_by_list_id();
        }

        echo 'done##', $main->toJsonData(200, 'success', $kq);
    } else if ($nod == 'tax_load') { //get tax personal income

        $shop_id         = $main->post('shop_id');

        $kq = array();
        if (isset($setup['tax_income_receive_by_' . $shop_id]) && $setup['tax_income_receive_by_' . $shop_id] != '') {
            $members->set('user_id', $setup['tax_income_receive_by_' . $shop_id]);
            $kq['dClient'] = $members->get_detail();
        } else {
            $kq['dClient'] = array();
        }

        if (isset($setup['tax_income_percent_' . $shop_id]) && $setup['tax_income_percent_' . $shop_id] != '') {
            $kq['tax_income_percent'] = $setup['tax_income_percent_' . $shop_id] + 0;
        } else {
            $kq['tax_income_percent'] = '';
        }

        echo 'done##', $main->toJsonData(200, 'success', $kq);
    } else {
        echo ($lang['er_004'] . " - Nod missing! ");
    }
} elseif ($act == 'modify') {

    if ($nod == 'save') {

        $lItems = $main->post('lItems', 'json');

        $lItems = json_decode($lItems, true);
        if ($lItems) {
            foreach ($lItems as $key => $item) {
                if (!isset($setup[$item['varname']])) {
                    //insert	
                    $opt->setvarname($item['varname']);
                    $opt->settitle($item['varname']);
                    $opt->setvalue($item['value']);
                    $opt->insert();
                } else {
                    $opt->setvarname($item['varname']);
                    $opt->setvalue($item['value']);
                    $opt->update();
                }

                //update payment_type_id_wallet_*
                update_payment_type_wallet($item['varname'], $item['value']);
            }
        }

        echo 'done##', $main->toJsonData(200, 'success', null);
    } else {
        echo ($lang['er_004'] . " - Nod missing! ");
    }
} elseif ($act == 'favi_icon') {

    if ($nod == 'save') {

        $varname = $main->post('varname');
        $img     = $main->post('img');
        
        if (!isset($setup[$varname])) {
            //insert	
            $opt->setvarname($varname);
            $opt->settitle('Favi icon '.$varname);
            $opt->setvalue($img);
            $opt->insert();
        } else {
            $opt->setvarname($varname);
            $opt->setvalue($img);
            $opt->update();
        }

        echo 'done##', $main->toJsonData(200, 'success', null);
    } else {
        echo ($lang['er_004'] . " - Nod missing! ");
    }
} else {
    echo ($lang['er_004'] . " - Action missing! ");
}

function update_payment_type_wallet($varname, $value)
{
    global $opt, $setup;

    $method_payment = new method_payment();

    /**
     * BEGIN custome => tự update payment_type_id_wallet_*
     */
    $dPayment = $method_payment->get_by_wallet_id($value
        /**wallet_id */
    ); //Lấy hình thức thanh toán mà có gắng ví điểm chỉnh rồi

    if (isset($dPayment['id'])) {
        if ($varname == 'wallet_id_main') {
            if (isset($setup['payment_type_wallet_main'])) {
                $opt->setvarname('payment_type_wallet_main');
                $opt->setvalue($dPayment['id']);
                $opt->update();
            } else {
                //insert	
                $opt->setvarname('payment_type_wallet_main');
                $opt->settitle('Hình thức thanh toán Ví chính');
                $opt->setvalue($dPayment['id']);
                $opt->insert();
            }
        }

        if ($varname == 'wallet_id_cashback') {
            if (isset($setup['payment_type_wallet_cashback'])) {
                $opt->setvarname('payment_type_wallet_cashback');
                $opt->setvalue($dPayment['id']);
                $opt->update();
            } else {
                //insert	
                $opt->setvarname('payment_type_wallet_cashback');
                $opt->settitle('Hình thức thanh toán Ví điểm');
                $opt->setvalue($dPayment['id']);
                $opt->insert();
            }
        }

        if ($varname == 'wallet_id_dcredit') {
            if (isset($setup['payment_type_wallet_dcredit'])) {
                $opt->setvarname('payment_type_wallet_dcredit');
                $opt->setvalue($dPayment['id']);
                $opt->update();
            } else {
                //insert	
                $opt->setvarname('payment_type_wallet_dcredit');
                $opt->settitle('Hình thức thanh toán Ví Credit');
                $opt->setvalue($dPayment['id']);
                $opt->insert();
            }
        }
    }
    /**
     * END 
     */

    return true;
}
