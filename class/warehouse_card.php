<?php
#Giá trị ở đây được tính theo số lượng xuất

class warehouse_card {
	
	public function add($inp_arr){
		global $db;

		$arr['days'] = $inp_arr['days'];//Format: m/d/Y
		$arr['product_id'] = $inp_arr['product_id'];
		$arr['sku_id'] = $inp_arr['sku_id'];

		$arr['product_name'] = $inp_arr['product_name'];
		$arr['sum_export'] = $inp_arr['sum_export'];
		$arr['sum_import'] = $inp_arr['sum_import'];
		$arr['user_cron'] = $inp_arr['user_cron'];

		$arr['before_inventory'] = $this->get_before_inventory(strtotime($inp_arr['days']), $inp_arr['product_id'], $inp_arr['sku_id']);
		$arr['difference'] = 0;
		$arr['date_inventory'] = 0;
		$arr['created_at'] = strtotime($inp_arr['days'])+1;
		
		$db->record_insert($db->tbl_fix."warehouse_card",$arr);
		return true;
	}
	
	public function update($inp_arr){
		global $db;

		$arr['sum_export'] = $inp_arr['sum_export'];
		$arr['user_cron'] = $inp_arr['user_cron'];
		
		$db->record_update($db->tbl_fix."warehouse_card",$arr," `days`='".$inp_arr['days']."' AND `product_id`='".$inp_arr['product_id']."' AND `sku_id`='".$inp_arr['sku_id']."' ");
		return true;
	}

	//For add have import to warehouse
	public function add_import($inp_arr){

		global $db;
		$arr['days'] = $inp_arr['days'];//Format: m/d/Y
		$arr['sku_id'] = $inp_arr['sku_id'];
		$arr['product_id'] = $inp_arr['product_id'];
		$arr['product_name'] = $inp_arr['product_name'];
		$arr['before_inventory'] = $inp_arr['before_inventory'];
		$arr['sum_export'] = $inp_arr['sum_export'];
		$arr['sum_import'] = $inp_arr['sum_import'];
		$arr['user_cron'] = $inp_arr['user_cron'];
		$arr['difference'] = $inp_arr['difference'];
		$arr['created_at'] = strtotime($inp_arr['days'])+1;
		$db->record_insert($db->tbl_fix."warehouse_card",$arr);
		
	}
	//For update have import to warehouse
	public function update_import($inp_arr){
		global $db;
		
		$arr['sum_import'] = $inp_arr['sum_import'];		
		$arr['user_cron'] = $inp_arr['user_cron'];
		
		$db->record_update($db->tbl_fix."warehouse_card",$arr," `days`='".$inp_arr['days']."' AND `product_id`='".$inp_arr['product_id']."' AND `sku_id`='".$inp_arr['sku_id']."'");
	}

	//cap nhat chenh lech trong ngay dược đồng bộ
	public function update_difference( $days, $product_id, $sku_id, $difference, $user_cron ){
		global $db;
		$SKU = new SKU();
		
		$arr['difference'] = $difference;
		$arr['user_cron'] = $user_cron;
		$arr['date_inventory'] = time();

		// $dthis = $this->get_detail( $days, $product_id, $sku_id );
		
		// if( isset($dthis['days']) ){
			$db->record_update( $db->tbl_fix."warehouse_card", $arr, " `days`='".$days."' AND `product_id`='".$product_id."' AND `sku_id`='".$sku_id."'");
		// }else{
		// 	$dlast = $this->get_last_record( $product_id, $sku_id );
		// 	if( isset($dlast['days']) ){
				
		// 		$arr_inp['days'] = $days;
		// 		$arr_inp['product_id'] = $product_id;
		// 		$arr_inp['sku_id'] = $sku_id;

		// 		$arr_inp['product_name'] = $dlast['product_name'];
		// 		$arr_inp['sum_export'] = $dlast['sum_export'];
		// 		$arr_inp['sum_import'] = $dlast['sum_import'];
		// 		$arr_inp['user_cron'] = $user_cron;
		// 		$arr_inp['before_inventory'] = $dlast['before_inventory'];
		// 		$arr_inp['difference'] = $difference;
		// 		$this->add_inventory( $arr_inp );

		// 	}else{
				
		// 		$product_name = $SKU->getFullNameSKU( $product_id, $sku_id );
				
		// 		$arr_inp['days'] = $days;
		// 		$arr_inp['product_id'] = $product_id;
		// 		$arr_inp['sku_id'] = $sku_id;

		// 		$arr_inp['product_name'] = $product_name;
		// 		$arr_inp['sum_export'] = 0;
		// 		$arr_inp['sum_import'] = 0;
		// 		$arr_inp['user_cron'] = $user_cron;
		// 		$arr_inp['before_inventory'] = 0;
		// 		$arr_inp['difference'] = $difference;
				
		// 		$this->add_inventory($arr_inp);

		// 	}
		// }

		// unset($arr);
		// unset($arr_inp);
		return true;
	}

	public function add_inventory($inp_arr){
		global $db;

		$arr['days'] = $inp_arr['days'];//Format: m/d/Y
		$arr['product_id'] = $inp_arr['product_id'];
		$arr['sku_id'] = $inp_arr['sku_id'];

		$arr['product_name'] = $inp_arr['product_name'];
		$arr['sum_export'] = $inp_arr['sum_export'];
		$arr['sum_import'] = $inp_arr['sum_import'];
		$arr['user_cron'] = $inp_arr['user_cron'];

		$arr['before_inventory'] = $inp_arr['before_inventory'];
		$arr['difference'] = $inp_arr['difference'];
		$arr['date_inventory'] = time();
		$arr['created_at'] = time();
		$arr['difference'] = $inp_arr['difference'];

		$db->record_insert($db->tbl_fix."warehouse_card",$arr);
	}
	
	public function get_detail($days,$product_id,$sku_id){//$days: format: m/d/Y
		global $db;
		$sql = "SELECT * FROM `warehouse_card` WHERE `product_id` = '".$product_id."' AND `sku_id` = '".$sku_id."' AND  `days` = '".$days."' LIMIT 1";
		$result = $db->executeQuery ( $sql , 1 );

		return $result;
	}

	public function listall_nocron_by_category( $shop_id, $cat_id, $from, $to, $keyword ){
		global $db;
		
		$from_days = date('m/d/Y', $from);
		$from = strtotime( $from_days );
		$to_days = date('m/d/Y',$to);

		if( $keyword 	!= '' ) $keyword 	= " AND pro.`keyword` LIKE '%$keyword%' ";
		if( $cat_id 	!= '' ) $cat_id 	= " AND pro.`cat_id` = '$cat_id' ";
		
		$sql = "SELECT 
				whc.`product_name`, SKU.`code`
				,whc.`sku_id`
				,whc.`product_id`
				,MAX(`whc`.`created_at`) as last_update
				,MAX(`whc`.`date_inventory`) as date_inventory
				,pro.`unit_import`, pro.`unit_export`, pro.`ratio_convert`
				FROM `warehouse_card` as whc
				INNER JOIN `SKU` ON `SKU`.`id` = `whc`.`sku_id` AND `SKU`.`product_id` = `whc`.`product_id`
				INNER JOIN `product` as pro ON `pro`.`id` = `whc`.`product_id`
				WHERE `pro`.shop_id = '$shop_id' AND `whc`.`created_at`<'$to' $cat_id $keyword
				GROUP BY `SKU`.unique_id ORDER BY `whc`.product_name ASC";
		
		$result = $db->executeQuery ( $sql );

		$rt = array();
		while( $item  = mysqli_fetch_assoc( $result ) ){
			
			$item['before_inventory'] = $this->get_before_inventory( $from, $item['product_id'], $item['sku_id'] )+0;//ton dau ky
			$item['after_inventory'] = $this->get_after_inventory( $to, $item['product_id'], $item['sku_id'] )+0;//ton cuoi ky
			$item['sum_return'] = $this->sum_return( $shop_id, $from, $to, $item['product_id'], $item['sku_id'] )+0;//tong tra
			$sum_import_and_export = $this->sum_import_and_export( $from, $to, $item['product_id'], $item['sku_id'] );
			$item['sum_export'] = $sum_import_and_export['sum_export']+0;
			$item['sum_import'] = $sum_import_and_export['sum_import']+0;
			$item['difference'] = $sum_import_and_export['difference']+0;
			$item['total_current'] = ($item['before_inventory'] + $item['sum_import'] - $item['sum_export'] - $item['difference']) + $item['sum_return'];
			$rt[] = $item;

		}
		
		return $rt;
	}
	
	public function listall_nocron( $shop_id, $keyword, $from, $to, $offset = 0, $limit = '' ){
		global $db;
		
		if( $keyword != '' ) $keyword = " AND pro.`keyword` LIKE '%$keyword%' ";
		if( $limit != '' ) $limit = "LIMIT $offset, $limit";
		
		$sql = "SELECT 
				whc.`product_name`
				,whc.`sku_id`
				,whc.`product_id`
				,MAX(`whc`.`created_at`) as last_update
				,MAX(`whc`.`date_inventory`) as date_inventory
				,pro.`unit_import`, pro.`unit_export`, pro.`ratio_convert`
				,SKU.`code`
				FROM `warehouse_card` as whc
				INNER JOIN `SKU` ON `SKU`.`id` = `whc`.`sku_id` AND `SKU`.`product_id` = `whc`.`product_id`
				INNER JOIN `product` as pro ON `pro`.`id` = `whc`.`product_id`
				WHERE `pro`.shop_id = '$shop_id' AND `whc`.`created_at` < '$to' $keyword
				GROUP BY `SKU`.unique_id ORDER BY `whc`.product_name ASC
				$limit";
		
		$result = $db->executeQuery ( $sql );
		
		$rt = array();
		while( $item  = mysqli_fetch_assoc( $result ) ){
			
			$item['before_inventory'] = $this->get_before_inventory( $from, $item['product_id'], $item['sku_id'] )+0;//ton dau ky
			$item['after_inventory'] = $this->get_after_inventory( $to, $item['product_id'], $item['sku_id'] )+0;//ton cuoi ky
			$item['sum_return'] = $this->sum_return( $shop_id, $from, $to, $item['product_id'], $item['sku_id'] )+0;//tong tra
			$sum_import_and_export = $this->sum_import_and_export( $from, $to, $item['product_id'], $item['sku_id'] );
			$item['sum_export'] = $sum_import_and_export['sum_export']+0;
			$item['sum_import'] = $sum_import_and_export['sum_import']+0;
			$item['difference'] = $sum_import_and_export['difference']+0;
			$item['total_current'] = ($item['before_inventory'] + $item['sum_import'] - $item['sum_export'] - $item['difference']) + $item['sum_return'];
			$rt[] = $item;

		}
		
		return $rt;
	}

	public function listall_nocron_count( $shop_id, $keyword, $from, $to  ){
		global $db;
		
		if( $keyword != '' ) $keyword = " AND pro.`keyword` LIKE '%$keyword%' ";
		
		$sql = "SELECT COUNT(*) total
					FROM( SELECT `whc`.created_at
					FROM `warehouse_card` as whc
					INNER JOIN `SKU` ON `SKU`.`id` = `whc`.`sku_id` AND `SKU`.`product_id` = `whc`.`product_id`
					INNER JOIN `product` as pro ON `pro`.`id` = `whc`.`product_id`
					WHERE `pro`.shop_id = '$shop_id' AND `whc`.`created_at`<'$to' $keyword
					GROUP BY `SKU`.unique_id ORDER BY `whc`.product_name ASC
				) tBN";
		
		$result = $db->executeQuery ( $sql, 1 );
		
		return $result['total']+0;
	}

	// public function pending_quantity_online( $shop_id, $product_id, $sku_id, $from, $to ){
	// 	global $db;
		
	// 	$sql = "SELECT SUM(dc.quantity) as total
	// 			FROM `detail_cart_".$shop_id."_".date('Y', $from)."` as dc
	// 			INNER JOIN `cart_".$shop_id."_".date('Y', $from)."` as `cart` ON `cart`.`id` = `dc`.`cart_id`
	// 			WHERE `dc`.sku_id = '".$sku_id."' AND `dc`.product_id = '".$product_id."' AND ".$from." < `cart`.`created_at` AND `cart`.`created_at`<".$to." AND `status`= '1' AND `saw` = '0' ";
		
	// 	$result = $db->executeQuery ( $sql , 1);
		
	// 	return $result['total'];
	// }

	//lay gia tri ton dau ky
	public function get_before_inventory($from_days, $product_id, $sku_id){//$from_days format:  value of strtotime 
		global $db;

		$sql = "SELECT `whc`.before_inventory, `whc`.sum_import, `whc`.sum_export ,`whc`.difference
				FROM `warehouse_card` as whc
				WHERE `whc`.`product_id`='".$product_id."' AND `whc`.`sku_id`='".$sku_id."' AND `created_at` < ".$from_days." ORDER BY `whc`.`created_at` DESC LIMIT 1";

		$result = $db->executeQuery ( $sql , 1 );
		return ($result['before_inventory'] + $result['sum_import'] - $result['sum_export'] - $result['difference']);
	}

	// lay gia tri ton cuoi ky
	public function get_after_inventory($to_days, $product_id, $sku_id){//$to_days format: is value of strtotime
		global $db;
		
		$sql = "SELECT `whc`.before_inventory ,`whc`.sum_import ,`whc`.sum_export ,`whc`.difference
				FROM `warehouse_card` as whc
				WHERE `whc`.`sku_id`='".$sku_id."' AND `whc`.`product_id`='".$product_id."' AND `whc`.created_at <= ".$to_days." ORDER BY created_at DESC LIMIT 1";
		
		$result = $db->executeQuery ( $sql , 1 );
		
		return ( $result['before_inventory'] + $result['sum_import'] - $result['sum_export'] - $result['difference'] );
	}

	// lay gia tri ton cuoi ky
	public function sum_import_and_export($from, $to, $product_id, $sku_id){//$to_days format: is value of strtotime
		global $db;
		
		$sql = "SELECT SUM(`whc`.sum_import) as sum_import, SUM(`whc`.sum_export) as sum_export,SUM(`whc`.difference) as difference
				FROM `warehouse_card` as whc
				WHERE `whc`.`sku_id`='".$sku_id."' AND `whc`.`product_id`='".$product_id."' AND ".$from." <= `whc`.created_at  AND `whc`.created_at < ".$to;
		
		$result = $db->executeQuery ( $sql, 1 );
		
		return $result;
	}

	//Tong tra ve o ca pos va online
	public function sum_return( $shop_id, $from, $to, $product_id, $sku_id){//$to_days format: is value of strtotime
		global $db;
		
		$sql = "SELECT quantity
				FROM `detail_order_".$shop_id."_".date('Y', $from)."` as `detail_order`
				WHERE `detail_order`.`sku_id`='".$sku_id."' AND `detail_order`.`product_id`='".$product_id."' AND `detail_order`.date_add > ".$from." AND `detail_order`.date_add < ".$to." AND quantity < 0";
		$result1 = $db->executeQuery ( $sql , 1 );

		// $sql = "SELECT quantity
		// 		FROM `detail_cart_".$shop_id."_".date('Y', $from)."` as `detail_cart`
		// 		WHERE `detail_cart`.`sku_id`='".$sku_id."' AND `detail_cart`.`product_id`='".$product_id."' AND `detail_cart`.created_at > ".$from." AND `detail_cart`.created_at < ".$to." AND quantity < 0";
		
		$result1 = $db->executeQuery ( $sql , 1 );

		return abs($result1['quantity']);
	}

	public function get_first($days,$product_id, $sku_id){
		global $db;
		$sql = "SELECT 
				`whc`.before_inventory
				FROM `warehouse_card` as whc
				WHERE `whc`.`product_id`='".$product_id."' AND `whc`.`sku_id`='".$sku_id."' AND '".$days."'=`days` LIMIT 1";
				
		$result = $db->executeQuery ( $sql , 1 );
		return $result['before_inventory'];
	}
	
	public function get_last_record($product_id, $sku_id){
		global $db;
		
		$sql = "SELECT *
				FROM `warehouse_card` as whc
				WHERE `whc`.`product_id`='".$product_id."' AND `whc`.`sku_id`='".$sku_id."' ORDER BY created_at DESC LIMIT 1";
		
		$result = $db->executeQuery ( $sql, 1 );
		
		return $result;
	}

	public function get_last($days, $product_id, $sku_id){
		global $db;
		
		$sql = "SELECT 
				`whc`.before_inventory ,`whc`.sum_import ,`whc`.sum_export ,`whc`.difference
				FROM `warehouse_card` as whc
				WHERE `whc`.`product_id`='".$product_id."' AND `whc`.`sku_id`='".$sku_id."' ORDER BY created_at DESC LIMIT 1";
		
		$result = $db->executeQuery ( $sql , 1 );
		
		return ($result['before_inventory'] + $result['sum_import'] - $result['sum_export'] - $result['difference']);
	}

	public function is_exist_product( $product_id ){
		global $db;
		
		$sql = "SELECT 
				COUNT(*) total
				FROM `warehouse_card` as whc
				WHERE `whc`.`product_id`='".$product_id."' LIMIT 1";
		
		$result = $db->executeQuery ( $sql , 1 );
		
		if( isset($result['total']) && $result['total'] >0  )
			return 1;

		return 0;
	}

	/*
	-- UPDATE or INSERT amount export to warehouse_card table: in phpjquery/main_index.php $act = wh_card_update_detail
	*/
	public function update_warehouse_card( $shop_id, $order_id ){
		global $db;
		$goods = new goods();
		
		$sql = "SELECT SUM( detail_order.amount * recipe.amount ) AS total_used, goods_id
				FROM `detail_order_".$shop_id."_".date('Y', $from)."` as `detail_order`
				LEFT JOIN recipe ON detail_order.menu_id = recipe.menu_id
				WHERE `detail_order`.order_id = '".$order_id."'
				GROUP BY recipe.goods_id";
		
		$result = $db->executeQuery ( $sql );

		$strtoday = date('m/d/Y');
		$yesterday = date('m/d/Y', time() - 86400);
		while($row = mysqli_fetch_assoc($result)){

			$dgoods = $goods->get_detail($row['goods_id']);
			$today = $this->get_detail($strtoday,$row['goods_id']);//Tính tồn đầu kỳ
			
			if($today==''){//insert
				$dthis = $this->get_detail($yesterday,$row['goods_id']);//Tính tồn đầu kỳ
				if($dgoods['export_value']>0){
					$before_value = $dthis['before_inventory']+$dthis['sum_import']-($dthis['sum_export']/$dgoods['export_value'])-$dthis['difference'];//Đầu kỳ - xuất trong kỳ + nhập trong kỳ - chênh lệnh (Chênh lệch của hệ thống là chênh lêch âm)
				}else{
					$before_value = 0;
				}
				
				$arr['days'] = $strtoday; //Format: m/d/Y
				$arr['goods_id'] = $row['goods_id']; //Goods_id
				$arr['goods_name'] = $dgoods['name'];
				$arr['type_goods'] = $dgoods['type'];
				$arr['before_inventory'] = $before_value;
				$arr['sum_export'] = $row['total_used'];
				$arr['sum_import'] = 0;
				$arr['warehouse_id'] = $dgoods['warehouse_id'];
				$arr['unit_id'] = $dgoods['unit_id'];
				$arr['user_cron'] = $_SESSION['username_client'];
				$arr['difference'] = 0;
		
				$this->add($arr);
				
			}else{//update
				
				$arr['days'] = $strtoday; //Format: m/d/Y
				$arr['goods_id'] = $row['goods_id']; //Goods_id
				
				//$arr['type_goods'] = $dgoods['type'];
				//$arr['goods_name'] = $dgoods['name'];
				//$arr['before_inventory'] = $before_value;
				$arr['sum_export'] = $row['total_used'] + $today['sum_export'];
				//$arr['sum_import'] = $sum_import;
				//$arr['warehouse_id'] = $dgoods['warehouse_id'];
				//$arr['unit_id'] = $dgoods['unit_id'];
				$arr['user_cron'] = $_SESSION['username_client'];
				//$arr['difference'] = 0;
				
				$this->update($arr);
			}
		}
		
		return true;
	}
	/*
	- update or insert amount import of sku to warehouse_card table: used in phpjquery/accountant_storing.php
	*/
	public function update_warehouse_card_import($wh_import_id){//$date format: value return of strtotime
		global $db;
		$goods = new goods();
		
		$sql = "SELECT SUM(amount) as sum_import,`whh`.goods_id
				FROM `warehouse_history` as whh
				WHERE `whh`.wh_import_id = '".$wh_import_id."'
				GROUP BY `whh`.goods_id DESC
				";
		
		$result = $db->executeQuery ( $sql );

		$strtoday = date('m/d/Y');
		$yesterday = date('m/d/Y', time() - 86400);
		
		while($row = mysqli_fetch_assoc($result)){

			$dgoods = $goods->get_detail($row['goods_id']);
			$today = $this->get_detail($strtoday,$row['goods_id']);//Kiểm tra chi tiết mã hàng ngày hôm nay đã có record chưa
			
			if( $today == '' ){//insert
				
				if($dgoods['export_value']>0){
					$before_value = $this->get_before_inventory(strtotime(date('m/d/Y')),$row['goods_id'],$dgoods['export_value']);//get before_inventory to update to new record
				}else{
					$before_value = 0;
				}

				$arr['days'] = $strtoday; //Format: m/d/Y
				$arr['goods_id'] = $row['goods_id']; //Goods_id
				$arr['goods_name'] = $dgoods['name'];
				$arr['type_goods'] = $dgoods['type'];
				$arr['before_inventory'] = $before_value;
				$arr['sum_export'] = 0;
				$arr['sum_import'] = $row['sum_import'];
				$arr['warehouse_id'] = $dgoods['warehouse_id'];
				$arr['unit_id'] = $dgoods['unit_id'];
				$arr['user_cron'] = $_SESSION['username_client'];
				$arr['difference'] = 0;
		
				$this->add_import($arr);
				
			}else{//update
				
				$arr['days'] = $strtoday; //Format: m/d/Y
				$arr['goods_id'] = $row['goods_id']; //Goods_id
				$arr['sum_import'] = $row['sum_import'];;
				$arr['user_cron'] = $_SESSION['username_client'];
				
				$this->update_import($arr);
			}
		}
		
		return true;
	}

	//Cap nhat so luong nhap kho
	public function update_import_amount( $product_id, $sku_id, $product_name, $user_cron, $amount , $plus_or_subtract ){
		//@@ Cap nhat so luong nhap kho: tuong ung $plus_or_subtract se cong hay tru ra khoi kho, neu record chua duoc tao thi se khoi tao
		global $db;
		$days = date('m/d/Y');
		$dcart = $this->get_detail($days, $product_id, $sku_id);

		if(isset( $dcart['days'] )){

			if($plus_or_subtract == 'plus'){
				$sql = "UPDATE `warehouse_card` SET `sum_import` = (`sum_import` + ".$amount.") WHERE `product_id`='".$product_id."' AND `sku_id`='".$sku_id."' AND days='".$days."'";

				$db->executeQuery($sql);
				return true;
			}else if($plus_or_subtract == 'subtract'){
				$sql = "UPDATE `warehouse_card` SET `sum_import` = (`sum_import` - ".$amount.") WHERE `product_id`='".$product_id."' AND `sku_id`='".$sku_id."' AND days='".$days."'";
				$db->executeQuery($sql);
				return true;
			}

		}else{

			$arr['days'] = $days;
			$arr['product_id'] = $product_id;
			$arr['sku_id'] = $sku_id;
			$arr['sum_export'] = 0;
			$arr['product_name'] = $product_name;
			
			$arr['user_cron'] = $user_cron;

			if( $plus_or_subtract == 'plus' ){

				$arr['sum_import'] = $amount;
				$this->add($arr);
				return true;

			}else if( $plus_or_subtract == 'subtract' ){
				$arr['sum_import'] = -1 * $amount;
				$this->add($arr);
				return true;
			}

		}

		return false;
	}
	//Cap nhat so luong nhap kho
	public function update_export_amount( $product_id, $sku_id, $product_name, $user_cron, $amount , $plus_or_subtract ){
		//@@ Cap nhat so luong nhap kho: tuong ung $plus_or_subtract se cong hay tru ra khoi kho, neu record chua duoc tao thi se khoi tao
		global $db;
		$days = date('m/d/Y');
		$dcart = $this->get_detail( $days, $product_id, $sku_id );
		
		if( isset( $dcart['days'] ) ){

			if( $plus_or_subtract == 'plus' ){
				$sql = "UPDATE `warehouse_card` SET `sum_export` = (`sum_export` + ".$amount.") WHERE `product_id`='".$product_id."' AND `sku_id`='".$sku_id."' AND days='".$days."'";
				$db->executeQuery($sql);
				return true;
			}else if($plus_or_subtract == 'subtract'){
				$sql = "UPDATE `warehouse_card` SET `sum_export` = (`sum_export` - ".$amount.") WHERE `product_id`='".$product_id."' AND `sku_id`='".$sku_id."' AND days='".$days."'";
				$db->executeQuery($sql);
				return true;
			}
			
		}else{
			
			$arr['days'] = $days;
			$arr['product_id'] = $product_id;
			$arr['sku_id'] = $sku_id;
			$arr['sum_import'] = 0;
			$arr['product_name'] = $product_name;
			$arr['user_cron'] = $user_cron;
			$arr['sum_export'] = $amount;
			$this->add($arr);
			return true;
			
		}
		return false;
	}

	//Update amount of goods in wh_card table after the goods is remove from warehouse_history table
	public function update_whcard_delete( $product_id, $sku_id, $amount_subtract ){
		global $db;
		$sql = "UPDATE `warehouse_card` SET `sum_import` = (`sum_import` - ".$amount_subtract.") WHERE `product_id`='".$product_id."' AND `sku_id` = '".$sku_id."' AND days='".date('m/d/Y')."'";
		$db->executeQuery($sql);
		return true;
	}

}
$wh_card = new warehouse_card();