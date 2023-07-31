<?php
class order
{

	protected $id;
	protected $code;
	protected $amount;
	protected $user_add;
	protected $shop_id;
	protected $status; //Status = 0 đơn hàng tạm; Status = 1 đơn hoàn thành; Status = -1 => đơn hủy
	protected $waiter;
	protected $printed;
	protected $last_update;
	protected $last_date;
	protected $treasurer;
	protected $note;
	protected $count_print;
	protected $name_customer;
	protected $no_customer;
	protected $mobile_customer;
	protected $id_customer;
	protected $is_official_customer; //giá trị chốt đơn hàng lúc mua là khách hàng chính thức hay là khách hàng mới dự bị ...
	protected $payment_type; // = 0 Tiền mặt; = 1 công nợ; 2 = ngoại tệ; 3 = thẻ; 4 khác; 5 Điểm;
	protected $is_booking; //=0 normal order; =1 booking order
	protected $status_booking; //=0 not delivery yet, =1 delivery some; = 2 done deliveried
	protected $vat;
	protected $created_at;
	protected $liabilities_status;
	protected $liabilities_paid;
	protected $hold_date;
	protected $liabilities_id;
	protected $ship_name;
	protected $ship_mobile;
	protected $ship_address;
	protected $ship_note;
	protected $address_book_id;
	protected $cash_more;
	protected $returned_from_order_id; //Order returned from Order_id
	protected $returned_from_created_at; //Unix time Order created at
	protected $total;
	protected $total_paid;
	protected $is_wholesale_price;
	protected $sub_orders;
	protected $created_from_order;
	protected $service_fee; //phí giao nhận
	protected $created_from_order_at;

	//=0 order from POS
	//=1 warehouse (Xuất nội bộ)
	//=2 Đơn khách hàng đặt tới công ty (Rồi sẽ chuyển sang =0) kết hợp với is_booking = 1
	//= 3 đơn do khách hàng YOBE đặt từ APP Client
	//= 4 đơn do xuất hàng của Showroom và điểm bán (Chỉ để quản lý số hàng tồn thôi)
	//= 5 hợp đồng cho thuê
	protected $order_type;

	protected $for_client_id; //Đối tượng được xuất cho

	protected $created_by_client_id;
	protected $longitude; //double
	protected $latitude; //double 

	protected $warehouse_id;
	protected $url_chung_tu;
	protected $is_internal; //Là xuất cho nội bộ hay xuất cho khách; nếu xuất cho khách thì dùng id_customer; còn xuất nội bộ thì dùng trường export_for_wh_id	
	protected $is_correction;
	protected $export_for_wh_id; //id kho
	protected $treasurer_id; //Lý do thu của đơn hàng này
	protected $pro_allow_commission; //List sản phẩm cho phép nhận 4% bởi đại lý.
	protected $pro_allow_commission_value; //Giá trị nhận
	protected $pro_allow_commission_percent; //Tính phần trăm
	protected $treasurer_group_id; //Lý do xuất của đơn hàng này
	protected $voucher_id; //Id voucher đã sử dụng cho đơn hàng

	// set value with paramater
	public function set($parameter, $val)
	{
		$this->$parameter = $val;
		return true;
	}
	// get value with paramater
	public function get($parameter)
	{
		return $this->$parameter;
	}

	// public function add( $shop_id, $user_add, $temp_area ){
	// 	global $db, $area;

	// 	$arr['id'] = $id = $this->get_id( $shop_id, $user_add );
	// 	$arr['code'] = $id;
	// 	$arr['amount'] = 0;
	// 	$arr['user_add'] = $user_add;
	// 	$arr['shop_id'] = $shop_id;

	// 	$arr['last_update'] = time();
	// 	$arr['last_date'] = date("d/m/y H:i:s");
	// 	$arr['date_out'] = 0;
	// 	$arr['out'] = '';
	// 	$arr['status'] = '1';
	// 	$arr['cooked'] = '0';
	// 	$arr['waiter'] = '';
	// 	$arr['temp_area'] = $temp_area;
	// 	$arr['returned_from_order_id'] = '';
	// 	$arr['returned_from_created_at'] = 0;
	// 	$arr['total'] = 0;
	// 	$arr['is_booking'] = 0;
	// 	$arr['status_booking'] = 0;
	// 	$arr['total_paid'] 	= $this->get('total_paid')+0;
	// 	$arr['created_at'] = time();

	// 	$arr['warehouse_id'] 		= $this->get('warehouse_id');
	// 	$arr['url_chung_tu'] 		= '';
	// 	$arr['is_internal'] 		= '0';
	// 	$arr['export_for_wh_id'] 	= '0';


	// 	$db->record_insert($db->tbl_fix."`order_".$shop_id."_".date('Y')."`", $arr);

	// 	return $id;
	// }

	public function checkTable_exist()
	{
		global $db;
		$shop_id = $this->get('shop_id');
		$table_name = substr($db->tbl_fix, 0, -1);
		$created_at = $this->get('created_at');
		$sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '$table_name'  AND table_name = 'order_" . $shop_id . "_" . date('Y', $created_at) . "'";
		$result = $db->executeQuery_list($sql);
		if (count($result) == 0) {
			return 0;
		}
		return 1;
		// return $sql;
	}

	public function clonex()
	{
		global $db, $detail_order;

		$shop_id 		= $this->get('shop_id');
		$order_id 		= $this->get('order_id');
		$created_at 	= $this->get('created_at');
		$user_add 		= $this->get('user_add');

		$c = $this->checkTable_exist();
		if ($c == 0) {
			$sql = "CREATE TABLE order_" . $shop_id . "_" . date('Y', $created_at) . " AS SELECT * FROM $db->tbl_fix`order_1_2021` WHERE 1 = 0";
			$db->executeQuery($sql);
		}
		$sql = "SELECT od.*
			FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "` `od`
			WHERE od.`id` = '$order_id' LIMIT 0,1 ";
		$arr = $db->executeQuery($sql, 1);
		if ($arr==[]) {
			$arr['id'] 			= $order_id;
			$arr['code'] 		= $order_id;
			$arr['user_add'] 	= $user_add;
			$arr['count_print']	= 0;
			$arr['last_update'] = time();
			$arr['last_date'] 	= date("d/m/y H:i:s");
			$arr['status'] 		= '0';
			$arr['printed'] 	= '0';
			$arr['status_booking'] 	= '0';
			$arr['returned_from_order_id'] 		= '';
			$arr['returned_from_created_at'] 	= 0;
			$arr['treasurer_id'] 				= 0;
			$arr['for_client_id'] 				= 0;
			$arr['is_correction'] 				= 0;
			$arr['total'] 		= 0;
			$arr['total_paid'] 	= $this->get('total_paid') + 0;
			$arr['created_at'] 	= time();

			$arr['warehouse_id'] 				= $this->get('warehouse_id');
			$arr['url_chung_tu'] 				= '';
			$arr['is_internal'] 				= '0';
			$arr['export_for_wh_id'] 			= '0';

			$db->record_insert($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y') . "`", $arr);
		}

		// clone detail_order
		// $detail_order = new detail_order();
		// $detail_order->add($shop_id, $created_at);
		// $detail_order->set('shop_id', $shop_id);
		// $detail_order->set('order_id', $order_id);
		// $detail_order->set('created_at', $created_at);
		// $detail_order->set('user_add', $user_add);
		// $detail_order->clonex($id);

		return $arr;
	}

	public function create_temp()
	{ //only use for phuc vu template
		global $db, $main;

		$shop_id 	= $this->get('shop_id');
		$user_add 	= $this->get('user_add');
		$vat 		= $this->get('vat');

		$arr['id'] 							= $id = $this->get_id($shop_id, $user_add);
		$arr['code'] 						= $id;
		$arr['amount'] 						= 0;
		$arr['user_add'] 					= $user_add;
		$arr['shop_id'] 					= $shop_id;
		$arr['status'] 						= '0';
		$arr['waiter'] 						= $user_add;
		$arr['printed'] 					= '0';
		$arr['last_update'] 				= time();
		$arr['last_date'] 					= date("d/m/y H:i:s");
		$arr['treasurer'] 					= '';
		$arr['note'] 						= '';
		$arr['count_print'] 				= '0';
		$arr['name_customer'] 				= $this->get('name_customer') . '';
		$arr['no_customer'] 				= $this->get('no_customer') + 0;
		$arr['mobile_customer'] 			= $this->get('mobile_customer') . '';
		$arr['id_customer'] 				= $this->get('id_customer') + 0;
		$arr['is_official_customer'] 		= $this->get('is_official_customer') + 0;
		$arr['payment_type'] 				= '0';
		$arr['is_booking'] 					= 0;
		$arr['status_booking'] 				= 0;
		$arr['vat'] 						= $vat;
		$arr['created_at'] 					= time();
		$arr['hold_date'] 					= '0';
		$arr['liabilities_id'] 				= '0';
		$arr['ship_name'] 					= $this->get('ship_name') . '';
		$arr['ship_mobile'] 				= $this->get('ship_mobile') . '';
		$arr['ship_address'] 				= $this->get('ship_address') . '';
		$arr['ship_note'] 					= $this->get('ship_note') . '';
		$arr['address_book_id'] 			= $this->get('address_book_id') + 0;
		$arr['cash_more'] 					= '0';
		$arr['order_type'] 					= '0';

		$arr['created_by_client_id'] 		= 0;
		$arr['for_client_id'] 				= 0;
		$arr['longitude'] 					= 0;
		$arr['latitude'] 					= 0;

		$arr['returned_from_order_id'] 		= '';
		$arr['returned_from_created_at'] 	= 0;
		$arr['total'] 						= 0;
		$arr['total_paid'] 					= $this->get('total_paid') + 0;

		$arr['is_wholesale_price'] 			= $this->get('is_wholesale_price') + 0;
		$arr['sub_orders'] 					= $this->get('sub_orders');
		$arr['created_from_order'] 			= $this->get('created_from_order');
		$arr['created_from_order_at'] 		= $this->get('created_from_order_at') + 0;

		$arr['warehouse_id'] 				= $this->get('warehouse_id');
		$arr['url_chung_tu'] 				= '';
		$arr['is_internal'] 				= '0';
		$arr['is_correction'] 				= '0';
		$arr['export_for_wh_id'] 			= '0';
		$arr['treasurer_id'] 				= '0';
		$arr['pro_allow_commission'] 		= '';
		$arr['pro_allow_commission_value'] 	= 0;
		$arr['pro_allow_commission_percent'] = 0;

		$db->record_insert($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y') . "`", $arr);

		return $id;
	}

	public function create_temp_by_customer()
	{ //only use for phuc vu template
		global $db, $main;

		$shop_id 	= $this->get('shop_id');
		$user_add 	= $this->get('user_add');
		$vat 		= $this->get('vat');

		$arr['id'] 							= $id = $this->get_id($shop_id, $user_add);
		$arr['code'] 						= $id;
		$arr['amount'] 						= 0;
		$arr['user_add'] 					= $user_add;
		$arr['shop_id'] 					= $shop_id;
		$arr['status'] 						= -2;
		$arr['waiter'] 						= $user_add;
		$arr['printed'] 					= '0';
		$arr['last_update'] 				= time();
		$arr['last_date'] 					= date("d/m/y H:i:s");
		$arr['treasurer'] 					= '';
		$arr['note'] 						= '';
		$arr['count_print'] 				= '0';
		$arr['name_customer'] 				= $this->get('name_customer') . '';
		$arr['no_customer'] 				= $this->get('no_customer') + 0;
		$arr['mobile_customer'] 			= $this->get('mobile_customer') . '';
		$arr['id_customer'] 				= $this->get('id_customer') + 0;
		$arr['is_official_customer'] 		= $this->get('is_official_customer') + 0;
		$arr['payment_type'] 				= '0';
		$arr['is_booking'] 					= 0;
		$arr['status_booking'] 				= 0;
		$arr['vat'] 						= $vat;
		$arr['created_at'] 					= time();
		$arr['hold_date'] 					= '0';
		$arr['liabilities_id'] 				= '0';
		$arr['ship_name'] 					= $this->get('ship_name') . '';
		$arr['ship_mobile'] 				= $this->get('ship_mobile') . '';
		$arr['ship_address'] 				= $this->get('ship_address') . '';
		$arr['ship_note'] 					= $this->get('ship_note') . '';
		$arr['address_book_id'] 			= $this->get('address_book_id') + 0;
		$arr['cash_more'] 					= '0';

		$arr['order_type'] 					= $this->get('order_type') + 0;

		$arr['created_by_client_id'] 		= $this->get('created_by_client_id') + 0;
		$arr['for_client_id']				= $this->get('for_client_id') == '' ? 0 : $this->get('for_client_id');
		$arr['longitude'] 					= $this->get('longitude') + 0;
		$arr['latitude'] 					= $this->get('latitude') + 0;

		$arr['returned_from_order_id'] 		= '';
		$arr['returned_from_created_at'] 	= 0;
		$arr['total'] 						= 0;
		$arr['total_paid'] 					= $this->get('total_paid') + 0;

		$arr['is_wholesale_price'] 			= $this->get('is_wholesale_price') + 0;
		$arr['sub_orders'] 					= $this->get('sub_orders');
		$arr['created_from_order'] 			= $this->get('created_from_order');
		$arr['created_from_order_at'] 		= $this->get('created_from_order_at') + 0;

		$arr['warehouse_id'] 				= $this->get('warehouse_id');
		$arr['url_chung_tu'] 				= '';
		$arr['is_internal'] 				= '0';
		$arr['is_correction'] 				= '0';
		$arr['export_for_wh_id'] 			= '0';
		$arr['treasurer_id'] 				= '0';

		$arr['pro_allow_commission'] 		= '';
		$arr['pro_allow_commission_value'] 	= 0;
		$arr['pro_allow_commission_percent'] = 0;

		$db->record_insert($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y') . "`", $arr);

		return $id;
	}

	public function create_temp_storing_id()
	{ //only use for storing template export warehouse
		global $db, $main;

		$shop_id 		= $this->get('shop_id');
		$user_add 		= $this->get('user_add');
		$vat 			= $this->get('vat');
		$warehouse_id 	= $this->get('warehouse_id');

		$id = $this->get_id_storing($shop_id, $warehouse_id, $user_add);

		$arr['id'] 							= $id;
		$arr['code'] 						= $id;
		$arr['amount'] 						= 0;
		$arr['user_add'] 					= $user_add;
		$arr['shop_id'] 					= $shop_id;
		$arr['status'] 						= '0';
		$arr['waiter'] 						= $user_add;
		$arr['printed'] 					= '0';
		$arr['last_update'] 				= time();
		$arr['last_date'] 					= date("d/m/y H:i:s");
		$arr['treasurer'] 					= '';
		$arr['note'] 						= '';
		$arr['count_print'] 				= '0';
		$arr['name_customer'] 				= $this->get('name_customer') . '';
		$arr['no_customer'] 				= $this->get('no_customer') + 0;
		$arr['mobile_customer'] 			= $this->get('mobile_customer') . '';
		$arr['id_customer'] 				= $this->get('id_customer') + 0;
		$arr['is_official_customer'] 		= $this->get('is_official_customer') + 0;
		$arr['payment_type'] 				= '0';
		$arr['order_type'] 					= '1'; //đơn hàng xuất kho

		$arr['created_by_client_id'] 		= 0;
		$arr['longitude'] 					= 0;
		$arr['latitude'] 					= 0;

		$arr['is_booking'] 					= 0;
		$arr['status_booking'] 				= 0;
		$arr['vat'] 						= $vat;
		$arr['created_at'] 					= time();
		$arr['hold_date'] 					= '0';
		$arr['liabilities_id'] 				= '0';
		$arr['ship_name'] 					= $this->get('ship_name') . '';
		$arr['ship_mobile'] 				= $this->get('ship_mobile') . '';
		$arr['ship_address'] 				= $this->get('ship_address') . '';
		$arr['ship_note'] 					= $this->get('ship_note') . '';
		$arr['address_book_id'] 			= $this->get('address_book_id') + 0;
		$arr['cash_more'] 					= '0';
		$arr['returned_from_order_id'] 		= '';
		$arr['returned_from_created_at'] 	= 0;
		$arr['total'] 						= 0;
		$arr['total_paid'] 					= $this->get('total_paid') + 0;

		$arr['is_wholesale_price'] 			= $this->get('is_wholesale_price') + 0;
		$arr['sub_orders'] 					= $this->get('sub_orders');
		$arr['created_from_order'] 			= $this->get('created_from_order');
		$arr['created_from_order_at'] 		= $this->get('created_from_order_at') + 0;

		$arr['warehouse_id'] 				= $warehouse_id;
		$arr['url_chung_tu'] 				= '';
		$arr['is_internal'] 				= '0';
		$arr['is_correction'] 				= '0';
		$arr['export_for_wh_id'] 			= '0';
		$arr['treasurer_id'] 				= '0';
		$arr['for_client_id'] 				= '0';

		$arr['pro_allow_commission'] 		= '';
		$arr['pro_allow_commission_value'] 	= 0;
		$arr['pro_allow_commission_percent'] = 0;

		$db->record_insert($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y') . "`", $arr);

		return $id;
	}

	public function update_temp_storing_id()
	{ //only use for storing template export warehouse
		global $db, $main;

		$shop_id 			= $this->get('shop_id');
		$id 				= $this->get('id');
		$created_at 		= $this->get('created_at');

		$arr['amount'] 						= 0;
		$arr['user_add'] 					= $this->get('user_add');
		// $arr['shop_id'] 					= $this->get('shop_id');
		$arr['status'] 						= '0';
		$arr['waiter'] 						= $this->get('waiter');
		$arr['printed'] 					= '0';
		$arr['last_update'] 				= time();
		$arr['last_date'] 					= date("d/m/y H:i:s");
		$arr['treasurer'] 					= $this->get('treasurer');
		$arr['note'] 						= $this->get('note');
		$arr['count_print'] 				= '0';
		$arr['name_customer'] 				= $this->get('name_customer') . '';
		$arr['no_customer'] 				= 1;
		$arr['mobile_customer'] 			= $this->get('mobile_customer') . '';
		$arr['id_customer'] 				= $this->get('id_customer') + 0;
		$arr['is_official_customer'] 		= $this->get('is_official_customer') + 0;
		$arr['payment_type'] 				= $this->get('payment_type') + 0;
		$arr['is_booking'] 					= 0;
		$arr['status_booking'] 				= 0;
		$arr['vat'] 						= $this->get('vat');

		$arr['hold_date'] 					= '0';
		$arr['liabilities_id'] 				= '0';

		$arr['ship_name'] 					= '';
		$arr['ship_mobile'] 				= '';
		$arr['ship_address'] 				= '';
		$arr['ship_note'] 					= '';

		$arr['cash_more'] 					= '0';
		$arr['returned_from_order_id'] 		= '';
		$arr['returned_from_created_at'] 	= 0;
		$arr['total'] 						= 0;
		$arr['total_paid'] 					= 0;

		$arr['is_wholesale_price'] 			= 0;
		$arr['sub_orders'] 					= '';
		$arr['created_from_order'] 			= '';
		$arr['created_from_order_at'] 		= 0;

		$arr['order_type'] 					= $this->get('order_type');
		$arr['warehouse_id'] 				= $this->get('warehouse_id');
		$arr['url_chung_tu'] 				= $this->get('url_chung_tu');
		$arr['is_correction'] 				= $this->get('is_correction');
		$arr['is_internal'] 				= $this->get('is_internal');
		$arr['export_for_wh_id'] 			= $this->get('export_for_wh_id');

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, "`id` = '$id' ");

		return $id;
	}

	public function checkout_by_customer()
	{ //only user for customer checkout cart
		global $db, $main;

		$shop_id 							= $this->get('shop_id');
		$id 								= $this->get('id');
		$created_at 						= $this->get('created_at');

		$arr['status'] 						= '-2'; //**************************************** */
		$arr['last_update'] 				= time();
		$arr['last_date'] 					= date("d/m/y H:i:s");

		if ($this->get('ship_name') != '')
			$arr['ship_name'] 					= $this->get('ship_name');
		if ($this->get('ship_mobile') != '')
			$arr['ship_mobile'] 				= $this->get('ship_mobile');
		if ($this->get('ship_address') != '')
			$arr['ship_address'] 				= $this->get('ship_address');
		if ($this->get('ship_note') != '')
			$arr['ship_note'] 					= $this->get('ship_note');

		$arr['address_book_id'] 			= $this->get('address_book_id');

		$arr['longitude'] 					= $this->get('longitude');
		$arr['latitude'] 					= $this->get('latitude');

		$arr['id_customer'] 				= $this->get('id_customer') + 0;
		$arr['mobile_customer'] 			= $this->get('mobile_customer');
		$arr['name_customer'] 				= $this->get('name_customer');
		$arr['created_by_client_id'] 		= $this->get('created_by_client_id');

		$arr['note'] 						= $this->get('note');
		$arr['payment_type'] 				= 0;
		$arr['order_type'] 					= $this->get('order_type');
		$arr['service_fee'] 				= $this->get('service_fee');
		$arr['total_paid'] 					= $this->get('total_paid');
		$arr['is_booking'] 					= 1; //**************************************** */
		$arr['pro_allow_commission'] 		= $this->get('pro_allow_commission');
		$arr['pro_allow_commission_value'] 	= $this->get('pro_allow_commission_value') + 0;
		$arr['pro_allow_commission_percent'] = $this->get('pro_allow_commission_percent') + 0;
		$arr['voucher_id']					= $this->get('voucher_id') + 0;

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, "`id` = '$id' ");

		return $id;
	}

	public function checkout_by_customer_showroom()
	{ //only user for customer checkout cart
		global $db, $main;

		$shop_id 							= $this->get('shop_id');
		$id 								= $this->get('id');
		$created_at 						= $this->get('created_at');

		$arr['status'] 						= '0'; //**************************************** */
		$arr['last_update'] 				= time();
		$arr['last_date'] 					= date("d/m/y H:i:s");

		if ($this->get('ship_name') != '')
			$arr['ship_name'] 					= $this->get('ship_name');
		if ($this->get('ship_mobile') != '')
			$arr['ship_mobile'] 				= $this->get('ship_mobile');
		if ($this->get('ship_address') != '')
			$arr['ship_address'] 				= $this->get('ship_address');
		if ($this->get('ship_note') != '')
			$arr['ship_note'] 					= $this->get('ship_note');

		$arr['address_book_id'] 			= $this->get('address_book_id');

		$arr['longitude'] 					= $this->get('longitude');
		$arr['latitude'] 					= $this->get('latitude');

		$arr['id_customer'] 				= $this->get('id_customer') + 0;
		$arr['mobile_customer'] 			= $this->get('mobile_customer');
		$arr['name_customer'] 				= $this->get('name_customer');
		$arr['created_by_client_id'] 		= $this->get('created_by_client_id');

		$arr['note'] 						= $this->get('note');
		$arr['payment_type'] 				= 0;
		$arr['order_type'] 					= $this->get('order_type');
		$arr['service_fee'] 				= $this->get('service_fee');
		$arr['total_paid'] 					= $this->get('total_paid');
		$arr['is_booking'] 					= 1; //**************************************** */
		$arr['pro_allow_commission'] 		= $this->get('pro_allow_commission');
		$arr['pro_allow_commission_value'] 	= $this->get('pro_allow_commission_value') + 0;
		$arr['pro_allow_commission_percent'] = $this->get('pro_allow_commission_percent') + 0;
		$arr['voucher_id']					= $this->get('voucher_id') + 0;

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, "`id` = '$id' ");

		return $id;
	}

	// AnCode: Thêm cập nhật số lần in.
	public function showroom_export()
	{ //only user for customer checkout cart
		global $db, $main;

		$shop_id 							= $this->get('shop_id');
		$id 								= $this->get('id');
		$created_at 						= $this->get('created_at');

		$dOrder = $this->get_detail($shop_id, $id, $created_at);

		$arr['status'] 						= '1';
		// $arr['printed'] 					= '1';
		$arr['printed'] 		     = $dOrder['printed'] + 1;
		$arr['last_update'] 				= time();
		$arr['last_date'] 					= date("d/m/y H:i:s");

		$arr['address_book_id'] 			= 0;

		$arr['longitude'] 					= 0;
		$arr['latitude'] 					= 0;

		$arr['id_customer'] 				= $this->get('id_customer') + 0;
		$arr['mobile_customer'] 			= $this->get('mobile_customer');
		$arr['name_customer'] 				= $this->get('name_customer');
		$arr['created_by_client_id'] 		= 0;

		$arr['note'] 						= $this->get('note');
		$arr['payment_type'] 				= 0;
		$arr['order_type'] 					= 4;
		$arr['service_fee'] 				= 0;
		$arr['total_paid'] 					= 0;
		$arr['is_booking'] 					= 0;
		$arr['pro_allow_commission'] 		= '';
		$arr['pro_allow_commission_value'] 	= 0;
		$arr['pro_allow_commission_percent'] = 0;
		$arr['voucher_id']					= 0;

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, "`id` = '$id' ");

		return $id;
	}

	public function checking_is_booking_completed()
	{ //chỉ dùng cho order là order booking
		global $db;

		$shop_id 		= $this->get('shop_id');
		$id 			= $this->get('id');
		$created_at 	= $this->get('created_at');

		$sql = "SELECT COUNT(*) total
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "` as dt 
				WHERE
				dt.order_id = '$id'
				AND dt.quantity > dt.delivered
				";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] > 0 ? 0 : 1;
	}

	public function checking_status_order_booking()
	{ //chỉ dùng cho order là order booking
		global $db;

		//return 0 => waiting delivery => not delivery anythings
		//return 1 => delivering ==> delivery some
		//return 2 ==> delivery all ==> complete

		$shop_id 		= $this->get('shop_id');
		$id 			= $this->get('id');
		$created_at 	= $this->get('created_at');

		$isCompleted = $this->checking_is_booking_completed();

		if ($isCompleted == 1)
			return 2; //đã hoàn thành giao hàng
		else {
			$sql = "SELECT COUNT(*) total
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "` as dt 
				WHERE
				dt.order_id = '$id'
				AND dt.delivered > 0
				";

			$result = $db->executeQuery($sql, 1);

			return $result['total'] > 0 ? 1 : 0;
		}
	}

	public function get_newest_id($shop_id, $user_add)
	{
		global $db;

		$time = strtotime(date('m/d/Y'));

		$sql = "SELECT od.*, IFNULL(mb.`avatar`, '') `avatar_customer`, IFNULL(mb.`email`, '') `email_customer`
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $time) . "` `od`
				LEFT JOIN " . $db->tbl_fix . "`members` mb ON od.id_customer = mb.user_id
				WHERE od.`shop_id`='$shop_id' AND od.`created_at` > '$time' AND od.`status` = 0 AND od.`user_add` = '$user_add' AND od.`order_type` = 0 ORDER BY od.last_update DESC LIMIT 0,1";
		$row = $db->executeQuery($sql, 1);

		return $row;
	}

	public function get_newest_id_by_customer($shop_id, $client_id)
	{
		global $db;

		$time = strtotime(date('m/d/Y'));

		$sql = "SELECT od.*, IFNULL(mb.`avatar`, '') `avatar_customer`, IFNULL(mb.`email`, '') `email_customer`
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $time) . "` `od`
				LEFT JOIN " . $db->tbl_fix . "`members` mb ON od.id_customer = mb.user_id
				WHERE od.`shop_id`='$shop_id' AND od.`created_at` > '$time' AND od.`status` = -2 AND od.`is_booking` = 0 AND od.`id_customer` = '$client_id' ORDER BY od.last_update DESC LIMIT 0,1";

		$row = $db->executeQuery($sql, 1);

		return $row;
	}

	public function get_temp_id($shop_id, $user_add)
	{
		global $db;

		$sql = "SELECT id FROM
				" . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y') . "` as `od`
				WHERE `shop_id`='" . $shop_id . "' AND `user_add`='" . $user_add . "' AND `created_at`>" . strtotime(date('m/d/Y')) . " AND `status`='0' 
				ORDER BY id DESC LIMIT 0,1";
		$row = $db->executeQuery($sql, 1);
		if ($row['id'] == '') {
			return '';
		} else {

			//update date in
			$arr['last_update'] = time();
			$arr['last_date'] = date("d/m/y H:i:s");
			$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y') . "`", $arr, " `id`= '" . $row['id'] . "' ");
			return $row['id'];
		}
	}

	// AnCode: Thêm cập nhật số lần in.
	public function update_finished()
	{
		global $db;

		$shop_id 				= $this->get('shop_id');
		$user_add 				= $this->get('user_add');
		$id 					= $this->get('id');
		$created_at 			= $this->get('created_at');
		$payment_type 			= $this->get('payment_type');
		$treasurer_group_id 	= $this->get('treasurer_group_id');
		$treasurer_id 			= $this->get('treasurer_id');
		$treasurer_id			= $treasurer_id == '' ? 0 : $treasurer_id;

		$created_from_order 	= $this->get('created_from_order');
		$created_from_order_at 	= $this->get('created_from_order_at') + 0;

		$dOrder = $this->get_detail($shop_id, $id, $created_at);

		// $arr['printed'] 		= '1';
		$arr['printed'] 		= $dOrder['printed'] + 1;
		$arr['status'] 			= '1';
		$arr['is_booking'] 		= '0';
		$arr['order_type'] 		= 0; //Đơn hàng được tính vào doanh thu
		$arr['payment_type'] 	= $payment_type + 0;
		$arr['treasurer_group_id'] 	= $treasurer_group_id;
		$arr['treasurer_id'] 	= $treasurer_id;
		$arr['treasurer'] 		= $user_add;
		$arr['created_at'] 		= time();
		$arr['last_update'] 	= time();

		if ($created_from_order != '' && $created_from_order_at > 0) {
			//re-update parent order about; child and item quantity
			$this->update_parent_order(); //re update parent order 
		}

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '" . $id . "' ");

		//Cập nhật hình thức thu/ xuất cho collected order
		$arr2['treasurer_group_id'] 	= $treasurer_group_id;
		$arr2['treasurer_id'] 			= $treasurer_id;
		$db->record_update($db->tbl_fix . "`collected_orders`", $arr2, " `shop_id` = '$shop_id' AND `order_id` = '$id' ");

		return true;
	}

	// AnCode: Thêm cập nhật số lần in.
	public function update_finished_storing()
	{
		global $db;

		$shop_id 				= $this->get('shop_id');
		$user_add 				= $this->get('user_add');
		$id 					= $this->get('id');
		$created_at 			= $this->get('created_at');
		$payment_type 			= $this->get('payment_type');
		$treasurer_group_id 	= $this->get('treasurer_group_id');
		$treasurer_id 			= $this->get('treasurer_id');
		$treasurer_id			= $treasurer_id == '' ? 0 : $treasurer_id;

		$dOrder = $this->get_detail($shop_id, $id, $created_at);

		// $arr['printed'] 		= '1';
		$arr['printed'] 		= $dOrder['printed'] + 1;
		$arr['status'] 			= '1';
		$arr['is_booking'] 		= '0';
		$arr['payment_type'] 	= $payment_type + 0;
		$arr['treasurer_group_id'] 	= $treasurer_group_id;
		$arr['treasurer_id'] 	= $treasurer_id;
		$arr['treasurer'] 		= $user_add;
		$arr['created_at'] 		= $created_at;
		$arr['last_update'] 	= time();

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '" . $id . "' ");

		//Cập nhật hình thức thu/ xuất cho collected order
		$arr2['treasurer_group_id'] 	= $treasurer_group_id;
		$arr2['treasurer_id'] 			= $treasurer_id;
		$db->record_update($db->tbl_fix . "`collected_orders`", $arr2, " `shop_id` = '$shop_id' AND `order_id` = '$id' ");

		return true;
	}

	public function update_parent_order()
	{
		global $db, $detail_order, $collected_orders;

		$shop_id 				= $this->get('shop_id');
		$user_add 				= $this->get('user_add');
		$order_id 				= $this->get('id');
		$created_at 			= $this->get('created_at');
		$payment_type 			= $this->get('payment_type');
		$created_from_order 	= $this->get('created_from_order');
		$created_from_order_at 	= $this->get('created_from_order_at');

		//update subs order for parents order
		$dOrder = $this->get_detail($shop_id, $created_from_order, $created_from_order_at);
		if (isset($dOrder['id'])) {

			//Update item delivered to parents order
			$lItems = $detail_order->listby_order($shop_id, $order_id, $created_at);

			foreach ($lItems as $item) {
				if ($item['quantity'] > 0) {
					$sql = "UPDATE " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_from_order_at) . "`
							SET `delivered` = IF( (`delivered` + '" . $item['quantity'] . "') <= `quantity`, ( `delivered` + '" . $item['quantity'] . "'), `quantity` )
							WHERE
							`order_id` = '$created_from_order'
							AND `sku_id` = '" . $item['sku_id'] . "'
							AND `product_id` = '" . $item['product_id'] . "'
							";
					$db->executeQuery($sql);
				}
			}

			//kiểm tra đơn hàng đã hoàn thành giao hay chưa hay đang giao chưa hoàn thành
			$this->set('shop_id', $shop_id);
			$this->set('id', $created_from_order);
			$this->set('created_at', $created_from_order_at);
			$status_booking = $this->checking_status_order_booking();

			$this->set('sub_orders', $dOrder['sub_orders'] != '' ? $dOrder['sub_orders'] . $order_id . ':' . $created_at . ';' : ';' . $order_id . ':' . $created_at . ';');
			$this->set('status_booking', $status_booking);
			$this->update_sub_orders(); //update sub order for parent order

			//cập nhật trạng thái status_booking ở bản collected_orders
			$collected_orders->set('shop_id', $shop_id);
			$collected_orders->set('order_id', $created_from_order);
			$collected_orders->set('created_from_order_at', $created_from_order_at);
			$collected_orders->set('status_booking', $status_booking);
			$collected_orders->update_status_booking();

			unset($lItems);
			unset($dOrder);
		} else {
			//không tìm thấy order thì bỏ qua
		}

		return true;
	}

	public function update_sub_orders()
	{ //update from sub order so using created_from_order and  created_from_order_at
		global $db;

		$shop_id 				= $this->get('shop_id');
		$created_from_order 	= $this->get('created_from_order'); //info parent order
		$created_from_order_at 	= $this->get('created_from_order_at'); //info parent order
		$status_booking 		= $this->get('status_booking');
		$sub_orders 			= $this->get('sub_orders');

		$arr['status_booking']		= $status_booking;
		$arr['sub_orders']			= $sub_orders;

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_from_order_at) . "`", $arr, " `id` = '$created_from_order' ");

		return true;
	}

	// AnCode: Thêm cập nhật số lần in.
	public function update_finished_return()
	{
		global $db;

		$shop_id 								= $this->get('shop_id');
		$user_add 								= $this->get('user_add');
		$id 									= $this->get('id');
		$created_at 							= $this->get('created_at');
		$payment_type 							= $this->get('payment_type');
		$liabilities_id 						= $this->get('liabilities_id');
		$hold_date 								= $this->get('hold_date');
		$note 									= $this->get('note');
		$id_customer 							= $this->get('id_customer') + 0;
		$is_official_customer 					= $this->get('is_official_customer') + 0;
		$mobile_customer 						= $this->get('mobile_customer');
		$name_customer 							= $this->get('name_customer');
		$returned_from_order_id 				= $this->get('returned_from_order_id');
		$returned_from_created_at 				= $this->get('returned_from_created_at');

		$dOrder = $this->get_detail($shop_id, $id, $created_at);

		// $arr['printed'] 						= '1';
		$arr['printed'] 		= $dOrder['printed'] + 1;
		$arr['status'] 							= '1';
		$arr['payment_type'] 					= $payment_type + 0;
		$arr['liabilities_id'] 					= $liabilities_id;
		$arr['hold_date'] 						= $hold_date;
		$arr['treasurer'] 						= $user_add;
		$arr['note'] 							= $note;
		$arr['id_customer'] 					= $id_customer;
		$arr['is_official_customer'] 			= $is_official_customer;
		$arr['mobile_customer'] 				= $mobile_customer;
		$arr['name_customer'] 					= $name_customer;
		$arr['returned_from_order_id'] 			= $returned_from_order_id;
		$arr['returned_from_created_at'] 		= $returned_from_created_at;
		$arr['last_update'] 					= time();

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$id' ");

		return true;
	}

	// public function update_finished_MB360Pay( $shop_id, $user_add, $order_id, $created_at,  $cash_more, $payment_type ='0'){
	// 	global $db;

	// 	$arr['printed'] 		= '1';
	// 	$arr['status'] 			= '1';
	// 	$arr['payment_type'] 	= $payment_type;
	// 	$arr['treasurer'] 		= $user_add;
	// 	$arr['cash_more'] 		= $cash_more;

	// 	$db->record_update( $db->tbl_fix."`order_".$shop_id."_".date('Y', $created_at)."`", $arr, " `id` = '$order_id' " );

	// 	return true;
	// }

	// public function update_liabilities_to_order($shop_id, $id , $created_at ){
	// 	global $db;

	// 	$arr['liabilities_id'] 		= $this->get('liabilities_id');//id công nợ được ghi
	// 	$arr['hold_date'] 			= $this->get('hold_date');
	// 	$arr['treasurer'] 			= $user_updated;

	// 	$db->record_update( $db->tbl_fix."`order_".$shop_id."_".date('Y', $created_at)."`", $arr, " `id`='".$id."'");
	// 	return true;
	// }

	/*Order công nợ cho khách hàng tạo cục bộ*/
	public function liabilities_order_user_local($shop_id, $order_id, $created_at)
	{
		global $db;

		$arr['treasurer'] 			= $this->get('treasurer');
		$arr['liabilities_id'] 		= $this->get('liabilities_id');
		$arr['hold_date'] 			= $this->get('hold_date');

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='" . $order_id . "'");
		return true;
	}

	// AnCode: Thêm cập nhật số lần in.
	public function update_paid($shop_id, $username, $id, $created_at)
	{
		global $db;

		$dOrder = $this->get_detail($shop_id, $id, $created_at);

		$arr['printed'] 		= $dOrder['printed'] + 1;
		// $arr['printed'] = '1';
		$arr['status'] = '1';
		$arr['treasurer'] = $username;

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='" . $id . "'");
		return true;
	}

	public function update_liabilities($shop_id, $id, $created_at)
	{
		global $db;

		$arr['liabilities_status'] = '1';

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='" . $id . "'");
		return true;
	}

	public function update_vat($shop_id, $id, $vat, $created_at)
	{
		global $db;

		$arr['vat'] = $vat;
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, "id='" . $id . "'");

		return true;
	}

	public function update_count_print($shop_id, $order_id, $created_at)
	{
		global $db;

		$sql = "UPDATE `order_" . $shop_id . "_" . date('Y', $created_at) . "` SET `count_print`=(`count_print`+1) WHERE id='" . $order_id . "'";
		$db->executeQuery($sql);

		return true;
	}

	public function update_note($shop_id, $order_id, $note, $created_at)
	{
		global $db;

		$arr['ship_note'] = $note;
		$arr['last_update'] = time();
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='$order_id' ");

		return true;
	}
	//Trung code (10/01/2023) hàm update ghi chú cho báo cáo tổng hợp
	public function update_note_sumReport($shop_id, $order_id, $note, $created_at)
	{
		global $db;

		$arr['note'] = $note;
		$arr['last_update'] = time();
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='$order_id' ");

		return true;
	}

	public function update_order_note()
	{
		global $db;

		$arr['note'] 			= $this->get('note');

		$shop_id 				= $this->get('shop_id');
		$order_id 				= $this->get('order_id');
		$created_at 			= $this->get('created_at');

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$order_id'");

		return true;
	}

	public function update_ship_info()
	{
		global $db;

		$arr['ship_name'] 		= $this->get('ship_name');
		$arr['ship_mobile'] 	= $this->get('ship_mobile');
		$arr['ship_address'] 	= $this->get('ship_address');
		$arr['ship_note'] 		= $this->get('ship_note');
		$arr['address_book_id'] = $this->get('address_book_id');

		$shop_id 				= $this->get('shop_id');
		$order_id 				= $this->get('order_id');
		$created_at 			= $this->get('created_at');

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$order_id'");

		return true;
	}

	public function update_park($shop_id, $order_id, $note, $username, $created_at)
	{
		global $db;

		$arr['note'] 			= $note;
		$arr['status'] 			= '-2';
		$arr['order_type'] 		= '0';
		$arr['treasurer'] 		= $username;
		$arr['last_update'] 	= time();

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='" . $order_id . "'");
		return true;
	}

	public function open_retrieve($shop_id, $order_id, $username, $created_at)
	{
		global $db;

		$arr['status'] 			= '0';
		$arr['treasurer'] 		= $username;
		$arr['last_update'] 	= time();

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '" . $order_id . "' ");
		return true;
	}

	public function update_last_update($shop_id, $id)
	{
		global $db;

		$arr['last_update'] = time();
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='" . $id . "'");

		return true;
	}

	public function update_amount($shop_id, $id, $amount)
	{
		global $db;

		$sql = "UPDATE " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "` SET `amount`=(`amount` + " . $amount . ") WHERE `id`='" . $id . "'";
		$db->executeQuery($sql);

		return true;
	}

	public function update_added($shop_id, $id, $created_at)
	{
		global $db;

		$arr['added'] 		= '1';
		$arr['status'] 		= '1';
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$id' ");

		return true;
	}

	public function update_total_paid($shop_id, $id, $created_at, $total_paid)
	{
		global $db;

		$arr['total_paid'] 		= $total_paid;
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$id' ");

		return true;
	}

	public function update_is_booking($shop_id, $id, $created_at, $is_booking)
	{
		global $db;
		//cập nhật trạng thái is_booking
		$arr['is_booking'] 		= $is_booking;
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$id' ");

		return true;
	}

	public function update_is_wholesale_price($shop_id, $id, $created_at, $is_wholesale_price)
	{
		global $db;
		//trangj th
		$arr['is_wholesale_price'] 		= $is_wholesale_price;
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$id' ");

		return true;
	}

	// AnCode: Thêm cập nhật số lần in.
	public function update_booking($shop_id, $id, $created_at, $username)
	{
		global $db; //lưu lại đơn hàng đặt hàng
		//Order đặt hàng là order có trạng thái status =1 và is_booking = 1
		$dOrder = $this->get_detail($shop_id, $id, $created_at);

		$arr['printed'] 		= $dOrder['printed'] + 1;
		// $arr['printed'] 			= 1;
		$arr['status'] 				= 1;
		$arr['is_booking'] 			= 1;
		$arr['waiter'] 				= $username;
		$arr['treasurer'] 			= $username;
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$id' ");

		return true;
	}

	public function get_detail($shop_id, $id, $created_at = 0)
	{
		global $db;
		if ($created_at == 0) $created_at = time();

		$this->update_total_order($shop_id, $id, $created_at);

		$sql = "SELECT od.*, IFNULL(mb.`avatar`, '') `avatar_customer`, IFNULL(mb.`email`, '') `email_customer`
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "` `od`
				LEFT JOIN " . $db->tbl_fix . "`members` mb ON od.id_customer = mb.user_id
				WHERE od.`id` = '$id' LIMIT 0,1 ";
		$row = $db->executeQuery($sql, 1);
		return $row;
	}

	public function get_detail_by_client()
	{
		global $db;

		$shop_id 		= $this->get('shop_id');
		$id 			= $this->get('id');
		$created_at 	= $this->get('created_at');

		if ($created_at == 0) $created_at = time();

		$this->update_total_order($shop_id, $id, $created_at);

		$sql = "SELECT  od.`id`, od.`treasurer`, od.`last_update`, od.`note`, od.`id_customer` client_id, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`code`, od.`user_add`, od.`created_at`, od.`shop_id`, od.`for_client_id`, od.`created_by_client_id`, od.`address_book_id`
						, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`, od.`service_fee`, od.`status`, od.`order_type`, od.`total`, od.`is_booking`
					  	, IFNULL( mb.`fullname`, '') for_fullname, IFNULL( mb.`mobile`, '') for_mobile, IFNULL( mb.`code`, '') for_code, IFNULL(mb.`member_group_id`, 0) for_member_group_id, IFNULL(mb.`avatar`, 0) for_avatar
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "` `od`
				LEFT JOIN " . $db->tbl_fix . "`members` mb ON od.for_client_id = mb.user_id
				WHERE od.`id` = '$id' LIMIT 0,1 ";
		$row = $db->executeQuery($sql, 1);
		return $row;
	}

	public function get_detail_all($shop_id, $id, $created_at = 0)
	{
		global $db;
		if ($created_at == 0) $created_at = time();

		$sql = "SELECT od.*, IFNULL(mb.`avatar`, '') `avatar_customer`, IFNULL(mb.`email`, '') `email_customer`
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "` `od`
				LEFT JOIN " . $db->tbl_fix . "`members` mb ON od.id_customer = mb.user_id
				WHERE `od`.`id` = '$id' LIMIT 0,1";
		$row = $db->executeQuery($sql, 1);
		return $row;
	}

	public function get_detail_bycode($shop_id, $code, $created_at)
	{
		global $db;

		$sql = "SELECT od.*, IFNULL(mb.`avatar`, '') `avatar_customer`, IFNULL(mb.`email`, '') `email_customer`
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "` as `od`
				LEFT JOIN " . $db->tbl_fix . "`members` mb ON od.id_customer = mb.user_id
				WHERE od.`code`='$code' AND od.`status`<>'-1' LIMIT 0,1";
		$row = $db->executeQuery($sql, 1);

		return $row;
	}

	public function get_detail_bycode_all($shop_id, $code, $created_at)
	{
		global $db;
		if ($created_at > time()) $created_at = time();

		$sql = "SELECT od.*, IFNULL(mb.`avatar`, '') `avatar_customer`, IFNULL(mb.`email`, '') `email_customer`
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "` as `od`
				LEFT JOIN " . $db->tbl_fix . "`members` mb ON od.id_customer = mb.user_id
				WHERE od.`code`='$code' AND od.`shop_id` = '$shop_id' LIMIT 0,1";

		$row = $db->executeQuery($sql, 1);

		return $row;
	}

	public function get_newest_code($shop_id)
	{
		global $db;

		$time = strtotime(date('m/d/Y', time()));

		$sql = "SELECT code FROM $db->tbl_fix`order_" . $shop_id . "_" . date('Y') . "`  as `od`
				WHERE `created_at` > " . $time . " AND `shop_id` = '$shop_id' ORDER BY id DESC LIMIT 0,1";
		$row = $db->executeQuery($sql, 1);
		if ($row['code'] == '') {
			$kq = '00001 - ' . date("dmY") . '01';
		} else {
			$num = substr($row['code'], 0, 5);
			$num = $num + 1;
			$kq = sprintf("%05d", $num) . ' - ' . date("dmY") . '01';
		}

		return $kq;
	}

	public function get_recent_code($shop_id, $created_at)
	{
		global $db;

		$kq = array();
		$time = strtotime(date('m/d/Y', time()));

		$sql = "SELECT id,code FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "` as `od` 
				WHERE created_at > '$time' AND `shop_id`='" . $shop_id . "'
				ORDER BY id DESC LIMIT 0,1";
		$row = $db->executeQuery($sql, 1);
		if ($row['code'] == '') {
			$kq = '00001 - ' . date("dmY") . '01';
		} else {
			$kq = $row['code'];
		}

		return $kq;
	}

	// public function report_order_from_to_day( $shop_id, $from, $to ){//from day(int) => to day (int)
	// 	global $db;
	// 	$cat = new category();
	// 	$product = new product();

	// 	$lcat = $cat->listby_shop( $shop_id );
	// 	$return = array();

	// 	foreach( $lcat as $key=>$item ){

	// 		$lproduct = $product->listby_cat_id_forrepreport( $item['id'] );

	// 		$ldetail = '';
	// 		$cat_giam_gia = 0;
	// 		$cat_thanh_tien = 0;
	// 		$total_profit = 0;
	// 		$cat_sl = 0;
	// 		$ldetail = array();

	// 		foreach($lproduct as $skey=>$sitem){
	// 			$detail_menu = $this->get_amount_ordered($shop_id, $sitem['id'], $from, $to);
	// 			if( $detail_menu['kq'] != '' ){
	// 				$cat_giam_gia += $detail_menu['sum_giam_gia'];
	// 				$cat_thanh_tien += $detail_menu['sum_thanh_tien'];
	// 				$cat_sl += $detail_menu['sum_sl'];
	// 				$total_profit += $detail_menu['total_profit'];				
	// 				$ldetail[] = $detail_menu['kq'];
	// 			}
	// 		}

	// 		if( $ldetail != '' ){				
	// 			$temp['cat_id'] = $item['id'];
	// 			$temp['cat_name'] = $item['name'];
	// 			$temp['cat_giam_gia'] = $cat_giam_gia;
	// 			$temp['cat_thanh_tien'] = $cat_thanh_tien;
	// 			$temp['total_profit'] = $total_profit;
	// 			$temp['cat_sl'] = $cat_sl;
	// 			$temp['detail_order'] = $ldetail;
	// 			$return[] = $temp;
	// 		}
	// 	}

	// 	unset($temp);
	// 	unset($lproduct);
	// 	unset($detail_menu);
	// 	unset($sitem);

	// 	return $return;
	// }

	// public function report_detail_selling($shop_id, $keyword, $from, $to, $offset = 0, $limit = '')
	// { //from day(int) => to day (int)
	// 	global $db;

	// 	if ($keyword != '') $keyword = " AND dt.`name` LIKE '%$keyword%' ";

	// 	if ($limit != '') $limit = " LIMIT $offset, $limit ";

	// 	$sql = "SELECT dt.`product_id`, dt.`name`, dt.`price`, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount, dt.`decrement`, dt.`vat`, dt.`root_price`, IFNULL(SKU.`code`, '') sku_code 
	// 			FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
	// 			INNER JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
	// 			LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
	// 			WHERE od.is_booking = 0 AND od.printed='1' AND od.status='1' AND od.created_at >= '$from' AND od.created_at < '$to' $keyword
	// 			GROUP BY dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement
	// 			ORDER BY `dt`.name
	// 			$limit"; // AND `dt`.product_id > 0

	// 	$result = $db->executeQuery_list($sql);

	// 	return $result;
	// }

	public function report_detail($shop_id, $payment_type, $from, $to, $offset = 0, $limit = '')
	{ //from day(int) => to day (int)
		global $db, $SKU;

		$method_payment = new method_payment();

		$order_type = $this->get('order_type');
		if ($order_type != '') $order_type = "AND od.`order_type` = '$order_type' ";

		$sqlPayment = '';
		if ($payment_type != '') {
			$lPayment = explode(';', $payment_type);
			foreach ($lPayment as $pt) {
				if ($pt != '')
					$sqlPayment .= " od.`payment_type` = '$pt' OR ";
			}
			if ($sqlPayment != '') {
				$sqlPayment = ' AND (' . substr($sqlPayment, 0, -3) . ')';
			}
		}

		if ($limit != '') $limit = " LIMIT $offset, $limit ";

		// $sql = "SELECT dt.`product_id`, dt.`name`, dt.`price`, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount, dt.`decrement`, dt.`vat`, dt.`root_price`, od.`payment_type`, od.`liabilities_id`, od.`hold_date`
		// 		FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 		LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
		// 		WHERE od.is_booking = 0 AND od.printed='1' AND od.status='1' AND od.created_at >= '$from' AND od.created_at <= '$to' $sqlPayment $order_type
		// 		GROUP BY od.payment_type, dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement
		// 		ORDER BY `od`.payment_type, `dt`.name
		// 		$limit";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT dt.`product_id`, dt.`name`, dt.`price`, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount, dt.`decrement`, dt.`vat`, dt.`root_price`, od.`payment_type`, od.`liabilities_id`, od.`hold_date`
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
				LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
				WHERE od.is_booking = 0 AND od.printed>'0' AND od.status='1' AND od.created_at >= '$from' AND od.created_at <= '$to' $sqlPayment $order_type
				GROUP BY od.payment_type, dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement
				ORDER BY `od`.payment_type, `dt`.name
				$limit";

		$result = $db->executeQuery($sql);
		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {

			$row['sku_code'] = $SKU->get_sku_code($row['product_id'], $row['sku_id']);

			$method_payment->set('id', $row['payment_type']);
			$row['payment_type'] = $method_payment->get_name();
			$kq[] = $row;
		}

		return $kq;
	}

	// public function report_detail_selling_info($shop_id, $keyword, $from, $to)
	// { //from day(int) => to day (int)
	// 	global $db;

	// 	if ($keyword != '') $keyword = " AND dt.`name` LIKE '%$keyword%' ";

	// 	$sql = "SELECT 
	// 					COUNT(*) total_record,
	// 					SUM(`total_revenue`) `total_revenue`,
	// 					SUM(`total_cost`) `total_cost`,
	// 					SUM(`total_discount`) `total_discount`,
	// 					SUM(`total_quantity`) total_quantity
	// 			FROM (
	// 				SELECT 	SUM(dt.`quantity`*dt.`price`) total_revenue,
	// 						SUM(dt.`quantity`*dt.`root_price`) total_cost,
	// 						SUM(dt.`quantity`*dt.`price`*(dt.`decrement`/100)) total_discount,
	// 						SUM(ABS(dt.`quantity`)) total_quantity
	// 				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
	// 				INNER JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id 
	// 				WHERE od.is_booking = 0 AND od.printed='1' AND od.status='1' AND '$from' <= od.created_at AND od.created_at < '$to' $keyword
	// 				GROUP BY dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement
	// 			) nTB"; //AND `dt`.product_id > 0

	// 	$r = $db->executeQuery($sql, 1);

	// 	return $r;
	// }

	public function report_detail_count($shop_id, $payment_type, $from, $to)
	{ //from day(int) => to day (int)
		global $db;

		$order_type = $this->get('order_type');
		if ($order_type != '') $order_type = "AND od.`order_type` = '$order_type' ";

		$sqlPayment = '';
		if ($payment_type != '') {
			$lPayment = explode(';', $payment_type);
			foreach ($lPayment as $pt) {
				if ($pt != '')
					$sqlPayment .= " od.`payment_type` = '$pt' OR ";
			}
			if ($sqlPayment != '') {
				$sqlPayment = ' AND (' . substr($sqlPayment, 0, -3) . ')';
			}
		}

		// $sql = "SELECT COUNT(*) total_record, SUM(total_sum) total_sum FROM (
		// 		SELECT COUNT(*) total_record, SUM(dt.`quantity`*dt.`price` *( 100 - dt.`decrement`) /100 ) `total_sum` 
		// 		FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 		LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
		// 		WHERE od.is_booking = 0 AND od.printed='1' AND od.status='1' AND od.created_at >= '$from' AND od.created_at < '$to' $sqlPayment $order_type
		// 		GROUP BY od.payment_type, dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement
		// 		ORDER BY `dt`.name) nTB";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT COUNT(*) total_record, SUM(total_sum) total_sum FROM (
				SELECT COUNT(*) total_record, SUM(dt.`quantity`*dt.`price` *( 100 - dt.`decrement`) /100 ) `total_sum` 
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
				LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
				WHERE od.is_booking = 0 AND od.printed>'0' AND od.status='1' AND od.created_at >= '$from' AND od.created_at < '$to' $sqlPayment $order_type
				GROUP BY od.payment_type, dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement
				ORDER BY `dt`.name) nTB";

		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function report_discount_from_to_day($shop_id, $from, $to)
	{ //from day(int) => to day (int)
		global $db;
		$cat = new category();
		$product = new product();

		$lcat = $cat->listby_shop($shop_id);
		$return = array();

		foreach ($lcat as $key => $item) {

			$lproduct = $product->listby_cat_id_forrepreport($item['id']);

			$ldetail = '';
			$cat_giam_gia = 0;
			$cat_thanh_tien = 0;
			$total_profit = 0;
			$cat_sl = 0;
			$ldetail = array();

			foreach ($lproduct as $skey => $sitem) {
				$detail_menu = $this->get_discount_items_ordered($shop_id, $sitem['id'], $from, $to);
				if (COUNT($detail_menu['kq']) > 0) {
					$cat_giam_gia += $detail_menu['sum_giam_gia'];
					$cat_thanh_tien += $detail_menu['sum_thanh_tien'];
					$cat_sl += $detail_menu['sum_sl'];
					$total_profit += $detail_menu['total_profit'];
					$ldetail[] = $detail_menu['kq'];
				}
			}

			if (COUNT($ldetail) > 0) {
				$temp['cat_id'] = $item['id'];
				$temp['cat_name'] = $item['name'];
				$temp['cat_giam_gia'] = $cat_giam_gia;
				$temp['cat_thanh_tien'] = $cat_thanh_tien;
				$temp['total_profit'] = $total_profit;
				$temp['cat_sl'] = $cat_sl;
				$temp['detail_order'] = $ldetail;
				$return[] = $temp;
			}
		}

		unset($temp);
		unset($lproduct);
		unset($detail_menu);
		unset($sitem);

		return $return;
	}

	public function get_amount_ordered($shop_id, $product_id, $from, $to)
	{
		global $db;

		$detail_order = new detail_order();

		// $sql = "SELECT dt.product_id, dt.name, dt.price, dt.sku_id, dt.sku_name, SUM(dt.quantity) as amount, dt.decrement, dt.vat, dt.root_price 
		// 		FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 		LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id 
		// 		WHERE od.is_booking = 0 AND od.printed='1' AND od.status='1' AND od.created_at >= '" . $from . "' AND od.created_at < '" . $to . "' AND dt.product_id = '" . $product_id . "'
		// 		GROUP BY dt.root_price, dt.price, dt.decrement";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT dt.`product_id`, dt.`name`, dt.`price`, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount, dt.`decrement`, dt.`vat`, dt.`root_price` 
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
				LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id 
				WHERE od.is_booking = 0 AND od.printed>'0' AND od.status='1' AND od.created_at >= '" . $from . "' AND od.created_at < '" . $to . "' AND dt.product_id = '" . $product_id . "'
				GROUP BY dt.root_price, dt.price, dt.decrement";
		$result = $db->executeQuery($sql);

		$sum_sl = '';
		$sum_giam_gia = '';
		$sum_thanh_tien = '';
		$total_profit = '';

		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$sum_sl += $row['amount'];
			$row['giam_gia'] = ($row['amount'] * $row['price'] * $row['decrement'] / 100);

			$row['total'] = $row['amount'] * $row['price'] - $row['giam_gia'];
			$row['profit'] = $row['total'] - $row['root_price'] * $row['amount'];
			$total_profit += $row['profit'];
			$sum_giam_gia += $row['giam_gia'];
			$sum_thanh_tien += $row['amount'] * $row['price'];
			$kq[] = $row;
		}


		$rt['sum_sl'] = $sum_sl;
		$rt['sum_giam_gia'] = $sum_giam_gia;
		$rt['sum_thanh_tien'] = $sum_thanh_tien;
		$rt['total_profit'] = $total_profit;
		$rt['kq'] = $kq;

		unset($row);
		unset($result);
		unset($sum_giam_gia);
		unset($sum_sl);
		unset($sum_thanh_tien);
		unset($kq);

		return $rt;
	}

	public function get_discount_items_ordered($shop_id, $product_id, $from, $to)
	{
		global $db;
		$detail_order = new detail_order();

		// $sql = "SELECT od.note,dt.order_id,dt.product_id,dt.name,dt.price,dt.sku_id,SUM(dt.quantity) as amount,dt.decrement,dt.vat, dt.root_price 
		// 		FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 		LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id 
		// 		WHERE od.printed = '1' AND od.status = '1' AND od.created_at >= '$from' AND od.created_at < '$to' AND dt.product_id = '$product_id' AND dt.decrement > 0
		// 		GROUP BY dt.root_price, dt.price, dt.decrement
		// 		ORDER BY od.created_at, dt.order_id";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT od.note,dt.order_id,dt.product_id,dt.name,dt.price,dt.sku_id,SUM(dt.quantity) as amount,dt.decrement,dt.vat, dt.root_price 
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
				LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id 
				WHERE od.printed>'0' AND od.status = '1' AND od.created_at >= '$from' AND od.created_at < '$to' AND dt.product_id = '$product_id' AND dt.decrement > 0
				GROUP BY dt.root_price, dt.price, dt.decrement
				ORDER BY od.created_at, dt.order_id";

		$result = $db->executeQuery($sql);

		$sum_sl = '';
		$sum_giam_gia = '';
		$sum_thanh_tien = '';
		$total_profit = '';

		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$sum_sl += $row['amount'];
			$row['giam_gia'] = ($row['amount'] * $row['price'] * $row['decrement'] / 100);

			$row['note'] = $row['note'];
			$row['total'] = $row['amount'] * $row['price'] - $row['giam_gia'];
			$row['profit'] = $row['total'] - $row['root_price'] * $row['amount'];
			$total_profit += $row['profit'];
			$sum_giam_gia += $row['giam_gia'];
			$sum_thanh_tien += $row['amount'] * $row['price'];
			$kq[] = $row;
		}

		$rt['sum_sl'] = $sum_sl;
		$rt['sum_giam_gia'] = $sum_giam_gia;
		$rt['sum_thanh_tien'] = $sum_thanh_tien;
		$rt['total_profit'] = $total_profit;
		$rt['kq'] = $kq;

		unset($row);
		unset($result);
		unset($sum_giam_gia);
		unset($sum_sl);
		unset($sum_thanh_tien);
		unset($kq);

		return $rt;
	}

	public function get_amount_ordered_decrement($shop_id, $from, $to)
	{
		global $db;
		$detail_order = new detail_order();

		// $sql = "SELECT SUM(dt.quantity * price) as total 
		// 		FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 		LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id WHERE od.shop_id = '" . $shop_id . "' 
		// 		AND od.printed='1' AND od.status='1' 
		// 		AND od.created_at >= '$from' AND od.created_at < '$to' 
		// 		AND dt.product_id = '0' AND dt.sku_id = '0'";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT SUM(dt.quantity * price) as total 
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
				LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id WHERE od.shop_id = '" . $shop_id . "' 
				AND od.printed>'0' AND od.status='1' 
				AND od.created_at >= '$from' AND od.created_at < '$to' 
				AND dt.product_id = '0' AND dt.sku_id = '0'";
		$result = $db->executeQuery($sql, 1);

		$total = 0 + @$result['total'];
		return $total;
	}

	//Tổng giá trị đơn hàng
	public function get_total_order($shop_id, $order_id, $created_at)
	{
		global $db;
		$detail_order = new detail_order();

		$sql = "SELECT SUM(quantity*price) as total 
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "` 
				WHERE `order_id` = '" . $order_id . "' AND product_id > 0 ";
		$result = $db->executeQuery($sql, 1);

		return $result['total'];
	}

	public function get_total_order_sub_package_fee($shop_id, $order_id, $created_at)
	{
		global $db, $setup;
		$detail_order = new detail_order();

		$sql = "SELECT SUM(quantity*price) as total 
				FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "` 
				WHERE `order_id` = '" . $order_id . "' AND product_id != '" . $setup['pro_package_fee'] . "' AND product_id != '" . $setup['pro_ship_fee'] . "' AND product_id > 0 ";
		$result = $db->executeQuery($sql, 1);

		return $result['total'];
	}

	public function search_code_order($shop_id, $keyword, $date)
	{
		global $db;

		$detail_order 	= new detail_order();
		$user 			= new user();
		$code 			= $keyword;

		$sql = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $date) . "` as `od`
				WHERE status='1' 
				AND (`id` LIKE '%" . $keyword . "%' OR `id` LIKE '%" . $code . "%')
				ORDER BY id ASC ";
		$result = $db->executeQuery($sql);

		$return = array();
		while ($row = mysqli_fetch_assoc($result)) {

			$duser  = $user->get_detail($row['waiter']);
			$row['detail_order'] = $detail_order->listby_order($shop_id, $row['id'], $row['last_update']);
			$row['detail_order_return'] = $detail_order->listby_order_toprint_return($shop_id, $row['id'], $row['last_update']);
			$row['waiter'] = $duser['fullname'];
			$return[] = $row;
			unset($row);
			unset($duser);
		}
		unset($result);

		return $return;
	}

	public function list_orders_history($shop_id, $from, $to)
	{
		global $db, $db_store;
		$detail_order = new detail_order();
		$user = new user();

		$sql = "SELECT od.*, IF(od.`liabilities_id` > 0 AND od.`hold_date` = 1, 'Tổng hợp', payment.`name`) payment_name
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as `od`
				LEFT JOIN $db_store->tbl_fix`method_payment` payment ON payment.`id` = od.`payment_type`
				WHERE status = '1' 
				AND `shop_id` = '$shop_id'
				AND '$from'<= created_at
				AND created_at < '$to'
				AND `order_type` = 0
				ORDER BY `last_update` DESC";
		$result = $db->executeQuery($sql);

		$return = array();
		while ($row = mysqli_fetch_assoc($result)) {

			$row['created_time'] = date('H:i', $row['created_at']);
			$row['treasurer']  	= $user->get_fullname($row['treasurer']);
			$row['total'] 		= $detail_order->get_sum_order($row['shop_id'], $row['id'], $row['created_at']);
			$return[] 			= $row;

			unset($row);
			unset($duser);
		}
		mysqli_free_result($result);

		return $return;
	}

	public function list_orders_from_to_day($shop_id, $payment_type, $from, $to, $offset = 0, $limit = '')
	{
		global $db;
		$detail_order = new detail_order();
		$user = new user();

		if ($limit != '') {
			$limit = " LIMIT $offset, $limit";
		}

		if ($payment_type != '') $payment_type = "AND `payment_type` = '" . $payment_type . "'";

		$sql = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as `od`
				WHERE status='1' 
				AND shop_id='" . $shop_id . "' 
				AND '$from' <= created_at $payment_type
				AND created_at < '$to' ORDER BY id ASC " . $limit;
		$result = $db->executeQuery($sql);

		$return = array();
		while ($row = mysqli_fetch_assoc($result)) {

			$duser  = $user->get_detail($row['waiter']);
			$row['detail_order'] = $detail_order->listby_order_toprint($shop_id, $row['id'], $row['last_update']);
			$row['detail_order_return'] = $detail_order->listby_order_toprint_return($shop_id, $row['id'], $row['last_update']);
			$row['waiter'] = $duser['fullname'];
			$return[] = $row;

			unset($row);
			unset($duser);
		}

		unset($result);
		return $return;
	}

	//listing in bill order
	public function list_orders_from_to_day_printing($shop_id, $payment_type, $from, $to)
	{
		global $db;
		$detail_order = new detail_order();
		$user = new user();

		if ($payment_type != '') $payment_type = " AND `payment_type` = '" . $payment_type . "'";

		$sql = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as `od`
				WHERE status='1' 
				AND shop_id = '" . $shop_id . "' " . $payment_type . "
				AND '$from' <= created_at
				AND created_at < '$to' ORDER BY id ASC ";

		$result = $db->executeQuery($sql);
		$return = array();

		while ($row = mysqli_fetch_assoc($result)) {

			$row['detail_order'] = $detail_order->listby_order_toprint($shop_id, $row['id'], $row['last_update']);
			$row['detail_order_return'] = $detail_order->listby_order_toprint_return($shop_id, $row['id'], $row['last_update']);
			if (COUNT($row['detail_order']) > 0 || COUNT($row['detail_order_return'])) {

				$dUser  = $user->get_detail($row['user_add']);
				$row['user_add'] = $dUser['fullname'];
				$return[] = $row;

				unset($row);
				unset($dUser);
			} else {
				$this->delete_item($shop_id, $row['id'], $row['last_update']);
			}
		}
		unset($result);

		return $return;
	}

	public function list_orders_from_to_day_count($shop_id, $payment_type, $from, $to)
	{
		global $db;

		if ($payment_type != '') $payment_type = "AND `payment_type` = '" . $payment_type . "'";

		$sql = "SELECT COUNT(id) as total FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as `od`
				WHERE status = '1'
				AND shop_id='" . $shop_id . "' 
				AND '$from'<= created_at " . $payment_type . "
				AND created_at < '$to' ORDER BY id ASC ";

		$result = $db->executeQuery($sql, 1);

		return $result['total'];
	}

	public function list_coupon_used($shop_id, $from, $to)
	{
		global $db;
		$detail_order = new detail_order();

		// $sql = "SELECT dt.name,dt.price,SUM(dt.quantity) as amount,dt.decrement,dt.coupon_id
		// 		FROM `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt
		// 		LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id 
		// 		WHERE od.shop_id = '" . $shop_id . "' AND od.printed='1' AND od.status='1' AND od.created_at >= '$from'
		// 		AND od.created_at < '$to' AND dt.product_id = 0 AND dt.sku_id = '0' AND dt.quantity < 0 AND dt.is_coupon = 1  GROUP BY dt.coupon_id,dt.price ORDER BY `name` ASC";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT dt.`name`,dt.`price`,SUM(dt.`quantity`) as amount,dt.`decrement`,dt.`coupon_id`
				FROM `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt
				LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id 
				WHERE od.shop_id = '" . $shop_id . "' AND od.printed>'0' AND od.status='1' AND od.created_at >= '$from'
				AND od.created_at < '$to' AND dt.product_id = 0 AND dt.sku_id = '0' AND dt.quantity < 0 AND dt.is_coupon = 1  GROUP BY dt.coupon_id,dt.price ORDER BY `name` ASC";
		$result = $db->executeQuery($sql);
		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$kq[] = $row;
		}

		return $kq;
	}

	public function sum_discount_items($shop_id, $from, $to)
	{
		global $db;

		$detail_order = new detail_order();
		$main = new main();

		// $sql = "SELECT SUM(dt.quantity * dt.price) as totals
		// 		FROM `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt
		// 		LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id 
		// 		WHERE od.shop_id = '" . $shop_id . "' AND od.printed = '1' AND od.status = '1' AND od.created_at >= '$from' 
		// 		AND od.created_at < '$to' AND dt.product_id = '0' AND dt.sku_id = '0' AND dt.quantity < 0 AND dt.is_coupon = 0";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT SUM(dt.quantity * dt.price) as totals
				FROM `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt
				LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id 
				WHERE od.shop_id = '" . $shop_id . "' AND od.printed>'0' AND od.status = '1' AND od.created_at >= '$from' 
				AND od.created_at < '$to' AND dt.product_id = '0' AND dt.sku_id = '0' AND dt.quantity < 0 AND dt.is_coupon = 0";

		$result = $db->executeQuery($sql, 1);
		$totals = @$result['totals'] + 0;

		return $totals;
	}

	public function list_discount_items($shop_id, $from, $to)
	{
		global $db;

		$detail_order = new detail_order();
		$main = new main();

		// $sql = "SELECT dt.order_id,dt.name,dt.quantity,dt.price
		// 		FROM `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt
		// 		LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id 
		// 		WHERE od.shop_id = '" . $shop_id . "' AND od.printed = '1' AND od.status = '1' AND od.created_at >= '$from' 
		// 		AND od.created_at < '$to' AND dt.product_id = '0' AND dt.sku_id = '0' AND dt.quantity < 0 AND dt.is_coupon = 0";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT dt.order_id,dt.name,dt.quantity,dt.price
				FROM `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt
				LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id 
				WHERE od.shop_id = '" . $shop_id . "' AND od.printed>'0' AND od.status = '1' AND od.created_at >= '$from' 
				AND od.created_at < '$to' AND dt.product_id = '0' AND dt.sku_id = '0' AND dt.quantity < 0 AND dt.is_coupon = 0";

		$kq = array();
		$result = $db->executeQuery($sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$kq[] = $row;
		}

		return $kq;
	}

	public function sum_surcharge_items($shop_id, $from, $to)
	{
		global $db;

		$detail_order = new detail_order();
		$main = new main();

		// $sql = "SELECT SUM(dt.quantity * dt.price) as totals
		// 		FROM `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt
		// 		LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id 
		// 		WHERE od.shop_id = '" . $shop_id . "' AND od.printed = '1' AND od.status = '1' AND od.created_at >= '$from' 
		// 		AND od.created_at < '$to' AND dt.product_id = '0' AND dt.sku_id = '0' AND dt.quantity = 1 AND dt.is_coupon = 0";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT SUM(dt.quantity * dt.price) as totals
				FROM `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt
				LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id 
				WHERE od.shop_id = '" . $shop_id . "' AND od.printed>'0' AND od.status = '1' AND od.created_at >= '$from' 
				AND od.created_at < '$to' AND dt.product_id = '0' AND dt.sku_id = '0' AND dt.quantity = 1 AND dt.is_coupon = 0";

		$result = $db->executeQuery($sql, 1);
		$totals = $result['totals'] + 0;

		return $totals;
	}

	public function sum_surcharge_items_cash($shop_id, $from, $to)
	{
		global $db;

		$detail_order = new detail_order();
		$main = new main();

		// $sql = "SELECT SUM(dt.quantity * dt.price) as totals
		// 		FROM `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt
		// 		LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id 
		// 		WHERE od.shop_id = '" . $shop_id . "' AND od.printed = '1' AND od.status = '1' AND od.created_at >= '$from' AND od.payment_type = 0
		// 		AND od.created_at < '$to' AND dt.product_id = '0' AND dt.sku_id = '0' AND dt.quantity = 1 AND dt.is_coupon = 0";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT SUM(dt.quantity * dt.price) as totals
				FROM `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt
				LEFT JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id 
				WHERE od.shop_id = '" . $shop_id . "' AND od.printed>'0' AND od.status = '1' AND od.created_at >= '$from' AND od.payment_type = 0
				AND od.created_at < '$to' AND dt.product_id = '0' AND dt.sku_id = '0' AND dt.quantity = 1 AND dt.is_coupon = 0";

		$result = $db->executeQuery($sql, 1);
		$totals = $result['totals'] + 0;

		return $totals;
	}

	public function filter_by_members($shop_id, $keyword = '', $year = '', $status_showroom = '', $payment_type = '', $offset = '', $limit = '')
	{
		global $db, $user, $detail_order, $shop;

		if ($shop_id != '') {

			$k = $this->list_booking($shop_id, $keyword, $year, $status_showroom, $payment_type, $offset, $limit);

			return $k;
		} else {

			$lShops = $shop->list_all_shop();

			$k = array();
			foreach ($lShops as $item) {

				$shop_id = $item['id'];

				$q = $this->list_booking($shop_id, $keyword, $year, $status_showroom, $payment_type, $offset, $limit);

				$k = array_merge($k, $q);
			}

			return $k;
		}
	}

	public function list_booking($shop_id, $keyword = '', $year = '', $status_showroom = '', $payment_type = '', $offset = '', $limit = '')
	{
		global $db, $db_store, $user, $detail_order, $shop;

		$collected_payments = new collected_payments();

		if ($year == '') $year = date('Y');

		$created_by_client_id = $this->get('created_by_client_id');
		if ($created_by_client_id != '') {
			$created_by_client_id = " AND ( od.`created_by_client_id` = '$created_by_client_id' OR od.`id_customer` = '$created_by_client_id' ) ";
		} else {
			$created_by_client_id = " AND od.`created_by_client_id` > 0 ";
		}

		$order_type = $this->get('order_type');
		$status 	= $this->get('status');

		if ($status !=  '') {
			$status = "AND od.`status` = '$status'";
		} else {
			$status = "";
		}

		if ($order_type != '') $order_type = " AND od.`order_type` = '$order_type' ";

		$is_booking = $this->get('is_booking');
		if ($is_booking != '') $is_booking = " AND od.`is_booking` = '$is_booking' ";

		if ($payment_type !== '') {
			$payment_type = " AND cp.`payment_type` = '$payment_type' ";
		} else {
			$payment_type = '';
		}

		if ($status_showroom != '') {
			if ($status_showroom == 0) {
				$status_showroom = " AND od.`ship_name` = '' ";
			} else {
				$status_showroom = " AND od.`ship_name` != '' ";
			}
		} else {
			$status_showroom = "";
		}

		if ($limit != '') $limit = " LIMIT $offset,$limit ";
		if ($keyword != '') $keyword = " AND ( `od`.`id` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' OR mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%' ) ";

		$sql = "SELECT od.`id`, od.`treasurer`, od.`last_update`, od.`last_update` last_update_at, IFNULL(od.`note`, '') note, `od`.id_customer, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`code`, od.`user_add`, od.`created_at`, od.`shop_id`, od.`created_at`
					, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`, od.`total`
					, od.`status`
					, IFNULL(del.delivery_id, 0) delivery_id, IFNULL(del.delivery_name, '') delivery_name, IFNULL(del.delivery_mobile, '') delivery_mobile
					, IFNULL(del.delivery_address, '') delivery_address, IFNULL(del.delivery_note, '') delivery_note
					, IFNULL(del.`delivery_status`, '' ) delivery_status
					, IFNULL(mb.`code`, '') members_code
					, IFNULL(mb.`mobile`, '') members_mobile
					, IFNULL(shop.`name`, '') shop_name
					, IF(`payment`.id = 1, 'Tổng hợp', IFNULL(payment.`name`, '') ) payment_name
					, IFNULL(`colOrder`.`order_client_type`, '') order_client_type
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as `od`
				LEFT JOIN $db->tbl_fix`collected_orders` colOrder ON colOrder.order_id = od.id AND colOrder.shop_id = od.shop_id
				LEFT JOIN $db->tbl_fix`shop` ON shop.id = od.shop_id
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.id = cp.order_id
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
				LEFT JOIN $db_store->tbl_fix`method_payment` payment ON payment.`id` = od.`payment_type`
				LEFT JOIN (
					SELECT del.order_id, del.shop_id, del.shipper_id delivery_id, mb.fullname delivery_name
					, mb.mobile delivery_mobile, mb.address delivery_address
					, del.note delivery_note, del.shipper_status delivery_status
					FROM $db->tbl_fix`delivery` del
					INNER JOIN  $db->tbl_fix`members` mb ON mb.user_id = del.shipper_id
					WHERE del.shipper_status > -1 AND del.shop_id = '$shop_id'
				) del ON del.order_id = od.`id` AND od.`shop_id` = del.`shop_id`
				WHERE od.`shop_id`='$shop_id' $order_type $is_booking $status $created_by_client_id $keyword $status_showroom $payment_type
				GROUP BY `od`.`id`
				ORDER BY od.`created_at` DESC
				$limit";

		$result = $db->executeQuery($sql);
		$kq = array();

		while ($row = mysqli_fetch_assoc($result)) {

			$collected_payments->set('shop_id', $shop_id);
			$collected_payments->set('order_id', $row['id']);
			$row['detail_payment'] = $collected_payments->list_by_order();

			$row['total'] 			= $detail_order->get_sum_order($shop_id, $row['id'], $row['last_update']);
			$row['last_update'] 	= date('d/m/Y', $row['last_update']);
			$kq[] = $row;
		}

		return $kq;
	}

	public function list_booking_count($shop_id, $keyword = '', $year = '', $status_showroom = '', $payment_type = '')
	{
		global $db, $user;
		if ($year == '') $year = date('Y');

		$created_by_client_id = $this->get('created_by_client_id');
		if ($created_by_client_id != '') {
			$created_by_client_id = " AND ( od.`created_by_client_id` = '$created_by_client_id' OR od.`id_customer` = '$created_by_client_id' ) ";
		} else {
			$created_by_client_id = " AND od.`created_by_client_id` > 0 ";
		}

		$order_type = $this->get('order_type');
		$status 	= $this->get('status');

		if ($status !=  '') {
			$status = "AND od.`status` = '$status'";
		} else {
			$status = "";
		}

		if ($order_type != '') $order_type = " AND od.`order_type` = '$order_type' ";

		$is_booking = $this->get('is_booking');
		if ($is_booking != '') $is_booking = " AND od.`is_booking` = '$is_booking' ";

		if ($payment_type !== '') {
			$payment_type = " AND cp.`payment_type` = '$payment_type' ";
		} else {
			$payment_type = "";
		}

		if ($status_showroom != '') {
			if ($status_showroom == 0) {
				$status_showroom = " AND od.`ship_name` = '' ";
			} else {
				$status_showroom = " AND od.`ship_name` != '' ";
			}
		} else {
			$status_showroom = "";
		}

		if ($keyword != '') $keyword = " AND ( `od`.`id` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' OR mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%' ) ";

		$sql = "SELECT COUNT(*) total
				FROM(
					SELECT `od`.id
					FROM " . $db->tbl_fix . " `order_" . $shop_id . "_" . $year . "` as `od`
					LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.id = cp.order_id
					LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
					WHERE od.`shop_id`='$shop_id' 
					$order_type 
					$is_booking 
					$status 
					$created_by_client_id 
					$keyword 
					$status_showroom 
					$payment_type
					GROUP BY `od`.`id`
				) nTB";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	public function list_booking_showroom($shop_id, $year = '', $offset = '', $limit = '') //lấy đơn hàng của showroom đặt (tùng code)
	{
		global $db, $user, $detail_order, $shop;

		if ($year == '') $year = date('Y');

		$created_by_client_id = $this->get('created_by_client_id');
		if ($created_by_client_id != '') {
			$created_by_client_id = " AND ( od.`created_by_client_id` = '$created_by_client_id' OR od.`id_customer` = '$created_by_client_id' ) ";
		} else {
			$created_by_client_id = " AND od.`created_by_client_id` > 0 ";
		}

		$order_type = $this->get('order_type');
		if ($order_type != '') $order_type = " AND od.`order_type` = '$order_type' ";

		$is_booking = $this->get('is_booking');
		if ($is_booking != '') $is_booking = " AND od.`is_booking` = '$is_booking' ";

		if ($limit != '') $limit = " LIMIT $offset,$limit ";

		$sql = "SELECT od.`id`, od.`treasurer`, od.`last_update`, od.`note`, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`code`, od.`user_add`, od.`created_at`, od.`shop_id`, od.`created_at`
					, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`
					, od.`status`
					, IFNULL(mb.`code`, '') members_code
					, IFNULL(mb.`mobile`, '') members_mobile
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as `od`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.id = cp.order_id
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
				WHERE od.`shop_id`='$shop_id' AND (od.`status` = 0 OR od.`status` = -2) $order_type $is_booking $created_by_client_id
				GROUP BY `od`.`id`
				ORDER BY od.`created_at` DESC
				$limit";

		$result = $db->executeQuery($sql);
		$kq = array();

		while ($row = mysqli_fetch_assoc($result)) {

			$row['total'] 			= $detail_order->get_sum_order($shop_id, $row['id'], $row['last_update']);
			$row['shop_name'] 		= $shop->get_shop_name($row['shop_id']);
			$row['last_update'] 	= date('d/m/Y', $row['last_update']);
			$kq[] = $row;
		}

		return $kq;
	}

	public function list_booking_processing($shop_id, $keyword = '', $year = '', $status_showroom = '', $payment_type = '', $type = '', $offset = '', $limit = '')
	{
		global $db, $user, $detail_order, $shop, $setup;

		if ($year == '') $year = date('Y');

		$created_by_client_id = $this->get('created_by_client_id');
		if ($created_by_client_id != '') {
			$created_by_client_id = " AND od.`created_by_client_id` = '$created_by_client_id' ";
		} else {
			$created_by_client_id = " AND od.`created_by_client_id` > 0 ";
		}

		$order_type = $this->get('order_type');
		if ($order_type != '') $order_type = " AND od.`order_type` = '$order_type' ";

		$is_booking = $this->get('is_booking');
		if ($is_booking != '') $is_booking = " AND od.`is_booking` = '$is_booking' ";

		if ($payment_type != '') {
			if ($payment_type == 15) {
				$payment_type = " AND cp.`payment_type` = '15' ";
			} else {
				$payment_type = " AND cp.`payment_type` != '15' ";
			}
		} else {
			$payment_type = "";
		}

		if ($status_showroom != '') {
			if ($status_showroom == 0) {
				$status_showroom = " AND od.`ship_name` = '' ";
			} else {
				$status_showroom = " AND od.`ship_name` != '' ";
			}
		} else {
			$status_showroom = "";
		}

		if ($type != '' && $type == 'processing') {
			$type = "del.shipper_status > -1 AND del.shipper_status != 3";
		} else if ($type != '' && $type == 'done') {
			$type = "del.shipper_status = 3";
		} else if ($type != '' && $type == 'cancel') {
			$type = "del.shipper_status = -2";
		} else {
			$type = "";
		}

		// $order_status = "AND od.`status` != -3";
		if ($limit != '') $limit = " LIMIT $offset,$limit ";

		if ($keyword != '') $keyword = " AND ( `od`.`id` = '$keyword' OR od.`name_customer` LIKE '%$keyword%' OR od.`mobile_customer` LIKE '%$keyword%' ) ";


		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT od.`id`, od.`treasurer`, od.`last_update`, od.`note`, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`cashback_total`, od.`code`, od.`user_add`, od.`created_at`, od.`shop_id`, od.`created_at`
					, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`, od.`service_fee`
					, od.`status`
					, IFNULL(del.`delivery_id`, 0) delivery_id, IFNULL(del.`delivery_name`, '') delivery_name, IFNULL(del.`delivery_mobile`, '') delivery_mobile
					, IFNULL(del.`delivery_address`, '') delivery_address, IFNULL(del.`delivery_note`, '') delivery_note
					, IFNULL(del.`delivery_status`, 0 ) delivery_status
					, IFNULL(del.`is_convert`, 0 ) is_convert
				FROM 
				(
					$sqlOrderTable
				) `od`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.id = cp.order_id
				INNER JOIN (
					SELECT del.order_id, del.shop_id, del.shipper_id delivery_id, del.is_convert, del.order_created_at, sr.name delivery_name
					, sr.mobile delivery_mobile, sr.address delivery_address
					, del.note delivery_note, del.shipper_status delivery_status
					FROM $db->tbl_fix`delivery` del
					INNER JOIN  $db->tbl_fix`showroom` sr ON sr.id = del.shipper_id
					WHERE $type AND del.shop_id = '$shop_id'
				) del ON del.order_id = od.`id` AND od.`shop_id` = del.`shop_id`
				WHERE od.`shop_id`='$shop_id' $order_type $is_booking $created_by_client_id $keyword $status_showroom $payment_type
				GROUP BY od.`id` ORDER BY del.`order_created_at` DESC
				$limit";

		$result = $db->executeQuery($sql);
		$kq = array();

		if ($result != '')
			while ($row = mysqli_fetch_assoc($result)) {

				$row['total'] 			= $detail_order->get_sum_order($shop_id, $row['id'], $row['last_update']);
				$row['shop_name'] 		= $shop->get_shop_name($row['shop_id']);
				$row['last_update'] 	= date('d/m/Y', $row['last_update']);
				$kq[] = $row;
			}
		return $kq;
	}


	public function list_booking_processing_count($shop_id, $keyword = '', $year = '', $type)
	{
		global $db, $user, $setup;
		$detail_order = new detail_order();

		if ($year == '') $year = date('Y');

		$created_by_client_id = $this->get('created_by_client_id');
		if ($created_by_client_id != '') {
			$created_by_client_id = " AND od.`created_by_client_id` = '$created_by_client_id' ";
		} else {
			$created_by_client_id = " AND od.`created_by_client_id` > 0 ";
		}

		if ($type != '' && $type == 'processing') {
			$type = "del.shipper_status > -1 AND del.shipper_status != 3";
		} else if ($type != '' && $type == 'done') {
			$type = "del.shipper_status = 3";
		} else if ($type != '' && $type == 'cancel') {
			$type = "del.shipper_status = -2";
		} else {
			$type = "";
		}

		if ($shop_id == '') $shop_id = "1";

		if ($keyword != '') $keyword = " AND ( od.`id` = '$keyword' OR `name_customer` LIKE '%$keyword%' OR `mobile_customer` LIKE '%$keyword%' ) ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT COUNT(*) total
				FROM (
					$sqlOrderTable
				) `od`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.id = cp.order_id
				INNER JOIN (
					SELECT del.order_id, del.shop_id, del.shipper_id delivery_id, del.order_created_at
					, del.note delivery_note, del.shipper_status delivery_status
					FROM $db->tbl_fix`delivery` del
					WHERE $type AND del.shop_id = '$shop_id'
				) del ON del.order_id = od.`id` AND od.`shop_id` = del.`shop_id`
				WHERE od.`shop_id`='$shop_id' $created_by_client_id";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	public function list_booking_delivery($shipper_id)
	{
		global $db, $user, $detail_order, $shop;

		$year = date('Y');

		$id_customer = $this->get('id_customer');
		if ($id_customer != '') $id_customer = " AND od.`id_customer` = '$id_customer' ";

		$sql = "SELECT od.id, od.`last_update`, od.`note`, od.`name_customer` fullname,
		od.`mobile_customer` mobile, od.`code`, od.`user_add`,
		od.`shop_id`, od.`created_at`, od.`ship_name`, od.`ship_mobile`, 
		od.`ship_note`,od.`ship_address`, od.`status`, del.order_id, del.shop_id,
		del.shipper_id delivery_id, mb.fullname delivery_name, mb.mobile delivery_mobile, 
		mb.address delivery_address, del.note delivery_note, del.shipper_status delivery_status
		FROM delivery del
		INNER JOIN members mb ON del.customer_id = mb.user_id
		INNER JOIN order_1_2020 od ON del.order_id = od.id
		WHERE del.shipper_id = $shipper_id";

		$result = $db->executeQuery($sql);
		$kq = array();

		while ($row = mysqli_fetch_assoc($result)) {

			$row['total'] 			= $detail_order->get_sum_order(1, $row['id'], $row['last_update']);
			$row['shop_name'] 		= $shop->get_shop_name($row['shop_id']);
			$row['last_update'] 	= date('d/m/Y', $row['last_update']);
			$kq[] = $row;
		}

		return $kq;
	}

	// public function list_order_customer_cancel($shop_id) //(tùng code) lấy danh sách đơn hàng khách hàng hủy  --- không dùng
	// {
	// 	global $db;

	// 	$sql = "SELECT od.`id`, od.`shop_id`, od.`created_at`, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`id` code, od.`ship_name`,
	// 	od.`ship_mobile`, od.`ship_note`, od.`total`, od.`address_book_id`, sh.`name` shop_name
	// 	FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y') . "` as `od`
	// 	INNER JOIN shop sh ON od.shop_id = sh.id
	// 	WHERE od.`status` = '-3'";

	// 	$result = $db->executeQuery_list($sql);

	// 	return $result;
	// }

	// public function list_order_customer_cancel_count($customer_id)//(tùng code) đếm danh sách đơn hàng khách hàng hủy  --- không dùng
	// {
	// 	global $db;

	// 	$sql = "SELECT COUNT(*) total FROM delivery del WHERE del.`customer_id` = $customer_id AND del.`shipper_status` = '-2'";

	// 	$result = $db->executeQuery($sql);

	// 	return $result['total']+0;
	// }

	public function list_retrieve($shop_id, $keyword = '', $year = '', $offset = '', $limit = '')
	{
		global $db, $db_store, $user, $setup;
		$detail_order 		= new detail_order();
		$collected_payments = new collected_payments();

		if ($keyword != '') $keyword = "AND ( od.`name_customer` LIKE '%$keyword%' 
												OR mb.`code` LIKE '%$keyword%' 
												OR od.`mobile_customer` LIKE '%$keyword%' 
												OR od.`id` LIKE '%$keyword%' 
												OR od.`note` LIKE '%$keyword%'
											)";

		if ($limit !== '') $limit = "LIMIT $offset, $limit";

		$sql = "SELECT od.`id`, od.`treasurer`, od.`last_update`, od.`last_update` last_update_at, od.`note`, od.`mobile_customer` members_mobile, od.`name_customer` `fullname`, IFNULL(mb.`code`, '') members_code, IF(od.`user_add` = '', 'Khách đặt', od.`user_add`) user_add, od.`created_at`, od.`total`
						, od.`ship_name`, od.`ship_mobile`, od.`ship_address`, od.`ship_note`
						, IFNULL(payment.`name`, '') payment_name
				FROM $db->tbl_fix`order_" . $shop_id . "_" . $year . "` `od`
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
				LEFT JOIN $db_store->tbl_fix`method_payment` payment ON payment.`id` = od.`payment_type`
				WHERE od.`shop_id`='$shop_id' 
				AND od.`order_type` = 0
				AND od.`status` = -2
				$keyword
				ORDER BY `created_at` DESC
				$limit";

		$result = $db->executeQuery($sql);
		$kq = array();

		while ($row = mysqli_fetch_assoc($result)) {

			$collected_payments->set('shop_id', $shop_id);
			$collected_payments->set('order_id', $row['id']);
			$row['detail_payment'] = $collected_payments->list_by_order();

			$row['total'] 		= $detail_order->get_sum_order($shop_id, $row['id'], $row['last_update']);
			$row['last_update'] = date('d/m/Y', $row['last_update']);
			$kq[] = $row;
		}

		return $kq;
	}

	public function list_retrieve_count($shop_id, $keyword = '', $year = '')
	{
		global $db, $db_store, $user, $setup;
		$detail_order = new detail_order();

		if ($year == '') {
			$year = date('Y');
		}

		if ($keyword != '') $keyword = "AND ( od.`name_customer` LIKE '%$keyword%' 
												OR mb.`code` LIKE '%$keyword%' 
												OR od.`mobile_customer` LIKE '%$keyword%' 
												OR od.`id` LIKE '%$keyword%' 
												OR od.`note` LIKE '%$keyword%'
											)";

		$sql = "SELECT COUNT(*) total
				FROM $db->tbl_fix`order_" . $shop_id . "_" . $year . "` `od`
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
				WHERE 
				od.`shop_id`='$shop_id' 
				AND od.`order_type` = 0
				AND od.`status` =-2 
				$keyword";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	public function delete_item($shop_id, $id, $created_at)
	{
		global $db;

		$db->record_delete($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", " `id` = '$id' ");
		$db->record_delete($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "`", " `order_id` = '" . $id . "'");
		$db->record_delete($db->tbl_fix . "`collected_orders`", " `order_id` = '$id' AND `shop_id` = '$shop_id' ");
		$db->record_delete($db->tbl_fix . "`collected_payments`", " `order_id` = '$id' AND `shop_id` = '$shop_id' ");
		$db->record_delete($db->tbl_fix . "`treasurer`", " `MATT` = '$id' AND `shop_id` = '$shop_id' AND `is_auto` = '1' ");
		$db->record_delete($db->tbl_fix . "`order_detail_combo`", " `order_id` = '$id' AND `shop_id` = '$shop_id' ");

		return true;
	}

	//xoa don hang do client tu tao => chi don thanh cong moi xoa theo ham nay
	public function delete_for_client($shop_id, $id, $created_at) //xóa cho client là chuyển đơn hàng sang trạng thái hủy
	{
		global $db;

		$this->set('shop_id', $shop_id);
		$this->set('id', $id);
		$this->set('created_at', $created_at);
		$this->update_delete_for_client($shop_id, $created_at);

		$db->record_delete($db->tbl_fix . "`treasurer`", " `MATT` = '$id' AND `shop_id` = '$shop_id' AND `is_auto` = '1' ");

		return true;
	}

	public function change_order_id($new_id)
	{
		global $db;

		$shop_id 		= $this->get('shop_id');
		$id 			= $this->get('id');
		$created_at 	= $this->get('created_at');
		$for_client_id 	= $this->get('for_client_id');

		$arr['id'] 				= $new_id;
		$arr['code'] 			= $new_id;
		$arr['for_client_id'] 	= $for_client_id;

		$arr2['order_id'] 	= $new_id;

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$id' ");
		$db->record_update($db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr2, " `order_id` = '$id' ");
		$db->record_update($db->tbl_fix . "`collected_orders`", $arr2, " `order_id` = '$id' AND `shop_id` = '$shop_id' ");
		$db->record_update($db->tbl_fix . "`collected_payments`", $arr2, " `order_id` = '$id' AND `shop_id` = '$shop_id' ");

		return true;
	}

	public function update_total_order($shop_id, $order_id, $created_at)
	{
		global $db, $detail_order;

		$total = $detail_order->get_sum_order($shop_id, $order_id, $created_at);

		$arr['total'] = $total + 0;
		$db->record_update("$db->tbl_fix`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$order_id' ");

		$arr1['sum'] = $total + 0;
		$db->record_update("$db->tbl_fix`collected_orders`", $arr1, " `order_id` = '$order_id' ");

		return true;
	}

	public function update_member_to_bill($shop_id, $order_id, $id_customer, $name_customer, $mobile_customer, $no_customer, $created_at, $is_official_customer = 0)
	{
		global $db;

		$arr['id_customer'] = $id_customer;
		$arr['is_official_customer'] = $is_official_customer;
		$arr['name_customer'] = $name_customer;
		$arr['mobile_customer'] = $mobile_customer;
		$arr['no_customer'] = $no_customer;

		$db->record_update("`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '" . $order_id . "' ");
		return true;
	}

	public function update_storing()
	{
		global $db;

		$shop_id 		= $this->get('shop_id');
		$id 			= $this->get('id');
		$created_at 	= $this->get('created_at');

		$arr['note'] 			= $this->get('note');
		$arr['url_chung_tu'] 	= $this->get('url_chung_tu');
		$arr['is_correction'] 	= $this->get('is_correction');

		$db->record_update("`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$id' ");
		return true;
	}

	public function update_pro_allow_commission() //Pro allow commission in first branch 
	{
		global $db;

		$shop_id 		= $this->get('shop_id');
		$id 			= $this->get('id');
		$created_at 	= $this->get('created_at');

		$pro_allow_commission 			= $this->get('pro_allow_commission');
		$pro_allow_commission_value 	= $this->get('pro_allow_commission_value') + 0;
		$pro_allow_commission_percent 	= $this->get('pro_allow_commission_percent') + 0;

		$arr['pro_allow_commission'] 			= $pro_allow_commission;
		$arr['pro_allow_commission_value'] 		= $pro_allow_commission_value;
		$arr['pro_allow_commission_percent'] 	= $pro_allow_commission_percent;

		$db->record_update("$db->tbl_fix`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$id' ");
		$db->record_update("$db->tbl_fix`collected_orders`", $arr, " `order_id` = '$id' AND `shop_id` = '$shop_id' ");

		return true;
	}

	public function update_url_chung_tu()
	{
		global $db;

		$shop_id 		= $this->get('shop_id');
		$id 			= $this->get('id');
		$created_at 	= $this->get('created_at');
		$arr['url_chung_tu'] 	= $this->get('url_chung_tu');

		$db->record_update("`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$id' ");

		return true;
	}

	public function update_member_to_bill_with_ship_info()
	{
		global $db;

		$shop_id	= $this->get('shop_id');
		$order_id	= $this->get('id');
		$created_at	= $this->get('created_at');

		$arr['is_official_customer'] 	= $this->get('is_official_customer');

		$arr['id_customer'] 			= $this->get('id_customer');
		$arr['name_customer'] 			= $this->get('name_customer');
		$arr['mobile_customer'] 		= $this->get('mobile_customer');
		$arr['no_customer'] 			= $this->get('no_customer');

		$arr['ship_name'] 				= $this->get('ship_name');
		$arr['ship_mobile'] 			= $this->get('ship_mobile');
		$arr['ship_address'] 			= $this->get('ship_address');
		$arr['ship_note'] 				= $this->get('ship_note');

		$arr['address_book_id'] 		= $this->get('address_book_id');

		$db->record_update("`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$order_id' ");
		return true;
	}

	public function remove_member_from_bill()
	{
		global $db;

		$shop_id	= $this->get('shop_id');
		$order_id	= $this->get('id');
		$created_at	= $this->get('created_at');

		$arr['is_official_customer'] 	= '0';

		$arr['id_customer'] 			= '0';
		$arr['name_customer'] 			= '';
		$arr['mobile_customer'] 		= '';
		$arr['no_customer'] 			= '0';

		$arr['ship_name'] 				= '';
		$arr['ship_mobile'] 			= '';
		$arr['ship_address'] 			= '';
		$arr['ship_note'] 				= '';

		$arr['address_book_id'] 		= '0';

		$db->record_update("`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '" . $order_id . "' ");
		return true;
	}

	public function update_field($shop_id, $order_id, $created_at)
	{
		global $db;

		$arr['treasurer_id'] = $this->get('treasurer_id');

		$db->record_update("`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '" . $order_id . "' ");
		return true;
	}

	public function update_payment_type($shop_id, $id, $payment_type = 0, $created_at)
	{
		global $db;

		$arr['payment_type'] = $payment_type + 0;
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='" . $id . "'");

		return true;
	}

	public function objOrder($shop_id, $order_id, $created_at)
	{
		global $db;
		$detail_order = new detail_order();

		$sql = "SELECT * FROM `order_" . $shop_id . "_" . date('Y', $created_at) . "` as `od` WHERE `od`.`id`='" . $order_id . "' LIMIT 1";
		$kq = $db->executeQuery($sql, 1);
		$kq['detail_order'] = $detail_order->arrDetailOrder($shop_id, $order_id, $created_at);

		return $kq;
	}

	public function get_max_id($shop_id, $user_add)
	{
		global $db;
		$startDate = strtotime(date('m/d/Y'));
		$sql = "SELECT id FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y') . "` WHERE `created_at`>'$startDate' ORDER BY `id` DESC, `created_at` DESC LIMIT 1";
		$result = $db->executeQuery($sql, 1);
		if (isset($result['id'])) {
			return substr($result['id'], 0, 3) + 1;
		} else {
			return 1;
		}
	}

	public function get_id($shop_id, $user_add)
	{
		global $db, $main;
		$user = new user();
		$dUser = $user->get_detail($user_add);

		$startDate = strtotime(date('m/d/Y'));

		$sql = "SELECT `id` FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y') . "` WHERE `created_at` > '$startDate' AND `order_type` = '0' ORDER BY `created_at` DESC LIMIT 1";
		$result = $db->executeQuery($sql, 1);
		if (isset($result['id'])) {
			$id = substr($result['id'], 0, 3) + 1;
			$id = sprintf("%03d", $id) . date('ymd') . $dUser['strID'] . $main->randString(3);
			unset($dUser);
			return $id;
		} else {
			$id = '001' . date('ymd') . $dUser['strID'] . $main->randString(3);
			unset($dUser);
			return $id;
		}
	}

	public function get_id_storing($shop_id, $warehouse_id, $user_add)
	{
		global $db, $main;
		$user = new user();

		$startDate = strtotime(date('m/d/Y'));

		$sql = "SELECT `id`, `last_update` FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y') . "` WHERE `created_at` > '$startDate' AND `warehouse_id` = '$warehouse_id' AND `order_type` = '1' AND `user_add` = '$user_add' ORDER BY `id` DESC LIMIT 1";

		$row = $db->executeQuery($sql, 1);

		if ($row['id'] != '') {
			$str = substr($row['id'], 7, 3);
			return date('ymd') . 'X' . sprintf("%03d", ($str + 1)) . $main->randString(3);
		} else {
			return date('ymd') . 'X001' . $main->randString(3);
		}
	}

	public function filter($keyword, $from, $to, $offset = 0, $limit = '')
	{
		global $db, $detail_order, $wh, $shop, $providers;

		$liabilities 		= new liabilities();
		$method_payment 	= new method_payment();

		$shop_id 		= $this->get('shop_id');
		$warehouse_id 	= $this->get('warehouse_id');
		$treasurer 		= $this->get('treasurer');
		$order_type 	= $this->get('order_type');

		if ($limit != '') $limit = "LIMIT $offset, $limit ";

		// $sqlFilter = "	AND od.`created_at` >= '$from'
		// 				AND od.`created_at` < '$to'";
		if ($keyword != '') {
			$sqlFilter = " AND (od.`id` LIKE '%$keyword%' OR od.`user_add` LIKE '%$keyword%' )";
		}


		// $sql = "SELECT `od`.*, `od`.id order_id, user.`fullname` `user_add`
		// 		FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od
		// 		LEFT JOIN `user` ON user.username = od.user_add
		// 		WHERE od.shop_id = '$shop_id' 
		// 		AND od.warehouse_id = '$warehouse_id'
		// 		AND od.order_type = '$order_type'
		// 		AND od.printed='1'
		// 		AND od.status='1' 
		// 		ORDER BY od.created_at DESC, od.`id`
		// 		$limit";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT `od`.*, `od`.id order_id, user.`fullname` `user_add`
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od
				LEFT JOIN `user` ON user.username = od.user_add
				WHERE od.shop_id = '$shop_id' 
				AND od.warehouse_id = '$warehouse_id'
				AND od.order_type = '$order_type'
				AND od.printed>'0'
				AND od.status='1' 
				ORDER BY od.created_at DESC, od.`id`
				$limit";



		// $sql = "SELECT `od`.*, `od`.id order_id, user.`fullname` `user_add`
		// 		FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od
		// 		LEFT JOIN `user` ON user.username = od.user_add
		// 		WHERE od.shop_id = '$shop_id' 
		// 		AND od.warehouse_id = '$warehouse_id'
		// 		AND od.order_type = '$order_type'
		// 		AND od.printed='1'
		// 		AND od.status='1' 
		// 		$sqlFilter
		// 		ORDER BY od.created_at DESC, od.`id`
		// 		$limit";

		$result = $db->executeQuery($sql);
		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {

			$row['lItems'] = $lItems = $detail_order->listby_order_grouped($shop_id, $row['id'], $row['created_at']);

			$method_payment->set('id', $row['payment_type']);
			$row['method_payment'] = $method_payment->get_name();
			$row['warehouse_name']	= $wh->get_detail_name($row['warehouse_id']) . '';
			$row['sum']				= $detail_order->get_sum_order($shop_id, $row['id'], $row['created_at']);

			$row['regard_to'] = $row['name_customer'];
			if ($row['is_internal'] == '1')
				$row['regard_to'] = $wh->get_detail_name($row['export_for_wh_id']) . '';

			$row['liabilities_total'] 	= $row['total'];
			$row['liabilities_paid'] 	= $row['total'];
			$row['liabilities_left'] 	= 0;
			if ($row['payment_type'] == 1) {
				$liabilities->set('id', $row['liabilities_id']);
				$dLia = $liabilities->get_detail();
				$row['liabilities_total'] 	= $dLia['total'];
				$row['liabilities_paid'] 	= $dLia['total_paid'];
				$row['liabilities_left'] 	= $dLia['total_left'];
			}

			$kq[] = $row;
		}

		return $kq;
	}

	public function filter_count($keyword, $from, $to)
	{
		global $db;

		$shop_id 			= $this->get('shop_id');
		$warehouse_id 		= $this->get('warehouse_id');
		$order_type 		= $this->get('order_type');

		$sqlFilter = "	AND od.`created_at` >= '$from'
						AND od.`created_at` < '$to'";
		if ($keyword != '') {
			$sqlFilter = " AND ( od.`id` LIKE '%$keyword%' OR od.`user_add` LIKE '%$keyword%' )";
		}

		// $sql = "SELECT COUNT(*) total_record
		// 		FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od 
		// 		WHERE od.shop_id = '$shop_id' 
		// 		AND od.warehouse_id = '$warehouse_id'
		// 		AND od.order_type = '$order_type'
		// 		AND od.printed='1'
		// 		AND od.status='1' 
		// 		$sqlFilter
		// 		";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT COUNT(*) total_record
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od 
				WHERE od.shop_id = '$shop_id' 
				AND od.warehouse_id = '$warehouse_id'
				AND od.order_type = '$order_type'
				AND od.printed>'0'
				AND od.status='1' 
				$sqlFilter
				";

		$result = $db->executeQuery($sql, 1);

		return $result['total_record'];
	}

	public function filter_returning($keyword, $from, $to, $offset = 0, $limit = '')
	{
		global $db;

		$shop_id 	= $this->get('shop_id');
		$treasurer 	= $this->get('treasurer');

		if ($treasurer != '') $treasurer = "AND od.`treasurer` = '$treasurer' ";
		if ($keyword != '') $keyword = "AND dt.`name` = '$keyword' ";

		if ($limit != '') $limit = "LIMIT $offset, $limit ";

		// $sql = "SELECT od.`id` `order_id`, od.`last_update` order_created_at, dt.`id` detail_order_id, dt.`name`, ABS(dt.`quantity`) quantity, dt.`price`, dt.`root_price`, dt.`product_id`, od.`treasurer`, od.`note`
		// 		FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od 
		// 		INNER JOIN `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt ON dt.order_id = od.id
		// 		WHERE od.shop_id = '$shop_id' 
		// 		AND od.printed='1'
		// 		AND od.status='1' 
		// 		AND od.created_at >= '$from'
		// 		AND od.created_at < '$to'
		// 		AND od.returned_from_order_id <> ''
		// 		AND od.returned_from_created_at > 0
		// 		$treasurer
		// 		$keyword
		// 		ORDER BY od.created_at DESC, od.`id`, dt.`name`
		// 		$limit";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT od.`id` `order_id`, od.`last_update` order_created_at, dt.`id` detail_order_id, dt.`name`, ABS(dt.`quantity`) quantity, dt.`price`, dt.`root_price`, dt.`product_id`, od.`treasurer`, od.`note`
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od 
				INNER JOIN `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt ON dt.order_id = od.id
				WHERE od.shop_id = '$shop_id' 
				AND od.printed>'0'
				AND od.status='1' 
				AND od.created_at >= '$from'
				AND od.created_at < '$to'
				AND od.returned_from_order_id <> ''
				AND od.returned_from_created_at > 0
				$treasurer
				$keyword
				ORDER BY od.created_at DESC, od.`id`, dt.`name`
				$limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function filter_returning_info($keyword, $from, $to)
	{
		global $db;

		$shop_id 	= $this->get('shop_id');
		$treasurer 	= $this->get('treasurer');

		if ($treasurer != '') $treasurer = "AND od.`treasurer` = '$treasurer' ";
		if ($keyword != '') $keyword = "AND dt.`name` = '$keyword' ";

		// $sql = "SELECT COUNT(*) total_record, SUM(ABS(dt.`quantity`)*dt.`price`*(1 - (dt.`decrement`/100) ) ) total_revenue
		// 		FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od 
		// 		INNER JOIN `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt ON dt.order_id = od.id
		// 		WHERE od.shop_id = '$shop_id' 
		// 		AND od.printed='1'
		// 		AND od.status='1' 
		// 		AND od.created_at >= '$from'
		// 		AND od.created_at < '$to'
		// 		AND od.returned_from_order_id <> ''
		// 		AND od.returned_from_created_at > 0
		// 		$treasurer
		// 		$keyword
		// 		";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT COUNT(*) total_record, SUM(ABS(dt.`quantity`)*dt.`price`*(1 - (dt.`decrement`/100) ) ) total_revenue
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od 
				INNER JOIN `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt ON dt.order_id = od.id
				WHERE od.shop_id = '$shop_id' 
				AND od.printed>'0'
				AND od.status='1' 
				AND od.created_at >= '$from'
				AND od.created_at < '$to'
				AND od.returned_from_order_id <> ''
				AND od.returned_from_created_at > 0
				$treasurer
				$keyword
				";

		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function filter_discount($keyword, $from, $to, $offset = 0, $limit = '')
	{
		global $db;

		$shop_id 	= $this->get('shop_id');
		$treasurer 	= $this->get('treasurer');

		if ($treasurer != '') $treasurer = "AND od.`treasurer` = '$treasurer' ";
		if ($keyword != '') $keyword = "AND dt.`name` = '$keyword' ";

		if ($limit != '') $limit = "LIMIT $offset, $limit ";

		// $sql = "SELECT od.`id` `order_id`, od.`last_update` order_created_at, dt.`id` detail_order_id, dt.`name`, dt.`quantity`, dt.`price`, dt.`root_price`, dt.`product_id`, od.`note`, dt.`decrement`
		// 		FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od 
		// 		INNER JOIN `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt ON dt.order_id = od.id
		// 		WHERE od.shop_id = '$shop_id' 
		// 		AND od.printed='1'
		// 		AND od.status_booking='0'
		// 		AND od.status='1' 
		// 		AND od.created_at >= '$from'
		// 		AND od.created_at < '$to'
		// 		AND (
		// 				( dt.quantity < 0 AND dt.product_id = 0 AND dt.sku_id = 0 )
		// 				OR
		// 				( dt.decrement > 0 )
		// 			)
		// 		$treasurer
		// 		$keyword
		// 		ORDER BY od.created_at DESC, od.`id`, dt.`name`
		// 		$limit";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT od.`id` `order_id`, od.`last_update` order_created_at, dt.`id` detail_order_id, dt.`name`, dt.`quantity`, dt.`price`, dt.`root_price`, dt.`product_id`, od.`note`, dt.`decrement`
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od 
				INNER JOIN `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt ON dt.order_id = od.id
				WHERE od.shop_id = '$shop_id' 
				AND od.printed>'0'
				AND od.status_booking='0'
				AND od.status='1' 
				AND od.created_at >= '$from'
				AND od.created_at < '$to'
				AND (
						( dt.quantity < 0 AND dt.product_id = 0 AND dt.sku_id = 0 )
						OR
						( dt.decrement > 0 )
					)
				$treasurer
				$keyword
				ORDER BY od.created_at DESC, od.`id`, dt.`name`
				$limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function filter_discount_info($keyword, $from, $to)
	{
		global $db;

		$shop_id 	= $this->get('shop_id');
		$treasurer 	= $this->get('treasurer');

		if ($treasurer != '') $treasurer = "AND od.`treasurer` = '$treasurer' ";
		if ($keyword != '') $keyword = "AND dt.`name` = '$keyword' ";

		// $sql = "SELECT COUNT(*) total_record, SUM(dt.`quantity`*dt.`price`*(1 - (dt.`decrement`/100) ) ) total_revenue
		// 		FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od 
		// 		INNER JOIN `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt ON dt.order_id = od.id
		// 		WHERE od.shop_id = '$shop_id' 
		// 		AND od.printed='1'
		// 		AND od.status='1' 
		// 		AND od.status_booking='0'
		// 		AND od.created_at >= '$from'
		// 		AND od.created_at < '$to'
		// 		AND (
		// 				( dt.quantity < 0 AND dt.product_id = 0 AND dt.sku_id = 0 )
		// 				OR
		// 				( dt.decrement > 0 )
		// 			)
		// 		$treasurer
		// 		$keyword
		// 		ORDER BY od.created_at DESC, od.`id`, dt.`name`
		// 		";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT COUNT(*) total_record, SUM(dt.`quantity`*dt.`price`*(1 - (dt.`decrement`/100) ) ) total_revenue
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $from) . "` as od 
				INNER JOIN `detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt ON dt.order_id = od.id
				WHERE od.shop_id = '$shop_id' 
				AND od.printed>'0'
				AND od.status='1' 
				AND od.status_booking='0'
				AND od.created_at >= '$from'
				AND od.created_at < '$to'
				AND (
						( dt.quantity < 0 AND dt.product_id = 0 AND dt.sku_id = 0 )
						OR
						( dt.decrement > 0 )
					)
				$treasurer
				$keyword
				ORDER BY od.created_at DESC, od.`id`, dt.`name`
				";

		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	//cho báo cáo doanh số theo nhóm chiết khấu sản phẩm
	public function report_detail_selling_group_commission($shop_id, $lProductCommission, $lBrand, $lSupplier, $keyword, $from, $to, $field = '', $sort = '', $offset = 0, $limit = '')
	{ //from day(int) => to day (int)
		global $db, $db_store, $setup;

		if ($keyword != '') $keyword = " AND ( dt.`name` LIKE '%$keyword%' 
											OR od.`id` LIKE '%$keyword%' 
											OR od.`name_customer` LIKE '%$keyword%' 
											OR od.`mobile_customer` LIKE '%$keyword%' 
											OR od.`note` LIKE '%$keyword%' 
											OR mb.`code` LIKE '%$keyword%' 
											OR `SKU`.code LIKE '%$keyword%' ) ";

		$sqlProCom = '';
		if ($lProductCommission !== '') {
			$lProductCommission = explode(';', $lProductCommission);
			foreach ($lProductCommission as $item) {
				if ($item != '') {
					if ($item == '0') {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR  pro.`product_commission_id` IS NULL OR ";
					} else {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR ";
					}
				}
			}
			if ($sqlProCom != '') {
				$sqlProCom = substr($sqlProCom, 0, -3);
				$sqlProCom = "AND ($sqlProCom) ";
			}
		}

		$sqlBrand = '';
		if ($lBrand !== '') {
			$lBrand = explode(';', $lBrand);
			foreach ($lBrand as $item) {
				if ($item != '') {
					$sqlBrand .= " pro.`brand_id` = '$item' OR ";
				}
			}
			if ($sqlBrand != '') {
				$sqlBrand = substr($sqlBrand, 0, -3);
				$sqlBrand = "AND ($sqlBrand) ";
			}
		}

		$sqlSupplier 	= '';
		if ($lSupplier !== '') {
			$lSupplier = explode(';', $lSupplier);
			foreach ($lSupplier as $item) {
				if ($item != '') {
					$sqlSupplier .= " pro.`supplier_id` = '$item' OR ";
				}
			}
			if ($sqlSupplier != '') {
				$sqlSupplier = substr($sqlSupplier, 0, -3);
				$sqlSupplier = "AND ($sqlSupplier) ";
			}
		}

		$treasurer_group_id 	= $this->get('treasurer_group_id');
		$sqlTreasurerGroupID = '';
		if ($treasurer_group_id != '') {
			$lSI = explode(';', $treasurer_group_id);
			foreach ($lSI as $itDe) {
				if ($itDe != '') {
					$sqlTreasurerGroupID .= " od.treasurer_group_id = '$itDe' OR ";
				}
			}
			if ($sqlTreasurerGroupID != '') {
				$sqlTreasurerGroupID = "AND (" . substr($sqlTreasurerGroupID, 0, -3) . ") ";
			}
		}

		$treasurer_id 	= $this->get('treasurer_id');
		$sqlTreasurerGroupIDThu = ''; //Thu
		if ($treasurer_id != '') {
			$lSI = explode(';', $treasurer_id);
			foreach ($lSI as $itDe) {
				if ($itDe != '') {
					$sqlTreasurerGroupIDThu .= " od.treasurer_id = '$itDe' OR ";
				}
			}
			if ($sqlTreasurerGroupIDThu != '') {
				$sqlTreasurerGroupIDThu = "AND (" . substr($sqlTreasurerGroupIDThu, 0, -3) . ") ";
			}
		}

		if ($limit != '') $limit = " LIMIT $offset, $limit ";

		$order_type = $this->get('order_type');
		if ($order_type != '')
			$order_type = "AND od.`order_type` = '$order_type' ";
		else {
			$order_type = "AND ( od.`order_type` = '0' OR od.`order_type` = '1' ) ";
		}

		//sort
		$sqlSort = " ORDER BY `nTB`.name ";
		if (in_array($field, array(
			'product_commission_parent_name',
			'code',
			'product_commission_name',
			'member_code',
			'fullname',
			'mobile',
			'department_name',
			'created_at',
			'product_name',
			'amount',
			'payment_type',
			'order_id',
			'cost',
			'discount',
			'thanh_tien',
			'lai',
		))) {
			if (!in_array($sort, array('ASC', 'DESC'))) $sort = 'ASC';

			$sortFieldArr = array(
				'product_commission_parent_name'        => 'nTB.`product_commission_parent_name`',
				'product_commission_name'                      		=> 'nTB.`product_commission_name`',
				'created_at'                      		=> 'nTB.`created_at`',
				'code'                      			=> 'nTB.`sku_code`',
				'order_id'								=> 'ntb.`order_id`',
				'member_code'                      		=> 'nTB.`code`',
				'fullname'                      		=> 'nTB.`fullname`',
				'mobile'                      			=> 'nTB.`mobile`',
				'department_name'                      	=> 'nTB.`department_name`',
				'user_add'                      		=> 'nTB.`user_add`',

				'product_name'                			=> 'nTB.`name`',
				'amount'                				=> 'nTB.`amount`',
				'payment_type'                			=> 'nTB.`payment_type_name`',

				'cost'                					=> 'nTB.`cost`',
				'discount'                				=> 'nTB.`discount`',
				'thanh_tien'                			=> 'nTB.`thanh_tien`',
				'lai'                					=> 'nTB.`lai`'
			);

			$field = isset($sortFieldArr[$field]) ? $sortFieldArr[$field] : '';

			if ($field != '')
				$sqlSort = " ORDER BY $field $sort ";
		}

		$pro_ship_fee = isset($setup['pro_ship_fee']) && $setup['pro_ship_fee'] != '' ? $setup['pro_ship_fee'] : 0;

		// $sql = "SELECT * FROM (
		// 			SELECT dt.`id`, dt.`order_id`, od.`created_at` order_created_at, od.`created_at` created_at,  od.`last_update`, dt.`product_id`, dt.`name`, dt.`price`, od.`is_internal`, od.`export_for_wh_id`, od.`treasurer` user_add, od.`note`
		// 					, SUM(dt.`quantity`*dt.`root_price`) cost
		// 					, SUM( dt.`quantity`*dt.`price`* (dt.`decrement`/100) ) discount
		// 					, SUM( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) thanh_tien
		// 					, SUM( ( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) - (dt.`quantity`*dt.`root_price`) ) lai
		// 					, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount
		// 					, dt.`decrement`, dt.`vat`, dt.`root_price`, IFNULL(SKU.`code`, '') sku_code
		// 					, IFNULL( procom.`product_commission_parent_name`, 'Chưa khai chiết khấu/ kho') product_commission_parent_name
		// 					, IFNULL( procom.`product_commission_name`, 'Chưa khai chiết khấu') product_commission_name
		// 					, IFNULL(IF( od.`liabilities_id` > 0 AND od.`hold_date` = 1, 'Tổng hợp', payment.`name`), 'Không xác định') payment_type_name, od.`payment_type`, od.`liabilities_id`, od.`hold_date`
		// 					, IFNULL(mb.`code`, '') code, IFNULL(mb.`fullname`, '') fullname, IFNULL(mb.`mobile`, '') mobile
		// 					, IFNULL(mbdep.`name`, 'Chưa khai báo') department_name
		// 					, IFNULL(wh.`name`, '') export_for_wh_name
		// 					, IFNULL(trea.`id`, '0') treasurer_group_id
		// 					, IFNULL(trea.`name`, '') treasurer_group_name
		// 			FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 			INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id
		// 			LEFT JOIN $db->tbl_fix`treasurer_group` trea ON trea.id = od.treasurer_group_id
		// 			LEFT JOIN $db->tbl_fix`product` as pro ON pro.id = dt.product_id
		// 			LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
		// 			LEFT JOIN (
		// 				SELECT procom.id, IFNULL(parent.`name`, 'Chưa khai báo') product_commission_parent_name, procom.`name` product_commission_name
		// 				FROM $db->tbl_fix`product_commission` procom
		// 				LEFT JOIN $db->tbl_fix`product_commission` parent ON parent.id = procom.parent_id
		// 				WHERE procom.is_parent = 0
		// 			) procom ON procom.id = pro.product_commission_id
		// 			LEFT JOIN $db_store->tbl_fix`method_payment` payment ON payment.`id` = od.`payment_type`
		// 			LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
		// 			LEFT JOIN $db->tbl_fix`member_department` mbdep ON mbdep.`id` = mb.`member_department_id`
		// 			LEFT JOIN $db->tbl_fix`warehouse` wh ON wh.`id` = od.`export_for_wh_id`
		// 			WHERE od.printed='1' AND od.status='1' AND od.is_booking = '0' 
		// 			AND '$from' <= od.created_at AND od.created_at < '$to' 
		// 			$keyword 
		// 			$sqlProCom 
		// 			$order_type 
		// 			$sqlTreasurerGroupID 
		// 			$sqlTreasurerGroupIDThu
		// 			$sqlBrand
		// 			$sqlSupplier
		// 			GROUP BY dt.order_id, dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement, od.payment_type
		// 		) nTB WHERE 1
		// 		$sqlSort
		// 		$limit
		// 		"; // AND `dt`.product_id > 0 //od.`is_booking` = 0 AND
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT nTB.* 
						,IFNULL( ctv.`fullname`, '' ) referral_fullname
						,IFNULL( ctv.`code` , '' ) referral_code
						,IFNULL( ctv.`bank_account`, '0' ) bank_account
						,IFNULL( ctv.`member_group_id`, '') member_group_id
						,IFNULL( dls.`name` ,'') status_name 
						FROM (
					SELECT dt.`id`, dt.`order_id`, od.`created_at` order_created_at, od.`created_at` created_at,  od.`last_update`, dt.`product_id`, dt.`name`, dt.`price`, od.`is_internal`, od.`export_for_wh_id`, od.`treasurer` user_add, od.`note`
							, SUM(dt.`quantity`*dt.`root_price`) cost
							, SUM( dt.`quantity`*dt.`price`* (dt.`decrement`/100) ) discount
							, SUM( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) thanh_tien
							, SUM( ( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) - (dt.`quantity`*dt.`root_price`) ) lai
							, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount
							, dt.`decrement`, dt.`vat`, dt.`root_price`, IFNULL(SKU.`code`, '') sku_code
							, IFNULL( procom.`product_commission_parent_name`, 'Chưa khai chiết khấu/ kho') product_commission_parent_name
							, IFNULL( procom.`product_commission_name`, 'Chưa khai chiết khấu') product_commission_name
							, IFNULL(IF( od.`liabilities_id` > 0 AND od.`hold_date` = 1, 'Tổng hợp', payment.`name`), 'Không xác định') payment_type_name, od.`payment_type`, od.`liabilities_id`, od.`hold_date`,od.`service_fee`
							, IFNULL(mb.`code`, '') code, IFNULL(mb.`fullname`, '') fullname, IFNULL(mb.`mobile`, '') mobile ,IFNULL( mb.`referral_by`, '' ) referral_by
							, IFNULL(mbdep.`name`, 'Chưa khai báo') department_name
							, IFNULL(wh.`name`, '') export_for_wh_name
							, IFNULL(trea.`id`, '0') treasurer_group_id
							, IFNULL(trea.`name`, '') treasurer_group_name
							, IFNULL( dlh.`shipper_status`,'') shipper_status
					FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
					INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id
					LEFT JOIN $db->tbl_fix`treasurer_group` trea ON trea.id = od.treasurer_group_id
					LEFT JOIN $db->tbl_fix`product` as pro ON pro.id = dt.product_id
					LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
					LEFT JOIN $db->tbl_fix`delivery` as dlh ON dt.`order_id` = dlh.`order_id`
					LEFT JOIN (
						SELECT procom.id, IFNULL(parent.`name`, 'Chưa khai báo') product_commission_parent_name, procom.`name` product_commission_name
						FROM $db->tbl_fix`product_commission` procom
						LEFT JOIN $db->tbl_fix`product_commission` parent ON parent.id = procom.parent_id
						WHERE procom.is_parent = 0
					) procom ON procom.id = pro.product_commission_id
					LEFT JOIN $db_store->tbl_fix`method_payment` payment ON payment.`id` = od.`payment_type`
					LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
					LEFT JOIN $db->tbl_fix`member_department` mbdep ON mbdep.`id` = mb.`member_department_id`
					LEFT JOIN $db->tbl_fix`warehouse` wh ON wh.`id` = od.`export_for_wh_id`
					WHERE od.printed>'0' AND od.status='1' AND od.is_booking = '0' 
					AND '$from' <= od.created_at AND od.created_at < '$to'
					$keyword 
					$sqlProCom 
					$order_type 
					$sqlTreasurerGroupID 
					$sqlTreasurerGroupIDThu
					$sqlBrand
					$sqlSupplier
					GROUP BY dt.order_id, dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement, od.payment_type
				) nTB
				LEFT JOIN $db->tbl_fix`members` ctv ON ctv.`code` = nTB.`referral_by`
	            LEFT JOIN $db->tbl_fix`delivery_steps` dls ON dls.`id` = nTB.`shipper_status` 
				WHERE 1 AND nTB.product_id <> '$pro_ship_fee'
				$sqlSort
				$limit
				"; // AND `dt`.product_id > 0 //od.`is_booking` = 0 AND
		//nTB.amount > 0
		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function report_detail_selling_group_commission_info($shop_id, $lProductCommission, $lBrand, $lSupplier, $keyword, $from, $to)
	{ //from day(int) => to day (int)
		global $db;

		if ($keyword != '') $keyword = " AND ( dt.`name` LIKE '%$keyword%' 
											OR od.`id` LIKE '%$keyword%' 
											OR od.`name_customer` LIKE '%$keyword%' 
											OR od.`mobile_customer` LIKE '%$keyword%' 
											OR od.`note` LIKE '%$keyword%' 
											OR mb.`code` LIKE '%$keyword%' 
											OR `SKU`.code LIKE '%$keyword%' ) ";

		$sqlProCom = '';
		if ($lProductCommission !== '') {
			$lProductCommission = explode(';', $lProductCommission);
			foreach ($lProductCommission as $item) {
				if ($item != '') {
					if ($item == '0') {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR  pro.`product_commission_id` IS NULL OR ";
					} else {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR ";
					}
				}
			}
			if ($sqlProCom != '') {
				$sqlProCom = substr($sqlProCom, 0, -3);
				$sqlProCom = "AND ($sqlProCom) ";
			}
		}

		$sqlBrand = '';
		if ($lBrand !== '') {
			$lBrand = explode(';', $lBrand);
			foreach ($lBrand as $item) {
				if ($item != '') {
					$sqlBrand .= " pro.`brand_id` = '$item' OR ";
				}
			}
			if ($sqlBrand != '') {
				$sqlBrand = substr($sqlBrand, 0, -3);
				$sqlBrand = "AND ($sqlBrand) ";
			}
		}

		$sqlSupplier 	= '';
		if ($lSupplier !== '') {
			$lSupplier = explode(';', $lSupplier);
			foreach ($lSupplier as $item) {
				if ($item != '') {
					$sqlSupplier .= " pro.`supplier_id` = '$item' OR ";
				}
			}
			if ($sqlSupplier != '') {
				$sqlSupplier = substr($sqlSupplier, 0, -3);
				$sqlSupplier = "AND ($sqlSupplier) ";
			}
		}

		$treasurer_group_id 	= $this->get('treasurer_group_id');
		$sqlTreasurerGroupID = ''; //Lý do xuất
		if ($treasurer_group_id != '') {
			$lSI = explode(';', $treasurer_group_id);
			foreach ($lSI as $itDe) {
				if ($itDe != '') {
					$sqlTreasurerGroupID .= " od.treasurer_group_id = '$itDe' OR ";
				}
			}
			if ($sqlTreasurerGroupID != '') {
				$sqlTreasurerGroupID = "AND (" . substr($sqlTreasurerGroupID, 0, -3) . ") ";
			}
		}

		$treasurer_id 	= $this->get('treasurer_id');
		$sqlTreasurerGroupIDThu = ''; //Thu
		if ($treasurer_id != '') {
			$lSI = explode(';', $treasurer_id);
			foreach ($lSI as $itDe) {
				if ($itDe != '') {
					$sqlTreasurerGroupIDThu .= " od.treasurer_id = '$itDe' OR ";
				}
			}
			if ($sqlTreasurerGroupIDThu != '') {
				$sqlTreasurerGroupIDThu = "AND (" . substr($sqlTreasurerGroupIDThu, 0, -3) . ") ";
			}
		}

		$order_type = $this->get('order_type');
		if ($order_type != '')
			$order_type = "AND od.`order_type` = '$order_type' ";
		else {
			$order_type = "AND ( od.`order_type` = '0' OR od.`order_type` = '1' ) ";
		}
		// $sql = "SELECT
		// 				COUNT(*) total_record,
		// 				SUM(IFNULL(total_revenue, 0)) total_revenue,
		// 				SUM(IFNULL(total_cost, 0)) total_cost,
		// 				SUM(IFNULL(total_discount, 0)) total_discount,
		// 				SUM(IFNULL(total_quantity, 0)) total_quantity
		// 		FROM (
		// 			SELECT 
		// 				SUM(dt.`quantity`*dt.`price`*((100 - dt.`decrement`)/100)) total_revenue,
		// 				SUM(dt.`quantity`*dt.`root_price`) total_cost,
		// 				SUM(dt.`quantity`*dt.`price`*(dt.`decrement`/100)) total_discount,
		// 				SUM(ABS(dt.`quantity`)) total_quantity
		// 			FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 			INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
		// 			LEFT JOIN $db->tbl_fix`treasurer_group` trea ON trea.id = od.treasurer_group_id
		// 			LEFT JOIN $db->tbl_fix`product` as pro ON pro.id = dt.product_id
		// 			LEFT JOIN $db->tbl_fix`SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
		// 			LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
		// 			WHERE od.printed='1' AND od.status='1' AND od.is_booking = '0' 
		// 			AND '$from' <= od.created_at AND od.created_at < '$to' 
		// 			$keyword 
		// 			$sqlProCom 
		// 			$order_type 
		// 			$sqlTreasurerGroupID 
		// 			$sqlTreasurerGroupIDThu
		// 			$sqlBrand
		// 			$sqlSupplier
		// 			GROUP BY dt.order_id, dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement, od.payment_type
		// 		) dt
		// 		";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT
						COUNT(*) total_record,
						SUM(IFNULL(total_revenue, 0)) total_revenue,
						SUM(IFNULL(total_cost, 0)) total_cost,
						SUM(IFNULL(total_discount, 0)) total_discount,
						SUM(IFNULL(total_quantity, 0)) total_quantity
				FROM (
					SELECT 
						SUM(dt.`quantity`*dt.`price`*((100 - dt.`decrement`)/100)) total_revenue,
						SUM(dt.`quantity`*dt.`root_price`) total_cost,
						SUM(dt.`quantity`*dt.`price`*(dt.`decrement`/100)) total_discount,
						SUM(ABS(dt.`quantity`)) total_quantity
					FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
					INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
					LEFT JOIN $db->tbl_fix`treasurer_group` trea ON trea.id = od.treasurer_group_id
					LEFT JOIN $db->tbl_fix`product` as pro ON pro.id = dt.product_id
					LEFT JOIN $db->tbl_fix`SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
					LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
					WHERE od.printed>'0' AND od.status='1' AND od.is_booking = '0' 
					AND '$from' <= od.created_at AND od.created_at < '$to' 
					$keyword 
					$sqlProCom 
					$order_type 
					$sqlTreasurerGroupID 
					$sqlTreasurerGroupIDThu
					$sqlBrand
					$sqlSupplier
					GROUP BY dt.order_id, dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement, od.payment_type
				) dt
				";

		$r = $db->executeQuery($sql, 1); //od.`is_booking` = 0 AND

		return $r;
	}

	//Báo cáo chi tiết sản phẩm số lượng bán theo thời gian chọn
	//HC: 210630



	public function report_detail_selling($shop_id, $lProductCommission, $keyword, $from, $to, $field = '', $sort = '', $offset = 0, $limit = '')
	{ //from day(int) => to day (int)
		global $db, $db_store;

		if ($keyword != '') $keyword = " AND ( dt.`name` LIKE '%$keyword%' OR `SKU`.code LIKE '%$keyword%' ) ";

		$sqlProCom = '';
		if ($lProductCommission != '') {
			$lProductCommission = explode(';', $lProductCommission);
			foreach ($lProductCommission as $item) {
				if ($item != '') {
					if ($item == '0') {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR  pro.`product_commission_id` IS NULL OR";
					} else {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR ";
					}
				}
			}
			if ($sqlProCom != '') {
				$sqlProCom = substr($sqlProCom, 0, -3);
				$sqlProCom = "AND ($sqlProCom) ";
			}
		}

		$treasurer_group_id 	= $this->get('treasurer_group_id');
		$sqlTreasurerGroupID = '';
		if ($treasurer_group_id != '') {
			$lSI = explode(';', $treasurer_group_id);
			foreach ($lSI as $itDe) {
				if ($itDe != '') {
					$sqlTreasurerGroupID .= " od.treasurer_group_id = '$itDe' OR ";
				}
			}
			if ($sqlTreasurerGroupID != '') {
				$sqlTreasurerGroupID = "AND (" . substr($sqlTreasurerGroupID, 0, -3) . ") ";
			}
		}

		$treasurer_id 	= $this->get('treasurer_id');
		$sqlTreasurerGroupIDThu = ''; //Thu
		if ($treasurer_id != '') {
			$lSI = explode(';', $treasurer_id);
			foreach ($lSI as $itDe) {
				if ($itDe != '') {
					$sqlTreasurerGroupIDThu .= " od.treasurer_id = '$itDe' OR ";
				}
			}
			if ($sqlTreasurerGroupIDThu != '') {
				$sqlTreasurerGroupIDThu = "AND (" . substr($sqlTreasurerGroupIDThu, 0, -3) . ") ";
			}
		}


		if ($limit != '') $limit = " LIMIT $offset, $limit ";

		$order_type = $this->get('order_type');
		if ($order_type != '')
			$order_type = "AND od.`order_type` = '$order_type' ";
		else {
			$order_type = "AND ( od.`order_type` = '0' OR od.`order_type` = '1' ) ";
		}

		//sort
		$sqlSort = " ORDER BY `nTB`.name ";
		if (in_array($field, array(
			'product_commission_parent_name',
			'code',
			'product_commission_name',
			'created_at',
			'product_name',
			'amount',
			'cost',
			'discount',
			'thanh_tien',
			'total_real',
			'lai',
		))) {
			if (!in_array($sort, array('ASC', 'DESC'))) $sort = 'ASC';

			$sortFieldArr = array(
				'product_commission_parent_name'        => 'nTB.`product_commission_parent_name`',
				'product_commission_name'                      		=> 'nTB.`product_commission_name`',
				'created_at'                      		=> 'nTB.`created_at`',
				'code'                      			=> 'nTB.`sku_code`',
				'product_name'                			=> 'nTB.`name`',
				'amount'                				=> 'nTB.`amount`',
				'total_cost'                			=> 'nTB.`total_cost`',
				'discount'                				=> 'nTB.`discount`',
				'thanh_tien'                			=> 'nTB.`thanh_tien`',
				'total_real'                			=> 'nTB.`total_real`', //Thực thu
				'lai'                					=> 'nTB.`lai`'
			);

			$field = isset($sortFieldArr[$field]) ? $sortFieldArr[$field] : '';

			if ($field != '')
				$sqlSort = " ORDER BY $field $sort ";
		}

		// $sql = "SELECT * FROM (
		// 			SELECT  dt.`id`, dt.`product_id`, dt.`name`, dt.`price`, od.`is_internal`
		// 					, SUM(dt.`quantity`*dt.`root_price`) total_cost
		// 					, SUM( dt.`quantity`*dt.`price`* (dt.`decrement`/100) ) discount
		// 					, SUM( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) thanh_tien
		// 					, SUM( dt.`quantity`*dt.`price` ) total_real
		// 					, SUM( ( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) - (dt.`quantity`*dt.`root_price`) ) lai
		// 					, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount
		// 					, dt.`decrement`, dt.`vat`, dt.`root_price`, IFNULL(SKU.`code`, '') sku_code
		// 					, IFNULL(pro.`img_1`, '') `image`
		// 			FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 			INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id
		// 			LEFT JOIN $db->tbl_fix`product` as pro ON pro.id = dt.product_id
		// 			LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
		// 			WHERE od.printed='1' AND od.status='1' AND od.is_booking = '0' AND '$from' <= od.created_at AND od.created_at < '$to' 
		// 			$keyword $sqlProCom $order_type $sqlTreasurerGroupID $sqlTreasurerGroupIDThu
		// 			GROUP BY dt.product_id, dt.sku_id
		// 		) nTB WHERE 1
		// 		$sqlSort
		// 		$limit
		// 		";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT * FROM (
					SELECT  dt.`id`, dt.`product_id`, dt.`name`, dt.`price`, od.`is_internal`
							, SUM(dt.`quantity`*dt.`root_price`) total_cost
							, SUM( dt.`quantity`*dt.`price`* (dt.`decrement`/100) ) discount
							, SUM( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) thanh_tien
							, SUM( dt.`quantity`*dt.`price` ) total_real
							, SUM( ( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) - (dt.`quantity`*dt.`root_price`) ) lai
							, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount
							, dt.`decrement`, dt.`vat`, dt.`root_price`, IFNULL(SKU.`code`, '') sku_code
							, IFNULL(pro.`img_1`, '') `image`
					FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
					INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id
					LEFT JOIN $db->tbl_fix`product` as pro ON pro.id = dt.product_id
					LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
					WHERE od.printed>'0' AND od.status='1' AND od.is_booking = '0' AND '$from' <= od.created_at AND od.created_at < '$to' 
					$keyword $sqlProCom $order_type $sqlTreasurerGroupID $sqlTreasurerGroupIDThu
					GROUP BY dt.product_id, dt.sku_id
				) nTB WHERE 1
				$sqlSort
				$limit
				";

		$result = $db->executeQuery_list($sql);

		return $result;
	}
	//Báo cáo chi tiết sản phẩm số lượng bán theo thời gian chọn
	//HC: 210630
	public function report_detail_selling_info($shop_id, $lProductCommission, $keyword, $from, $to)
	{ //from day(int) => to day (int)
		global $db;

		if ($keyword != '') $keyword = " AND ( dt.`name` LIKE '%$keyword%' OR `SKU`.code LIKE '%$keyword%' ) ";

		$sqlProCom = '';
		if ($lProductCommission != '') {
			$lProductCommission = explode(';', $lProductCommission);
			foreach ($lProductCommission as $item) {
				if ($item != '') {
					if ($item == '0') {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR  pro.`product_commission_id` IS NULL OR";
					} else {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR ";
					}
				}
			}
			if ($sqlProCom != '') {
				$sqlProCom = substr($sqlProCom, 0, -3);
				$sqlProCom = "AND ($sqlProCom) ";
			}
		}

		$treasurer_group_id 	= $this->get('treasurer_group_id');
		$sqlTreasurerGroupID = ''; //Lý do xuất
		if ($treasurer_group_id != '') {
			$lSI = explode(';', $treasurer_group_id);
			foreach ($lSI as $itDe) {
				if ($itDe != '') {
					$sqlTreasurerGroupID .= " od.treasurer_group_id = '$itDe' OR ";
				}
			}
			if ($sqlTreasurerGroupID != '') {
				$sqlTreasurerGroupID = "AND (" . substr($sqlTreasurerGroupID, 0, -3) . ") ";
			}
		}

		$treasurer_id 	= $this->get('treasurer_id');
		$sqlTreasurerGroupIDThu = ''; //Thu
		if ($treasurer_id != '') {
			$lSI = explode(';', $treasurer_id);
			foreach ($lSI as $itDe) {
				if ($itDe != '') {
					$sqlTreasurerGroupIDThu .= " od.treasurer_id = '$itDe' OR ";
				}
			}
			if ($sqlTreasurerGroupIDThu != '') {
				$sqlTreasurerGroupIDThu = "AND (" . substr($sqlTreasurerGroupIDThu, 0, -3) . ") ";
			}
		}

		$order_type = $this->get('order_type');
		if ($order_type != '')
			$order_type = "AND od.`order_type` = '$order_type' ";
		else {
			$order_type = "AND ( od.`order_type` = '0' OR od.`order_type` = '1' ) ";
		}
		// $sql = "SELECT
		// 				COUNT(*) total_record,
		// 				SUM(IFNULL(total_revenue, 0)) total_revenue,
		// 				SUM(IFNULL(total_cost, 0)) total_cost,
		// 				SUM(IFNULL(total_discount, 0)) total_discount,
		// 				SUM(IFNULL(total_quantity, 0)) total_quantity
		// 		FROM (
		// 			SELECT 
		// 				SUM(dt.`quantity`*dt.`price`*((100 - dt.`decrement`)/100)) total_revenue,
		// 				SUM(dt.`quantity`*dt.`root_price`) total_cost,
		// 				SUM(dt.`quantity`*dt.`price`*(dt.`decrement`/100)) total_discount,
		// 				SUM(ABS(dt.`quantity`)) total_quantity
		// 			FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 			INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
		// 			LEFT JOIN $db->tbl_fix`product` as pro ON pro.id = dt.product_id
		// 			LEFT JOIN $db->tbl_fix`SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
		// 			WHERE od.printed='1' AND od.status='1' AND od.is_booking = '0' AND '$from' <= od.created_at AND od.created_at < '$to'
		// 			$keyword $sqlProCom $order_type $sqlTreasurerGroupID $sqlTreasurerGroupIDThu
		// 			GROUP BY dt.product_id, dt.sku_id
		// 		) dt
		// 		";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT
						COUNT(*) total_record,
						SUM(IFNULL(total_revenue, 0)) total_revenue,
						SUM(IFNULL(total_cost, 0)) total_cost,
						SUM(IFNULL(total_discount, 0)) total_discount,
						SUM(IFNULL(total_quantity, 0)) total_quantity
				FROM (
					SELECT 
						SUM(dt.`quantity`*dt.`price`*((100 - dt.`decrement`)/100)) total_revenue,
						SUM(dt.`quantity`*dt.`root_price`) total_cost,
						SUM(dt.`quantity`*dt.`price`*(dt.`decrement`/100)) total_discount,
						SUM(ABS(dt.`quantity`)) total_quantity
					FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
					INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
					LEFT JOIN $db->tbl_fix`product` as pro ON pro.id = dt.product_id
					LEFT JOIN $db->tbl_fix`SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
					WHERE od.printed>'0' AND od.status='1' AND od.is_booking = '0' AND '$from' <= od.created_at AND od.created_at < '$to'
					$keyword $sqlProCom $order_type $sqlTreasurerGroupID $sqlTreasurerGroupIDThu
					GROUP BY dt.product_id, dt.sku_id
				) dt
				";

		$r = $db->executeQuery($sql, 1); //od.`is_booking` = 0 AND

		return $r;
	}

	//cho báo cáo kho hàng mượn
	public function report_warehouse_borowed($shop_id, $lProductCommission, $keyword, $from, $to, $field = '', $sort = '', $offset = 0, $limit = '')
	{ //from day(int) => to day (int)
		global $db, $db_store;

		if ($keyword != '') $keyword = " AND ( dt.`name` LIKE '%$keyword%' OR od.`id` LIKE '%$keyword%' OR od.`name_customer` LIKE '%$keyword%' OR od.`mobile_customer` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";

		$sqlProCom = '';
		if ($lProductCommission != '') {
			$lProductCommission = explode(';', $lProductCommission);
			foreach ($lProductCommission as $item) {
				if ($item != '') {
					if ($item == '0') {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR  pro.`product_commission_id` IS NULL OR";
					} else {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR ";
					}
				}
			}
			if ($sqlProCom != '') {
				$sqlProCom = substr($sqlProCom, 0, -3);
				$sqlProCom = "AND ($sqlProCom) ";
			}
		}

		if ($limit != '') $limit = " LIMIT $offset, $limit ";

		$order_type = $this->get('order_type');
		if ($order_type != '') $order_type = "AND od.`order_type` = '$order_type' ";

		//sort
		$sqlSort = " ORDER BY `nTB`.name ";
		if (in_array($field, array(
			'product_commission_parent_name',
			'code',
			'product_commission_name',
			'member_code',
			'fullname',
			'mobile',
			'department_name',
			'created_at',
			'product_name',
			'amount',
			'payment_type',

			'cost',
			'discount',
			'thanh_tien',
			'lai',
		))) {
			if (!in_array($sort, array('ASC', 'DESC'))) $sort = 'ASC';

			$sortFieldArr = array(
				'product_commission_parent_name'        => 'nTB.`product_commission_parent_name`',
				'product_commission_name'                      		=> 'nTB.`product_commission_name`',
				'created_at'                      		=> 'nTB.`created_at`',
				'code'                      			=> 'nTB.`sku_code`',

				'member_code'                      		=> 'nTB.`code`',
				'fullname'                      		=> 'nTB.`fullname`',
				'mobile'                      			=> 'nTB.`mobile`',
				'department_name'                      	=> 'nTB.`department_name`',
				'user_add'                      		=> 'nTB.`user_add`',

				'product_name'                			=> 'nTB.`name`',
				'amount'                				=> 'nTB.`amount`',
				'payment_type'                			=> 'nTB.`payment_type_name`',

				'cost'                					=> 'nTB.`cost`',
				'discount'                				=> 'nTB.`discount`',
				'thanh_tien'                			=> 'nTB.`thanh_tien`',
				'lai'                					=> 'nTB.`lai`'
			);

			$field = isset($sortFieldArr[$field]) ? $sortFieldArr[$field] : '';

			if ($field != '')
				$sqlSort = " ORDER BY $field $sort ";
		}

		// $sql = "SELECT * FROM (
		// 			SELECT dt.`id`, dt.`order_id`, od.`created_at` order_created_at, od.`created_at` created_at,  od.`last_update`, dt.`product_id`, dt.`name`, dt.`price`, od.`is_internal`, od.`export_for_wh_id`, od.`treasurer` user_add
		// 					, SUM(dt.`quantity`*dt.`root_price`) cost
		// 					, SUM( dt.`quantity`*dt.`price`* (dt.`decrement`/100) ) discount
		// 					, SUM( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) thanh_tien
		// 					, SUM( ( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) - (dt.`quantity`*dt.`root_price`) ) lai
		// 					, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount
		// 					, dt.`decrement`, dt.`vat`, dt.`root_price`, IFNULL(SKU.`code`, '') sku_code
		// 					, IFNULL( procom.`product_commission_parent_name`, 'Chưa khai chiết khấu/ kho') product_commission_parent_name
		// 					, IFNULL( procom.`product_commission_name`, 'Chưa khai chiết khấu') product_commission_name
		// 					, IFNULL(IF( od.`liabilities_id` > 0 AND od.`hold_date` = 1, 'Tổng hợp', payment.`name`), 'Không xác định') payment_type_name, od.`payment_type`, od.`liabilities_id`, od.`hold_date`
		// 					, IFNULL(mb.`code`, '') code, IFNULL(mb.`fullname`, '') fullname, IFNULL(mb.`mobile`, '') mobile
		// 					, IFNULL(mbdep.`name`, 'Chưa khai báo') department_name
		// 					, IFNULL(wh.`name`, '') export_for_wh_name
		// 			FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 			INNER JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id
		// 			INNER JOIN `product` as pro ON pro.id = dt.product_id
		// 			LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
		// 			LEFT JOIN (
		// 				SELECT procom.id, IFNULL(parent.`name`, 'Chưa khai báo') product_commission_parent_name, procom.`name` product_commission_name
		// 				FROM $db->tbl_fix`product_commission` procom
		// 				LEFT JOIN $db->tbl_fix`product_commission` parent ON parent.id = procom.parent_id
		// 				WHERE procom.is_parent = 0
		// 			) procom ON procom.id = pro.product_commission_id
		// 			LEFT JOIN $db_store->tbl_fix`method_payment` payment ON payment.`id` = od.`payment_type`
		// 			LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
		// 			LEFT JOIN $db->tbl_fix`member_department` mbdep ON mbdep.`id` = mb.`member_department_id`
		// 			LEFT JOIN $db->tbl_fix`warehouse` wh ON wh.`id` = od.`export_for_wh_id`
		// 			WHERE od.printed='1' AND od.status='1' AND '$from' <= od.created_at AND od.created_at < '$to' $keyword $sqlProCom $order_type
		// 			GROUP BY dt.order_id, dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement, od.payment_type
		// 		) nTB WHERE nTB.amount > 0
		// 		$sqlSort
		// 		$limit
		// 		"; // AND `dt`.product_id > 0 //od.`is_booking` = 0 AND
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT * FROM (
					SELECT dt.`id`, dt.`order_id`, od.`created_at` order_created_at, od.`created_at` created_at,  od.`last_update`, dt.`product_id`, dt.`name`, dt.`price`, od.`is_internal`, od.`export_for_wh_id`, od.`treasurer` user_add
							, SUM(dt.`quantity`*dt.`root_price`) cost
							, SUM( dt.`quantity`*dt.`price`* (dt.`decrement`/100) ) discount
							, SUM( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) thanh_tien
							, SUM( ( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) - (dt.`quantity`*dt.`root_price`) ) lai
							, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount
							, dt.`decrement`, dt.`vat`, dt.`root_price`, IFNULL(SKU.`code`, '') sku_code
							, IFNULL( procom.`product_commission_parent_name`, 'Chưa khai chiết khấu/ kho') product_commission_parent_name
							, IFNULL( procom.`product_commission_name`, 'Chưa khai chiết khấu') product_commission_name
							, IFNULL(IF( od.`liabilities_id` > 0 AND od.`hold_date` = 1, 'Tổng hợp', payment.`name`), 'Không xác định') payment_type_name, od.`payment_type`, od.`liabilities_id`, od.`hold_date`
							, IFNULL(mb.`code`, '') code, IFNULL(mb.`fullname`, '') fullname, IFNULL(mb.`mobile`, '') mobile
							, IFNULL(mbdep.`name`, 'Chưa khai báo') department_name
							, IFNULL(wh.`name`, '') export_for_wh_name
					FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
					INNER JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id
					INNER JOIN `product` as pro ON pro.id = dt.product_id
					LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
					LEFT JOIN (
						SELECT procom.id, IFNULL(parent.`name`, 'Chưa khai báo') product_commission_parent_name, procom.`name` product_commission_name
						FROM $db->tbl_fix`product_commission` procom
						LEFT JOIN $db->tbl_fix`product_commission` parent ON parent.id = procom.parent_id
						WHERE procom.is_parent = 0
					) procom ON procom.id = pro.product_commission_id
					LEFT JOIN $db_store->tbl_fix`method_payment` payment ON payment.`id` = od.`payment_type`
					LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
					LEFT JOIN $db->tbl_fix`member_department` mbdep ON mbdep.`id` = mb.`member_department_id`
					LEFT JOIN $db->tbl_fix`warehouse` wh ON wh.`id` = od.`export_for_wh_id`
					WHERE od.printed>'0' AND od.status='1' AND '$from' <= od.created_at AND od.created_at < '$to' $keyword $sqlProCom $order_type
					GROUP BY dt.order_id, dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement, od.payment_type
				) nTB WHERE nTB.amount > 0
				$sqlSort
				$limit
				"; // AND `dt`.product_id > 0 //od.`is_booking` = 0 AND
		$result = $db->executeQuery_list($sql);

		return $result;
	}


	public function report_warehouse_borowed_info($shop_id, $lProductCommission, $keyword, $from, $to)
	{ //from day(int) => to day (int)
		global $db;

		if ($keyword != '') $keyword = " AND ( dt.`name` LIKE '%$keyword%' OR od.`id` LIKE '%$keyword%' OR od.`name_customer` LIKE '%$keyword%' OR od.`mobile_customer` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";

		$sqlProCom = '';
		if ($lProductCommission != '') {
			$lProductCommission = explode(';', $lProductCommission);
			foreach ($lProductCommission as $item) {
				if ($item != '') {
					if ($item == '0') {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR  pro.`product_commission_id` IS NULL OR";
					} else {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR ";
					}
				}
			}
			if ($sqlProCom != '') {
				$sqlProCom = substr($sqlProCom, 0, -3);
				$sqlProCom = "AND ($sqlProCom) ";
			}
		}

		$order_type = $this->get('order_type');
		if ($order_type != '') $order_type = "AND od.`order_type` = '$order_type' ";

		// $sql = "SELECT
		// 				COUNT(*) total_record,
		// 				SUM(IFNULL(total_revenue, 0)) total_revenue,
		// 				SUM(IFNULL(total_cost, 0)) total_cost,
		// 				SUM(IFNULL(total_discount, 0)) total_discount,
		// 				SUM(IFNULL(total_quantity, 0)) total_quantity
		// 		FROM (
		// 			SELECT 
		// 				SUM(dt.`quantity`*dt.`price`*((100 - dt.`decrement`)/100)) total_revenue,
		// 				SUM(dt.`quantity`*dt.`root_price`) total_cost,
		// 				SUM(dt.`quantity`*dt.`price`*(dt.`decrement`/100)) total_discount,
		// 				SUM(ABS(dt.`quantity`)) total_quantity
		// 			FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 			INNER JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
		// 			INNER JOIN `product` as pro ON pro.id = dt.product_id
		// 			LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
		// 			LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
		// 			WHERE  od.printed='1' AND od.status='1' AND '$from' <= od.created_at AND od.created_at < '$to' $keyword $sqlProCom $order_type
		// 			GROUP BY dt.order_id, dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement, od.payment_type
		// 		) dt
		// 		";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT
						COUNT(*) total_record,
						SUM(IFNULL(total_revenue, 0)) total_revenue,
						SUM(IFNULL(total_cost, 0)) total_cost,
						SUM(IFNULL(total_discount, 0)) total_discount,
						SUM(IFNULL(total_quantity, 0)) total_quantity
				FROM (
					SELECT 
						SUM(dt.`quantity`*dt.`price`*((100 - dt.`decrement`)/100)) total_revenue,
						SUM(dt.`quantity`*dt.`root_price`) total_cost,
						SUM(dt.`quantity`*dt.`price`*(dt.`decrement`/100)) total_discount,
						SUM(ABS(dt.`quantity`)) total_quantity
					FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
					INNER JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
					INNER JOIN `product` as pro ON pro.id = dt.product_id
					LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
					LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
					WHERE  od.printed>'0' AND od.status='1' AND '$from' <= od.created_at AND od.created_at < '$to' $keyword $sqlProCom $order_type
					GROUP BY dt.order_id, dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement, od.payment_type
				) dt
				";

		$r = $db->executeQuery($sql, 1); //od.`is_booking` = 0 AND

		return $r;
	}

	//cho báo cáo doanh số theo nhóm chiết khấu sản phẩm & filter theo phòng ban
	public function report_detail_selling_group_department_commission($shop_id, $by_department_id, $lProductCommission, $keyword, $from, $to, $offset = 0, $limit = '')
	{ //from day(int) => to day (int)
		global $db;

		$sqlDe = '';
		if ($by_department_id != '') {
			$lRMD = explode(';', $by_department_id);
			foreach ($lRMD as $itde) {
				if ($itde != '')
					$sqlDe .= " mb.`member_department_id` = '$itde' OR ";
			}

			if ($sqlDe != '') {
				$sqlDe = "AND (" . substr($sqlDe, 0, -3) . " )";
			}
		}

		if ($keyword != '') $keyword = " AND dt.`name` LIKE '%$keyword%' ";

		$sqlProCom = '';
		if ($lProductCommission != '') {
			$lProductCommission = explode(';', $lProductCommission);
			foreach ($lProductCommission as $item) {
				if ($item != '') {
					if ($item == '0') {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR  pro.`product_commission_id` IS NULL OR";
					} else {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR ";
					}
				}
			}
			if ($sqlProCom != '') {
				$sqlProCom = substr($sqlProCom, 0, -3);
				$sqlProCom = "AND ($sqlProCom) ";
			}
		}

		if ($limit != '') $limit = " LIMIT $offset, $limit ";

		// $sql = "SELECT * FROM (
		// 			SELECT dt.`id`, dt.`product_id`, dt.`name`, dt.`price`, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount, dt.`decrement`, dt.`vat`, dt.`root_price`, IFNULL(SKU.`code`, '') sku_code 
		// 			FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 			INNER JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
		// 			INNER JOIN `product` as pro ON pro.id = dt.product_id
		// 			LEFT JOIN `members` as mb ON mb.user_id = od.id_customer
		// 			LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
		// 			WHERE od.printed='1' AND od.status='1' AND '$from' <= od.created_at AND od.created_at < '$to' $keyword $sqlProCom $sqlDe
		// 			GROUP BY dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement
		// 		) nTB WHERE nTB.amount > 0
		// 		ORDER BY `nTB`.name
		// 		$limit
		// 		"; // AND `dt`.product_id > 0
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT * FROM (
					SELECT dt.`id`, dt.`product_id`, dt.`name`, dt.`price`, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount, dt.`decrement`, dt.`vat`, dt.`root_price`, IFNULL(SKU.`code`, '') sku_code 
					FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
					INNER JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
					INNER JOIN `product` as pro ON pro.id = dt.product_id
					LEFT JOIN `members` as mb ON mb.user_id = od.id_customer
					LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
					WHERE od.printed>'0' AND od.status='1' AND '$from' <= od.created_at AND od.created_at < '$to' $keyword $sqlProCom $sqlDe
					GROUP BY dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement
				) nTB WHERE nTB.amount > 0
				ORDER BY `nTB`.name
				$limit
				"; // AND `dt`.product_id > 0

		$result = $db->executeQuery_list($sql);

		return $result;
	}


	public function report_detail_selling_group_department_commission_info($shop_id, $by_department_id, $lProductCommission, $keyword, $from, $to)
	{ //from day(int) => to day (int)
		global $db;

		$sqlDe = '';
		if ($by_department_id != '') {
			$lRMD = explode(';', $by_department_id);
			foreach ($lRMD as $itde) {
				if ($itde != '')
					$sqlDe .= " mb.`member_department_id` = '$itde' OR ";
			}

			if ($sqlDe != '') {
				$sqlDe = "AND (" . substr($sqlDe, 0, -3) . " )";
			}
		}

		if ($keyword != '') $keyword = " AND dt.`name` LIKE '%$keyword%' ";

		$sqlProCom = '';
		if ($lProductCommission != '') {
			$lProductCommission = explode(';', $lProductCommission);
			foreach ($lProductCommission as $item) {
				if ($item != '') {
					if ($item == '0') {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR  pro.`product_commission_id` IS NULL OR";
					} else {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR ";
					}
				}
			}
			if ($sqlProCom != '') {
				$sqlProCom = substr($sqlProCom, 0, -3);
				$sqlProCom = "AND ($sqlProCom) ";
			}
		}

		// $sql = "SELECT
		// 				COUNT(*) total_record,
		// 				IFNULL( SUM(dt.`quantity`*dt.`price`), 0) total_revenue_before,
		// 				IFNULL( SUM(dt.`quantity`*dt.`price`*( (100 - dt.`decrement`)/100 ) ), 0) total_revenue,
		// 				IFNULL( SUM(dt.`quantity`*dt.`root_price`), 0) total_cost,
		// 				IFNULL( SUM(dt.`quantity`*dt.`price`*(dt.`decrement`/100)), 0) total_discount,
		// 				IFNULL( SUM(ABS(dt.`quantity`)), 0) total_quantity
		// 		FROM (
		// 			SELECT dt.`id`, dt.`product_id`, dt.`name`, dt.`price`, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as quantity, dt.`decrement`, dt.`vat`, dt.`root_price`, IFNULL(SKU.`code`, '') sku_code 
		// 			FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
		// 			INNER JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
		// 			INNER JOIN `product` as pro ON pro.id = dt.product_id
		// 			LEFT JOIN `members` as mb ON mb.user_id = od.id_customer
		// 			LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
		// 			WHERE od.`status_booking` = 0 AND od.printed='1' AND od.status='1' AND '$from' <= od.created_at AND od.created_at < '$to' $keyword $sqlProCom $sqlDe
		// 			GROUP BY dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement
		// 		) dt WHERE dt.quantity > 0
		// 		";
		// AnCode: Sửa printed=1 thành printed>0
		$sql = "SELECT
						COUNT(*) total_record,
						IFNULL( SUM(dt.`quantity`*dt.`price`), 0) total_revenue_before,
						IFNULL( SUM(dt.`quantity`*dt.`price`*( (100 - dt.`decrement`)/100 ) ), 0) total_revenue,
						IFNULL( SUM(dt.`quantity`*dt.`root_price`), 0) total_cost,
						IFNULL( SUM(dt.`quantity`*dt.`price`*(dt.`decrement`/100)), 0) total_discount,
						IFNULL( SUM(ABS(dt.`quantity`)), 0) total_quantity
				FROM (
					SELECT dt.`id`, dt.`product_id`, dt.`name`, dt.`price`, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as quantity, dt.`decrement`, dt.`vat`, dt.`root_price`, IFNULL(SKU.`code`, '') sku_code 
					FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
					INNER JOIN `order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id=od.id
					INNER JOIN `product` as pro ON pro.id = dt.product_id
					LEFT JOIN `members` as mb ON mb.user_id = od.id_customer
					LEFT JOIN `SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
					WHERE od.`status_booking` = 0 AND od.printed>'0' AND od.status='1' AND '$from' <= od.created_at AND od.created_at < '$to' $keyword $sqlProCom $sqlDe
					GROUP BY dt.product_id, dt.sku_id, dt.root_price, dt.price, dt.decrement
				) dt WHERE dt.quantity > 0
				";

		$r = $db->executeQuery($sql, 1);

		return $r;
	}

	/*
	- BEGIN LIST ORDER TO DELIVERY
	*/
	public function filter_delivery($shop_id, $keyword = '', $year = '')
	{
		global $db, $user, $detail_order, $shop;

		if ($shop_id != '') {

			$k = $this->list_to_delivery($shop_id, $keyword, $year);

			return $k;
		} else {

			$lShops = $shop->list_all_shop();

			$k = array();
			foreach ($lShops as $item) {

				$shop_id = $item['id'];

				$q = $this->list_to_delivery($shop_id, $keyword, $year);

				$k = array_merge($k, $q);
			}

			return $k;
		}
	}

	public function list_to_delivery($shop_id, $keyword = '', $year = '')
	{
		global $db, $user, $detail_order, $shop;

		if ($year == '') $year = date('Y');

		$id_customer = $this->get('id_customer');
		if ($id_customer != '') $id_customer = " AND `id_customer` = '$id_customer' ";

		if ($keyword != '') $keyword = " AND ( `od`.`id` = '$keyword' OR od.`ship_address` LIKE '%$keyword%' OR od.`name_customer` LIKE '%$keyword%' OR od.`mobile_customer` LIKE '%$keyword%' ) ";

		$sql = "SELECT od.`id`, `treasurer`, `last_update`, od.`note`, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, od.`created_at`, od.`shop_id`
					, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`, del.`note` shipper_note
					, od.`status`
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as `od`
				LEFT JOIN " . $db->tbl_fix . "`delivery` `del` ON del.order_id = `od`.id AND del.shop_id = od.shop_id
				WHERE od.`shop_id`='$shop_id' AND `order_type` = 2 AND `is_booking` = 1 $id_customer $keyword
				AND ( del.id IS NULL OR del.shipper_status = -1 )
				ORDER BY od.`created_at` DESC";

		$result = $db->executeQuery($sql);
		$kq = array();

		while ($row = mysqli_fetch_assoc($result)) {

			$row['total'] 			= $detail_order->get_sum_order($shop_id, $row['id'], $row['last_update']);
			$row['shop_name'] 		= $shop->get_shop_name($row['shop_id']);
			$row['last_update'] 	= date('d/m/Y', $row['last_update']);
			$row['fee'] 			= 0;
			$kq[] = $row;
		}

		return $kq;
	}

	public function list_to_delivery_count($shop_id, $keyword = '', $year = '')
	{
		global $db, $user;
		$detail_order = new detail_order();

		if ($year == '') $year = date('Y');

		$id_customer = $this->get('id_customer');
		if ($id_customer != '') $id_customer = " AND `id_customer` = '$id_customer' ";

		if ($keyword != '') $keyword = " AND ( od.`id` = '$keyword' OR od.`ship_address` LIKE '%$keyword%' OR `name_customer` LIKE '%$keyword%' OR `mobile_customer` LIKE '%$keyword%' ) ";

		$sql = "SELECT COUNT(*) total
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as `od`
				LEFT JOIN " . $db->tbl_fix . "`delivery` `del` ON del.order_id = `od`.id AND del.shop_id = od.shop_id
				WHERE od.`shop_id`='$shop_id' AND `order_type`=2 AND `is_booking` = 1 $id_customer $keyword
				AND ( del.id IS NULL OR del.shipper_status = -1 )
				ORDER BY od.`created_at` DESC";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	public function update_order($shop_id, $order_id, $created_at)
	{
		global $db;

		$arr['id'] 						= $this->get('order_id');
		$arr['name_customer'] 			= $this->get('name_customer');
		$arr['mobile_customer'] 		= $this->get('mobile_customer');
		$arr['ship_address'] 			= $this->get('ship_address');
		$arr['note'] 					= $this->get('note');
		$arr['status'] 					= $this->get('status');

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='" . $order_id . "'");
		return true;
	}

	public function edit_address_book($shop_id, $order_id, $created_at)
	{
		global $db;

		$arr['address_book_id'] 		= $this->get('address_book_id');

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='" . $order_id . "'");
		return true;
	}

	public function edit_shipment_address($shop_id, $order_id, $created_at)
	{
		global $db;

		$arr['address_book_id'] 		= $this->get('address_book_id');
		$arr['ship_name'] 				= $this->get('ship_name');
		$arr['ship_mobile'] 			= $this->get('ship_mobile');
		$arr['ship_address'] 			= $this->get('ship_address');
		$arr['ship_note'] 				= $this->get('ship_note');

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='" . $order_id . "'");
		return true;
	}

	public function update_delivery_status($shop_id, $created_at)
	{
		global $db;
		$collected_orders = new collected_orders();

		$id 				= $this->get('id');
		$arr['status'] 		= $this->get('status');
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='$id' AND `status` <> 1");

		$collected_orders->set('shop_id', $shop_id);
		$collected_orders->set('order_id', $id);
		$collected_orders->set('status', $arr['status']);
		$collected_orders->update_delivery_status();

		return true;
	}

	public function update_delete_for_client() //chi chuyen trang thai ve -1; khi don da o trang thai thanh cong;
	{
		global $db;

		$shop_id 		= $this->get('shop_id');
		$id 			= $this->get('id');
		$created_at 	= $this->get('created_at');

		$arr['status'] 		= -1;
		$arr['last_update'] = time();
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='$id' AND `shop_id` = '$shop_id' AND `status` = 1");

		$collected_orders = new collected_orders();
		$collected_orders->set('shop_id', $shop_id);
		$collected_orders->set('order_id', $id);
		$collected_orders->update_delete_for_client();

		return true;
	}

	public function update_status_order() //Cập nhật đơn hàng hủy bởi tự thành viên: HC 210628
	{
		global $db;
		$collected_orders = new collected_orders();

		$id 					= $this->get('id');
		$shop_id 				= $this->get('shop_id');
		$created_at 			= $this->get('created_at');

		$arr['status'] 			= $this->get('status'); //-1;
		$arr['order_type'] 		= $this->get('order_type'); //2;
		$arr['is_booking'] 		= $this->get('is_booking'); //1;
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='$id' AND `status` <> 1");

		$collected_orders->set('shop_id', $shop_id);
		$collected_orders->set('order_id', $id);
		$collected_orders->set('status', $arr['status']);
		$collected_orders->set('order_type', $arr['order_type']);
		$collected_orders->set('is_booking', $arr['is_booking']);
		$collected_orders->update_status_order();

		return true;
	}

	public function update_status_order_by_showroom() //Cập nhật đơn hàng showroom giao
	{
		global $db;
		$collected_orders = new collected_orders();

		$id 					= $this->get('id');
		$shop_id 				= $this->get('shop_id');
		$created_at 			= $this->get('created_at');

		$arr['status'] 			= $this->get('status'); //-1;
		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='$id'");

		$collected_orders->set('shop_id', $shop_id);
		$collected_orders->set('order_id', $id);
		$collected_orders->set('status', 1);
		$collected_orders->set('order_type', 7);
		$collected_orders->set('is_booking', 0);
		$collected_orders->update_status_order();

		return true;
	}

	/*
	- END LIST ORDER TO DELIVERY
	*/

	public function get_ship_address_by_order_id($shop_id, $order_id, $created_at)
	{
		global $db;

		$sql = "SELECT `od`.ship_address, `od`.ship_name name_customer, `od`.ship_mobile mobile_customer, `od`.status status_order
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "` `od`
				WHERE od.`id` = '$order_id' LIMIT 0,1 ";

		$row = $db->executeQuery($sql, 1);

		return $row;
	}

	//lấy thông tin người đặt hàng (tùngcode/10/07/2021)
	public function get_info_ship_address_by_order_id($shop_id, $order_id, $created_at)
	{
		global $db;

		$sql = "SELECT `od`.ship_note, `od`.ship_address, `od`.ship_name ship_name, `od`.ship_mobile ship_mobile, `od`.status status_order, 
				IFNULL(`mb`.avatar, '') for_avatar, IFNULL(`mb`.mobile, '') for_mobile, IFNULL(`mb`.fullname,'') for_fullname, IFNULL(`mb`.code,'') for_code, IFNULL(`mb`.member_group_id, '') for_member_group_id
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "` `od`
				LEFT JOIN " . $db->tbl_fix . "`members` `mb` ON mb.`user_id` = od.`for_client_id`
				WHERE od.`id` = '$order_id' LIMIT 0,1 ";
		$row = $db->executeQuery($sql, 1);

		return $row;
	}

	public function get_booking_members_detail_product($shop_id, $keyword, $from, $to, $showroom, $status_order, $order_type, $payments = '', $offset = '', $limit = '')
	{ //phần báo cáo đơn hàng khách hàng (tùng code)

		global $db, $user, $detail_order, $shop, $setup;
		$collected_payments = new collected_payments();
		$delivery = new delivery();
		$delivery_history = new delivery_history();

		// if ($year == '') $year = date('Y');
		if ($shop_id == '') $shop_id = "1";

		if ($showroom != '') {
			$showroom = " AND sr.`id` = $showroom";
		} else {
			$showroom = "";
		}

		if ($payments != '') {
			if ($payments == '1') {
				$payments = "AND col_pay.`payment_type` = " . $setup['payment_type_wallet_cashback'] . "";
			} else if ($payments == '2') {
				$payments = "AND col_pay.`payment_type` = " . $setup['payment_type_wallet_main'] . "";
			} else if ($payments == '3') {
				$payments = "AND col_pay.`payment_type` = " . $setup['payment_type_COD'] . "";
			} else {
				$payments = "";
			}
		} else {
			$payments = "";
		}

		if ($order_type != '') {
			$order_type = "AND od.`order_type` = $order_type";
		} else {
			$order_type = "";
		}

		if ($status_order != '') {
			$status_order = "AND del.`shipper_status` = $status_order";
		} else {
			$status_order = "";
		}

		if ($keyword != '') $keyword = " AND ( od.`id` LIKE '%$keyword%'
												OR mb.`code` LIKE '%$keyword%'
												OR od.`ship_mobile` LIKE '%$keyword%' 
												OR od.`ship_name` LIKE '%$keyword%' 
												OR od.`name_customer` LIKE '%$keyword%' 
												OR od.`mobile_customer` LIKE '%$keyword%' 
											) ";

		$sqlFromTo = '';
		if ($from != '' && $from > 0) {
			$sqlFromTo = " AND '$from' < od.`created_at` AND od.`created_at` < '$to' ";
		}

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlDTOrderTable = "SELECT * FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlDTOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT od.`id`, od.`total`, od.`treasurer`, od.`last_update`, od.`note`, od.`name_customer` members_fullname, od.`mobile_customer` mobile, od.`code`, od.`user_add`, od.`created_at`, od.`shop_id`
						, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`
						, IFNULL(del.`is_convert`, 0) is_convert
						, IFNULL(del.`shipper_status`, '' ) delivery_status
						, IFNULL(mb.`code`, '') members_code
						, IFNULL(mb.`mobile`, '') members_mobile
						, IFNULL(sr.`id`, '') showroom_id
						, IFNULL(sr.`name`, '') showroom_name
						, IFNULL(sr.`mobile`, '') showroom_mobile
						, IFNULL(sr.`address_full`, '') showroom_address
						, IFNULL(SKU.`code`, 'Chưa khai báo') sku_code
						, IFNULL(dt.`name`, '') product_name
						, dt.`quantity`, dt.`price`
				FROM  (
					$sqlOrderTable
				)
				`od`
				INNER JOIN (
					$sqlDTOrderTable
				) dt ON dt.`order_id` = od.`id`
				INNER JOIN $db->tbl_fix`delivery` del ON 
														( 
															del.`order_id` = od.`id` 
															AND od.`shop_id` = del.`shop_id`
														)
				LEFT JOIN $db->tbl_fix`SKU` ON SKU.`product_id` = dt.`product_id` AND SKU.`id` = dt.`sku_id`
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
				
				LEFT JOIN " . $db->tbl_fix . "`showroom` sr ON del.`shipper_id` = sr.`id`
				LEFT JOIN " . $db->tbl_fix . "`collected_payments` col_pay ON col_pay.`order_id` = od.`id`
				WHERE od.`shop_id`='$shop_id' $showroom $order_type $status_order $payments $keyword $sqlFromTo
				GROUP BY dt.`id`
				ORDER BY od.`created_at`DESC, od.`id`";

		$result = $db->executeQuery($sql);
		$kq = array();

		while ($row = mysqli_fetch_assoc($result)) {

			// $row['total'] 			= $detail_order->get_sum_order($shop_id, $row['id'], $row['last_update']);
			$row['shop_name'] 		= $shop->get_shop_name($row['shop_id']);
			$row['last_update'] 	= date('d/m/Y', $row['last_update']);

			$collected_payments->set('shop_id', $shop_id);
			$collected_payments->set('order_id', $row['id']);
			$lPayment 	= $collected_payments->list_by_order();

			$row['COD']				= 0;
			$row['wallet_main']		= 0;
			$row['wallet_cashback']	= 0;
			foreach ($lPayment as $key => $ssit) {
				if ($ssit['id'] == $setup['payment_type_COD']) {
					$row['COD'] 			+= $ssit['total'];
				} else if ($ssit['id'] == $setup['payment_type_wallet_main']) {
					$row['wallet_main'] 	+= $ssit['total'];
				} else if ($ssit['id'] == $setup['payment_type_wallet_cashback']) {
					$row['wallet_cashback'] 	+= $ssit['total'];
				}
			}

			$delivery->set('shipper_status', $row['delivery_status']);
			$row['delivery_status_label'] = $delivery->delivery_status_label();

			$delivery_history->set('order_id', $row['id']);
			$delivery_history->set('shop_id', $row['shop_id']);
			$row['delivery_done_at'] = $delivery_history->get_done_date();

			$kq[] = $row;
		}

		return $kq;
	}

	public function get_booking_members($shop_id, $keyword, $from, $to, $showroom, $status_order, $order_type, $payments = '', $offset, $limit)
	{ //phần báo cáo đơn hàng khách hàng (tùng code)

		global $db, $user, $detail_order, $shop, $setup;
		$collected_payments = new collected_payments();
		$delivery 			= new delivery();

		if ($shop_id == '') $shop_id = "1";

		if ($showroom != '') {
			$showroom = " AND sr.`id` = $showroom";
		} else {
			$showroom = "";
		}

		if ($payments != '') {
			if ($payments == '1') {
				$payments = "AND col_pay.`payment_type` = " . $setup['payment_type_wallet_cashback'] . "";
			} else if ($payments == '2') {
				$payments = "AND col_pay.`payment_type` = " . $setup['payment_type_wallet_main'] . "";
			} else if ($payments == '3') {
				$payments = "AND col_pay.`payment_type` = " . $setup['payment_type_COD'] . "";
			} else {
				$payments = "";
			}
		} else {
			$payments = "";
		}

		if ($order_type != '') {
			$order_type = "AND od.`order_type` = $order_type";
		} else {
			$order_type = "";
		}

		if ($status_order != '') {
			$status_order = "AND del.`shipper_status` = $status_order";
		} else {
			$status_order = "";
		}

		if ($limit != '') $limit = " LIMIT $offset,$limit ";
		if ($keyword != '') $keyword = " AND ( od.`id` LIKE '%$keyword%'
												OR mb.`code` LIKE '%$keyword%'
												OR od.`ship_mobile` LIKE '%$keyword%' 
												OR od.`ship_name` LIKE '%$keyword%' 
												OR od.`name_customer` LIKE '%$keyword%' 
												OR od.`mobile_customer` LIKE '%$keyword%' 
											) ";

		$sqlFromTo = '';
		if ($from != '' && $from > 0) {
			$sqlFromTo = " AND '$from' < od.`created_at` AND od.`created_at` < '$to' ";
		}

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT od.`id`, od.`total`, od.`treasurer`, od.`last_update`, od.`note`, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`code`, od.`user_add`, od.`created_at`, od.`shop_id`, od.`created_at`
						, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`
						, IFNULL(del.`shipper_id`, 0) delivery_id
						, IFNULL(del.`shipper_status`, '' ) delivery_status
						, IFNULL(del.`is_convert`, 0 ) is_convert
						, IFNULL(mb.`code`, '') members_code
						, IFNULL(mb.`mobile`, '') members_mobile
						, IFNULL(sr.`name`, '') showroom_name
						, IFNULL(sr.`mobile`, '') showroom_mobile
						, IFNULL(sr.`address_full`, '') showroom_address
				FROM  (
					$sqlOrderTable
				)
				`od`
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
				LEFT JOIN $db->tbl_fix`delivery` del ON 
														( 
															del.`order_id` = od.`id` 
															AND od.`shop_id` = del.`shop_id`
														)
				LEFT JOIN " . $db->tbl_fix . "`showroom` sr ON del.`shipper_id` = sr.`id`
				LEFT JOIN " . $db->tbl_fix . "`collected_payments` col_pay ON col_pay.`order_id` = od.`id`
				WHERE od.`shop_id`='$shop_id' 
				GROUP BY od.`id`
				ORDER BY od.`created_at` DESC
				$limit";

		$result = $db->executeQuery($sql);
		$kq = array();

		while ($row = mysqli_fetch_assoc($result)) {

			// $row['total'] 			= $detail_order->get_sum_order($shop_id, $row['id'], $row['last_update']);
			$row['shop_name'] 		= $shop->get_shop_name($row['shop_id']);
			$row['last_update'] 	= date('d/m/Y', $row['last_update']);

			$collected_payments->set('shop_id', $shop_id);
			$collected_payments->set('order_id', $row['id']);
			$payment 	= $collected_payments->list_by_order();

			$row['COD']			= 0;
			$row['wallet_main']	= 0;
			$row['wallet_cashback']	= 0;
			foreach ($payment as $key => $ssit) {
				if ($ssit['id'] == $setup['payment_type_COD']) {
					$row['COD'] 			+= $ssit['total'];
				} else if ($ssit['id'] == $setup['payment_type_wallet_main']) {
					$row['wallet_main'] 	+= $ssit['total'];
				} else if ($ssit['id'] == $setup['payment_type_wallet_cashback']) {
					$row['wallet_cashback'] 	+= $ssit['total'];
				}
			}

			$kq[] = $row;
		}

		return $kq;
	}

	public function get_booking_members_count($shop_id, $keyword, $from, $to, $showroom, $status_order, $order_type, $payments = '')
	{ //đếm số lượng đơn hàng khách hàng phần báo cáo (tùng code)
		global $db, $user, $setup;
		$detail_order = new detail_order();

		// if ($year == '') $year = date('Y');

		$created_by_client_id = $this->get('created_by_client_id');
		if ($created_by_client_id != '') {
			$created_by_client_id = " AND od.`created_by_client_id` = '$created_by_client_id' ";
		} else {
			$created_by_client_id = " AND od.`created_by_client_id` > 0 ";
		}

		if ($showroom != '') {
			$showroom = " AND sr.`id` = $showroom";
		} else {
			$showroom = "";
		}

		if ($payments != '') {
			if ($payments == '1') {
				$payments = "AND col_pay.`payment_type` = " . $setup['payment_type_wallet_cashback'] . "";
			} else if ($payments == '2') {
				$payments = "AND col_pay.`payment_type` = " . $setup['payment_type_wallet_main'] . "";
			} else if ($payments == '3') {
				$payments = "AND col_pay.`payment_type` = " . $setup['payment_type_COD'] . "";
			}
		} else {
			$payments = "";
		}

		if ($order_type != '') {
			$order_type = "AND od.`order_type` = $order_type";
		} else {
			$order_type = "AND (od.`order_type` = 2 OR od.`order_type` = 3)";
		}

		if ($status_order != '') {
			$status_order = "AND del.`shipper_status` = $status_order";
		} else {
			$status_order = "";
		}

		if ($shop_id == '') $shop_id = "1";

		if ($keyword != '') $keyword = " AND ( od.`id` LIKE '%$keyword%'
												OR mb.`code` LIKE '%$keyword%'
												OR od.`ship_mobile` LIKE '%$keyword%' 
												OR od.`ship_name` LIKE '%$keyword%' 
												OR od.`name_customer` LIKE '%$keyword%' 
												OR od.`mobile_customer` LIKE '%$keyword%' 
											) ";

		$sqlFromTo = '';
		if ($from != '' && $from > 0) {
			$sqlFromTo = " AND '$from' < od.`created_at` AND od.`created_at` < '$to' ";
		}

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT COUNT(*) total_record, SUM(`total`) total_value
				FROM (

					SELECT od.`id`, od.`total`
					FROM (
						$sqlOrderTable
					) od 
					LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
					LEFT JOIN $db->tbl_fix`delivery` del ON 
														( 
															del.`order_id` = od.`id` 
															AND od.`shop_id` = del.`shop_id`
														)
					LEFT JOIN " . $db->tbl_fix . "`showroom` sr ON del.`shipper_id` = sr.`id`
					LEFT JOIN " . $db->tbl_fix . "`collected_payments` col_pay ON col_pay.`order_id` = od.`id`
					WHERE od.`shop_id`='$shop_id' $showroom $order_type $status_order $payments $keyword $sqlFromTo
					GROUP BY od.`id`

				) nTB";

		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function get_booking_showroom($shop_id, $keyword, $year, $showroom, $status_order, $order_type, $offset, $limit)
	{ //phần báo cáo đơn hàng khách hàng (tùng code)

		global $db, $user, $detail_order, $shop;

		if ($year == '') $year = date('Y');
		if ($shop_id == '') $shop_id = "1";

		if ($showroom != '') {
			$showroom = " AND od.`id_customer` = $showroom";
		} else {
			$showroom = "";
		}

		if ($order_type != '') {
			$order_type = "AND od.`order_type` = $order_type";
		} else {
			$order_type = "";
		}

		if ($status_order != '') {
			$status_order = "AND od.`status` = $status_order";
		} else {
			$status_order = "";
		}

		if ($limit != '') $limit = " LIMIT $offset,$limit ";
		if ($keyword != '') $keyword = " AND ( od.`id` LIKE '%$keyword%'
												OR mb.`code` LIKE '%$keyword%'
												OR mb.`fullname` LIKE '%$keyword%'
												OR mb.`mobile` LIKE '%$keyword%'
												OR od.`ship_mobile` LIKE '%$keyword%' 
												OR od.`ship_name` LIKE '%$keyword%' 
											) ";

		$sql = "SELECT od.`id`, od.`treasurer`, od.`last_update`, od.`note`, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`code`, od.`user_add`, od.`shop_id`, od.`created_at`
					, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`, od.`status`
					, IFNULL(mb.`code`, '') members_code
					, IFNULL(mb.`mobile`, '') members_mobile
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as `od`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.id = cp.order_id
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
				WHERE od.`shop_id`='$shop_id' $showroom $order_type $status_order $keyword
				GROUP BY od.`id`
				ORDER BY od.`created_at` DESC
				$limit";
		$result = $db->executeQuery($sql);
		$kq = array();

		while ($row = mysqli_fetch_assoc($result)) {

			$row['total'] 			= $detail_order->get_sum_order($shop_id, $row['id'], $row['last_update']);
			$row['shop_name'] 		= $shop->get_shop_name($row['shop_id']);
			$row['last_update'] 	= date('d/m/Y', $row['last_update']);
			$kq[] = $row;
		}

		return $kq;
	}

	public function get_booking_showroom_count($shop_id, $keyword, $year, $showroom, $status_order, $order_type)
	{ //đếm số lượng đơn hàng khách hàng phần báo cáo (tùng code)
		global $db, $user;
		$detail_order = new detail_order();

		if ($year == '') $year = date('Y');

		$created_by_client_id = $this->get('created_by_client_id');
		if ($created_by_client_id != '') {
			$created_by_client_id = " AND od.`created_by_client_id` = '$created_by_client_id' ";
		} else {
			$created_by_client_id = " AND od.`created_by_client_id` > 0 ";
		}

		if ($showroom != '') {
			$showroom = " AND od.`id_customer` = $showroom";
		} else {
			$showroom = "";
		}

		if ($order_type != '') {
			$order_type = "AND od.`order_type` = $order_type";
		} else {
			$order_type = "";
		}

		if ($status_order != '') {
			$status_order = "AND od.`status` = $status_order";
		} else {
			$status_order = "";
		}

		if ($shop_id == '') $shop_id = "1";

		if ($keyword != '') $keyword = " AND ( `od`.`id` LIKE '%$keyword%'
												OR od.`ship_mobile` LIKE '%$keyword%' 
												OR od.`ship_name` LIKE '%$keyword%' 
											) ";

		$sql = "SELECT COUNT(*) total
				FROM( 
				SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . $year . "` as od 
				WHERE od.`shop_id`='$shop_id' $showroom $order_type $status_order $keyword GROUP BY od.`id` ORDER BY od.`created_at` DESC
				)n";
		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	public function list_by_showroom($customer_id, $shop_id) //lấy tất cả đơn hàng của showroom đặt(tùng code)
	{
		global $db;

		$sql = "SELECT od.* FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y') . "` as `od`  WHERE od.`id_customer` = $customer_id";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function list_order_showroom_cancel($shop_id, $order_id) //lấy danh sách đơn hàng đã hủy của showroom(tùng code)
	{
		global $db;

		$sql = "SELECT od.`id`, od.`shop_id`, od.`created_at`, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`id` code, od.`ship_name`,
		od.`ship_mobile`, od.`ship_note`, od.`total`, od.`address_book_id`, od.`ship_address`, sh.`name` shop_name
		FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y') . "` as `od`
		INNER JOIN shop sh ON od.shop_id = sh.id
		WHERE od.id = '$order_id' AND od.`status` = '-1' ORDER BY od.`created_at` DESC";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function list_booking_processing_not_delivery($shop_id, $keyword = '', $year = '', $status_showroom = '', $payment_type = '', $type = '', $offset = '', $limit = '')
	{
		global $db, $user, $detail_order, $shop, $setup;

		if ($year == '') $year = date('Y');

		$created_by_client_id = $this->get('created_by_client_id');
		if ($created_by_client_id != '') {
			$created_by_client_id = " AND od.`created_by_client_id` = '$created_by_client_id' ";
		} else {
			$created_by_client_id = " AND od.`created_by_client_id` > 0 ";
		}

		$order_type = $this->get('order_type');
		if ($order_type != '') $order_type = " AND od.`order_type` = '$order_type' ";

		$is_booking = $this->get('is_booking');
		if ($is_booking != '') $is_booking = " AND od.`is_booking` = '$is_booking' ";

		if ($payment_type != '') {
			if ($payment_type == 15) {
				$payment_type = " AND cp.`payment_type` = '15' ";
			} else {
				$payment_type = " AND cp.`payment_type` != '15' ";
			}
		} else {
			$payment_type = "";
		}

		if ($type != '' && $type == 'processing') {
			$type = "AND (od.`status` = -2 OR od.`status` = 0)";
		} else if ($type != '' && $type == 'done') {
			$type = "AND od.`status` = 1";
		} else if ($type != '' && $type == 'cancel') {
			$type = "AND od.`status` = -1";
		} else if ($type != '' && $type == 'payorder') {
			$type = "AND cp.`payment_type` = 20";
		} else {
			$type = "";
		}

		if ($shop_id == '') $shop_id = "1";

		// $order_status = "AND od.`status` != -3";
		if ($limit != '') $limit = " LIMIT $offset,$limit ";

		if ($keyword != '') $keyword = " AND ( `od`.`id` = '$keyword' OR od.`name_customer` LIKE '%$keyword%' OR od.`mobile_customer` LIKE '%$keyword%' ) ";


		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT od.`id`, od.`treasurer`, od.`last_update`, od.`note`, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`code`, od.`user_add`, od.`created_at`, od.`shop_id`, od.`created_at`
					, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`, od.`service_fee`
					, od.`status`
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_2021` `od`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
				WHERE od.`shop_id`='$shop_id' $order_type $is_booking $type $created_by_client_id $keyword
				GROUP BY od.`id` ORDER BY od.`created_at` DESC
				$limit";

		$result = $db->executeQuery($sql);
		$kq = array();

		if ($result != '')
			while ($row = mysqli_fetch_assoc($result)) {

				$row['total'] 			= $detail_order->get_sum_order($shop_id, $row['id'], $row['last_update']);
				$row['shop_name'] 		= $shop->get_shop_name($row['shop_id']);
				$row['last_update'] 	= date('d/m/Y', $row['last_update']);
				$kq[] = $row;
			}
		return $kq;
	}


	public function list_booking_processing_not_delivery_count($shop_id, $keyword = '', $year = '', $type)
	{
		global $db, $user, $setup;
		$detail_order = new detail_order();

		if ($year == '') $year = date('Y');

		$created_by_client_id = $this->get('created_by_client_id');
		if ($created_by_client_id != '') {
			$created_by_client_id = " AND od.`created_by_client_id` = '$created_by_client_id' ";
		} else {
			$created_by_client_id = " AND od.`created_by_client_id` > 0 ";
		}

		if ($type != '' && $type == 'processing') {
			$type = "AND (od.`status` = -2 OR od.`status` = 0)";
		} else if ($type != '' && $type == 'done') {
			$type = "AND od.`status` = 1";
		} else if ($type != '' && $type == 'cancel') {
			$type = "AND od.`status` = -1";
		} else if ($type != '' && $type == 'payorder') {
			$type = "AND cp.`payment_type` = 20";
		} else {
			$type = "";
		}

		if ($shop_id == '') $shop_id = "1";

		if ($keyword != '') $keyword = " AND ( od.`id` = '$keyword' OR `name_customer` LIKE '%$keyword%' OR `mobile_customer` LIKE '%$keyword%' ) ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}
		$sql = "SELECT COUNT(*) total
		FROM " . $db->tbl_fix . "`order_" . $shop_id . "_2021` `od`
		LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.id = cp.order_id
		WHERE od.`shop_id`='$shop_id' $type $created_by_client_id";
		// $sql = "SELECT COUNT(*) total
		// 		FROM (
		// 			$sqlOrderTable
		// 		) `od`
		// 		LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.id = cp.order_id
		// 		WHERE od.`shop_id`='$shop_id' $type $created_by_client_id";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	public function find_order_by_id()
	{ //Tìm order_detail theo order_id để thanh toán (tùng code)
		global $db, $setup, $shop;

		$collected_payments = new collected_payments();

		$id = $this->get('id');
		$shop_id = $this->get('shop_id');

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT od.`id`, od.`total`, od.`treasurer`, od.`last_update`, od.`note`, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`code`, od.`user_add`, od.`created_at`, od.`shop_id`
						, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`
						, IFNULL(mb.`code`, '') members_code
						, IFNULL(mb.`mobile`, '') members_mobile
				FROM  (
					$sqlOrderTable
				)
				`od`
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`id_customer`
				LEFT JOIN " . $db->tbl_fix . "`collected_payments` col_pay ON col_pay.`order_id` = od.`id`
				WHERE od.`id` = '$id'
				GROUP BY od.`id` ORDER BY od.`created_at` DESC ";

		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function check_client_bought_product(
		$shop_id,
		$product_id,
		$sku_id,
		$amount_bought = 1
		/**Số lượng đã mua */
	) {
		global $db, $setup;

		$id_customer = $this->get('id_customer');

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlDTOrderTable = "SELECT * FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlDTOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`detail_order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT SUM(dt.`quantity`) quantity
				FROM  (
					$sqlOrderTable
				)
				`od`
				INNER JOIN (
					$sqlDTOrderTable
				) dt ON dt.`order_id` = od.`id`
				WHERE od.`order_type` = '3' 
				AND od.`status` = '1' 
				AND od.`id_customer` = '$id_customer' 
				AND dt.`product_id` = '$product_id' 
				AND dt.`sku_id` = '$sku_id'
				";

		$r = $db->executeQuery($sql, 1);

		if (isset($r['quantity']) && $r['quantity'] >= $amount_bought) {
			return 1;
		} else {
			return 0;
		}
	}

	public function list_booking_pay_by_wallet_pay($shop_id, $keyword = '', $year = '', $status_showroom = '', $payment_type = '', $type = '', $offset = '', $limit = '')
	{
		global $db, $db_store, $user, $detail_order, $shop, $setup;

		if ($year == '') $year = date('Y');

		$id_customer = $this->get('id_customer');
		if ($id_customer != '') {
			$id_customer = " AND od.`id_customer` = '$id_customer' ";
		} else {
			$id_customer = " AND od.`id_customer` > 0 ";
		}

		$order_type = $this->get('order_type');
		if ($order_type != '') $order_type = " AND od.`order_type` = '$order_type' ";

		$is_booking = $this->get('is_booking');
		if ($is_booking != '') $is_booking = " AND od.`is_booking` = '$is_booking' ";

		if ($shop_id == '') $shop_id = "1";

		if ($limit != '') $limit = " LIMIT $offset,$limit ";

		if ($keyword != '') $keyword = " AND ( `od`.`id` = '$keyword' OR od.`name_customer` LIKE '%$keyword%' OR od.`mobile_customer` LIKE '%$keyword%' ) ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT od.`id`, od.`treasurer`, od.`last_update`, od.`note`, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`code`, od.`user_add`, od.`created_at`, od.`shop_id`, od.`created_at`
					, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`, od.`service_fee`
					, od.`status`
					FROM  (
					$sqlOrderTable
				)`od`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
				LEFT JOIN $db_store->tbl_fix`method_payment` mp ON mp.`id` = cp.`payment_type`
				WHERE od.`shop_id` = '$shop_id' $order_type $is_booking $id_customer AND od.`status` = 1 AND mp.`wallet_id` > 0 AND cp.`wallet_paid` = 0 $keyword
				GROUP BY od.`id` ORDER BY od.`created_at` DESC
				$limit";

		$result = $db->executeQuery($sql);
		$kq = array();

		if ($result != '')
			while ($row = mysqli_fetch_assoc($result)) {

				$row['total'] 			= $detail_order->get_sum_order($shop_id, $row['id'], $row['last_update']);
				$row['shop_name'] 		= $shop->get_shop_name($row['shop_id']);
				$row['last_update'] 	= date('d/m/Y', $row['last_update']);
				$kq[] = $row;
			}

		return $kq;
	}

	public function list_booking_pay_by_wallet_pay_count($shop_id, $keyword = '', $year = '', $type)
	{
		global $db, $db_store, $user, $setup;
		$detail_order = new detail_order();

		if ($year == '') $year = date('Y');

		$id_customer = $this->get('id_customer');
		if ($id_customer != '') {
			$id_customer = " AND od.`id_customer` = '$id_customer' ";
		} else {
			$id_customer = " AND od.`id_customer` > 0 ";
		}

		if ($shop_id == '') $shop_id = "1";

		if ($keyword != '') $keyword = " AND ( od.`id` = '$keyword' OR `name_customer` LIKE '%$keyword%' OR `mobile_customer` LIKE '%$keyword%' ) ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT COUNT(*) total FROM(
				SELECT cp.*
				FROM  (
							$sqlOrderTable
						)`od`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.id = cp.order_id
				LEFT JOIN $db_store->tbl_fix`method_payment` mp ON mp.`id` = cp.`payment_type`
				WHERE od.`shop_id`='$shop_id' $id_customer AND od.`status` = 1 AND mp.`wallet_id` > 0 AND cp.`wallet_paid` = 0 
				GROUP BY od.`id`
				)ntb";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	//danh sách đơn hàng dmember (tùng code - 25/03/2021)
	//HC: modify 210601
	public function list_booking_processing_not_delivery_dmember($shop_id, $keyword = '', $year = '', $status_showroom = '', $payment_type = '', $type = '', $offset = '', $limit = '')
	{
		global $db, $user, $detail_order, $shop, $setup;

		if ($year == '') 		$year = date('Y');
		if ($shop_id == '') 	$shop_id = "1";

		$created_by_client_id 	= $this->get('created_by_client_id');
		$created_by_client_id 	= " AND ( od.`created_by_client_id` = '$created_by_client_id' OR od.`id_customer` = '$created_by_client_id' ) ";

		$order_type = $this->get('order_type');
		if ($order_type != '') $order_type = " AND od.`order_type` = '$order_type' ";

		$is_booking = $this->get('is_booking');
		if ($is_booking != '') $is_booking = " AND od.`is_booking` = '$is_booking' ";

		$payment_type_wallet_main 		= $setup['payment_type_wallet_main'];
		$payment_type_wallet_cashback 	= $setup['payment_type_wallet_cashback'];
		$payment_type_COD 				= $setup['payment_type_COD'];

		//Nếu muốn lấy đơn theo loại đơn
		if (strtolower($payment_type) == 'dpoint') {
			$payment_type = " AND cp.`payment_type` = '$payment_type_wallet_cashback' AND cp.`value` > 0 ";
		} else {
			$payment_type = "";
		}

		if ($type != '' && $type == 'processing') {
			//Trạng thái chờ; đang xử lý hoặc hoàn thành nhưng nếu chưa thanh toán thì vẫn đang trong processing
			$type = "AND(
							(
								( od.`status` = -2 OR od.`status` = 0  ) AND ( od.`order_type` = 0 OR od.`order_type` = 2 )
							)
							OR
							(
								od.`status` = 0  AND od.`order_type` = 0
							) 
							OR
							( 	
								od.`status` = 1  
								AND od.`order_type` = 0
								AND cp.`wallet_paid` = 0 
								AND (
									cp.`payment_type` = '$payment_type_wallet_main' 
									OR cp.`payment_type` = '$payment_type_wallet_cashback'
								)
							)
						)
					";
		} else if ($type != '' && $type == 'done') {
			//Trạng thái = 1; wallet_paid = 0 nếu  khác hình thức điểm dcash; dpoint còn lại pass hết
			$type = "AND (
						 	(od.`status` = 1 AND od.`order_type` = 0)
							AND (
									cp.`wallet_paid` > 0 
									OR ( 
										cp.`payment_type` <> '$payment_type_wallet_main' 
										AND cp.`payment_type` <> '$payment_type_wallet_cashback' 
										) 
								)
						)
						 ";
		} else if ($type != '' && $type == 'cancel') {
			$type = "AND od.`status` = -1 AND od.`is_booking` = 1 AND `od`.`order_type` = '2' ";
		} else {
			$type = "";
		}

		if ($keyword != '') $keyword = " AND ( `od`.`id` = '$keyword' OR od.`name_customer` LIKE '%$keyword%' OR od.`mobile_customer` LIKE '%$keyword%' ) ";

		if ($limit != '') $limit = " LIMIT $offset,$limit ";


		$sqlSelectUnion 	= " `id`, `treasurer`, `last_update`, `note`, `name_customer`, `mobile_customer` 
								, `code`, `user_add`, `created_at`, `shop_id`, `ship_name`, `ship_mobile`
								, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `is_booking`
								, `created_by_client_id`, `id_customer`
								";

		$union_from 		= $setup['begin_time'];
		$union_to 			= time();

		$sqlOrderTable 		= "SELECT $sqlSelectUnion FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";
		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
								SELECT $sqlSelectUnion FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT od.`id`, od.`treasurer`, od.`last_update`, od.`note`, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`code`, od.`user_add`, od.`created_at`, od.`shop_id`, od.`created_at`
					, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`, od.`service_fee`
					, od.`status`
					FROM (
						$sqlOrderTable
					) `od`
					INNER JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
					WHERE od.`shop_id` = '$shop_id' $order_type $is_booking $type $payment_type $created_by_client_id $keyword
					GROUP BY od.`id` 
					ORDER BY od.`created_at` DESC
					$limit";

		$result = $db->executeQuery($sql);
		$kq = array();

		while ($row = mysqli_fetch_assoc($result)) {

			$row['total'] 			= $detail_order->get_sum_order($shop_id, $row['id'], $row['last_update']);
			$row['shop_name'] 		= $shop->get_shop_name($row['shop_id']);
			$row['last_update'] 	= date('d/m/Y', $row['last_update']);
			$kq[] = $row;
		}

		return $kq;
	}

	//đếm danh sách đơn hàng dmember (tùng code - 25/03/2021)
	//HC: modify 210601
	public function list_booking_processing_not_delivery_dmember_count($shop_id, $keyword = '', $payment_type = '', $year = '', $type)
	{
		global $db, $setup;

		if ($year == '') 		$year = date('Y');
		if ($shop_id == '') 	$shop_id = "1";

		$created_by_client_id 	= $this->get('created_by_client_id');
		$created_by_client_id 	= " AND ( od.`created_by_client_id` = '$created_by_client_id' OR od.`id_customer` = '$created_by_client_id' ) ";

		$order_type = $this->get('order_type');
		if ($order_type != '') $order_type = " AND od.`order_type` = '$order_type' ";

		$is_booking = $this->get('is_booking');
		if ($is_booking != '') $is_booking = " AND od.`is_booking` = '$is_booking' ";

		$payment_type_wallet_main 		= $setup['payment_type_wallet_main'];
		$payment_type_wallet_cashback 	= $setup['payment_type_wallet_cashback'];
		$payment_type_COD 				= $setup['payment_type_COD'];

		//Nếu muốn lấy đơn theo loại đơn: all hoặc dpoint còn lại là dcash + cách hình thức khác
		if (strtolower($payment_type) == 'dpoint') {
			$payment_type = " AND cp.`payment_type` = '$payment_type_wallet_cashback' AND cp.`value` > 0 ";
		} else {
			$payment_type = "";
		}

		if ($type != '' && $type == 'processing') {
			//Trạng thái chờ; đang xử lý hoặc hoàn thành nhưng nếu chưa thanh toán thì vẫn đang trong processing
			$type = "AND(
							(
								( od.`status` = -2 OR od.`status` = 0  ) AND ( od.`order_type` = 0 OR od.`order_type` = 2 )
							)
							OR
							(
								od.`status` = 0  AND od.`order_type` = 0
							) 
							OR
							( 	
								od.`status` = 1  
								AND od.`order_type` = 0
								AND cp.`wallet_paid` = 0 
								AND (
									cp.`payment_type` = '$payment_type_wallet_main' 
									OR cp.`payment_type` = '$payment_type_wallet_cashback'
								)
							)
						)
					";
		} else if ($type != '' && $type == 'done') {
			//Trạng thái = 1; wallet_paid = 0 nếu  khác hình thức điểm dcash; dpoint còn lại pass hết
			$type = "AND (
						 	(od.`status` = 1 AND od.`order_type` = 0)
							AND (
									cp.`wallet_paid` > 0 
									OR ( 
										cp.`payment_type` <> '$payment_type_wallet_main' 
										AND cp.`payment_type` <> '$payment_type_wallet_cashback' 
										) 
								)
						)
						 ";
		} else if ($type != '' && $type == 'cancel') {
			$type = "AND od.`status` = -1 AND od.`is_booking` = 1 AND `od`.`order_type` = '2' ";
		} else {
			$type = "";
		}

		if ($keyword != '') $keyword = " AND ( `od`.`id` = '$keyword' OR od.`name_customer` LIKE '%$keyword%' OR od.`mobile_customer` LIKE '%$keyword%' ) ";

		$sqlSelectUnion 	= " `id`, `treasurer`, `last_update`, `note`, `name_customer`, `mobile_customer` 
								, `code`, `user_add`, `created_at`, `shop_id`, `ship_name`, `ship_mobile`
								, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `is_booking`
								, `created_by_client_id`, `id_customer`
								";

		$union_from 		= $setup['begin_time'];
		$union_to 			= time();

		$sqlOrderTable 		= "SELECT $sqlSelectUnion FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";
		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
								SELECT $sqlSelectUnion FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT COUNT(*) total FROM (
					SELECT od.`id`
					FROM (
						$sqlOrderTable
					) `od`
					INNER JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
					WHERE od.`shop_id` = '$shop_id' $order_type $is_booking $type $payment_type $created_by_client_id $keyword
					GROUP BY od.`id` 
				) od
				";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	//HC => 20210617 => load lịch sử đơn hàng của khách hàng =>Đơn hàng của tôi hoặc đơn tôi lên
	public function client_order_history($shop_id, $keyword, $type = '' /*Loại đơn cần load*/, $offset = '', $limit = '')
	{
		//payment_type = hình thức nào thì load lên hình thức đó: 1;2;3 .. => nếu rỗng sẽ load mặc định không phải kho điểm tích lũy/cashback
		global $db, $db_store, $setup;

		$id_customer 		= $this->get('id_customer');
		$for_client_id 		= $this->get('for_client_id');
		if ($id_customer > 0)
			$sqlWhereClient 	= " AND ( od.`client_id` = '$id_customer' OR od.`created_by_client_id` = '$id_customer' ) ";
		else
			$sqlWhereClient 	= " AND ( od.`for_client_id` = '$for_client_id' OR od.`created_by_client_id` = '$for_client_id' OR od.`client_id` = '$for_client_id' ) ";

		$payment_type = $this->get('payment_type');
		$sqlPaymentType 	= '';
		if ($payment_type != '') {
			$lSh = explode(';', $payment_type);
			foreach ($lSh as $itde) {
				if ($itde != '')
					$sqlPaymentType .= " cp.`payment_type` = '$itde' OR ";
			}
			if ($sqlPaymentType != '') {
				$sqlPaymentType = "AND (" . substr($sqlPaymentType, 0, -3) . " )";
			}
		}

		if ($type == 'waiting') { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi
			$sqlTypeReport = "AND( 
									( od.`order_type` = 6  AND od.`status` = -2  AND od.`is_booking` = 1)
								)
							";
		} else if ($type == 'waiting_pay') { //waiting_pay => đơn hàng chờ xác nhận thanh toán

			$sqlTypeReport = "AND od.`order_type` = 0 AND od.`status` = 1 AND mp.`wallet_id` > 0 AND cp.`wallet_paid` = 0";
		} else if ($type == 'processing') { //processing
			$sqlTypeReport = "AND( 
									(	( od.`order_type` = 0  AND ( od.`status` = -2 OR od.`status` = 0 )  ) 
										OR ( od.`order_type` = 2  AND od.`status` = -2 ) 
									) AND od.`is_booking` = 1
								)
							";
		} else if ($type == 'done') { //done
			$sqlTypeReport = "AND( 
									( od.`order_type` = 0  AND od.`status` = 1 )
								)
							";
		} else if ($type == 'cancel') { //cancel
			$sqlTypeReport = "AND( 
									( od.`status` = -1 AND od.`is_booking` = 1 AND `od`.`order_type` = '2' )
								)
							";
		} else {
			$sqlTypeReport = "AND( 
									( od.`order_type` = 6 AND od.`status` = -2  AND od.`is_booking` = 1)
									OR ( 
											(	( od.`order_type` = 0  AND ( od.`status` = -2 OR od.`status` = 0 )  ) 
												OR ( od.`order_type` = 2  AND od.`status` = -2 ) 
											) AND od.`is_booking` = 1
										)
									OR ( od.`order_type` = 0  AND od.`status` = 1 )
									OR ( od.`status` = -1 AND od.`is_booking` = 1 AND `od`.`order_type` = '2' )
								)
							";
		}


		if ($keyword != '') $keyword = " AND ( `od`.`id` LIKE '%$keyword%' ) ";

		if ($limit != '') $limit = " LIMIT $offset,$limit ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`, `address_book_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
						 FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
								SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`, `address_book_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
								FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT od.*, IFNULL( mb.`fullname`, '') for_fullname, IFNULL( mb.`mobile`, '') for_mobile, IFNULL( mb.`code`, '') for_code
						, IFNULL(mb.`member_group_id`, 0) for_member_group_id, IFNULL(mb.`avatar`, 0) for_avatar
						, IFNULL(mp.`name` , '') payment_name
				FROM (
					$sqlOrderTable
				) od
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`for_client_id`
				LEFT JOIN $db->tbl_fix`members` forMB ON forMB.`user_id` = od.`for_client_id`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
				LEFT JOIN $db_store->tbl_fix`method_payment` mp ON mp.`id` = cp.`payment_type`
				WHERE od.`shop_id`='$shop_id' $sqlWhereClient $sqlTypeReport $sqlPaymentType $keyword
				GROUP BY od.`id`
				ORDER BY od.`created_at` DESC
				$limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	//HC => 20210617 => load lịch sử đơn hàng của khách hàng =>Đơn hàng của tôi hoặc đơn tôi lên
	public function client_order_history_count($shop_id, $keyword, $type = '' /*Loại đơn cần load*/)
	{
		global $db, $db_store, $setup;

		$id_customer 		= $this->get('id_customer');

		$for_client_id 		= $this->get('for_client_id');
		if ($id_customer > 0)
			$sqlWhereClient 	= " AND ( od.`client_id` = '$id_customer' OR od.`created_by_client_id` = '$id_customer' ) ";
		else
			$sqlWhereClient 	= " AND ( od.`for_client_id` = '$for_client_id' OR od.`created_by_client_id` = '$for_client_id' OR od.`client_id` = '$for_client_id' ) ";

		// $order_type = $this->get('order_type');//Loại đơn hàng
		// $sqlOrderType 	= '';
		// if( $order_type != '' ){

		//     $lSh = explode( ';', $order_type);
		//     foreach ($lSh as $itde) {
		//         if( $itde != '' )
		//             $sqlOrderType .= " od.`order_type` = '$itde' OR ";
		//     }

		//     if( $sqlOrderType != '' ){
		//         $sqlOrderType = "AND (".substr($sqlOrderType,0, -3)." )";
		//     }

		// }else{
		// 	$sqlOrderType = "AND od.`order_type` = '0' ";
		// }



		$payment_type = $this->get('payment_type');
		$sqlPaymentType 	= '';
		if ($payment_type != '') {

			$lSh = explode(';', $payment_type);
			foreach ($lSh as $itde) {
				if ($itde != '')
					$sqlPaymentType .= " cp.`payment_type` = '$itde' OR ";
			}

			if ($sqlPaymentType != '') {
				$sqlPaymentType = "AND (" . substr($sqlPaymentType, 0, -3) . " )";
			}
		}





		if ($type == 'waiting') { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi
			$sqlTypeReport = "AND( 
									( od.`order_type` = 6  AND od.`status` = -2  AND od.`is_booking` = 1)
								)
							";
		} else if ($type == 'waiting_pay') { //waiting_pay => đơn hàng chờ xác nhận thanh toán

			$sqlTypeReport = "AND od.`order_type` = 0 AND od.`status` = 1 AND mp.`wallet_id` > 0 AND cp.`wallet_paid` = 0";
		} else if ($type == 'processing') { //processing
			$sqlTypeReport = "AND( 
									(	( od.`order_type` = 0  AND ( od.`status` = -2 OR od.`status` = 0 )  ) 
										OR ( od.`order_type` = 2  AND od.`status` = -2 ) 
									) AND od.`is_booking` = 1
								)
							";
		} else if ($type == 'done') { //done
			$sqlTypeReport = "AND( 
									( od.`order_type` = 0  AND od.`status` = 1 )
								)
							";
		} else if ($type == 'cancel') { //cancel
			$sqlTypeReport = "AND( 
									( od.`status` = -1 AND od.`is_booking` = 1 AND `od`.`order_type` = '2' AND od.`is_booking` = 1 )
								)
							";
		} else {
			$sqlTypeReport = "AND( 
									( od.`order_type` = 6 AND od.`status` = -2  AND od.`is_booking` = 1)
									OR ( 
											(	( od.`order_type` = 0  AND ( od.`status` = -2 OR od.`status` = 0 )  ) 
												OR ( od.`order_type` = 2  AND od.`status` = -2 ) 
											) AND od.`is_booking` = 1
										)
									OR ( od.`order_type` = 0  AND od.`status` = 1 )
									OR ( od.`status` = -1 AND od.`is_booking` = 1 AND `od`.`order_type` = '2' AND od.`is_booking` = 1 )
								)
							";
		}


		if ($keyword != '') $keyword = " AND ( `od`.`id` LIKE '%$keyword%' ) ";

		if ($limit != '') $limit = " LIMIT $offset,$limit ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
						 FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
								SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
								FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT COUNT(*) total_record, SUM(`total`) `total_value` FROM(
				SELECT od.*, IFNULL( mb.`fullname`, '') for_fullname, IFNULL( mb.`mobile`, '') for_mobile, IFNULL( mb.`code`, '') for_code
				FROM (
					$sqlOrderTable
				) od
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`for_client_id`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
				LEFT JOIN $db_store->tbl_fix`method_payment` mp ON mp.`id` = cp.`payment_type`
				WHERE od.`shop_id`='$shop_id' $sqlWhereClient $sqlTypeReport $sqlPaymentType $keyword
				GROUP BY od.`id`
				) nTB";

		$r = $db->executeQuery($sql, 1);
		return array(
			'total_record' => isset($r['total_record']) ? $r['total_record'] : 0,
			'total_value' => isset($r['total_value']) ? $r['total_value'] : 0,
		);
	}

	//HC => 211007 => load lịch sử đơn hàng của khách hàng =>Đơn hàng của tôi hoặc đơn tôi lên => by delivery steps
	public function client_order_history_steps($shop_id, $keyword, $type = '' /*Loại đơn cần load*/, $offset = '', $limit = '')
	{
		//payment_type = hình thức nào thì load lên hình thức đó: 1;2;3 .. => nếu rỗng sẽ load mặc định không phải kho điểm tích lũy/cashback
		global $db, $db_store, $setup;

		$id_customer 		= $this->get('id_customer');
		$for_client_id 		= $this->get('for_client_id');
		if ($id_customer > 0)
			$sqlWhereClient 	= " AND ( od.`client_id` = '$id_customer' OR od.`created_by_client_id` = '$id_customer' ) ";
		else
			$sqlWhereClient 	= " AND ( od.`for_client_id` = '$for_client_id' OR od.`created_by_client_id` = '$for_client_id' OR od.`client_id` = '$for_client_id' ) ";

		$payment_type = $this->get('payment_type');
		$sqlPaymentType 	= '';
		if ($payment_type != '') {
			$lSh = explode(';', $payment_type);
			foreach ($lSh as $itde) {
				if ($itde != '')
					$sqlPaymentType .= " cp.`payment_type` = '$itde' OR ";
			}
			if ($sqlPaymentType != '') {
				$sqlPaymentType = "AND (" . substr($sqlPaymentType, 0, -3) . " )";
			}
		}

		$sqlOrderBy = "ORDER BY  od.`created_at` DESC";

		if ($type > 1) { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi

			$sqlTypeReport = "AND( 
									( del.`shipper_status` = '$type'  AND od.`status` = 1  AND od.`order_type` = 0 )
									OR (del.`shipper_status` = '$type'  AND (od.`status` = 1 OR od.`status` = 0)  AND od.`order_type` = 7)
								)
							";
		} else if ($type == 1) { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi

			$sqlTypeReport = "AND( 
									( ( del.`shipper_status` = '1' OR del.`shipper_status` = '0' OR del.`shipper_status` IS NULL )  AND od.`status` = 1  AND od.`order_type` = 0 )
									OR (`od`.`order_type` = 7 AND (del.`shipper_status` = '1' OR del.`shipper_status` = '0' OR del.`shipper_status` IS NULL))
								)
							";
		} else if ($type == 0) {

			//Đơn hàng vừa được được tạo => nằm trong khách lên đơn
			//bỏ đơn hàng lưu tạm, vì admin có thể tự tạo đơn cho khách ...
			//order_type = 2 => đợn đặt mua; order_type = 6 đơn báo giá
			$sqlTypeReport = "AND ( 
									( `od`.`order_type` = 2 OR `od`.`order_type` = 6 ) AND od.`status` = -2 AND od.`is_booking` = 1 AND ( del.`shipper_status` = '0' OR del.`shipper_status` IS NULL )
									OR
									( `od`.`order_type` = 0 AND od.`status` = 1 AND od.`is_booking` = 0 AND od.`created_by_client_id` = 0 AND ( del.`shipper_status` = '0' OR del.`shipper_status` IS NULL ) )
									OR
									( `od`.`order_type` = 7 AND od.`status` = 0 AND del.`shipper_status` = 0)
								)

							";
		} else if ($type == -1) { //Hủy
			//order_type = 2 đơn đặt rồi huy; order_type =6 đơn báo giá hủy; order_type = 0 đơn đã xác nhận xuất hàng rồi hủy
			$sqlTypeReport = "AND ( `od`.`order_type` = 2 OR `od`.`order_type` = 6 OR `od`.`order_type` = 7 OR `od`.`order_type` = 0) AND od.`status` = -1 AND od.`created_by_client_id` > 0";
			$sqlOrderBy = "ORDER BY  od.`last_update` DESC";
		} else {

			$sqlTypeReport = "AND( 
									( od.`order_type` = 6 AND od.`status` = -2  AND od.`is_booking` = 1)
									OR ( 
											(	( od.`order_type` = 0  AND ( od.`status` = -2 OR od.`status` = 0 )  ) 
												OR ( od.`order_type` = 2  AND od.`status` = -2 ) 
											) AND od.`is_booking` = 1
										)
									OR ( od.`order_type` = 0  AND od.`status` = 1 )
									OR ( od.`status` = -1 AND od.`is_booking` = 1 AND `od`.`order_type` = '2' )
								)
							";
		}

		if ($keyword != '') $keyword = " AND ( `od`.`id` LIKE '%$keyword%' ) ";

		if ($limit != '') $limit = " LIMIT $offset,$limit ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`, `address_book_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
						 FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
								SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`, `address_book_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
								FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT od.*, IFNULL( mb.`fullname`, '') for_fullname, IFNULL( mb.`mobile`, '') for_mobile, IFNULL( mb.`code`, '') for_code
						, IFNULL(mb.`member_group_id`, 0) for_member_group_id, IFNULL(mb.`avatar`, 0) for_avatar
						, IFNULL(mp.`name` , '') payment_name
				FROM (
					$sqlOrderTable
				) od
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`for_client_id`
				LEFT JOIN $db->tbl_fix`members` forMB ON forMB.`user_id` = od.`for_client_id`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
				LEFT JOIN $db->tbl_fix`delivery` del ON del.`order_id` = cp.`order_id`
				LEFT JOIN $db_store->tbl_fix`method_payment` mp ON mp.`id` = cp.`payment_type`
				WHERE od.`shop_id`='$shop_id' $sqlWhereClient $sqlTypeReport $sqlPaymentType $keyword
				GROUP BY od.`id`
				$sqlOrderBy
				$limit";

		// echo $sql;exit;

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	//HC => 211007 => load lịch sử đơn hàng của khách hàng =>Đơn hàng của tôi hoặc đơn tôi lên => by delivery steps
	public function client_order_history_steps_count($shop_id, $keyword, $type = '' /*Loại đơn cần load*/)
	{
		global $db, $db_store, $setup;

		$id_customer 		= $this->get('id_customer');

		$for_client_id 		= $this->get('for_client_id');
		if ($id_customer > 0)
			$sqlWhereClient 	= " AND ( od.`client_id` = '$id_customer' OR od.`created_by_client_id` = '$id_customer' ) ";
		else
			$sqlWhereClient 	= " AND ( od.`for_client_id` = '$for_client_id' OR od.`created_by_client_id` = '$for_client_id' OR od.`client_id` = '$for_client_id' ) ";

		// $order_type = $this->get('order_type');//Loại đơn hàng
		// $sqlOrderType 	= '';
		// if( $order_type != '' ){

		//     $lSh = explode( ';', $order_type);
		//     foreach ($lSh as $itde) {
		//         if( $itde != '' )
		//             $sqlOrderType .= " od.`order_type` = '$itde' OR ";
		//     }

		//     if( $sqlOrderType != '' ){
		//         $sqlOrderType = "AND (".substr($sqlOrderType,0, -3)." )";
		//     }

		// }else{
		// 	$sqlOrderType = "AND od.`order_type` = '0' ";
		// }



		$payment_type = $this->get('payment_type');
		$sqlPaymentType 	= '';
		if ($payment_type != '') {

			$lSh = explode(';', $payment_type);
			foreach ($lSh as $itde) {
				if ($itde != '')
					$sqlPaymentType .= " cp.`payment_type` = '$itde' OR ";
			}

			if ($sqlPaymentType != '') {
				$sqlPaymentType = "AND (" . substr($sqlPaymentType, 0, -3) . " )";
			}
		}


		if ($type > 1) { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi
			$sqlTypeReport = "AND( 
									( del.`shipper_status` = '$type'  AND od.`status` = 1  AND od.`order_type` = 0 )
								)
							";
		} else if ($type == 1) { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi
			$sqlTypeReport = "AND( 
									( ( del.`shipper_status` = '1' OR del.`shipper_status` = '0' OR del.`shipper_status` IS NULL )  AND od.`status` = 1  AND od.`order_type` = 0 )
								)
							";
		} else if ($type == 0) {
			//Đơn hàng vừa được được tạo => nằm trong khách lên đơn
			//bỏ đơn hàng lưu tạm, vì admin có thể tự tạo đơn cho khách ...
			//order_type = 2 => đợn đặt mua; order_type = 6 đơn báo giá
			$sqlTypeReport = "AND ( 
									( `od`.`order_type` = 2 OR `od`.`order_type` = 6 ) AND od.`status` = -2 AND od.`is_booking` = 1 AND ( del.`shipper_status` = '0' OR del.`shipper_status` IS NULL )
									OR
									( `od`.`order_type` = 0 AND od.`status` = 1 AND od.`is_booking` = 0 AND od.`created_by_client_id` = 0 AND ( del.`shipper_status` = '0' OR del.`shipper_status` IS NULL ) )
								)
							";
		} else if ($type == -1) { //Hủy
			//order_type = 2 đơn đặt rồi huy; order_type =6 đơn báo giá hủy; order_type = 0 đơn đã xác nhận xuất hàng rồi hủy
			$sqlTypeReport = "AND ( `od`.`order_type` = 2 OR `od`.`order_type` = 6 OR `od`.`order_type` = 0) AND od.`status` = -1 AND od.`created_by_client_id` > 0";
		} else {

			$sqlTypeReport = "AND( 
									( od.`order_type` = 6 AND od.`status` = -2  AND od.`is_booking` = 1)
									OR ( 
											(	( od.`order_type` = 0  AND ( od.`status` = -2 OR od.`status` = 0 )  ) 
												OR ( od.`order_type` = 2  AND od.`status` = -2 ) 
											) AND od.`is_booking` = 1
										)
									OR ( od.`order_type` = 0  AND od.`status` = 1 )
									OR ( od.`status` = -1 AND od.`is_booking` = 1 AND `od`.`order_type` = '2' )
								)
							";
		}

		if ($keyword != '') $keyword = " AND ( `od`.`id` LIKE '%$keyword%' ) ";

		if ($limit != '') $limit = " LIMIT $offset,$limit ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
						 FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
								SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
								FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT COUNT(*) total_record, SUM(`total`) `total_value` FROM(
				SELECT od.*, IFNULL( mb.`fullname`, '') for_fullname, IFNULL( mb.`mobile`, '') for_mobile, IFNULL( mb.`code`, '') for_code
				FROM (
					$sqlOrderTable
				) od
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`for_client_id`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
				LEFT JOIN $db->tbl_fix`delivery` del ON del.`order_id` = cp.`order_id`
				LEFT JOIN $db_store->tbl_fix`method_payment` mp ON mp.`id` = cp.`payment_type`
				WHERE od.`shop_id`='$shop_id' $sqlWhereClient $sqlTypeReport $sqlPaymentType $keyword
				GROUP BY od.`id`
				) nTB";

		$r = $db->executeQuery($sql, 1);
		return array(
			'total_record' => isset($r['total_record']) ? $r['total_record'] : 0,
			'total_value' => isset($r['total_value']) ? $r['total_value'] : 0,
		);
	}

	public function client_order_history_steps_supplier($shop_id, $keyword, $type = '' /*Loại đơn cần load*/, $supplier_id, $offset = '', $limit = '')
	{
		//payment_type = hình thức nào thì load lên hình thức đó: 1;2;3 .. => nếu rỗng sẽ load mặc định không phải kho điểm tích lũy/cashback
		global $db, $db_store, $setup;

		$id_customer 		= $this->get('id_customer');
		$for_client_id 		= $this->get('for_client_id');
		if ($id_customer > 0)
			$sqlWhereClient 	= " AND ( od.`client_id` = '$id_customer' OR od.`created_by_client_id` = '$id_customer' ) ";
		else
			$sqlWhereClient 	= " AND ( od.`for_client_id` = '$for_client_id' OR od.`created_by_client_id` = '$for_client_id' OR od.`client_id` = '$for_client_id' ) ";

		$payment_type = $this->get('payment_type');
		$sqlPaymentType 	= '';
		if ($payment_type != '') {
			$lSh = explode(';', $payment_type);
			foreach ($lSh as $itde) {
				if ($itde != '')
					$sqlPaymentType .= " cp.`payment_type` = '$itde' OR ";
			}
			if ($sqlPaymentType != '') {
				$sqlPaymentType = "AND (" . substr($sqlPaymentType, 0, -3) . " )";
			}
		}

		$sqlOrderBy = "ORDER BY  od.`created_at` DESC";

		if ($type > 1) { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi
			$sqlTypeReport = "AND( 
									( del.`shipper_status` = '$type'  AND od.`status` = 1  AND od.`order_type` = 0 )
								)
							";
		} else if ($type == 1) { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi
			$sqlTypeReport = "AND( 
									( ( del.`shipper_status` = '1' OR del.`shipper_status` = '0' OR del.`shipper_status` IS NULL )  AND od.`status` = 1  AND od.`order_type` = 0 )
								)
							";
		} else if ($type == 0) {
			//Đơn hàng vừa được được tạo => nằm trong khách lên đơn
			//bỏ đơn hàng lưu tạm, vì admin có thể tự tạo đơn cho khách ...
			//order_type = 2 => đợn đặt mua; order_type = 6 đơn báo giá
			$sqlTypeReport = "AND ( 
									( `od`.`order_type` = 2 OR `od`.`order_type` = 6 ) AND od.`status` = -2 AND od.`is_booking` = 1 AND ( del.`shipper_status` = '0' OR del.`shipper_status` IS NULL )
									OR
									( `od`.`order_type` = 0 AND od.`status` = 1 AND od.`is_booking` = 0 AND od.`created_by_client_id` = 0 AND ( del.`shipper_status` = '0' OR del.`shipper_status` IS NULL ) )
								)
							";
		} else if ($type == -1) { //Hủy
			//order_type = 2 đơn đặt rồi huy; order_type =6 đơn báo giá hủy; order_type = 0 đơn đã xác nhận xuất hàng rồi hủy
			$sqlTypeReport = "AND ( `od`.`order_type` = 2 OR `od`.`order_type` = 6 OR `od`.`order_type` = 0) AND od.`status` = -1 AND od.`created_by_client_id` > 0";
			$sqlOrderBy = "ORDER BY  od.`last_update` DESC";
		} else {

			$sqlTypeReport = "AND( 
									( od.`order_type` = 6 AND od.`status` = -2  AND od.`is_booking` = 1)
									OR ( 
											(	( od.`order_type` = 0  AND ( od.`status` = -2 OR od.`status` = 0 )  ) 
												OR ( od.`order_type` = 2  AND od.`status` = -2 ) 
											) AND od.`is_booking` = 1
										)
									OR ( od.`order_type` = 0  AND od.`status` = 1 )
									OR ( od.`status` = -1 AND od.`is_booking` = 1 AND `od`.`order_type` = '2' )
								)
							";
		}

		if ($keyword != '') $keyword = " AND ( `od`.`id` LIKE '%$keyword%' ) ";

		if ($limit != '') $limit = " LIMIT $offset,$limit ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`, `address_book_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
						 FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
								SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`, `address_book_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
								FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT od.*, IFNULL( mb.`fullname`, '') for_fullname, IFNULL( mb.`mobile`, '') for_mobile, IFNULL( mb.`code`, '') for_code
						, IFNULL(mb.`member_group_id`, 0) for_member_group_id, IFNULL(mb.`avatar`, 0) for_avatar
						, IFNULL(mp.`name` , '') payment_name
				FROM (
					$sqlOrderTable
				) od
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`for_client_id`
				LEFT JOIN $db->tbl_fix`members` forMB ON forMB.`user_id` = od.`for_client_id`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
				LEFT JOIN $db->tbl_fix`delivery` del ON del.`order_id` = cp.`order_id`
				LEFT JOIN $db_store->tbl_fix`method_payment` mp ON mp.`id` = cp.`payment_type`
				INNER JOIN $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $union_from) . "` dt ON od.id = dt.order_id
				INNER JOIN $db->tbl_fix`product` pro ON pro.`id` = dt.`product_id`
                INNER JOIN $db->tbl_fix`supplier` sup ON sup.`id` = pro.`supplier_id`
				WHERE od.`shop_id`='$shop_id' 
				AND sup.`id` = '$supplier_id'
				$sqlTypeReport $sqlPaymentType $keyword
				GROUP BY od.`id`
				$sqlOrderBy
				$limit";

		// echo $sql;

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	//HC => 211007 => load lịch sử đơn hàng của khách hàng =>Đơn hàng của tôi hoặc đơn tôi lên => by delivery steps
	public function client_order_history_steps_supplier_count($shop_id, $keyword, $type = '' /*Loại đơn cần load*/, $supplier_id)
	{
		global $db, $db_store, $setup;

		$id_customer 		= $this->get('id_customer');

		$for_client_id 		= $this->get('for_client_id');
		if ($id_customer > 0)
			$sqlWhereClient 	= " AND ( od.`client_id` = '$id_customer' OR od.`created_by_client_id` = '$id_customer' ) ";
		else
			$sqlWhereClient 	= " AND ( od.`for_client_id` = '$for_client_id' OR od.`created_by_client_id` = '$for_client_id' OR od.`client_id` = '$for_client_id' ) ";

		// $order_type = $this->get('order_type');//Loại đơn hàng
		// $sqlOrderType 	= '';
		// if( $order_type != '' ){

		//     $lSh = explode( ';', $order_type);
		//     foreach ($lSh as $itde) {
		//         if( $itde != '' )
		//             $sqlOrderType .= " od.`order_type` = '$itde' OR ";
		//     }

		//     if( $sqlOrderType != '' ){
		//         $sqlOrderType = "AND (".substr($sqlOrderType,0, -3)." )";
		//     }

		// }else{
		// 	$sqlOrderType = "AND od.`order_type` = '0' ";
		// }



		$payment_type = $this->get('payment_type');
		$sqlPaymentType 	= '';
		if ($payment_type != '') {

			$lSh = explode(';', $payment_type);
			foreach ($lSh as $itde) {
				if ($itde != '')
					$sqlPaymentType .= " cp.`payment_type` = '$itde' OR ";
			}

			if ($sqlPaymentType != '') {
				$sqlPaymentType = "AND (" . substr($sqlPaymentType, 0, -3) . " )";
			}
		}


		if ($type > 1) { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi
			$sqlTypeReport = "AND( 
									( del.`shipper_status` = '$type'  AND od.`status` = 1  AND od.`order_type` = 0 )
								)
							";
		} else if ($type == 1) { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi
			$sqlTypeReport = "AND( 
									( ( del.`shipper_status` = '1' OR del.`shipper_status` = '0' OR del.`shipper_status` IS NULL )  AND od.`status` = 1  AND od.`order_type` = 0 )
								)
							";
		} else if ($type == 0) {
			//Đơn hàng vừa được được tạo => nằm trong khách lên đơn
			//bỏ đơn hàng lưu tạm, vì admin có thể tự tạo đơn cho khách ...
			//order_type = 2 => đợn đặt mua; order_type = 6 đơn báo giá
			$sqlTypeReport = "AND ( 
									( `od`.`order_type` = 2 OR `od`.`order_type` = 6 ) AND od.`status` = -2 AND od.`is_booking` = 1 AND ( del.`shipper_status` = '0' OR del.`shipper_status` IS NULL )
									OR
									( `od`.`order_type` = 0 AND od.`status` = 1 AND od.`is_booking` = 0 AND od.`created_by_client_id` = 0 AND ( del.`shipper_status` = '0' OR del.`shipper_status` IS NULL ) )
								)
							";
		} else if ($type == -1) { //Hủy
			//order_type = 2 đơn đặt rồi huy; order_type =6 đơn báo giá hủy; order_type = 0 đơn đã xác nhận xuất hàng rồi hủy
			$sqlTypeReport = "AND ( `od`.`order_type` = 2 OR `od`.`order_type` = 6 OR `od`.`order_type` = 0) AND od.`status` = -1 AND od.`created_by_client_id` > 0";
		} else {

			$sqlTypeReport = "AND( 
									( od.`order_type` = 6 AND od.`status` = -2  AND od.`is_booking` = 1)
									OR ( 
											(	( od.`order_type` = 0  AND ( od.`status` = -2 OR od.`status` = 0 )  ) 
												OR ( od.`order_type` = 2  AND od.`status` = -2 ) 
											) AND od.`is_booking` = 1
										)
									OR ( od.`order_type` = 0  AND od.`status` = 1 )
									OR ( od.`status` = -1 AND od.`is_booking` = 1 AND `od`.`order_type` = '2' )
								)
							";
		}

		if ($keyword != '') $keyword = " AND ( `od`.`id` LIKE '%$keyword%' ) ";

		if ($limit != '') $limit = " LIMIT $offset,$limit ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
						 FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
								SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
								FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT COUNT(*) total_record, SUM(`total`) `total_value` FROM(
				SELECT od.*, IFNULL( mb.`fullname`, '') for_fullname, IFNULL( mb.`mobile`, '') for_mobile, IFNULL( mb.`code`, '') for_code
				FROM (
					$sqlOrderTable
				) od
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`for_client_id`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
				LEFT JOIN $db->tbl_fix`delivery` del ON del.`order_id` = cp.`order_id`
				LEFT JOIN $db_store->tbl_fix`method_payment` mp ON mp.`id` = cp.`payment_type`
				INNER JOIN $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $union_from) . "` dt ON od.id = dt.order_id
				INNER JOIN $db->tbl_fix`product` pro ON pro.`id` = dt.`product_id`
                INNER JOIN $db->tbl_fix`supplier` sup ON sup.`id` = pro.`supplier_id`
				WHERE od.`shop_id`='$shop_id' 
				AND sup.`id` = '$supplier_id'
				$sqlTypeReport $sqlPaymentType $keyword
				GROUP BY od.`id`
				) nTB";

		$r = $db->executeQuery($sql, 1);
		return array(
			'total_record' => isset($r['total_record']) ? $r['total_record'] : 0,
			'total_value' => isset($r['total_value']) ? $r['total_value'] : 0,
		);
	}


	//tạo đơn hàng chi tiết trả về cho app show đầy đủ thông tin
	public function order_detail_general($dMember, $item)
	{
		global $detail_order, $setup;

		$collected_payments = new collected_payments();
		$collected_orders 	= new collected_orders();
		$supplier           = new supplier();

		unset($item['cost']);
		$collected_payments->set('shop_id', $item['shop_id']);
		$collected_payments->set('order_id', $item['id']);
		$lPayment     = $collected_payments->list_by_order();

		$collected_orders->set('shop_id', $item['shop_id']);
		$collected_orders->set('order_id', $item['id']);
		$dCollectedOrder     = $collected_orders->get_detail_by_order_id();

		$item['dSupplier'] 		= array();
		if (isset($dCollectedOrder['id']) && $dCollectedOrder['supplier_id'] > 0) {
			$supplier->set('id', $dCollectedOrder['supplier_id']);
			$dSupplier = $supplier->get_detail();
			if (isset($dSupplier['id'])) {
				$item['dSupplier'] = $dSupplier;
			}
		}

		$item['is_cashback'] 	= false;
		$register_back_value    = 0;
		$COD                    = 0;
		$wallet_cashback        = 0;
		foreach ($lPayment as $ssi) {
			if (!$item['is_cashback'] && $setup['payment_type_wallet_cashback'] == $ssi['id']) {
				$item['is_cashback'] = true;
			}
			if ($setup['payment_type_wallet_cashback'] != $ssi['id']) {
				$register_back_value += $ssi['total']; //COD + ví (tiền thật)
			}

			if ($ssi['id'] == $setup['payment_type_COD']) {
				$COD                 += $ssi['total'];
			} else if ($ssi['id'] == $setup['payment_type_wallet_cashback']) {
				$wallet_cashback     += $ssi['total'];
			}
		}
		$item['lPayment'] = $lPayment;

		$dDiSer                   = $detail_order->devidend_service_fee($item['shop_id'], $item['id'], $item['created_at']);
		$discount_val             = $dDiSer['discount'];
		$ship_fee_val             = $dDiSer['ship_fee'];
		$package_fee_val          = $dDiSer['package_fee'];
		$total_product            = $dDiSer['total_product'];
		unset($dDiSer);

		$item['ship_fee']           = $ship_fee_val;
		$item['package_fee']        = $package_fee_val;
		$item['discount']           = $discount_val;
		$item['total_product']      = $total_product;
		$item['COD_total']          = $COD;

		//lấy lại list chỉ có sản phẩm
		$item['lItems']   = $detail_order->listby_order($item['shop_id'], $item['id'], $item['created_at']);

		$item['cashback_total'] = $this->execute_cashback($dMember, $item, $item['lItems'], $this->cal_sum_item_real($item['lItems']));

		return $item;
	}


	//Tính tổng tiền của sản phẩm theo giá bán lẻ
	private	function cal_sum_item_real($lDetailOrders)
	{

		$sum = 0;
		foreach ($lDetailOrders as $item) {
			if (isset($item['product_id']) && $item['product_id'] > 0) {
				$sum += $item['quantity'] * $item['price'];
			}
		}
		return $sum;
	}

	private	function execute_cashback($dMember, $dOrder, $lDetailOrders, $total_order_real)
	{
		global $main, $setup;

		$wallet_cashback        = new wallet_cashback();

		$value_cashback = 0;
		$member_group_id = $dMember['member_group_id'];

		if ($member_group_id > 0 && isset($dMember['user_id'])) {
			$wallet_cashback->set('member_group_id', $member_group_id);
			foreach ($lDetailOrders as $item) {
				$product_commission_id = $item['product_commission_id'];

				if ($product_commission_id > 0) {
					$wallet_cashback->set('product_commission_id', $product_commission_id);
					$dWalletCashback = $wallet_cashback->get_detail_record();

					if (isset($dWalletCashback['product_commission_id']) && $dWalletCashback['value'] > 0) {
						if ($dWalletCashback['is_value'] == 1) {
							$value_cashback += $dWalletCashback['value'];
						} else {
							//%
							$value_cashback += ($item['quantity'] * $item['price'] * (100 - $item['decrement']) * $dWalletCashback['value']) / 10000;
						}
					}
				}
			}
		}

		if (isset($setup['cod_cashback_decrement']) && $setup['cod_cashback_decrement'] > 0) {
			$value_cashback = ($value_cashback * (100 - $setup['cod_cashback_decrement'])) / 100;
		}

		return $value_cashback;
	}

	//danh sách đơn hàng dmember (tùng code - 25/03/2021)
	public function list_booking_processing_not_delivery_azone($shop_id, $keyword = '', $year = '', $status_showroom = '', $payment_type = '', $type = '', $offset = '', $limit = '')
	{
		global $db, $user, $detail_order, $shop, $setup;

		if ($year == '') $year = date('Y');

		$created_by_client_id = $this->get('created_by_client_id');
		if ($created_by_client_id != '') {
			$created_by_client_id = " AND od.`created_by_client_id` = '$created_by_client_id' ";
		} else {
			$created_by_client_id = " AND od.`created_by_client_id` > 0 ";
		}

		$order_type = $this->get('order_type');
		if ($order_type != '') $order_type = " AND od.`order_type` = '$order_type' ";

		$is_booking = $this->get('is_booking');
		if ($is_booking != '') $is_booking = " AND od.`is_booking` = '$is_booking' ";

		$payment_type_wallet_main = $setup['payment_type_wallet_main'];
		$payment_type_wallet_cashback = $setup['payment_type_wallet_cashback'];
		$payment_type_COD = $setup['payment_type_COD'];
		if ($payment_type == 'main' || $payment_type == 'Main' || $payment_type == 'MAIN') {
			$payment_type = " AND (cp.`payment_type` = $payment_type_wallet_main AND cp.`value` > 0 OR cp.`payment_type` = $payment_type_COD AND cp.`value` > 0)";
		} else if ($payment_type == 'cashback' || $payment_type == 'Cashback' || $payment_type == 'CASHBACK') {
			$payment_type = " AND cp.`payment_type` = $payment_type_wallet_cashback AND cp.`value` > 0 ";
		} else {
			$payment_type = "";
		}

		if ($type != '' && $type == 'processing') {
			$type = "AND (od.`status` = -2 OR od.`status` = 0)";
		} else if ($type != '' && $type == 'done') {
			$type = "AND od.`status` = 1";
		} else if ($type != '' && $type == 'cancel') {
			$type = "AND od.`status` = -1";
		} else if ($type != '' && $type == 'payorder') {
			$type = ""; // $type = "AND cp.`payment_type` = 20";
		} else {
			$type = "";
		}

		if ($shop_id == '') $shop_id = "1";

		// $order_status = "AND od.`status` != -3";
		if ($limit != '') $limit = " LIMIT $offset,$limit ";

		if ($keyword != '') $keyword = " AND ( `od`.`id` = '$keyword' OR od.`name_customer` LIKE '%$keyword%' OR od.`mobile_customer` LIKE '%$keyword%' ) ";


		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT od.`id`, od.`treasurer`, od.`last_update`, od.`note`, od.`name_customer` fullname, od.`mobile_customer` mobile, od.`code`, od.`user_add`, od.`created_at`, od.`shop_id`, od.`created_at`
					, od.`ship_name`, od.`ship_mobile`, od.`ship_note`, od.`ship_address`, od.`service_fee`
					, od.`status`
				FROM " . $db->tbl_fix . "`order_" . $shop_id . "_2021` `od`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
				WHERE od.`shop_id`='$shop_id' $order_type $is_booking $type $payment_type $created_by_client_id $keyword
				GROUP BY od.`id` ORDER BY od.`created_at` DESC
				$limit";

		$result = $db->executeQuery($sql);
		$kq = array();

		if ($result != '')
			while ($row = mysqli_fetch_assoc($result)) {

				$row['total'] 			= $detail_order->get_sum_order($shop_id, $row['id'], $row['last_update']);
				$row['shop_name'] 		= $shop->get_shop_name($row['shop_id']);
				$row['last_update'] 	= date('d/m/Y', $row['last_update']);
				$kq[] = $row;
			}
		return $kq;
	}

	//đếm danh sách đơn hàng dmember (tùng code - 25/03/2021)
	public function list_booking_processing_not_delivery_azone_count($shop_id, $keyword = '', $payment_type = '', $year = '', $type)
	{
		global $db, $user, $setup;
		$detail_order = new detail_order();

		if ($year == '') $year = date('Y');

		$created_by_client_id = $this->get('created_by_client_id');
		if ($created_by_client_id != '') {
			$created_by_client_id = " AND od.`created_by_client_id` = '$created_by_client_id' ";
		} else {
			$created_by_client_id = " AND od.`created_by_client_id` > 0 ";
		}

		if ($payment_type == 'main' || $payment_type == 'Main' || $payment_type == 'MAIN') {
			$payment_type = " AND cp.`payment_type` = '92' AND cp.`value` > 0 ";
		} else if ($payment_type == 'cashback' || $payment_type == 'Cashback' || $payment_type == 'CASHBACK') {
			$payment_type = " AND cp.`payment_type` = '95' AND cp.`value` > 0 ";
		} else {
			$payment_type = "";
		}

		if ($type != '' && $type == 'processing') {
			$type = "AND (od.`status` = -2 OR od.`status` = 0)";
		} else if ($type != '' && $type == 'done') {
			$type = "AND od.`status` = 1";
		} else if ($type != '' && $type == 'cancel') {
			$type = "AND od.`status` = -1";
		} else if ($type != '' && $type == 'payorder') {
			$type = ""; // $type = "AND cp.`payment_type` = 20";
		} else {
			$type = "";
		}

		if ($shop_id == '') $shop_id = "1";

		if ($keyword != '') $keyword = " AND ( od.`id` = '$keyword' OR `name_customer` LIKE '%$keyword%' OR `mobile_customer` LIKE '%$keyword%' ) ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
							SELECT * FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}
		$sql = "SELECT COUNT(*) total
		FROM " . $db->tbl_fix . "`order_" . $shop_id . "_2021` `od`
		LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.id = cp.order_id
		WHERE od.`shop_id`='$shop_id' $type $payment_type $created_by_client_id";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	public function create_by_list_pro($lPros, $lPays, $dClient = '')
	{ //lPros  = [{product_id, SKU.unique_id, quantity, price, decrement}]
		global $wh, $order, $detail_order, $collected_orders, $product, $setup, $main;

		$shop_id 	= $this->get('shop_id');
		$order_type = $this->get('order_type');
		$payment_type = $this->get('payment_type');
		$note 		= $this->get('note') . '';

		$service_fee 	= $this->get('service_fee') + 0;
		$total_paid 	= $this->get('total_paid') + 0;

		//Khởi tạo đơn hàng
		$this->set('shop_id', $shop_id);
		$this->set('user_add',  '');
		$this->set('vat',  $setup['taxs']);
		$this->set('id_customer',  isset($dClient['user_id']) ? $dClient['user_id'] : 0);
		$this->set('mobile_customer',  isset($dClient['mobile']) ? $dClient['mobile'] : 0);
		$this->set('name_customer',  isset($dClient['fullname']) ? $dClient['fullname'] : 0);
		$this->set('is_official_customer', isset($dClient['is_official']) ? $dClient['is_official'] : 0);
		$dWH = $wh->get_detail_by_shop_id($shop_id);
		$order->set('warehouse_id', isset($dWH['id']) ?  $dWH['id'] : '0');

		$this->set('created_by_client_id', isset($dClient['user_id']) ? $dClient['user_id'] : 0);
		$this->set('longitude', 0);
		$this->set('latitude', 0);
		$this->set('order_type', 2); //Đơn từ app Client YOBE

		$order_id = $this->create_temp_by_customer();
		$order_created_at = time();

		//Thêm item vào đơn hàng
		foreach ($lPros as $item) {

			$product->set('id', $item['product_id']);
			$dProduct = $product->get_detail();

			if (isset($item['price']))
				$dProduct['price']      = $main->number($item['price']);

			$dProduct['expire_date'] = 0;
			if (isset($item['expire_date']))
				$dProduct['expire_date']      = $item['expire_date'];

			$dProduct['quantity'] = 1;
			if (isset($item['amount']))
				$dProduct['quantity']      = $main->number($item['quantity']);

			$dProduct['decrement'] = 0;
			if (isset($item['decrement']))
				$dProduct['decrement']      = $main->number($item['decrement']);


			if (isset($dProduct['id']) && $dProduct['multi_attribute'] == 0) {
				$detail_order->add_product_item($shop_id, '', $order_id, $order_created_at, $dProduct, '', 1);
			} else {
				$dSKU = $SKU->get_by_unique_id($item['unique_id']);
				if (isset($dSKU['id'])) {
					$detail_order->add_product_item($shop_id, '', $order_id, $order_created_at, $dProduct, $dSKU, 1);
				}
			}
		}

		$this->set('shop_id', $shop_id);
		$this->set('id', $order_id);
		$this->set('ship_name', '');
		$this->set('ship_mobile', '');
		$this->set('ship_address', '');
		$this->set('address_book_id', 0);
		$this->set('longitude', 0);
		$this->set('latitude', 0);
		$this->set('ship_note', '');
		$this->set('note', $note);
		$this->set('created_at', $order_created_at);
		$this->set('created_by_client_id', isset($dClient['user_id']) ? $dClient['user_id'] : 0);
		$this->set('total_paid', $total_paid);
		$this->set('service_fee', $service_fee);
		$this->set('pro_allow_commission', 0);
		$this->set('pro_allow_commission_value', 0);
		$this->set('pro_allow_commission_percent', 0);
		$this->set('voucher_id', 0);
		$this->checkout_by_customer();

		$tong_tien = $detail_order->get_sum_order($shop_id, $order_id, $created_at);

		$dOrder = $this->get_detail($shop_id, $order_id, $order_created_at);

		$collected_orders->set('sum', $tong_tien);
		$collected_orders->set('payment_type', $payment_type);
		$collected_orders->set('created_at', time());
		$collected_orders->set('order_id', $order_id);
		$collected_orders->set('status', 0);
		$collected_orders->set('total_paid', $dOrder['total_paid']);
		$collected_orders->set('shop_id', $dOrder['shop_id']);
		$collected_orders->set('created_by', 'KH-AUTO');
		$collected_orders->set('members_id', $dOrder['id_customer']);
		$collected_orders->set('members_name', $dOrder['name_customer']);
		$collected_orders->set('members_mobile', $dOrder['mobile_customer']);
		$collected_orders->set('is_official_member', $dOrder['is_official_customer']);
		$collected_orders->set('is_booking', 1); //
		$collected_orders->set('is_returned_order', 0); //
		$collected_orders->set('nvkd_id', 0); //
		$collected_orders->set('nvkd_commission', 0); //
		$collected_orders->set('service_fee', $dOrder['total_paid']); //
		$collected_orders->set('order_type', $dOrder['order_type']); //
		$collected_orders->set('is_internal', $dOrder['is_internal']); //
		$collected_orders->set('created_by_client_id', $dOrder['created_by_client_id']); //
		$collected_orders->set('export_for_wh_id', $dOrder['export_for_wh_id']); //
		$collected_orders_id = $collected_orders->add(json_encode($lPays));

		return array('collected_orders_id' => $collected_orders_id, 'order_id' => $order_id, 'order_created_at' => $order_created_at, 'tong_tien' => $tong_tien);
	}

	public function sum_total_order_processing($client_id, $shop_id, $year, $payment_type)
	{
		global $db;

		$type = "AND( 
					(	( od.`order_type` = 0  AND ( od.`status` = -2 OR od.`status` = 0 )  ) 
						OR ( od.`order_type` = 2  AND od.`status` = -2 ) 
					) AND od.`is_booking` = 1
					)
				";

		$sql = "SELECT SUM(total) total 
			FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $year) . "` `od`
			INNER JOIN $db->tbl_fix`collected_payments` colp ON colp.`order_id` = od.`id`
			WHERE id_customer='$client_id' $type AND colp.`payment_type` = $payment_type";
		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	public function create_shipment($shop_id, $order_id, $created_at, $lItems, $dDel, $dColOrder, $dAddress, $note, $partner_id = 1) //partner_id = goship partner
	{	//Khởi tạo vận đơn cho đơn vị giao hàng goship
		global $setup, $api;

		$eco_ward_ship      = new eco_ward_ship();
		$eco_district_ship  = new eco_district_ship();
		$eco_city_ship      = new eco_city_ship();
		$eco_ward           = new eco_ward();
		$eco_district       = new eco_district();
		$eco_city           = new eco_city();
		$address_book       = new address_book();
		$supplier       	= new supplier();
		$product       		= new product();

		/**
		 * BEGIN đổi ID city, district, ward sang ID của nhà cung cấp dịch vụ vận chuyển
		 */

		// $address_book->set('id', $address_book_id);
		// $dAddress = $address_book->get_detail();

		$to_fullname			= $dAddress['fullname'];
		$to_mobile				= $dAddress['mobile'];
		$to_address				= $dAddress['address'];

		$eco_ward_ship->set('ward_id', $dAddress['ward_id']);
		$eco_ward_ship->set('partner_id', $partner_id);
		$toDWard = $eco_ward_ship->get_detail_item();
		$to_ward_id = isset($toDWard['new_id']) && $toDWard['new_id'] != '' ? $toDWard['new_id'] : 0;

		$eco_district_ship->set('district_id', $dAddress['district_id']);
		$eco_district_ship->set('partner_id', $partner_id);
		$toDDistrict = $eco_district_ship->get_detail_item();
		$to_district_id = isset($toDDistrict['new_id']) && $toDDistrict['new_id'] != '' ? $toDDistrict['new_id'] : 0;

		$eco_city_ship->set('city_id', $dAddress['city_id']);
		$eco_city_ship->set('partner_id', $partner_id);
		$toDCity    = $eco_city_ship->get_detail_item();
		$to_city_id    = isset($toDCity['new_id']) && $toDCity['new_id'] != '' ? $toDCity['new_id'] : 0;
		/**
		 * END đổi ID city, district, ward sang ID của nhà cung cấp dịch vụ vận chuyển
		 */

		/**
		 * BEGIN chuyển đổi địa chỉ from
		 */
		if ($dDel['pickup_fullname'] != '' && $dDel['pickup_mobile'] != '' && $dDel['pickup_address'] != '' && $dDel['pickup_ward_id'] != '' && $dDel['pickup_district_id'] != '' && $dDel['pickup_city_id'] != '') {
			$from_fullname		= $dDel['pickup_fullname'];
			$from_mobile		= $dDel['pickup_mobile'];
			$from_address		= $dDel['pickup_address'];

			$ward_id		= $dDel['pickup_ward_id'];
			$district_id	= $dDel['pickup_district_id'];
			$city_id		= $dDel['pickup_city_id'];
		} else if ($dColOrder['supplier_id'] > 0) {
			$supplier->set('id', $dColOrder['supplier_id']);
			$dSupplier = $supplier->get_detail();
			if (isset($dSupplier['id']) && $dSupplier['id'] != '') {

				$from_fullname	= $dSupplier['fullname'];
				$from_mobile	= $dSupplier['mobile'];
				$from_address	= $dSupplier['address'];

				$ward_id 		= $dSupplier['ward_id'];
				$district_id 	= $dSupplier['district_id'];
				$city_id 		= $dSupplier['city_id'];
			}
		}

		if ($partner_id == 4) {
			//name ward
			$eco_ward->set('id_ward', $ward_id);
			$fromWardName = $eco_ward->get_name();
			//name district 
			$eco_district->set('id_district', $district_id);
			$fromDistrictName = $eco_district->get_name();
			//name city
			$eco_city->set('id_city', $city_id);
			$fromCityName = $eco_city->get_name();
		} else {
			$eco_ward_ship->set('ward_id', $ward_id);
			$eco_ward_ship->set('partner_id', $partner_id);
			$fromDWard = $eco_ward_ship->get_detail_item();
			$from_ward_id = isset($fromDWard['new_id']) && $fromDWard['new_id'] != '' ? $fromDWard['new_id'] : 0;

			$eco_district_ship->set('district_id', $district_id);
			$eco_district_ship->set('partner_id', $partner_id);
			$fromDDistrict = $eco_district_ship->get_detail_item();
			$from_district_id = isset($fromDDistrict['new_id']) && $fromDDistrict['new_id'] != '' ? $fromDDistrict['new_id'] : 0;

			$eco_city_ship->set('city_id', $city_id);
			$eco_city_ship->set('partner_id', $partner_id);
			$fromDCity    = $eco_city_ship->get_detail_item();
			$from_city_id    = isset($fromDCity['new_id']) && $fromDCity['new_id'] != '' ? $fromDCity['new_id'] : 0;
		}

		/**
		 * END chuyển đổi địa chỉ from
		 */

		/**
		 * BEGIN tính kích thước gói hàng
		 */
		$realWeight   = 0; //Trọng lượng thật sản phẩm
		$estWeight    = 0; //Trọng lượng ước tính quy đổi: sum (dài x rộng x cao )/ 5000
		$total_qty    = 0; //tổng số lượng sản phẩm 
		$pduct     = array(); //sản phẩm của đơn hàng
		$lProduct     = array(); //sản phẩm của đơn hàng
		$total_product_price = 0; //tổng giá trị đơn hàng
		$pro_ship_fee = isset($setup['pro_ship_fee']) && $setup['pro_ship_fee'] > 0 ? $setup['pro_ship_fee'] : 0;
		$checkWeight = false;
		foreach ($lItems as $dPro) {
			if ($dPro['product_id'] > 0 && $dPro['product_id'] != $pro_ship_fee) {
				$total_qty += $dPro['quantity'];
				$total_product_price += $dPro['price'] * $dPro['quantity'];
				$product->set('id', $dPro['product_id']);
				$dProduct = $product->get_detail();

				$realWeight     += $dProduct['weight'] * $dPro['quantity'];
				$estWeight      += ($dProduct['height'] * $dProduct['length'] * $dProduct['width'] * $dPro['quantity']) / 5000;
				if ($partner_id == "2") {
					$pduct['PRODUCT_NAME'] = $dPro['name'];
					$pduct['PRODUCT_QUANTITY'] = $dPro['quantity'] + 0;
					$pduct['PRODUCT_PRICE'] = $dPro['price'] + 0;
					$pduct['PRODUCT_WEIGHT'] = $dProduct['weight'] * $dPro['quantity'];
					$lProduct[] = $pduct;
				}
				//nếu mà là goship thì kiểm tra xem các sản phẩm trong đơn hàng có nhập khối lượng không
				if ($partner_id == "1" && ($dProduct['weight'] == 0 || $dProduct['height'] == 0 || $dProduct['width'] == 0 || $dProduct['length'] == 0)) {
					$checkWeight = true;
				}
			}
		}
		$calWeight = $estWeight > $realWeight ? $estWeight : $realWeight;
		/**
		 * END tính kích thước gói hàng
		 */

		/**Begin tính tiền thu hộ */
		$dRateInfo = json_decode($dDel['rate_info'], true);

		$collected_payments = new collected_payments();
		$collected_payments->set('shop_id', $shop_id);
		$collected_payments->set('order_id', $order_id);
		$dColPay = $collected_payments->get_detail_by_payment_type();

		$payment_cod = 0;
		if (isset($dColPay['payment_type']) && $dColPay['payment_type'] == 1) {
			$payment_cod = $dColPay['value'] + 0;
			if (isset($dRateInfo['money_collection_by_product']) && $dRateInfo['money_collection_by_product'] == '') {
				$payment_cod = isset($dRateInfo['money_collection']) ? $dRateInfo['money_collection'] + 0 : 0;
			}
		}

		/**End tính tiền thu hộ */

		$jsonData = array();

		if ($partner_id == '1') { //goship

			if ($checkWeight == true) {
				$kq = array('status' => 403, 'data' => 'Một số sản phẩm trong đơn thiếu cân nặng, kích thước, chiều cao, vui lòng nhập đầy đủ các thông tin cho sản phẩm');
			} else {

				$total_price = 0;
				if (isset($dRateInfo['price_by_product'])) {
					//giá trị của các sản phẩm trong đơn hàng
					if ($dRateInfo['price_by_product'] == 1) {
						$total_price = $total_product_price;
					} else {
						$total_price = $dRateInfo['declared_price'];
					}
				}

				$jsonData['shipment']['rate'] 						= $dDel['rate_id'];
				$jsonData['shipment']['order_id'] 					= $order_id;
				$jsonData['shipment']['payer'] 						= 1;

				$jsonData['shipment']['address_from']['name'] 		= $from_fullname;
				$jsonData['shipment']['address_from']['phone'] 		= $from_mobile;
				$jsonData['shipment']['address_from']['street'] 	= $from_address;
				$jsonData['shipment']['address_from']['ward'] 		= $from_ward_id;
				$jsonData['shipment']['address_from']['district'] 	= $from_district_id;
				$jsonData['shipment']['address_from']['city'] 		= $from_city_id;

				$jsonData['shipment']['address_to']['name'] 		= $to_fullname;
				$jsonData['shipment']['address_to']['phone'] 		= $to_mobile;
				$jsonData['shipment']['address_to']['street'] 		= $to_address;
				$jsonData['shipment']['address_to']['ward'] 		= $to_ward_id;
				$jsonData['shipment']['address_to']['district'] 	= $to_district_id;
				$jsonData['shipment']['address_to']['city'] 		= $to_city_id;

				$jsonData['shipment']['parcel']['cod'] 				= $payment_cod;
				$jsonData['shipment']['parcel']['amount'] 			= $total_price + 0;
				$jsonData['shipment']['parcel']['quantity'] 		= 1;
				$jsonData['shipment']['parcel']['weight'] 			= $calWeight;
				$jsonData['shipment']['parcel']['width'] 			= 1;
				$jsonData['shipment']['parcel']['height'] 			= 1;
				$jsonData['shipment']['parcel']['length'] 			= 1;
				$jsonData['shipment']['parcel']['metadata'] 		= $note;

				$status_code = 403;
				$result = $api->exeAPIShip('POST', 'shipments', $jsonData, $status_code);
				$res = json_decode($result, true);

				if ($res['code'] == 401) {
					$token = $api->loginGoShip();
					if (!isset($token['code']) || $token['code'] != 200) {
						$kq = array('status' => $token['code'], 'data' => $token);
					} else {

						$status_code = 403;
						$result = $api->exeAPIShip('POST', 'shipments', $jsonData, $status_code);
						$res = json_decode($result, true);
						$kq = array('status' => $status_code, 'data' => $res);
					}
				} else {
					$kq = array('status' => $status_code, 'data' => $res); //kết quả phải được kiểm tra khi xuất ra
				}
			}
		} else if ($partner_id == '2') { //viettel post
			$order_payment = 1;
			if ($payment_cod > 0) {
				$order_payment = 3;
			} else {
				$order_payment = 1;
			}

			$jsonData['ORDER_NUMBER'] = $order_id;
			$jsonData['SENDER_FULLNAME'] = $from_fullname;
			$sender_address = $from_address . ', ' . $fromDWard['name'] . ', ' . $fromDDistrict['name'] . ', ' . $fromDCity['name'];
			$jsonData['SENDER_ADDRESS'] = $sender_address;
			$jsonData['SENDER_PHONE'] = $from_mobile;
			$jsonData['RECEIVER_FULLNAME'] = $to_fullname;
			$receiver_address = $to_address . ', ' . $toDWard['name'] . ', ' . $toDDistrict['name'] . ', ' . $toDCity['name'];
			$jsonData['RECEIVER_ADDRESS'] = $receiver_address;
			$jsonData['RECEIVER_PHONE'] = $to_mobile;
			$jsonData['PRODUCT_NAME'] = $to_fullname . ' - ' . $to_mobile;
			$jsonData['PRODUCT_DESCRIPTION'] = "";
			$jsonData['PRODUCT_QUANTITY'] = $total_qty + 0;
			$jsonData['PRODUCT_PRICE'] = $total_product_price;
			$jsonData['PRODUCT_WEIGHT'] = $calWeight;
			$jsonData['PRODUCT_LENGTH'] = 1;
			$jsonData['PRODUCT_WIDTH'] = 1;
			$jsonData['PRODUCT_HEIGHT'] = 1;
			$jsonData['ORDER_PAYMENT'] = $order_payment; //loại vận đơn 1 không thu hộ,2 thu hộ tiền hàng và tiền cước,3 thu hộ tiền hàng, 4 thu hộ tiền cước
			$jsonData['ORDER_SERVICE'] = $dDel['rate_id'];
			$jsonData['ORDER_SERVICE_ADD'] = "";
			$jsonData['ORDER_NOTE'] = $note;
			$jsonData['MONEY_COLLECTION'] = $payment_cod;
			$jsonData['LIST_ITEM'] = $lProduct;
			$status_code = 403;

			$result = $api->exeAPIViettelPost('POST', 'order/createOrderNlp', $jsonData, $status_code);
			$result = json_decode($result, true);

			if (isset($result['status']) && $result['status'] != 200) {

				$token = $api->loginViettelPost();

				if (!isset($token['status']) || $token['status'] != 200) {
					$kq = array('status' => $token['status'], 'data' => $token);
				} else {

					$status_code = 403;
					$result = $api->exeAPIViettelPost('POST', 'order/createOrderNlp', $jsonData, $status_code);
					$result = json_decode($result, true);

					$kq = array('status' => $result['status'], 'data' => $result['data']);
				}
			} else {

				$kq = array('status' => $result['status'], 'data' => $result['data']); //kết quả phải được kiểm tra khi xuất ra
			}
		} else if ($partner_id == '3') {
			//Gom đơn
			if ($fromDCity['name'] == '') {
				$kq = array('status' => 403, 'data' => 'Thiếu địa chỉ nhận hàng, thiếu địa chỉ tỉnh/thành phố.');
			} else if ($fromDDistrict['name'] == '') {
				$kq = array('status' => 403, 'data' => 'Thiếu địa chỉ nhận hàng, thiếu địa chỉ quận/huyện.');
			} else if ($fromDWard['name'] == '') {
				$kq = array('status' => 403, 'data' => 'Thiếu địa chỉ nhận hàng, thiếu địa chỉ xã/phường.');
			} else if ($toDCity['name'] == '') {
				$kq = array('status' => 403, 'data' => 'Thiếu địa chỉ giao hàng, thiếu địa chỉ tỉnh/thành phố.');
			} else if ($toDDistrict['name'] == '') {
				$kq = array('status' => 403, 'data' => 'Thiếu địa chỉ giao hàng, thiếu địa chỉ quận/huyện');
			} else if ($toDWard['name'] == '') {
				$kq = array('status' => 403, 'data' => 'Thiếu địa chỉ giao hàng, thiếu địa chỉ xã/phường');
			} else {
				$jsonData['product_name'] = $to_fullname . ' - ' . $to_mobile;
				$jsonData['product_price'] = $total_product_price;
				$jsonData['product_number'] = $total_qty;
				$jsonData['collect_amount'] = $payment_cod;
				$jsonData['type'] = 1;
				$jsonData['pickup_type'] = 2;
				$jsonData['service_id'] = $dDel['rate_id'];
				$jsonData['weight'] = $calWeight;
				$jsonData['width'] = 1;
				$jsonData['height'] = 1;
				$jsonData['length'] = 1;
				$jsonData['note'] = $note;
				$jsonData['source_province'] = $fromDCity['name'];
				$jsonData['source_district'] = $fromDDistrict['name'];
				$jsonData['source_ward'] = $fromDWard['name'];
				$jsonData['source_address'] = $from_address;
				$jsonData['source_phone'] = $from_mobile;
				$jsonData['source_name'] = $from_fullname;

				$jsonData['dest_province'] = $toDCity['name'];
				$jsonData['dest_district'] = $toDDistrict['name'];
				$jsonData['dest_ward'] = $toDWard['name'];
				$jsonData['dest_address'] = $to_address;
				$jsonData['dest_phone'] = $to_mobile;
				$jsonData['dest_name'] = $to_fullname;

				$result = $api->exeAPIGomDon('POST', 'order/create', $jsonData, $status_code);
				$result = json_decode($result, true);

				if (isset($result['result']) && $result['result'] == false) {

					$token = $api->loginGomDon();

					if (isset($token['result']) && $token['result'] == false) {
						$kq = array('status' => $token['status'], 'data' => $token);
					} else {

						$status_code = 403;
						$result = $api->exeAPIGomDon('POST', 'order/create', $jsonData, $status_code);
						$result = json_decode($result, true);
						$data = '';
						if ($result['result'] == true && $result['data'] != '') {
							$data = $result['data'];
							$status = 200;
						} else {
							$status = 403;
						}
						$kq = array('status' => $status, 'data' => $data);
					}
				} else {
					if ($result['result'] == true && $result['data'] != '') {
						$data = $result['data'];
						$status = 200;
					} else {
						$status = 403;
					}
					$kq = array('status' => $status, 'data' => $data); //kết quả phải được kiểm tra khi xuất ra
				}
			}
		} else {
			//Best Express
			$total_price = 0;
			if (isset($dRateInfo['PriceByProduct'])) {
				//giá trị của các sản phẩm trong đơn hàng
				if ($dRateInfo['PriceByProduct'] == 1) {
					$total_price = $total_product_price;
				} else {
					$total_price = $dRateInfo['DeclaredPrice'];
				}
			}

			$jsonData['Code'] = $order_id;
			$jsonData['ProductName'] = $to_fullname . ' - ' . $to_mobile;
			$jsonData['ProductPrice'] = $total_price + 0;
			$jsonData['CollectAmount'] = $payment_cod;
			$jsonData['JourneyType'] = 1;
			$jsonData['PickupType'] = 2;
			$jsonData['ServiceId'] = $dDel['rate_id'];
			$jsonData['Weight'] = $calWeight;
			$jsonData['Height'] = 1;
			$jsonData['Length'] = 1;
			$jsonData['Width'] = 1;
			$jsonData['SourceCity'] = $fromCityName;
			$jsonData['SourceDistrict'] = $fromDistrictName;
			$jsonData['SourceWard'] = $fromWardName;
			$jsonData['SourceAddress'] = $from_address;
			$jsonData['SourceName'] = $from_fullname;
			$jsonData['SourcePhoneNumber'] = $from_mobile;
			$jsonData['DestCity'] = $dAddress['city'];
			$jsonData['DestDistrict'] = $dAddress['district'];
			$jsonData['DestWard'] = $dAddress['ward'];
			$jsonData['DestAddress'] = $dAddress['address'];
			$jsonData['DestName'] = $to_fullname;
			$jsonData['DestPhoneNumber'] = $to_mobile;
			$jsonData['ReturnCity'] = $fromCityName;
			$jsonData['ReturnDistrict'] = $fromDistrictName;
			$jsonData['ReturnWard'] = $fromWardName;
			$jsonData['ReturnAddress'] = $from_address;
			$jsonData['ReturnName'] = $from_fullname;
			$jsonData['ReturnPhoneNumber'] = $from_mobile;
			$jsonData['Note'] = $note;

			$status_code = 403;

			$result = $api->exeApiBestExpress('POST', 'process/sears/Order/Add', $jsonData, $status_code);
			$result = json_decode($result, true);

			if (isset($result['Result']) && $result['Result'] != 1) {
				if (strpos($result['Message'], '401') == 1) {
					$token = $api->loginBestExpress();
					if (!isset($token['Result']) || $token['Result'] != 1) {
						$kq = array('status' => 403, 'data' => "Đăng nhập thất bại");
					} else {
						$status_code = 403;
						$result = $api->exeApiBestExpress('POST', 'process/sears/Order/Add', $jsonData, $status_code);
						$result = json_decode($result, true);
						$data = '';
						if ($result['Result'] == 1) {
							$data = $result;
							$status = 200;
						} else {
							if (strpos($result['Message'], '401') == 1) {
								$data = "Có sự cố xảy ra, vui lòng thử lại";
							} else {
								$data = $result['Message'];
							}
							$status = 403;
						}
						$kq = array('status' => $status, 'data' => $data);
					}
				} else {
					if (strpos($result['Message'], '803') == 1) {
						$data = "Đơn hàng đã bị hủy";
					} else {
						$data = $result['Message'];
					}
					$kq = array('status' => 403, 'data' => $data);
				}
			} else {
				$kq = array('status' => 200, 'data' => $result); //kết quả phải được kiểm tra khi xuất ra
			}
		}
		return $kq;
	}

	/**
	 * Ý tưởng cho func này là để xác nhận dữ liệu sao cho luôn luôn đúng theo các điều kiện
	 */
	public function check_validate_order($shop_id, $order_id, $order_created_at, $lDetailOrders, $isCovertPoint = 0 /*Đơn đổi điểm phải ko*/, $isFromPOS = 0, $isClientEdited = 1)
	{
		global $db;

		// kiểm tra sản phẩm có phải của shop_id này không?

		//Kiểm tra chiết khấu hoặc giá tối thiếu có đúng không?: Trường hợp cho chính giá đối với setting isClientEdited = 1
		//, còn không thì chỉ cho phép đúng theo chiết khấu isFromPOS = 0

		//Tính giảm giá tổng đơn hàng nếu có từ client theo chính sách revenue_commission (giảm giá theo tổng doanh số mua); hay có item giảm giá tổng đơn

		//Tính xem có được free ship hoặc free ship bao nhiêu theo cài đặt từ hệ thống tổng hoặc voucher giảm ship

		return $lDetailOrders;
	}
	// kiểm tra đơn hàng của người dùng đặt - An 14/10/22
	public function check_client_order($shop_id, $order_id, $client_id)
	{
		global $db;

		$sql = "SELECT * FROM $db->tbl_fix `order_" . $shop_id . "_2023`
						WHERE `id`='$order_id' AND `id_customer`='$client_id'";
		$result = $db->executeQuery($sql, 1);
		return $result;
	}

	public function getInfoBill()
	{
		global $db;
		$id				= $this->get('id');
		$shop_id		= $this->get('shop_id');
		$data			= getdate();
		$class_name		= "order_" . $shop_id . "_" . $data['year'];
		$detail_order	= "detail_order_" . $shop_id . "_" . $data['year'];

		$sql = "SELECT dod.*,pd.`unit_import` unit,od.`id_customer` 
		FROM $db->tbl_fix$class_name od  
		INNER JOIN $db->tbl_fix$detail_order dod ON dod.`order_id`= od.`id`
		INNER JOIN $db->tbl_fix`product` pd ON pd.`id`= dod.`product_id`
		WHERE dod.`order_id`='$id' ";
		$res = $db->executeQuery($sql);
		$member_id = '';
		$result['list_product'] = array();
		while ($row = mysqli_fetch_assoc($res)) {
			// $kq['detail_order_id']=$row['id'];
			// $kq['order_id']=$row['order_id'];
			// $kq['product_id']=$row['product_id']+0;
			$kq['name'] = $row['name'];
			$kq['unit'] = $row['unit'];
			$kq['quantity'] = $row['quantity'] + 0;
			$kq['price'] = $row['price'] + 0;
			$kq['type'] = 'HANG_HOA';
			$kq['total'] = $row['price'] * $row['quantity'];
			$kq['subtotal'] = $row['price'] * $row['quantity'];
			$kq['tax_money'] = 0;
			$kq['rate'] = 0;
			$result['list_product'][] = $kq;
			//thông tin của khách hàng
			$member_id = $row['id_customer'];
		}

		$members = new members();
		$members->set('user_id', $member_id);
		$iMember = $members->get_detail();

		$result['member_info'] = '';
		if (isset($iMember) && $iMember != '') {
			$member_info['buyer_name']           = $iMember['fullname'];
			$member_info['buyer_code']           = $iMember['user_id'];
			$member_info['buyer_legal_name']     = '';
			$member_info['buyer_tax_code']       = $iMember['tax'];
			$member_info['buyer_address_line']   = $iMember['address'];
			$member_info['buyer_postal_code']    = '700000';
			$member_info['buyer_phone_number']   = $iMember['mobile'];
			$member_info['buyer_fax_number']     = '';
			$member_info['buyer_email']          = $iMember['email'];
			$member_info['buyer_bank_name']      = $iMember['bank_name'];
			$member_info['buyer_bank_account']   = $iMember['bank_account'];
			$member_info['buyer_district_name']  = $iMember['district'];
			$member_info['buyer_city_name']      = $iMember['city'];
			$member_info['buyer_country_code']   = '+84';
			$member_info['buyer_id_type']        = "CMND";
			$member_info['buyer_id_no']          = $iMember['cmnd'];

			$month = ($iMember['month'] == '') ? '01' : $iMember['month'];
			$day = ($iMember['day'] == '') ? '01' : $iMember['day'];
			$year = ($iMember['year'] == '') ? '1970' : $iMember['year'];

			$date = date(DATE_ATOM, mktime(0, 0, 0, $month, $day, $year));
			$member_info['buyer_birth_day'] 	= $date;
			$result['member_info']	= $member_info;
		}

		return $result;
	}
	public function getOrder()
	{
		global $db;
		$id				= $this->get('id');
		$shop_id		= $this->get('shop_id');
		$data			= getdate();
		$class_name		= "order_" . $shop_id . "_" . $data['year'];
		$detail_order	= "detail_order_" . $shop_id . "_" . $data['year'];

		$sqlBuyer = "SELECT *
		FROM $db->tbl_fix$class_name od  
		INNER JOIN $db->tbl_fix`members` mb ON od.`id_customer`= mb.`user_id`
		WHERE od.`id`='$id'";
		$result['buyer_data'] = $db->executeQuery($sqlBuyer, 1);

		$sqlProduct = "SELECT *,dod.`id` detail_order_id
		FROM $db->tbl_fix$class_name od  
		INNER JOIN $db->tbl_fix$detail_order dod ON dod.`order_id`= od.`id`
		INNER JOIN $db->tbl_fix`product` pd ON pd.`id`= dod.`product_id`
		WHERE dod.`order_id`='$id'";
		$lines = $db->executeQuery($sqlProduct);
		while ($row = mysqli_fetch_assoc($lines)) {
			$kq['detail_order_id'] = $row['detail_order_id'];
			$kq['name'] = $row['name'];
			$kq['unit_import'] = $row['unit_import'];
			$kq['product_id'] = $row['product_id'];
			$kq['quantity'] = $row['quantity'] + 0;
			$kq['price'] = $row['price'] + 0;
			$kq['type'] = "HANG_HOA";
			$kq['total'] = $row['price'] * $row['quantity'];
			$kq['subtotal'] = $row['price'] * $row['quantity'];
			$kq['tax_money'] = 0;
			$kq['rate'] = 0;
			$result['lines'][] = $kq;
		}

		return $result;
	}

	public function client_order_history_steps_showroom($shop_id, $keyword, $type = '' /*Loại đơn cần load*/, $showroom_id, $offset = '', $limit = '')
	{
		//payment_type = hình thức nào thì load lên hình thức đó: 1;2;3 .. => nếu rỗng sẽ load mặc định không phải kho điểm tích lũy/cashback
		global $db, $db_store, $setup;

		// $id_customer 		= $this->get('id_customer');
		// $for_client_id 		= $this->get('for_client_id');
		// if ($id_customer > 0)
		// 	$sqlWhereClient 	= " AND ( od.`client_id` = '$id_customer' OR od.`created_by_client_id` = '$id_customer' ) ";
		// else
		// 	$sqlWhereClient 	= " AND ( od.`for_client_id` = '$for_client_id' OR od.`created_by_client_id` = '$for_client_id' OR od.`client_id` = '$for_client_id' ) ";

		$payment_type = $this->get('payment_type');
		$sqlPaymentType 	= '';
		if ($payment_type != '') {
			$lSh = explode(';', $payment_type);
			foreach ($lSh as $itde) {
				if ($itde != '')
					$sqlPaymentType .= " cp.`payment_type` = '$itde' OR ";
			}
			if ($sqlPaymentType != '') {
				$sqlPaymentType = "AND (" . substr($sqlPaymentType, 0, -3) . " )";
			}
		}

		$sqlOrderBy = "ORDER BY  od.`created_at` DESC";

		if ($type > 1) { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi
			$sqlTypeReport = "AND( 
									( del.`shipper_status` = '$type'  AND od.`status` = 1  AND od.`order_type` = 0 )
								)
							";
		} else if ($type == 1) { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi
			$sqlTypeReport = "AND( 
									( ( del.`shipper_status` = '1' OR del.`shipper_status` = '0' OR del.`shipper_status` IS NULL )  AND od.`status` = 1  AND od.`order_type` = 0 )
								)
							";
		} else if ($type == 0) {
			//Đơn hàng vừa được được tạo => nằm trong khách lên đơn
			//bỏ đơn hàng lưu tạm, vì admin có thể tự tạo đơn cho khách ...
			//order_type = 2 => đợn đặt mua; order_type = 6 đơn báo giá
			$sqlTypeReport = "AND ( 
									( `od`.`order_type` = 2 OR `od`.`order_type` = 6 ) AND od.`status` = -2 AND od.`is_booking` = 1 AND ( del.`shipper_status` = '0' OR del.`shipper_status` IS NULL )
									OR
									( `od`.`order_type` = 0 AND od.`status` = 1 AND od.`is_booking` = 0 AND od.`created_by_client_id` = 0 AND ( del.`shipper_status` = '0' OR del.`shipper_status` IS NULL ) )
								)
							";
		} else if ($type == -1) { //Hủy
			//order_type = 2 đơn đặt rồi huy; order_type =6 đơn báo giá hủy; order_type = 0 đơn đã xác nhận xuất hàng rồi hủy
			$sqlTypeReport = "AND ( `od`.`order_type` = 2 OR `od`.`order_type` = 6 OR `od`.`order_type` = 0) AND od.`status` = -1 AND od.`created_by_client_id` > 0";
		} else {

			$sqlTypeReport = "AND( 
									( od.`order_type` = 6 AND od.`status` = -2  AND od.`is_booking` = 1)
									OR ( 
											(	( od.`order_type` = 0  AND ( od.`status` = -2 OR od.`status` = 0 )  ) 
												OR ( od.`order_type` = 2  AND od.`status` = -2 ) 
											) AND od.`is_booking` = 1
										)
									OR ( od.`order_type` = 0  AND od.`status` = 1 )
									OR ( od.`status` = -1 AND od.`is_booking` = 1 AND `od`.`order_type` = '2' )
								)
							";
		}


		if ($keyword != '') $keyword = " AND ( `od`.`id` LIKE '%$keyword%' ) ";

		if ($limit != '') $limit = " LIMIT $offset,$limit ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`, `address_book_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
						 FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
								SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`, `address_book_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
								FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT od.*, IFNULL( mb.`fullname`, '') for_fullname, IFNULL( mb.`mobile`, '') for_mobile, IFNULL( mb.`code`, '') for_code
						, IFNULL(mb.`member_group_id`, 0) for_member_group_id, IFNULL(mb.`avatar`, 0) for_avatar
						, IFNULL(mp.`name` , '') payment_name, comshow.`value` total_commission
				FROM (
					$sqlOrderTable
				) od
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`for_client_id`
				LEFT JOIN $db->tbl_fix`members` forMB ON forMB.`user_id` = od.`for_client_id`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
				LEFT JOIN $db->tbl_fix`delivery` del ON del.`order_id` = cp.`order_id`
				LEFT JOIN $db_store->tbl_fix`method_payment` mp ON mp.`id` = cp.`payment_type`
				INNER JOIN $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $union_from) . "` dt ON od.id = dt.order_id
				INNER JOIN $db->tbl_fix`product` pro ON pro.`id` = dt.`product_id`
				LEFT JOIN $db->tbl_fix`commission_showroom` comshow ON comshow.`order_id` = od.`id`
				WHERE od.`shop_id`='$shop_id'
				AND del.`showroom_id` = '$showroom_id'
				$sqlTypeReport $sqlPaymentType $keyword
				GROUP BY od.`id`
				$sqlOrderBy
				$limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	//HC => 211007 => load lịch sử đơn hàng của khách hàng =>Đơn hàng của tôi hoặc đơn tôi lên => by delivery steps
	public function client_order_history_steps_showroom_count($shop_id, $keyword, $type = '' /*Loại đơn cần load*/, $showroom_id)
	{
		global $db, $db_store, $setup;

		$id_customer 		= $this->get('id_customer');

		// $for_client_id 		= $this->get('for_client_id');
		// if( $id_customer > 0 )
		// 	$sqlWhereClient 	= " AND ( od.`client_id` = '$id_customer' OR od.`created_by_client_id` = '$id_customer' ) ";
		// else
		// 	$sqlWhereClient 	= " AND ( od.`for_client_id` = '$for_client_id' OR od.`created_by_client_id` = '$for_client_id' OR od.`client_id` = '$for_client_id' ) ";

		// $order_type = $this->get('order_type');//Loại đơn hàng
		// $sqlOrderType 	= '';
		// if( $order_type != '' ){

		//     $lSh = explode( ';', $order_type);
		//     foreach ($lSh as $itde) {
		//         if( $itde != '' )
		//             $sqlOrderType .= " od.`order_type` = '$itde' OR ";
		//     }

		//     if( $sqlOrderType != '' ){
		//         $sqlOrderType = "AND (".substr($sqlOrderType,0, -3)." )";
		//     }

		// }else{
		// 	$sqlOrderType = "AND od.`order_type` = '0' ";
		// }



		$payment_type = $this->get('payment_type');
		$sqlPaymentType 	= '';
		if ($payment_type != '') {

			$lSh = explode(';', $payment_type);
			foreach ($lSh as $itde) {
				if ($itde != '')
					$sqlPaymentType .= " cp.`payment_type` = '$itde' OR ";
			}

			if ($sqlPaymentType != '') {
				$sqlPaymentType = "AND (" . substr($sqlPaymentType, 0, -3) . " )";
			}
		}

		if ($type > 1) { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi
			$sqlTypeReport = "AND( 
									( del.`shipper_status` = '$type'  AND od.`status` = 1  AND od.`order_type` = 0 )
								)
							";
		} else if ($type == 1) { //waiting => đang chờ xác nhận hoặc là đơn báo giá chưa gửi đi
			$sqlTypeReport = "AND( 
									( ( del.`shipper_status` = '1' OR del.`shipper_status` = '0' OR del.`shipper_status` IS NULL )  AND od.`status` = 1  AND od.`order_type` = 0 )
								)
							";
		} else if ($type == 0) {
			//Đơn hàng vừa được được tạo => nằm trong khách lên đơn
			//bỏ đơn hàng lưu tạm, vì admin có thể tự tạo đơn cho khách ...
			//order_type = 2 => đợn đặt mua; order_type = 6 đơn báo giá
			$sqlTypeReport = "AND ( 
									( `od`.`order_type` = 2 OR `od`.`order_type` = 6 ) AND od.`status` = -2 AND od.`is_booking` = 1 AND ( del.`shipper_status` = '0' OR del.`shipper_status` IS NULL )
									OR
									( `od`.`order_type` = 0 AND od.`status` = 1 AND od.`is_booking` = 0 AND od.`created_by_client_id` = 0 AND ( del.`shipper_status` = '0' OR del.`shipper_status` IS NULL ) )
								)
							";
		} else if ($type == -1) { //Hủy
			//order_type = 2 đơn đặt rồi huy; order_type =6 đơn báo giá hủy; order_type = 0 đơn đã xác nhận xuất hàng rồi hủy
			$sqlTypeReport = "AND ( `od`.`order_type` = 2 OR `od`.`order_type` = 6 OR `od`.`order_type` = 0) AND od.`status` = -1 AND od.`created_by_client_id` > 0";
		} else {

			$sqlTypeReport = "AND( 
									( od.`order_type` = 6 AND od.`status` = -2  AND od.`is_booking` = 1)
									OR ( 
											(	( od.`order_type` = 0  AND ( od.`status` = -2 OR od.`status` = 0 )  ) 
												OR ( od.`order_type` = 2  AND od.`status` = -2 ) 
											) AND od.`is_booking` = 1
										)
									OR ( od.`order_type` = 0  AND od.`status` = 1 )
									OR ( od.`status` = -1 AND od.`is_booking` = 1 AND `od`.`order_type` = '2' )
								)
							";
		}

		if ($keyword != '') $keyword = " AND ( `od`.`id` LIKE '%$keyword%' ) ";

		$union_from 	= $setup['begin_time'];
		$union_to 		= time();
		$sqlOrderTable = "SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
						 FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`";

		while (date('Y', $union_from) != date('Y', $union_to)) {
			$union_from = strtotime('01/02/' . (date('Y', $union_from) + 1)); //năm tiếp theo: ví dụ from là năm 2019 thì cái phải sẽ ra: 01/02/2020
			$sqlOrderTable .= "UNION ALL
								SELECT `id`, `treasurer`, `last_update`, `note`, `id_customer` client_id, `name_customer` fullname, `mobile_customer` mobile, `code`, `user_add`, `created_at`, `shop_id`, `for_client_id`, `created_by_client_id`
								, `ship_name`, `ship_mobile`, `ship_note`, `ship_address`, `service_fee`, `status`, `order_type`, `total`, `is_booking`
								FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $union_from) . "`
							";
		}

		$sql = "SELECT COUNT(*) total_record, SUM(`total`) `total_value` FROM(
				SELECT od.*, IFNULL( mb.`fullname`, '') for_fullname, IFNULL( mb.`mobile`, '') for_mobile, IFNULL( mb.`code`, '') for_code
				FROM (
					$sqlOrderTable
				) od
				LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`for_client_id`
				LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
				LEFT JOIN $db->tbl_fix`delivery` del ON del.`order_id` = cp.`order_id`
				LEFT JOIN $db_store->tbl_fix`method_payment` mp ON mp.`id` = cp.`payment_type`
				INNER JOIN $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $union_from) . "` dt ON od.id = dt.order_id
				INNER JOIN $db->tbl_fix`product` pro ON pro.`id` = dt.`product_id`
				WHERE od.`shop_id`='$shop_id' 
				AND del.`showroom_id` = '$showroom_id'
				$sqlTypeReport $sqlPaymentType $keyword
				GROUP BY od.`id`
				) nTB";

		$r = $db->executeQuery($sql, 1);
		return array(
			'total_record' => isset($r['total_record']) ? $r['total_record'] : 0,
			'total_value' => isset($r['total_value']) ? $r['total_value'] : 0,
		);
	}

	public function update_service_fee()
	{
		global $db;

		$shop_id 		= $this->get('shop_id');
		$id 			= $this->get('id');
		$created_at 	= $this->get('created_at');

		$arr['service_fee'] 			= $this->get('service_fee');

		$db->record_update("`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id` = '$id' ");
		return true;
	}

	public function filter_order_by_client_department()
	{
		global $db, $db_store;

		$shop_id 				= $this->get('shop_id');
		$id 					= $this->get('id');
		$created_at 			= $this->get('created_at');

		$sql = "SELECT od.*, IFNULL( mb.`fullname`, '') for_fullname, IFNULL( mb.`mobile`, '') for_mobile, IFNULL( mb.`code`, '') for_code
			, IFNULL(mb.`member_group_id`, 0) for_member_group_id, IFNULL(mb.`avatar`, 0) for_avatar
			, IFNULL(mp.`name` , '') payment_name
			FROM " . $db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "` od
		LEFT JOIN $db->tbl_fix`members` mb ON mb.`user_id` = od.`for_client_id`
		LEFT JOIN $db->tbl_fix`members` forMB ON forMB.`user_id` = od.`for_client_id`
		LEFT JOIN $db->tbl_fix`collected_payments` cp ON od.`id` = cp.`order_id`
		LEFT JOIN $db_store->tbl_fix`method_payment` mp ON mp.`id` = cp.`payment_type`
		WHERE od.`id` = '$id'
		";

		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	//Dung code báo cáo top bán hàng
	public function report_detail_top_selling($lProductCommission, $keyword, $from, $to, $field = '', $sort = '', $offset = 0, $limit = '')
	{ //from day(int) => to day (int)
		global $db, $db_store;

		$shop_id = $this->get('shop_id');

		if ($keyword != '') $keyword = " AND ( dt.`name` LIKE '%$keyword%' OR `SKU`.code LIKE '%$keyword%' ) ";

		$sqlProCom = '';
		if ($lProductCommission != '') {
			$lProductCommission = explode(';', $lProductCommission);
			foreach ($lProductCommission as $item) {
				if ($item != '') {
					if ($item == '0') {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR  pro.`product_commission_id` IS NULL OR";
					} else {
						$sqlProCom .= " pro.`product_commission_id` = '$item' OR ";
					}
				}
			}
			if ($sqlProCom != '') {
				$sqlProCom = substr($sqlProCom, 0, -3);
				$sqlProCom = "AND ($sqlProCom) ";
			}
		}

		$treasurer_group_id 	= $this->get('treasurer_group_id');
		$sqlTreasurerGroupID = '';
		if ($treasurer_group_id != '') {
			$lSI = explode(';', $treasurer_group_id);
			foreach ($lSI as $itDe) {
				if ($itDe != '') {
					$sqlTreasurerGroupID .= " od.treasurer_group_id = '$itDe' OR ";
				}
			}
			if ($sqlTreasurerGroupID != '') {
				$sqlTreasurerGroupID = "AND (" . substr($sqlTreasurerGroupID, 0, -3) . ") ";
			}
		}

		$treasurer_id 	= $this->get('treasurer_id');
		$sqlTreasurerGroupIDThu = ''; //Thu
		if ($treasurer_id != '') {
			$lSI = explode(';', $treasurer_id);
			foreach ($lSI as $itDe) {
				if ($itDe != '') {
					$sqlTreasurerGroupIDThu .= " od.treasurer_id = '$itDe' OR ";
				}
			}
			if ($sqlTreasurerGroupIDThu != '') {
				$sqlTreasurerGroupIDThu = "AND (" . substr($sqlTreasurerGroupIDThu, 0, -3) . ") ";
			}
		}

		if ($limit != '') $limit = " LIMIT $offset, $limit ";


		$order_type = $this->get('order_type');
		if ($order_type != '')
			$order_type = "AND od.`order_type` = '$order_type' ";
		else {
			$order_type = "AND ( od.`order_type` = '0' OR od.`order_type` = '1' ) ";
		}

		//sort
		$sqlSort = " ORDER BY `nTB`.name ";

		if (in_array($field, array(
			'product_commission_parent_name',
			'code',
			'product_commission_name',
			'created_at',
			'product_name',
			'amount',
			'cost',
			'discount',
			'thanh_tien',
			'total_real',
			'lai',
		))) {
			if (!in_array($sort, array('ASC', 'DESC'))) $sort = 'ASC';

			$sortFieldArr = array(
				'product_commission_parent_name'        => 'nTB.`product_commission_parent_name`',
				'product_commission_name'                      		=> 'nTB.`product_commission_name`',
				'created_at'                      		=> 'nTB.`created_at`',
				'code'                      			=> 'nTB.`sku_code`',
				'product_name'                			=> 'nTB.`name`',
				'amount'                				=> 'nTB.`amount`',
				'total_cost'                			=> 'nTB.`total_cost`',
				'discount'                				=> 'nTB.`discount`',
				'thanh_tien'                			=> 'nTB.`thanh_tien`',
				'total_real'                			=> 'nTB.`total_real`', //Thực thu
				'lai'                					=> 'nTB.`lai`',
			);

			$field = isset($sortFieldArr[$field]) ? $sortFieldArr[$field] : '';

			if ($field != '')
				$sqlSort = " ORDER BY $field $sort ";
		}

		$sqlAllPro = "SELECT  dt.`id`, dt.`product_id`, dt.`name`, dt.`price`, od.`is_internal`
								, SUM(dt.`quantity`*dt.`root_price`) total_cost
								, SUM( dt.`quantity`*dt.`price`* (dt.`decrement`/100) ) discount
								, SUM( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) thanh_tien
								, SUM( dt.`quantity`*dt.`price` ) total_real
								, SUM( ( dt.`quantity`*dt.`price`* ((100 - dt.`decrement`)/100) ) - (dt.`quantity`*dt.`root_price`) ) lai
								, dt.`sku_id`, dt.`sku_name`, SUM(dt.`quantity`) as amount
								, dt.`decrement`, dt.`vat`, dt.`root_price`, IFNULL(SKU.`code`, '') sku_code
								, IFNULL(pro.`img_1`, '') `image`
						FROM $db->tbl_fix`detail_order_" . $shop_id . "_" . date('Y', $from) . "` as dt 
						INNER JOIN $db->tbl_fix`order_" . $shop_id . "_" . date('Y', $from) . "` as od ON dt.order_id = od.id
						LEFT JOIN $db->tbl_fix`product` as pro ON pro.id = dt.product_id
						LEFT JOIN $db->tbl_fix`SKU` ON SKU.id = dt.sku_id AND SKU.`product_id` = dt.`product_id`
						WHERE od.printed='1' AND od.status='1' AND od.is_booking = '0' AND '$from' <= od.created_at AND od.created_at < '$to' 
						$keyword $sqlProCom $order_type $sqlTreasurerGroupID $sqlTreasurerGroupIDThu  
						GROUP BY dt.product_id, dt.sku_id";

		$sql = "WITH topN as (SELECT * FROM ($sqlAllPro) nTB WHERE 1 $sqlSort $limit)
				SELECT * FROM topN
				UNION ALL
				SELECT 'AllOTHER' id,'0' product_id,'Sản phẩm khác' name, IFNULL(sum(ntb.price),0) price,IFNULL(sum(ntb.is_internal),0) is_internal,IFNULL(sum(ntb.total_cost),0) total_cost,IFNULL(sum(ntb.discount),0) discount,IFNULL(sum(ntb.thanh_tien),0) thanh_tien,IFNULL(sum(ntb.total_real),0) total_real, IFNULL(sum(ntb.lai),0) lai,'0' sku_id,'All Other' sku_name,IFNULL(sum(ntb.amount),0) amount,'0' decrement, IFNULL(sum(ntb.vat),0), IFNULL(sum(ntb.root_price),0) root_price,'all-other' sku_code, '' `image`
				FROM ($sqlAllPro) ntb
				WHERE ntb.`product_id` NOT IN (SELECT product_id FROM topN)";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	//AnCode: update số lần in 
	public function update_printed()
	{
		global $db;

		$shop_id 	  = $this->get('shop_id');
		$id         = $this->get('order_id');
		$created_at = $this->get('created_at');
		$printed    = $this->get('printed');

		$arr['printed'] = $printed;

		$db->record_update($db->tbl_fix . "`order_" . $shop_id . "_" . date('Y', $created_at) . "`", $arr, " `id`='" . $id . "'");

		return true;
	}
}
$order = new order();
