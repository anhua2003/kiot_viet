<?php
class wallet_transaction extends model
{

    protected $class_name = 'wallet_transaction';
    protected $id;
    protected $from_client;
    protected $from_fullname;
    protected $wallet_id; //= 0 is normal wallet; order is id of wallet cashback
    protected $to_client;
    protected $to_fullname; //
    protected $amount; //
    protected $created_at; //
    protected $order_id; //
    protected $order_created_at; //
    protected $shop_id; //
    protected $note; //
    protected $fee; //
    protected $chung_tu; //
    protected $transaction_type; //Hình thức thanh toán: có thể là mã loại thanh toán, có thể là loại thanh toán tiền mặt hay thẻ của POS?????
    protected $created_by_admin; //Hình thức thanh toán: có thể là mã loại thanh toán, có thể là loại thanh toán tiền mặt hay thẻ của POS?????

    public function create()
    {
        global $db, $members;

        $from_client            = $this->get('from_client');
        $to_client              = $this->get('to_client');
        $wallet_id              = $this->get('wallet_id');
        $amount                 = $this->get('amount');

        $order_id               = $this->get('order_id');
        $order_created_at       = $this->get('order_created_at');
        $shop_id                = $this->get('shop_id');

        $note                   = $this->get('note');
        $fee                    = $this->get('fee');
        $transaction_type       = $this->get('transaction_type');
        $created_by_admin       = $this->get('created_by_admin');

        // if( $from_client == 1 ){//Tài khoản Global
        //     $transaction_type = 'GLOBALOUT';//Giao dịch Vào/Ra
        //     $this->set('transaction_type', $transaction_type);
        // }elseif( $to_client == 1 ){//Tài khoản Global{
        //     $transaction_type = 'GLOBALIN';//Giao dịch Vào/Ra
        //     $this->set('transaction_type', $transaction_type);
        // }
        
        $id = $this->add();

        // if( $wallet_id == 0 ){

        //     //Trừ ví tổng
        //     $members->set('user_id', $from_client);
        //     $members->set('wallet_main', $amount);
        //     $members->giam_wallet_main();

        //     //tăng ví tổng
        //     $members->set('user_id', $to_client);
        //     $members->set('wallet_main', $amount);
        //     $members->tang_wallet_main();

        // }else{

        $this->set('from_client', $from_client);
        $this->set('to_client', $to_client);
        $this->set('amount', $amount);
        $this->set('wallet_id', $wallet_id);
        $this->transfer_cashback();

        // }
        return $id;
    }

    public function transfer_cashback()
    {
        /*
        - Tăng ví cashback của to_client và giảm ví cashback của from_client
        */
        $wallet_detail = new wallet_detail();

        $from_client        = $this->get('from_client');
        $to_client          = $this->get('to_client');
        $amount             = $this->get('amount');
        $wallet_id          = $this->get('wallet_id');

        //Trừ ví cashback tổng
        // $members->set('user_id', $from_client);
        // $members->set('wallet_detail', $amount);
        // $members->giam_wallet_detail();

        // if( $from_client > 1 ){
        //không phải admin: vì admin không có ví chi tiết
        //rút tiền ở ví chi tiết bớt ra
        $wallet_detail->set('client_id', $from_client);
        $wallet_detail->set('wallet_id', $wallet_id);
        $wallet_detail->set('amount', $amount);
        $wallet_detail->giam();
        // }

        //tăng ví cashback tổng
        // $members->set('user_id', $to_client);
        // $members->set('wallet_detail', $amount);
        // $members->tang_wallet_detail();

        // if( $from_client > 1 ){
        //không phải admin: vì admin không có ví chi tiết
        //rút tiền ở ví chi tiết bớt ra
        $wallet_detail->set('client_id', $to_client);
        $wallet_detail->set('wallet_id', $wallet_id);
        $wallet_detail->set('amount', $amount);
        $wallet_detail->tang();
        // }

        return true;
    }

    public function add()
    {
        global $db;

        $arr['from_client']                         = $this->get('from_client');
        $arr['to_client']                             = $this->get('to_client');
        $arr['wallet_id']                             = $this->get('wallet_id');
        $arr['amount']                                 = $this->get('amount');
        $arr['order_id']                             = $this->get('order_id');
        $arr['order_created_at']                     = $this->get('order_created_at');
        $arr['shop_id']                             = $this->get('shop_id') + 0;
        $arr['note']                                 = $this->get('note');
        $arr['fee']                                 = $this->get('fee');
        $arr['chung_tu']                            = $this->get('chung_tu');
        $arr['transaction_type']                     = $this->get('transaction_type');
        $arr['created_by_admin']                    = $this->get('created_by_admin');
        $arr['created_at']                             = time();

        // print_r($arr);

        $db->record_insert($this->class_name, $arr);
        unset($arr);
        return $db->mysqli_insert_id();
    }

    private function update_amount()
    { //chỉ dùng nội hàm
        global $db;

        $id                                     = $this->get('id');
        $note                                     = $this->get('note');

        $arr['amount']                             = $this->get('amount');
        if ($note != '')
            $arr['note']                        =  $note;

        $db->record_update($this->class_name, $arr, " `id` = '$id' ");

        unset($arr);
        return true;
    }

    public function update_info() //cập nhật thông tin giao dịch(tùngcode-23/07/2021)
    { //chỉ dùng nội hàm
        global $db;

        $id                                         = $this->get('id');
        $note                                       = $this->get('note');

        $arr['chung_tu']                            = $this->get('chung_tu');
        if ($note != '')
            $arr['note']                            =  $note;

        $db->record_update($this->class_name, $arr, " `id` = '$id' ");

        unset($arr);
        return true;
    }

    public function get_transaction_by_order_info()
    { //list all theo tên nhóm chính
        global $db;

        $from_client            = $this->get('from_client');
        $to_client              = $this->get('to_client');
        $wallet_id              = $this->get('wallet_id');
        $order_id               = $this->get('order_id');
        $order_created_at       = $this->get('order_created_at');
        $shop_id                = $this->get('shop_id');
        $transaction_type       = $this->get('transaction_type');

        $sql = "SELECT *
                FROM `" . $this->class_name . "` wlt
                WHERE
                `from_client` = '$from_client'
                AND `to_client` = '$to_client'
                AND `wallet_id` = '$wallet_id'
                AND `order_id` = '$order_id'
                AND `order_created_at` = '$order_created_at'
                AND `shop_id` = '$shop_id'
                AND `transaction_type` = '$transaction_type'
                LIMIT 1
                ";

        $result = $db->executeQuery($sql, 1);

        return $result;
    }

    public function list_by_client_count($keyword, $from, $to)
    { //list all theo tên nhóm chính
        global $db;

        $client_id                             = $this->get('client_id');
        $wallet_id                             = $this->get('wallet_id');
        $transaction_type                      = $this->get('transaction_type');

        if ($client_id      != '') $client_id     = "AND ( wlt.`from_client` =  '$client_id' OR wlt.`to_client` =  '$client_id' ) ";
        if ($wallet_id      != '') $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id' ";
        if ($keyword        != '') $keyword       = "AND ( mbfrom.`fullname` LIKE '%$keyword%' OR mbfrom.`mobile` LIKE '%$keyword%' OR mbto.`fullname` LIKE '%$keyword%' OR mbto.`mobile` LIKE '%$keyword%' ) ";

        $sqlFromTo = '';
        if ($from != '') {
            $sqlFromTo = "AND $from <= wlt.`created_at` AND wlt.`created_at` < $to ";
        }

        $sqlTransType = '';
        if ($transaction_type != '') {
            $lTr = explode(';', $transaction_type);
            foreach ($lTr as $tID) {
                if ($tID != '') {
                    $sqlTransType .= "wlt.`transaction_type` = '$tID' OR ";
                }
            }
            if ($sqlTransType != '') {
                $sqlTransType = "AND (" . substr($sqlTransType, 0, -3) . ")";
            }
        }

        $sql = "SELECT COUNT(*) `total`
                FROM `" . $this->class_name . "` wlt
                LEFT JOIN `members` mbfrom ON mbfrom.user_id = wlt.from_client
                LEFT JOIN `members` mbto ON mbto.user_id = wlt.to_client
                WHERE 1
                $client_id
                $wallet_id
                $keyword
                $sqlFromTo
                $sqlTransType";

        $result = $db->executeQuery($sql, 1);

        return $result['total'] + 0;
    }

    public function list_by_client_info( $keyword, $from, $to, $member_group, $filter_type )//filter_type = '' all; = -1 Tổng trừ ra; = 1 Tổng cộng về; = 0 Tổng + và trừ; = 2 không có tổng
    { //list all theo nguoi dung
        global $db;

        $client_id                             = $this->get('client_id');
        $wallet_id                             = $this->get('wallet_id');
        $transaction_type                      = $this->get('transaction_type');

        if ($client_id      != '') $client_id     = "AND ( wlt.`from_client` =  '$client_id' OR wlt.`to_client` =  '$client_id' ) ";
        if ($wallet_id      != '') $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id' ";
        if ($keyword        != '') $keyword       = "AND ( mbfrom.`fullname` LIKE '%$keyword%' OR mbfrom.`mobile` LIKE '%$keyword%' OR mbto.`fullname` LIKE '%$keyword%' OR mbto.`mobile` LIKE '%$keyword%' OR wlt.`note` LIKE '%$keyword%' ) ";
        if ($member_group   != '') $member_group  = "AND (mbfrom.`member_group_id` = '$member_group' OR mbto.`member_group_id` = '$member_group')";

        $sqlFromTo = '';
        if ($from != '') {
            $sqlFromTo = "AND $from <= wlt.`created_at` AND wlt.`created_at` < $to ";
        }

        $sqlTransType = '';
        if ($transaction_type != '') {
            $lTr = explode(';', $transaction_type);
            foreach ($lTr as $tID) {
                if ($tID != '') {
                    $sqlTransType .= "wlt.`transaction_type` = '$tID' OR ";
                }
            }
            if ($sqlTransType != '') {
                $sqlTransType = "AND (" . substr($sqlTransType, 0, -3) . ")";
            }
        }

        $sqlFilterType = '';
        if( $filter_type != '' ){
            if( $filter_type == '-1' )
                $sqlFilterType = "AND wlt.`from_client` = '1' ";
            elseif( $filter_type == '1' )
                $sqlFilterType = "AND wlt.`to_client` = '1' ";
            elseif( $filter_type == '0' )
                $sqlFilterType = "AND ( wlt.`from_client` = '1' OR wlt.`to_client` = '1' ) ";
            elseif( $filter_type == '2' )
                $sqlFilterType = "AND ( wlt.`from_client` <> '1' AND wlt.`to_client` <> '1' ) ";
        }

        $sql = "SELECT COUNT(*) `total_record`, SUM(`amount`) total_value 
                FROM `" . $this->class_name . "` wlt
                LEFT JOIN `members` mbfrom ON mbfrom.user_id = wlt.from_client
                LEFT JOIN `members` mbto ON mbto.user_id = wlt.to_client
                WHERE 1
                $client_id
                $wallet_id
                $member_group
                $keyword
                $sqlFromTo
                $sqlTransType
                $sqlFilterType";

        $result = $db->executeQuery($sql, 1);

        return $result;
    }

    public function list_by_client_summary($keyword, $from, $to, $member_group, $filter_type = '')//filter_type = '' all; = -1 Tổng trừ ra; = 1 Tổng cộng về; = 0 Tổng + và trừ; = 2 không có tổng
    { //list all theo nguoi dung
        global $db;

        $client_id                             = $this->get('client_id');
        $wallet_id                             = $this->get('wallet_id');
        $transaction_type                      = $this->get('transaction_type');

        $sqlClientID        = "( wlt.`from_client` =  '$client_id' OR wlt.`to_client` =  '$client_id' ) ";
        if ($wallet_id      != '') $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id' ";
        if ($keyword        != '') $keyword       = "AND ( mbfrom.`fullname` LIKE '%$keyword%' OR mbfrom.`mobile` LIKE '%$keyword%' OR mbto.`fullname` LIKE '%$keyword%' OR mbto.`mobile` LIKE '%$keyword%' OR wlt.`note` LIKE '%$keyword%' ) ";
        if ($member_group   != '') $member_group  = "AND (mbfrom.`member_group_id` = '$member_group' OR mbto.`member_group_id` = '$member_group')";

        $sqlFromTo = '';
        if ($from != '') {
            $sqlFromTo = "AND $from <= wlt.`created_at` AND wlt.`created_at` < $to ";
        }

        $sqlTransType = '';
        if ($transaction_type != '') {
            $lTr = explode(';', $transaction_type);
            foreach ($lTr as $tID) {
                if ($tID != '') {
                    $sqlTransType .= "wlt.`transaction_type` = '$tID' OR ";
                }
            }
            if ($sqlTransType != '') {
                $sqlTransType = "AND (" . substr($sqlTransType, 0, -3) . ")";
            }
        }

        $sqlFilterType = '';
        if( $filter_type != '' ){
            if( $filter_type == '-1' )
                $sqlFilterType = "AND wlt.`from_client` = '1' ";
            elseif( $filter_type == '1' )
                $sqlFilterType = "AND wlt.`to_client` = '1' ";
            elseif( $filter_type == '0' )
                $sqlFilterType = "AND ( wlt.`from_client` = '1' OR wlt.`to_client` = '1' ) ";
            elseif( $filter_type == '2' )
                $sqlFilterType = "AND ( wlt.`from_client` <> '1' AND wlt.`to_client` <> '1' ) ";
        }

        $sql = "SELECT COUNT(*) `total_record`, 
                    SUM(IF(wlt.`from_client` = '$client_id', wlt.`amount`, 0 )) total_out,
                    SUM(IF(wlt.`to_client` = '$client_id', wlt.`amount`, 0 )) total_in,
                    SUM(wlt.`amount`) total_sum
                FROM `" . $this->class_name . "` wlt
                LEFT JOIN `members` mbfrom ON mbfrom.user_id = wlt.from_client
                LEFT JOIN `members` mbto ON mbto.user_id = wlt.to_client
                WHERE
                $sqlClientID
                $wallet_id
                $member_group
                $keyword
                $sqlFromTo
                $sqlTransType
                $sqlFilterType";

        $result = $db->executeQuery($sql, 1);

        return $result;
    }

    public function list_by_client($keyword, $from, $to, $member_group, $filter_type = '', $offset = 0, $limit = '')//filter_type = '' all; = -1 Tổng trừ ra; = 1 Tổng cộng về; = 0 Tổng + và trừ; = 2 không có tổng
    { //list all theo tên nhóm chính
        global $db;

        $client_id                             = $this->get('client_id');
        $wallet_id                             = $this->get('wallet_id');
        $transaction_type                      = $this->get('transaction_type');

        if ($client_id      != '') $client_id     = "AND ( wlt.`from_client` =  '$client_id' OR wlt.`to_client` =  '$client_id' ) ";
        if ($wallet_id      != '') $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id' ";
        if ($keyword        != '') $keyword       = "AND ( mbfrom.`fullname` LIKE '%$keyword%' OR mbfrom.`mobile` LIKE '%$keyword%' OR mbto.`fullname` LIKE '%$keyword%' OR mbto.`mobile` LIKE '%$keyword%' OR wlt.`note` LIKE '%$keyword%' ) ";
        if ($limit          != '') $limit         = "LIMIT $offset, $limit ";
        if ($member_group   != '') $member_group  = "AND (mbfrom.`member_group_id` = '$member_group' OR mbto.`member_group_id` = '$member_group')";

        $sqlFromTo = '';
        if ($from != '') {
            $sqlFromTo = "AND $from <= wlt.`created_at` AND wlt.`created_at` < $to ";
        }

        $sqlTransType = '';
        if ($transaction_type != '') {
            $lTr = explode(';', $transaction_type);
            foreach ($lTr as $tID) {
                if ($tID != '') {
                    $sqlTransType .= "wlt.`transaction_type` = '$tID' OR ";
                }
            }
            if ($sqlTransType != '') {
                $sqlTransType = "AND (" . substr($sqlTransType, 0, -3) . ")";
            }
        }

        $sqlFilterType = '';
        if( $filter_type != '' ){
            if( $filter_type == '-1' )
                $sqlFilterType = "AND wlt.`from_client` = '1' ";
            elseif( $filter_type == '1' )
                $sqlFilterType = "AND wlt.`to_client` = '1' ";
            elseif( $filter_type == '0' )
                $sqlFilterType = "AND ( wlt.`from_client` = '1' OR wlt.`to_client` = '1' ) ";
            elseif( $filter_type == '2' )
                $sqlFilterType = "AND ( wlt.`from_client` <> '1' AND wlt.`to_client` <> '1' ) ";
        }

        $sql = "SELECT wlt.*, 
                             mbfrom.`fullname` from_fullname
                            , mbfrom.`mobile` from_mobile, mbfrom.`wallet_main` from_wallet_main
                            , mbfrom.`wallet_cashback` from_wallet_cashback
                            , mbfrom.`code` from_code
                            , mbto.`code` to_code
                            , 
                             mbto.`fullname` to_fullname
                            , mbto.`mobile` to_mobile
                            , wallet.`wallet_code`, IF( wlt.`wallet_id` = 0, 'Ví chính', IFNULL(wallet.`name`, 'Không xác định') ) wallet_name, IFNULL(user.`fullname`, '-' ) created_by_admin_fullname
                            , mbto.`wallet_main` to_wallet_main, mbto.`wallet_cashback` to_wallet_cashback
                FROM $db->tbl_fix`$this->class_name` wlt
                LEFT JOIN $db->tbl_fix`members` mbfrom ON mbfrom.user_id = wlt.from_client
                LEFT JOIN $db->tbl_fix`member_group` mbGfrom ON mbGfrom.id = mbfrom.member_group_id
                LEFT JOIN $db->tbl_fix`members` mbto ON mbto.user_id = wlt.to_client
                LEFT JOIN $db->tbl_fix`member_group` mbGTo ON mbGTo.id = mbto.member_group_id
                LEFT JOIN `product_commission` wallet ON wallet.id = wlt.wallet_id
                LEFT JOIN `user` ON user.id = wlt.created_by_admin
                WHERE 1
                $client_id
                $wallet_id
                $member_group
                $keyword
                $sqlFromTo
                $sqlTransType
                $sqlFilterType
                ORDER BY `id` DESC
                $limit";
        $result = $db->executeQuery_list($sql);

        return $result;
    }

    public function client_filter_info($keyword)
    { //list all theo nguoi dung
        global $db;

        $client_id                             = $this->get('client_id');
        $wallet_id                             = $this->get('wallet_id');

        $sqlClient_id     = "AND ( wlt.`from_client` =  '$client_id' OR wlt.`to_client` =  '$client_id' ) ";

        if ($wallet_id      != '') $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id' ";
        if ($keyword        != '') $keyword       = "AND ( mbfrom.`fullname` LIKE '%$keyword%' OR mbfrom.`mobile` LIKE '%$keyword%' OR mbto.`fullname` LIKE '%$keyword%' OR mbto.`mobile` LIKE '%$keyword%' OR wlt.`note` LIKE '%$keyword%' ) ";

        $sql = "SELECT COUNT(*) `total_record`, SUM(`amount`) total_value 
                FROM `" . $this->class_name . "` wlt
                LEFT JOIN `members` mbfrom ON mbfrom.user_id = wlt.from_client
                LEFT JOIN `members` mbto ON mbto.user_id = wlt.to_client
                WHERE 1
                $sqlClient_id
                $wallet_id
                $keyword";

        $result = $db->executeQuery($sql, 1);
        return $result;
    }

    public function client_filter($keyword, $offset = 0, $limit = '')
    { //list all theo tên nhóm chính
        global $db;

        $client_id                             = $this->get('client_id');
        $wallet_id                             = $this->get('wallet_id');

        $sqlClient_id     = "AND ( wlt.`from_client` =  '$client_id' OR wlt.`to_client` =  '$client_id' ) ";

        if ($wallet_id      != '') $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id' ";
        if ($keyword        != '') $keyword       = "AND ( mbfrom.`fullname` LIKE '%$keyword%' OR mbfrom.`mobile` LIKE '%$keyword%' OR mbto.`fullname` LIKE '%$keyword%' OR mbto.`mobile` LIKE '%$keyword%' OR wlt.`note` LIKE '%$keyword%' ) ";
        if ($limit          != '')  $limit         = "LIMIT $offset, $limit ";

        $sql = "SELECT wlt.*, mbfrom.`fullname` from_fullname, mbfrom.`mobile` from_mobile, mbfrom.`wallet_main` from_wallet_main
                            , mbfrom.`wallet_cashback` from_wallet_cashback, mbto.`fullname` to_fullname, mbto.`mobile` to_mobile
                            , wallet.`wallet_code`, IF( wlt.`wallet_id` = 0, 'Ví chính', IFNULL(wallet.`name`, 'Không xác định') ) wallet_name, IFNULL(user.`fullname`, '-' ) created_by_admin_fullname
                            , mbto.`wallet_main` to_wallet_main, mbto.`wallet_cashback` to_wallet_cashback
                FROM `" . $this->class_name . "` wlt
                LEFT JOIN `members` mbfrom ON mbfrom.user_id = wlt.from_client
                LEFT JOIN `members` mbto ON mbto.user_id = wlt.to_client
                LEFT JOIN `product_commission` wallet ON wallet.id = wlt.wallet_id
                LEFT JOIN `user` ON user.id = wlt.created_by_admin
                WHERE 1
                $sqlClient_id
                $wallet_id
                $keyword
                ORDER BY `id` DESC
                $limit";

        $result = $db->executeQuery_list($sql);

        return $result;
    }

    public function filter($wallet_type, $offset = 0, $limit = '')
    { //wallet_main; wallet_cashback; wallet_referral
        global $db, $setup;

        $client_id                             = $this->get('client_id');

        $client_id     = " ( wlt.`from_client` =  '$client_id' OR wlt.`to_client` =  '$client_id' ) ";

        $wallet_id_main         = $setup['wallet_id_main'];
        $wallet_id_share        = $setup['wallet_id_share'];
        $wallet_id_cashback     = $setup['wallet_id_cashback'];
        $wallet_id_borrow       = $setup['wallet_id_borrow'];
        $wallet_id_sharing      = $setup['wallet_id_sharing'];
        
        $wallet_id = '';
        if ($wallet_type == 'wallet_main') {
            $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id_main' ";
        } else if ($wallet_type == 'wallet_referral') {
            $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id_share' ";
        } else if ($wallet_type == 'wallet_cashback') {
            $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id_cashback' ";
        } else if ($wallet_type == 'wallet_borrow') {
            $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id_borrow' ";
        } else if ($wallet_type == 'wallet_sharing') {
            $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id_sharing' ";
        } else {
            $l = explode(';', $setup['wallet_cashback_list_id']);

            $str = '';
            foreach ($l as $key => $i) {
                $str     .= " wlt.`wallet_id` = '$i' OR ";
            }
            if ($str != '') {
                $wallet_id = "AND (" . substr($str, 0, -3) . " )";
            }
        }

        if ($limit != '') $limit = "LIMIT $offset, $limit";

        $sql = "SELECT wlt.*, mbfrom.`fullname` from_fullname, mbto.`fullname` to_fullname
                FROM `" . $this->class_name . "` wlt
                LEFT JOIN `members` mbfrom ON mbfrom.user_id = wlt.from_client
                LEFT JOIN `members` mbto ON mbto.user_id = wlt.to_client
                WHERE
                $client_id
                $wallet_id
                ORDER BY `id` DESC
                $limit";

        $result = $db->executeQuery_list($sql);

        return $result;
    }

    public function filter_count($wallet_type)
    { //wallet_main; wallet_cashback; wallet_referral
        global $db, $setup;

        $client_id                             = $this->get('client_id');

        $client_id     = " ( wlt.`from_client` =  '$client_id' OR wlt.`to_client` =  '$client_id' ) ";

        $wallet_id_main         = $setup['wallet_id_main'];
        $wallet_id_share        = $setup['wallet_id_share'];
        $wallet_id_cashback     = $setup['wallet_id_cashback'];
        $wallet_id_borrow       = $setup['wallet_id_borrow'];
        $wallet_id_sharing      = $setup['wallet_id_sharing'];

        $wallet_id = '';
        if ($wallet_type == 'wallet_main') {
            $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id_main' ";
        } else if ($wallet_type == 'wallet_referral') {
            $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id_share' ";
        } else if ($wallet_type == 'wallet_cashback') {
            $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id_cashback' ";
        } else if ($wallet_type == 'wallet_borrow') {
            $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id_borrow' ";
        } else if ($wallet_type == 'wallet_sharing') {
            $wallet_id     = "AND wlt.`wallet_id` = '$wallet_id_sharing' ";
        } else {
            $l = explode(';', $setup['wallet_cashback_list_id']);

            $str = '';
            foreach ($l as $key => $i) {
                $str     .= " wlt.`wallet_id` = '$i' OR ";
            }
            if ($str != '') {
                $wallet_id = "AND (" . substr($str, 0, -3) . " )";
            }
        }

        if ($limit != '') $limit = "LIMIT $offset, $limit";

        $sql = "SELECT COUNT(*) `total_record`
                FROM `" . $this->class_name . "` wlt
                WHERE
                $client_id
                $wallet_id
                ";

        $result = $db->executeQuery($sql, 1);

        return $result['total_record'] + 0;
    }

    //Huân: 20201228 18:33 => Cập nhật lại giá trị giao dịch đúng cho JOBs
    public function update_right_value_of_tds($new_amount, $dWalletTrans)
    {
        //Update right transaction value

        $old_amount = $dWalletTrans['amount'];

        if ($new_amount < $old_amount) {
            //Trừ lại
            $this->set('from_client', $dWalletTrans['to_client']);
            $this->set('to_client', $dWalletTrans['from_client']);
            $this->set('amount', $old_amount - $new_amount);
            $this->set('wallet_id', $dWalletTrans['wallet_id']);
            $this->transfer_cashback();
        } else {
            //Tăng lên
            $this->set('from_client', $dWalletTrans['from_client']);
            $this->set('to_client', $dWalletTrans['to_client']);
            $this->set('amount', $new_amount - $old_amount);
            $this->set('wallet_id', $dWalletTrans['wallet_id']);
            $this->transfer_cashback();
        }

        $this->set('id', $dWalletTrans['id']);
        $this->set('amount', $new_amount);
        $this->update_amount();

        return true;
    }

    // lịch sử giao dịch của dmember (tùng code - 29012021): HC fixed: 210520
    public function filter_app( $wallet_type, $offset = 0, $limit = '' )
    {   
        global $db, $setup;

        $client_id                             = $this->get('client_id');
        $wallet_id                             = $this->get('wallet_id');

        $client_id     = " ( wlt.`from_client` =  '$client_id' OR wlt.`to_client` =  '$client_id' ) ";

        $l = explode(';', $wallet_id);

        $sqlWallet = '';
        foreach ($l as $key => $i) {
            $sqlWallet     .= " wlt.`wallet_id` = '$i' OR ";
        }

        if ($sqlWallet != '') {
            $sqlWallet = "AND ( " . substr($sqlWallet, 0, -3) . " )";
        }
        
        if ($limit != '') $limit = "LIMIT $offset, $limit";

        $sql = "SELECT wlt.*, mbfrom.`fullname` from_fullname, mbto.`fullname` to_fullname
                FROM `" . $this->class_name . "` wlt
                LEFT JOIN `members` mbfrom ON mbfrom.`user_id` = wlt.`from_client`
                LEFT JOIN `members` mbto ON mbto.`user_id` = wlt.`to_client`
                WHERE
                $client_id
                $sqlWallet
                ORDER BY `id` DESC
                $limit";

        $result = $db->executeQuery_list($sql);

        return $result;
    }

    public function filter_app_count()
    {
        global $db, $setup;

        $client_id                             = $this->get('client_id');
        $wallet_id                             = $this->get('wallet_id');

        $client_id     = " ( wlt.`from_client` =  '$client_id' OR wlt.`to_client` =  '$client_id' ) ";

        $l = explode(';', $wallet_id);

        $sqlWallet = '';
        foreach ($l as $key => $i) {
            $sqlWallet     .= " wlt.`wallet_id` = '$i' OR ";
        }

        if ($sqlWallet != '') {
            $sqlWallet = "AND ( " . substr($sqlWallet, 0, -3) . " )";
        }
        
        $sql = "SELECT COUNT(*) total
                FROM `" . $this->class_name . "` wlt
                WHERE
                $client_id
                $sqlWallet";

        $r = $db->executeQuery($sql, 1);

        return $r['total']+0;

    }

    public function filter_app_in( $offset = '', $limit = '')//lịch sử vào, ko lịch sử ra
    {
        global $db, $setup;

        $client_id                             = $this->get('client_id');
        $wallet_id                             = $this->get('wallet_id');

        $client_id     = " ( wlt.`to_client` =  '$client_id' OR wlt.`from_client` =  '$client_id' ) ";

        $l = explode(';', $wallet_id);
        $sqlWallet = '';
        foreach ($l as $key => $i) {
            $sqlWallet     .= " wlt.`wallet_id` = '$i' OR ";
        }

        if ($sqlWallet != '') {
            $sqlWallet = "AND ( " . substr($sqlWallet, 0, -3) . " )";
        }
        
        if ($limit != '') $limit = "LIMIT $offset, $limit";

        $sql = "SELECT wlt.*, IF(mbfrom.`user_id` = 1, 'Hệ thống', mbfrom.`fullname`) from_fullname, mbto.`fullname` to_fullname
                        , walletName.`wallet_name`, walletName.`wallet_code`, walletName.`name` wallet_symbol
                FROM `" . $this->class_name . "` wlt
                INNER JOIN $db->tbl_fix`product_commission` walletName ON walletName.`id` = wlt.`wallet_id`
                LEFT JOIN `members` mbfrom ON mbfrom.`user_id` = wlt.`from_client`
                LEFT JOIN `members` mbto ON mbto.`user_id` = wlt.`to_client`
                WHERE
                $client_id
                $sqlWallet
                ORDER BY `id` DESC
                $limit";

        $result = $db->executeQuery_list($sql);

        return $result;
    }

    public function filter_app_in_count()//lịch sử vào, ko lịch sử ra
    {
        global $db, $setup;

        $client_id                             = $this->get('client_id');
        $wallet_id                             = $this->get('wallet_id');

        $client_id     = " ( wlt.`to_client` =  '$client_id' OR wlt.`from_client` =  '$client_id' ) ";

        $l = explode(';', $wallet_id);
        $sqlWallet = '';
        foreach ($l as $key => $i) {
            $sqlWallet     .= " wlt.`wallet_id` = '$i' OR ";
        }

        if ($sqlWallet != '') {
            $sqlWallet = "AND ( " . substr($sqlWallet, 0, -3) . " )";
        }
        
        $sql = "SELECT COUNT(*) total FROM (
                    SELECT wlt.`id`
                    FROM `" . $this->class_name . "` wlt
                    INNER JOIN $db->tbl_fix`product_commission` walletName ON walletName.`id` = wlt.`wallet_id`
                    LEFT JOIN `members` mbfrom ON mbfrom.`user_id` = wlt.`from_client`
                    LEFT JOIN `members` mbto ON mbto.`user_id` = wlt.`to_client`
                    WHERE
                    $client_id
                    $sqlWallet
                )n";

        $result = $db->executeQuery($sql, 1);

        return $result['total']+0;
    }

    public function filter_app_in_sum()//Chỉ sum lượng vào ko tính lượt ra
    {
        global $db, $setup;

        $client_id                             = $this->get('client_id');
        $wallet_id                             = $this->get('wallet_id');
        
        $sqlClientID     = " AND (
                                    ( wlt.`to_client` =  '$client_id' OR wlt.`from_client` =  '$client_id' ) 
                                    OR
                                    wlt.`to_client` IS NULL
                                )";

        $l = explode(';', $wallet_id);

        $sqlWallet = '';
        foreach ($l as $key => $i) {
            $sqlWallet     .= " walletName.`id` = '$i' OR ";
        }

        if ($sqlWallet != '') {
            $sqlWallet = "AND ( " . substr($sqlWallet, 0, -3) . " )";
        }
        
        $sql = "SELECT  SUM( IF( wlt.`to_client` = $client_id, IFNULL(`amount`, 0), 0)) total_value
                        , SUM( IF( wlt.`from_client` = $client_id, IFNULL(`amount`, 0), 0)) total_paid
                        , walletName.`id` `wallet_id`
                        , walletName.`wallet_name`
                        , walletName.`wallet_code`
                        , walletName.`name` wallet_symbol
                FROM $db->tbl_fix`product_commission` walletName
                LEFT JOIN $db->tbl_fix`$this->class_name` wlt ON walletName.`id` = wlt.`wallet_id`
                WHERE 1
                $sqlClientID
                $sqlWallet
                GROUP BY walletName.`id`";

        $r = $db->executeQuery_list($sql);

        $kq = array();
        $total_value    = 0;
        $total_paid     = 0;
        foreach ($l as $i) {

            $item['total_value']    = 0;
            $item['total_paid']     = 0;
            $item['wallet_name']    = '';
            $item['wallet_code']    = '';
            $item['wallet_symbol']  = '';
            $item['wallet_id']      = 0;

            foreach ($r as $dVal) {
                if( $dVal['wallet_id'] == $i ){
                    $item['total_value']    = $dVal['total_value'];
                    $item['total_paid']     = $dVal['total_paid'];
                    $item['wallet_name']    = $dVal['wallet_name'];
                    $item['wallet_code']    = $dVal['wallet_code'];
                    $item['wallet_symbol']  = $dVal['wallet_symbol'];
                    $item['wallet_id']      = $dVal['wallet_id'];
                }

                if( $dVal['wallet_id'] == 1 ){
                    $total_value  = $dVal['total_value'];
                    $total_paid   = $dVal['total_paid'];
                    $item['wallet_name']    = 'Quỹ tiền';
                }
            }
            

            $kq[] = $item;
        }


        return array(
            'total_value'   => $total_value,
            'total_paid'    => $total_paid,
            'l'             => $kq
        );

    }
    // end lịch sử giao dịch của dmember

    // hàm lấy danh sách 10 người có giao dịch gần nhất (tùngcode-15/03/2021)
    public function get_top_last_transfers() //hàm get các chứng chỉ theo level và theo khách hàng để xác định khách hàng đã active hay chưa (tùng code - 10/03/2021)
    {
        global $db;

        $from_client = $this->get('from_client');
        // $to_client = $this->get('to_client');

        $sql = "SELECT mb.* FROM wallet_transaction w 
        INNER JOIN ( 
            SELECT `id` FROM ( 
                SELECT MAX(`id`) id FROM ( 
                    SELECT `id`, from_client, to_client 
                    FROM `wallet_transaction` 
                    WHERE `from_client` = '$from_client' ORDER BY id DESC ) n 
                    GROUP BY `to_client` )nn
                ORDER BY id desc LIMIT 10 ) n on n.id = w.`id`
                INNER JOIN members mb ON mb.`user_id` = w.`to_client`"; 
        $result = $db->executeQuery_list($sql);

        return $result;
    }
}
