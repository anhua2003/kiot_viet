<?php
 
class SKU{

	public function add_info( $product_id, $id, $code, $name, $price, $price_promotion, $web_id, $attArr, $img_1, $img_2){
		global $db;

		$arr['product_id'] = $product_id;
		$arr['id'] = $id;
		$arr['code'] = $code;
		$arr['name'] = $name;
		$arr['price'] = $price;
		if( $price_promotion != '' ) $arr['price_promotion'] = $price_promotion;
		$arr['web_id'] = $web_id;


		$arr['attribute_1'] = $attArr['attribute_1'];
		$arr['attribute_2'] = $attArr['attribute_2'];
		$arr['attribute_3'] = $attArr['attribute_3'];
		$arr['attribute_4'] = $attArr['attribute_4'];
		$arr['attribute_5'] = $attArr['attribute_5'];

		if($img_1 != '') $arr['img_1'] = $img_1;
		if($img_2 != '') $arr['img_2'] = $img_2;

		$arr['last_update'] = time();

		$arr['deleted'] = 0;
		$arr['on_stock'] = 0;

		$db->record_insert( $db->tbl_fix."`SKU`" , $arr );
		return $db->mysqli_insert_id();
	}

	public function update_info( $unique_id, $id, $code, $name, $price, $price_promotion, $web_id, $attArr, $img_1, $img_2 ){
		global $db;

		$arr['id'] 				= $id;
		$arr['code'] 			= $code;
		$arr['name'] 			= $name;
		$arr['price'] 			= $price;
		if( $price_promotion != '' ) $arr['price_promotion'] = $price_promotion;
		$arr['web_id'] 			= $web_id;

		$arr['attribute_1'] 	= $attArr['attribute_1'];
		$arr['attribute_2'] 	= $attArr['attribute_2'];
		$arr['attribute_3'] 	= $attArr['attribute_3'];
		$arr['attribute_4'] 	= $attArr['attribute_4'];
		$arr['attribute_5'] 	= $attArr['attribute_5'];

		if($img_1 != '') 		$arr['img_1'] = $img_1;
		if($img_2 != '') 		$arr['img_2'] = $img_2;

		$arr['last_update'] = time();
		
		$db->record_update( $db->tbl_fix."`SKU`" , $arr, " `unique_id` = '$unique_id' ");
		
		return $unique_id;
	}
	
	public function update_web_id( $unique_id, $web_id ){
		global $db;

		$arr['web_id'] 			= $web_id;
				
		$db->record_update( $db->tbl_fix."`SKU`" , $arr, " `unique_id` = '$unique_id' ");
		
		return $unique_id;
	}

	public function update_code( $id, $product_id, $code ){
		global $db;

		$arr['code'] 			= $code;
		$db->record_update( $db->tbl_fix."`SKU`" , $arr, " `product_id` = '$product_id' AND `id` = '$id' ");
		
		return true;
	}

	public function add_SKU_web( $product_id, $web_id, $code, $name, $img ){
		global $db,$database;

		$arr['id'] = $this->get_id_insert( $product_id );
		$arr['web_id'] = $web_id;
		$arr['code'] = $code;
		$arr['product_id'] = $product_id;

		$arr['price'] 				= $price;
		$arr['price_promotion'] 	= $price_promotion;

		$arr['attribute_1'] = '';
		$arr['attribute_2'] = '';
		$arr['attribute_3'] = '';
		$arr['attribute_4'] = '';
		$arr['attribute_5'] = '';

		$arr['name'] = $name;

		if( $img_1 != '' ) $arr['img_1'] = $img;
		$arr['img_2'] = '';

		$arr['last_update'] = time();

		$dSKU = $this->get_detail_by_web_id( $arr['code'], $web_id, $product_id );

		if( isset( $dSKU['id'] ) ){
			$arr['id'] =  $dSKU['id'];
			$db->record_update( $db->tbl_fix."`SKU`" , $arr, " `unique_id` = '".$dSKU['unique_id']."' " );
			$unique_id = $dSKU['unique_id'];
		}else{
			$db->record_insert( $db->tbl_fix."`SKU`" , $arr );
			$unique_id = $db->mysqli_insert_id();
		}
		
		return $unique_id;
	}

	public function add_clone( $product_id, $attArr ){
		global $db;

		$attArr['id'] = $attArr['id'];
		$attArr['code'] = $attArr['code'];
		$attArr['on_stock'] = 0;
		
		$attArr['product_id'] = $product_id;
		$attArr['last_update'] = time();

		$db->record_insert( $db->tbl_fix."`SKU`" , $attArr);

		return $db->mysqli_insert_id();
	}
	
	public function update_new_clone_attribute( $new_product_id, $old_att, $position, $new_id ){
		global $db;
		
		$attArr["attribute_$position"] = $new_id;
		$db->record_update( $db->tbl_fix."`SKU`" , $attArr, " `product_id` = '$new_product_id' AND `attribute_$position` = '$old_att' ");
		
		return true;
	}
	
	public function add_default( $product_id, $on_stock, $pos_product_id, $store_name, $img_1, $img_2){
		
		global $db,$database;
		
		
		$arr['id'] = 0;
		$arr['code'] = sprintf("%05d", $product_id).' - 00';
		
		$arr['product_id'] = $product_id;
		$arr['on_stock'] = $on_stock;

		$arr['attribute_1'] = 0;
		$arr['attribute_2'] = 0;
		$arr['attribute_3'] = 0;
		$arr['attribute_4'] = 0;
		$arr['attribute_5'] = 0;
		
		$arr['name'] = '';

		$arr['img_1'] = $img_1;
		$arr['img_2'] = $img_2;

		$arr['pos_sku_id'] = '0';
		$arr['store_name'] = $store_name;
		$arr['pos_product_id'] = $pos_product_id;

		$arr['last_update'] = time();
		
		$db->record_insert( $db->tbl_fix."`SKU`" , $arr );
		
		
		return 0;

	}

	public function update($id, $product_id, $code, $attArr, $img_1, $img_2){

		global $db,$database;
		
		
		$arr['code'] = $code;

		$arr['attribute_1'] = $attArr['attribute_1'];
		$arr['attribute_2'] = $attArr['attribute_2'];
		$arr['attribute_3'] = $attArr['attribute_3'];
		$arr['attribute_4'] = $attArr['attribute_4'];
		$arr['attribute_5'] = $attArr['attribute_5'];

		$arr['name'] = $attArr['name'];

		if($img_1 != '') $arr['img_1'] = $img_1;
		if($img_2 != '') $arr['img_2'] = $img_2;

		$arr['last_update'] = time();
		
		$db->record_update( $db->tbl_fix."`SKU`" , $arr ," `id` ='".$id."' AND `product_id` ='".$product_id."'");
		
		
		return true;
		
	}

	public function delete_img($position, $sku_id, $product_id){

		global $db,$database;
		
		
		$arr['img_'.$position] = '';
		
		$db->record_update( $db->tbl_fix."`SKU`" , $arr ," `id` ='".$sku_id."' AND `product_id` ='".$product_id."'");
		
		
		return true;
		
	}

	public function create_default_sku( $product_id, $code ){
		global $db;

		$dThis = $this->get_detail( 0, $product_id );
		if( !isset( $dThis['product_id'] ) ){

			$arr['id'] = 0;
			
			if( $code == '' )
				$arr['code'] = sprintf('%05d' , $product_id).' - 00';
			else
				$arr['code'] = $code;
			
			$arr['product_id'] = $product_id;
			$arr['last_update'] = time();
			$arr['on_stock'] = 0;
			
			$db->record_insert( $db->tbl_fix."`SKU`" , $arr );
		}

		return 0;
	}

	public function create_default_sku_web( $web_id, $product_id, $code ){
		global $db;

		$dThis = $this->get_detail_by_web_id( $code, $web_id, $product_id );
		if( !isset( $dThis['product_id'] ) ){

			$arr['id'] = 0;
			
			if( $code == '' )
				$arr['code'] = sprintf('%05d' , $product_id).' - 00';
			else
				$arr['code'] = $code;
			
			$arr['web_id'] = $web_id;
			$arr['product_id'] = $product_id;
			$arr['last_update'] = time();
			$arr['on_stock'] = 0;
			
			$db->record_insert( $db->tbl_fix."`SKU`" , $arr );

			return $db->mysqli_insert_id();
		}else{
			return $dThis['unique_id'];
		}
	}

	public function update_default_sku( $product_id , $code){

		global $db,$database;
		
		
		$arr['code'] = $code;
		$arr['last_update'] = time();
		
		$db->record_update( $db->tbl_fix."`SKU`" , $arr, " `id` = '0' AND `product_id` = '".$product_id."' " );
		
		
		return true;

	}

	public function update_default_sku_web( $web_id, $product_id , $code){

		global $db,$database;
		
		
		$arr['code'] = $code;
		$arr['web_id'] = $web_id;
		$arr['last_update'] = time();
		
		$db->record_update( $db->tbl_fix."`SKU`" , $arr, " `id` = '0' AND `product_id` = '".$product_id."' " );
		
		
		return true;

	}

	public function get_default_sku( $product_id ){
		global $db;

		$sql = "SELECT *
				FROM `SKU` WHERE `product_id` = '".$product_id."' AND id='0' AND `deleted` = 0 ";
		$result = $db->executeQuery ( $sql, 1 );
		
		return $result;
	}

	public function get_default_sku_code( $product_id ){
		global $db;

		$sql = "SELECT `code`
				FROM `SKU` WHERE `product_id` = '$product_id' AND id='0' AND `deleted` = 0 ";
		$result = $db->executeQuery ( $sql, 1 );
		
		if( isset($result['code']) )
			return $result['code'];
		else
			return '';
		
	}

	public function get_sku_code( $product_id, $sku_id ){
		global $db;

		$sql = "SELECT `code`
				FROM `SKU`
				WHERE
				`product_id` = '$product_id' 
				AND `deleted` = '0'
				AND `id` = '$sku_id'
				LIMIT 1";

		$result = $db->executeQuery ( $sql, 1 );

		if( isset($result['code']) )
			return $result['code'];
		else
			return '';
		
	}

	public function delete($id, $product_id){

		global $db,$database;
		
		
		$arr['deleted'] = 1;

		$arr['last_update'] = time();
		
		$db->record_update( $db->tbl_fix."`SKU`" , $arr ," `id` ='".$id."' AND `product_id` ='".$product_id."'");
		
		
		return true;
		
	}

	public function delete_by_product_id( $product_id){
		
		global $db;
		
		$arr['deleted'] = 1;
		$arr['last_update'] = time();
		$db->record_update( $db->tbl_fix."`SKU`" , $arr ," `product_id` = '".$product_id."' ");
		
		return true;
	}

	public function delete_others_sku_web( $lUniqueID, $product_id){
		
		global $db;
		if( COUNT($lUniqueID) > 1 ){
			$sqlQuery = '';
			
			foreach( $lUniqueID as $it ){
				$sqlQuery .= " AND `unique_id` <> '$it' ";
			}
			
			$db->record_delete( $db->tbl_fix."`SKU`" , " `product_id` = '$product_id' $sqlQuery ");
		}
		return true;
	}

	public function delete_others_default( $product_id){

		global $db,$database;
		
		
		$arr['deleted'] = 1;

		$arr['last_update'] = time();
		
		$db->record_update( $db->tbl_fix."`SKU`" , $arr ," `id` <>'0' AND `product_id` ='".$product_id."'");
		
		
		return true;
		
	}

	public function delete_default( $product_id){

		global $db,$database;
		
		
		$db->record_delete( $db->tbl_fix."`SKU`"  ," `id` = '0' AND `product_id` ='".$product_id."'");
		
		
		return true;
		
	}

	public function get_detail_by_web_id( $code, $web_id, $product_id ){
		global $db;

		$sql = "SELECT * FROM ".$db->tbl_fix."`SKU` WHERE `code` = '$code' AND `web_id` = '".$web_id."' AND `product_id` = '".$product_id."' AND `deleted` = 0 LIMIT 0,1";
		$row = $db->executeQuery ( $sql, 1 );

		return $row;
	}

	public function get_by_web_id( $web_id, $product_id ){
		global $db;

		$sql = "SELECT * FROM ".$db->tbl_fix."`SKU` WHERE `web_id` = '".$web_id."' AND `product_id` = '".$product_id."' AND `deleted` = 0 LIMIT 0,1";
		$row = $db->executeQuery ( $sql, 1 );

		return $row;
	}

	public function get_detail( $id, $product_id ){
		global $db;

		$sql = "SELECT * FROM ".$db->tbl_fix."`SKU` WHERE `id` = '$id' AND `product_id` = '$product_id' AND `deleted` = 0 LIMIT 1";
		$row = $db->executeQuery ( $sql, 1 );

		return $row;
	}

	public function get_detail_code( $id, $product_id ){
		global $db;

		$sql = "SELECT `code` FROM ".$db->tbl_fix."`SKU` WHERE `id` = '$id' AND `product_id` = '$product_id' AND `deleted` = 0 LIMIT 1";
		$row = $db->executeQuery ( $sql, 1 );

		return $row['code'];
	}

	public function get_by_unique_id( $unique_id ){
		global $db;
		
		$sql = "SELECT * FROM ".$db->tbl_fix."`SKU` WHERE `unique_id` = '".$unique_id."' LIMIT 1";
		
		$row = $db->executeQuery ( $sql, 1 );
		
		return $row;
	}
	
	public function get_by_code( $shop_id, $code ){
		global $db;
		
		$sql = "SELECT `SKU`.*,`product`.ratio_convert
				FROM ".$db->tbl_fix."`SKU`
				INNER JOIN `product` ON `SKU`.`product_id` = `product`.`id`
				WHERE `SKU`.`code` = '$code' AND `SKU`.`deleted` = 0 AND `product`.`deleted` = 0 AND `product`.shop_id = '$shop_id'
				LIMIT 1";
		$result = $db->executeQuery ( $sql, 1);

		return $result;
	}

	public function get_product_id_by_code( $shop_id, $code ){
		global $db;

		$sql = "SELECT `product`.`name`, `product`.price, `product`.on_sales, `product`.sales, `product`.wholesale_price, SKU.`on_stock`, SKU.`id`, SKU.`product_id`,
						SKU.`attribute_1`, SKU.`attribute_2`, SKU.`attribute_3`, SKU.`attribute_4`, SKU.`attribute_5`
						, SKU.`name` sku_name
				FROM ".$db->tbl_fix."`SKU`
				INNER JOIN `product` ON `SKU`.`product_id` = `product`.`id`
				WHERE `SKU`.`code` = '$code' AND `SKU`.`deleted` = 0 AND `product`.`deleted` = 0 AND `product`.shop_id = '$shop_id'
				LIMIT 1";
		
		$result = $db->executeQuery ( $sql, 1);
		return $result;
	}
	
	public function listby_proID( $product_id ){
		global $db;
		
		$sql = "SELECT * FROM ".$db->tbl_fix."`SKU` WHERE `product_id` = '".$product_id."' AND `deleted` = 0 ORDER BY `id`,`code` ";
		$result = $db->executeQuery ( $sql );
		
		$kq = array();
		while( $row = mysqli_fetch_assoc($result) ){
			$kq[] = $row;
		}
		
		return $kq;
	}

	public function list_by_product_id_to_web( $product_id ){
		global $db;
		
		$sql = "SELECT `unique_id` as `id`, `web_id` `id_on_web`, `name`, `code`, `on_stock` as quantity, price, price_promotion
				FROM ".$db->tbl_fix."`SKU` WHERE `product_id` = '".$product_id."' AND `deleted` = 0 ORDER BY `code` ";
		$result = $db->executeQuery ( $sql );
		
		$kq = array();
		while( $row = mysqli_fetch_assoc($result) ){
			$kq[] = $row;
		}
		
		return $kq;
	}

	public function list_by_product_id( $product_id ){
		global $db;
		
		$sql = "SELECT *
				FROM `SKU`
				WHERE `product_id` = '$product_id' AND `deleted` = 0 ORDER BY `id` ";
		$result = $db->executeQuery_list( $sql );
		
		return $result;
	}
	
	public function clone_SKU_to_other( $product_id, $new_product_id ){
		global $db;
		
		$sql = "SELECT * FROM ".$db->tbl_fix."`SKU` WHERE `product_id` = '".$product_id."' AND `deleted` = 0 ORDER BY `code` ";
		$result = $db->executeQuery ( $sql );
		$no_row = mysqli_num_rows( $result );

		if( $no_row > 0 ){
			while( $row = mysqli_fetch_assoc( $result ) ){
				$row['product_id'] = $new_product_id;
				unset($row['unique_id']);
				$this->add_clone( $new_product_id, $row );
			}
		}else{
			$this->create_default_sku( $new_product_id, '');
		}

		return true;
	}

	public function listby_proID_toPrint( $lSKUs ){
		global $db;
		$querySKU = '';
		$lSKUs = explode(':', $lSKUs );
		foreach ( $lSKUs as $key => $value ) {
			$item = explode(',', $value);
			if( !empty( $item[0] ) ){
				$querySKU .= " SKU.`unique_id` = '".$item[0]."' OR ";
			}
		}

		$kq = array();
		if( $querySKU != '' ){
			$querySKU = substr( $querySKU, 0, -3 );
			$sql = "SELECT `SKU`.*, `pro`.`name` as product_name, `pro`.`price` as product_price 
					FROM ".$db->tbl_fix."`SKU`
					INNER JOIN `product` as pro
					ON `pro`.`id` = `SKU`.`product_id`
					WHERE pro.`deleted` = 0 AND ( ".$querySKU." )
					ORDER BY SKU.`code` ";
			$result = $db->executeQuery ( $sql );
			while( $row = mysqli_fetch_assoc($result) ){
				$kq[$row['unique_id']] = $row;
			}

		}

		return $kq;
	}

	public function listby_attribute($att_id){
		global $db,$database;
		

		$sql = "SELECT * FROM ".$db->tbl_fix."`SKU` WHERE `attribute_id`='".$att_id."' LIMIT 0,1";
		
		$result = $db->executeQuery ( $sql );
		
		$kq = array();
		while($row = mysqli_fetch_assoc($result)){
			$kq[] = $row;
		}
		
		
		return $kq;
	}

	// public function getSKUByAtt( $product_id, $att_1, $att_2, $att_3, $att_4, $att_5 ){
	// 	global $db;
		
	// 	$sql = "SELECT * FROM ".$db->tbl_fix."`SKU` WHERE `product_id`='".$product_id."' AND `attribute_1`='".$att_1."' AND `attribute_2`='".$att_2."' AND `attribute_3`='".$att_3."' AND `attribute_4`='".$att_4."' AND `attribute_5`='".$att_5."' AND `deleted` = 0  LIMIT 0,1";
	// 	$result = $db->executeQuery ( $sql , 1);
	// 	return $result;
	// }

	public function get_id_insert( $product_id ){
		global $db,$database;
		

		$sql = "SELECT id FROM ".$db->tbl_fix."`SKU` WHERE `product_id`='".$product_id."' ORDER BY id DESC LIMIT 0,1";
		
		$result = $db->executeQuery ( $sql , 1 );
		
		
		if( isset($result['id']) ){
			return ($result['id'] + 1);
		}else{
			return 1;
		}
	}

	public function get_stock_byorderID($shop_id, $order_id, $order_created_at){
		global $db;

		$sql = "SELECT pro.sum_stock, SKU.on_stock, dt.product_id, dt.sku_id
				FROM `detail_order_".$shop_id."_".date('Y', $order_created_at)."` AS dt
				INNER JOIN `product` AS pro ON pro.id = `dt`.product_id
				INNER JOIN `SKU` ON `SKU`.id = dt.sku_id
				AND `SKU`.product_id = `dt`.product_id
				WHERE `dt`.order_id ='$order_id' AND SKU.deleted = 0
				GROUP BY SKU.code";
		
		$kq = array();
		$result = $db->executeQuery ( $sql );
		while ($row = mysqli_fetch_assoc($result)) {
			$kq[] = $row;
		}

		return $kq;
	}

	//cập nhật/ thêm/ xóa SKU
	public function update_list( $shop_id, $product_id, $lSKUs ){
		global $db, $main;
		
		$lIDs = array();
		foreach( $lSKUs as $item ){
			if( isset($item['id']) ){

				$attArr['attribute_1'] = '0';
				$attArr['attribute_2'] = '0';
				$attArr['attribute_3'] = '0';
				$attArr['attribute_4'] = '0';
				$attArr['attribute_5'] = '0';
				
				if( $item['web_id'] != '' && $item['web_id'] != '0' ){
					//get detail by web_id
					$dSKU = $this->get_by_web_id( $item['web_id'], $product_id );
					if( isset($dSKU['id']) ){
						$lIDs[] = $this->update_info( $dSKU['unique_id'], $item['id'], $item['code'], $item['name'], $main->number($item['price']), $main->number($item['price_promotion']), $item['web_id'], $attArr, $item['img_1'], '' );
					}else{
						$lIDs[] = $this->add_info( $product_id, $item['id'], $item['code'], $item['name'], $main->number($item['price']), $main->number($item['price_promotion']), $item['web_id'], $attArr, $item['img_1'], '' );
					}
				}else{
					if( $item['code'] != '' ){
						//get detail SKU by code
						$dSKU = $this->get_by_code( $shop_id, $item['code'] );
						if( isset($dSKU['unique_id']) && $dSKU['product_id'] == $product_id ){
							$lIDs[] = $this->update_info( $dSKU['unique_id'], $item['id'], $item['code'], $item['name'], $main->number($item['price']), $main->number($item['price_promotion']), $item['web_id'], $attArr, $item['img_1'], '' );
						}else{
							$lIDs[] = $this->add_info( $product_id, $item['id'], $item['code'], $item['name'], $main->number($item['price']), $main->number($item['price_promotion']), $item['web_id'], $attArr, $item['img_1'], '' );
						}
					}else{
						//get detail SKU by ID
						$dSKU = $this->get_detail( $item['id'], $product_id );
						if( isset($dSKU['unique_id']) ){
							$lIDs[] = $this->update_info( $dSKU['unique_id'], $item['id'], $item['code'], $item['name'], $main->number($item['price']), $main->number($item['price_promotion']), $item['web_id'], $attArr, $item['img_1'], '' );
						}else{
							$lIDs[] = $this->add_info( $product_id, $item['id'], $item['code'], $item['name'], $main->number($item['price']), $main->number($item['price_promotion']), $item['web_id'], $attArr, $item['img_1'], '' );
						}
					}
				}
			}
		}
		//

		$sqlWhere = '';
		foreach ( $lIDs as $key => $proID ) {
			$sqlWhere .= " `unique_id` <> '$proID' AND ";
		}

		$db->record_delete( $db->tbl_fix."`SKU`"  ," $sqlWhere `product_id` = '".$product_id."' ");

		return true;
	}
	
	//cập nhật cộng số lượng
	public function update_stock_plus($product_id, $sku_id, $val_plus){
		global $db,$database;
		

		$sql = "UPDATE `SKU` SET `on_stock` = `on_stock` + ".$val_plus." WHERE `product_id` = '".$product_id."' AND `id` = '".$sku_id."' ";
		$result = $db->executeQuery ( $sql );
		
		$sql = "UPDATE `product` SET `sum_stock` = `sum_stock` + ".$val_plus." WHERE `id` = '".$product_id."' ";
		$result = $db->executeQuery ( $sql );

		
		
		return true;
	}

	//cập nhật trừ số lượng
	public function update_stock_subtract($product_id, $sku_id, $val_subtract){
		global $db,$database;
		
		$val_subtract +=0;
		$sql = "UPDATE `SKU` SET `on_stock` = `on_stock` - '".$val_subtract."' WHERE `product_id` = '".$product_id."' AND `id` = '".$sku_id."' ";
		$result = $db->executeQuery ( $sql );
		
		$sql = "UPDATE `product` SET `sum_stock` = `sum_stock` - '".$val_subtract."' WHERE `id` = '".$product_id."' ";
		$result = $db->executeQuery ( $sql );
		
		
		return true;
	}

	public function get_att_name_SKU($dSKU){
		
		$attribute = '';
		
		if($dSKU['name'] != '') $attribute = '('.$dSKU['name'].')';

		return $attribute; 
	}

	public function getFullNameSKU($product_id, $sku_id){
		global $db;
		
		$sql = "SELECT pro.name,SKU.attribute_1,SKU.attribute_2,SKU.attribute_3,SKU.attribute_4,SKU.attribute_5
				,SKU.name as sku_name
				FROM SKU 
				INNER JOIN product as pro ON pro.id = SKU.product_id
				WHERE SKU.`product_id`='".$product_id."' AND SKU.`id`='".$sku_id."' AND SKU.deleted = 0 LIMIT 0,1";
		$dSKU = $db->executeQuery ( $sql, 1);
		
		$attribute = ' ';
		
		if( $dSKU['sku_name'] != '') $attribute .= '('.$dSKU['sku_name'].')';
		
		return $dSKU['name'].$attribute;
	}

	public function getFullNameSKUUniqueID( $product_id, $sku_id, &$code ){
		global $db;
		
		$sql = "SELECT pro.name,SKU.attribute_1,SKU.attribute_2,SKU.attribute_3,SKU.attribute_4,SKU.attribute_5
				,SKU.name as sku_name, SKU.`code`
				FROM SKU
				INNER JOIN product as pro ON pro.id = SKU.product_id
				WHERE SKU.`product_id` = '$product_id' AND SKU.`unique_id`='$sku_id' AND SKU.deleted = 0 LIMIT 0,1";
		$dSKU = $db->executeQuery ( $sql, 1);
		
		$attribute = ' ';
		
		if( $dSKU['sku_name'] != '') $attribute .= '('.$dSKU['sku_name'].')';

		$code = $dSKU['code'];
		
		return $dSKU['name'].$attribute;
	}

	public function exist_code( $shop_id, $code, $sku_id ){
		global $db;

		$sql = "SELECT pro.name, SKU.attribute_1,SKU.attribute_2,SKU.attribute_3,SKU.attribute_4,SKU.attribute_5
				,SKU.name sku_name
				FROM `product` pro
				INNER JOIN `SKU` ON SKU.product_id = pro.id
				WHERE pro.shop_id = '$shop_id' AND SKU.code = '$code' AND SKU.id <> '$sku_id' AND SKU.deleted = 0 ";

		$dSKU = $db->executeQuery ( $sql, 1);

		$attribute = '';
		if( isset($dSKU['sku_name']) && $dSKU['sku_name'] != '' ){
			$attribute = '('.$dSKU['sku_name'].')';
			$dSKU['name'] = $dSKU['name'].' '.$attribute;
		}

		return $dSKU;
	}

	public function is_exist_code( $shop_id, $product_id, $code ){
		global $db;

		if( $product_id != ''  ) $product_id = " AND SKU.`product_id` <> '$product_id' ";
		
		$sql = "SELECT `unique_id`
				FROM $db->tbl_fix`SKU` 
				INNER JOIN $db->tbl_fix`product` pro ON `SKU`.product_id = pro.`id`
				WHERE pro.`shop_id` = '$shop_id' AND `SKU`.`code` = '$code' AND SKU.`deleted` = 0 $product_id LIMIT 1";

		$dSKU = $db->executeQuery ( $sql, 1);

		if( isset($dSKU['unique_id']) )
			return true;
		else
			return false;
	}

	public function is_list_exist_code( $shop_id, $product_id, $lSKUs ){
		global $db;

		$lSKUs = json_decode( $lSKUs, true );
		if( $product_id != ''  ) $product_id = " AND SKU.`product_id` <> '$product_id' ";

		$is_exist = false;
		if( is_array($lSKUs) ){
			foreach($lSKUs as $ite ){
				$code = $ite['code'];
				$sql = "SELECT `unique_id`
						FROM $db->tbl_fix`SKU` 
						INNER JOIN $db->tbl_fix`product` pro ON `SKU`.product_id = pro.`id`
						WHERE pro.`shop_id` = '$shop_id' AND `SKU`.`code` = '$code' AND SKU.`deleted` = 0 $product_id LIMIT 1";

				$dSKU = $db->executeQuery ( $sql, 1);

				if( isset($dSKU['unique_id']) )
					$is_exist = true;
				
				if( $is_exist ) break;
			}
		}
		
		return $is_exist;
	}

}
$SKU = new SKU();
