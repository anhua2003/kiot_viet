<?php

/**
 *
- Record decrement: product_id = 0, sku_id =0,  quantity = -1 (Giảm giá %)
- Record surcharge: product_id = 0, sku_id =0,  quantity = 1 (Phụ thu)
 **/
class detail_order extends model
{

	protected $class_name = 'detail_order';
	protected $id;
	protected $order_id;
	protected $product_id;
	protected $sku_id;
	protected $quantity;
	protected $quantity_paid; //số lượng sản phẩm còn nợ
	protected $returned;
	protected $max_allowed_order;
	protected $date_add;
	protected $name;
	protected $note;
	protected $price;
	// Giá mặc định: nghĩa là giá lẻ mặc định sẽ bán cho khách hàng này; 
	// nếu không cài product_price_detail theo đối tượng thì giá mặc định = product.price; 
	//còn nếu có default_price bằng product_price_detail.value
	protected $default_price;
	protected $root_price; //Giá vốn cài đặt hoặc có thể tính theo giá nhập
	protected $sale_price; //Giá mà đại lý chỉnh để bán cho khách của tự họ: chỉnh giá đơn hàng
	protected $sale_decrement; //Giảm của giá mà đại lý giảm cho khách họ muốn bán => tự bán; công ty giao hộ
	protected $wh_history_id;
	protected $decrement;
	protected $vat;
	protected $user_decrement;
	protected $last_update;
	protected $user_add;
	protected $attribute_1;
	protected $attribute_2;
	protected $attribute_3;
	protected $attribute_4;
	protected $attribute_5;
	protected $sku_name;
	protected $same_groups;
	protected $wh_history_return_id;
	protected $is_coupon;
	protected $coupon_id;
	protected $is_cancel; // trả hàng
	protected $cancel_report_id;
	protected $delivered;
	protected $inverse; //đơn vị hập xuất
	protected $expire_date;
	protected $ratio_convert;
	protected $barcode;
	protected $cashback_value; //Giá trị cashback: % hay giá trị nhập
	protected $cashback_is_value; //Loại cashback: theo giá trị hay theo % = 1 theo giá trị; = 0 theo %

	public function checkTable_exist($shop_id, $created_at)
	{
		global $db;
		$table_name = substr($db->tbl_fix, 0, -1);
		$sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '$table_name'  AND table_name = 'detail_order_" . $shop_id . "_" . date('Y', $created_at) . "'";
		$result = $db->executeQuery_list($sql);
		if (count($result) == 0) {
			return 0;
		}
		return 1;
	}

	public function add($shop_id, $order_created_at)
	{
		global $db, $main;
		$order_id = $this->get('order_id');
		$product_id = $this->get('product_id');
		$c = $this->checkTable_exist($shop_id, $order_created_at);
		if ($c == 0) {
			$sql = "CREATE TABLE detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . " AS SELECT * FROM $db->tbl_fix`detail_order_1_2021` WHERE 1 = 0";
			$db->executeQuery($sql);
		}
		$sql1 = "SELECT od.*
			FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` `od`
			WHERE od.`order_id` = '$order_id' and od.`product_id` = '$product_id' LIMIT 0,1 ";
		$arr = $db->executeQuery($sql1, 1);

		if ($arr == []) {
			$arr['id'] 						= rand(0, 9999);
			$arr['order_id'] 				= $this->get('order_id');
			$arr['product_id'] 				= $product_id;
			$arr['sku_id'] 					= $this->get('sku_id');

			$arr['quantity'] 				= $this->get('quantity');
			$arr['quantity_paid'] 			= 0; //$this->get('quantity');
			$arr['returned'] 				= 0;
			$arr['max_allowed_order'] 		= $this->get('max_allowed_order') + 0;
			$arr['date_add'] 				= time();
			$arr['name'] 					= $this->get('name');
			$arr['note'] 					= $this->get('note');
			$arr['price'] 					= $this->get('price');
			$arr['default_price'] 			= $this->get('default_price') + 0;
			$arr['root_price'] 				= $this->get('root_price');
			$arr['wh_history_id'] 			= $this->get('wh_history_id');

			if ($this->get('decrement') != 0)
				$arr['decrement'] 			= $this->get('decrement');
			else
				$arr['decrement'] 			= 0;

			$arr['vat'] 					= 0;
			$arr['user_decrement'] 			= '';
			$arr['last_update'] 			= time();
			$arr['user_add'] 				= $this->get('user_add');

			if ($this->get('sale_price') >= 0)
				$arr['sale_price'] 				= $this->get('sale_price') + 0; //nếu có set thì chỉnh lại giá là giá được set
			else
				$arr['sale_price'] 				= 0; ///không có set cho bằng 0

			if ($this->get('sale_decrement') >= 0)
				$arr['sale_decrement'] 				= $this->get('sale_decrement') + 0; //nếu có set thì chỉnh lại giảm giá là giá được set
			else
				$arr['sale_decrement'] 				= 0; //không có set cho bằng 0

			$arr['attribute_1'] 			= $this->get('attribute_1');
			$arr['attribute_2'] 			= $this->get('attribute_2');
			$arr['attribute_3'] 			= $this->get('attribute_3');
			$arr['attribute_4'] 			= $this->get('attribute_4');
			$arr['attribute_5'] 			= $this->get('attribute_5');

			$arr['sku_name'] 				= $this->get('sku_name');
			$arr['same_groups'] 			= $this->get('same_groups') + 0;
			$arr['wh_history_return_id'] 	= $this->get('wh_history_return_id') + 0;

			$arr['is_coupon'] 				= $this->get('is_coupon') + 0;
			$arr['coupon_id'] 				= $this->get('coupon_id') + 0;
			$arr['is_cancel'] 				= $this->get('is_cancel') + 0;
			$arr['cancel_report_id'] 		= $this->get('cancel_report_id') + 0;
			$arr['delivered'] 				= $this->get('delivered') + 0;
			$arr['inverse'] 				= $this->get('inverse') + 0;
			$arr['expire_date'] 			= $this->get('expire_date') + 0;
			$arr['ratio_convert'] 			= $this->get('ratio_convert') + 0;

			$arr['barcode'] 				= $this->get('barcode') . '';

			$arr['cashback_value'] 			= $this->get('cashback_value') + 0;
			$arr['cashback_is_value'] 		= $this->get('cashback_is_value') + 0;

			$db->record_insert($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr);
		}
		// echo $arr['product_id'];
		// exit();
		return $arr;
	}

	public function clonex($new_order_id)
	{
		global $db, $main;

		$shop_id 		= $this->get('shop_id');
		$order_id 		= $this->get('order_id');
		$created_at 	= $this->get('created_at');
		$user_add 		= $this->get('user_add');

		$lItems = $this->listby_order($shop_id, $order_id, $created_at);
		foreach ($lItems as $key => $arr) {

			$arr['id'] 						= $this->get_id($shop_id, $user_add);
			$arr['returned'] 				= 0;
			$arr['order_id'] 				= $new_order_id;
			$arr['max_allowed_order'] 		= 0;
			$arr['date_add'] 				= time();
			$arr['last_update'] 			= time();
			$arr['user_add'] 				= $user_add;
			$arr['wh_history_return_id'] 	= 0;
			$arr['is_cancel'] 				= 0;
			$arr['cancel_report_id'] 		= 0;
			$arr['delivered'] 				= 0;

			unset($arr['sku_code']);
			unset($arr['unit_import']);
			unset($arr['unit_export']);

			$db->record_insert($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y') . "`", $arr);
		}
		unset($lItems);

		return true;
	}

	//  An(08/02/2023) - Không sài nữa
	// public function add_coupon($shop_id, $coupon_code, $order_created_at)
	// {
	// 	global $db, $order, $main;

	// 	$order_id 			= $this->get('order_id');
	// 	$arr['id'] 			= $id = $this->get_id($shop_id, $this->get('user_add'));
	// 	$arr['order_id'] 	= $order_id;
	// 	$arr['product_id'] 	= 0;
	// 	$arr['sku_id'] 		= 0;
	// 	$arr['quantity'] 	= -1;
	// 	$arr['returned'] 	= 0;
	// 	$arr['name'] 		= $this->get('name');
	// 	$arr['price'] 		= $this->get('price');
	// 	$arr['root_price'] 	= 0;
	// 	$arr['user_add'] 	= $this->get('user_add');
	// 	$arr['is_coupon'] 	= 1;
	// 	$arr['coupon_id'] 	= $this->get('coupon_id');

	// 	$arr['decrement'] 				= 0;
	// 	$arr['user_decrement'] 			= '';
	// 	$arr['vat'] 					= 0;
	// 	$arr['same_groups'] 			= 0;

	// 	$arr['is_cancel'] 				= 0;
	// 	$arr['cancel_report_id'] 		= 0;

	// 	$arr['sale_price'] 				= 0;
	// 	$arr['sale_decrement'] 			= 0;

	// 	$arr['date_add'] 	= time();
	// 	$arr['last_update'] = time();

	// 	//coupon ko phải hàng hóa nên cứ là 1 là đơn vị xuất và có thời hạn sử dụng cũng ko có
	// 	$arr['inverse'] 				= 1;
	// 	$arr['ratio_convert'] 			= 1;
	// 	$arr['expire_date'] 			= 0;
	// 	$arr['barcode'] 				= $this->get('barcode') . '';

	// 	$db->record_insert($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr);

	// 	$dOrder = $order->get_detail($shop_id, $order_id, $order_created_at);

	// 	if (isset($dOrder['id']) && $dOrder['id_customer'] > 0) {
	// 		$sum = $this->get_sum_order($shop_id, $order_id, $order_created_at);
	// 		$coupon_history->set('member_id', $dOrder['id_customer']);
	// 		$coupon_history->set('fullname', $dOrder['name_customer']);
	// 		$coupon_history->set('mobile', $dOrder['mobile_customer']);
	// 		$coupon_history->set('order_id', $order_id);
	// 		$coupon_history->set('shop_id', $dOrder['shop_id']);
	// 		$coupon_history->set('date_in', $dOrder['date_in']);
	// 		$coupon_history->set('order_total', $sum);
	// 		$coupon_history->set('coupon_id', $this->get('coupon_id'));
	// 		$coupon_history->set('coupon_code', $coupon_code);
	// 		$coupon_history->set('detail_order_id', $id);
	// 		$coupon_history->add();
	// 	}

	// 	return $id;
	// }

	//Tạo một dong giam giá
	public function record_decrement($shop_id, $order_created_at)
	{
		global $db, $main;

		$arr['id'] 						= $id = $this->get_id($shop_id, $this->get('user_add'));
		$arr['order_id'] 				= $this->get('order_id');
		$arr['product_id'] 				= 0;
		$arr['sku_id'] 					= 0;
		$arr['quantity'] 				= -1;
		$arr['returned'] 				= 0;

		$arr['name'] 					= $this->get('name');
		$arr['price'] 					= $this->get('price');
		$arr['root_price'] 				= 0;
		$arr['user_add'] 				= $this->get('user_add');

		$arr['note'] 					= $this->get('note');

		$arr['attribute_1'] 			= '0';
		$arr['attribute_2'] 			= '0';
		$arr['attribute_3'] 			= '0';
		$arr['attribute_4'] 			= '0';
		$arr['attribute_5'] 			= '0';

		$arr['sku_name'] 				= '';
		$arr['root_price'] 				= 0;
		$arr['wh_history_id'] 			= '0';
		$arr['wh_history_return_id'] 	= '0';

		$arr['decrement'] 				= 0;
		$arr['user_decrement'] 			= '';
		$arr['vat'] 					= 0;
		$arr['same_groups'] 			= 0;

		$arr['is_coupon'] 				= 0;
		$arr['coupon_id'] 				= 0;
		$arr['is_cancel'] 				= 0;
		$arr['cancel_report_id'] 		= 0;
		$arr['inverse'] 				= 1;
		$arr['expire_date'] 			= 0;
		$arr['ratio_convert'] 			= 1;
		$arr['barcode'] 				= '';

		$arr['cashback_value'] 			= 0;
		$arr['cashback_is_value'] 		= 0;

		$arr['sale_price'] 				= 0;
		$arr['sale_decrement'] 			= 0;

		$arr['date_add'] 				= time();
		$arr['last_update'] 			= time();

		$db->record_insert($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr);

		return $id;
	}

	//create record surcharge
	public function record_surcharge($shop_id, $user_add, $order_id, $name)
	{
		global $db;

		$arr['id'] 			= $id 		= $this->get_id($shop_id, $user_add) . $main->randString(5);
		$arr['order_id'] 				= $order_id;
		$arr['user_add'] 				= $user_add;
		$arr['name'] 					= $name;
		$arr['product_id'] 				= 0;
		$arr['sku_id'] 					= 0;
		$arr['quantity'] 				= 1;
		$arr['returned'] 				= 0;
		$arr['price'] 					= 0;
		$arr['note'] 					= '';

		$arr['attribute_1'] 			= '0';
		$arr['attribute_2'] 			= '0';
		$arr['attribute_3'] 			= '0';
		$arr['attribute_4'] 			= '0';
		$arr['attribute_5'] 			= '0';

		$arr['sku_name'] 				= '';
		$arr['root_price'] 				= 0;
		$arr['wh_history_id'] 			= '0';
		$arr['wh_history_return_id'] 	= '0';

		$arr['decrement'] 				= 0;
		$arr['user_decrement'] 			= '';
		$arr['vat'] 					= 0;
		$arr['same_groups'] 			= 0;

		$arr['is_coupon'] 				= 0;
		$arr['coupon_id'] 				= 0;
		$arr['is_cancel'] 				= 0;
		$arr['cancel_report_id'] 		= 0;

		$arr['date_add'] 				= time();
		$arr['last_update'] 			= time();
		$arr['inverse'] 				= 1;
		$arr['expire_date'] 			= 0;
		$arr['ratio_convert'] 			= 1;

		$arr['cashback_value'] 			= 0;
		$arr['cashback_is_value'] 		= 0;

		$arr['sale_price'] 				= 0;
		$arr['sale_decrement'] 			= 0;

		$db->record_insert($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y') . "`", $arr);

		return $id;
	}

	public function create_surcharge_item($dShop, $user_add, $order_id, $lang, $setup)
	{
		if ($dShop['surcharge_on'] == '1') {

			$name = "Phụ thu " . $dShop['surcharge_percent'] . "%";

			$surcharge_from = $dShop['surcharge_from_hour'] * 3600 + $dShop['surcharge_from_minute'] * 60 + 0;
			$surcharge_to = $dShop['surcharge_to_hour'] * 3600 + $dShop['surcharge_to_minute'] * 60 + 0;
			$now = time() - strtotime(date("m/d/Y"));
			if ($now >= $surcharge_from || $now <= $surcharge_to) //thêm
				$this->record_surcharge($dShop['id'], $user_add, $order_id, $name);
		}
		return true;
	}

	public function cal_surcharge($dShop, $order_id, $created_at)
	{
		if ($dShop['surcharge_on'] == '1') {

			@$surcharge_from = $dShop['surcharge_from_hour'] * 3600 + $dShop['surcharge_from_minute'] * 60 + 0;
			@$surcharge_to = $dShop['surcharge_to_hour'] * 3600 + $dShop['surcharge_to_minute'] * 60 + 0;
			$now = time() - strtotime(date("m/d/Y"));
			if ($surcharge_from <= $now && $now <= $surcharge_to) {

				$tong_tien = $this->get_sum_order_for_surcharge($dShop['id'], $order_id, $created_at);
				$price = $tong_tien * ($dShop['surcharge_percent'] / 100);

				//update phu thu
				$this->set('order_id', $order_id);
				$this->set('price', $price);
				$this->update_surcharge($dShop['id'], $created_at);
			}
		}
		return true;
	}

	public function update_surcharge($shop_id, $created_at)
	{
		global $db;

		$order_id 			= $this->get('order_id');
		$arr['price'] 		= $this->get('price');
		$arr['date_add'] 	= time();

		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `product_id` = '0' AND `sku_id` = '0' AND `quantity` = '1' AND `order_id` = '$order_id' ");
		return true;
	}

	public function update_cashback($shop_id)
	{
		global $db;

		$id 				= $this->get('id');
		$date_add 			= $this->get('date_add');

		$arr['cashback_value'] 			= $this->get('cashback_value');
		$arr['cashback_is_value'] 		= $this->get('cashback_is_value');

		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $date_add) . "`", $arr, " `id` = '$id' ");

		return true;
	}

	public function update_commission_for_customer($shop_id, $members_id, $order_id, $created_at)
	{
		global $db, $product_commission_detail, $setup;
		$members 		= new members();
		$member_group 	= new member_group();
		$product_price_detail 	= new product_price_detail();

		$members->set('user_id', $members_id);
		$dM = $members->get_detail();

		if (isset($dM['user_id'])) {
			if ($dM['member_group_id'] > 0) {
				//Cập nhật giá cho khách hàng này

				//Cập nhật chiết khấu cho khách hàng này
				//get list product
				$l = $this->listby_order_pro_commission($shop_id, $order_id, $created_at);
				foreach ($l as $it) {

					if (isset($setup['enabled_apply_discount_on_price']) && $setup['enabled_apply_discount_on_price'] == 1) {
						//Cập nhật cho phép hay không cho phép áp dụng bảng giá theo nhóm khách hàng
						$product_price_detail->set('product_id', $it['product_id']);
						$product_price_detail->set('unique_id', $it['unique_id']);
						$product_price_detail->set('member_group_id', $dM['member_group_id']);
						$dProPrice = $product_price_detail->get_detail_record();
						if (isset($dProPrice['product_id'])) {
							$arr['price'] 			= $dProPrice['value']; //Giá theo cài
							$arr['default_price'] 	= $dProPrice['value']; //Giá mặc định lúc này chính là giá xuất cho đối tượng này 
						} else {
							$arr['price'] = $it['retail_price']; //Giá lẻ ở product.price = retail_price
							$arr['default_price'] = $it['retail_price']; //Giá mặc định là giá lẻ cho đối tượng này ở product.price = retail_price
						}
					}

					if ($it['product_commission_id'] > 0) { //nếu =0 skip
						$product_commission_detail->set('product_commission_id', $it['product_commission_id']);
						$product_commission_detail->set('member_group_id', $dM['member_group_id']);
						$d = $product_commission_detail->get_detail_record();
						if (isset($d['value'])) {
							$arr['decrement'] 			= $d['value'];
						}
					}
					if (!empty($arr)) {
						$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`= '" . $it['id'] . "' AND `order_id` = '$order_id' ");
					}
					unset($arr);
				}
			}
		} else if ($members_id == 0) {
			//Cập nhật giá theo đúng giá sản phẩm bán lẻ
			//không có members_id thì remove giảm giá;
			//default_price theo func add_product_item là giá bán lẻ cài ở product.price

			$sTable = $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "`";
			$sql = "UPDATE  $sTable SET `price` = `default_price`, `decrement` = 0 WHERE `product_id` > 0 AND `quantity` > 0 AND `order_id` = '$order_id' ";
			$db->exeCuteQuery($sql);
		}

		return true;
	}

	public function update_cancel_return_id($shop_id, $detail_order_id, $order_created_at, $cancel_report_id)
	{
		global $db;

		$arr['cancel_report_id'] = $cancel_report_id;
		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " `id`='" . $detail_order_id . "'");

		return true;
	}

	public function update_sale_price()
	{
		global $db;

		$shop_id 					= $this->get('shop_id');
		$order_created_at 			= $this->get('date_add');
		$id 						= $this->get('id');

		$arr['sale_price'] 			= $this->get('sale_price');
		$arr['sale_decrement'] 		= $this->get('sale_decrement');

		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " id='$id' ");

		return true;
	}

	public function update_quantity($shop_id, $id, $quantity, $order_created_at)
	{
		global $db;

		$arr['quantity'] 		= $quantity;
		$arr['quantity_paid'] 		= $quantity;
		$arr['barcode'] 		= $this->get('barcode');
		$arr['note'] 			= $this->get('note');

		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " id='$id' ");

		return true;
	}

	//Update all product quantity_paid paid by order_id
	public function update_quantity_paid_all($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "UPDATE $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`
				SET `quantity_paid` = `quantity`
				WHERE `order_id` = '$order_id'";
		$db->executeQuery($sql);

		return true;
	}

	public function update_barcode_debt($shop_id)
	{
		global $db;

		$id 					= $this->get('id');
		$date_add 				= $this->get('date_add');
		$arr['quantity_paid'] 	= $this->get('quantity_paid');
		$arr['barcode'] 		= $this->get('barcode');

		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $date_add) . "`", $arr, " id='$id' ");

		return true;
	}

	public function update_quantity_paid($shop_id, $id, $quantity_paid, $order_created_at)
	{
		global $db;

		$sql = "UPDATE " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` 
				SET `quantity_paid` = ('$quantity_paid')
				WHERE `id` = '$id'";

		$db->executeQuery($sql);

		return true;
	}

	public function update_created_at_for_export_internal($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$arr['date_add'] = $order_created_at;
		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " `order_id`='$order_id' ");

		return true;
	}

	public function update_returned($shop_id)
	{
		global $db;

		$id 				= $this->get('id');
		$date_add			= $this->get('date_add');
		$arr['returned']   	= $this->get('returned');
		$arr['note']   		= $this->get('note');

		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $date_add) . "`", $arr, " `id` = '$id' ");

		return true;
	}

	public function update_warehouse_history($shop_id, $id, $quantity, $root_price, $wh_history_id, $wh_history_return_id, $order_created_at)
	{
		global $db;

		$arr['quantity'] = $quantity;
		$arr['root_price'] = $root_price;
		$arr['wh_history_id'] = $wh_history_id;
		$arr['wh_history_return_id'] = $wh_history_return_id;
		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " `id`='" . $id . "'");

		return true;
	}

	public function update_root_price($shop_id, $id, $order_created_at, $root_price)
	{
		global $db;

		$arr['root_price'] = $root_price;
		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " `id`= '" . $id . "' ");

		return true;
	}
	// chỉnh sửa function để update giá mới cho ecoupon -- An (27/09/22) 
	// thay đổi $id thành $product_id
	public function update_new_price($shop_id, $product_id, $new_price, $order_created_at)
	{
		global $db;

		$arr['price'] = $new_price;
		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " `product_id`= '" . $product_id . "' ");

		return true;
	}

	public function update_note()
	{
		global $db;

		$id 		= $this->get('id');
		$shop_id 	= $this->get('shop_id');
		$date_add 	= $this->get('date_add');

		$arr['note'] = $this->get('note');

		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $date_add) . "`", $arr, " `id` = '$id' ");

		return true;
	}

	public function update_wholesale_price($shop_id, $order_id, $order_created_at, $status)
	{
		global $db;
		$product = new product();

		$sql = "SELECT id,product_id FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` WHERE `order_id` = '" . $order_id . "' AND `product_id` > 0 ";
		$result = $db->executeQuery($sql);

		if ($status == 1) {
			while ($row = mysqli_fetch_assoc($result)) {

				$product->set('id', $row['product_id']);
				$dProduct = $product->get_detail();

				$arr['price'] = $dProduct['wholesale_price'];

				$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " `id`= '" . $row['id'] . "' ");
			}
		} else {
			while ($row = mysqli_fetch_assoc($result)) {

				$product->set('id', $row['product_id']);
				$dProduct = $product->get_detail();

				if ($dProduct['on_sales'] == 1)
					$arr['price'] = $dProduct['sales'];
				else
					$arr['price'] = $dProduct['price'];

				$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " `id`= '" . $row['id'] . "' ");
			}
		}
		mysqli_free_result($result);

		unset($dProduct);
		unset($arr);
		unset($sql);
		return true;
	}

	public function discount_percentItem($shop_id, $id, $percent, $note, $order_created_at)
	{
		global $db;

		$arr['decrement'] = $percent;
		$arr['note'] = $note;

		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " `id`='" . $id . "'");

		return true;
	}

	public function update_percent_coupon($shop_id, $id, $percent, $note, $order_created_at)
	{
		global $db;

		$coupon_id = $this->get('coupon_id');
		$arr['decrement'] = $percent;
		$arr['coupon_id'] = $coupon_id;
		$arr['note'] = $note;

		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " `id`='" . $id . "'");

		return true;
	}

	public function discount_priceItem($shop_id, $id, $new_price, $note, $order_created_at)
	{
		global $db;

		$arr['price'] = $new_price;
		$arr['note'] = $note;
		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " `id`='" . $id . "'");

		return true;
	}

	public function update_giam_gia($shop_id, $order_id, $type, $percent, $user_increment, $order_created_at)
	{
		global $db;

		if ($type == 'increment') {
			$arr['increment'] = $percent;
		} else if ($type == 'decrement') {
			$arr['decrement'] = $percent;
		} else if ($type == 'vat') {
			$arr['vat'] = $percent;
		}

		$arr['user_increment'] = $user_increment;
		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " `order_id` = '" . $order_id . "' ");

		return true;
	}

	public function decrement_all_bill($shop_id, $order_id, $percent, $user_decrement, $order_created_at)
	{
		global $db;

		$arr['decrement'] = $percent;
		$arr['user_decrement'] = $user_decrement;

		return $db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " order_id='" . $order_id . "'");
	}

	public function update_giam_gia_mon($shop_id, $id, $type, $percent, $user_increment)
	{
		global $db;

		if ($type == 'increment') {
			$arr['increment'] = $percent;
		} else if ($type == 'decrement') {
			$arr['decrement'] = $percent;
		} else if ($type == 'vat') {
			$arr['vat'] = $percent;
		}
		$arr['user_increment'] = $user_increment;
		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", $arr, " `id`='" . $id . "'");

		return true;
	}

	//update giá trị của coupon
	public function update_price_coupon($shop_id, $created_at)
	{
		global $db;
		$id = $this->get('id');
		$arr['default_price'] = $this->get('default_price');
		$arr['price'] = $this->get('price');
		$arr['root_price'] = $this->get('root_price');
		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='" . $id . "'");

		return true;
	}

	public function listby_order($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT `dt`.*, dt.`name` product_name, IFNULL(`SKU`.code, '') sku_code
						, IFNULL(pro.`unit_import`, '') unit_import
						, IFNULL(pro.`unit_export`, '') unit_export
						, IFNULL(`pro`.web_id, 0) web_id
						, IFNULL(`pro`.product_commission_id, 0) product_commission_id
						, IFNULL(pro.`pro_type`, 0) pro_type
						, IF(SKU.`img_1` IS NOT NULL AND SKU.`img_1` <> ''
						, IFNULL(SKU.`img_1`, ''), IFNULL(pro.`img_1`, '')) `image`
						, IFNULL(SKU.`on_stock`, 0) `on_stock`
						, IFNULL(SKU.`unique_id`, 0) `unique_id`
						, pro.`point`
						, pro.`price` retail_price
						, (dt.`quantity`- dt.`quantity_paid`) quantity_debt
						, pro.`link_url`
						, pro.`pro_type`
						, pro.`shop_id`
						, pro.`cat_id`
						, pro.`supplier_id`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt
				LEFT JOIN `SKU` ON `SKU`.id = `dt`.sku_id AND `SKU`.product_id = `dt`.product_id
				LEFT JOIN `product` pro ON `pro`.id = `dt`.product_id
				WHERE `order_id` = '$order_id'
				ORDER BY `last_update` DESC";
		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function listby_order_original($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT `dt`.*
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt
				WHERE `order_id` = '$order_id' ";
		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function listby_order_by_supplier($shop_id, $client_id, $supplier_id, $order_id, $order_created_at)
	{
		global $db;

		$sqlSup = '';
		if ($supplier_id !== '')
			$sqlSup = "AND `pro`.supplier_id  = '$supplier_id' ";

		$sql = "SELECT `dt`.*, IFNULL(`SKU`.code, '') sku_code, IFNULL(pro.`unit_import`, '') unit_import, IFNULL(pro.`unit_export`, '') unit_export, IFNULL(`pro`.web_id, 0) web_id, IFNULL(`pro`.product_commission_id, 0) product_commission_id, IFNULL(pro.`pro_type`, 0) pro_type
						, IF(SKU.`img_1` IS NOT NULL AND SKU.`img_1` <> '', IFNULL(SKU.`img_1`, ''), IFNULL(pro.`img_1`, '')) `image`
						, IFNULL(SKU.`on_stock`, 0) `on_stock`
						, IFNULL(SKU.`unique_id`, 0) `unique_id`, pro.`point`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt
				LEFT JOIN `SKU` ON `SKU`.id = `dt`.sku_id AND `SKU`.product_id = `dt`.product_id
				LEFT JOIN `product` pro ON `pro`.id = `dt`.product_id
				LEFT JOIN `supplier` sup ON `sup`.id = `pro`.supplier_id
				WHERE `order_id` = '$order_id' AND `sup`.client_id = '$client_id' $sqlSup
				ORDER BY `last_update` DESC";
		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function listby_order_with_point($shop_id, $order_id, $order_created_at)
	{

		global $db;

		$sql = "SELECT `dt`.*, IFNULL(`SKU`.code, '') sku_code, pro.`unit_import`, pro.`unit_export`, `pro`.web_id, `pro`.product_commission_id, pro.`pro_type`
						, IF(SKU.`img_1` IS NOT NULL AND SKU.`img_1` <> '', IFNULL(SKU.`img_1`, ''), IFNULL(pro.`img_1`, '')) `image`
						, IFNULL(SKU.`on_stock`, 0) `on_stock`
						, IFNULL(pro.`point`, 0) `point`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt
				LEFT JOIN `SKU` ON `SKU`.id = `dt`.sku_id AND `SKU`.product_id = `dt`.product_id
				LEFT JOIN `product` pro ON `pro`.id = `dt`.product_id
				WHERE `order_id` = '$order_id'
				ORDER BY `last_update` DESC";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function sum_point_of_order($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT  SUM(dt.`quantity`*IFNULL(pro.`point`, 0)) `point`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt
				LEFT JOIN `product` pro ON `pro`.id = `dt`.product_id
				WHERE `order_id` = '$order_id'";

		$result = $db->executeQuery($sql, 1);

		return $result['point'];
	}

	public function listby_order_wallet_commission($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT `dt`.*,
						IFNULL(`SKU`.code, '') sku_code
						, pro.`unit_import`
						, pro.`unit_export`
						, `pro`.web_id
						, `pro`.product_commission_id
						, `pro`.product_commission_id wallet_id
						, IFNULL(`procom`.wallet_name, '') wallet_name
						, IFNULL(`procom`.wallet_commission, 0) wallet_commission
						, IFNULL(`procom`.wallet_commission, 0) cashback_percent
						, pro.`pro_type`
						, IF(SKU.`img_1` IS NOT NULL AND SKU.`img_1` <> '', IFNULL(SKU.`img_1`, ''), IFNULL(pro.`img_1`, '')) `image`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt
				LEFT JOIN `SKU` ON `SKU`.id = `dt`.sku_id AND `SKU`.product_id = `dt`.product_id
				LEFT JOIN `product` pro ON `pro`.id = `dt`.product_id
				LEFT JOIN `product_commission` procom ON `pro`.product_commission_id = `procom`.id
				WHERE `order_id`='$order_id'
				ORDER BY `last_update` DESC";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	//Tương tự hàm listby_order_wallet_commission bỏ các item ship_fee và package fee như là phí giao dịch
	public function listby_order_wallet_commission_for_client($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT `dt`.*, IFNULL(`SKU`.code, '') sku_code, pro.`unit_import`, pro.`unit_export`, `pro`.img_1 `image`, `pro`.web_id, `pro`.product_commission_id,  `pro`.product_commission_id wallet_id, IFNULL(`procom`.wallet_name, '') wallet_name, IFNULL(`procom`.wallet_commission, 0) wallet_commission, IFNULL(`procom`.wallet_commission, 0) cashback_percent, pro.`pro_type`, `pro`.is_service
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt
				LEFT JOIN `SKU` ON `SKU`.id = `dt`.sku_id AND `SKU`.product_id = `dt`.product_id
				LEFT JOIN `product` pro ON `pro`.id = `dt`.product_id
				LEFT JOIN `product_commission` procom ON `pro`.product_commission_id = `procom`.id
				WHERE `order_id`='$order_id'
				ORDER BY `last_update` DESC";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	//Danh sách sản phẩm trong đơn hàng có cài chiết khấu cashback
	public function listby_order_with_cashback_value($shop_id, $order_id, $order_created_at, $member_group_id)
	{
		global $db;

		$sql = "SELECT `dt`.id, `dt`.product_id, `dt`.quantity, `dt`.price, `dt`.`decrement`, `dt`.`date_add`, `wCashback`.`value`, `wCashback`.`is_value`
				FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt
				INNER JOIN $db->tbl_fix`product` pro ON `pro`.id = `dt`.product_id
				INNER JOIN $db->tbl_fix`wallet_cashback` wCashback ON `wCashback`.product_commission_id = `pro`.product_commission_id AND `wCashback`.member_group_id = '$member_group_id'
				WHERE dt.`order_id` = '$order_id' AND `wCashback`.`value` > 0 AND `dt`.`decrement` = 0";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	//Tương tự hàm listby_order_wallet_commission: chỉ lấy sản phẩm, bỏ các sản phẩm dịch vụ và coupon
	public function listby_order_only_product($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT `dt`.*, IFNULL(`SKU`.code, '') sku_code, pro.`unit_import`, pro.`unit_export`, `pro`.img_1 `image`, `pro`.web_id, `pro`.product_commission_id,  `pro`.product_commission_id wallet_id, IFNULL(`procom`.wallet_name, '') wallet_name, IFNULL(`procom`.wallet_commission, 0) wallet_commission, IFNULL(`procom`.wallet_commission, 0) cashback_percent, pro.`pro_type`, `pro`.is_service
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt
				LEFT JOIN `SKU` ON `SKU`.id = `dt`.sku_id AND `SKU`.product_id = `dt`.product_id
				LEFT JOIN `product` pro ON `pro`.id = `dt`.product_id
				LEFT JOIN `product_commission` procom ON `pro`.product_commission_id = `procom`.id
				WHERE `order_id`='$order_id' AND ( pro.pro_type = '0' OR pro.pro_type = '1' )
				ORDER BY `last_update` DESC";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function listby_order_grouped($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT `dt`.*, SUM(`dt`.quantity) quantity
						,IFNULL(`SKU`.code, '') sku_code, pro.`unit_import`, pro.`unit_export`, `pro`.img_1 `image`, `pro`.web_id, `pro`.product_commission_id
						, pro.`pro_type`
				FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt
				LEFT JOIN $db->tbl_fix`SKU` ON `SKU`.id = `dt`.sku_id AND `SKU`.product_id = `dt`.product_id
				LEFT JOIN $db->tbl_fix`product` pro ON `pro`.id = `dt`.product_id
				WHERE `order_id`='$order_id'
				GROUP BY dt.`product_id`, dt.`sku_id`, dt.`price`, dt.`decrement`, dt.`inverse`
				ORDER BY `last_update` DESC";

		$result = $db->executeQuery($sql);
		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$kq[] = $row;
		}

		return $kq;
	}

	public function list_no_root_price($shop_id)
	{
		global $db, $wh_history;

		$sql = "SELECT `dt`.id, `dt`.order_id, `dt`.product_id, `dt`.sku_id, `dt`.inverse, `dt`.ratio_convert
				FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y') . "` dt
				WHERE `root_price` = 0 AND `product_id` > 0 ";

		$result = $db->executeQuery($sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$dRoot = $wh_history->get_last_price_import($row['product_id'], $row['sku_id']);
			if (isset($dRoot['price']) && $dRoot['price'] > 0) {

				$root_price = $dRoot['price'];
				$arr['ratio_convert'] = $row['ratio_convert'];
				if (!($dRoot['inverse'] == $row['inverse'] && ($row['inverse'] == 0 || $row['inverse'] == 1))) {
					if ($row['ratio_convert'] == 0) $arr['ratio_convert'] = 1;
					if ($dRoot['inverse'] == 0 &&  $row['inverse'] == 1) {
						$root_price = $dRoot['price'] / $arr['ratio_convert'];
					} else if ($dRoot['inverse'] == 1 &&  $row['inverse'] == 0) {
						$root_price = $dRoot['price'] * $arr['ratio_convert'];
					}
				}

				$arr['root_price'] = $root_price;
				$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y') . "`", $arr, " `id`='" . $row['id'] . "'");
			}
		}

		return true;
	}

	public function list_by_wh_history($shop_id, $wh_history_id, $amount_exported)
	{
		global $db, $user, $setup;
		//Hiện tại chỉ cho show ra sản phẩm được list trong năm đang chọn;

		$table_schema 	= str_replace('.', '', $db->tbl_fix);
		$sum_amount_exported = 0;

		$YEAR 				= date('Y', time());
		$year_stop			= date('Y', $setup['begin_time']) - 1;
		$total_export_sum 	= 0;
		$kq					= array();

		while ($YEAR > $year_stop && $amount_exported > $total_export_sum) {
			$table_name_dt 	= "detail_order_" . $shop_id . "_" . $YEAR;
			$table_name_order 	= "order_" . $shop_id . "_" . $YEAR;

			$sql1 = "SELECT COUNT(*) total FROM information_schema.`tables` WHERE table_schema = '$table_schema' AND table_name = '$table_name_dt' LIMIT 1";
			$exist = $db->executeQuery($sql1, 1);

			if (isset($exist['total']) && $exist['total'] > 0) {

				$sql = "SELECT `dt`.id, `dt`.order_id, `dt`.`name`, `dt`.inverse, SUM(`dt`.quantity) quantity, `dt`.price, `dt`.root_price, `dt`.`decrement`,  pro.`unit_import`, pro.`unit_import`, dt.`ratio_convert`, dt.`wh_history_id`, od.`order_type`, `dt`.date_add created_at, `od`.user_add, `od`.shop_id, , pro.`pro_type`
						FROM $db->tbl_fix`$table_name_dt` dt
						INNER JOIN $db->tbl_fix`product` pro ON `pro`.id = `dt`.product_id
						INNER JOIN $db->tbl_fix`$table_name_order` od ON `od`.id = `dt`.order_id
						WHERE dt.`wh_history_id`='$wh_history_id' AND `pro`.shop_id = '$shop_id' AND od.`status` = 1 AND od.`printed` = 1
						GROUP BY `dt`.order_id, `dt`.`product_id`, `dt`.`sku_id`, `dt`.inverse, `dt`.price, `dt`.root_price, `dt`.`decrement`
						ORDER BY dt.`last_update` DESC";
				$result = $db->executeQuery($sql);

				while ($row = mysqli_fetch_assoc($result)) {
					if ($row['inverse'] == 1 && $row['ratio_convert'] > 1)
						$total_export_sum += $row['quantity'] / $row['ratio_convert'];
					else
						$total_export_sum += $row['quantity'];
					$row['user_add_fullname'] = $user->get_fullname($row['user_add']);
					$kq[] = $row;
				}
			}

			$YEAR -= 1;
		}

		return $kq;
	}

	public function list_exported_before_imported($shop_id, $product_id, $sku_id)
	{
		global $db, $user, $setup;
		//Hiện tại chỉ cho show ra sản phẩm được list trong năm đang chọn;

		$table_schema 	= str_replace('.', '', $db->tbl_fix);
		$sum_amount_exported = 0;

		$YEAR 				= date('Y', time());
		$year_stop			= date('Y', $setup['begin_time']) - 1;
		$total_export_sum 	= 0;
		$kq					= array();

		while ($YEAR > $year_stop) {
			$table_name_dt 	= "detail_order_" . $shop_id . "_" . $YEAR;
			$table_name_order 	= "order_" . $shop_id . "_" . $YEAR;

			$sql1 = "SELECT COUNT(*) total FROM information_schema.`tables` WHERE table_schema = '$table_schema' AND table_name = '$table_name_dt' LIMIT 1";
			$exist = $db->executeQuery($sql1, 1);

			if (isset($exist['total']) && $exist['total'] > 0) {

				$sql = "SELECT `dt`.id, `dt`.order_id, `dt`.`name`, `dt`.inverse, SUM(`dt`.quantity) quantity, `dt`.price, `dt`.root_price, `dt`.`decrement`,  pro.`unit_import`, pro.`unit_import`, dt.`ratio_convert`, dt.`wh_history_id`, od.`order_type`, `dt`.date_add created_at, `od`.user_add, `od`.shop_id
						FROM " . $db->tbl_fix . "`$table_name_dt` dt
						INNER JOIN `product` pro ON `pro`.id = `dt`.product_id
						INNER JOIN " . $db->tbl_fix . "`$table_name_order` od ON `od`.id = `dt`.order_id
						WHERE dt.`wh_history_id` = '0' AND dt.`product_id` = '$product_id' AND dt.`sku_id` = '$sku_id' AND `pro`.shop_id = '$shop_id'  AND od.`status` = 1 AND od.`printed` = 1 
						GROUP BY `dt`.order_id, `dt`.`product_id`, `dt`.`sku_id`, `dt`.inverse, `dt`.price, `dt`.root_price, `dt`.`decrement`
						ORDER BY dt.`last_update` DESC";
				$result = $db->executeQuery($sql);

				while ($row = mysqli_fetch_assoc($result)) {
					if ($row['inverse'] == 1 && $row['ratio_convert'] > 1)
						$total_export_sum += $row['quantity'] / $row['ratio_convert'];
					else
						$total_export_sum += $row['quantity'];
					$row['user_add_fullname'] = $user->get_fullname($row['user_add']) . '';
					$kq[] = $row;
				}
			}

			$YEAR -= 1;
		}

		return $kq;
	}

	public function listby_order_ex_storing($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT `dt`.*, `dt`.quantity amount,  `dt`.inverse is_inverse, `dt`.`name` product_name, IFNULL(`SKU`.code, '') code, pro.`unit_import`, pro.`unit_export`, pro.`ratio_convert`, pro.`pro_type`
				, IF( IFNULL(SKU.img_1, '') = '', pro.img_1,  SKU.img_1) `image`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt
				LEFT JOIN `SKU` ON `SKU`.id = `dt`.sku_id AND `SKU`.product_id = `dt`.product_id
				LEFT JOIN `product` pro ON `pro`.id = `dt`.product_id
				WHERE `order_id`='" . $order_id . "'
				ORDER BY `last_update` DESC";

		$result = $db->executeQuery($sql);

		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$row['expire_date'] = $row['expire_date'] == 0 ? '' : date("d/m/Y", $row['expire_date']);
			$kq[] = $row;
		}

		return $kq;
	}

	public function listby_order_pro_commission($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT `dt`.id, `dt`.product_id, pro.`product_commission_id`, pro.`pro_type`
				, `dt`.`default_price`, SKU.`unique_id`, pro.`price` retail_price
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt
				LEFT JOIN  " . $db->tbl_fix . "`product` pro ON pro.`id` = dt.`product_id`
				LEFT JOIN  " . $db->tbl_fix . "`SKU` ON dt.`sku_id` = SKU.`id` AND SKU.`product_id` = dt.`product_id`
				WHERE `order_id` = '$order_id'
				AND dt.`product_id` > 0
				";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function create_order_from_booking_order($new_order_id)
	{ //cofbo
		global $db;

		$shop_id 		= $this->get('shop_id');
		$order_id 		= $this->get('order_id');
		$date_add 		= $this->get('date_add');

		$lItems = $this->listby_order($shop_id, $order_id, $date_add);

		$this->set('order_id', $new_order_id);
		foreach ($lItems as $item) {
			$left_quantity = $item['quantity'] - $item['delivered'];
			if ($left_quantity > 0) {

				$this->set('product_id', $item['product_id']);
				$this->set('sku_id', $item['sku_id']);

				$this->set('quantity', $left_quantity);
				$this->set('returned', 0);
				$this->set('max_allowed_order', $left_quantity);
				$this->set('name', $item['name']);
				$this->set('note', '');
				$this->set('price', $item['price']);
				$this->set('root_price', $item['root_price']);
				$this->set('wh_history_id', 0);
				$this->set('decrement', $item['decrement']);
				$this->set('user_decrement', $item['user_decrement']);
				$this->set('vat', $item['vat']);
				$this->set('user_add', $item['user_add']);

				$this->set('attribute_1', $item['attribute_1']);
				$this->set('attribute_2', $item['attribute_2']);
				$this->set('attribute_3', $item['attribute_3']);
				$this->set('attribute_4', $item['attribute_4']);
				$this->set('attribute_5', $item['attribute_5']);

				$this->set('sku_name', $item['sku_name']);
				$this->set('wh_history_id', 0);
				$this->set('wh_history_return_id', 0);
				$this->set('delivered', 0);

				//Tạo item 
				$this->add($shop_id, $date_add);
			}
		}
		unset($lItems);

		return true;
	}

	public function get_total_item($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT COUNT(*) as total_item FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` dt WHERE `order_id`='" . $order_id . "' ";
		$result = $db->executeQuery($sql, 1);

		return $result['total_item'] + 0;
	}

	public function listby_order_widthSKU($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT dt.*, SKU.`on_stock`, SKU.`name` as sku_name,
				SKU.`attribute_1`, SKU.`attribute_2`, SKU.`attribute_3`, SKU.`attribute_4`, SKU.`attribute_5`,
				pro.`root_price`, pro.`allow_root_price`, pro.`pro_type`
			  	FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` as dt
				INNER JOIN $db->tbl_fix`SKU` ON dt.`sku_id` = `SKU`.id AND `dt`.product_id = `SKU`.product_id AND dt.order_id = '$order_id'
				INNER JOIN $db->tbl_fix`product` pro ON pro.`id` = `dt`.product_id
 				ORDER BY `date_add` ASC";

		$result = $db->executeQuery($sql);

		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$kq[] = $row;
		}

		return $kq;
	}

	public function listby_order_widthSKU_grouped($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT SUM(`dt`.quantity) as quantity, SKU.`on_stock`, `dt`.name, `SKU`.id as sku_id, `SKU`.product_id, pro.`price`, pro.`root_price`, pro.`allow_root_price`, pro.`pro_type`
			  	FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` as dt
				INNER JOIN `SKU` ON dt.`sku_id` = `SKU`.id AND `dt`.product_id = `SKU`.product_id AND dt.order_id = '$order_id'
				INNER JOIN $db->tbl_fix`product` pro ON pro.`id` = `dt`.product_id
				GROUP BY `dt`.product_id, `dt`.sku_id
				";

		$result = $db->executeQuery($sql);
		$kq = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$kq[] = $row;
		}

		mysqli_free_result($result);
		unset($row);

		return $kq;
	}

	public function listby_order_return($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT dt.*, IFNULL(SKU.`on_stock`, 0) on_stock
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` as dt
				LEFT JOIN `SKU` ON dt.`sku_id` = `SKU`.id AND `dt`.product_id = `SKU`.product_id
				WHERE `order_id` = '" . $order_id . "'
				ORDER BY last_update DESC";
		$result = $db->executeQuery($sql);
		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$kq[] = $row;
		}

		return $kq;
	}

	// public function listby_order_letter($shop_id, $order_id, $order_created_at){//list to print form A4, A5
	// 	global $db;

	// 	$sql = "SELECT SUM(dt.quantity) as amount, dt.name, dt.price,dt.date_add, dt.decrement, dt.vat, `SKU`.code sku_code
	// 			FROM ".$db->tbl_fix."`detail_order_".$shop_id."_".date('Y', $order_created_at)."` as dt
	// 			LEFT JOIN `SKU` ON `SKU`.id = dt.`sku_id` AND `SKU`.product_id = dt.product_id
	// 			WHERE dt.order_id='$order_id' AND dt.`quantity` > 0
	// 			GROUP BY dt.`product_id`, dt.`sku_id`, dt.`price`, dt.`decrement`
	// 			ORDER BY dt.date_add ASC";

	// 	$result = $db->executeQuery ( $sql );
	// 	$kq = array();
	// 	while($row = mysqli_fetch_assoc($result)){
	// 		$kq[] = $row;
	// 	}

	// 	return $kq;
	// }

	// public function listby_order_toprint($shop_id, $order_id, $order_created_at, $type = '')
	// {
	// 	global $db, $setup;

	// 	if ($type != '' && $type == 'client_delivery') {
	// 		$limit = '';
	// 		// $limit = 'LIMIT 0,3';
	// 		$pro_type = 'AND p.`pro_type` = 0';
	// 	} else {
	// 		$limit = '';
	// 		$pro_type = '';
	// 	}

	// 	$sql = "SELECT SUM(dt.`quantity`) quantity, dt.`name`, dt.`price`, dt.`decrement`, dt.`sale_price`, dt.`sale_decrement`, dt.`date_add`, dt.`product_id`, dt.`sku_id`, dt.`vat`, dt.`sku_name`, IFNULL(`SKU`.code, '') sku_code, p.`img_1` `image`
	// 			FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` as dt 
	// 			LEFT JOIN `SKU` ON `SKU`.id = dt.`sku_id` AND `SKU`.product_id = dt.product_id
	// 			LEFT JOIN product p ON p.`id` = dt.`product_id`
	// 			WHERE dt.order_id='$order_id' AND (dt.`quantity` > 0 OR (dt.`quantity` < 0 AND dt.product_id = 0 )) $pro_type
	// 			GROUP BY dt.`product_id`, dt.`sku_id`, dt.`price`, dt.`decrement`, dt.`sale_price`, dt.`sale_decrement`
	// 			ORDER BY dt.date_add DESC " . $limit . "";

	// 	$result = $db->executeQuery($sql);
	// 	$kq = array();
	// 	$kq_discount = array();
	// 	while ($row = mysqli_fetch_assoc($result)) {
	// 		if ($row['quantity'] == -1 && $row['product_id'] == 0) {
	// 			$kq_discount[] = $row;
	// 		} else {
	// 			$kq[] = $row;
	// 		}
	// 	}

	// 	$kq = array_merge($kq, $kq_discount);

	// 	return $kq;
	// }
	public function listby_order_toprint($shop_id, $order_id, $order_created_at, $type = '')
	{
		global $db, $setup;
		$order_detail_combo = new order_detail_combo();

		if ($type != '' && $type == 'client_delivery') {
			$limit = '';
			// $limit = 'LIMIT 0,3';
			$pro_type = 'AND p.`pro_type` = 0';
		} else {
			$limit = '';
			$pro_type = '';
		}

		$sql = "SELECT SUM(dt.`quantity`) quantity, dt.`name`, dt.`price`, dt.`decrement`, dt.`sale_price`, dt.`sale_decrement`, dt.`date_add`, dt.`product_id`, dt.`sku_id`, dt.`vat`, dt.`sku_name`, IFNULL(`SKU`.code, '') sku_code, p.`img_1` `image`, p.`pro_type` `pro_type`, dt.`id` `detail_order_id`, dt.`coupon_id`
				FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` as dt 
				LEFT JOIN `SKU` ON `SKU`.id = dt.`sku_id` AND `SKU`.product_id = dt.product_id
				LEFT JOIN product p ON p.`id` = dt.`product_id`
				WHERE dt.order_id='$order_id' AND (dt.`quantity` > 0 OR (dt.`quantity` < 0 AND dt.product_id = 0) OR (dt.coupon_id>0 AND dt.is_coupon>0)) $pro_type
				GROUP BY dt.`product_id`, dt.`sku_id`, dt.`price`, dt.`decrement`, dt.`sale_price`, dt.`sale_decrement`
				ORDER BY dt.date_add DESC " . $limit . "";

		$result = $db->executeQuery($sql);
		$kq = array();
		$kq_discount = array();
		while ($row = mysqli_fetch_assoc($result)) {

			if ($row['pro_type'] == 4) {
				$order_detail_combo->set('shop_id', $shop_id);
				$order_detail_combo->set('product_id', $row['product_id']);
				$order_detail_combo->set('detail_order_id', $row['detail_order_id']);
				$row['detail_combo'] = $order_detail_combo->get_product_by_order_detail();
			}

			if ($row['quantity'] == -1 && $row['product_id'] == 0) {
				$kq_discount[] = $row;
			} else {
				$kq[] = $row;
			}
		}

		$kq = array_merge($kq, $kq_discount);

		return $kq;
	}

	public function listby_order_toprint_return($shop_id, $order_id, $order_created_at)
	{
		global $db;

		$sql = "SELECT dt.`quantity`, dt.`name`, dt.`price`, dt.`decrement`, dt.`sale_price`, dt.`sale_decrement`, dt.`date_add`, dt.`vat`, dt.`note`
						, dt.`sku_name`, `SKU`.code sku_code, p.`img_1` `image`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` as dt
				LEFT JOIN `SKU` ON `SKU`.id = dt.`sku_id` AND `SKU`.product_id = dt.product_id
				LEFT JOIN product p ON p.`id` = dt.`product_id`
				WHERE dt.order_id = '$order_id' AND dt.`quantity` < 0 AND dt.product_id > 0 AND dt.coupon_id=0 ORDER BY dt.date_add ASC";

		$result = $db->executeQuery($sql);
		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$kq[] = $row;
		}

		return $kq;
	}

	public function get_sum_order_sub_orders($shop_id, $sub_orders)
	{ //format: ;order_id1:created_at1;order_id2:created_at2;
		global $db;

		$total = 0;
		$sub_orders = explode(';', $sub_orders);
		foreach ($sub_orders as $it) {
			if ($it != '') {
				$it = explode(':', $it);
				if (COUNT($it) == 2) {
					$total += $this->get_sum_order($shop_id, $it[0], $it[1]);
				}
			}
		}

		return $total;
	}

	public function get_sum_order($shop_id, $order_id, $order_created_at = 0)
	{
		global $db;

		if ($order_created_at == 0) $order_created_at = time();

		$sql = "SELECT sum((`quantity`*`price`*(100-`decrement`)/100)) as `sum`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` 
				WHERE order_id='$order_id'";
		// WHERE order_id='$order_id' AND `is_coupon`=0";

		$result = $db->executeQuery($sql, 1);
		return $result['sum'];
	}

	public function get_sum_order_default($shop_id, $order_id, $order_created_at = 0)
	{
		global $db;

		if ($order_created_at == 0) $order_created_at = time();

		$sql = "SELECT sum((`quantity`*`default_price`) as `sum` 
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` 
				WHERE order_id='$order_id'";
		// WHERE order_id='$order_id' AND `is_coupon`=0";

		$result = $db->executeQuery($sql, 1);

		return $result['sum'];
	}

	public function get_sum_general($shop_id, $order_id, $order_created_at = 0)
	{ //Lấy sum tổng hợp
		global $db;

		if ($order_created_at == 0) $order_created_at = time();

		$sql = "SELECT sum((`quantity`*`price`*(100-`decrement`)/100)) as `total_order`, sum(`quantity`*`default_price`) as `total_default` 
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` 
				WHERE order_id='$order_id' AND `coupon_id`=0";

		$r = $db->executeQuery($sql, 1);

		return array(
			'total_order' => isset($r['total_order']) ? $r['total_order'] : 0,
			'total_default' => isset($r['total_default']) ? $r['total_default'] : 0 //Giá trị tổng đơn phải thu người dùng
		);
	}

	public function count_item_product($shop_id, $order_created_at)
	{
		global $db;

		$no_items 	= 0;

		$order_id 				= $this->get('order_id');

		if ($order_created_at < 10000) $order_created_at = time();

		$sql = "SELECT `quantity` FROM
				" . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`
				WHERE `order_id` = '$order_id' AND `product_id` > 0
				LIMIT 1";
		$lIt = $db->executeQuery_list($sql);


		foreach ($lIt as $key => $it) {
			$no_items += abs($it['quantity']);
		}

		return $no_items;
	}

	public function get_static_info($shop_id, $order_created_at)
	{ //discount; cost (root price); no items
		global $db;

		$no_items 	= 0;
		$discount 	= 0;
		$cost 		= 0;

		$order_id 				= $this->get('order_id');

		if ($order_created_at < 10000) $order_created_at = time();

		$sql = "SELECT `quantity`, `decrement`, `root_price`, `price`, `product_id` FROM
				" . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`
				WHERE `order_id` = '$order_id' AND `product_id` > 0";
		$lIt = $db->executeQuery_list($sql);

		foreach ($lIt as $key => $it) {

			if ($it['product_id'] > 0) {
				$no_items 	+= abs($it['quantity']);
				$cost 		+= abs($it['quantity']) * $it['root_price'];
			}

			$discount 	+= ($it['quantity'] * $it['price']) * ($it['decrement'] / 100); // giảm giá theo item
			if ($it['product_id'] == 0 && $it['quantity'] == -1)
				$discount 	+= abs($it['price']); // record giảm giá
		}

		return array('cost' => $cost, 'no_items' => $no_items, 'discount' => $discount);
	}

	public function get_sum_order_for_surcharge($shop_id, $order_id, $order_created_at = 0)
	{
		global $db;

		if ($order_created_at == 0) $order_created_at = time();

		$sql = "SELECT sum((`quantity`*`price`*(100-`decrement`)/100)) as sum 
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` 
				WHERE order_id='" . $order_id . "' AND `product_id` > 0 AND `quantity` > 0
				ORDER BY date_add ASC";

		$result = $db->executeQuery($sql, 1);

		return $result['sum'];
	}

	public function get_detail()
	{
		global $db;

		$shop_id 			= $this->get('shop_id');
		$id 				= $this->get('id');
		$order_created_at 	= $this->get('date_add');

		if ($order_created_at == 0) $order_created_at = time();

		$sql = "SELECT *, (`quantity`-`quantity_paid`) quantity_debt FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` WHERE id='" . $id . "' LIMIT 1";
		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function get_exist_product($shop_id, $order_created_at)
	{
		global $db;

		$order_id 				= $this->get('order_id');
		$product_id 			= $this->get('product_id');
		$sku_id 				= $this->get('sku_id');

		if ($order_created_at < 10000) $order_created_at = time();

		$sql = "SELECT * FROM
				" . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`
				WHERE `order_id` = '$order_id' AND `product_id` = '$product_id' AND `sku_id` = '$sku_id'
				LIMIT 1";

		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function get_exist_coupon($shop_id, $order_created_at)
	{
		global $db;

		$order_id 				= $this->get('order_id');
		$product_id 			= $this->get('product_id');
		// $sku_id 				  = $this->get('sku_id');
		$coupon_id				= $this->get('coupon_id');

		if ($order_created_at < 10000) $order_created_at = time();

		$sql = "SELECT * FROM
				" . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`
				WHERE `order_id` = '$order_id' AND `product_id` = '$product_id' AND `coupon_id`='$coupon_id'
				LIMIT 1";

		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function check_exist_coupon($shop_id, $order_created_at)
	{
		global $db;

		$order_id = $this->get('order_id');

		if ($order_created_at < 10000) $order_created_at = time();

		$sql = "SELECT * FROM
				" . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`
				WHERE `order_id` = '$order_id' AND `coupon_id`<>'0'
				LIMIT 1";
		// echo $sql;
		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function get_exist_shipping_fee($shop_id, $order_created_at)
	{
		global $db;

		$order_id 				= $this->get('order_id');
		$product_id 			= $this->get('product_id');
		$sku_id 				= $this->get('sku_id');
		$coupon_id				= $this->get('coupon_id');
		$is_coupon				= $this->get('is_coupon');

		if ($order_created_at < 10000) $order_created_at = time();

		$sql = "SELECT * FROM
				" . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`
				WHERE `order_id` = '$order_id' AND `product_id` = '$product_id' AND `sku_id` = '$sku_id' AND `coupon_id`='$coupon_id' AND `is_coupon`='$is_coupon'
				LIMIT 1";

		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function get_surcharge_item($shop_id, $order_id, $created_at = 0)
	{
		global $db;
		if ($created_at == 0) $created_at = time();

		$sql = "SELECT * FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "`
				WHERE `order_id` = '" . $order_id . "' AND `product_id` = '0' AND `sku_id` = '0' AND `quantity` = '1'
				LIMIT 1";

		$result = $db->executeQuery($sql, 1);
		return $result;
	}

	public function delete_item()
	{
		global $db;

		$shop_id 			= $this->get('shop_id');
		$id 				= $this->get('id');
		$order_created_at 	= $this->get('date_add');

		$db->record_delete($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` ", " `id` = '" . $id . "' ");

		return true;
	}

	public function delete_by_order_id($shop_id, $order_id, $order_created_at = 0)
	{
		global $db;
		if ($order_created_at == 0) $order_created_at = time();

		$db->record_delete($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "`", " `order_id` = '$order_id' ");

		return true;
	}

	public function get_sku_name_SKU($dd_order)
	{

		$attribute = '';

		if ($dd_order['sku_name'] != '') $attribute = '(' . $dd_order['sku_name'] . ')';

		return $attribute;
	}

	public function get_id($shop_id, $user_add)
	{
		global $db, $main;
		$user = new user();
		$dUser = $user->get_detail($user_add);

		$startDate = strtotime(date('m/d/Y'));

		$sql = "SELECT id FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y') . "` WHERE `date_add` > '$startDate' ORDER BY `id` DESC , `date_add` DESC LIMIT 1";
		$result = $db->executeQuery($sql, 1);
		if (isset($result['id'])) {
			$id = substr($result['id'], 0, 5) + 1;
			$id = sprintf("%05d", $id) . date('dmy') . $main->randString(5); //.sprintf( "%04d", $dUser['id'] );
			unset($dUser);
			return $id;
		} else {
			$id = '00001' . date('dmy') . $main->randString(5); //.sprintf( "%04d", $dUser['id'] );
			unset($dUser);
			return $id;
		}
	}

	public function get_max_id($shop_id)
	{
		global $db;
		$startDate = strtotime(date('m/d/Y'));
		$sql = "SELECT id FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y') . "` WHERE `date_add`>'$startDate' ORDER BY `id` DESC, `date_add` DESC LIMIT 1";
		$result = $db->executeQuery($sql, 1);
		if (isset($result['id'])) {
			return substr($result['id'], 0, 5) + 1;
		} else {
			return 1;
		}
	}

	public function arrDetailOrder($shop_id, $order_id, $order_created_at = 0)
	{
		global $db;
		if ($order_created_at == 0) $order_created_at = time();
		$sql = "SELECT * 
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $order_created_at) . "` as dt 
				WHERE `order_id` = '" . $order_id . "' 
				ORDER BY date_add ASC";
		$result = $db->executeQuery($sql);
		$kq  = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$kq[] = $row;
		}
		return $kq;
	}

	public function add_product_item($shop_id, $username, $order_id, $created_at, $dProduct, $dSKU, $is_storing = 0)
	{
		global $wh_history, $shop, $order, $detail_order, $product, $SKU, $setup;

		//BEGIN lấy giá vốn của SKU và id phiếu nhập
		$root_price		= '0';
		$wh_history_id	= '0';

		$dWhHis = $wh_history->get_fifo_row($dProduct['id'], isset($dSKU['id']) ? $dSKU['id'] : '0');
		if (isset($dWhHis['id'])) { //Lấy phiếu nhập liên quan nếu có
			$wh_history_id	= $dWhHis['id'];
		}

		if (isset($dProduct['allow_root_price']) && $dProduct['allow_root_price'] == 1) {
			$root_price		= $dProduct['root_price']; //Cho phép lấy theo giá cài
		} else {
			if (isset($dWhHis['id'])) //Tính giá vốn theo giá xuất và theo đúng phiếu xuất
				$root_price		= ($dWhHis['price'] / $dWhHis['ratio_convert']) * ((100 - $dWhHis['decrement']) / 100);
		}
		//END lấy giá vốn của SKU và id phiếu nhập

		$dShop = $shop->get_detail($shop_id);

		if (!isset($dSKU['id'])) {
			$product->set('id', $dProduct['id']);
			$dProDefault = $product->get_detail();
			$detail_order->set('default_price', $dProDefault['price']);
		} else {
			// $dSKU = $SKU->get_detail('0', $dProduct['id']);
			$detail_order->set('default_price', isset($dSKU['price']) ? $dSKU['price'] : 0);
		}

		if ($is_storing == 1) {

			$detail_order->set('quantity', $dProduct['quantity']);
			$detail_order->set('price', $dProduct['price']);
			$detail_order->set('inverse', $dProduct['inverse']); //đơn vị xuất cho POS
			$detail_order->set('expire_date', $dProduct['expire_date']);
			$detail_order->set('decrement', $dProduct['decrement']);
		} else {

			$price = $dProduct['price'] + 0;

			$detail_order->set('quantity', 1);
			$detail_order->set('decrement', 0);
			$detail_order->set('price', $price);
			$detail_order->set('inverse', 1); //đơn vị xuất cho POS
			$detail_order->set('expire_date', isset($dWhHis['expire_date']) ? $dWhHis['expire_date'] : 0);
		}

		$detail_order->set('order_id', $order_id);
		$detail_order->set('product_id', $dProduct['id']);
		$detail_order->set('ratio_convert', $dProduct['ratio_convert']);

		if (isset($dSKU['id']))
			$detail_order->set('sku_id', $dSKU['id']);
		else
			$detail_order->set('sku_id', 0);

		if ($dProduct['multi_attribute'] == 1 && isset($dSKU['name']))
			$detail_order->set('name', $dProduct['name'] . ' (' . $dSKU['name'] . ')');
		else
			$detail_order->set('name', $dProduct['name']);

		$detail_order->set('user_add', $username);
		$detail_order->set('note', isset($dProduct['note']) ? $dProduct['note'] : '');

		$detail_order->set('attribute_1',  isset($dSKU['id']) ? $dSKU['attribute_1'] : '0');
		$detail_order->set('attribute_2',  isset($dSKU['id']) ? $dSKU['attribute_2'] : '0');
		$detail_order->set('attribute_3',  isset($dSKU['id']) ? $dSKU['attribute_3'] : '0');
		$detail_order->set('attribute_4',  isset($dSKU['id']) ? $dSKU['attribute_4'] : '0');
		$detail_order->set('attribute_5',  isset($dSKU['id']) ? $dSKU['attribute_5'] : '0');
		$detail_order->set('sku_name', 	   isset($dSKU['id']) ? $dSKU['name'] : '');

		$detail_order->set('root_price', $root_price);
		$detail_order->set('wh_history_id', $wh_history_id);
		$detail_order->set('wh_history_return_id', 0);

		$dOrder 	= $order->get_detail($shop_id, $order_id, $created_at);

		//chỉ cho phép insert khi status == 0 (order temp)
		$detail_order_id = '';
		$quantity = 1;
		if (isset($dOrder['status']) && ($dOrder['status'] == 0 or $dOrder['status'] == -2)) {

			if ($is_storing == 1) {
				//nếu export mà theo kho thì thêm chứ ko nhập dòng
				$detail_order_id = $detail_order->add($shop_id, $created_at);
			} else {
				$dExistPro = $detail_order->get_exist_product($shop_id, $created_at);
				if (empty($dExistPro['id']))
					$detail_order_id = $detail_order->add($shop_id, $created_at);
				else {
					$quantity = ($dExistPro['quantity'] + 1);
					$barcode = $this->get('barcode');
					if ($barcode != '') {
						$detail_order->set('barcode', $dExistPro['barcode'] == '' ? $barcode : $dExistPro['barcode'] . ';' . $barcode);
						if ($dExistPro['barcode'] != '') {
							$lBar = explode(';', $dExistPro['barcode']);
							$lBar = array_diff($lBar, ['']);
							$quantity = COUNT($lBar) + 1;
						} else {
							$quantity = 1;
						}
					}
					$detail_order->set('note', $dExistPro['note']);
					$detail_order->update_quantity($shop_id, $dExistPro['id'], $quantity, $created_at);
					$detail_order_id = $dExistPro['id'];
				}
			}

			// AnCode: Nếu là sản phẩm Combo thì thêm sản phẩm vào bảng order_detail_combo
			if ($dProduct['pro_type'] == 4) {
				// lấy list sản phẩm Combo của sản phẩm đó
				$product_combo = new product_combo();
				$product_combo->set('product_combo_id', $dProduct['id']);
				$lCombo = $product_combo->list_by_product_combo();
				// lấy từng sản phẩm trong combo thêm vào bảng order_detail_combo
				foreach ($lCombo as $key => $dCombo) {
					// lấy dữ liệu của sản phẩm combo ra kiểm tra
					$order_detail_combo = new order_detail_combo();
					$order_detail_combo->set('detail_order_id', $detail_order_id);
					$order_detail_combo->set('product_id', $dCombo['product_id']);
					$dExistCombo = $order_detail_combo->get_exist_product($shop_id);
					// nếu đã tồn tại thì cập nhật số lượng không thêm mới.
					if (empty($dExistCombo['id'])) {
						//thêm mới vào order_detail_combo 
						$order_detail_combo = new order_detail_combo();
						$order_detail_combo->set('product_combo_id', $dProduct['id']);
						$order_detail_combo->set('product_id', $dCombo['product_id']);
						$order_detail_combo->set('unique_id', $dCombo['unique_id']);
						$order_detail_combo->set('price_sale', $dCombo['price_sale']);
						$order_detail_combo->set('quantity', $dCombo['quantity']);
						$order_detail_combo->set('price', $dCombo['price']);
						$order_detail_combo->set('shop_id', $shop_id);
						$order_detail_combo->set('order_id', $order_id);
						$order_detail_combo->set('detail_order_id', $detail_order_id);
						$order_detail_combo->set('order_created_at', $detail_order_id);
						$order_detail_combo->set('wh_history_id', $wh_history_id);
						$order_detail_combo_id = $order_detail_combo->add();
					} else {
						// cập nhập lại số lượng
						$dQuantity = $quantity * $dCombo['quantity'];
						$order_detail_combo->update_quantity($dExistCombo['id'], $dQuantity);
					}
				}
			}

			/**
			 * begin cập nhật phí giao hàng
			 */
			//kiểm tra xem đơn hàng có phí vận chuyển không nếu có khi xóa hay thêm sản phẩm thì xóa đi
			$detail_order->set('order_id', $order_id);
			$detail_order->set('product_id', isset($setup['pro_ship_fee']) && $setup['pro_ship_fee'] > 0 ? $setup['pro_ship_fee'] : 0);
			$detail_order->set('sku_id', 0);
			$detail_order->set('coupon_id', 0);
			$detail_order->set('is_coupon', 0);
			//kiểm tra xem có tồn tại phí giao hàng không
			$dExistShippingFee = $detail_order->get_exist_shipping_fee($shop_id, $created_at);
			//nếu có phí giao hàng thì xóa đi khi xóa 1 item trong đơn hàng hiện tại
			if (isset($dExistShippingFee['id']) && $dExistShippingFee['id'] != '') {
				$detail_order->set('shop_id', $shop_id);
				$detail_order->set('id', $dExistShippingFee['id']);
				$detail_order->set('date_add', $created_at);
				$detail_order->delete_item();
				//sau khi xóa sản phẩm phí vận chuyển update lại dịch vụ vận chuyển của đơn hàng là rỗng
				$delivery = new delivery();
				$delivery->set('order_id', $order_id);
				$delivery->set('shop_id', $shop_id);
				$dDelivery = $delivery->get_by_order_id();
				if (isset($dDelivery['id']) && $dDelivery['id'] != '') {
					//lấy đơn vị vận chuyển đang tích hợp ở setting
					if (isset($setup['default_shipping_system']) && $setup['default_shipping_system'] != '') {
						$partner_id = $setup['default_shipping_system'];
					} else {
						$partner_id = 1;
					}
					$delivery->set('id', $dDelivery['id']);
					$delivery->set('rate_id', '');
					$delivery->set('rate_info', '');
					$delivery->set('carrier', $partner_id);
					//update lại delivery khi xóa phí vận chuyển
					$delivery->update_service_delivery();
				}
				//update lại service_fee 
				$order->set('shop_id', $shop_id);
				$order->set('id', $order_id);
				$order->set('created_at', $created_at);
				$order->set('service_fee', 0);
				$order->update_service_fee();
			}

			/**
			 * end cập nhật phí giao hàng
			 */
			if ($is_storing == 0) {
				//create sarcharge => Tính phụ thu nếu có
				$detail_order->cal_surcharge($dShop, $order_id, $created_at);
			}
		}

		if ($is_storing == 0) {
			$dOrder 	= $order->get_detail($shop_id, $order_id, $created_at);

			$hasAlert = false;
			$hasAlertMSG = '';
			//cập nhật commission vào trong order cho khách hàng
			if (isset($dOrder['status']) && ($dOrder['status'] == 0 or $dOrder['status'] == -2) && $dOrder['id_customer'] > 0) {
				//kiểm tra xem đơn hàng có coupon không
				$detail_order->set('order_id', $order_id);
				$check_coupon = $detail_order->check_exist_coupon($shop_id, $created_at);
				// nếu tồn tại thì kiểm tra
				if (isset($check_coupon['id']) && $check_coupon['id'] != '') {
					$ecoupon = new ecoupon();
					$ecoupon->set('id', $check_coupon['coupon_id']);
					$dCoupon = $ecoupon->get_detail();
					// nếu mã giảm theo chiết khấu hoặc loại giảm theo sản phẩm
					// thì cập nhật lại chiết khấu đơn hàng theo KH
					if ($dCoupon['by_type_price'] == 0 || $dCoupon['type'] == 3) {
						$detail_order->update_commission_for_customer($shop_id, $dOrder['id_customer'], $order_id, $created_at);
						// tính lại giá tiền mã giảm giá
						$detail_order->set('order_id', $order_id);
						$detail_order->set('id', $check_coupon['id']);
						$status_coupon = $detail_order->update_coupon_item($shop_id, $created_at, $dCoupon);
						// thông báo trạng thái coupoun
						if (isset($status_coupon['status'])) {
							$hasAlert = true;
							$hasAlertMSG = $status_coupon['msg'];
						}
					}
				} else {
					// nếu không có thì update lại bth
					$detail_order->update_commission_for_customer($shop_id, $dOrder['id_customer'], $order_id, $created_at);
				}
			}
			$dOrder 	= $order->get_detail($shop_id, $order_id, $created_at);
			$dOrder['listItems'] 	= $detail_order->listby_order($shop_id, $order_id, $created_at);

			// thông báo của khi áp dụng mã giảm giá
			$dOrder['hasAlert'] = array('status' => $hasAlert, 'msg' => $hasAlertMSG);

			return $dOrder;
		} else {
			return $detail_order_id;
		}
	}
	//thêm 1 coupon vào đơn hàng
	public function add_coupon_item($shop_id, $username, $order_id, $created_at, $dEcoupon, $ship_fee = 0)
	{
		global $shop, $order, $setup;

		$ecoupon_apply = new ecoupon_apply();
		$price = 0;
		$chiet_khau = 0;
		$gia_le = 0;
		$gia_le_item = 0;
		$gia_chiet_khau = 0;
		$total = 0;
		$list_order = $this->listby_order($shop_id, $order_id, $created_at);
		foreach ($list_order as $key => $val) {
			if ($val['coupon_id'] == 0) {
				$total = $val['price'] * $val['quantity'] * ((100 - $val['decrement']) / 100);
				$gia_le_item = $val['default_price'] * $val['quantity'];
				$gia_le += $gia_le_item;
				$chiet_khau += $gia_le_item - $total;
			}
		}
		//kiểm tra loại coupon
		if ($dEcoupon['type'] == '2' || $dEcoupon['type'] == '4') {
			//by_price_type 1||0 //0 là tính theo giá chiết khấu 1 là tính theo giá lẻ
			if ($dEcoupon['by_type_price'] == "1") {
				if ($gia_le >= $dEcoupon['is_total']) { //kiểm tra xem đơn hàng đã đạt giá trị tối thiểu để áp dụng coupon chưa
					if ($dEcoupon['value_type'] == "0") { //0 là % 1 là tiền
						$price = ($dEcoupon['value'] / 100) * $gia_le;
						if ($price > $dEcoupon['value_max']) { //nếu số tiền giảm giá lớn hơn giá trị max của đơn hàng thì lấy giá trị max
							$price = $dEcoupon['value_max'];
						}
					} else {
						$price = $dEcoupon['value'];
					}
				}
			} else {
				$gia_chiet_khau = $gia_le - $chiet_khau;
				if ($gia_chiet_khau >= $dEcoupon['is_total']) {
					if ($dEcoupon['value_type'] == "0") { //0 là % 1 là tiền
						$price = ($dEcoupon['value'] / 100) * $gia_chiet_khau;
						if ($price > $dEcoupon['value_max']) { //nếu số tiền giảm giá lớn hơn giá trị max của đơn hàng thì lấy giá trị max
							$price = $dEcoupon['value_max'];
						}
					} else {
						$price = $dEcoupon['value'];
					}
				}
			}
		} else if ($dEcoupon['type'] == '3') {
			if ($gia_le >= $dEcoupon['is_total']) { //kiểm tra xem đơn hàng có đạt giá trị tối thiểu không
				//truyền coupon_id qua để check sản phẩm
				$ecoupon_apply->set('ecoupon_id', $dEcoupon['id']);
				$lProductApply = $ecoupon_apply->check_product_order($list_order, $order_id, $shop_id);

				if ($dEcoupon['value_type'] == "0") {
					foreach ($lProductApply as $key => $item) {
						if ($dEcoupon['value'] > $item['decrement']) {
							$this->set('coupon_id', $dEcoupon['id']);
							$this->discount_percentItem($shop_id, $item['id'], 0, '', $created_at);
							$tien_sau_giam  = $item['price'] * $item['quantity'] * ((100 - $dEcoupon['value']) / 100);
							$tien_giam = ($item['price'] * $item['quantity']) - $tien_sau_giam;
							$price += $tien_giam;
						}
					}
					if ($price > $dEcoupon['value_max']) { //nếu số tiền giảm giá lớn hơn giá trị max thì lấy giá trị max
						$price = $dEcoupon['value_max'];
					}
				} else {
					foreach ($lProductApply as $key => $item) {
						$discount_percent = ($dEcoupon['value'] * 100) / ($item['price'] * $item['quantity']);
						if ($discount_percent > $item['decrement']) {
							$this->set('coupon_id', $dEcoupon['id']);
							$this->discount_percentItem($shop_id, $item['id'], 0, '', $created_at);
							// $tien_sau_giam  = $item['price'] * $item['quantity']*((100 - $discount_percent)/100);
							// $tien_giam = ($item['price']*$item['quantity']) - $tien_sau_giam;
						}
					}
					$price = $dEcoupon['value'];
				}
			}
		} else if ($dEcoupon['type'] == '1') { //free ship
			if ($dEcoupon['by_type_price'] == "1") {
				if ($gia_le >= $dEcoupon['is_total']) { //kiểm tra xem đơn hàng đã đạt giá trị tối thiểu để áp dụng coupon chưa
					if ($dEcoupon['value_type'] == "0") { //0 là % 1 là tiền
						$price = ($ship_fee * $dEcoupon['value']) / 100;
						if ($price > $dEcoupon['value_max']) { //nếu số tiền giảm giá lớn hơn giá trị max thì lấy giá trị max
							$price = $dEcoupon['value_max'];
						}
					} else {
						$price = $dEcoupon['value'];
					}
				}
			} else {
				$gia_chiet_khau = $gia_le - $chiet_khau;
				if ($gia_chiet_khau >= $dEcoupon['is_total']) {
					if ($dEcoupon['value_type'] == "0") { //0 là % 1 là tiền
						$price = ($ship_fee * $dEcoupon['value']) / 100;
						if ($price > $dEcoupon['value_max']) { //nếu số tiền giảm giá lớn hơn giá trị max thì lấy giá trị max
							$price = $dEcoupon['value_max'];
						}
					} else {
						$price = $dEcoupon['value'];
					}
				}
			}
		}


		$this->set('default_price', $price);


		$this->set('quantity', $dEcoupon['type'] == 4 ? 0 : -1);
		$this->set('decrement', 0);

		$this->set('price', $price + 0);
		$this->set('inverse', 1); //đơn vị xuất cho POS
		$this->set('expire_date', isset($dWhHis['expire_date']) ? $dWhHis['expire_date'] : 0);


		$this->set('order_id', $order_id);
		$this->set('product_id', isset($setup['pro_coupon_fee']) ? $setup['pro_coupon_fee'] : 0);
		$this->set('ratio_convert', 0);

		$this->set('sku_id', 0);


		$this->set('name', $dEcoupon['name']);

		$this->set('user_add', $username);
		$this->set('note', isset($dEcoupon['note']) ? $dEcoupon['note'] : '');

		$this->set('attribute_1', '0');
		$this->set('attribute_2', '0');
		$this->set('attribute_3', '0');
		$this->set('attribute_4', '0');
		$this->set('attribute_5', '0');
		$this->set('sku_name', '');

		$this->set('root_price', 0);
		$this->set('wh_history_id', '');
		$this->set('wh_history_return_id', 0);
		$this->set('is_coupon', $dEcoupon['type']);
		$this->set('coupon_id', $this->get('coupon_id'));

		$dOrder 	= $order->get_detail($shop_id, $order_id, $created_at);

		//chỉ cho phép insert khi status == 0 (order temp)
		if (isset($dOrder['status']) && ($dOrder['status'] == 0 or $dOrder['status'] == -2)) {
			// thêm sản mã giảm giá vào đơn hàng
			$detail_order_id = $this->add($shop_id, $created_at);
		}

		// trả lại thông tin đơn hàng
		$dOrder = $order->get_detail($shop_id, $order_id, $created_at);
		$dOrder['listItems'] 	= $this->listby_order($shop_id, $order_id, $created_at);

		return $dOrder;
	}

	//func update lại coupon trong đơn hàng khi update coupon
	public function update_coupon_item($shop_id, $created_at, $dEcoupon, $ship_fee = 0)
	{
		global $db;

		$order_id = $this->get('order_id');
		$id       = $this->get('id');

		$flag = false;
		$price = 0;
		$chiet_khau = 0;
		$gia_le = 0;
		$gia_le_item = 0;
		$gia_chiet_khau = 0;
		$total = 0;
		$list_order = $this->listby_order($shop_id, $order_id, $created_at);

		foreach ($list_order as $key => $val) {
			if ($val['is_coupon'] == 0) {
				$total = $val['price'] * $val['quantity'] * ((100 - $val['decrement']) / 100);
				$gia_le_item = $val['default_price'] * $val['quantity'];
				$gia_le += $gia_le_item;
				$chiet_khau += $gia_le_item - $total;
			}
		}
		//kiểm tra loại coupon
		if ($dEcoupon['type'] == '2' || $dEcoupon['type'] == '4') {
			//by_price_type 1||0 //0 là tính theo giá chiết khấu 1 là tính theo giá lẻ
			if ($dEcoupon['by_type_price'] == "1") {
				if ($gia_le >= $dEcoupon['is_total']) { //kiểm tra xem đơn hàng đã đạt giá trị tối thiểu để áp dụng coupon chưa
					if ($dEcoupon['value_type'] == "0") { //0 là % 1 là tiền
						$price = ($dEcoupon['value'] / 100) * $gia_le;
						if ($price > $dEcoupon['value_max']) { //nếu số tiền giảm giá lớn hơn giá trị max của đơn hàng thì lấy giá trị max
							$price = $dEcoupon['value_max'];
						}
					} else {
						$price = $dEcoupon['value'];
					}
				} else {
					$flag = true;
					//remove coupon đi vì không đạt giá trị tối thiểu
				}
			} else {
				$gia_chiet_khau = $gia_le - $chiet_khau;
				if ($gia_chiet_khau >= $dEcoupon['is_total']) {
					if ($dEcoupon['value_type'] == "0") { //0 là % 1 là tiền
						$price = ($dEcoupon['value'] / 100) * $gia_chiet_khau;
						if ($price > $dEcoupon['value_max']) { //nếu số tiền giảm giá lớn hơn giá trị max của đơn hàng thì lấy giá trị max
							$price = $dEcoupon['value_max'];
						}
					} else {
						$price = $dEcoupon['value'];
					}
				} else {
					$flag = true;
					//remove coupon đi vì không đạt giá trị tối thiểu
				}
			}
		} else if ($dEcoupon['type'] == '3') {
			if ($gia_le >= $dEcoupon['is_total']) { //kiểm tra xem đơn hàng có đạt giá trị tối thiểu không
				//truyền coupon_id qua để check sản phẩm
				$ecoupon_apply = new ecoupon_apply();
				$ecoupon_apply->set('ecoupon_id', $dEcoupon['id']);
				$lProductApply = $ecoupon_apply->check_product_order($list_order, $order_id, $shop_id);
				if (count($lProductApply) > 0) {
					if ($dEcoupon['value_type'] == '0') {
						foreach ($lProductApply as $key => $item) {
							$this->set('coupon_id', $dEcoupon['id']);
							$this->discount_percentItem($shop_id, $item['id'], 0, '', $created_at);
							$this->discount_priceItem($shop_id, $item['id'], $item['default_price'], '', $created_at);
							$tien_sau_giam  = $item['price'] * $item['quantity'] * ((100 - $dEcoupon['value']) / 100);
							$tien_giam = ($item['price'] * $item['quantity']) - $tien_sau_giam;
							$price += $tien_giam;
						}
						if ($price > $dEcoupon['value_max']) { //nếu số tiền giảm giá lớn hơn giá trị max thì lấy giá trị max
							$price = $dEcoupon['value_max'];
						}
					} else {
						foreach ($lProductApply as $key => $item) {
							$this->set('coupon_id', $dEcoupon['id']);
							$this->discount_percentItem($shop_id, $item['id'], 0, '', $created_at);
							$this->discount_priceItem($shop_id, $item['id'], $item['default_price'], '', $created_at);
						}
						$price = $dEcoupon['value'];
					}
				} else {
					$flag = true;
					//xóa coupon đi vì không có sản phẩm nào có thể áp dụng
				}
			} else {
				$flag = true;
				//xóa coupon vì không đạt giá trị tối thiểu
			}
		}
		if ($dEcoupon['type'] == '1') { //free ship
			if ($dEcoupon['by_type_price'] == "1") {
				if ($gia_le >= $dEcoupon['is_total']) { //kiểm tra xem đơn hàng đã đạt giá trị tối thiểu để áp dụng coupon chưa
					if ($dEcoupon['value_type'] == "0") { //0 là % 1 là tiền
						$price = ($ship_fee * $dEcoupon['value']) / 100;
						if ($price > $dEcoupon['value_max']) { //nếu số tiền giảm giá lớn hơn giá trị max thì lấy giá trị max
							$price = $dEcoupon['value_max'];
						}
					} else {
						$price = $dEcoupon['value'];
					}
				}
			} else {
				$gia_chiet_khau = $gia_le - $chiet_khau;
				if ($gia_chiet_khau >= $dEcoupon['is_total']) {
					if ($dEcoupon['value_type'] == "0") { //0 là % 1 là tiền
						$price = ($ship_fee * $dEcoupon['value']) / 100;
						if ($price > $dEcoupon['value_max']) { //nếu số tiền giảm giá lớn hơn giá trị max thì lấy giá trị max
							$price = $dEcoupon['value_max'];
						}
					} else {
						$price = $dEcoupon['value'];
					}
				}
			}
		}

		//xóa và update giá trị của coupon
		if ($flag == true) {
			$this->set('date_add', $created_at);
			$this->set('shop_id', $shop_id);
			$this->set('id', $id);
			//func xóa coupon
			$this->delete_item();
			// thông báo
			$kq['status'] = true;
			$kq['msg'] = 'Mã giảm giá đã được xóa do không đủ điều kiện sử dụng.';
			return $kq;
		} else {
			$this->set('default_price', $price + 0);
			$this->set('price', $price + 0);
			$this->set('root_price', $price + 0);
			$this->set('id', $id);
			//func update coupon
			$this->update_price_coupon($shop_id, $created_at);
			// nếu mã giảm theo sản phẩm thì sẽ thông báo thêm
			$msg_pro = '';
			if ($dEcoupon['type'] == '3') {
				$msg_pro = 'Đã xóa giảm giá của những sản phẩm được áp dụng. ';
			}
			// thông báo
			$kq['status'] = true;
			$kq['msg'] = $msg_pro . 'Cập nhật mã giảm giá thành công.';
			return $kq;
		}
	}

	public function add_product_item_client($shop_id, $username, $order_id, $created_at, $dProduct, $dSKU = '', $order_created_by = 0)
	{
		global $wh_history, $shop, $order, $detail_order, $product, $SKU, $setup;
		$members 				= new members();
		$product_price_detail 	= new product_price_detail();

		$dOrder 	= $order->get_detail($shop_id, $order_id, $created_at);

		//chỉ cho phép insert khi status == 0 (order temp)
		$detail_order_id = '';
		if (isset($dOrder['status']) && ($dOrder['status'] == 0 or $dOrder['status'] == -2)) {

			$quantity = isset($dProduct['quantity']) ? $dProduct['quantity'] : 1; //Nếu không được set thì mặc định là một

			//BEGIN lấy giá vốn của SKU và id phiếu nhập
			$root_price		 = '0';
			$wh_history_id = '0';
			$expire_date	 = '0';

			$dWhHis = $wh_history->get_fifo_row($dProduct['id'], isset($dSKU['id']) ? $dSKU['id'] : '0');
			if (isset($dWhHis['id'])) { //Lấy phiếu nhập liên quan nếu có
				$wh_history_id = $dWhHis['id'];
				$expire_date = $dWhHis['expire_date'];
			}

			if (isset($dProduct['allow_root_price']) && $dProduct['allow_root_price'] == 1) {
				$root_price = $dProduct['root_price']; //Cho phép lấy theo giá cài
			} else {
				if (isset($dWhHis['id'])) //Tính giá vốn theo giá xuất và theo đúng phiếu xuất
					$root_price = ($dWhHis['price'] / $dWhHis['ratio_convert']) * ((100 - $dWhHis['decrement']) / 100);
			}
			//END lấy giá vốn của SKU và id phiếu nhập

			$dShop = $shop->get_detail($shop_id);

			if (!isset($dSKU['id'])) {
				$unique_id = '';
				$detail_order->set('default_price', $dProduct['price']); // Giá mặc định là giá lẻ
			} else {
				$unique_id = $dSKU['unique_id'];
				$detail_order->set('default_price', isset($dSKU['price']) ? $dSKU['price'] : 0); //Giá mặc định là giá trong dSKU.price
			}

			if ($order_created_by > 0) {
				//order_created_by = members.user_id

				//Update đúng default price
				$members->set('user_id', $order_created_by);
				$dMember = $members->get_detail();

				if (isset($setup['enabled_apply_discount_on_price']) && $setup['enabled_apply_discount_on_price'] == 1) {
					//Cập nhật cho phép hay không cho phép áp dụng bảng giá theo nhóm khách hàng
					$product_price_detail->set('product_id', $dProduct['id']);
					$product_price_detail->set('unique_id', $unique_id);
					$product_price_detail->set('member_group_id', $dMember['member_group_id']);
					$dProPrice = $product_price_detail->get_detail_record();
					if (isset($dProPrice['product_id'])) {
						$detail_order->set('default_price', $dProPrice['value']); //Giá mặc định lúc này chính là giá xuất cho đối tượng này 
					}
				}
			}

			$price = $dProduct['price'] + 0; //Giá lấy trực tiếp khách nhập và thay đổi

			$detail_order->set('quantity', $quantity);
			$detail_order->set('decrement', $dProduct['decrement']);
			$detail_order->set('price', $price);

			if (isset($dProduct['sale_price']) && $dProduct['sale_price'] >= 0) {
				$detail_order->set('sale_price', $dProduct['sale_price']);
			}

			if (isset($dProduct['sale_decrement']) && $dProduct['sale_decrement'] >= 0) {
				$detail_order->set('sale_decrement', $dProduct['sale_decrement']);
			}

			$detail_order->set('inverse', 1); //đơn vị xuất cho POS
			$detail_order->set('expire_date', $expire_date);

			$detail_order->set('order_id', $order_id);
			$detail_order->set('product_id', $dProduct['id']);
			$detail_order->set('ratio_convert', $dProduct['ratio_convert']);

			if (isset($dSKU['id']))
				$detail_order->set('sku_id', $dSKU['id']);
			else
				$detail_order->set('sku_id', 0);

			if ($dProduct['multi_attribute'] == 1 && isset($dSKU['name']))
				$detail_order->set('name', $dProduct['name'] . ' (' . $dSKU['name'] . ')');
			else
				$detail_order->set('name', $dProduct['name']);

			$detail_order->set('user_add', $username);
			$detail_order->set('note', isset($dProduct['note']) ? $dProduct['note'] : '');
			// thêm thông tin is_coupon nếu là ecoupon
			$detail_order->set('is_coupon', isset($dProduct['is_coupon']) ? $dProduct['is_coupon'] : '0');
			$detail_order->set('coupon_id', isset($dProduct['coupon_id']) ? $dProduct['coupon_id'] : '0');

			$detail_order->set('attribute_1',  isset($dSKU['id']) ? $dSKU['attribute_1'] : '0');
			$detail_order->set('attribute_2',  isset($dSKU['id']) ? $dSKU['attribute_2'] : '0');
			$detail_order->set('attribute_3',  isset($dSKU['id']) ? $dSKU['attribute_3'] : '0');
			$detail_order->set('attribute_4',  isset($dSKU['id']) ? $dSKU['attribute_4'] : '0');
			$detail_order->set('attribute_5',  isset($dSKU['id']) ? $dSKU['attribute_5'] : '0');
			$detail_order->set('sku_name', 	   isset($dSKU['id']) ? $dSKU['name'] : '');

			$detail_order->set('root_price', $root_price);
			$detail_order->set('wh_history_id', $wh_history_id);
			$detail_order->set('wh_history_return_id', 0);

			$dExistPro = $detail_order->get_exist_product($shop_id, $created_at);
			if (empty($dExistPro['id']))
				$detail_order_id = $detail_order->add($shop_id, $created_at);
			else {
				$new_quantity = ($dExistPro['quantity'] + $quantity);
				$detail_order->set('note', $dExistPro['note']);
				$detail_order->update_quantity($shop_id, $dExistPro['id'], $new_quantity, $created_at);
				$detail_order_id = $dExistPro['id'];
			}

			// AnCode: Nếu là sản phẩm Combo thì thêm sản phẩm vào bảng order_detail_combo
			if ($dProduct['pro_type'] == 4) {
				// lấy list sản phẩm Combo của sản phẩm đó
				$product_combo = new product_combo();
				$product_combo->set('product_combo_id', $dProduct['id']);
				$lCombo = $product_combo->list_by_product_combo();
				// lấy từng sản phẩm trong combo thêm vào bảng order_detail_combo
				foreach ($lCombo as $key => $dCombo) {
					//thêm vào order_detail_combo 
					$order_detail_combo = new order_detail_combo();
					$order_detail_combo->set('product_combo_id', $dProduct['id']);
					$order_detail_combo->set('product_id', $dCombo['product_id']);
					$order_detail_combo->set('unique_id', $dCombo['unique_id']);
					$order_detail_combo->set('price_sale', $dCombo['price_sale']);
					$order_detail_combo->set('quantity', $dCombo['quantity']);
					$order_detail_combo->set('price', $dCombo['price']);
					$order_detail_combo->set('shop_id', $shop_id);
					$order_detail_combo->set('order_id', $order_id);
					$order_detail_combo->set('detail_order_id', $detail_order_id);
					$order_detail_combo->set('order_created_at', $detail_order_id);
					$order_detail_combo->set('wh_history_id', $wh_history_id);
					$order_detail_combo_id = $order_detail_combo->add();
				}
			}

			return $detail_order_id;
		} else {
			return false;
		}
	}

	// An(11/03/23) không sử dụng
	// public function add_product_coupon($shop_id, $order_id, $created_at)
	// {
	// 	global $shop, $order;

	// 	$price			   = $this->get('price');
	// 	$user_add		   = $this->get('user_add');
	// 	$product_id    = $this->get('product_id');
	// 	$quantity		   = $this->get('quantity');
	// 	$name			     = $this->get('name');
	// 	$note			     = $this->get('note');
	// 	$coupon_id     = $this->get('coupon_id');
	// 	$sku_id			   = 0;
	// 	$root_price    = 0;
	// 	$wh_history_id = 0;

	// 	$this->set('price', $price);
	// 	$this->set('user_add', $user_add);
	// 	$this->set('product_id', $product_id);
	// 	$this->set('quantity', $quantity);
	// 	$this->set('name', $name);
	// 	$this->set('note', $note);
	// 	$this->set('decrement', 0);
	// 	$this->set('is_coupon', 1);
	// 	$this->set('coupon_id', $coupon_id);
	// 	$this->set('inverse', 1); //đơn vị xuất cho POS
	// 	$this->set('expire_date', 0);
	// 	$detail_order_id = $this->add($shop_id, $created_at);

	// 	//Tạo phụ thu
	// 	$dShop = $shop->get_detail($shop_id);
	// 	$this->cal_surcharge($dShop, $order_id, $created_at);

	// 	$dOrder = $order->get_detail($shop_id, $order_id, $created_at);
	// 	//cập nhật commission vào trong order cho khách hàng
	// 	if (isset($dOrder['status']) && $dOrder['status'] == 0 && $dOrder['id_customer'] > 0) {
	// 		$this->update_commission_for_customer($shop_id, $dOrder['id_customer'], $order_id, $created_at);
	// 	}
	// 	unset($dOrder);
	// 	unset($dShop);

	// 	return $detail_order_id;
	// }

	public function add_product_service($shop_id, $order_id, $created_at)
	{
		global $shop, $order;


		$price			= $this->get('price');
		$user_add		= $this->get('user_add');
		$product_id		= $this->get('product_id');
		$sku_id			= 0;
		$quantity		= $this->get('quantity');
		$name			= $this->get('name');
		$note			= $this->get('note');
		$root_price		= 0;
		$wh_history_id	= 0;

		$this->set('price', $price);
		$this->set('user_add', $user_add);
		$this->set('product_id', $product_id);
		$this->set('quantity', $quantity);
		$this->set('name', $name);
		$this->set('note', $note);
		$this->set('decrement', 0);
		$this->set('inverse', 1); //đơn vị xuất cho POS
		$this->set('expire_date', 0);
		$detail_order_id = $this->add($shop_id, $created_at);

		//Tạo phụ thu
		$dShop = $shop->get_detail($shop_id);
		$this->cal_surcharge($dShop, $order_id, $created_at);

		$dOrder 	= $order->get_detail($shop_id, $order_id, $created_at);

		unset($dOrder);
		unset($dShop);

		return $detail_order_id;
	}

	public function devidend_service_fee($shop_id, $order_id, $created_at)
	{
		global $setup;
		$lItems   		= $this->listby_order_wallet_commission_for_client($shop_id, $order_id, $created_at);

		$package_fee_val 	  = 0;
		$ship_fee_val 		  = 0;
		$total_product 		  = 0;
		$discount_val 		  = 0;
		$coupon_fee_val = 0;
		foreach ($lItems as $sitdo) {

			if ($sitdo['product_id'] > 0 && $sitdo['product_id'] ==  $setup['pro_package_fee']) { //phí đóng gói
				$package_fee_val  += abs($sitdo['quantity'] * $sitdo['price']);
			} else if ($sitdo['product_id'] > 0 && $sitdo['product_id'] ==  $setup['pro_ship_fee']) {
				$ship_fee_val  += abs($sitdo['quantity'] * $sitdo['price']);
			} else if ($sitdo['product_id'] > 0 && $sitdo['product_id'] ==  $setup['voucher_free_ship_id']) {
				$discount_val  += ($sitdo['quantity'] * $sitdo['price']);
			} else if ($sitdo['product_id'] > 0 && $sitdo['product_id'] ==  $setup['pro_coupon_fee']) {
				$coupon_fee_val  += ($sitdo['quantity'] * $sitdo['price']);
			} else {
				if ($sitdo['product_id'] > 0)
					$total_product += ($sitdo['quantity'] * $sitdo['price']);
			}
		}

		return array(
			'package_fee'   => $package_fee_val,
			'ship_fee' 		=> $ship_fee_val,
			'discount' 		=> $discount_val,
			'total_product' => $total_product,
			'total_order'	=> $total_product + $ship_fee_val + $discount_val + $package_fee_val + $coupon_fee_val
		); //$ship_fee, $package_fee, $total_product, discount
	}

	public function get_and_sum_product_order($lItems)
	{ //hàm lấy tất cả sản phẩm tổng hợp để xuất excel (tùng code - 18/11/2021)
		global $db;

		$shop_id = '';
		$created_at = '';
		$order_id = '';

		foreach ($lItems as $key => $item) {
			$shop_id = $item['shop_id'];
			$created_at = $item['created_at'];
			$order_id .= "OR `order_id` = '" . $item['order_id'] . "'";
		}

		$order_id = substr($order_id, 2);

		$sql = "SELECT p.*, SUM(dt.`quantity`) quantity
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "` as dt 
				INNER JOIN " . $db->tbl_fix . "`product` p ON p.id = dt.product_id 
				WHERE p.`pro_type` = 0 AND ($order_id)
				GROUP BY dt.product_id";
		$result = $db->executeQuery_list($sql);

		return $result;
	}

	/**
	 * list_product_debt_showroom method get all products debt showroom.
	 * @author datdat.itsn02
	 * 
	 * @param  mixed $keyword : search by name and code of products
	 * @param  mixed $year : filter year of order
	 * @param  mixed $offset 
	 * @param  mixed $limit
	 * @return void
	 */
	public function list_product_debt_showroom($keyword, $year = '', $pro_ship_fee = '',  $offset = '', $limit = '')
	{
		//HC upgrade 210910
		global $db;

		if ($year == '') $year = date('Y');
		$shop_id 	= $this->get('shop_id');

		if ($limit != '') 	$limit 		= "LIMIT $offset, $limit ";
		if ($keyword != '')   $keyword 	= " AND (SKU.`code` = '$keyword' OR p.`name` LIKE '%$keyword%' )";

		/**
		 * quantity_paid: tổng đã trả
		 * quantity: Số lượng bán cho khách
		 * total_value: Giá trị theo giá lẻ
		 * total_real: Giá trị theo giá thực thu
		 * total_value_debt: Tổng giá trị nợ khách
		 * total_value_debt_root: Tổng giá vốn số lượng nợ khách
		 * quantity_debt: Số lượng còn nợ
		 */
		//, IFNULL(dt.`total_value_debt_root`, 0) total_value_debt_root
		$sql = "SELECT p.`id`, p.`id` product_id, p.`img_1` `image`, p.`price`, p.`name`, SKU.`code`, SKU.`id` sku_id
						, IFNULL(dt.`quantity_paid`, 0) quantity_paid
						, IFNULL(dt.`quantity`, 0) quantity
						, IFNULL(dt.`total_value`, 0) total_value
						, IFNULL(dt.`total_real`, 0) total_real
						, IFNULL(dt.`total_value_debt`, 0) total_value_debt
						, IFNULL(dt.`quantity_debt`, 0) quantity_debt
				FROM $db->tbl_fix`product` p 
				INNER JOIN $db->tbl_fix`SKU` ON p.`id` = SKU.`product_id`
				INNER JOIN (

					SELECT 	dt.`product_id`
							, dt.`sku_id`
							, SUM(dt.`quantity_paid`) quantity_paid
							, SUM(dt.`quantity`) quantity
							, SUM(dt.`quantity`*dt.`price`) total_value
							, SUM(dt.`quantity`*dt.`price`*( (100-dt.`decrement`)/100) ) total_real
							, SUM( (dt.`quantity` - dt.`quantity_paid`) * dt.`price`*( (100-dt.`decrement`)/100) ) total_value_debt
							, SUM( (dt.`quantity` - dt.`quantity_paid`) * dt.`root_price` ) total_value_debt_root
							, SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt

					FROM  $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` dt
					INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od ON od.id = dt.order_id
					INNER JOIN $db->tbl_fix`delivery` de ON de.order_id = od.id
					WHERE od.`status` = 1
					AND od.`order_type` = 7
					AND de.shipper_status = 6
					AND dt.`product_id` != '$pro_ship_fee'
					GROUP BY dt.product_id , dt.sku_id

				) dt ON SKU.product_id = dt.product_id AND SKU.id = dt.sku_id
				WHERE
				p.deleted = 0
				AND SKU.deleted = 0
				$keyword
				$limit";
		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function list_product_debt($keyword, $year = '', $field = '', $sort = '',  $offset = '', $limit = '')
	{ //hàm lấy tất cả sản phẩm còn nợ (tùng code - 27/07/2021)
		//HC upgrade 210910
		global $db;

		if ($year == '') $year = date('Y');
		$shop_id 	= $this->get('shop_id');

		$sortFieldArr = array(
			'name'  				=> 'p.`name`',
			'quantity_debt'  		=> 'dt.`quantity_debt`',
			'total_value_debt'  	=> 'dt.`total_value_debt`',
			// 'total_value_debt_root' => 'dt.`total_value_debt_root`',
		);

		$field = isset($sortFieldArr[$field]) ? $sortFieldArr[$field] : ''; //kiểm tra xem có ko
		if ($field != '') {
			$sqlSort = " ORDER BY " . $field . " $sort ";
		} else { //ko có thì mặc định
			$sqlSort = " ORDER BY dt.`quantity_debt` DESC ";
		}

		if ($limit != '') 	$limit 		= "LIMIT $offset, $limit ";
		if ($keyword != '')   $keyword 	= " AND (SKU.`code` LIKE '%$keyword%' OR p.`name` LIKE '%$keyword%' )";

		/**
		 * quantity_paid: tổng đã trả
		 * quantity: Số lượng bán cho khách
		 * total_value: Giá trị theo giá lẻ
		 * total_real: Giá trị theo giá thực thu
		 * total_value_debt: Tổng giá trị nợ khách
		 * total_value_debt_root: Tổng giá vốn số lượng nợ khách
		 * quantity_debt: Số lượng còn nợ
		 */
		//, IFNULL(dt.`total_value_debt_root`, 0) total_value_debt_root
		$sql = "SELECT p.`id`, p.`id` product_id, p.`img_1` `image`, p.`price`, p.`name`, SKU.`code`, SKU.`id` sku_id
						, IFNULL(dt.`quantity_paid`, 0) quantity_paid
						, IFNULL(dt.`quantity`, 0) quantity
						, IFNULL(dt.`total_value`, 0) total_value
						, IFNULL(dt.`total_real`, 0) total_real
						, IFNULL(dt.`total_value_debt`, 0) total_value_debt
						, IFNULL(dt.`quantity_debt`, 0) quantity_debt
				FROM $db->tbl_fix`product` p 
				INNER JOIN $db->tbl_fix`SKU` ON p.`id` = SKU.`product_id`
				LEFT JOIN (

					SELECT 	dt.`product_id`
							, dt.`sku_id`
							, SUM(dt.`quantity_paid`) quantity_paid
							, SUM(dt.`quantity`) quantity
							, SUM(dt.`quantity`*dt.`price`) total_value
							, SUM(dt.`quantity`*dt.`price`*( (100-dt.`decrement`)/100) ) total_real
							, SUM( (dt.`quantity` - dt.`quantity_paid`) * dt.`price`*( (100-dt.`decrement`)/100) ) total_value_debt
							, SUM( (dt.`quantity` - dt.`quantity_paid`) * dt.`root_price` ) total_value_debt_root
							, SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt

					FROM  $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` dt
					INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od ON od.id = dt.order_id
					WHERE od.`status` = 1
					AND od.`order_type` = 0
					AND (dt.`quantity` - dt.`quantity_paid`) > 0
					GROUP BY dt.product_id , dt.sku_id

				) dt ON SKU.product_id = dt.product_id AND SKU.id = dt.sku_id
				WHERE
				p.deleted = 0
				AND SKU.deleted = 0
				AND p.`shop_id` = '$shop_id' 
				$keyword
				$sqlSort
				$limit";

		$r = $db->executeQuery_list($sql);

		return $r;
	}

	public function list_product_debt_info($keyword, $year = '')
	{ 	//hàm lấy tất cả sản phẩm còn nợ (tùng code - 27/07/2021)
		//HC upgrade 210910
		global $db;

		if ($year == '') $year = date('Y');
		$shop_id 	= $this->get('shop_id');

		if ($keyword != '')   $keyword 	= " AND (SKU.`code` LIKE '%$keyword%' OR p.`name` LIKE '%$keyword%' )";

		//, SUM(IFNULL(dt.`total_value_debt_root`, 0)) total_value_debt_root
		$sql = "SELECT COUNT(*) total_record
						, SUM(IFNULL(dt.`quantity_paid`, 0)) quantity_paid
						, SUM(IFNULL(dt.`quantity`, 0)) quantity_sell
						, SUM(IFNULL(dt.`total_value`, 0)) total_value
						, SUM(IFNULL(dt.`total_real`, 0)) total_real
						, SUM(IFNULL(dt.`total_value_debt`, 0)) total_value_debt
						, SUM(IFNULL(dt.`quantity_debt`, 0)) quantity_debt
				FROM $db->tbl_fix`product` p 
				INNER JOIN $db->tbl_fix`SKU` ON p.`id` = SKU.`product_id`
				LEFT JOIN (

					SELECT 	dt.`product_id`
							, dt.`sku_id`
							, SUM(dt.`quantity_paid`) quantity_paid
							, SUM(dt.`quantity`) quantity
							, SUM(dt.`quantity`*dt.`price`) total_value
							, SUM(dt.`quantity`*dt.`price`*( (100-dt.`decrement`)/100) ) total_real
							, SUM((dt.`quantity` - dt.`quantity_paid`) * dt.`price`*( (100-dt.`decrement`)/100) ) total_value_debt
							, SUM((dt.`quantity` - dt.`quantity_paid`) * dt.`root_price` ) total_value_debt_root
							, SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt

					FROM  $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` dt
					INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od ON od.id = dt.order_id
					WHERE od.`status` = 1
					AND od.`order_type` = 0
					AND (dt.`quantity` - dt.`quantity_paid`) > 0
					GROUP BY dt.product_id , dt.sku_id

				) dt ON SKU.product_id = dt.product_id AND SKU.id = dt.sku_id
				WHERE 
				p.deleted = 0
				AND SKU.deleted = 0
				AND p.`shop_id` = '$shop_id' 
				$keyword ";

		$r = $db->executeQuery($sql, 1);

		/**
		 * total_record: tổng số sản phẩm
		 * quantity_paid: tổng số đã trả
		 * quantity_sell: tổng số đã bán
		 * total_value: Tổng theo giá lẻ
		 * total_real: Thực thu
		 * total_value_debt: Giá trị nợ khách
		 * total_value_debt_root: Giá trị vốn nợ
		 * quantity_debt: Số lượng nợ
		 */

		return array(
			'total_record' 	=> isset($r['total_record']) ? $r['total_record'] : 0,
			'quantity_paid' => isset($r['quantity_paid']) ? $r['quantity_paid'] : 0,
			'quantity_sell' => isset($r['quantity_sell']) ? $r['quantity_sell'] : 0,
			'total_value' 	=> isset($r['total_value']) ? $r['total_value'] : 0,
			'total_real' 	=> isset($r['total_real']) ? $r['total_real'] : 0,
			'total_value_debt' 	=> isset($r['total_value_debt']) ? $r['total_value_debt'] : 0,
			'total_value_debt_root' 	=> isset($r['total_value_debt_root']) ? $r['total_value_debt_root'] : 0,
			'quantity_debt' => isset($r['quantity_debt']) ? $r['quantity_debt'] : 0
		);
	}

	public function list_item_need_paid_by_client($client_id, $year = '')
	{ 	//List item detail_order chưa trả nợ
		//HC: 210910
		global $db;
		if ($year ==  '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');
		$product_id 	= $this->get('product_id');
		$sku_id 		= $this->get('sku_id');

		$sql = "SELECT dt.`name`, dt.`id` detail_order_id, dt.`product_id`, dt.`sku_id`, dt.`quantity`, dt.`quantity_paid`, ( dt.`quantity` - dt.`quantity_paid`)  quantity_debt
				FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` as dt 
				INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . $year . "` as od ON od.`id` = dt.`order_id`
				WHERE 
				dt.`quantity_paid` < dt.`quantity`
				AND od.`status` = 1
				AND od.`order_type` = 0
				AND dt.`product_id` = '$product_id'
				AND dt.`sku_id` = '$sku_id'
				AND od.`id_customer` = '$client_id'
				ORDER BY od.`created_at` ASC";

		$r = $db->executeQuery_list($sql);

		return $r;
	}

	public function list_order_by_product($keyword = '', $year = '', $offset = '', $limit = '')
	{ //hàm lấy tất cả order theo sản phẩm còn nợ (tùng code - 06/08/2021)
		global $db;
		if ($year == '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');
		$product_id 	= $this->get('product_id');
		$sku_id 		= $this->get('sku_id');

		if ($keyword != '') $keyword 	= " AND (
												mb.`code` LIKE '%$keyword%' 
												OR mb.`fullname` LIKE '%$keyword%'
												OR mb.`mobile` LIKE '%$keyword%'
											)";

		if ($limit != '') $limit 		= "LIMIT $offset, $limit ";
		/**
		 * quantity_paid: tổng đã trả
		 * quantity: Số lượng bán cho khách
		 * total_value: Giá trị theo giá lẻ
		 * total_real: Giá trị theo giá thực thu
		 * total_value_debt: Tổng giá trị nợ khách
		 * total_value_debt_root: Tổng giá vốn số lượng nợ khách
		 * quantity_debt: Số lượng còn nợ
		 */

		$sql = "SELECT * 
				FROM
				(
					SELECT 	IFNULL( `mb`.fullname, 'Vãng lai' ) fullname
							, IFNULL( `mb`.code, '-' ) code
							, IFNULL( `mb`.mobile, '-' ) mobile 
							, IFNULL( `mb`.`user_id`, '0' ) client_id 

							, SUM(dt.`quantity_paid`) quantity_paid
							, SUM(dt.`quantity`) quantity
							, SUM(dt.`quantity`*dt.`price`) total_value
							, SUM(dt.`quantity`*dt.`price`*( (100-dt.`decrement`)/100) ) total_real
							, SUM((dt.`quantity` - dt.`quantity_paid`) * dt.`price`*( (100-dt.`decrement`)/100) ) total_value_debt
							, SUM((dt.`quantity` - dt.`quantity_paid`) * dt.`root_price` ) total_value_debt_root
							, SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt

					FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` as dt 
					INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . $year . "` as od ON od.`id` = dt.`order_id`
					LEFT JOIN $db->tbl_fix`members` as mb ON mb.`user_id` = od.`id_customer`
					WHERE 
					dt.`quantity_paid` < dt.`quantity`
					AND od.`status` = 1
					AND od.`order_type` = 0
					AND dt.`product_id` = '$product_id'
					AND dt.`sku_id` = '$sku_id'
					$keyword
					GROUP BY od.`id_customer`

				) nTB
				ORDER BY nTB.`quantity_debt` DESC
				$limit";

		$r = $db->executeQuery_list($sql);

		return $r;
	}

	public function list_order_by_product_count($keyword = '', $year = '')
	{ //hàm lấy tất cả order theo sản phẩm còn nợ (tùng code - 06/08/2021)
		//HC: 210910 upgrade
		global $db;
		if ($year == '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');
		$product_id 	= $this->get('product_id');
		$sku_id 		= $this->get('sku_id');

		if ($keyword != '') $keyword 	= " AND (
												mb.`code` LIKE '%$keyword%' 
												OR mb.`fullname` LIKE '%$keyword%'
												OR mb.`mobile` LIKE '%$keyword%'
											)";

		$sql = "SELECT COUNT(*) total
				FROM (
					SELECT od.`id_customer`
					FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . $year . "` as dt 
					INNER JOIN " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as od ON od.`id` = dt.`order_id`
					LEFT JOIN " . $db->tbl_fix . "`members` as mb ON mb.`user_id` = od.`id_customer`
					WHERE 
					dt.`quantity_paid` < dt.`quantity`
					AND od.`status` = 1
					AND od.`order_type` = 0
					AND dt.`product_id` = '$product_id'
					AND dt.`sku_id` = '$sku_id'
					$keyword
					GROUP BY od.`id_customer`
				) nTB ";

		$r = $db->executeQuery($sql, 1);

		return $r['total'] + 0;
	}


	/**
	 * list_order_by_product_showroom method get all showroom have order debt
	 *
	 * @param  mixed $keyword : search by name and code of products
	 * @param  mixed $year : filter year of order
	 * @param  mixed $offset
	 * @param  mixed $limit
	 * @return void
	 */
	public function list_order_by_product_showroom($keyword = '', $year = '', $offset = '', $limit = '')
	{ //hàm lấy tất cả order theo sản phẩm còn nợ của showroom (Datdat code - 13/12/2022)
		global $db;
		if ($year == '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');
		$product_id 	= $this->get('product_id');
		$sku_id 		= $this->get('sku_id');

		if ($keyword != '') $keyword 	= " AND (
												nTB.`order_id` = '$keyword'  
											)";

		if ($limit != '') $limit 		= "LIMIT $offset, $limit ";


		$sql = "SELECT * 
		 FROM
		 (
			 SELECT IFNULL(desr.`showroom_id`, '0') showroom_id
					 , IFNULL(desr.`showroom_name`, '-') showroom_name
					 , IFNULL(desr.`showroom_mobile`, '-') showroom_mobile
					 , IFNULL(desr.`showroom_address`, '-') showroom_address
					 , nTB.`value_debt`
					 , nTB.`quantity_debt`
					 , nTB.`order_id`
			 FROM (
				 SELECT SUM( (dt.`quantity` - dt.`quantity_paid`)*dt.`price`*( (100 - dt.`decrement`)/100 ) ) value_debt
				 , SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt
				 , od.`id` order_id
				 FROM $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od 
				 INNER JOIN $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` dt ON od.`id` = dt.`order_id`
				 WHERE od.`status` = 1
				 AND od.`order_type` = 7
				 AND dt.`product_id` = $product_id
				 AND dt.`sku_id` = $sku_id
				 GROUP BY od.`id`
			 ) nTB
			 LEFT JOIN (
				 SELECT 
					 de.`shipper_status` shipper_status,
					 de.`order_id`,
					 sr.`id` showroom_id,
					 sr.`name` showroom_name,
					 sr.`mobile` showroom_mobile,
					 sr.`address` showroom_address
				 FROM $db->tbl_fix`delivery` de
				 INNER JOIN $db->tbl_fix`showroom` sr ON de.`showroom_id` = sr.`id`
			 ) desr ON nTB.`order_id` = desr.`order_id`
			 WHERE desr.`shipper_status` = 6
			 $keyword
		 ) nTB
		 ORDER BY nTB.`value_debt` DESC
		 $limit";
		$result = $db->executeQuery_list($sql);

		return $result;
	}

	/**
	 * list_order_by_product_showroom_count method count total products of order debt showroom
	 *
	 * @param  mixed $keyword : search by name and code of products
	 * @param  mixed $year : filter year of order
	 * @return void
	 */
	public function list_order_by_product_showroom_count($keyword = '', $year = '')
	{
		global $db;
		if ($year == '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');
		$product_id 	= $this->get('product_id');
		$sku_id 		= $this->get('sku_id');

		if ($keyword != '') $keyword 	= " AND (
			nTB.`order_id` = '$keyword'  
		)";

		$sql = "SELECT COUNT(*) total 
		FROM
		(
			SELECT IFNULL(desr.`showroom_id`, '0') showroom_id
					, IFNULL(desr.`showroom_name`, '-') showroom_name
					, IFNULL(desr.`showroom_mobile`, '-') showroom_mobile
					, IFNULL(desr.`showroom_address`, '-') showroom_address
					, nTB.`value_debt`
					, nTB.`quantity_debt`
					, nTB.`order_id`
			FROM (
				SELECT SUM( (dt.`quantity` - dt.`quantity_paid`)*dt.`price`*( (100 - dt.`decrement`)/100 ) ) value_debt
				, SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt
				, od.`id` order_id
				FROM $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od 
				INNER JOIN $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` dt ON od.`id` = dt.`order_id`
				WHERE od.`status` = 1
				AND od.`order_type` = 7
				AND dt.`product_id` = $product_id
				AND dt.`sku_id` = $sku_id
				GROUP BY od.`id`
			) nTB
			LEFT JOIN (
				SELECT 
					de.`shipper_status` shipper_status,
					de.`order_id`,
					sr.`id` showroom_id,
					sr.`name` showroom_name,
					sr.`mobile` showroom_mobile,
					sr.`address` showroom_address
				FROM $db->tbl_fix`delivery` de
				INNER JOIN $db->tbl_fix`showroom` sr ON de.`showroom_id` = sr.`id`
			) desr ON nTB.`order_id` = desr.`order_id`
			WHERE desr.`shipper_status` = 6
			$keyword
		) nTB
		ORDER BY nTB.`value_debt` DESC";
		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}
	public function list_showroom_debt($keyword, $year = '', $field = '', $sort = '',  $offset = '', $limit = '')
	{ //hàm lấy tất cả sản phẩm còn nợ (tùng code - 27/07/2021)
		//HC upgrade 210910
		global $db;

		if ($year == '') $year = date('Y');
		$shop_id 	= $this->get('shop_id');

		$sortFieldArr = array(
			'name'  				=> 'p.`name`',
			'quantity_debt'  		=> 'dt.`quantity_debt`',
			'total_value_debt'  	=> 'dt.`total_value_debt`',
			// 'total_value_debt_root' => 'dt.`total_value_debt_root`',
		);

		$field = isset($sortFieldArr[$field]) ? $sortFieldArr[$field] : ''; //kiểm tra xem có ko
		if ($field != '') {
			$sqlSort = " ORDER BY " . $field . " $sort ";
		} else { //ko có thì mặc định
			$sqlSort = " ORDER BY dt.`quantity_debt` DESC ";
		}

		if ($limit != '') 	$limit 		= "LIMIT $offset, $limit ";
		if ($keyword != '')   $keyword 	= " AND (SKU.`code` LIKE '%$keyword%' OR p.`name` LIKE '%$keyword%' )";

		/**
		 * quantity_paid: tổng đã trả
		 * quantity: Số lượng bán cho khách
		 * total_value: Giá trị theo giá lẻ
		 * total_real: Giá trị theo giá thực thu
		 * total_value_debt: Tổng giá trị nợ khách
		 * total_value_debt_root: Tổng giá vốn số lượng nợ khách
		 * quantity_debt: Số lượng còn nợ
		 */
		//, IFNULL(dt.`total_value_debt_root`, 0) total_value_debt_root
		$sql = "SELECT p.`id`, p.`id` product_id, p.`img_1` `image`, p.`price`, p.`name`, SKU.`code`, SKU.`id` sku_id
						, dt.`order_type`
						, IFNULL(dt.`quantity_paid`, 0) quantity_paid
						, IFNULL(dt.`quantity`, 0) quantity
						, IFNULL(dt.`total_value`, 0) total_value
						, IFNULL(dt.`total_real`, 0) total_real
						, IFNULL(dt.`total_value_debt`, 0) total_value_debt
						, IFNULL(dt.`quantity_debt`, 0) quantity_debt
				FROM $db->tbl_fix`product` p 
				INNER JOIN $db->tbl_fix`SKU` ON p.`id` = SKU.`product_id`
				LEFT JOIN (

					SELECT 	dt.`product_id`
							, dt.`sku_id`
							, od.`order_type`
							, SUM(dt.`quantity_paid`) quantity_paid
							, SUM(dt.`quantity`) quantity
							, SUM(dt.`quantity`*dt.`price`) total_value
							, SUM(dt.`quantity`*dt.`price`*( (100-dt.`decrement`)/100) ) total_real
							, SUM( (dt.`quantity` - dt.`quantity_paid`) * dt.`price`*( (100-dt.`decrement`)/100) ) total_value_debt
							, SUM( (dt.`quantity` - dt.`quantity_paid`) * dt.`root_price` ) total_value_debt_root
							, SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt

					FROM  $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` dt
					INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od ON od.id = dt.order_id
					WHERE od.`status` = 1
					AND od.`order_type` = 7
					AND (dt.`quantity` - dt.`quantity_paid`) > 0
					GROUP BY dt.product_id , dt.sku_id

				) dt ON SKU.product_id = dt.product_id AND SKU.id = dt.sku_id
				WHERE
				p.deleted = 0
				AND dt.`order_type` = 7
				AND SKU.deleted = 0
				AND p.`shop_id` = '$shop_id' 
				$keyword
				$sqlSort
				$limit";

		$r = $db->executeQuery_list($sql);

		return $r;
	}

	public function list_showroom_debt_info($keyword, $year = '')
	{ 	//hàm lấy tất cả sản phẩm còn nợ (tùng code - 27/07/2021)
		//HC upgrade 210910
		global $db;

		if ($year == '') $year = date('Y');
		$shop_id 	= $this->get('shop_id');

		if ($keyword != '')   $keyword 	= " AND (SKU.`code` LIKE '%$keyword%' OR p.`name` LIKE '%$keyword%' )";

		//, SUM(IFNULL(dt.`total_value_debt_root`, 0)) total_value_debt_root
		$sql = "SELECT COUNT(*) total_record
						, dt.`order_type`
						, SUM(IFNULL(dt.`quantity_paid`, 0)) quantity_paid
						, SUM(IFNULL(dt.`quantity`, 0)) quantity_sell
						, SUM(IFNULL(dt.`total_value`, 0)) total_value
						, SUM(IFNULL(dt.`total_real`, 0)) total_real
						, SUM(IFNULL(dt.`total_value_debt`, 0)) total_value_debt
						, SUM(IFNULL(dt.`quantity_debt`, 0)) quantity_debt
				FROM $db->tbl_fix`product` p 
				INNER JOIN $db->tbl_fix`SKU` ON p.`id` = SKU.`product_id`
				LEFT JOIN (

					SELECT 	dt.`product_id`
							, dt.`sku_id`
							, od.`order_type`
							, SUM(dt.`quantity_paid`) quantity_paid
							, SUM(dt.`quantity`) quantity
							, SUM(dt.`quantity`*dt.`price`) total_value
							, SUM(dt.`quantity`*dt.`price`*( (100-dt.`decrement`)/100) ) total_real
							, SUM((dt.`quantity` - dt.`quantity_paid`) * dt.`price`*( (100-dt.`decrement`)/100) ) total_value_debt
							, SUM((dt.`quantity` - dt.`quantity_paid`) * dt.`root_price` ) total_value_debt_root
							, SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt

					FROM  $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` dt
					INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od ON od.id = dt.order_id
					WHERE od.`status` = 1
					AND od.`order_type` = 7
					AND (dt.`quantity` - dt.`quantity_paid`) > 0
					GROUP BY dt.product_id , dt.sku_id

				) dt ON SKU.product_id = dt.product_id AND SKU.id = dt.sku_id
				WHERE 
				p.deleted = 0
				AND dt.`order_type` = 7
				AND SKU.deleted = 0
				AND p.`shop_id` = '$shop_id' 
				$keyword ";

		$r = $db->executeQuery($sql, 1);

		/**
		 * total_record: tổng số sản phẩm
		 * quantity_paid: tổng số đã trả
		 * quantity_sell: tổng số đã bán
		 * total_value: Tổng theo giá lẻ
		 * total_real: Thực thu
		 * total_value_debt: Giá trị nợ khách
		 * total_value_debt_root: Giá trị vốn nợ
		 * quantity_debt: Số lượng nợ
		 */

		return array(
			'total_record' 	=> isset($r['total_record']) ? $r['total_record'] : 0,
			'quantity_paid' => isset($r['quantity_paid']) ? $r['quantity_paid'] : 0,
			'quantity_sell' => isset($r['quantity_sell']) ? $r['quantity_sell'] : 0,
			'total_value' 	=> isset($r['total_value']) ? $r['total_value'] : 0,
			'total_real' 	=> isset($r['total_real']) ? $r['total_real'] : 0,
			'total_value_debt' 	=> isset($r['total_value_debt']) ? $r['total_value_debt'] : 0,
			'total_value_debt_root' 	=> isset($r['total_value_debt_root']) ? $r['total_value_debt_root'] : 0,
			'quantity_debt' => isset($r['quantity_debt']) ? $r['quantity_debt'] : 0
		);
	}

	/**
	 * list_debt_by_showroom method get all showroom have order debt
	 * @author datdat.itsn02
	 * 
	 * @param  mixed $keyword        : keyword search order id
	 * @param  mixed $year           : filter year of order
	 * @param  mixed $showroom_id
	 * @param  mixed $pro_ship_fee   : id of ship fee product
	 * @param  mixed $offset
	 * @param  mixed $limit
	 * @return void
	 */
	public function list_debt_by_showroom($keyword = '', $year = '', $showroom_id = '', $pro_ship_fee = '', $offset = '', $limit = '')
	{
		global $db;
		if ($year == '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');

		if ($keyword != '') $keyword 	= " AND (
												desr.`order_id` = '$keyword' 
											)";

		if ($showroom_id != '') $showroom_id 	= " AND (
														desr.`showroom_id` = '$showroom_id' 
													)";

		if ($limit != '') $limit 		= "LIMIT $offset, $limit ";

		$sql = "SELECT * 
				FROM
				(
					SELECT IFNULL(desr.`showroom_id`, '0') showroom_id
							, IFNULL(desr.`showroom_name`, '-') showroom_name
							, IFNULL(desr.`showroom_mobile`, '-') showroom_mobile
							, IFNULL(desr.`showroom_address`, '-') showroom_address
							, nTB.`value_debt`
							, nTB.`quantity_debt`
							, nTB.`order_id`
					FROM (
						SELECT SUM( (dt.`quantity` - dt.`quantity_paid`)*dt.`price`*( (100 - dt.`decrement`)/100 ) ) value_debt
						, SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt
						, od.`id` order_id
						FROM $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od 
						INNER JOIN $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` dt ON od.`id` = dt.`order_id`
						WHERE od.`status` = 1
						AND od.`order_type` = 7
						AND dt.`product_id` != '$pro_ship_fee'
						GROUP BY od.`id`
					) nTB
					LEFT JOIN (
						SELECT 
							de.`shipper_status` shipper_status,
							de.`order_id`,
							sr.`id` showroom_id,
							sr.`name` showroom_name,
							sr.`mobile` showroom_mobile,
							sr.`address` showroom_address
						FROM $db->tbl_fix`delivery` de
						INNER JOIN $db->tbl_fix`showroom` sr ON de.`showroom_id` = sr.`id`
					) desr ON nTB.`order_id` = desr.`order_id`
					WHERE desr.`shipper_status` = 6
					$keyword
					$showroom_id
				) nTB
				ORDER BY nTB.`value_debt` DESC
				$limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}
	/**
	 * list_debt_by_showroom_count get total record, total quantity, total value of order debt showroom
	 * @author datdat.itsn02
	 * 
	 * @param  mixed $keyword       : keyword search order id
	 * @param  mixed $year          : filter year of order
	 * @param  mixed $showroom_id   
	 * @param  mixed $pro_ship_fee  : id of ship fee product
	 * @return void
	 */
	public function list_debt_by_showroom_count($keyword = '', $year = '', $showroom_id = '', $pro_ship_fee = '')
	{
		global $db;
		if ($year == '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');

		if ($keyword != '') $keyword 	= " AND (
												desr.`order_id` = '$keyword'
											)";
		if ($showroom_id != '') $showroom_id 	= " AND (
														desr.`showroom_id`='$showroom_id'
												)";

		$sql = "SELECT COUNT(*) total_record
						, SUM(nTB.`quantity_debt`) quantity_debt
						, SUM(nTB.`value_debt`) value_debt
				FROM
				(
					SELECT SUM(nTB.`quantity_debt`) quantity_debt
							, SUM(nTB.`value_debt`) value_debt
					FROM (
						SELECT SUM( (dt.`quantity` - dt.`quantity_paid`)*dt.`price`*( (100 - dt.`decrement`)/100 ) ) value_debt
						, SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt
						, od.`id` order_id
						FROM $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od 
						INNER JOIN $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` dt ON od.`id` = dt.`order_id`
						WHERE dt.`quantity_paid` < dt.`quantity`
						AND od.`status` = 1
						AND od.`order_type` = 7
						AND dt.`product_id` != '$pro_ship_fee'
						GROUP BY order_id 
					) nTB
					LEFT JOIN (
						SELECT 
						de.`shipper_status` shipper_status,
							de.`order_id` order_id,
							sr.`id` showroom_id,
							sr.`name` showroom_name,
							sr.`mobile` showroom_mobile
						FROM $db->tbl_fix`delivery` de
						INNER JOIN $db->tbl_fix`showroom` sr ON de.`showroom_id` = sr.`id`
					) desr ON nTB.`order_id` = desr.`order_id`
					WHERE nTB.quantity_debt > 0
					AND desr.`shipper_status` = 6
					$keyword
					$showroom_id
					GROUP BY desr.`showroom_id`
				) nTB";
		$result = $db->executeQuery($sql, 1);

		return array(
			'total_record' => isset($result['total_record']) ? $result['total_record'] : 0,
			'quantity_debt' => isset($result['quantity_debt']) ? $result['quantity_debt'] : 0,
			'value_debt' => isset($result['value_debt']) ? $result['value_debt'] : 0,
		);
	}
	/**
	 * list_debt_by_product_count: get total/value of products debt showroom
	 * @author datdat.itsn02
	 * 
	 * @param  mixed $keyword             : keyword search Id of product
	 * @param  mixed $year                : year of order
	 * @param  mixed $pro_ship_fee        : id of ship fee product
	 * @return void
	 */
	public function list_debt_by_product_count($keyword = '', $year = '', $pro_ship_fee = '')
	{
		global $db;
		if ($year == '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');

		if ($keyword != '')   $keyword 	= " AND (SKU.`code` = '$keyword' OR p.`name` LIKE '%$keyword%' )";

		$sql = "SELECT COUNT(*) total_record
						, SUM(nTB.`quantity_debt`) quantity_debt
						, SUM(nTB.`value_debt`) value_debt
				FROM
				(
					SELECT nPro.`quantity_debt`
							, nPro.`value_debt`
					FROM $db->tbl_fix`product` p
					INNER JOIN $db->tbl_fix`SKU` ON p.`id` = SKU.`product_id`
					INNER JOIN
					(
						SELECT SUM( (dt.`quantity` - dt.`quantity_paid`)*dt.`price`*( (100 - dt.`decrement`)/100 ) ) value_debt
						, SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt
						, od.`id` order_id
						, dt.`product_id` product_id
						, dt.`sku_id` sku_id
						FROM $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od 
						INNER JOIN $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` dt ON od.`id` = dt.`order_id`
						INNER JOIN $db->tbl_fix`delivery` de ON de.`order_id` = od.`id`
						WHERE  od.`status` = 1
						AND od.`order_type` = 7
						AND de.`shipper_status` = 6
						AND dt.`product_id` != '$pro_ship_fee'
						GROUP BY product_id, sku_id
					) nPro
					ON SKU.product_id = nPro.product_id 
					AND SKU.id = nPro.sku_id
					WHERE
					p.deleted = 0
					AND SKU.deleted = 0
					$keyword
				) nTB";
		$result = $db->executeQuery($sql, 1);

		return array(
			'total_record' => isset($result['total_record']) ? $result['total_record'] : 0,
			'quantity_debt' => isset($result['quantity_debt']) ? $result['quantity_debt'] : 0,
			'value_debt' => isset($result['value_debt']) ? $result['value_debt'] : 0,
		);
	}

	public function list_debt_by_member($keyword = '', $year = '', $offset = '', $limit = '')
	{ 	//Load danh sách thành viên còn hàng nợ
		global $db;
		if ($year == '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');

		if ($keyword != '') $keyword 	= " AND (
												mb.`name` LIKE '%$keyword%' 
												OR mb.`fullname` LIKE '%$keyword%'
												OR mb.`mobile` LIKE '%$keyword%'
											)";

		if ($limit != '') $limit 		= "LIMIT $offset, $limit ";

		$sql = "SELECT * 
				FROM
				(
					SELECT IFNULL(mb.`user_id`, '0') `client_id`
							, IFNULL(mb.`fullname`, 'Vãng lai') fullname
							, IFNULL(mb.`mobile`, '-') mobile
							, IFNULL(mb.`code`, '-') code
							, nTB.`value_debt`
							, nTB.`quantity_debt`
					FROM (
						SELECT SUM( (dt.`quantity` - dt.`quantity_paid`)*dt.`price`*( (100 - dt.`decrement`)/100 ) ) value_debt
						, SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt
						, od.`id_customer` client_id
						FROM $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od 
						INNER JOIN $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` dt ON od.`id` = dt.`order_id`
						WHERE dt.`quantity_paid` < dt.`quantity`
						AND od.`status` = 1
						AND od.`order_type` = 0
						GROUP BY `od`.id_customer
					) nTB
					LEFT JOIN $db->tbl_fix`members` mb  ON nTB.`client_id` = mb.`user_id`
					WHERE nTB.quantity_debt > 0
					$keyword
				) nTB
				ORDER BY nTB.`value_debt` DESC
				$limit";

		$r = $db->executeQuery_list($sql);

		return $r;
	}

	public function list_debt_by_member_count($keyword = '', $year = '')
	{ 	//Load danh sách thành viên còn hàng nợ
		global $db;
		if ($year == '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');

		if ($keyword != '') $keyword 	= " AND (
												mb.`code` LIKE '%$keyword%' 
												OR mb.`fullname` LIKE '%$keyword%'
												OR mb.`mobile` LIKE '%$keyword%'
											)";

		$sql = "SELECT COUNT(*) total_record
						, SUM(nTB.`quantity_debt`) quantity_debt
						, SUM(nTB.`value_debt`) value_debt
				FROM
				(
					SELECT nTB.`quantity_debt`
							, nTB.`value_debt`
					FROM (
						SELECT SUM( (dt.`quantity` - dt.`quantity_paid`)*dt.`price`*( (100 - dt.`decrement`)/100 ) ) value_debt
						, SUM(dt.`quantity` - dt.`quantity_paid`) quantity_debt
						, od.`id_customer` client_id
						FROM $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od 
						INNER JOIN $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` dt ON od.`id` = dt.`order_id`
						WHERE dt.`quantity_paid` < dt.`quantity`
						AND od.`status` = 1
						AND od.`order_type` = 0
						GROUP BY `od`.id_customer
					) nTB
					LEFT JOIN $db->tbl_fix`members` mb  ON nTB.`client_id` = mb.`user_id`
					WHERE nTB.quantity_debt > 0
					$keyword
				) nTB";

		$r = $db->executeQuery($sql, 1);

		return array(
			'total_record' => isset($r['total_record']) ? $r['total_record'] : 0,
			'quantity_debt' => isset($r['quantity_debt']) ? $r['quantity_debt'] : 0,
			'value_debt' => isset($r['value_debt']) ? $r['value_debt'] : 0,
		);
	}

	public function info_product_debt($year = '')
	{ //Load danh sách thành viên còn hàng nợ hàm count
		global $db;

		if ($year == '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');

		$sql = "SELECT SUM(dt.`quantity`-dt.`quantity_paid`) quantity, SUM((dt.`quantity`-dt.`quantity_paid`)*dt.`default_price`) total
				FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` as dt 
				INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . $year . "` as od ON od.`id` = dt.`order_id` 
				WHERE 
				dt.`quantity_paid` < dt.`quantity`
				AND od.`status` = 1
				AND od.`order_type` = 0
				";
		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function list_order_debt($keyword = '', $year = '', $offset = '', $limit = '')
	{ //hàm lấy tất cả đơn hàng còn nợ hàng thành viên (tùng code - 27/07/2021)
		//HC 210911
		global $db;

		if ($year == '') $year = date('Y');

		$shop_id 	= $this->get('shop_id');

		if ($limit != '') $limit = "LIMIT $offset, $limit ";
		if ($keyword != '') $keyword = " AND (dt.`order_id` LIKE '%$keyword%' OR p.`name` LIKE '%$keyword%' OR mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%' )";

		$sql = "SELECT od.*, p.`img_1` `image`, IFNULL(mb.`fullname`,'') fullname, IFNULL(mb.`mobile`,'') mobile
				FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` as dt
				INNER JOIN $db->tbl_fix`product` p ON p.id = dt.product_id 
				INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od ON dt.`order_id` = od.`id`
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
				WHERE dt.`quantity_paid` < dt.`quantity` 
				AND od.`status` = 1
				AND od.`order_type` = 0
				$keyword
				GROUP BY od.`id`
				ORDER BY od.`created_at` DESC 
				$limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function list_order_debt_count($keyword = '', $year = '')
	{ //hàm đếm tổng số đơn hàng còn nợ hàng thành viên (tùng code - 27/07/2021)
		//HC: 210912
		global $db;

		if ($year == '') $year = date('Y');

		$shop_id 	= $this->get('shop_id');

		if ($keyword != '') $keyword = " AND (p.`id` LIKE '%$keyword%' OR p.`name` LIKE '%$keyword%' OR mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%' )";

		$sql = "SELECT COUNT(ntb.`total`) total
				FROM(SELECT COUNT(*) total
				FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . $year . "` as dt 
				INNER JOIN  $db->tbl_fix`product` p ON p.id = dt.product_id 
				INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . $year . "` od ON dt.`order_id` = od.`id`
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
				WHERE 
				dt.`quantity_paid` < dt.`quantity`
				AND od.`status` = 1
				AND od.`order_type` = 0
				$keyword 
				GROUP BY od.`id`)ntb";
		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	// public function list_product_by_order($keyword, $offset, $limit)
	// { //hàm lấy tất cả đơn hàng còn nợ hàng thành viên (tùng code - 27/07/2021)
	// 	global $db;

	// 	$order_id 	= $this->get('order_id');
	// 	$shop_id 	= $this->get('shop_id');
	// 	$created_at = $this->get('created_at');

	// 	if ($limit != '') $limit = "LIMIT $offset, $limit ";
	// 	if ($keyword != '') $keyword = " AND (dt.`order_id` LIKE '%$keyword%' OR p.`name` LIKE '%$keyword%')";

	// 	$sql = "SELECT dt.*, p.`img_1`
	// 			FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "` as dt
	// 			INNER JOIN " . $db->tbl_fix . "`product` p ON p.id = dt.product_id
	// 			WHERE dt.`quantity_paid` < dt.`quantity` AND dt.`order_id` = '$order_id' $keyword $limit";
	// 	$result = $db->executeQuery_list($sql);
	// 	return $result;
	// }

	// public function list_product_by_order_count($keyword)
	// { //hàm đếm tổng số đơn hàng còn nợ hàng thành viên (tùng code - 27/07/2021)
	// 	global $db;

	// 	$order_id 	= $this->get('order_id');
	// 	$shop_id 	= $this->get('shop_id');
	// 	$created_at = $this->get('created_at');

	// 	if ($keyword != '') $keyword = " AND (p.`id` LIKE '%$keyword%' OR p.`name` LIKE '%$keyword%')";

	// 	$sql = "SELECT COUNT(*) total
	// 			FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "` as dt 
	// 			INNER JOIN " . $db->tbl_fix . "`product` p ON p.id = dt.product_id
	// 			WHERE dt.`quantity_paid` < dt.`quantity` AND dt.`order_id` = '$order_id' $keyword";
	// 	$result = $db->executeQuery($sql, 1);

	// 	return $result['total'] + 0;
	// }


	/**
	 * showroom_sum_total_left method get total product debt
	 * @author datdat.itsn02
	 * 
	 * @param  mixed $year : year of order
	 * @return void
	 */
	public function showroom_sum_total_left($year = '')
	{
		global $db;

		if ($year == '') $year = date('Y');

		$product_id 	= $this->get('product_id');
		$sku_id 		= $this->get('sku_id');
		$shop_id 		= $this->get('shop_id');
		$order_id 		= $this->get('order_id');

		$sql = "SELECT SUM(dt.`quantity`-dt.`quantity_paid`) quantity_debt, dt.`quantity_paid`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . $year . "` as dt 
				INNER JOIN " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as od ON od.id = dt.order_id 
				INNER JOIN (
					SELECT showroom_id, order_id, shipper_status
					FROM " . $db->tbl_fix . "`delivery` as de 
					INNER JOIN " . $db->tbl_fix . "`showroom` as sr ON de.showroom_id = sr.id
					WHERE de.shop_id = " . $shop_id . "
				) as desr ON desr.order_id = od.id
				INNER JOIN " . $db->tbl_fix . "`product` p ON p.id = dt.product_id
				WHERE
				od.`status` = 1
				AND od.`order_type` = 7
				AND dt.`product_id` = '$product_id'
				AND desr.`order_id` = '$order_id'
				AND desr.`shipper_status` = 6
				AND dt.`sku_id` = '$sku_id'
				";
		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function sum_total_left($client_id, $year = '') //total left by client_id
	{ //hàm đếm tổng số đơn hàng còn nợ hàng thành viên (tùng code - 27/07/2021)
		//HC: 210910
		global $db;

		if ($year == '') $year = date('Y');

		$product_id 	= $this->get('product_id');
		$sku_id 		= $this->get('sku_id');
		$shop_id 		= $this->get('shop_id');

		$sql = "SELECT SUM(dt.`quantity`-dt.`quantity_paid`) quantity_debt, dt.`quantity_paid`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . $year . "` as dt 
				INNER JOIN " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as od ON od.id = dt.order_id 
				INNER JOIN " . $db->tbl_fix . "`product` p ON p.id = dt.product_id
				WHERE
				dt.`quantity_paid` < dt.`quantity`
				AND od.`status` = 1
				AND od.`order_type` = 0
				AND dt.`product_id` = '$product_id'
				AND od.`id_customer` = '$client_id'
				AND dt.`sku_id` = '$sku_id'
				";
		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function get_detail_order_debt_left($client_id, $year = '') //get detail order id left to update barcode export
	{   //HC: 220217 Hàm lấy toàn bộ danh sách các detail order ID để cập nhật nợ hàng thành viên để xuất hàng ra 
		global $db;

		if ($year == '') $year = date('Y');

		$product_id 	= $this->get('product_id');
		$sku_id 		= $this->get('sku_id');
		$shop_id 		= $this->get('shop_id');

		$sql = "SELECT dt.`id`, dt.`date_add`, dt.`quantity_paid`, dt.`quantity`, dt.`order_id`, (dt.`quantity` - dt.`quantity_paid`) debt_left
						, dt.`barcode`, od.`created_at` order_created_at, dt.`name`, dt.`product_id`, dt.`sku_id`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . $year . "` as dt 
				INNER JOIN " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as od ON od.id = dt.order_id 
				INNER JOIN " . $db->tbl_fix . "`product` p ON p.id = dt.product_id
				WHERE
				dt.`quantity_paid` < dt.`quantity`
				AND od.`status` = 1
				AND od.`order_type` = 0
				AND dt.`product_id` = '$product_id'
				AND od.`id_customer` = '$client_id'
				AND dt.`sku_id` = '$sku_id'
				";
		$result = $db->executeQuery_list($sql);

		return $result;
	}


	/**
	 * get_detail_showroom_order_debt_left: method get single/all product of order debt showroom
	 *
	 * @property mixed product_id,sku_id  : has value => get single product
	 * @param  mixed $year                : year of order
	 * @return void
	 */
	public function get_detail_showroom_order_debt_left($year = '')
	{
		global $db;

		if ($year == '') $year = date('Y');

		$product_id 	= $this->get('product_id');
		$sku_id 		= $this->get('sku_id');
		$shop_id 		= $this->get('shop_id');
		$order_id 		= $this->get('order_id');

		if (isset($product_id) && $product_id != "") {
			$product_id = "AND dt.`product_id` = '$product_id'";
		}

		if (isset($sku_id) && $sku_id != "") {
			$sku_id = "AND dt.`sku_id` = '$sku_id'";
		}

		$sql = "SELECT dt.`id`, dt.`date_add`, dt.`quantity_paid`, dt.`quantity`, dt.`order_id`, (dt.`quantity` - dt.`quantity_paid`) debt_left
						, dt.`barcode`, od.`created_at` order_created_at, dt.`name`, dt.`product_id`, dt.`sku_id`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . $year . "` as dt 
				INNER JOIN " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as od ON od.id = dt.order_id 
				INNER JOIN (
					SELECT showroom_id, order_id
					FROM " . $db->tbl_fix . "`delivery` as de 
					INNER JOIN " . $db->tbl_fix . "`showroom` as sr ON de.showroom_id = sr.id
					WHERE de.shop_id = " . $shop_id . "
				) as desr ON desr.order_id = od.id
				INNER JOIN " . $db->tbl_fix . "`product` p ON p.id = dt.product_id
				WHERE
				od.`status` = 1
				AND od.`order_type` = 7
				AND desr.`order_id` = '$order_id'
				$product_id
				$sku_id
				AND (dt.`quantity` - dt.`quantity_paid`)
				";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	/**
	 * list_product_debt_by_showroom
	 * @author datdat.itsn02
	 * 
	 * @param  mixed $year           : year of order
	 * @param  mixed $pro_ship_fee   : id of ship fee product
	 * @return void 
	 */
	public function list_product_debt_by_showroom($year = '', $pro_ship_fee = '')
	{
		global $db;

		if ($year == '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');
		$order_id 		= $this->get('order_id');

		$sql = "SELECT dt.`id`, dt.`date_add`, dt.`quantity_paid`
						, (dt.`quantity`- dt.`quantity_paid`) quantity_debt
						, dt.`quantity`, dt.`order_id`
						, dt.`price`, dt.`decrement`
						, dt.`product_id`, dt.`sku_id`
						, dt.`barcode`, od.`created_at` order_created_at
						, p.`name`
						, p.`img_1` `image`
						, od.`id_customer` client_id
						, SKU.`code` sku_code
						, (dt.`quantity` - dt.`quantity_paid`) * dt.`price`*( (100-dt.`decrement`)/100) value_debt
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . $year . "` as dt 
				INNER JOIN " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as od ON od.id = dt.order_id 
				INNER JOIN " . $db->tbl_fix . "`product` p ON p.id = dt.product_id
				INNER JOIN " . $db->tbl_fix . "`SKU` ON p.id = SKU.product_id AND SKU.id = dt.sku_id
				INNER JOIN ( 
					SELECT de.`order_id` order_id,
					 	   de.`showroom_id` showroom_id 
					FROM $db->tbl_fix`delivery` de 
					INNER JOIN 
						$db->tbl_fix`showroom` sr ON de.`showroom_id` = sr.`id` 
						) desr ON dt.`order_id` = desr.`order_id`
				WHERE od.`status` = 1
				AND od.`order_type` = 7
				AND desr.`order_id` = '$order_id'
				AND dt.`product_id` != '$pro_ship_fee'
				GROUP BY dt.`product_id`, dt.`sku_id`
				";
		$result = $db->executeQuery_list($sql);

		return $result;
	}
	public function list_product_debt_by_client($client_id, $year = '')
	{   //HC: 220218 List toàn bộ sản phẩm mà khách hàng này đang nợ: sản phẩm được gộp theo số lượng
		global $db;

		if ($year == '') $year = date('Y');

		$shop_id 		= $this->get('shop_id');

		$sql = "SELECT dt.`id`, dt.`date_add`, dt.`quantity_paid`
						, SUM((dt.`quantity`- dt.`quantity_paid`)) quantity_debt
						, dt.`quantity`, dt.`order_id`
						, p.`price`, dt.`decrement`
						, dt.`product_id`, dt.`sku_id`
						, dt.`barcode`, od.`created_at` order_created_at
						, p.`name`
						, p.`img_1` `image`
						, od.`id_customer` client_id
						, SKU.`code` sku_code
						, SUM( (dt.`quantity` - dt.`quantity_paid`) * dt.`price`*( (100-dt.`decrement`)/100) ) value_debt
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . $year . "` as dt 
				INNER JOIN " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as od ON od.id = dt.order_id 
				INNER JOIN " . $db->tbl_fix . "`product` p ON p.id = dt.product_id
				INNER JOIN " . $db->tbl_fix . "`SKU` ON p.id = SKU.product_id
				WHERE dt.`quantity_paid` < dt.`quantity`
				AND od.`status` = 1
				AND od.`order_type` = 0
				AND od.`id_customer` = '$client_id'
				GROUP BY dt.`product_id`, dt.`sku_id`
				";

		$r = $db->executeQuery_list($sql);

		return $r;
	}
	//AnCode: xóa giá giảm cập nhật đúng theo giá bán lẻ
	public function remove_decrement_on_bill($shop_id, $order_id, $created_at)
	{
		global $db;

		$sql = "UPDATE $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "` SET `price` = `default_price`, `decrement` = 0 WHERE `product_id` > 0 AND `quantity` > 0 AND `order_id` = '$order_id' ";
		// echo $sql;
		// exit();
		$db->executeQuery($sql);

		return true;
	}

	//Thêm phí vận chuyển vào đơn hàng
	public function extra_shipping_fee($shop_id, $username, $order_id, $created_at, $dDeliveryFeeItem)
	{
		global $shop, $order, $detail_order, $product, $setup;

		$price = $dDeliveryFeeItem['price'] + 0;
		$detail_order->set('default_price', $price);
		$detail_order->set('quantity', 1);
		$detail_order->set('decrement', 0);
		$detail_order->set('price', $price);
		$detail_order->set('inverse', 1); //đơn vị xuất cho POS
		$detail_order->set('expire_date', 0);
		$detail_order->set('order_id', $order_id);
		$detail_order->set('product_id', $dDeliveryFeeItem['id']);
		$detail_order->set('ratio_convert', $dDeliveryFeeItem['ratio_convert']);
		$detail_order->set('sku_id', 0);
		$detail_order->set('name', $dDeliveryFeeItem['name']);
		$detail_order->set('user_add', $username);
		$detail_order->set('note', '');
		$detail_order->set('attribute_1', '0');
		$detail_order->set('attribute_2', '0');
		$detail_order->set('attribute_3', '0');
		$detail_order->set('attribute_4', '0');
		$detail_order->set('attribute_5', '0');
		$detail_order->set('sku_name', '');
		$detail_order->set('root_price', 0);
		$detail_order->set('wh_history_id', '0');
		$detail_order->set('wh_history_return_id', 0);
		$detail_order->set('coupon_id', 0);
		$detail_order->set('is_coupon', 0);

		$dOrder 	= $order->get_detail($shop_id, $order_id, $created_at);
		//chỉ cho phép insert khi status == 0 (order temp)
		$detail_order_id = '';
		if (isset($dOrder['status']) && ($dOrder['status'] == 0 or $dOrder['status'] == -2)) {
			$dExistShippingFee = $this->get_exist_shipping_fee($shop_id, $created_at);
			if (empty($dExistShippingFee['id'])) {
				$detail_order_id = $this->add($shop_id, $created_at);
			} else {
				$this->set('date_add', $dExistShippingFee['date_add']);
				$this->set('shop_id', $shop_id);
				$this->set('id', $dExistShippingFee['id']);
				$this->delete_item();
				$detail_order_id = $this->add($shop_id, $created_at);
			}

			//update lại service_fee 
			$order->set('shop_id', $shop_id);
			$order->set('id', $order_id);
			$order->set('created_at', $created_at);
			$order->set('service_fee', $price);
			$order->update_service_fee();

			//lấy dữ liệu cho đơn hàng
			$dOrder['listItems'] 	= $this->listby_order($shop_id, $order_id, $created_at);
			return $dOrder;
		} else {
			return $detail_order_id;
		}
	}
}
$detail_order = new detail_order();
