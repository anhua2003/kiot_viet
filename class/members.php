<?php
class members
{

	private $class_name = 'members';
	private $user_id;
	private $code;
	private $is_official;
	private $referral_by;
	private $referral_link;

	//id user cấp quản lý trực tiếp: 
	//ví dụ user a có sale tuyển đc n user b: thì giá trị của b.direct_referral = a.id
	//---Trường hợp YOBE=> cùng một đại lý ở trên nhưng có thể là khác trường này: 
	//nếu parent chưa kích hoạt đại lý thì trường này của user mới = của parent
	// còn nếu đã kích hoạt đại lý thì trường của user mới = parent.user_id
	private $direct_referral;
	private $npp_referral; //Toàn bộ cây của npp này
	private $cmnd; //Số CMND
	private $cmnd_frontside; //CMND link mặt trước
	private $cmnd_backside; //CMND link mặt sau
	private $docs; //link file tài liệu
	private $pkd;

	private $member_department_id;

	private $activate; // Mobile activate = mobile verify đã kích hoạt bằng mobile verify chưa
	private $activated; // trạng thái trong setting được kích hoạt không: activated_status
	private $activated_at; // Đợt kích hoạt khi nào
	private $license_to; // trạng thái trong setting license_status

	private $cum;
	private $kvkd;
	private $gdkd;
	private $chinhanh;

	private $password;
	private $salt;
	private $fullname;

	private $total_spent; // doanh số thực thu: đã trừ giảm giá và chiết khẩu
	private $total_discount; // Tổng giảm giá
	private $total_revenue; // Tổng doanh số dựa trên giá lẻ ko bao gồm giảm giá

	private $day;
	private $month;
	private $year;
	private $mobile;
	private $unique_mobile;
	private $email;
	private $point;

	private $address;
	private $longitude; //Định vị địa điểm khách hàng
	private $latitude; //Định vị địa điểm khách hàng

	private $is_user_address;
	private $delivery_address;
	private $city;
	private $district;
	private $ward;

	private $city_id;
	private $district_id;
	private $ward_id;

	private $country;
	private $sex; //= 0 women, = 1 men
	private $note;
	private $avatar;
	private $last_transaction;
	private $is_wholesale_customer;
	private $is_bad_debts;
	private $max_debts;
	private $is_local_created;
	private $card_number;
	private $tax;
	private $facebook;
	private $web_id;
	private $member_group_id;
	private $member_title_id;
	private $joined_at;
	private $shop_id;
	private $gmid;//nhóm quyền
	private $permission;//quyền

	private $balance;
	private $wallet_cashback;
	private $wallet_register;

	private $session_token;

	private $bank_name;
	private $bank_account;
	private $bank_fullname;
	private $bank_branch;
	private $bank_city;

	private $by_user_cs;
	private $created_by;

	private $city_allowed;
	private $district_allowed;

	private $is_sale_daily; //Là tài khoản sale đại lý
	private $last_is_sale_daily; //Lần cập nhật on/off chức năng sale đại lý
	private $activate_is_sale_daily; //Thời gian lần đầu kích hoạt lên sale đại lý

	private $pending_is_sale_daily; //Khách hàng đang được mở chức năng chờ lên đại lý
	private $activate_is_sale_daily_at; //Thời gian mở khi nào (Chức năng nâng cấp đại lý)
	private $activate_is_sale_daily_by; //Sale đại lý nào, đã bật chức năng Chờ cập nhật đại lý cho tài khoản khách hàng này members.user_id

	private $cmnd_date_provide; //Ngày cấp
	private $cmnd_providers; //Nơi cấp

	private $list_pro_allow_free; //Danh sách sản phẩm cho phép nhận chiết khấu % free: pro1;pro2;pro3; ... bị giới hạn số lượng bởi number_pro_allow_free

	private $member_level_id; //Đang ở level nào
	private $no_referral; //Số lượng khách hàng bên dưới được giới thiệu
	private $self_revenue; //Doanh số cá nhân
	private $referral_revenue; //Doanh số nhóm (Doanh số đơn hàng thành công của toàn bộ hệ thống khách hàng được giới thiệu dưới)



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

	public function add()
	{
		global $db, $main, $setup;

		$user_id = $this->get('user_id');
		$arr['user_id'] = $user_id;
		$arr['avatar'] = $this->get('avatar');

		$arr['code'] = $this->get('code');
		$arr['is_official'] = $this->get('is_official') + 0;
		$arr['referral_by'] = $referral_by = $this->get('referral_by');
		$arr['direct_referral'] = $this->get('direct_referral') == '' ? 0 : $this->get('direct_referral');
		$arr['npp_referral'] = $this->get('npp_referral') == '' ? 0 : $this->get('npp_referral');

		$arr['cmnd'] 			= $this->get('cmnd');

		$arr['cmnd_frontside'] 	= $this->get('cmnd_frontside') == '' ? '' : $this->get('cmnd_frontside');
		$arr['cmnd_backside'] 	= $this->get('cmnd_backside') == '' ? '' : $this->get('cmnd_backside');
		$arr['docs'] 			= $this->get('docs') == '' ? '' : $this->get('docs');

		$arr['pkd'] 			= $this->get('pkd');

		$arr['member_department_id'] 			= $this->get('member_department_id') + 0;

		$arr['activated']						= 0;
		$arr['activated_at']					= 0;
		if (isset($setup['activated_status']) && $setup['activated_status'] == 1) {
			$arr['activated']					= 1;
			$arr['activated_at']				= time();
		}
		$arr['license_to']						= 0;

		$arr['cum'] 		= $this->get('cum');
		$arr['kvkd'] 		= $this->get('kvkd');
		$arr['gdkd'] 		= $this->get('gdkd');
		$arr['chinhanh'] 	= $this->get('chinhanh');

		$arr['is_wholesale_customer'] = $this->get('is_wholesale_customer')+0;

		$arr['password'] 	= '';
		$arr['salt'] 		= '';

		$password 	= $this->get('password');
		if ($password != '') {
			$salt = $this->randString(10);
			$pass = md5(md5($password) . $salt);

			$arr['password'] = $pass;
			$arr['salt'] = $salt;
		}

		$arr['fullname'] 		= $this->get('fullname');
		$arr['mobile'] 			= $this->get('mobile');
		$arr['unique_mobile'] 	= $main->number($arr['mobile']);

		$arr['city_id'] 		= '0' . $this->get('city_id');
		$arr['district_id'] 	= '0' . $this->get('district_id');
		$arr['ward_id'] 		= '0' . $this->get('ward_id');

		$arr['city'] 			= $this->get('city');
		$arr['district'] 		= $this->get('district');
		$arr['ward'] 			= $this->get('ward');
		$arr['country'] 		= $this->get('country');

		$arr['address'] = $this->get('address');

		if ($this->get('delivery_address') != '') {
			$arr['delivery_address'] = $this->get('delivery_address');
		} else {
			$arr['delivery_address'] = $this->get('address');
		}

		$member_group_id = $this->get('member_group_id');
		$member_group_id = $member_group_id == '' ? $setup['default_members_group_id'] : $member_group_id;

		$arr['member_group_id'] = $member_group_id + 0;
		$arr['member_title_id'] = $this->get('member_title_id') == '' ? 0 : $this->get('member_title_id');

		$arr['direct_referral'] 	= $this->get('direct_referral') + 0;
		$arr['npp_referral'] 		= $this->get('npp_referral') + 0;
		$arr['cmnd_date_provide'] 	= $this->get('cmnd_date_provide');
		$arr['cmnd_providers'] 		= $this->get('cmnd_providers');

		// if (isset($setup['is_yobe365']) && $setup['is_yobe365'] == 1 && (!isset($arr['direct_referral']) || $arr['direct_referral'] == 0)) {
		// 	//Tính ra direct_referral cho user này nếu chưa tính toán
		// 	//member_group_id_npp_tuyen
		// 	//member_group_id_khachhang (hoặc đại lý)

		// 	if ($member_group_id == 12) {

		// 		$this->set('referral_by', $referral_by);
		// 		$dParent = $this->get_by_referral();
		// 		if (isset($dParent['user_id'])) {

		// 			if ($dParent['member_group_id'] == $setup['member_group_id_khachhang'] && $dParent['activated_at'] > 0) { //Đã 1 lần kích hoạt thì user cứ đổ vào đại lý
		// 				$arr['direct_referral'] = $dParent['user_id'];
		// 				$arr['npp_referral'] = $dParent['npp_referral'];
		// 			} else if ($dParent['member_group_id'] == $setup['member_group_id_khachhang']) { //chưa bao giờ kích hoạt đại lý
		// 				$arr['direct_referral'] = $dParent['direct_referral'];
		// 				$arr['npp_referral'] = $dParent['npp_referral'];
		// 			} else if ($dParent['member_group_id'] == $setup['member_group_id_npp_tuyen']) {
		// 				$arr['npp_referral'] = $dParent['user_id'];
		// 			}
		// 		}
		// 	} else if ($member_group_id == 11) {

		// 		$this->set('referral_by', $referral_by);
		// 		$this->set('member_group_id', 9); //PTTT
		// 		$id_direct = $this->get_id_parent_at(); //Get id đại lý
		// 		if (!$id_direct) {
		// 			$arr['direct_referral'] = $id_direct;
		// 			$arr['npp_referral'] 	= $id_direct;
		// 		}
		// 	} else if ($member_group_id == 9) {

		// 		$this->set('referral_by', $referral_by);
		// 		$this->set('member_group_id', 7); //PTTT
		// 		$id_direct = $this->get_id_parent_at(); //Get id đại lý
		// 		if (!$id_direct) {
		// 			$arr['direct_referral'] = $id_direct;
		// 			$arr['npp_referral'] 	= $id_direct;
		// 		}
		// 	} else if ($member_group_id == 4) {

		// 		$this->set('referral_by', $referral_by);
		// 		$dParent = $this->get_by_referral();
		// 		if (isset($dParent['user_id'])) {
		// 			$arr['direct_referral'] = $dParent['user_id'];
		// 			$arr['npp_referral'] = $dParent['user_id'];
		// 		}
		// 	}
		// }

		$arr['total_spent'] = $this->get('total_spent')+0;
		$arr['point'] = $this->get('point')+0;
		$arr['tax'] = $this->get('tax')+0;

		$arr['day'] = $this->get('day');
		$arr['month'] = $this->get('month');
		$arr['year'] = $this->get('year');

		$arr['email'] = $this->get('email');
		$arr['facebook'] = $this->get('facebook');
		$arr['note'] = $this->get('note');

		if ($this->get('web_id') > 0)
			$arr['web_id'] 			= $this->get('web_id');

		$arr['is_user_address'] = $this->get('is_user_address') + 0;

		$arr['is_bad_debts'] = $this->get('is_bad_debts');
		$arr['max_debts'] = $this->get('max_debts');
		$arr['shop_id'] 	= $this->get('shop_id') + 0;
		$arr['gmid'] 	  = $this->get('gmid');//vancode
		$arr['permission'] 	  = $this->get('permission');//vancode 
		$arr['created_by'] 	= $this->get('created_by') . '';
		$arr['is_local_created'] = 1;

		$arr['joined_at'] = time();

		$arr['by_user_cs'] 	= $this->get('by_user_cs') + 0;

		$arr['city_allowed'] 		= $this->get('city_allowed');
		$arr['district_allowed'] 	= $this->get('district_allowed');

		$arr['card_number'] 	= $this->get('card_number');
		$arr['tax'] 			= $this->get('tax');
		$arr['sex'] 			= $this->get('sex') + 0;
		$arr['last_transaction'] 			= $this->get('last_transaction') + 0;
		$arr['list_pro_allow_free'] 			= $this->get('list_pro_allow_free');
		$arr['total_discount'] 			= $this->get('total_discount') + 0;
		$arr['total_revenue'] 			= $this->get('total_revenue') + 0;
		$arr['longitude'] 			= $this->get('longitude') + 0;
		$arr['latitude'] 			= $this->get('latitude') + 0;
		$arr['is_bad_debts'] 			= $this->get('is_bad_debts') + 0;
		$arr['max_debts'] 			= $this->get('max_debts') + 0;

		$dThis = $this->get_detail();
		if (!isset($dThis['user_id'])) {

			unset($arr['user_id']);
			$arr['wallet_main'] 	= 0;
			$arr['wallet_cashback'] = 0;
			$arr['wallet_register'] = 0; //isset($setup['is_yobe365']) && isset($setup['wallet_register_bonus_amount']) ? $setup['wallet_register_bonus_amount'] : 0;
			$arr['session_token'] 	= '';

			$arr['bank_name'] 		= '';
			$arr['bank_account'] 	= '';
			$arr['bank_fullname'] 	= '';
			$arr['bank_branch'] 	= '';
			$arr['bank_city'] 		= '';

			$arr['referral_link'] 	= '';

			$arr['member_level_id'] 		= '0';
			$arr['no_referral'] 			= '0';
			$arr['self_revenue'] 			= '0';
			$arr['referral_revenue'] 		= '0';

			// $arr['balance_promotion'] = 0;
			$arr['session_token'] 	= '';
			$arr['activate'] 		= 1;
			$db->record_insert('members', $arr);
			$user_id = $db->mysqli_insert_id();

			if (isset($setup['new_register_trial_days']) && $setup['new_register_trial_days'] > 0) {
				//Giới hạn khách hàng mới sử dụng defined ngày
				$this->set('user_id', $user_id);
				$this->set('license_to', time() +  $setup['new_register_trial_days'] * 86400);
				$this->license_upgrade();
			}

			if ($arr['code'] == '') {
				$arr1['code'] = isset($setup['start_member_code']) ? $setup['start_member_code'] . $arr['mobile'] : 'KH' . sprintf("%05d", $user_id);
				$db->record_update('members', $arr1, " `user_id` = '$user_id' ");
				unset($arr1);
			}
		} else
			$this->update();

		/*
		- BEGIN up level for user
		- Tính toán để lên level tự động
		*/
		if ($referral_by != '') {
			$this->set('referral_by', $referral_by);
			$dParent = $this->get_detail_parent();
			if (isset($dParent['user_id'])) {
				$this->set('user_id', $dParent['user_id']);
				$this->cal_up_level();
			}
		}
		/*
		- BEGIN up level for user
		*/

		unset($arr);
		return $user_id;
	}

	public function update_by_CS()
	{
		global $db, $setup;

		$user_id 						= $this->get('user_id');

		$arr['code'] 					= $this->get('code');
		$arr['fullname'] 				= $this->get('fullname');
		$arr['mobile'] 					= $this->get('mobile');
		$arr['email'] 					= $this->get('email');
		$arr['address'] 				= $this->get('address');
		$arr['referral_by'] 			= $this->get('referral_by');
		$arr['note'] 					= $this->get('note');
		$arr['avatar'] 					= $this->get('avatar');
		$arr['member_group_id'] 		= $this->get('member_group_id');
		$arr['member_department_id'] 	= $this->get('member_department_id');
		$arr['is_official'] 			= $this->get('is_official');

		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' ");

		return $user_id;
	}

	public function update_referral_link()
	{
		global $db, $setup;

		$user_id 					= $this->get('user_id');
		$arr['referral_link'] 		= $this->get('referral_link');
		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' ");

		return true;
	}

	public function update_max_debts_and_is_bad_debts(){
		global $db, $setup;

		$user_id 					= $this->get('user_id');
		$arr['max_debts'] 			= $this->get('max_debts');
		$arr['is_bad_debts'] 		= $this->get('is_bad_debts');
		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' ");

		return true;
	}

	// public function hub_add(){
	// 	global $db, $main, $setup;

	// 	$user_id = $this->get('user_id');

	// 	$arr['user_id'] = $user_id;
	// 	$arr['avatar'] = $this->get('avatar');

	// 	$arr['code'] = $this->get('code');
	// 	$arr['referral_by'] = $referral_by = $this->get('referral_by');
	// 	$arr['direct_referral'] = $this->get('direct_referral') == '' ? 0:$this->get('direct_referral');
	// 	$arr['cmnd'] = $this->get('cmnd');
	// 	$arr['pkd'] = '';

	// 	$arr['member_department_id'] 			= $this->get('member_department_id') == '' ? $setup['default_member_department_id']:$this->get('member_department_id');
	// 	$arr['activated']						= isset( $setup['activated_status']) && $setup['activated_status'] == 1 ? 0:1;
	// 	$arr['license_to']						= 0;
	// 	$arr['cum'] 							= '';
	// 	$arr['kvkd'] 							= '';
	// 	$arr['gdkd'] 							= '';
	// 	$arr['chinhanh'] 						= '';

	// 	$arr['is_wholesale_customer'] = 0;

	// 	$password 	= $this->get('session_token');
	// 	// $salt = $this->randString(10);
	// 	// $pass = md5(md5($password).$salt);

	// 	$arr['password'] = $password;
	// 	$arr['salt'] = $salt;

	// 	$arr['fullname'] = $this->get('fullname');
	// 	$arr['mobile'] = $this->get('mobile');
	// 	$arr['unique_mobile'] = $main->number( $arr['mobile'] );

	// 	$arr['city'] = $this->get('city');
	// 	$arr['city_id'] = $this->get('city_id')+0;

	// 	$arr['district'] = $this->get('district');
	// 	$arr['district_id'] = $this->get('district_id')+0;

	// 	$arr['ward'] = $this->get('ward');
	// 	$arr['ward_id'] = $this->get('ward_id')+0;

	// 	$arr['address'] = $this->get('address');
	// 	$arr['country'] = $this->get('country');

	// 	if( $this->get('delivery_address') != '' ){
	// 		$arr['delivery_address'] = $this->get('delivery_address');
	// 	}else {
	// 		$arr['delivery_address'] = $this->get('address');
	// 	}

	// 	$arr['member_group_id'] 	= $this->get('member_group_id') == '' ? $setup['default_member_group_id']:$this->get('member_group_id');

	// 	$arr['total_spent'] = 0;
	// 	$arr['point'] = 0;
	// 	$arr['tax'] = 0;

	// 	$arr['day'] 	= $this->get('day');
	// 	$arr['month'] 	= $this->get('month');
	// 	$arr['year'] 	= $this->get('year');

	// 	$arr['email'] = $this->get('email');
	// 	$arr['facebook'] = '';
	// 	$arr['note'] = '';

	// 	$arr['is_user_address'] 	= $this->get('is_user_address')+0;

	// 	$arr['is_bad_debts'] 		= 0;
	// 	$arr['max_debts'] 			= 0;
	// 	$arr['shop_id'] 			= 0;
	// 	$arr['is_local_created'] 	= $this->get('is_local_created');
	// 	$arr['joined_at'] = time();

	// 	$arr['by_user_cs'] 	= $this->get('by_user_cs') == '' ? $setup['default_by_user_cs']:$this->get('by_user_cs');

	// 	$arr['is_official'] 		= 0;
	// 	$arr['wallet_main'] 		= 0;
	// 	$arr['wallet_cashback'] 	= 0;
	// 	$arr['wallet_register'] 	= 0;
	// 	$arr['session_token'] 		= $this->get('session_token');

	// 	$arr['bank_name'] 		= '';
	// 	$arr['bank_account'] 	= '';
	// 	$arr['bank_fullname'] 	= '';
	// 	$arr['bank_branch'] 	= '';
	// 	$arr['bank_city'] 		= '';

	// 	$db->record_insert($db->tbl_fix.'`members`', $arr);
	// 	$user_id = $db->mysqli_insert_id();

	// 	if( $arr['code'] == '' ){
	// 		$arr1['code'] = 'KH'.sprintf( "%05d", $user_id);
	// 		$db->record_update( $db->tbl_fix.'`members`', $arr1, " `user_id` = '$user_id' ");
	// 		unset($arr1);
	// 	}

	// 	/*
	// 	- BEGIN up level for user
	// 	- Tính toán để lên level tự động
	// 	*/
	// 	if( $referral_by != '' ){
	// 		$this->set('referral_by', $referral_by);
	// 		$dParent = $this->get_detail_parent();
	// 		if( isset($dParent['user_id']) ){
	// 			$this->set('user_id', $dParent['user_id']);
	// 			$this->cal_up_level();
	// 		}
	// 	}
	// 	/*
	// 	- BEGIN up level for user
	// 	*/

	// 	unset($arr);
	// 	return $user_id;
	// }

	public function hub_update()
	{
		global $db, $main, $setup;

		$user_id 			= $this->get('user_id');

		$arr['avatar'] 		= $this->get('avatar');
		$arr['cmnd'] 		= $this->get('cmnd');

		$arr['activated']						= 0;
		$arr['activated_at']					= 0;
		if (isset($setup['activated_status']) && $setup['activated_status'] == 1) {
			$arr['activated']					= 1;
			$arr['activated_at']				= time();
		}
		$arr['license_to']						= 0;

		$password 			= $this->get('password');

		$arr['password'] 	= $password;
		$arr['session_token'] = $password;
		$arr['salt'] 		= $salt;

		$arr['fullname'] 	= $this->get('fullname');
		$arr['mobile'] 		= $this->get('mobile');
		$arr['unique_mobile'] = $main->number($arr['mobile']);

		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' ");

		unset($arr);
		return $user_id;
	}

	public function update()
	{
		global $db;
		$main = new main();

		if ($this->get('avatar') != '') $arr['avatar'] = $this->get('avatar');

		$arr['fullname'] = $this->get('fullname');
		$arr['is_wholesale_customer'] = $this->get('is_wholesale_customer') + 0;
		$arr['fullname'] = $this->get('fullname');
		$arr['mobile'] = $this->get('mobile');
		$arr['unique_mobile'] = $main->number($arr['mobile']);

		$arr['code'] = $this->get('code');
		$arr['is_official'] = $this->get('is_official');
		$arr['referral_by'] = $this->get('referral_by');
		$arr['cmnd'] = $this->get('cmnd');

		if ($this->get('cmnd_frontside') != '')
			$arr['cmnd_frontside'] 	= $this->get('cmnd_frontside');

		if ($this->get('cmnd_backside') != '')
			$arr['cmnd_backside'] 	= $this->get('cmnd_backside');

		if ($this->get('docs') != '')
			$arr['docs'] 			= $this->get('docs');

		$arr['pkd'] = $this->get('pkd');

		$arr['member_department_id'] 			= $this->get('member_department_id');
		$arr['cum'] 		= $this->get('cum');
		$arr['kvkd'] 		= $this->get('kvkd');
		$arr['gdkd'] 		= $this->get('gdkd');
		$arr['chinhanh'] 	= $this->get('chinhanh');

		$password = $this->get('password');
		if ($password != '') {

			$salt = $this->randString(10);
			$pass = md5(md5($password) . $salt);

			$arr['password'] = $pass;
			$arr['salt'] = $salt;
		}

		$arr['address'] = $this->get('address');
		$arr['delivery_address'] = $this->get('delivery_address');

		$arr['day'] 			= $this->get('day');
		$arr['month'] 			= $this->get('month');
		$arr['year'] 			= $this->get('year');

		$arr['city_id'] 		= $this->get('city_id') + 0;
		$arr['district_id'] 	= $this->get('district_id') + 0;
		$arr['ward_id'] 		= $this->get('ward_id') + 0;

		$arr['city'] 			= $this->get('city');
		$arr['district'] 		= $this->get('district');
		$arr['ward'] 			= $this->get('ward');

		$arr['member_group_id'] = $this->get('member_group_id');
		$arr['member_title_id'] = $this->get('member_title_id') > 0 ? $this->get('member_title_id') : 0;

		$arr['total_spent'] 	= $this->get('total_spent') + 0;
		$arr['point'] 			= $this->get('point') + 0;
		$arr['tax'] 			= $this->get('tax');
		$arr['sex'] 			= $this->get('sex') + 0;
		$arr['email'] 			= $this->get('email');
		$arr['facebook'] 		= $this->get('facebook');

		if ($this->get('web_id') > 0)
			$arr['web_id'] 			= $this->get('web_id');

		$arr['shop_id'] 			= $this->get('shop_id') + 0;
		$arr['gmid'] 			    = $this->get('gmid');//vancode
		$arr['permission'] 			= $this->get('permission');//vancode
		$arr['note'] 				= $this->get('note');

		$arr['by_user_cs'] 			= $this->get('by_user_cs') + 0;

		$arr['city_allowed'] 		= $this->get('city_allowed');
		$arr['district_allowed'] 	= $this->get('district_allowed');
		$arr['activate'] 			= $this->get('activate');
		$arr['session_token'] 		= '';

		$db->record_update($db->tbl_fix . 'members', $arr, " `user_id` = '" . $this->get('user_id') . "'");
		unset($arr);
		return true;
	}

	public function update_password()
	{
		global $db;

		$user_id 				= $this->get('user_id');
		$password 				= $this->get('password');
		$fullname 				= $this->get('fullname');

		$arr['salt'] 			= $this->randString(10);
		$arr['password'] 		= md5(md5($password) . $arr['salt']);
		$arr['session_token'] 	= '';

		if ($fullname != '')
			$arr['fullname'] 	= $fullname;

		$db->record_update($db->tbl_fix . $this->class_name, $arr, " `user_id` = '$user_id' ");

		return $arr['password'];
	}

	public function reset_password()
	{
		global $db;

		$user_id 				= $this->get('user_id');
		$password 				= $this->get('password');
		// $session_token 			= $this->get('session_token');

		$arr['salt'] 			= $this->randString(10);
		$arr['password'] 		= md5(md5($password) . $arr['salt']);
		// $arr['session_token'] 	= $session_token;

		$db->record_update($db->tbl_fix . $this->class_name, $arr, " `user_id` = '$user_id' ");

		return $arr['password'];
	}

	public function update_password_first()
	{
		global $db;

		$user_id 				= $this->get('user_id');
		$password 				= $this->get('password');
		$fullname 				= $this->get('fullname');

		$arr['salt'] 			= $this->randString(10);
		$arr['password'] 		= md5(md5($password) . $arr['salt']);

		if ($fullname != '')
			$arr['fullname'] 	= $fullname;

		$db->record_update($db->tbl_fix . $this->class_name, $arr, " `user_id` = '$user_id' ");

		return $arr['password'];
	}

	public function update_official()
	{
		global $db;

		$user_id 				= $this->get('user_id');
		$is_official 			= $this->get('is_official');

		$arr['is_official'] 	= $is_official;
		$db->record_update($db->tbl_fix . $this->class_name, $arr, " `user_id` = '$user_id' ");

		return true;
	}

	public function empty_password()
	{
		global $db;

		$user_id 			= $this->get('user_id');

		$arr['salt'] 		= '';
		$arr['password'] 	= '';
		$db->record_update($db->tbl_fix . $this->class_name, $arr, " `user_id` = '$user_id' ");

		return true;;
	}

	// update thông tin để nâng cấp đại lý (tùng code - 26/12/21)
	public function update_info()
	{
		global $db;
		$main = new main();

		if ($this->get('member_group_id') > 0) $arr['member_group_id'] = $this->get('member_group_id');
		if ($this->get('member_title_id') > 0) $arr['member_title_id'] = $this->get('member_title_id');
		if ($this->get('fullname') != '') $arr['fullname'] = $this->get('fullname');
		if ($this->get('facebook') != '') $arr['facebook'] = $this->get('facebook');

		if ($this->get('day') != '') $arr['day'] = $this->get('day');
		if ($this->get('month') != '') $arr['month'] = $this->get('month');
		if ($this->get('year') != '') $arr['year'] = $this->get('year');
		if ($this->get('sex') !== '') $arr['sex'] = $this->get('sex')+0;

		if ($this->get('cum') != '') $arr['cum'] = $this->get('cum');
		if ($this->get('pkd') != '') $arr['pkd'] = $this->get('pkd');
		if ($this->get('gdkd') != '') $arr['gdkd'] = $this->get('gdkd');
		if ($this->get('kvkd') != '') $arr['kvkd'] = $this->get('kvkd');
		if ($this->get('chinhanh') != '') $arr['chinhanh'] = $this->get('chinhanh');
		if ($this->get('district') != '') $arr['district'] = $this->get('district');

		if ($this->get('cmnd') != '') $arr['cmnd'] = $this->get('cmnd');
		if ($this->get('cmnd_frontside') != '') $arr['cmnd_frontside'] = $this->get('cmnd_frontside');
		if ($this->get('cmnd_backside') != '') $arr['cmnd_backside'] = $this->get('cmnd_backside');
		if ($this->get('avatar') != '') $arr['avatar'] = $this->get('avatar');
		if ($this->get('tax') != '') $arr['tax'] = $this->get('tax');
		if ($this->get('mobile') != '') $arr['mobile'] = $this->get('mobile');
		if ($this->get('email') != '') $arr['email'] = $this->get('email');
		if ($this->get('cmnd_date_provide') != '') $arr['cmnd_date_provide'] = $this->get('cmnd_date_provide');
		if ($this->get('cmnd_providers') != '') $arr['cmnd_providers'] = $this->get('cmnd_providers');

		if ($this->get('activate') != '') $arr['activate'] = $this->get('activate');
		if ($this->get('password') != '') $arr['password'] = $this->get('password');
		if ($this->get('address') != '') $arr['address'] = $this->get('address');

		$db->record_update('members', $arr, " `user_id` = '" . $this->get('user_id') . "'");
		unset($arr);
		return true;
	}

	public function update_web_info()
	{
		global $db;

		$user_id 			= $this->get('user_id');
		$arr['facebook'] 	= $this->get('facebook');
		$arr['web_id'] 		= $this->get('web_id');

		$db->record_update($db->tbl_fix . $this->class_name, $arr, " `user_id` = '$user_id' ");

		return true;
	}

	public function update_avatar()
	{
		global $db;
		$main = new main();

		if ($this->get('avatar') != '') $arr['avatar'] = $this->get('avatar');

		$db->record_update('members', $arr, " `user_id` = '" . $this->get('user_id') . "'");
		unset($arr);
		return true;
	}

	//tung code
	public function update_info_partner()
	{
		global $db;
		$main = new main();

		// $user_id 			= $this->get('user_id');

		$arr['fullname'] 		= $this->get('fullname');
		$arr['email'] 			= $this->get('email');
		$arr['mobile'] 			= $this->get('mobile');
		$arr['address'] 		= $this->get('address');

		$db->record_update('members', $arr, " `user_id` = '" . $this->get('user_id') . "'");
		unset($arr);
		return true;
	}

	public function update_bank_info()
	{
		global $db;

		$arr['bank_name'] 		= $this->get('bank_name');
		$arr['bank_account'] 	= $this->get('bank_account');
		$arr['bank_fullname'] 	= $this->get('bank_fullname');
		$arr['bank_branch'] 	= $this->get('bank_branch');
		$arr['bank_city'] 		= $this->get('bank_city');

		$db->record_update('members', $arr, " `user_id` = '" . $this->get('user_id') . "' ");

		unset($arr);
		return true;
	}

	public function update_bank_info_yobe()
	{
		global $db;

		$arr['bank_name'] 		= $this->get('bank_name');
		$arr['bank_account'] 	= $this->get('bank_account');
		$arr['bank_fullname'] 	= $this->get('bank_fullname');
		$arr['bank_branch'] 	= $this->get('bank_branch');
		$arr['bank_city'] 		= $this->get('bank_city');

		$db->record_update('members', $arr, " `user_id` = '" . $this->get('user_id') . "' ");

		unset($arr);
		return true;
	}

	public function update_synchronize()
	{
		global $db;
		$main = new main();
		$arr['fullname'] = $this->get('fullname');
		$arr['mobile'] = $this->get('mobile');
		$arr['unique_mobile'] = $main->only_number($this->get('mobile'));
		$arr['address'] = $this->get('address');
		$arr['city'] = $this->get('city');
		$arr['country'] = $this->get('country');
		$arr['sex'] = $this->get('sex') + 0;
		$arr['avatar'] = $this->get('avatar');
		$db->record_update('members', $arr, " `user_id` = '" . $this->get('user_id') . "'");
		unset($arr);
		return true;
	}

	public function searching_members($txt)
	{
		global $db;
		$referral_by = $this->get('referral_by');
		if ($referral_by != '') $referral_by = " AND ( ( `mb`.referral_by = '$referral_by' AND `mb`.referral_by <> '') OR ( `mb`.mobile = '$referral_by' AND `mb`.mobile <> '' ) )  ";

		$kq = array();
		if ($txt != '') {
			$txt = " (`email` LIKE '%$txt%' OR `unique_mobile` LIKE '%$txt%' OR `code` LIKE '%$txt%') ";

			$sql = "SELECT * FROM `members` WHERE  `user_id` > 5 AND $txt $referral_by LIMIT 1000";

			$result = $db->executeQuery($sql);
			while ($row = mysqli_fetch_assoc($result)) {
				$kq[] = $row;
			}

			unset($result);
		}
		return $kq;
	}

	public function list_members_revenue($month, $year)
	{
		global $db;

		$collected_orders = new collected_orders();
		$collected_orders->set('month', $month);
		$collected_orders->set('year', $year);

		$sql = "SELECT mb.*, mg.`name` member_group_name
				FROM `members` mb
				LEFT JOIN `member_group` mg
				ON `mb`.`member_group_id` = `mg`.`id`
				WHERE `user_id` > 5
				ORDER BY `total_spent` DESC, `fullname`
				";

		$kq = array();
		$result = $db->executeQuery($sql);
		while ($row = mysqli_fetch_assoc($result)) {

			$collected_orders->set('members_id', $row['user_id']);
			$sRev = $collected_orders->list_by_members_by_month();

			$row['total_revenue'] 	= $sRev['total_revenue'];
			$row['total_discount'] 	= $sRev['total_discount'];
			$row['total_cost'] 		= $sRev['total_cost'];

			$kq[] = $row;
		}

		unset($result);
		return $kq;
	}

	public function list_members_revenue_by_field($month, $year)
	{
		global $db;

		$collected_orders = new collected_orders();
		$collected_orders->set('month', $month);
		$collected_orders->set('year', $year);

		$sql = "SELECT mb.*, mg.`name` member_group_name
				FROM `members` mb
				LEFT JOIN `member_group` mg
				ON `mb`.`member_group_id` = `mg`.`id`
				WHERE `user_id` > 5
				ORDER BY `total_spent` DESC, `fullname`
				";

		$kq = array();
		$result = $db->executeQuery($sql);
		while ($row = mysqli_fetch_assoc($result)) {

			$collected_orders->set('members_id', $row['user_id']);
			$sRev = $collected_orders->list_by_members_by_month_field('referral_by', $row['code']);

			$row['total_revenue'] 	= $sRev['total_revenue'];
			$row['total_discount'] 	= $sRev['total_discount'];
			$row['total_cost'] 		= $sRev['total_cost'];

			$kq[] = $row;
		}

		unset($result);
		return $kq;
	}

	public function list_members_revenue_by_pkd($month, $year)
	{
		global $db;

		$collected_orders = new collected_orders();
		$collected_orders->set('month', $month);
		$collected_orders->set('year', $year);

		$sql = "SELECT IFNULL(mb.`pkd`, '') pkd
				FROM `members` mb
				WHERE `user_id` > 5
				GROUP BY mb.`pkd`
				ORDER BY `total_spent` DESC, `fullname`
				";

		$kq = array();
		$result = $db->executeQuery($sql);
		while ($row = mysqli_fetch_assoc($result)) {

			$sRev = $collected_orders->list_by_members_by_month_pkd('pkd', $row['pkd']);

			$row['total_revenue'] 	= $sRev['total_revenue'];
			$row['total_discount'] 	= $sRev['total_discount'];
			$row['total_cost'] 		= $sRev['total_cost'];

			$kq[] = $row;
		}

		unset($result);
		return $kq;
	}

	public function filter_members($keyword,$gmid, $joined_from, $month, $city, $field, $sort, $offset = 0, $limit = '')
	{
		global $db, $user, $setup;

		// $eco_city 		= new eco_city();
		// $eco_district 	= new eco_district();

		$shop_id 				= $this->get('shop_id'); //shop_id1;shop_id2;
		$is_official 			= $this->get('is_official'); //Khách hàng chính thức
		$member_group_id 		= $this->get('member_group_id');
		$member_department_id 	= $this->get('member_department_id');
		$code 					= $this->get('code');
		$mobile 				= $this->get('mobile');
		$license_to 			= $this->get('license_to');
		$referral_by 			= '';

		$sqlShop =  '';
		if ($shop_id != '') {
			$ls = explode(';', $shop_id);
			foreach ($ls as $ite) {
				if ($ite != '')
					$sqlShop .= " mb.shop_id = '$ite' OR";
			}
			if ($sqlShop != '')
				$sqlShop = 'AND (' . substr($sqlShop, 0, -2) . ' )';
		}

		if ($is_official != '') $is_official = " AND `mb`.is_official = '$is_official' ";
		if ($member_group_id != '') $member_group_id = " AND `mb`.member_group_id = '$member_group_id' ";
		if ($member_department_id != '') $member_department_id = " AND `mb`.member_department_id = '$member_department_id' ";

		if ($code != '' || $mobile != '') $referral_by = "AND ( `referral_by` = '$code' OR `referral_by` = '$mobile' ) AND `referral_by` <> '' ";
		if ($joined_from != '') $joined_from = " AND mb.`joined_at` > $joined_from ";
		if ($month != '') $month = " AND mb.`month` = '$month' ";
		if ($keyword != '') $keyword = " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`email` LIKE '%$keyword%'  OR mb.`unique_mobile` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";
		if ($city != '') $city = " AND mb.`city` = '$city' ";
		if ($license_to != '' && $license_to > 0)
			$license_to = " AND mb.`license_to` > 0 ";
		else
			$license_to = '';

		if ($limit != '') $limit = "LIMIT $offset,$limit";
		
		$sqlgmid = '';
		if( $gmid != '') $sqlgmid = "AND mb.`gmid` = '$gmid'";//vancode

		if (in_array($field, array(
			'fullname',
			'user_id',
			'member_group_name',
			'code',
			'shop_name',
			'last_transaction',
			'total_spent',
			'total_liabilities',
			'joined_at',
			'wallet_detail_main',
			'wallet_detail_share',
			'wallet_register',
			'wallet_detail_cashback',
		))) {
			if (!in_array($sort, array('ASC', 'DESC'))) $sort = 'ASC';
			$sorting = " ORDER BY nTB.`$field` $sort ";
		} else {
			$sorting = " ORDER BY nTB.`joined_at` ASC ";
		}

		$sqlMBGroupName = " IFNULL(mg.`name`, 'Mặc định') member_group_name ";
		// if (isset($setup['is_yobe365']) && $setup['is_yobe365'] == 1) {
		// 	$sqlMBGroupName = "IF( mb.`member_group_id` = '" . $setup['member_group_id_khachhang'] . "' AND mb.`license_to` > 0 , 'Đại lý', mg.`name` ) member_group_name";
		// }

		// $wallet_id_main 		= $setup['wallet_id_main'];
		// $wallet_id_share 		= $setup['wallet_id_share'];
		// $wallet_id_cashback 	= $setup['wallet_id_cashback'];

		$sql = "SELECT * FROM(
					SELECT mb.*, $sqlMBGroupName, IFNULL(nTB.`total_liabilities`, 0) total_liabilities
							, IFNULL(shop.`name`, 'Chưa khai báo') shop_name
							, IFNULL( `mti`.`name`, '') member_title_name
							, gmid.`name` as gmid_name
							
					FROM `members` mb
					LEFT JOIN `member_group` mg ON `mb`.`member_group_id` = `mg`.`id`
					LEFT JOIN `member_title` mti ON `mb`.`member_title_id` = `mti`.`id`
					LEFT JOIN `shop` ON `shop`.`id` = `mb`.`shop_id`
					LEFT JOIN `gmid` ON gmid.id = `mb`.`gmid` 
					


					LEFT JOIN (
						SELECT `customer_id`, SUM(`total_left`) `total_liabilities`
						FROM `liabilities` lia
						WHERE `total_left` > 0 AND `type` = 'KH'
						GROUP BY lia.`customer_id`
					) nTB
					ON nTB.`customer_id` = mb.`user_id`
					WHERE `user_id` > 5 $joined_from $month $is_official $city $keyword $sqlgmid $referral_by $member_group_id $member_department_id $sqlShop $license_to
				) nTB
				$sorting
				$limit";

		// , IFNULL( `wd_main`.amount, 0) wallet_detail_main
		// 			, IFNULL( `wd_share`.amount, 0) wallet_detail_share
		// 			, IFNULL( `wd_cashback`.amount, 0) wallet_detail_cashback
		// LEFT JOIN $db->tbl_fix`wallet_detail` wd_main ON ( `wd_main`.`client_id` = `mb`.`user_id` AND `wd_main`.wallet_id = '$wallet_id_main' )
		// 	LEFT JOIN $db->tbl_fix`wallet_detail` wd_share ON ( `wd_share`.`client_id` = `mb`.`user_id` AND `wd_share`.wallet_id = '$wallet_id_share' )
		// 	LEFT JOIN $db->tbl_fix`wallet_detail` wd_cashback ON ( `wd_cashback`.`client_id` = `mb`.`user_id` AND `wd_cashback`.wallet_id = '$wallet_id_cashback' )

		$kq = array();
		$result = $db->executeQuery($sql);
		while ($row = mysqli_fetch_assoc($result)) {

			$row['by_user_cs_fullname'] = 'Mặc định';
			if ($row['by_user_cs'] > 0)
				$row['by_user_cs_fullname'] = $user->get_fullname_by_id($row['by_user_cs']);

			// $row['city_allowed_list'] 		= $eco_city->get_by_list_strID( $row['city_allowed'] );
			// $row['district_allowed_list'] 	= $eco_district->get_by_list_strID( $row['district_allowed'] );
			unset($row['password']);
			unset($row['salt']);
			unset($row['session_token']);

			$kq[] = $row;
		}

		unset($result);
		return $kq;
	}
	//vancode add fuction filter_count_members
	public function filter_count_members( $keyword,$gmid ) {
		global $db;

		if( $gmid != '' ) $gmid = " AND `gmid` = '$gmid' ";
		if ($keyword != '') $keyword = " AND ( `fullname` LIKE '%$keyword%' OR `email` LIKE '%$keyword%'  OR `unique_mobile` LIKE '%$keyword%' OR `code` LIKE '%$keyword%' ) ";

		$sql = "SELECT COUNT(*) total
				FROM " . $db->tbl_fix . "`members`
				WHERE `user_id` > 5
				$gmid
				$keyword";
		
		$rows = $db->executeQuery( $sql, 1);
		
		return $rows['total']+0;
	}
	//END

	//Sum info của user
	public function filter_members_summary($keyword, $joined_from, $month, $city)
	{
		global $db;

		$shop_id 				= $this->get('shop_id');
		$is_official 			= $this->get('is_official');
		$member_group_id 		= $this->get('member_group_id');
		$member_department_id 	= $this->get('member_department_id');
		$code 					= $this->get('code');
		$mobile 				= $this->get('mobile');
		$license_to 			= $this->get('license_to');
		$referral_by			= '';

		$sqlShop =  '';
		if ($shop_id != '') {
			$ls = explode(';', $shop_id);
			foreach ($ls as $ite) {
				if ($ite != '')
					$sqlShop .= " mb.shop_id = '$ite' OR";
			}
			if ($sqlShop != '')
				$sqlShop = 'AND (' . substr($sqlShop, 0, -2) . ' )';
		}

		if ($is_official != '') $is_official = " AND `mb`.is_official = '$is_official' ";
		if ($member_group_id != '') $member_group_id = " AND `mb`.member_group_id = '$member_group_id' ";
		if ($member_department_id != '') $member_department_id = " AND `mb`.member_department_id = '$member_department_id' ";

		if ($code != '' || $mobile != '') $referral_by = "AND ( `referral_by` = '$code' OR `referral_by` = '$mobile' ) AND `referral_by` <> '' ";

		if ($joined_from != '') $joined_from = " AND mb.`joined_at` > $joined_from ";
		if ($month != '') $month = " AND mb.`month` = '$month' ";
		if ($city != '') $city = " AND mb.`city` = '$city' ";
		if ($license_to != '' && $license_to > 0)
			$license_to = " AND mb.`license_to` > 0 ";
		else
			$license_to = '';

		if ($keyword != '') $keyword = " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`email` LIKE '%$keyword%'  OR mb.`unique_mobile` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";

		$sql = "SELECT SUM(`total_spent`) total_spent, SUM(`point`) total_point, SUM(`wallet_main`) total_balance , SUM(`wallet_cashback`) total_wallet_cashback 
					, SUM(`total_dept_value`) total_dept_value
					, SUM(`total_dept_paid`) total_dept_paid
					, SUM(`total_dept_left`) total_dept_left
					, SUM(`total_liabilities`) total_liabilities
				FROM (
					SELECT mb.`total_spent`, mb.`point`, mb.`wallet_main`, mb.`wallet_cashback`
							, IFNULL(nTB.`total_dept_value`, 0) total_dept_value
							, IFNULL(nTB.`total_dept_paid`, 0) total_dept_paid
							, IFNULL(nTB.`total_dept_left`, 0) total_dept_left
							, IFNULL(nTB.`total_liabilities`, 0) total_liabilities
					FROM `members` mb
					LEFT JOIN (
						SELECT `customer_id`, SUM(`total`) `total_dept_value`, SUM(`total_paid`) `total_dept_paid`, SUM(`total_left`) `total_dept_left`, SUM(`total_left`) `total_liabilities`
						FROM `liabilities` lia
						WHERE `type` = 'KH'
						GROUP BY lia.`customer_id`
					) nTB 
					ON nTB.`customer_id` = mb.`user_id`
					WHERE `user_id` > 5 $joined_from $month $is_official $city $keyword $referral_by $member_group_id $member_department_id $sqlShop $license_to
				) nS";
		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function filter_members_count($keyword, $joined_from, $month, $city)
	{
		global $db;

		$shop_id 				= $this->get('shop_id');
		$is_official 			= $this->get('is_official');
		$member_group_id 		= $this->get('member_group_id');
		$member_department_id 	= $this->get('member_department_id');
		$code 					= $this->get('code');
		$mobile 				= $this->get('mobile');
		$license_to 			= $this->get('license_to');
		$referral_by			= '';

		$sqlShop =  '';
		if ($shop_id != '') {
			$ls = explode(';', $shop_id);
			foreach ($ls as $ite) {
				if ($ite != '')
					$sqlShop .= " mb.shop_id = '$ite' OR";
			}
			if ($sqlShop != '')
				$sqlShop = 'AND (' . substr($sqlShop, 0, -2) . ' )';
		}

		if ($is_official != '') $is_official = " AND `mb`.is_official = '$is_official' ";
		if ($member_group_id != '') $member_group_id = " AND `mb`.member_group_id = '$member_group_id' ";
		if ($member_department_id != '') $member_department_id = " AND `mb`.member_department_id = '$member_department_id' ";
		if ($code != '' || $mobile != '') $referral_by = "AND ( `referral_by` = '$code' OR `referral_by` = '$mobile' ) AND `referral_by` <> '' ";

		if ($joined_from != '') $joined_from = " AND `joined_at` > $joined_from ";
		if ($month != '') $month = " AND `month` = '$month' ";
		if ($city != '') $city = " AND `city` = '$city' ";
		if ($license_to != '' && $license_to > 0)
			$license_to = " AND mb.`license_to` > 0 ";
		else
			$license_to = '';
		if ($keyword != '') $keyword = " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`email` LIKE '%$keyword%' OR mb.`unique_mobile` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";

		$sql = "SELECT COUNT(user_id) as total FROM `members` mb WHERE `user_id` > 5 $joined_from $month $is_official $city $keyword $referral_by $member_group_id $member_department_id $sqlShop $license_to";
		$result = $db->executeQuery($sql, 1);

		return ($result['total'] + 0);
	}

	//Thống kế con: mỗi nhóm khách hàng có bao nhiêu thành viên con
	public function filter_members_statistic_child($keyword, $joined_from, $month, $city)
	{
		global $db;

		$shop_id 				= $this->get('shop_id');
		$is_official 			= $this->get('is_official');
		$member_group_id 		= $this->get('member_group_id');
		$member_department_id 	= $this->get('member_department_id');
		$code 					= $this->get('code');
		$mobile 				= $this->get('mobile');
		$license_to 			= $this->get('license_to');
		$referral_by			= '';

		$sqlShop =  '';
		if ($shop_id != '') {
			$ls = explode(';', $shop_id);
			foreach ($ls as $ite) {
				if ($ite != '')
					$sqlShop .= " mb.shop_id = '$ite' OR";
			}
			if ($sqlShop != '')
				$sqlShop = 'AND (' . substr($sqlShop, 0, -2) . ' )';
		}

		if ($is_official != '') $is_official = " AND `mb`.is_official = '$is_official' ";
		if ($member_group_id != '') $member_group_id = " AND `mb`.member_group_id = '$member_group_id' ";
		if ($member_department_id != '') $member_department_id = " AND `mb`.member_department_id = '$member_department_id' ";
		if ($code != '' || $mobile != '') $referral_by = "AND ( `referral_by` = '$code' OR `referral_by` = '$mobile' ) AND `referral_by` <> '' ";

		if ($joined_from != '') $joined_from = " AND `joined_at` > $joined_from ";
		if ($month != '') $month = " AND `month` = '$month' ";
		if ($city != '') $city = " AND `city` = '$city' ";
		if ($license_to != '' && $license_to > 0)
			$license_to = " AND mb.`license_to` > 0 ";
		else
			$license_to = '';
		if ($keyword != '') $keyword = " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`email` LIKE '%$keyword%' OR mb.`unique_mobile` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";

		$sql = "SELECT mb.`member_group_id`, COUNT(`member_group_id`) as total_count, IFNULL(mg.`name`, 'Không xác định') member_group_name
				FROM $db->tbl_fix`members` mb
				LEFT JOIN $db->tbl_fix`member_group` mg ON mg.`id` = mb.`member_group_id`
				WHERE `user_id` > 5 $joined_from $month $is_official $city $keyword $referral_by $member_group_id $member_department_id $sqlShop $license_to
				GROUP BY `mb`.member_group_id";
		$r = $db->executeQuery_list($sql);

		return $r;
	}

	//Huan: Created 20201117 for npp YOBE
	public function filter_by_npp(
		$keyword,
		$from, //đăng ký từ thời gian nào tới thời gian nào
		$to, //đăng ký từ thời gian nào tới thời gian nào
		$is_daily/* = 1 loại đại lý; = 0 loại khách hàng; = '' all 2 loại kia */,
		$activated, /*// = 0 load all, = 1 đã kích hoạt = total_spent > 0 or = '' list all */
		$offset = 0,
		$limit = ''
	) {
		global $db, $setup;

		$member_group_id_khachhang 	= $setup['member_group_id_khachhang'];
		$npp_referral				= $this->get('npp_referral');

		$lMBG = explode(';', $member_group_id_khachhang);
		$sqlMBG = '';
		foreach ($lMBG as $ssi) {
			if ($ssi != '')
				$sqlMBG .= " mb.`member_group_id` = '$ssi' OR";
		}
		if ($sqlMBG != '')
			$sqlMBG = 'AND (' . substr($sqlMBG, 0, -2) . ' )';

		//Tìm
		if ($keyword != '') 	$keyword 	= " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`email` LIKE '%$keyword%'  OR mb.`unique_mobile` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";

		$sqlFromTo = '';
		if ($from != '' && $from > 0) {
			$sqlFromTo = " AND '$from' < `mb`.`joined_at` AND `mb`.`joined_at` < '$to' ";
		}

		//Filter loại
		if ($is_daily != '') {
			if ($is_daily == 1) {
				$is_daily 	= " AND mb.`activated` > 0 ";
			} elseif ($is_daily == 2) {
				$is_daily 	= " AND mb.`is_sale_daily` = 1 ";
			} else {
				$is_daily 	= " AND mb.`activated` = 0 ";
			}
		}

		//Tài khoản kích hoạt chưa
		if ($activated != '') {
			if ($activated == '1')
				$activated 	= " AND mb.`total_spent` > 0 ";
			else
				$activated 	= " AND mb.`total_spent` = 0 ";
		}

		if ($limit != '') $limit = "LIMIT $offset, $limit";

		$sql = "SELECT * FROM(
					SELECT mb.`user_id`, mb.`mobile`, mb.`fullname`, mb.`email`, mb.`total_spent`, mb.`code`, IF( mb.`is_sale_daily` > 0, 'Sale đại lý', IF( mb.`license_to` > 0, 'Đại lý', mg.`name`)) member_group_name, mb.`joined_at`
					, mb.`is_sale_daily`
					FROM `members` mb
					LEFT JOIN `member_group` mg ON `mb`.`member_group_id` = `mg`.`id`
					WHERE `user_id` > 5  
					$sqlMBG
					AND mb.`npp_referral` 		= '$npp_referral'
					$keyword $sqlFromTo $activated $is_daily
				) nTB
				$limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	//Huan: Created 20201117 for npp YOBE
	public function filter_by_npp_count(
		$keyword,
		$from, //đăng ký từ thời gian nào tới thời gian nào
		$to, //đăng ký từ thời gian nào tới thời gian nào
		$is_daily/* = 1 loại đại lý; = 0 loại khách hàng; = '' all 2 loại kia */,
		$activated /*// = 0 load all, = 1 đã kích hoạt = total_spent > 0 or = '' list all */
	) {
		global $db, $setup;

		$member_group_id_khachhang 	= $setup['member_group_id_khachhang'];
		$npp_referral				= $this->get('npp_referral');

		$lMBG = explode(';', $member_group_id_khachhang);
		$sqlMBG = '';
		foreach ($lMBG as $ssi) {
			if ($ssi != '')
				$sqlMBG .= " mb.`member_group_id` = '$ssi' OR";
		}
		if ($sqlMBG != '')
			$sqlMBG = 'AND (' . substr($sqlMBG, 0, -2) . ' )';


		//Tìm
		if ($keyword != '') 	$keyword 	= " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`email` LIKE '%$keyword%'  OR mb.`unique_mobile` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";

		$sqlFromTo = '';
		if ($from != '' && $from > 0) {
			$sqlFromTo = " AND '$from' < `mb`.`joined_at` AND `mb`.`joined_at` < '$to' ";
		}

		//Filter loại
		if ($is_daily != '') {
			if ($is_daily == 1) {
				$is_daily 	= " AND mb.`activated` > 0 ";
			} elseif ($is_daily == 2) {
				$is_daily 	= " AND mb.`is_sale_daily` = 1 ";
			} else {
				$is_daily 	= " AND mb.`activated` = 0 ";
			}
		}

		//Tài khoản kích hoạt chưa
		if ($activated != '') {
			if ($activated == '1')
				$activated 	= " AND mb.`total_spent` > 0 ";
			else
				$activated 	= " AND mb.`total_spent` = 0 ";
		}

		$sql = "SELECT COUNT(*) total
				FROM `members` mb
				WHERE `user_id` > 5 
				$sqlMBG
				AND mb.`npp_referral` 		= '$npp_referral'
				$keyword $sqlFromTo $activated $is_daily";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	public function list_members_new()
	{
		global $db;

		$total_spent_from 	= $this->get('total_spent');
		$is_official 		= $this->get('is_official');
		$joined_at 			= $this->get('joined_at');

		$sql = "SELECT mb.*
				FROM $db->tbl_fix`members` mb
				WHERE `user_id` > 5
				AND `total_spent` >= '$total_spent_from'
				AND `joined_at` < '$joined_at'
				AND `is_official` = '$is_official'
				";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function check_login()
	{
		global $db, $database;

		$username = $this->get('email');

		if ($username != '') {

			$rows = array();
			$username = str_replace(' ', '', $username);
			$username = str_replace('#', '', $username);
			$username = str_replace('/', '', $username);
			$username = str_replace('\\', '', $username);
			$username = str_replace('\'', '', $username);

			$sql = "SELECT mb.*, IFNULL(mg.`name`, 'Mặc định') member_group_name
					FROM " . $db->tbl_fix . "`members` mb
					LEFT JOIN " . $db->tbl_fix . "`member_group` mg ON mg.id = mb.member_group_id
					WHERE ( (`unique_mobile` = '$username' AND `unique_mobile` <> '' ) OR (`email` = '$username' AND `email` <> '' ) )  AND `password` = '" . $this->get('password') . "' LIMIT 1";

			$rows = $db->executeQuery($sql, 1);
			if (isset($rows['user_id'])) {
				return $rows;
			} else {
				$sql = "SELECT mb.*, IFNULL(mg.`name`, 'Mặc định') member_group_name
						FROM " . $db->tbl_fix . "`members` mb
						LEFT JOIN " . $db->tbl_fix . "`member_group` mg ON mg.id = mb.member_group_id
						WHERE `user_id` = '$username'  AND `password` = '" . $this->get('password') . "' LIMIT 1";
				$rows = $db->executeQuery($sql, 1);

				return $rows;
			}
		} else {

			$user_id = $this->get('user_id');
			$rows = array();
			$sql = "SELECT mb.*, IFNULL(mg.`name`, 'Mặc định') member_group_name
					FROM " . $db->tbl_fix . "`members` mb
					LEFT JOIN " . $db->tbl_fix . "`member_group` mg ON mg.id = mb.member_group_id
					WHERE `user_id` = '$user_id'  AND `password` = '" . $this->get('password') . "' LIMIT 1";
			$rows = $db->executeQuery($sql, 1);
			
			return $rows;
		}
	}

	public function get_salt()
	{
		global $db;

		$username = $this->get('email');

		// $sql = "SELECT `salt` FROM " . $db->tbl_fix . "`members` WHERE `user_id` = '$username' ";
		// $rows = $db->executeQuery($sql, 1);

		// if (isset($rows['salt'])) {
		// 	return $rows['salt'];
		// } else {
		$sql = "SELECT `salt` FROM " . $db->tbl_fix . "`members` WHERE ( (`mobile` = '$username' AND `mobile` <> '' ) OR (`email` = '$username' AND `email` <> '' ) )  LIMIT 1 ";
		$rows = $db->executeQuery($sql, 1);

		if (isset($rows['salt']))
			return $rows['salt'];
		else
			return '';
		// }
	}

	public function get_detail()
	{
		global $db;
		$user_id = $this->get('user_id');
		// $sql = "SELECT * FROM `members` WHERE `user_id` = '$user_id' LIMIT 1 ";
        //vancode sql 
		$sql = "SELECT `members`.*, gmid.`name` as gmid_name
		FROM " . $db->tbl_fix . "`members`
		LEFT JOIN `gmid` ON gmid.id = members.gmid
		WHERE `members`. `user_id` = '$user_id' 
		LIMIT 1 ";
		
		$dThis = $db->executeQuery($sql, 1);

		return $dThis;
	}

	public function auto_suggest_members($no_limit)
	{
		global $db;

		$member_group_id = $this->get('member_group_id');

		$sqlMBG = "";
		if ($member_group_id !== '')
			$sqlMBG = " AND `member_group_id` = '$member_group_id' ";

		$sql = "SELECT * 
				FROM $db->tbl_fix`members`
				WHERE 1 $sqlMBG
				ORDER BY `joined_at` DESC
				LIMIT $no_limit ";

		$result = $db->executeQuery_list($sql, 1);

		return $result;
	}

	public function is_exist_mobile_or_email($info)
	{
		global $db;

		$user_id = $this->get('user_id');
		$sql = "SELECT `user_id` FROM `members` WHERE `mobile` = '$info' OR `email` = '$info' LIMIT 1 ";
		$result = $db->executeQuery($sql, 1);

		return isset($result['user_id']);
	}

	public function get_by_email()
	{
		global $db, $main;

		($this->get('user_id') != '') ? $except_id = " AND `user_id` <> '" . $this->get('user_id') . "'" : $except_id = "";

		$email = $this->get('email');

		$email = str_replace(' ', '_', $email);
		$email = str_replace('#', '_', $email);
		$email = str_replace('/', '_', $email);
		$email = str_replace('\\', '_', $email);

		$rows = array();
		if (($email != '' && preg_match('/^[ \w]+$/',  $email) || $main->isEmail($email))) {

			$sql = "SELECT `user_id`, `fullname` ,`password`, `salt`, `activate`  FROM " . $db->tbl_fix . $this->class_name . " WHERE 
					(`email`='$email' AND `email` <> '' ) $except_id LIMIT 1";

			$rows = $db->executeQuery($sql, 1);
		}

		return $rows;
	}

	public function get_by_mobile()
	{
		global $db, $main;

		($this->get('user_id') != '') ? $except_id = " AND `user_id` <> '" . $this->get('user_id') . "'" : $except_id = "";

		$mobile = $this->get('mobile');

		$mobile = str_replace(' ', '_', $mobile);
		$mobile = str_replace('#', '_', $mobile);
		$mobile = str_replace('/', '_', $mobile);
		$mobile = str_replace('\\', '_', $mobile);

		$rows = array();

		$sql = "SELECT *  FROM " . $db->tbl_fix . $this->class_name . " WHERE 
                (`mobile`='$mobile' AND `mobile` <> '' )  $except_id LIMIT 1";
		$rows = $db->executeQuery($sql, 1);

		return $rows;
	}

	public function get_by_email_or_mobile()
	{
		global $db, $main;

		($this->get('user_id') != '') ? $except_id = " AND `user_id` <> '" . $this->get('user_id') . "'" : $except_id = "";

		$email = $this->get('email');
		$mobile = $this->get('mobile');

		$email = str_replace(' ', '_', $email);
		$email = str_replace('#', '_', $email);
		$email = str_replace('/', '_', $email);
		$email = str_replace('\\', '_', $email);

		$mobile = str_replace(' ', '_', $mobile);
		$mobile = str_replace('#', '_', $mobile);
		$mobile = str_replace('/', '_', $mobile);
		$mobile = str_replace('\\', '_', $mobile);

		$rows = array();
		if (($email != '' && preg_match('/^[ \w]+$/',  $email) || $main->isEmail($email))) {

			$sql = "SELECT `user_id`, `email`, `mobile`, `fullname` ,`password`, `salt`, `activate`  FROM " . $db->tbl_fix . $this->class_name . " WHERE 
					((`email`='$email' AND `email` <> '' ) OR (`mobile`='$mobile' AND `mobile` <> '' )) $except_id LIMIT 1";

			$rows = $db->executeQuery($sql, 1);
		}

		return $rows;
	}

	public function get_detail_parent() //get detail parent or get detail by code or mobile or email
	{
		global $db;

		$referral_by = $this->get('referral_by');

		$result = array();
		if ($referral_by != '' && $referral_by != '0') {
			$sql = "SELECT * FROM " . $db->tbl_fix . "`members` WHERE `code` = '$referral_by' OR `mobile` = '$referral_by' OR `email` = '$referral_by' LIMIT 1 ";
			$result = $db->executeQuery($sql, 1);
		}

		return $result;
	}

	public function get_id_ncc()
	{
		global $db;

		$referral_by = $this->get('referral_by');
		$this->set('referral_by', $referral_by);
		$dParent1 = $this->get_detail_parent();

		// $ncc_id = 0;
		// // if( isset($dParent1['user_id']) && $dParent1['referral_by'] != '' ){
		// if( isset($dParent1['user_id']) ){
		// 	$this->set( 'referral_by', $dParent1['referral_by'] );
		// 	$dParent2 = $this->get_detail_parent();
		// 	if( isset($dParent2['user_id']) ){
		// 		$ncc_id = $dParent2['user_id'];
		// 	}
		// }

		// return $ncc_id;

		return $dParent1['user_id'];
	}

	public function get_id_parent_at()
	{
		global $db;

		$member_group_id = $this->get('member_group_id');
		$referral_by = $this->get('referral_by');

		$this->set('referral_by', $referral_by);
		$dParent = $this->get_detail_parent();

		if (!isset($dParent['member_group_id'])) {
			return false;
		} else if (isset($dParent['member_group_id']) &&  $dParent['member_group_id'] == $member_group_id) {
			return $dParent['user_id'];
		} else {
			$this->set('referral_by', $dParent['referral_by']);
			$this->set('member_group_id', $member_group_id);
			return $this->get_id_parent_at();
		}
	}

	public function get_detail_by_code()
	{
		global $db;
		$code = $this->get('code');
		$sql = "SELECT * FROM " . $db->tbl_fix . "`members` WHERE `code` = '$code' LIMIT 1 ";
		$result = $db->executeQuery($sql, 1);
		return $result;
	}

	public function get_detail_has_group()
	{
		global $db;
		$user_id = $this->get('user_id');
		$sql = "SELECT mb.*, mg.`code` member_group_code, mg.`name` member_group_name FROM `members` mb
				LEFT JOIN `member_group` mg ON mg.`id` = mb.`member_group_id`
				WHERE mb.`user_id` = '$user_id' LIMIT 1 ";
		$result = $db->executeQuery($sql, 1);
		return $result;
	}

	public function update_session_token()
	{
		global $db;

		$user_id 				= $this->get('user_id');
		$arr['session_token'] 	= $this->get('session_token');
		$arr['last_logged'] 	= time();

		$db->record_update('members', $arr, " `user_id` = '$user_id' ");

		return $arr['session_token'];
	}

	public function update_license()
	{
		global $db;

		$user_id 				= $this->get('user_id');

		$arr['license_to'] 		= $this->get('license_to');

		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' ");

		return true;
	}

	public function update_de_activated()
	{
		global $db;

		$user_id 				= $this->get('user_id');

		$arr['activated'] 		= 0;

		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' AND `activated_at` > 0 ");

		return true;
	}

	public function update_activate()
	{
		global $db;

		$user_id 				= $this->get('user_id');

		$arr['activate'] 		= 1;

		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' ");

		return true;
	}

	public function update_de_activate()
	{
		global $db;

		$user_id 				= $this->get('user_id');

		$arr['activate'] 		= 0;

		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' ");

		return true;
	}

	public function update_activated()
	{
		global $db;

		$user_id 				= $this->get('user_id');

		$arr['activated'] 		= 1;
		$arr['activated_at'] 	= time();

		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' AND `activated_at` = 0 ");

		return true;
	}

	public function update_verified_mobile()
	{
		global $db;

		$user_id 				= $this->get('user_id');

		$arr['member_level_id']	= 4;
		$arr['activate'] 		= 1;
		$arr['joined_at'] 		= time();

		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' AND `activate` = 0 ");

		return true;
	}

	public function update_list_free_product()
	{
		global $db;

		$user_id 							= $this->get('user_id');
		$arr['list_pro_allow_free'] 		= $this->get('list_pro_allow_free');

		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' ");

		return true;
	}

	public function get_by_session_token()
	{
		global $db;

		$session_token = $this->get('session_token');
		$sql = "SELECT * FROM `members` WHERE `session_token` = '$session_token' LIMIT 1 ";
		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function update_spent_and_point()
	{
		global $db;

		$total_spent 		= @$this->get('total_spent') + 0;
		$point 				= @$this->get('point') + 0;
		$user_id 			= $this->get('user_id');
		$sql = "UPDATE `members` SET `total_spent` = (`total_spent` + $total_spent), `point` = (`point` + $point), `last_transaction` = '" . time() . "'  WHERE `user_id` = '$user_id' LIMIT 1";
		$db->executeQuery($sql);

		return true;
	}

	public function update_referral_by()
	{
		global $db;

		$user_id 			= $this->get('user_id');
		$arr['referral_by']	= $this->get('referral_by');
		$db->record_update($db->tbl_fix . $this->class_name, $arr, " `user_id` = '$user_id' ");

		return true;
	}

	public function update_new_branch()
	{
		global $db;

		$user_id 				= $this->get('user_id');
		$arr['referral_by']		= $this->get('referral_by');
		$arr['member_group_id']	= $this->get('member_group_id');
		$db->record_update($db->tbl_fix . $this->class_name, $arr, " `user_id` = '$user_id' ");

		return true;
	}

	public function re_update_joined_at()
	{
		global $db;

		$user_id 			= $this->get('user_id');
		$arr['joined_at']	= time();
		$db->record_update($db->tbl_fix . $this->class_name, $arr, " `user_id` = '$user_id' ");

		return true;
	}

	public function re_update_inactivate_by_parent()
	{
		global $db;

		$user_id 					= $this->get('user_id');

		$arr['direct_referral']		= $this->get('direct_referral');
		$arr['npp_referral']		= $this->get('npp_referral');
		$arr['referral_by']			= $this->get('referral_by');
		$arr['joined_at']			= time();

		$db->record_update($db->tbl_fix . $this->class_name, $arr, " `user_id` = '$user_id' ");

		return true;
	}

	public function update_total_discount_and_revenue()
	{
		global $db;

		$total_revenue 		= @$this->get('total_revenue') + 0;
		$total_discount 	= @$this->get('total_discount') + 0;
		$user_id 			= $this->get('user_id');

		$sql = "UPDATE `members` SET `total_revenue` = (`total_revenue` + $total_revenue), `total_discount` = (`total_discount` + $total_discount), `last_transaction` = '" . time() . "'  WHERE `user_id` = '$user_id' LIMIT 1";

		$db->executeQuery($sql);

		return true;
	}

	public function tang_wallet_main()
	{
		global $db;

		$user_id 			= $this->get('user_id');
		$wallet_main 	= $this->get('wallet_main');
		$sql = "UPDATE `members` SET `wallet_main` = (`wallet_main` + '$wallet_main') WHERE `user_id` = '$user_id' LIMIT 1";
		$result = $db->executeQuery($sql);

		return true;
	}

	public function giam_wallet_main()
	{
		global $db;

		$user_id 			= $this->get('user_id');
		$wallet_main 	= $this->get('wallet_main');
		$sql = "UPDATE $db->tbl_fix`members` SET `wallet_main` = (`wallet_main` - '$wallet_main') WHERE `user_id` = '$user_id' LIMIT 1";
		$result = $db->executeQuery($sql);

		return true;
	}

	public function tang_wallet_cashback()
	{
		global $db;

		$user_id 			= $this->get('user_id');
		$wallet_cashback 	= $this->get('wallet_cashback');
		$sql = "UPDATE $db->tbl_fix`members` SET `wallet_cashback` = (`wallet_cashback` + '$wallet_cashback') WHERE `user_id` = '$user_id' LIMIT 1";
		$result = $db->executeQuery($sql);

		return true;
	}

	public function giam_wallet_cashback()
	{
		global $db;

		$user_id 			= $this->get('user_id');
		$wallet_cashback 	= $this->get('wallet_cashback');
		$sql = "UPDATE $db->tbl_fix`members` SET `wallet_cashback` = (`wallet_cashback` - '$wallet_cashback') WHERE `user_id` = '$user_id' LIMIT 1";
		$result = $db->executeQuery($sql);

		return true;
	}

	public function tang_wallet_register()
	{
		global $db;

		$user_id 			= $this->get('user_id');
		$wallet_register 	= $this->get('wallet_register');
		$sql = "UPDATE $db->tbl_fix`members` SET `wallet_register` = (`wallet_register` + '$wallet_register') WHERE `user_id` = '$user_id' LIMIT 1";
		$result = $db->executeQuery($sql);

		return true;
	}

	public function giam_wallet_register()
	{
		global $db;

		$user_id 			= $this->get('user_id');
		$wallet_register 	= $this->get('wallet_register');
		$sql = "UPDATE $db->tbl_fix`members` SET `wallet_register` = (`wallet_register` - '$wallet_register') WHERE `user_id` = '$user_id' LIMIT 1";
		$result = $db->executeQuery($sql);

		return true;
	}

	// public function tang_balance(){
	// 	global $db;

	// 	$user_id 			= $this->get( 'user_id' );
	// 	$balance_cong_tang_giam 	= $this->get( 'balance' );
	// 	$sql = "UPDATE `members` SET `balance` = (`balance` + $balance_cong_tang_giam) WHERE `user_id` = '$user_id' LIMIT 1";
	// 	$result = $db->executeQuery( $sql );

	// 	return true;
	// }

	// public function giam_balance(){
	// 	global $db;

	// 	$user_id 			= $this->get( 'user_id' );
	// 	$balance_cong_tang_giam 	= $this->get( 'balance' );
	// 	$sql = "UPDATE `members` SET `balance` = (`balance` - $balance_cong_tang_giam) WHERE `user_id` = '$user_id' LIMIT 1";
	// 	$result = $db->executeQuery( $sql );

	// 	return true;
	// }

	// public function tang_balance_promotion(){
	// 	global $db;

	// 	$user_id 			= $this->get( 'user_id' );
	// 	$balance_cong_tang_giam 	= $this->get( 'balance_promotion' );
	// 	$sql = "UPDATE `members` SET `balance_promotion` = (`balance_promotion` + $balance_cong_tang_giam) WHERE `user_id` = '$user_id' LIMIT 1";
	// 	$result = $db->executeQuery( $sql );

	// 	return true;
	// }

	// public function giam_balance_promotion(){
	// 	global $db;

	// 	$user_id 			= $this->get( 'user_id' );
	// 	$balance_cong_tang_giam 	= $this->get( 'balance_promotion' );
	// 	$sql = "UPDATE `members` SET `balance_promotion` = (`balance_promotion` - $balance_cong_tang_giam) WHERE `user_id` = '$user_id' LIMIT 1";
	// 	$result = $db->executeQuery( $sql );

	// 	return true;
	// }

	public function update_used_point()
	{
		global $db;

		$point = @$this->get('point') + 0;
		$user_id = $this->get('user_id');
		$sql = "UPDATE $db->tbl_fix`members` SET  `point` = (`point` - $point)  WHERE `user_id` = '$user_id' LIMIT 1 ";
		$result = $db->executeQuery($sql);

		return true;
	}

	public function update_member_group()
	{
		global $db;

		$user_id = $this->get('user_id');
		$arr['member_group_id'] = $this->get('member_group_id');
		$db->record_delete($db->tbl_fix . '`members`', " `user_id` = '$user_id' ");

		return true;
	}

	public function delete()
	{
		global $db;

		$user_id = $this->get('user_id');
		$db->record_delete('members', " `user_id` = " . $user_id);

		return true;
	}

	public function getby_email()
	{
		global $db;

		$email = $this->get('email');
		$sql = "SELECT * FROM `members` WHERE `email` = '$email' LIMIT 1 ";
		$result = $db->executeQuery($sql, 1);

		return $result;
	}

	public function getby_mobile()
	{
		global $db;

		$mobile = $this->get('mobile');
		$sql = "SELECT * FROM `members` WHERE `unique_mobile` = '$mobile' LIMIT 1 ";
		$result = $db->executeQuery($sql, 1);

		return $result;
	}


	//Limit user system
	public function listby_key($keyword, $excepted = '')
	{
		global $db;
		$main = new main();
		$email = '';
		$mobile = '';

		$referral_by 		= $this->get('referral_by');
		$shop_id 			= $this->get('shop_id');

		$sqlShop =  '';
		if ($shop_id != '') {
			$ls = explode(';', $shop_id);
			foreach ($ls as $ite) {
				if ($ite != '')
					$sqlShop .= " shop_id = '$ite' OR";
			}
			if ($sqlShop != '')
				$sqlShop = 'AND (' . substr($sqlShop, 0, -2) . ' )';
		}

		$mobile = $main->only_number($keyword);
		if ($mobile == $keyword) {
			if ($mobile != '') $mobile = "OR `mobile` LIKE '%$mobile%' ";
		} else {
			$mobile = '';
			$email = $main->clean($keyword);
			$email = "OR `email` LIKE '%$email%' ";
		}

		if ($excepted != '') $excepted = " AND `code` <> '$excepted' AND `referral_by` = '$excepted' ";
		if ($referral_by != '') $referral_by = " AND `referral_by` = '$referral_by' ";

		$sql = "SELECT `user_id`,`email`,`mobile`,`address`, `avatar`, `fullname`
				FROM `members`
				WHERE 
				`user_id` > 5 
				AND ( `fullname` LIKE '%$keyword%' OR `code`
				LIKE '%$keyword%' $mobile $email ) $excepted $sqlShop $referral_by
				ORDER BY `mobile` ASC, `email` ASC LIMIT 12";

		$result = $db->executeQuery($sql);
		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$row['added'] = 1;
			$kq[] = $row;
		}
		return $kq;
	}

	//ALL user include system
	public function listby_key_all($keyword, $excepted = '')
	{
		global $db;
		$main = new main();
		$email = '';
		$mobile = '';

		$referral_by 		= $this->get('referral_by');
		$shop_id 			= $this->get('shop_id');

		$sqlShop =  '';
		if ($shop_id != '') {
			$ls = explode(';', $shop_id);
			foreach ($ls as $ite) {
				if ($ite != '')
					$sqlShop .= " shop_id = '$ite' OR";
			}
			if ($sqlShop != '')
				$sqlShop = 'AND (' . substr($sqlShop, 0, -2) . ' )';
		}

		$mobile = $main->only_number($keyword);
		if ($mobile == $keyword) {
			if ($mobile != '') $mobile = "OR `mobile` LIKE '%$mobile%' ";
		} else {
			$mobile = '';
			$email = $main->clean($keyword);
			$email = "OR `email` LIKE '%$email%' ";
		}

		if ($excepted != '') $excepted = " AND `code` <> '$excepted' AND `referral_by` = '$excepted' ";
		if ($referral_by != '') $referral_by = " AND `referral_by` = '$referral_by' ";

		$sql = "SELECT `user_id`,`email`,`mobile`,`address`, `avatar`, `fullname`
				FROM `members`
				WHERE ( `fullname` LIKE '%$keyword%' OR `code`
				LIKE '%$keyword%' $mobile $email ) $excepted $sqlShop $referral_by
				ORDER BY `mobile` ASC, `email` ASC LIMIT 12";

		$result = $db->executeQuery($sql);
		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$row['added'] = 1;
			$kq[] = $row;
		}
		return $kq;
	}

	public function listby_key_branch($keyword, $self_code = '', $self_client_id = '', $parent_code = '')
	{
		global $db;
		$main = new main();
		$email = '';
		$mobile = '';

		$mobile = $main->only_number($keyword);
		if ($mobile == $keyword) {
			if ($mobile != '') $mobile = "OR `mobile` LIKE '%$mobile%' ";
		} else {
			$mobile = '';
			$email = $main->clean($keyword);
			$email = "OR `email` LIKE '%$email%' ";
		}
		$excepted = '';
		if ($self_code != '') $excepted = " AND ( `referral_by` = '$self_code' OR `code` = '$parent_code' ) AND `user_id` <> '$self_client_id' ";

		$sql = "SELECT `user_id`,`email`,`mobile`,`address`, `avatar`, `fullname` FROM `members` WHERE `user_id` > 5 AND ( `fullname` LIKE '%$keyword%' OR `code` LIKE '%$keyword%' $mobile $email ) $excepted ORDER BY `mobile` ASC, `email` ASC LIMIT 12";


		$result = $db->executeQuery($sql);
		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$row['added'] = 1;
			$kq[] = $row;
		}
		return $kq;
	}

	public function listby_key_name($keyword)
	{
		global $db;
		$main = new main();

		$keyword = $main->clean($keyword);

		$sql = "SELECT `user_id`,`email`,`mobile`,`address` FROM `members` WHERE `user_id` > 5 AND `fullname` LIKE '%$keyword%' ORDER BY `fullnamee` ASC LIMIT 10";
		$result = $db->executeQuery($sql);
		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$row['added'] = 1;
			$kq[] = $row;
		}
		return $kq;
	}

	public function list_all_by($sort, $joined_from, $month, $city)
	{
		global $db;

		if ($joined_from != '') $joined_from = " AND `joined_at` > $joined_from ";
		if ($month != '') $month = " AND `month` = '$month' ";
		if ($city != '') $city = " AND `city` = '$city' ";

		//condition sort by
		$sorting = '';

		if (isset($sort['sortby_name']) && $sort['sortby_name'] != '')
			if ($sort['sortby_name'] == 'up') {
				$sorting = " `fullname` ASC ";
			} else {
				$sorting = " `fullname` DESC ";
			}

		if (isset($sort['sortby_point']) && $sort['sortby_point'] != '')
			if ($sort['sortby_point'] == 'up') {
				$sorting = " `point` ASC ";
			} else {
				$sorting = " `point` DESC ";
			}

		if (isset($sort['sortby_spent']) && $sort['sortby_spent'] != '')
			if ($sort['sortby_spent'] == 'up') {
				$sorting = " `total_spent` ASC ";
			} else {
				$sorting = " `total_spent` DESC ";
			}

		if (isset($sort['sortby_joined']) && $sort['sortby_joined'] != '')
			if ($sort['sortby_joined'] == 'down') {
				$sorting = " `joined_at` DESC ";
			} else {
				$sorting = " `joined_at` ASC ";
			}

		if (isset($sort['sortby_lastTransaction']) && $sort['sortby_lastTransaction'] != '')
			if ($sort['sortby_lastTransaction'] == 'down') {
				$sorting = " `last_transaction` DESC ";
			} else {
				$sorting = " `last_transaction` ASC ";
			}

		if ($sorting != '') {
			$sorting = "ORDER BY " . $sorting;
		} else {
			$sorting = " ORDER BY joined_at DESC";
		}

		$sql = "SELECT `user_id`,`fullname`,`joined_at`,`total_spent`,`point`,`city` FROM `members` WHERE `user_id` > 5 $joined_from $month $city $sorting ";

		$kq = array();
		$result = $db->executeQuery($sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$kq[] = $row;
		}

		unset($result);
		return $kq;
	}

	//COUNT NO new member of a user: 
	public function count_new_referral($from, $to)
	{
		global $db;

		$code 				= $this->get('code');
		$mobile 			= $this->get('mobile');

		$referral = " (mb.`referral_by` = '$code' OR mb.`referral_by` = '$mobile' ) ";

		$sql = "SELECT COUNT(*) total
				FROM $db->tbl_fix`members` mb
				WHERE $referral AND '$from' < `joined_at` AND `joined_at` < '$to' ";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	//lấy danh sách thành vien cùng hệ thống -> api partner/members
	public function list_referral_by($keyword = '', $offset = 0, $limit = '')
	{
		global $db;

		$code 				= $this->get('code');
		$mobile 			= $this->get('mobile');
		$direct_referral 	= $this->get('direct_referral');

		$referral = " (mb.`referral_by` = '$code' OR mb.`referral_by` = '$mobile' ) ";

		if ($keyword != '') $keyword = " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%' OR mb.`email` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";
		// if ($direct_referral != '' && $direct_referral > 0) $direct_referral = " AND mb.`direct_referral` <> '$direct_referral' "; //Trực tiếp bởi NPP hoặc đại lý

		if ($limit != '') $limit = "LIMIT $offset, $limit";

		$sql = "SELECT mb.*, IF( mb.`is_sale_daily` > 0, 'Sale đại lý', IF( mb.`license_to` > 0, 'Đại lý', mg.`name`)) member_group_name
				FROM $db->tbl_fix`members` mb
				LEFT JOIN " . $db->tbl_fix . "`member_group` mg ON mg.`id` = mb.`member_group_id`
				WHERE $referral $keyword
				$limit";

		$result = $db->executeQuery($sql);

		$kq		= array();
		while ($row = mysqli_fetch_assoc($result)) {
			unset($row['password']);
			unset($row['salt']);
			unset($row['session_token']);
			$kq[] = $row;
		}

		return $kq;
	}

	//lấy danh sách thành vien cùng hệ thống -> api partner/members => count number record
	public function list_referral_by_count($keyword = '')
	{
		global $db;

		$code = $this->get('code');
		$mobile = $this->get('mobile');
		$direct_referral = $this->get('direct_referral');

		$referral = " (`referral_by` = '$code' OR `referral_by` = '$mobile' )";

		if ($direct_referral != '' && $direct_referral > 0) $direct_referral = " AND `direct_referral` <> '$direct_referral' ";

		if ($keyword != '') $keyword = " AND ( `fullname` LIKE '%$keyword%' OR `mobile` LIKE '%$keyword%' OR `email` LIKE '%$keyword%' OR `code` LIKE '%$keyword%' ) ";

		$sql = "SELECT COUNT(*) total
				FROM $db->tbl_fix`members` mb
				WHERE $referral $keyword $direct_referral";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	//list active user by parent id
	public function list_referral_activated($offset = '', $limit = '')
	{
		global $db;

		$direct_referral 		= $this->get('direct_referral');

		if ($limit != '')
			$limit = " LIMIT $offset, $limit ";

		$sql = "SELECT *
				FROM $db->tbl_fix`members`
				WHERE 
				`direct_referral` = '$direct_referral'
				AND `activated` = 1 AND `license_to` > 0 
				$limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function list_referral_activated_count()
	{
		global $db;

		$direct_referral 		= $this->get('direct_referral');

		$sql = "SELECT COUNT(*) total
				FROM $db->tbl_fix`members`
				WHERE 
				`direct_referral` = '$direct_referral'
				AND `activated` = 1 AND `license_to` > 0 ";

		$result = $db->executeQuery($sql, 1);

		return $result['total'];
	}

	public function list_child($keyword, $from = '', $to = '', $type = '', $offset = '', $limit = '')
	{
		global $db;

		if ($type != '') {
			if ($type > 0) {
				$type = "AND mb.`total_spent` > 0";
			} else {
				$type = "AND mb.`total_spent` = 0";
			}
		} else {
			$type = "";
		}

		$sqlFromTo = '';
		if ($from != '' && $from > 0) {
			$sqlFromTo = " AND '$from' < `mb`.`joined_at` AND `mb`.`joined_at` < '$to' ";
		}

		$direct_referral 		= $this->get('direct_referral');

		if ($limit != '')
			$limit = " LIMIT $offset, $limit ";

		if ($keyword != '') {
			$keyword = " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%' ) ";
		}

		$sql = "SELECT mb.`user_id`, mb.`fullname`, mb.`mobile`, mb.`activated`, mb.`joined_at`, mb.`total_spent`
				FROM $db->tbl_fix`members` mb
				WHERE 
				mb.`direct_referral` = '$direct_referral' 
				$type
				$keyword
				$sqlFromTo
				$limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function list_child_count($keyword, $from = '', $to = '', $type = '')
	{
		global $db;

		$direct_referral 		= $this->get('direct_referral');

		$sqlFromTo = '';
		if ($from != '' && $from > 0) {
			$sqlFromTo = " AND '$from' < `mb`.`joined_at` AND `mb`.`joined_at` < '$to' ";
		}

		if ($type != '') {
			if ($type > 0) {
				$type = "AND mb.`total_spent` > 0";
			} else {
				$type = "AND mb.`total_spent` = 0";
			}
		} else {
			$type = "";
		}

		if ($keyword != '') {
			$keyword = " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%' ) ";
		}

		$sql = "SELECT COUNT(*) total
				FROM $db->tbl_fix`members` mb
				WHERE 
				mb.`direct_referral` = '$direct_referral'
				$type $keyword $sqlFromTo";

		$result = $db->executeQuery($sql, 1);

		return $result['total'];
	}

	//lấy danh sách thành vien cùng hệ thống -> api partner/members
	public function get_by_referral()
	{
		global $db;

		$referral = $this->get('referral_by');

		$result = '';
		if ($referral != '') {

			$referral_by = "`mobile` = '$referral' OR `code` = '$referral'";

			$sql = "SELECT * FROM $db->tbl_fix`members` WHERE $referral_by";
			$result = $db->executeQuery($sql, 1);
		}

		return $result;
	}

	public function get_option()
	{
		global $db;
		$sql = "select * from " . $db->tbl_fix . "members WHERE `user_id` > 5 ORDER BY last_transaction DESC LIMIT 1000";
		$rows = $db->executeQuery($sql);
		$kq = '';
		while ($row = mysqli_fetch_assoc($rows)) {
			$kq .= '<option value="' . $row['user_id'] . '">' . $row["fullname"] . '/ ' . $row['mobile'] . '</option>';
		}
		return $kq;
	}

	public function get_fullname()
	{
		global $db;

		$user_id = $this->get('user_id');

		$sql = "SELECT `fullname`
				FROM " . $db->tbl_fix . "`members`
				WHERE `user_id` = '$user_id'
				LIMIT 1";
		$rows = $db->executeQuery($sql, 1);

		return $rows['fullname'] . '';
	}

	public function opt_all()
	{
		global $db;

		$sql = "SELECT `user_id`, `fullname`, `mobile`
				FROM " . $db->tbl_fix . "`members`
				WHERE `user_id` > 5
				ORDER BY `fullname` DESC";
		$rows = $db->executeQuery($sql);

		$opt = '<option value="0">Khách vãng lai</option>';
		while ($row = mysqli_fetch_assoc($rows)) {
			$opt .= '<option value="' . $row['user_id'] . '">' . $row["fullname"] . ' ' . ($row['mobile'] != '' ? '(' . $row['mobile'] . ')' : '') . '</option>';
		}
		mysqli_free_result($rows);

		return $opt;
	}

	public function get_opt_city()
	{
		global $db;
		$sql = "SELECT `city` from " . $db->tbl_fix . "members
				WHERE `user_id` > 5 AND `city` <> 'HN' AND `city` <> 'HCM'
				ORDER BY `city` ASC";
		$rows = $db->executeQuery($sql);
		$kq = '';
		while ($row = mysqli_fetch_assoc($rows)) {
			$kq .= '<option value="' . $row['city'] . '">' . $row['city'] . '</option>';
		}

		return $kq;
	}

	private function randString($length = 10)
	{
		$characters = 'w01s2345arbctvdeffg1hijklm4nop6789qrstuv3wxyz5AB675839CDEFGHIJ627g184g9gKLMfNdOPsQRSTfUVWgXdYsZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	public function cal_up_level()
	{
		global $db, $member_group;

		$KPI_level = new KPI_level();

		$user_id = $this->get('user_id');
		$dMember = $this->get_detail();

		$member_group->set('id', $dMember['member_group_id']);
		$dMBG = $member_group->get_detail();

		if (isset($dMBG['id'])) {

			$KPI_level->set('id', $dMBG['kpi_level_id']);
			$dKPI = $KPI_level->get_detail();

			if (isset($dKPI['id']) && $dKPI['up_level'] != $dMember['member_group_id'] && $dKPI['up_level'] > 0) {
				//có KPI lên level nhưng hiện tại đã level này rồi thì ko tính nữa

				//tính toán doanh số cá nhân
				$total_spent = $dMember['total_spent'];
				if ($dKPI['total_spent_by'] === 0) {
					//discount
					$total_spent = $dMember['total_discount'];
				} else if ($dKPI['total_spent_by'] === 2) {
					//doanh số giá lẻ
					$total_spent = $dMember['total_revenue'];
				}

				//Tính toán doanh số cấp dưới
				$total_child_spent = 0;
				if ($dKPI['total_child_spent_by'] === 0) {

					//discount
					$sql2 = "SELECT SUM(`total_discount`) total
						FROM $db->tbl_fix`members`
						WHERE `user_id` > 5 AND ( `referral_by` = '" . $dMember['code'] . "' OR `referral_by` =  '" . $dMember['mobile'] . "' OR `referral_by` =  '" . $dMember['email'] . "' )";
					$result = $db->executeQuery($sql2, 1);
					$total_child_spent = isset($result['total']) ? $result['total'] : 0;
				} else if ($dKPI['total_child_spent_by'] === 2) {

					//doanh số giá lẻ
					$sql2 = "SELECT SUM(`total_revenue`) total
						FROM $db->tbl_fix`members`
						WHERE `user_id` > 5 AND ( `referral_by` = '" . $dMember['code'] . "' OR `referral_by` =  '" . $dMember['mobile'] . "' OR `referral_by` =  '" . $dMember['email'] . "' )";
					$result = $db->executeQuery($sql2, 1);
					$total_child_spent = isset($result['total']) ? $result['total'] : 0;
				} else {
					//doanh số thực thu
					$sql2 = "SELECT SUM(`total_spent`) total
						FROM $db->tbl_fix`members`
						WHERE `user_id` > 5 AND ( `referral_by` = '" . $dMember['code'] . "' OR `referral_by` =  '" . $dMember['mobile'] . "' OR `referral_by` =  '" . $dMember['email'] . "' )";
					$result = $db->executeQuery($sql2, 1);
					$total_child_spent = isset($result['total']) ? $result['total'] : 0;
				}

				//Tính toán số lượng downline
				$sql3 = "SELECT COUNT(*) total
						FROM $db->tbl_fix`members`
						WHERE `user_id` > 5 AND ( `referral_by` = '" . $dMember['code'] . "' OR `referral_by` =  '" . $dMember['mobile'] . "' OR `referral_by` =  '" . $dMember['email'] . "' )";

				$result = $db->executeQuery($sql3, 1);
				$total_child = isset($result['total']) ? $result['total'] : 0;

				if (
					$total_spent >= $dKPI['total_spent'] &&
					$total_spent >= $dKPI['total_child_spent'] &&
					$total_spent >= $dKPI['total_child']
				) {
					//update new level
					$arr['member_group_id'] = $dKPI['up_level'];
					$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' ");

					return true;
				}
			}
		}


		return false;
	}

	public function filter_by_group($keyword)
	{
		global $db;

		$member_group_id = $this->get('member_group_id');
		if ($keyword != '') $keyword = " AND ( `fullname` LIKE '%$keyword%' OR `mobile` LIKE '%$keyword%') ";

		$investorGroupSql = '';
		if ($member_group_id != '') {
			$investorGroupSql = " AND ( `member_group_id` LIKE '$member_group_id%' OR `member_group_id` LIKE '%;$member_group_id;%' ) ";
		}

		$sql = "SELECT `user_id`, `fullname`, `mobile`
                FROM " . $db->tbl_fix . "`" . $this->class_name . "`
                WHERE 
				1
				$keyword
				$investorGroupSql
		        ORDER BY `fullname` ASC LIMIT 0,5";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function group_by_shop_mg_dep()
	{ //Get list allow by of this member: shop and member_group and department in child members
		global $db, $setup;

		$code 		= $this->get('code');
		$mobile 	= $this->get('mobile');

		// $sql = "SELECT tb.`shop_id` id, `itb`.`name`
		//         FROM " . $db->tbl_fix . "`" . $this->class_name . "` tb
		//         INNER JOIN " . $db->tbl_fix . "`shop` itb ON itb.`id` = tb.`shop_id`
		// 		WHERE 
		// 		( 
		// 			tb.`referral_by` = '$mobile'
		// 			OR
		// 			tb.`referral_by` = '$code' 
		// 		)
		// 		AND tb.`referral_by` <> ''
		// 		AND `itb`.`name` IS NOT NULL
		//         GROUP BY `shop_id`";

		$sqlShop = '';
		if ($setup['default_shop_list'] != '') {
			$lSh = explode(';', $setup['default_shop_list']);
			foreach ($lSh as $itde) {
				if ($itde != '')
					$sqlShop .= " tb.`id` = '$itde' OR ";
			}

			if ($sqlShop != '') {
				$sqlShop = "AND (" . substr($sqlShop, 0, -3) . " )";
			}
		}

		$sql = "SELECT tb.`id`, `tb`.`name`
                FROM " . $db->tbl_fix . "`shop` tb
				WHERE 1 $sqlShop
		        ORDER BY `name`";
		$kq['shop'] = $db->executeQuery_list($sql);

		$sql = "SELECT tb.`member_group_id` id, `itb`.`name`
                FROM " . $db->tbl_fix . "`" . $this->class_name . "` tb
                INNER JOIN " . $db->tbl_fix . "`member_group` itb ON itb.`id` = tb.`member_group_id`
				WHERE 
				( 
					tb.`referral_by` = '$mobile'
					OR
					tb.`referral_by` = '$code' 
				)
				AND tb.`referral_by` <> ''
				AND `itb`.`name` IS NOT NULL
		        GROUP BY `member_group_id`";
		$kq['member_group'] = $db->executeQuery_list($sql);

		$sql = "SELECT tb.`member_department_id` id, `itb`.`name`
                FROM " . $db->tbl_fix . "`" . $this->class_name . "` tb
                INNER JOIN " . $db->tbl_fix . "`member_department` itb ON itb.`id` = tb.`member_department_id`
				WHERE 
				( 
					tb.`referral_by` = '$mobile'
					OR
					tb.`referral_by` = '$code' 
				)
				AND tb.`referral_by` <> ''
				AND `itb`.`name` IS NOT NULL
		        GROUP BY `member_department_id`";
		$kq['department'] = $db->executeQuery_list($sql);

		return $kq;
	}


	public function managers_showroom_by_keyword($keyword, $except = '')
	{
		global $db;

		if ($keyword != '') $keyword = "AND ( `fullname` LIKE '%$keyword%' OR `mobile` LIKE '%$keyword%' OR `code` LIKE '%$keyword%' )";

		$sqlExcept = '';
		if ($except != '') {
			$lExcept = explode(';', $except);
			foreach ($lExcept as $id) {
				if ($id != '') {
					$sqlExcept .= " AND `user_id` <> '$id' ";
				}
			}
		}

		$sql = "SELECT * FROM `members` WHERE 1 $sqlExcept $keyword LIMIT 20";
		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function get_member_showroom()
	{ //list id district
		global $db_store, $db;

		$id = $this->get('user_id');

		$sqlWhere = '';
		if ($id != '') {
			$l = explode(';', $id);

			foreach ($l as $id) {
				if ($id != '') {
					$sqlWhere .= " `user_id` = '$id' OR ";
				}
			}
			$sqlWhere = "(" . substr($sqlWhere, 0, -3) . ")";
		} else {
			$sqlWhere = "`user_id` = '0'";
		}

		$sql = "SELECT mb.`user_id` id, mb.`fullname` name
                FROM $db->tbl_fix`members` mb
                WHERE $sqlWhere ";
		$kq = $db->executeQuery_list($sql);

		return $kq;
	}

	// public function add_partner()
	// {
	// 	global $db, $main, $setup;

	// 	$fullname 			= $this->get('username');
	// 	$mobile 			= $this->get('mobile');
	// 	$password 			= $this->get('password');
	// 	$member_group_id 	= $this->get('member_group_id');
	// 	$referral_by 		= $this->get('referral_by');

	// 	if ($password != '') {
	// 		$salt = $this->randString(10);
	// 		$pass = md5(md5($password) . $salt);
	// 	} else {
	// 		$pass = '';
	// 	}

	// 	$arr['fullname'] 			= $fullname;
	// 	$arr['referral_by'] 		= $referral_by;
	// 	$arr['mobile'] 				= $mobile;
	// 	$arr['password'] 			= $pass;
	// 	$arr['salt'] 				= $salt;
	// 	$arr['joined_at'] 			= time();
	// 	$arr['member_group_id'] 	= $member_group_id;
	// 	$arr['activate'] 			= 0;

	// 	$db->record_insert('members', $arr);
	// 	$user_id = $db->mysqli_insert_id();

	// 	unset($arr);
	// 	return $user_id;
	// }

	public function daily_valid($dThis)
	{
		global $setup;

		if (isset($dThis['license_to']) &&  $dThis['license_to'] > 0) {
			return 2; //đại lý fee còn đang action
		} else if (isset($dThis['activated_at']) && $dThis['activated_at'] > 0) {
			return 1; //đại lý free
		} else {
			return 0; //Chưa kích hoạt
		}
	}

	public function partner_type($dThis)
	{
		global $setup;
		//partner_type: 0 = showroom, 1: NPP, 2: partner; 3 = client

		if (isset($dThis['member_group_id']) && $dThis['member_group_id'] == 11) {
			return 1; //NPP
		} else if (isset($dThis['member_group_id']) && 6 < $dThis['member_group_id'] && $dThis['member_group_id'] < 11) {
			return 2; //Partner
		} else if (isset($dThis['member_group_id']) && 2 < $dThis['member_group_id'] && $dThis['member_group_id'] < 5) {
			return 0; //Partner
		} else {
			return 3; //Chưa kích hoạt
		}
	}

	// Admin update KH lên đại lý khi được xác nhận đã chuyển khoản cho cty
	public function update_daily_admin($type)
	{
		global $db;

		$mobile 				= $this->get('mobile');

		if ($type > 0) {
			$arr['license_to'] 			= time() + 365 * 86400;
		} else {
			$arr['license_to'] = 0;
		}

		$arr['activated_at'] 			= time();
		$arr['activated'] 				= 1;
		$arr['pending_is_sale_daily'] 	= 1;

		$db->record_update($db->tbl_fix . '`members`', $arr, " `unique_mobile` = '$mobile' ");

		return true;
	}

	public function find_member_tranfers($keyword, $client_id, $type, $offset, $limit)
	{ //tìm khách hàng để thực hiện chuyển tiền (tùng code- 25012021)
		//HC 210713 fix: bổ sung type
		global $db;

		if ($type == 'exactly') {
			$sqlWhere = "AND (`mobile` = '$keyword' )";
		} else {
			$sqlWhere = "AND (`mobile` LIKE '%$keyword%' OR `email` LIKE '%$keyword%' OR `code` LIKE '%$keyword%') ";
		}

		if ($limit != '') $limit = "LIMIT $offset, $limit";

		$sql = "SELECT * FROM $db->tbl_fix`members` 
				WHERE `user_id` != $client_id $sqlWhere
				$limit";
		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function find_member_tranfers_count($keyword, $client_id, $type)
	{ //đếm số khách hàng tìm kiếm để thực hiện chuyển tiền (tùng code- 25012021)
		//HC 210713 fix: bổ sung type
		global $db;

		if ($type == 'exactly') {
			$sqlWhere = "AND (`mobile` = '$keyword' )";
		} else {
			$sqlWhere = "AND (`mobile` LIKE '%$keyword%' OR `email` LIKE '%$keyword%' OR `code` LIKE '%$keyword%') ";
		}

		$sql = "SELECT COUNT(*) total FROM `members` 
				WHERE `user_id` != $client_id $sqlWhere";
		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	public function update_sale_daily()
	{
		global $db;

		$user_id 						= $this->get('user_id');
		$is_sale_daily					= $this->get('is_sale_daily');
		$activate_is_sale_daily 		= $this->get('activate_is_sale_daily');

		if ($activate_is_sale_daily > 0) {

			$arr['is_sale_daily'] 				= $is_sale_daily;
			$arr['last_is_sale_daily'] 			= time();
		} else {

			$arr['is_sale_daily'] 				= $is_sale_daily;
			$arr['last_is_sale_daily'] 			= time();
			$arr['activate_is_sale_daily'] 		= time();
		}

		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' ");

		return true;
	}

	public function active_pending_daily($dClient_id)
	{
		global $db;

		$user_id 						= $this->get('user_id');
		$pending_is_sale_daily			= $this->get('pending_is_sale_daily');

		$arr['pending_is_sale_daily'] 	= $pending_is_sale_daily;
		$arr['activate_is_sale_daily_by'] 	= $dClient_id;
		$arr['activate_is_sale_daily_at'] 	= time();

		$db->record_update($db->tbl_fix . '`members`', $arr, " `user_id` = '$user_id' ");

		return true;
	}

	// lấy danh sách khách hàng trực tiếp có thể là đại lý. để mở chức năng chờ lên đại lý của saledaily (tùngcode-23/02/21)
	public function list_member_pending_sale_daily($keyword, $status, $from, $to, $offset = 0, $limit = '')
	{
		global $db;

		$mobile = $this->get('mobile');
		$code = $this->get('code');

		if ($limit != '') $limit = "LIMIT $offset,$limit";
		if ($keyword != '') $keyword = " AND ( `fullname` LIKE '%$keyword%' OR `mobile` LIKE '%$keyword%' OR `email` LIKE '%$keyword%' OR `code` LIKE '%$keyword%' ) ";

		if ($status != '') $status = "AND pending_is_sale_daily = $status";

		$sqlFromTo = '';
		if ($from != '' && $from > 0) {
			$sqlFromTo = " AND '$from' <= `joined_at` AND `joined_at` <= '$to' ";
		}

		$referral_by = "(`referral_by` = '$mobile' OR `referral_by` = '$code')";

		$sql = "SELECT * FROM $db->tbl_fix`members` WHERE $referral_by $status $sqlFromTo $keyword $limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	// đếm khách hàng trực tiếp có thể là đại lý. để mở chức năng chờ lên đại lý của saledaily (tùngcode-23/02/21)
	public function list_member_pending_sale_daily_count($keyword = '', $status = '', $from, $to)
	{
		global $db;

		$code = $this->get('code');
		$mobile = $this->get('mobile');

		$referral = " (`referral_by` = '$code' OR `referral_by` = '$mobile' )";

		if ($keyword != '') $keyword = " AND ( `fullname` LIKE '%$keyword%' OR `mobile` LIKE '%$keyword%' OR `email` LIKE '%$keyword%' OR `code` LIKE '%$keyword%' ) ";
		if ($status != '') $status = "AND pending_is_sale_daily = $status";
		$sqlFromTo = '';
		if ($from != '' && $from > 0) {
			$sqlFromTo = " AND '$from' <= `joined_at` AND `joined_at` <= '$to' ";
		}

		$sql = "SELECT COUNT(*) total
				FROM $db->tbl_fix`members` mb
				WHERE $referral $status $sqlFromTo $keyword";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	// danh sách sale đại lý của nhà phân phối (tùng code - 26/02/21)
	public function get_list_sale_daily_by_npp($offset = '', $limit = '')
	{
		global $db;

		$npp_referral = $this->get('npp_referral');

		$npp_referral = "`npp_referral` = '$npp_referral'";
		if ($limit != '') $limit = "LIMIT $offset, $limit";

		$sql = "SELECT mb.*
				FROM $db->tbl_fix`members` mb
				WHERE $npp_referral AND `is_sale_daily` = 1 $limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	// đếm danh sách sale đại lý của nhà phân phối (tùng code - 26/02/21)
	public function get_list_sale_daily_by_npp_count()
	{
		global $db;

		$npp_referral = $this->get('npp_referral');

		$npp_referral = "`npp_referral` = '$npp_referral'";

		$sql = "SELECT COUNT(*) total
				FROM $db->tbl_fix`members` mb
				WHERE $npp_referral AND `is_sale_daily` = 1";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	//lấy danh sách đại lý đã được nâng cấp thành công dưới mã giới thiệu của user có filter dành cho app client(tùng code - 26/02/21)
	public function filter_list_daily_by_sale_daily($keyword, $status, $from = '', $to = '', $offset = 0, $limit = '')
	{
		global $db;

		$user_id = $this->get('user_id');
		if ($status != '' && $status != 0) {
			$is_daily = "AND mb.`pending_is_sale_daily` = $status";
		} else {
			$is_daily = "AND (mb.`pending_is_sale_daily` = 2 OR mb.`pending_is_sale_daily` = 1)";
		}

		$sqlFromTo = '';
		if ($from != '' && $from > 0 && $status == 0) {
			$sqlFromTo = " AND '$from' <= mb.`activate_is_sale_daily_at` AND mb.`activate_is_sale_daily_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == -1) {
			$sqlFromTo = " AND '$from' <= mb.`joined_at` AND mb.`joined_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == 1) {
			$sqlFromTo = " AND '$from' <= mb.`activated_at` AND mb.`activated_at` <= '$to' ";
		} else {
			$sqlFromTo = "";
		}

		if ($keyword != '') $keyword = " AND (mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%')";
		if ($limit != '') $limit = "LIMIT $offset, $limit";

		$sql = "SELECT mb.*, IF( mb.`is_sale_daily` > 0, 'Sale đại lý', IF( mb.`license_to` > 0, 'Đại lý', mg.`name`)) member_group_name 
				FROM $db->tbl_fix`members` mb
				LEFT JOIN `member_group` mg ON `mb`.`member_group_id` = `mg`.`id`
				WHERE mb.`activate_is_sale_daily_by` = $user_id $is_daily $sqlFromTo $keyword $limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	//lấy danh sách đại lý đã được nâng cấp thành công dưới mã giới thiệu của user có filter dành cho app client(tùng code - 26/02/21)
	public function filter_list_daily_by_sale_daily_count($keyword, $status, $from = 0, $to = '')
	{
		global $db;

		$user_id = $this->get('user_id');
		if ($status != '' && $status != 0) {
			$is_daily = "AND `pending_is_sale_daily` = $status";
		} else {
			$is_daily = "AND (`pending_is_sale_daily` = 2 OR `pending_is_sale_daily` = 1)";
		}

		$sqlFromTo = '';
		if ($from != '' && $from > 0 && $status == 0) {
			$sqlFromTo = " AND '$from' <= `activate_is_sale_daily_at` AND `activate_is_sale_daily_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == -1) {
			$sqlFromTo = " AND '$from' <= `joined_at` AND `joined_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == 1) {
			$sqlFromTo = " AND '$from' <= `activated_at` AND `activated_at` <= '$to' ";
		} else {
			$sqlFromTo = "";
		}

		if ($keyword != '') $keyword = " AND (`fullname` LIKE '%$keyword%' OR `mobile` LIKE '%$keyword%')";

		$sql = "SELECT COUNT(*) total
				FROM $db->tbl_fix`members` mb
				LEFT JOIN `member_group` mg ON `mb`.`member_group_id` = `mg`.`id` WHERE `activate_is_sale_daily_by` = $user_id $is_daily $sqlFromTo $keyword";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	//lấy danh sách đại lý đã được nâng cấp thành công dưới mã giới thiệu của user dành cho app partner (tùng code - 26/02/21)
	public function get_list_daily_by_sale_daily($keyword = '', $status, $from = '', $to = '', $offset = '', $limit = '')
	{
		global $db;

		$user_id = $this->get('user_id');
		if ($status != '') {
			$is_daily = "AND `pending_is_sale_daily` = $status";
		} else {
			$is_daily = "AND (`pending_is_sale_daily` = 2 OR `pending_is_sale_daily` = 1)";
		}

		if ($keyword != '') $keyword = " AND (mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%')";

		$sqlFromTo = '';
		if ($from != '' && $from > 0 && $status == 0) {
			$sqlFromTo = " AND '$from' <= `activate_is_sale_daily_at` AND `activate_is_sale_daily_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == -1) {
			$sqlFromTo = " AND '$from' <= `joined_at` AND `joined_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == 1) {
			$sqlFromTo = " AND '$from' <= `activated_at` AND `activated_at` <= '$to' ";
		} else {
			$sqlFromTo = "";
		}

		if ($limit != '') $limit = "LIMIT $offset, $limit";

		$sql = "SELECT ntb.*, mb.`fullname` sale_name, mb.`mobile` sale_mobile FROM 
				(SELECT * FROM $db->tbl_fix`members` 
				WHERE `npp_referral` = $user_id $sqlFromTo $is_daily) 
				ntb INNER JOIN members mb ON ntb.`activate_is_sale_daily_by` = mb.`user_id` 
				WHERE 1 $keyword $limit ";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	//lấy danh sách đại lý đã được nâng cấp thành công dưới mã giới thiệu của user dành cho app partner (tùng code - 26/02/21)
	public function get_list_daily_by_sale_daily_count($keyword = '', $status, $from = '', $to = '')
	{
		global $db;

		$user_id = $this->get('user_id');
		if ($status != '') {
			$is_daily = "AND `pending_is_sale_daily` = $status";
		} else {
			$is_daily = "AND (`pending_is_sale_daily` = 2 OR `pending_is_sale_daily` = 1)";
		}

		if ($keyword != '') $keyword = " AND (mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%')";

		$sqlFromTo = '';
		if ($from != '' && $from > 0 && $status == 0) {
			$sqlFromTo = " AND '$from' <= `activate_is_sale_daily_at` AND `activate_is_sale_daily_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == -1) {
			$sqlFromTo = " AND '$from' <= `joined_at` AND `joined_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == 1) {
			$sqlFromTo = " AND '$from' <= `activated_at` AND `activated_at` <= '$to' ";
		} else {
			$sqlFromTo = "";
		}

		$sql = "SELECT COUNT(*) total
				FROM (SELECT * FROM $db->tbl_fix`members` 
				WHERE `npp_referral` = $user_id $sqlFromTo $is_daily) 
				ntb INNER JOIN members mb ON ntb.`activate_is_sale_daily_by` = mb.`user_id` 
				WHERE 1 $keyword ";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	//lấy danh sách thành vien cùng hệ thống -> api partner/members (tùng code - 05/03/2021)
	public function filter_list_referral_by($keyword = '', $status = '', $from = '', $to = '', $offset = 0, $limit = '')
	{
		global $db;

		$code 				= $this->get('code');
		$mobile 			= $this->get('mobile');
		$direct_referral 	= $this->get('direct_referral');

		$referral = " (mb.`referral_by` = '$code' OR mb.`referral_by` = '$mobile' ) ";

		if ($status != '') {
			if ($status > 0) {
				$is_daily = "AND mb.`pending_is_sale_daily` = $status";
			} else {
				$is_daily = "AND (mb.`pending_is_sale_daily` = 0 OR mb.`pending_is_sale_daily` = 1)";
			}
		} else {
			$is_daily = "";
		}

		$sqlFromTo = '';
		if ($from != '' && $from > 0 && $status == 1) {
			$sqlFromTo = " AND '$from' <= mb.`activate_is_sale_daily_at` AND mb.`activate_is_sale_daily_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == 0) {
			$sqlFromTo = " AND '$from' <= mb.`joined_at` AND mb.`joined_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == 2) {
			$sqlFromTo = " AND '$from' <= mb.`activated_at` AND mb.`activated_at` <= '$to' ";
		} else if ($from != '' && $from > 0) {
			$sqlFromTo = "AND ( ('$from' <= mb.`activated_at` AND mb.`activated_at` <= '$to') OR ('$from' <= mb.`joined_at` AND mb.`joined_at` <= '$to') ) ";
		} else {
			$sqlFromTo = "";
		}

		if ($keyword != '') $keyword = " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%' OR mb.`email` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";
		// if ($direct_referral != '' && $direct_referral > 0) $direct_referral = " AND mb.`direct_referral` <> '$direct_referral' "; //Trực tiếp bởi NPP hoặc đại lý

		if ($limit != '') $limit = "LIMIT $offset, $limit";

		$sql = "SELECT mb.*, IF( mb.`is_sale_daily` > 0, 'Sale đại lý', IF( mb.`license_to` > 0, 'Đại lý', mg.`name`)) member_group_name
				FROM $db->tbl_fix`members` mb
				LEFT JOIN " . $db->tbl_fix . "`member_group` mg ON mg.`id` = mb.`member_group_id`
				WHERE $referral $sqlFromTo $is_daily $keyword
				$limit";

		$result = $db->executeQuery($sql);

		$kq		= array();
		while ($row = mysqli_fetch_assoc($result)) {
			unset($row['password']);
			unset($row['salt']);
			unset($row['session_token']);
			$kq[] = $row;
		}

		return $kq;
	}

	//lấy danh sách thành vien cùng hệ thống có filter ngày, filter KH hay đại lý -> api partner/members => count number record (tùng code - 05/03/2021)
	public function filter_list_referral_by_count($keyword = '', $status = '', $from = '', $to = '')
	{
		global $db;

		$code = $this->get('code');
		$mobile = $this->get('mobile');
		$direct_referral = $this->get('direct_referral');

		$referral = " (mb.`referral_by` = '$code' OR mb.`referral_by` = '$mobile' )";

		if ($status != '') {
			if ($status > 0) {
				$is_daily = "AND mb.`pending_is_sale_daily` = $status";
			} else {
				$is_daily = "AND (mb.`pending_is_sale_daily` = 0 OR mb.`pending_is_sale_daily` = 1)";
			}
		} else {
			$is_daily = "";
		}

		$sqlFromTo = '';
		if ($from != '' && $from > 0 && $status == 1) {
			$sqlFromTo = " AND '$from' <= mb.`activate_is_sale_daily_at` AND mb.`activate_is_sale_daily_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == 0) {
			$sqlFromTo = " AND '$from' <= mb.`joined_at` AND mb.`joined_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == 2) {
			$sqlFromTo = " AND '$from' <= mb.`activated_at` AND mb.`activated_at` <= '$to' ";
		} else if ($from != '' && $from > 0) {
			$sqlFromTo = "AND ( ('$from' <= mb.`activated_at` AND mb.`activated_at` <= '$to') OR ('$from' <= mb.`joined_at` AND mb.`joined_at` <= '$to') ) ";
		} else {
			$sqlFromTo = "";
		}

		if ($direct_referral != '' && $direct_referral > 0) $direct_referral = " AND mb.`direct_referral` <> '$direct_referral' ";

		if ($keyword != '') $keyword = " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%' OR mb.`email` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";

		$sql = "SELECT COUNT(*) total
				FROM $db->tbl_fix`members` mb
				LEFT JOIN " . $db->tbl_fix . "`member_group` mg ON mg.`id` = mb.`member_group_id`
				WHERE $referral $sqlFromTo $is_daily $keyword";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	//lấy danh sách thành vien cùng hệ thống có filter ngày, filter KH hay đại lý -> api partner/members => count number record (tùng code - 05/03/2021)
	public function filter($keyword = '', $status = '', $from = '', $to = '')
	{
		global $db;

		$code = $this->get('code');
		$mobile = $this->get('mobile');
		$direct_referral = $this->get('direct_referral');

		$referral = " (mb.`referral_by` = '$code' OR mb.`referral_by` = '$mobile' )";

		if ($status != '') {
			if ($status > 0) {
				$is_daily = "AND mb.`pending_is_sale_daily` = $status";
			} else {
				$is_daily = "AND (mb.`pending_is_sale_daily` = -1 OR mb.`pending_is_sale_daily` = 0)";
			}
		} else {
			$is_daily = "";
		}

		$sqlFromTo = '';
		if ($from != '' && $from > 0 && $status == 0) {
			$sqlFromTo = " AND '$from' <= mb.`activate_is_sale_daily_at` AND mb.`activate_is_sale_daily_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == -1) {
			$sqlFromTo = " AND '$from' <= mb.`joined_at` AND mb.`joined_at` <= '$to' ";
		} else if ($from != '' && $from > 0 && $status == 1) {
			$sqlFromTo = " AND '$from' <= mb.`activated_at` AND mb.`activated_at` <= '$to' ";
		} else if ($from != '' && $from > 0) {
			$sqlFromTo = "AND ( ('$from' <= mb.`activated_at` AND mb.`activated_at` <= '$to') OR ('$from' <= mb.`joined_at` AND mb.`joined_at` <= '$to') ) ";
		} else {
			$sqlFromTo = "";
		}

		if ($direct_referral != '' && $direct_referral > 0) $direct_referral = " AND mb.`direct_referral` <> '$direct_referral' ";

		if ($keyword != '') $keyword = " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%' OR mb.`email` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";

		$sql = "SELECT COUNT(*) total
				FROM $db->tbl_fix`members` mb
				LEFT JOIN " . $db->tbl_fix . "`member_group` mg ON mg.`id` = mb.`member_group_id`
				WHERE $referral $sqlFromTo $is_daily $keyword";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	public function level_up_execute()
	{
		global $db, $setup;

		//thực hiện lên cấp cho khách hàng và khách hàng cha
		$user_id 	= $this->get('user_id');
		$dUser		= $this->get_detail();
		if (isset($dUser['user_id'])) {
			$this->set('referral_by', $dUser['referral_by']);
			$dParent = $this->get_detail_parent();
			if (isset($dParent['user_id'])) {

				//Đếm số lượng member đã active của user này
				$sql = "SELECT COUNT(*) total FROM $db->tbl_fix`$this->class_name` mb WHERE ( `referral_by` = '" . $dParent['code'] . "' OR `referral_by` = '" . $dParent['mobile'] . "' ) AND `referral_by` <> '' AND `total_spent` > 0 ";
				$dNoActive = $db->executeQuery($sql, 1);
				$total_activated = $dNoActive['total'] + 0;
				if ($total_activated > 0) {
					$arr['member_level_id'] = 1;
					if ($total_activated < 1) {
						//begin
						$arr['member_level_id'] = 1;
					} else if ($total_activated == 1) {
						//gold
						$arr['member_level_id'] = 2;
					} else if ($total_activated == 2) {
						//diamond
						$arr['member_level_id'] = 3;
					} else {
						//ruby
						$arr['member_level_id'] = 4;
					}

					if ($dParent['member_level_id'] <= $arr['member_level_id']) {
						$arr['no_referral'] = $total_activated;
						$db->record_update("$db->tbl_fix`$this->class_name`", $arr, " `user_id` = '" . $dParent['user_id'] . "' ");
					}

					return true;
				}
			}
		}
		return false;
	}

	public function license_dmember($dMember)
	{
		global $setup, $product;

		if ($dMember['member_group_id'] != $setup['member_group_trial']) {

			$dMember['license_activated']      = true;
			$dMember['license_label']          = $dMember['license_to'] == 0 ? 'Chờ cập nhật' : date('d/m/Y', $dMember['license_to']);

			//Chính thức:
			if ($dMember['license_to'] == 0 && $dMember['activated_at'] > 0) {
				//vô hạn
				$dMember['license_label']          = 'Vô thời hạn';
			} else if ($dMember['license_to'] < time()) {
				//Hết hạn
				$dMember['license_activated']      = false;
				$dMember['license_label']          = $dMember['license_to'] == 0 ? 'Chờ cập nhật' : date('d/m/Y', $dMember['license_to']);
			}
			$lProExtend = isset($setup['products_to_extend_'.$dMember['shop_id']]) ? $setup['products_to_extend_'.$dMember['shop_id']]:'';
			$dMember['license_product']        = $product->list_by_defined($lProExtend);
		} else {
			//Dùng thử
			if ($dMember['license_to'] > 0 && $dMember['license_to'] > time()) {
				//Còn hạn dùng thử
				$dMember['license_activated']      = true;
				$dMember['license_label']          = $dMember['license_to'] == 0 ? 'Chờ cập nhật' : date('d/m/Y', $dMember['license_to']);
			} else {
				//Tài khoản hết hạn dùng thử
				$dMember['license_activated']      = false;
				$dMember['license_label']          = 'Hết hạn dùng thử';
			}
			$lProUpgrade = isset($setup['products_to_upgrade_'.$dMember['shop_id']]) ? $setup['products_to_upgrade_'.$dMember['shop_id']]:'';
			$dMember['license_product']        		= $product->list_by_defined($lProUpgrade);
		}

		return $dMember;
	}

	public function license_upgrade()
	{
		global $db, $setup;

		$user_id 		= $this->get('user_id');
		$license_to 	= $this->get('license_to');

		$time_now 		= time();
		$sql = "UPDATE $db->tbl_fix`$this->class_name` SET `activated_at` = IF(`activated_at` > 0, `activated_at`, $time_now), `activated`= 1, `license_to` = '$license_to' WHERE `user_id` = '$user_id'";

		$db->executeQuery($sql);

		return true;
	}

	public function client_summary($dClient, $from, $to)
	{

		$commission_coaching    = new commission_coaching();
		$commission_department  = new commission_department();
		$collected_orders  		= new collected_orders();
		$member_group  			= new member_group();

		//hoa hồng coaching
		$commission_coaching->set('shop_id', $dClient['shop_id']);
		$commission_coaching->set('client_id', $dClient['user_id']);
		$dC                 			= $commission_coaching->client_filter_app_info('', '', $from - 1, $to);
		$kq['coaching_commission']     	= $dC['total_commission'];

		//Hoa hồng phòng ban quản lý
		$commission_department->set('client_id', $dClient['user_id']);
		$dC                 = $commission_department->client_filter_info_sum('', '', $from - 1,  $to);
		$kq['department_commission']     = $dC['total_commission'];

		//Doanh số phòng ban quản lý
		$commission_department->set('client_mngt_revenue_id', $dClient['user_id']);
		$dC                 = $commission_department->client_mngt_revenue_info_sum('', $from - 1,  $to);
		$kq['department_revenue']     = $dC['total_order_real'];


		//Số khách hàng mới tháng này
		$this->set('code', $dClient['code']);
		$this->set('mobile', $dClient['mobile']);
		$kq['no_referral']     = $this->count_new_referral($from - 1,  $to);

		//Doanh số cá nhân
		$collected_orders->set('members_id', $dClient['user_id']);
		$collected_orders->set('created_by_client_id', '');
		$collected_orders->set('is_booking', '');
		$dC = $collected_orders->client_self_revenue_sum('', $from - 1,  $to);
		$kq['self_revenue']     = $dC['total_order_real'];

		$kq['from'] = date('d/m/Y H:i', $from - 1);
		$kq['to'] = date('d/m/Y H:i', $to);

		// lấy KPIlevel theo member_group (tùngcode-20/04/2021)
		$member_group->set('id', $dClient['member_group_id']);
		$KPI = $member_group->get_KPIlevel_by_member_group();

		if (isset($KPI['total_spent'])) {
			$kq['KPI'] = $KPI;
		} else {
			$kq['KPI'] = null;
		}

		return $kq;
	}

	public function render_detail_info($dMember, $from, $to)
	{
		//HC: 210705 => sử dụng cho api login/ register/ reset password verify để trả về đồng nhất dữ liệu
		global $notification, $setup;

		$wallet_detail 		= new wallet_detail();
		$address_book 		= new address_book();
		$member_group 		= new member_group();
		$member_department 	= new member_department();


		$user_id = $this->get('user_id');

		$notification->set('for_admin', 0); //for client only
		$notification->set('to', $user_id);
		$dMember['un_read_number'] = $notification->count_un_read();

		$wallet_detail->set('client_id', $user_id);
		$dWallet = $wallet_detail->get_total_wallet_by_client();
		$dMember['wallet_main']         = $dWallet['wallet_main'];
		$dMember['wallet_cashback']     = $dWallet['wallet_cashback'];



		$address_book->set('client_id', $dMember['user_id']);
		$dMember['address_default']     = $address_book->get_default();

		// $dMember['status_activated']    = $this->daily_valid($dMember);
		// $dMember['partner_type']        = $this->partner_type($dMember);

		// $this->set('npp_referral', $dMember['user_id']);
		// $dMember['count_all_members']        = $this->filter_by_npp_count('', '', '', '', '');

		$wallet_detail->set('client_id', $dMember['user_id']);
		$lWallet = $wallet_detail->get_all_wallet_by_client();
		if (isset($lWallet) && $lWallet != '')
			$dMember['lWallet'] = $lWallet;
		else
			$dMember['lWallet'] = [];


		$member_group->set('id', $dMember['member_group_id']);
		$dMemberGroup = $member_group->get_detail();
		$dMember['member_group_name'] = $dMemberGroup['name'];



		$member_department->set('id', $dMember['member_department_id']);
		$member_department_name = $member_department->get_detail();
		$dMember['member_department_name'] = $member_department_name['name'];



		$this->set('user_id', $dMember['by_user_cs']);
		$dUserCS = $this->get_detail();
		$dMember['by_user_cs_name'] = $dUserCS['fullname'];



		//Xác định showroom owner và check trường hợp nhóm showroom nhưng không có set showroom
		$dMember['showroom_owner']          = false;
		$dMember['QRCode']          = $link . '/qrcode.php?code=' . $dMember['mobile'];

		/**
		 * BEGIN tính toán còn hạn hay hết hạn.
		 */

		$dMember = $this->license_dmember($dMember);

		/**
		 * END tính toán còn hạn hay hết hạn.
		 */

		/**
		 * BEGIN summary KPI
		 */

		$dMember['summary'] = $this->client_summary($dMember, $from, $to);
		/**
		 * END summary KPI
		 */

		return $dMember;
	}

	//lấy danh sách thành viên sắp hết hạn (tùng code - 12/07/2021)
	public function filter_list_member_expired($now)
	{
		global $db;

		// $sql = "SELECT mb.* FROM $db->tbl_fix`members` mb WHERE mb.`license_to` >= $exp OR mb.`license_to` >= $exp7 OR mb.`license_to` >= $exp3 ";
		$sql = "SELECT * FROM " . $db->tbl_fix . "`" . $this->class_name . "`
				WHERE FROM_UNIXTIME(`license_to`, '%Y-%m-%d 00:00:00') = FROM_UNIXTIME('$now', '%Y-%m-%d 00:00:00')
				OR date_sub(FROM_UNIXTIME(`license_to`, '%Y-%m-%d 00:00:00'), interval 1 day) = FROM_UNIXTIME('$now', '%Y-%m-%d 00:00:00')
				OR date_sub(FROM_UNIXTIME(`license_to`, '%Y-%m-%d 00:00:00'), interval 3 day) = FROM_UNIXTIME('$now', '%Y-%m-%d 00:00:00')
				OR date_sub(FROM_UNIXTIME(`license_to`, '%Y-%m-%d 00:00:00'), interval 7 day) = FROM_UNIXTIME('$now', '%Y-%m-%d 00:00:00')
				OR date_add(FROM_UNIXTIME(`license_to`, '%Y-%m-%d 00:00:00'), interval 1 day) = FROM_UNIXTIME('$now', '%Y-%m-%d 00:00:00')
				";
		$result = $db->executeQuery_list($sql);

		return $result;
	}

	//func list người dùng theo keyword để tìm kiếm (tùngcode-13/07/2021)
	public function list_by($keyword, $ofset = '', $limit = '')
	{
		global $db;

		if ($limit != '') $limit = " LIMIT $ofset, $limit ";
		if ($keyword != '') $keyword = " AND (`fullname` LIKE '%$keyword%' OR `mobile` LIKE '%$keyword%' OR `email` LIKE '%$keyword%' ) ";

		$sql = "SELECT *
                FROM " . $db->tbl_fix . "`" . $this->class_name . "`
                WHERE
                1
                $keyword
                ORDER BY `joined_at` DESC
                $limit";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function update_max_debts() //cập nhật lại giới hạn vay tín dụng
	{
		global $db;

		$user_id 			= $this->get('user_id');
		$max_debts 	= $this->get('max_debts');
		$sql = "UPDATE $db->tbl_fix`members` SET `max_debts` = (`max_debts`+'$max_debts') WHERE `user_id` = '$user_id' LIMIT 1";

		$db->executeQuery($sql);
		return true;
	}

	public function list_by_wallet_debt($keyword, $offset = '', $limit = '')
	{
		global $db, $credit_history, $setup;

		$wallet_id = $setup['wallet_id_debt'];

		if ($limit != '')
			$limit = " LIMIT $offset, $limit ";

		if ($keyword != '') {
			$keyword = " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";
		}

		$sql = "SELECT mb.*, IFNULL(wl.`amount`, 0) amount
				FROM $db->tbl_fix`members` mb
				LEFT JOIN wallet_detail wl ON wl.`client_id` = mb.`user_id` AND wl.`wallet_id` = $wallet_id
				WHERE mb.`user_id` > 5
				$keyword
				ORDER BY wl.`amount` DESC
				$limit";

		$result = $db->executeQuery_list($sql);
		return $result;
	}

	public function list_by_wallet_debt_count($keyword)
	{
		global $db, $setup;

		$wallet_id = $setup['wallet_id_debt'];

		if ($keyword != '') {
			$keyword = " AND ( mb.`fullname` LIKE '%$keyword%' OR mb.`mobile` LIKE '%$keyword%' OR mb.`code` LIKE '%$keyword%' ) ";
		}

		$sql = "SELECT COUNT(*) total
				FROM $db->tbl_fix`members` mb
				LEFT JOIN wallet_detail wl ON wl.`client_id` = mb.`user_id` AND wl.`wallet_id` = $wallet_id
				WHERE mb.`user_id` > 5
				$keyword";

		$result = $db->executeQuery($sql, 1);

		return $result['total'];
	}

	// public function update_max_debts()
	// {
	// 	global $db;
	// 	$main = new main();

	// 	$arr['max_debts'] = $this->get('max_debts');
	// 	$arr['is_bad_debts'] = $this->get('is_bad_debts');

	// 	$db->record_update('members', $arr, " `user_id` = '" . $this->get('user_id') . "' ");

	// 	unset($arr);
	// 	return true;
	// }

	// vancode 16/11/22  get_permission_members    
	public function get_permission_members_new(){
		global $db;

		$sql = "SELECT * FROM $db->tbl_fix`permission_members`
				WHERE `root` = '0'
				AND `is_hidden` = '0'
				AND `is_menu` = '0'
				ORDER BY `group` ASC";
		$result = $db->executeQuery( $sql );
		
		$i = 1;
		$html = '';
		$sub_html = '';
		while ( $root = mysqli_fetch_assoc($result) ) {
			
			if( (($i-1)%3) == 0 && $i > 1 ){
				$html .= '<div class="row top-20">'.$sub_html.'</div>';
				$sub_html = '';
			}

			
			$sub_sql = "SELECT * FROM $db->tbl_fix`permission_members`
						WHERE `root` = '".$root['id']."'
						AND `is_hidden` = '0'
						AND `is_menu` = '0'
						ORDER BY `group` ASC ";
			$sub_result = $db->executeQuery_list( $sub_sql );
			if(COUNT($sub_result) > 0 ){

				$sub_html .= '<div class="col-lg-4 col-md-4">
					<div class="font-size-18"> <span class="circle_price">'.($i++).'</span> <b>  <span  class="root_id hide">'.$root['id'].' - </span> '.$root['title'].'</b></div>
				';
				foreach($sub_result as $sub_row){
					$sub_html .= '<div class="top-5 opt_permission">
								<label class="none-bold">
									<input permission_id = "'.$sub_row['id'].'" class="ckb_permission ace" type="checkbox" value="'.$sub_row['permission'].'"/> 
									<span class="lbl">'.$sub_row['title'].'</span>
								</label>
								</div>';
				}
				$sub_html .= '</div>';

			}
			
		}

		$html .= '<div class="row top-10">'.$sub_html.'</div>';

		return $html;
	}
	//vancode update_permission_by_gmid
	public function update_permission_by_gmid( $gmid, $default_permission ) {
		global $db;
		
		$arr['permission'] = $default_permission;

		$db->record_update($db->tbl_fix."`members`", $arr," `gmid` ='$gmid' ");
	}
	// end vancode get_permission_members

}

/**
 * GHI CHÚ CHO TRƯỜNG HỢP KÍCH HOẠT HAY KHÔNG KÍCH HOẠT ĐẠI LÝ CỦA MỘT USER = KHÁCH HÀNG CỦA YOBE
 * 1. Nếu trường thời gian kích hoạt là license còn => nghĩa user này đang kích hoạt toàn bộ sản phẩm
 * 2. Còn ngược lại thì kiểm tra ở một bản cài đặt sản phẩm được hưởng free và cộng với sản phẩm kích hoạt chỉ 1 sản phẩm
 */
