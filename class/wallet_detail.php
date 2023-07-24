<?php
class wallet_detail extends model{//giá trị cac loại ví;
	
	protected $class_name = 'wallet_detail';
	protected $id;
	protected $wallet_id;
	protected $client_id;// ~ members_id
	protected $amount;//Giá trị trong ví
	protected $last_change;//unix time
	
	public function add(){
		global $db;
		
		$arr['wallet_id'] 						= $this->get('wallet_id');
		$arr['client_id'] 						= $this->get('client_id');
		$arr['amount'] 					        = $this->get('amount');
		$arr['last_change'] 					= time();

        $db->record_insert( $this->class_name, $arr);
        
		unset($arr);
		return $db->mysqli_insert_id();
	}

	public function update(){
		global $db;
		
        $id 								    = $this->get('id');
        
        $arr['wallet_id'] 						= $this->get('wallet_id');
        $arr['client_id'] 						= $this->get('client_id');
        $arr['amount'] 					        = $this->get('amount');
        $arr['last_change'] 					= time();
		
		$db->record_update( $this->class_name, $arr, " `id` = '$id' ");

		unset($arr);
		return true;
	}

	public function tang(){
		global $db;

		$client_id 			= $this->get( 'client_id' );
		$wallet_id 			= $this->get( 'wallet_id' );
		$amount 			= $this->get( 'amount' );

		$time 				= time();

		$d = $this->get_detail_by();

		if( isset( $d['wallet_id']) ){
			$sql = "UPDATE $db->tbl_fix`$this->class_name`  SET `amount` = (`amount` + '$amount'), `last_change` = '$time'  WHERE `client_id` = '$client_id' AND `wallet_id` = '$wallet_id' LIMIT 1";
			$result = $db->executeQuery( $sql );
		}else{
			$this->add();
		}
		
		return true;
	}

	public function giam(){
		global $db;

		$client_id 			= $this->get( 'client_id' );
		$wallet_id 			= $this->get( 'wallet_id' );
		$amount 			= $this->get( 'amount' );
		$time 				= time();
		
		$d = $this->get_detail_by();

		if( isset( $d['wallet_id']) ){
			$sql = "UPDATE $db->tbl_fix`$this->class_name` SET `amount` = (`amount` - '$amount'), `last_change` = '$time' WHERE `client_id` = '$client_id' AND `wallet_id` = '$wallet_id' LIMIT 1";
			$result = $db->executeQuery( $sql );
		}else{
			$this->set( 'amount', -1*$amount );
			$this->add();
		}

		return true;
	}

	public function get_detail_by(){
		global $db;

		$client_id 			= $this->get( 'client_id' );
		$wallet_id 			= $this->get( 'wallet_id' );

		$sql = "SELECT * FROM $db->tbl_fix`$this->class_name` WHERE `client_id`='$client_id' AND  `wallet_id` = '$wallet_id' LIMIT 1";
		
		$row = $db->executeQuery ( $sql, 1 );
		
		return $row;
	}

	public function get_balance(){
		global $db;

		$client_id 			= $this->get( 'client_id' );
		$wallet_id 			= $this->get( 'wallet_id' );

		$sql = "SELECT `amount` FROM $db->tbl_fix`$this->class_name` WHERE `client_id`='$client_id' AND  `wallet_id` = '$wallet_id' LIMIT 1";
		
		$row = $db->executeQuery ( $sql, 1 );
		
		return isset($row['amount']) ? $row['amount']:0;
	}

	//Hàm thanh toán bằng điểm cash back
	public function pay_with_cashback( $shop_id = '', $order_id = '', $order_created_at = '' ){
		global $db, $setup;
		$wallet_transaction = new wallet_transaction();

		$amount				= $this->get( 'amount' );
		$client_id 			= $this->get( 'client_id' );

		$l 					= $this->list_by_client();
		$lCashback 			= explode(';', $setup['wallet_cashback_list_id']);

		foreach ($l as $key => $item) {
			if( in_array($item['wallet_id'], $lCashback ) && $amount > 0 ){//Tất cả còn lại là ví điểm

				$wAmount 		= $item['amount'];
				$amount2Giam	= 0;
				if( $amount < $wAmount ){
					$amount2Giam = $amount;
					$amount = 0;
				}else{
					$amount2Giam = $wAmount;
					$amount = $amount-$wAmount;
				}

				$wallet_transaction->set('from_client', $client_id);
				$wallet_transaction->set('to_client', 1);//Thu hồi về ví tổng
				$wallet_transaction->set('wallet_id', $item['wallet_id']);
				$wallet_transaction->set('amount', $amount2Giam);
				$wallet_transaction->set('shop_id', $shop_id);
				$wallet_transaction->set('order_id', $order_id);
				$wallet_transaction->set('order_created_at', $order_created_at);
				$wallet_transaction->set('note', '');
				$wallet_transaction->set('fee', 0);
				$wallet_transaction->set('transaction_type', 'PAYWITHCASHBACK');
				$wallet_transaction->set('created_by_admin', 0);
				$wallet_transaction->create();

			}
		}

		return $amount == 0 ? true:false;//Nếu bằng fail nghĩa là trừ chưa đủ số lượng

	}
	
	public function list_by_client() {//list all theo tên nhóm chính
		global $db, $setup;
        
		$client_id 						= $this->get('client_id');

        $sql = "SELECT wl.*, procom.`wallet_name` wallet_name, procom.`wallet_code`, procom.`wallet_commission`
                FROM `". $this->class_name ."` wl
                INNER JOIN `product_commission` procom ON procom.id = wl.wallet_id
                WHERE wl.`client_id` =  '$client_id' AND procom.`is_wallet` = 1 ORDER BY `id` ASC";
		
		$result = $db->executeQuery_list( $sql );

		return $result;
	}
	
	public function get_total_wallet_by_client() {//list all theo tên nhóm chính
		global $db, $setup;
		
		$members = new members();
        
		$client_id 			= $this->get('client_id');
		$l 					= $this->list_by_client();

		$kq['wallet_main'] 				= 0;//id = 1
		$kq['wallet_referral'] 			= 0;//id = 2 wallet_referral
		$kq['wallet_cashback'] 			= 0;//All order wallet as defined in setup.wallet_cashback_list_id
		$kq['wallet_register'] 			= 0;
		$kq['wallet_yobetech'] 			= 0;
		$kq['wallet_sharing'] 			= 0;
		$kq['wallet_borrow'] 			= 0;
		$kq['wallet_cashback_detail'] 	= 0;

		$lCashback = explode(';', $setup['wallet_cashback_list_id']);
		
		$members->set('user_id', $client_id);
		$dM = $members->get_detail();
		if( isset($dM['wallet_register']) )
			$kq['wallet_register']  = $dM['wallet_register']+0;

		foreach ($l as $key => $item) {
			if( $item['wallet_id'] == $setup['wallet_id_main']){//Ví chính và ví rút YOBETECH
				$kq['wallet_main'] 		+= $item['amount'];
			}else if( $item['wallet_id'] == $setup['wallet_id_yobetech'] ){//Ví chính và ví rút YOBETECH
				$kq['wallet_yobetech'] 		+= $item['amount'];
			}else if( $item['wallet_id'] == $setup['wallet_id_share'] ){//Ví chia sẻ
				$kq['wallet_referral'] 		+= $item['amount'];
			}else if( $item['wallet_id'] == $setup['wallet_id_cashback'] ){//Ví chia sẻ
				$kq['wallet_cashback'] 	+= $item['amount'];
			}else if( $item['wallet_id'] == $setup['wallet_id_sharing'] ){//Ví chiết khấu 30%
				$kq['wallet_sharing'] 	+= $item['amount'];
			}else if( $item['wallet_id'] == $setup['wallet_id_borrow'] ){//Ví chiết khấu 30%
				$kq['wallet_borrow'] 	+= $item['amount'];
			}else if( in_array($item['wallet_id'], $lCashback )){//Tất cả ví còn lại không còn dùng: do dồn về 1 ví
				$kq['wallet_cashback_detail'] 	+= $item['amount'];
			}
		}

		return $kq;
    }

	public function get_cashflow_by() {//list all theo tên nhóm chính
		global $db, $setup;
		
		$client_id 						= $this->get('client_id');

        $sql = "SELECT SUM(wl.`amount`) total
                FROM `". $this->class_name ."` wl
				INNER JOIN `product_commission` procom ON procom.id = wl.wallet_id
                WHERE wl.`client_id` =  '$client_id' AND procom.`is_wallet` = 1";
		
		$result = $db->executeQuery( $sql, 1 );
		
		return abs($result['total']+0);
    }
    
	public function list_by_wallet( $offset = 0, $limit = '') {//list all theo tên nhóm chính
        global $db;
        
        if( $limit != '' ) $limit = "LIMIT $offset, $limit ";
        
        $wallet_id 						= $this->get('wallet_id');
        $sql = "SELECT wl.*, cl.`fullname`, cl.`mobile`, cl.`wallet`, cl.`wallet_detail`, cl.`email`
                FROM `". $this->class_name ."` wl
                INNER JOIN `members` cl ON cl.`user_id` = wl.client_id
                WHERE wl.`wallet_id` =  '$wallet_id' ORDER BY cl.`fullname` ASC
                $limit";
        
		$result = $db->executeQuery_list( $sql );
        
		return $result;
	}

	public function list_wallet_cashback_showroom() {//list wallet điểm của showroom (tùng code - 13/05/2021)
        global $db, $setup;
        
        $sql = "SELECT wl.*, cl.`member_group_id`, cl.`user_id`
                FROM `". $this->class_name ."` wl
                INNER JOIN `members` cl ON cl.`user_id` = wl.`client_id`
                WHERE wl.`wallet_id` = ".$setup['wallet_id_cashback']." AND cl.`member_group_id` = ".$setup['member_group_id_showroom']." ORDER BY cl.`fullname` ASC";
        
		$result = $db->executeQuery_list( $sql );
        
		return $result;
	}

	public function get_cashback_livestream($user_id) {//lấy ví điểm của khách hàng livestream show lên đơn in (tùng code - 7/1/21)
        global $db, $setup;
        
        $sql = "SELECT *
                FROM `". $this->class_name ."`
                WHERE wallet_id =  ".$setup['wallet_id_cashback']." AND client_id = '$user_id'";
        
		$result = $db->executeQuery( $sql, 1 );
		return $result['amount'];
	}

	public function get_list_wallet_by_client() {//list all theo tên nhóm chính
		global $db, $setup;
		
		$client_id 						= $this->get('client_id');

        $sql = "SELECT IFNULL(wl.`id`, 0) id,IFNULL(wl.`wallet_id`, 0) wallet_id, IFNULL(wl.`client_id`, 0) client_id, IFNULL(wl.`amount`, 0) amount,IFNULL(wl.`last_change`, 0) last_change
				, procom.`wallet_name` wallet_name, procom.`wallet_code`, procom.`wallet_commission`, procom.`is_hidden`
                FROM `". $this->class_name ."` wl
                RIGHT JOIN `product_commission` procom ON procom.`id` = wl.`wallet_id` AND wl.`client_id` =  '$client_id'
				RIGHT JOIN `wallet_transaction` wlt ON wlt.`wallet_id` = wl.`wallet_id` AND (wlt.`to_client` =  '$client_id' OR wlt.`from_client` =  '$client_id')
				WHERE procom.`is_wallet` = 1
				GROUP BY wlt.`wallet_id`
				ORDER BY procom.`id` ASC";
		$result = $db->executeQuery_list( $sql );

		return $result;
	}
	
	public function get_all_wallet_by_client()
	{ //list all theo tên nhóm chính
		global $db, $setup;

		$client_id 						= $this->get('client_id');

		$sql = "SELECT procom.`id` wallet_id, procom.`wallet_name` wallet_name, procom.`wallet_code`, procom.`wallet_commission`, procom.`is_hidden`, procom.`is_transfer`, IFNULL(wl.`amount`, 0) `amount`
                FROM  `product_commission` procom 
                LEFT JOIN `" . $this->class_name . "` wl ON procom.`id` = wl.`wallet_id` AND wl.`client_id` =  '$client_id'
				INNER JOIN `wallet_transaction` wlt ON wlt.`wallet_id` = wl.`wallet_id` AND (wlt.`to_client` =  '$client_id' OR wlt.`from_client` =  '$client_id')
				WHERE procom.`is_wallet` = 1 GROUP BY wlt.`wallet_id` ORDER BY procom.`id` ASC";
				
		$result = $db->executeQuery($sql);
		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			if ($row['is_hidden'] == 1) {
				$row['is_hidden'] = true;
			} else {
				$row['is_hidden'] = false;
			}
			if ($row['is_transfer'] == 1) {
				$row['is_transfer'] = true;
			} else {
				$row['is_transfer'] = false;
			}
			$kq[] = $row;
		}

		return $kq;
	}

	// public function get_total_wallet_by_client_dmember() {//list all theo tên nhóm chính
	// 	global $db, $setup;
		
	// 	$members = new members();
        
	// 	$client_id 			= $this->get('client_id');
	// 	$l 					= $this->list_by_client();

	// 	$kq['DPOINT'] 				= 0;//id = 1
	// 	$kq['Dcash'] 			= 0;//id = 2 wallet_referral
	// 	$kq['DSS'] 			= 0;//All order wallet as defined in setup.wallet_cashback_list_id
	// 	$kq['DGH'] 			= 0;
	// 	$kq['DHS'] 			= 0;
	// 	$kq['wallet_cashback_detail'] 	= 0;

	// 	$lCashback = explode(';', $setup['wallet_cashback_list_id']);
		
	// 	$members->set('user_id', $client_id);
	// 	$dM = $members->get_detail();
	// 	if( isset($dM['wallet_register']) )
	// 		$kq['wallet_register']  = $dM['wallet_register']+0;
			
	// 	foreach ($l as $key => $item) {
	// 		if( $item['wallet_id'] == $setup['wallet_id_main']){//Ví chính và ví rút YOBETECH
	// 			$kq['DPOINT'] 		+= $item['amount'];
	// 		}else if( $item['wallet_id'] == $setup['wallet_id_cashback'] ){//Ví chia sẻ
	// 			$kq['Dcash'] 	+= $item['amount'];
	// 		}else if( $item['wallet_id'] == $setup['wallet_id_dss'] ){//Ví chia sẻ
	// 			$kq['DSS'] 	+= $item['amount'];
	// 		}else if( $item['wallet_id'] == $setup['wallet_id_dgh'] ){//Ví chia sẻ
	// 			$kq['DGH'] 	+= $item['amount'];
	// 		}else if( $item['wallet_id'] == $setup['wallet_id_dhs'] ){//Ví chia sẻ
	// 			$kq['DHS'] 	+= $item['amount'];
	// 		}else if( in_array($item['wallet_id'], $lCashback )){//Tất cả ví còn lại không còn dùng: do dồn về 1 ví
	// 			$kq['wallet_cashback_detail'] 	+= $item['amount'];
	// 		}
	// 	}

	// 	return $kq;
    // }

}

$wallet_detail = new wallet_detail();