<?php
class shop {

	private $id;
	private $printer_id;
	private $printer_name;
	private $name;
	private $warehouse_id;
	private $address;
	private $tax_code;
	private $mobile;
	private $username;
	private $is_wholesale_price;
	private $update_cook;
	private $update_bartender;
	private $allow_report;
	private $time_report;
	private $date_report;
	private $coffers;
	private $online_status;
	private $master_id;
	private $master_name;
	private $master_info;
	private $master_update;
	private $surcharge_on;
	private $surcharge_percent;
	private $surcharge_from;
	private $surcharge_to;
	private $created_at;
	private $note_in_bill;
	private $printing_form;
	private $bill_setting;
	private $default_member_group;
	private $payment_default;

	// set value with paramater
	public function set( $parameter, $val) {
		$this->$parameter = $val;
		return true;
	}
	// get value with paramater
	public function get( $parameter ) {
		return $this->$parameter;
	}

	public function add(){
		global $db;

		$name 		= $this->get('name');
		$username 	= $this->get('username');

		$sql = "SELECT `name` FROM $db->tbl_fix`shop` WHERE `name` = '$name' LIMIT 0,1";		
		$row = $db->executeQuery ( $sql, 1 );

		if( !isset($row['name']) ){
			
			$arr['name'] 				= $this->get('name');
			$arr['tax_code'] 			= $this->get('tax_code');
			$arr['address'] 			= $this->get('address');
			$arr['mobile'] 				= $this->get('mobile');
			$arr['username'] 			= $this->get('username');
			$arr['allow_report'] 		= $this->get('allow_report');
			$arr['default_member_group']= $this->get('default_member_group');
			$arr['payment_default']		= $this->get('payment_default');
			$arr['is_wholesale_price'] 	= '0';

			$db->record_insert( $db->tbl_fix.'shop', $arr );

		}else{
			exit('Trùng tên với một của hàng đã tạo trước đó');
		}
		
		return $db->mysqli_insert_id();
	}
	
	public function update(){
		global $db;
		
		$id 						= $this->get('id');
		
		$arr['time_report'] 		= 0;
		$arr['date_report'] 		= 0;

		$arr['name'] 				= $this->get('name');
		$arr['tax_code'] 			= $this->get('tax_code');
		$arr['address'] 			= $this->get('address');
		$arr['mobile'] 				= $this->get('mobile');
		$arr['username'] 			= $this->get('username');
		$arr['allow_report'] 		= $this->get('allow_report');
		$arr['default_member_group']= $this->get('default_member_group');
		$arr['payment_default']		= $this->get('payment_default');
		
		$db->record_update( $db->tbl_fix.'shop', $arr, " `id` = '$id' ");

		return true;
	}

	public function update_surcharge( $shop_id, $surcharge_on, $surcharge_percent, $surcharge_from, $surcharge_to ){
		global $db;

		$arr['surcharge_on'] = $surcharge_on;
		$arr['surcharge_percent'] = $surcharge_percent;
		$arr['surcharge_from'] = $surcharge_from;
		$arr['surcharge_to'] = $surcharge_to;
		
		$db->record_update( $db->tbl_fix."shop", $arr, " `id`='".$shop_id."'");
		return true;
	}
	
	public function update_wholesale_price( $shop_id, $status){
		global $db,$database;
		
		
		$arr['is_wholesale_price'] = $status;
		$db->record_update($db->tbl_fix."shop", $arr, " `id`='".$shop_id."'");
		
		
		return true;
	}

	public function update_cook($shop_id){
		global $db,$database;
		

		$arr['update_cook'] = time();
		
		$db->record_update($db->tbl_fix."shop",$arr," id='".$shop_id."'");
		
		

		return true;
	}
	
	public function update_bartender($shop_id){
		global $db,$database;
		

		$arr['update_bartender'] = time();
		
		$db->record_update($db->tbl_fix."shop",$arr," id='".$shop_id."'");
		
		

		return true;
	}
	
	public function update_price_table($shop_id, $is_wholesale_price){
		global $db,$database;
		

		$arr['is_wholesale_price'] = $is_wholesale_price;
		
		$db->record_update($db->tbl_fix."shop",$arr," id='".$shop_id."'");
		
		

		return true;
	}
	public function update_price_title($shop_id,$name_table_1,$name_table_2,$name_table_3,$name_table_4,$name_table_5){
		global $db,$database;
		
		
		$arr['name_price_1'] = $name_table_1;
		$arr['name_price_2'] = $name_table_2;
		$arr['name_price_3'] = $name_table_3;
		$arr['name_price_4'] = $name_table_4;
		$arr['name_price_5'] = $name_table_5;
		
		$db->record_update($db->tbl_fix."shop",$arr," id='".$shop_id."'");
		
		

		return true;
	}
	
	public function get_detail($id){
		global $db;
		
		$sql = "SELECT * FROM ".$db->tbl_fix."`shop` WHERE id='".$id."' LIMIT 0,1";
		$row = $db->executeQuery ( $sql, 1 );
		
		if( isset($row['id']) ){
			$surcharge_from = explode(":", $row['surcharge_from']);
			$surcharge_to = explode(":", $row['surcharge_to']);
			@$row['surcharge_from_hour'] = $surcharge_from['0'];
			@$row['surcharge_from_minute'] = $surcharge_from['1'];
			@$row['surcharge_to_hour'] = $surcharge_to['0'];
			@$row['surcharge_to_minute'] = $surcharge_to['1'];
			unset( $row['surcharge_from'] );
			unset( $row['surcharge_to'] );
		}
		
		return $row;
	}

	public function get_shop_name( $id ){
		global $db;
		
		$sql = "SELECT `name` FROM `shop` WHERE id = '$id' LIMIT 0,1";
		$row = $db->executeQuery ( $sql, 1 );
		
		return $row['name'];
	}
	
	public function get_min_id(){
		global $db;
		$sql = "SELECT MIN(id) as min_id FROM ".$db->tbl_fix."`shop`";
		$row = $db->executeQuery ( $sql, 1 );
		return $row['min_id'] + 0;
	}
	
	public function delete($id){
		global $db,$database;
		
		
		$arr['username'] = 'deleted';
		$arr['id'] = '-'.$id;
		
		$db->record_update( $db->tbl_fix."`shop`",$arr, " `id` = '$id' " );
		$db->record_update( $db->tbl_fix."`warehouse`", $arr, " `shop_id` = '$id' " );
		
		
		return true;
	}

	public function update_printer_info( $id, $printer_id, $printer_name ){
		global $db;
		
		$arr['printer_id'] = $printer_id;
		$arr['printer_name'] = $printer_name;
		$db->record_update( $db->tbl_fix."`shop`", $arr, " `id`='$id'" );
		
		return true;
	}

	public function listby_username($username){
		global $db;

		$sql = "SELECT * FROM ".$db->tbl_fix."`shop` WHERE `username`='".$username."' AND `id`>0 ORDER BY id ASC";
		
		$result = $db->executeQuery ( $sql);
		$kq = array();
		while($row = mysqli_fetch_assoc($result)){
			$surcharge_from = explode(":", $row['surcharge_from']);
			$surcharge_to = explode(":", $row['surcharge_to']);

			@$row['surcharge_from_hour'] = $surcharge_from['0'];
			@$row['surcharge_from_minute'] = $surcharge_from['1'];
			@$row['surcharge_to_hour'] = $surcharge_to['0'];
			@$row['surcharge_to_minute'] = $surcharge_to['1'];
			unset( $row['surcharge_from'] );
			unset( $row['surcharge_to'] );
			$kq[] = $row;

		}
		return $kq;
	}

	public function list_all(){
		global $db;

		$sql = "SELECT * FROM ".$db->tbl_fix."`shop` WHERE `id` > 0 ORDER BY id ASC";
		
		$result = $db->executeQuery ( $sql);
		$kq = array();
		while($row = mysqli_fetch_assoc($result)){
			$surcharge_from = explode(":", $row['surcharge_from']);
			$surcharge_to = explode(":", $row['surcharge_to']);

			@$row['surcharge_from_hour'] = $surcharge_from['0'];
			@$row['surcharge_from_minute'] = $surcharge_from['1'];
			@$row['surcharge_to_hour'] = $surcharge_to['0'];
			@$row['surcharge_to_minute'] = $surcharge_to['1'];
			unset( $row['surcharge_from'] );
			unset( $row['surcharge_to'] );
			$kq[] = $row;

		}
		return $kq;
	}
	
	public function listby_accessed( $accessed ){
		global $db;

		$arr_acc = explode(":",$accessed);
		$where_shop = '';

		if(is_array($arr_acc)){
			foreach($arr_acc as $key=>$item){
				if($item!=''){
					$where_shop .= "OR `id`='".$item."' ";
				}
			}
			$where_shop = substr($where_shop,2);
		}
		
		if($where_shop != ''){
			$sql = "SELECT * FROM ".$db->tbl_fix."`shop` WHERE ".$where_shop." ORDER BY id ASC";
			
			$result = $db->executeQuery ( $sql);
			while($row = mysqli_fetch_assoc($result)){
				$kq[] = $row;
			}
		}
		
		return $kq;
	}
	
	//check admin on shop is true
	public function admin_onshop( $username, $shop_id ){
		global $db, $database;
		

		$sql = "SELECT * FROM ".$db->tbl_fix."`shop` WHERE `username`='".$username."' AND `id`='".$shop_id."' ORDER BY id ASC";
		
		$result = $db->executeQuery ( $sql,2);

		

		return $result;
	}
	
	public function listby_username_option($username){
		global $db,$database;
		
		
		$sql = "SELECT `shop`.id,`shop`.name,`wh`.name as warehouse_name, `wh`.id as warehouse_id FROM ".$db->tbl_fix."`shop`
				INNER JOIN `warehouse` wh ON wh.shop_id = `shop`.id
				WHERE `shop`.`username` = '".$username."'
				AND `shop`.`id` > 0 AND `wh`.id > 0 AND `wh`.id IS NOT NULL
				ORDER BY `shop`.id ASC";

		$result = $db->executeQuery ( $sql);
		$option = '';
		while($row = mysqli_fetch_assoc($result)){
			
			$option .= "<option warehouse-name=\"".$row['warehouse_name']."\" warehouse-id=\"".$row['warehouse_id']."\" value='".$row['id']."'>".$row['name']."</option>";
			
		}
		
		
		
		return $option;
	}

	public function listby_username_option_2($username){
		global $db,$database;
		
		
		$sql = "SELECT `shop`.id,`shop`.name FROM ".$db->tbl_fix."`shop`
				WHERE `shop`.`username`='".$username."' AND `shop`.`id` > 0 ORDER BY `shop`.id ASC";
		$result = $db->executeQuery ( $sql);
		
		$option = '';
		while($row = mysqli_fetch_assoc($result)){
			
			$option .= "<option value='".$row['id']."'>".$row['name']."</option>";
			
		}	
		
		
		
		return $option;
	}

	public function opt_all(){
		global $db,$database;
		
		
		$sql = "SELECT `shop`.id,`shop`.name FROM ".$db->tbl_fix."`shop`
				WHERE  `shop`.`id` > 0 ORDER BY `shop`.id ASC";
		$result = $db->executeQuery ( $sql);
		
		$option = '';
		while($row = mysqli_fetch_assoc($result)){
			$option .= "<option value='".$row['id']."'>".$row['name']."</option>";
		}	
		
		
		
		return $option;
	}

	
	public function opt_by_username( $dUser, $refix = '' ){
		global $db;
		
		$option = '';
		if( isset($dUser['id']) ){

			if( $dUser['gid'] < 2 ){
				$sql = "SELECT `shop`.id, `shop`.`name` FROM ".$db->tbl_fix."`shop`
						WHERE `shop`.`id` > 0
						ORDER BY `shop`.id ASC";
			}else {
				$sql = "SELECT `shop`.id, `shop`.`name`, `shop`.id FROM ".$db->tbl_fix."`shop`
					WHERE `shop`.`id` = '".$dUser['shop_id']."' AND `shop`.`id` > 0
					ORDER BY `shop`.id ASC";
			}

			$result = $db->executeQuery ( $sql);
			
			while($row = mysqli_fetch_assoc($result)){
				
				$option .= "<option shop-id='".$row['id']."' value='".$row['id']."'>$refix".$row['name']."</option>";
				
			}	
		}
		
		return $option;
	}

	public function get_first_shop(){
		global $db;
		
		$sql = "SELECT * FROM ".$db->tbl_fix."`shop` WHERE `id`>0 ORDER BY id ASC";
		$result = $db->executeQuery ( $sql, 1);
		
		return $result;
	}

	// public function list_all(){
	// 	global $db;
		
	// 	$sql = "SELECT `id`,`name` FROM ".$db->tbl_fix."`shop` WHERE `id` > 0 ORDER BY name ASC";
	// 	$result = $db->executeQuery ( $sql );
		
	// 	$option = '';
	// 	while( $row = mysqli_fetch_assoc($result) ){
		
	// 		$option .= "<option value='".$row['id']."'>".$row['name']."</option>";
			
	// 	}
	// 	mysqli_free_result( $result );

		
	// 	return $option;
	// }
	
	public function list_all_shop(){
		global $db;
		
		$sql = "SELECT `id`,`name`,`tax_code`,`address`,`mobile`,`created_at` FROM ".$db->tbl_fix."`shop` WHERE `id`>0 ORDER BY `id` ASC";
		$result = $db->executeQuery_list( $sql);
		
		return $result;
	}

	public function allow_report($shop_id){
		global $db;		
		$dshop = $this->get_detail($shop_id);
		$now = strtotime(date('m/d/Y'));
		if( $now > $dshop['date_report'] ){
		
			$arr['time_report'] = '0';
			$arr['date_report'] = $now;
			$db->record_update( $db->tbl_fix."`shop`",$arr, " `id`='".$shop_id."'" );
		
			unset($dshop);
			return true;
		}else{
			if($dshop['allow_report'] > $dshop['time_report']){
				unset($dshop);
				return true;
			}else{
				if($dshop['allow_report']==0){
					unset($dshop);
					return true;
				}else{
					unset($dshop);
					return false;
				}
			}
		}
	}
	
	public function count_all(){
		global $db;

		$sql = "SELECT COUNT(*) total
				FROM ".$db->tbl_fix."`shop`
				WHERE `id` > 0";
		
		$result = $db->executeQuery ( $sql, 1);
		
		return $result['total'];
	}

	public function count_up_time_report($shop_id){
		global $db;
		
		$dshop = $this->get_detail($shop_id);
		$sql = "UPDATE ".$db->tbl_fix."`shop` SET `time_report`=(`time_report`+1) WHERE `id`='".$shop_id."'";
		$result = $db->executeQuery( $sql );
		
		return true;
	}
	
	public function json_shop( $shop_applied_coupon ){
		$lShop = explode(':', $shop_applied_coupon);
		$jShop = array();
		foreach ($lShop as $key => $item) {
			if($item != ''){
				$dShop = $this->get_detail( $item );
				if( isset($dShop['name']) ){
					$kq['name'] = $dShop['name'];
					$kq['address'] = $dShop['address'];
					$kq['mobile'] = $dShop['mobile'];
					$jShop[] = $kq;
				}
			}
		}
		return json_encode($jShop);
	}

	public function remove_master_id( $master_id ){
		global $db;
		$arr['online_status'] = '0';
		$arr['master_id'] = '';
		$arr['master_name'] = '';
		$arr['master_info'] = '';
		$db->record_update($db->tbl_fix."shop", $arr," `master_id`='".$master_id."'");
		return true;
	}

	public function update_note_in_bill(  $shop_id, $note_in_bill ){
		global $db;
		
		$arr['note_in_bill'] = $note_in_bill;
		
		$db->record_update($db->tbl_fix."shop", $arr," `id`='".$shop_id."'");
		return true;
	}

	public function reset_printer(){
		global $db;

		$arr['printer_id'] = '';
		$arr['printer_name'] = '';
		
		$db->record_update($db->tbl_fix.'shop', $arr , " `id` > 0 ");
		
		return true;
	}

	public function disable_offline( $id ){
		global $db;
		$arr['online_status'] = '0';
		$arr['master_id'] = '';
		$arr['master_name'] = '';
		$arr['master_info'] = '';
		$db->record_update($db->tbl_fix."shop", $arr," `id`='".$id."'");
		return true;
	}

	public function set_master_device( $id, $master_id, $master_name, $master_info ){
		global $db,$database;
		
		$arr['online_status'] = 1;
		$arr['master_id'] = $master_id;
		$arr['master_name'] = $master_name;
		$arr['master_info'] = $master_info;
		$db->record_update( $db->tbl_fix."shop", $arr," `id`='".$id."'");

		return true;
	}
	
	public function list_all_accessed( $shop_accessed ){
		global $db;

		$kq = array();
		
		$lShop = explode( ';', $shop_accessed );

		$sqlWhere = '';
		foreach( $lShop as $item ){
			if( $item != '' ){
				$sqlWhere .= " `id` = '$item' OR";
			}
		}

		if( $sqlWhere != '' ){
			
			$sqlWhere = substr( $sqlWhere, 0, -2 );

			$sql = "SELECT * FROM ".$db->tbl_fix."`shop` WHERE $sqlWhere ORDER BY id ASC";

			$result = $db->executeQuery ( $sql);

			while( $row = mysqli_fetch_assoc($result) ){

				$surcharge_from = explode(":", $row['surcharge_from']);
				$surcharge_to = explode(":", $row['surcharge_to']);

				@$row['surcharge_from_hour'] 	= $surcharge_from['0'];
				@$row['surcharge_from_minute'] 	= $surcharge_from['1'];
				@$row['surcharge_to_hour'] 		= $surcharge_to['0'];
				@$row['surcharge_to_minute'] 	= $surcharge_to['1'];

				unset( $row['surcharge_from'] );
				unset( $row['surcharge_to'] );

				$kq[] = $row;

			}

		}

		return $kq;
	}

	public function opt_all_accessed( $shop_accessed ){
		global $db;
		$kq = '';
		
		$lShop = explode( ';', $shop_accessed );

		$sqlWhere = '';
		foreach( $lShop as $item ){
			if( $item != '' ){
				$sqlWhere .= " `id` = '$item' OR";
			}
		}

		if( $sqlWhere != '' ){

			$sqlWhere = substr( $sqlWhere, 0, -2 );

			$sql = "SELECT `id`, `name` FROM ".$db->tbl_fix."`shop` WHERE $sqlWhere ORDER BY id ASC";
			
			$result = $db->executeQuery ( $sql);

			while( $row = mysqli_fetch_assoc($result) ){
				$kq .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
			}

		}

		return $kq;
	}

	public function list_by_user( $dUserLogin ){
		if( isset($dUserLogin['gid']) && $dUserLogin['gid'] < 1 ){
			return $this->list_all();
		}else{
			return $this->list_all_accessed( isset($dUserLogin['accessed']) ? $dUserLogin['accessed'] : '' );
		}
	}

	public function opt_by_user( $dUserLogin, $all_option = 0 ){
		if( isset($dUserLogin['gid']) && $dUserLogin['gid'] < 1 ){
			if( $all_option == 1 )
				$opt = '<option value="">Tất cả chi nhánh</option>'.$this->opt_all();
			else
				$opt = $this->opt_all();
			
			return $opt;
		}else{
			return $this->opt_all_accessed( isset($dUserLogin['accessed']) ? $dUserLogin['accessed'] : '' );
		}
	}

}

$shop = new shop();
