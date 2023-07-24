<?php

//Danh cho thu ngan
$user->setusername($_SESSION['username']);
$user->setpassword($_SESSION['pass']);
$dUserLogin = $user->check_login();

if (!isset($dUserLogin['username'])) {
	$main->redirect($link . "/?m=panel&act=login");
	exit();
}

//Dành cho thu ngan
$_SESSION['fullname'] = $dUserLogin['fullname'];

$st->assign('lShops', $shop->list_by_user($dUserLogin));
$st->assign('str_permission',$dUserLogin['permission']);

if ($act == 'index') {

	$title .= $lang['lb_settings']; //Cấu hình hệ thống

	// $dshop = $shop->get_detail($dUserLogin['shop_id']);
	// $dshop = $shop->listby_username($dshop['username']);
	// if( $dshop == '' ){
	// 	$dshop = $shop->listby_username($_SESSION['username']);
	// }

	// $st->assign("dshop", $dshop);	

	$st->assign("str_permission", $dUserLogin['permission']);

	// unset($dshop);

}else if( $act == 'home'){
	$title = 'Quản lý trang chủ'; //Tạo trang chủ
	
} else if ($act == 'change_lang') {
	$title .= $lang['lb_selectlang']; //Chọn ngôn ngữ
	$lang = @$_GET['lang']; //

	if (in_array($lang, array('vi', 'en'))) {
		$user->update_lang($_SESSION['username'], $lang);

		$opt->setvarname('lang');
		$opt->setvalue($lang);
		$opt->update();

		// $posts['data'] = json_encode(  array( 'lang' => $lang ) );
		// $result = $api2Store->exeAPI2Store('/website/setting_update', $posts );

		$main->redirect($link . "/?m=user&act=login");
		$db->close();
		exit();
	} else {
		$main->redirect($link . '/?m=supervisor&act=index');
		exit();
	}
} else if ($act == 'eraser') {
	$title .= $lang['lb_eraserExe']; //Eraser system

	$st->assign('opt_shop', $shop->opt_by_user($dUserLogin, 1));
} else if ($act == 'google') {
	$st->assign('google_app_id', $_GET['google_app_id']);
} else if ($act == 'setting') {
	$title .= 'Cài đặt toàn hệ thống';

	$st->assign('setting', $opt->listall());
	
} else if ($act == 'config') {
	$title .= 'Cài đặt';

	$type = 0; //chỉ load setting của trang admin
	$image = 0; // không load cài đặt kiểu hình ảnh

	$st->assign('setting', $opt->list_all_by_type($type, $image));
	$st->assign('config', array(	
		   							'hotline',  			// số điện thoại hotline
			 						'term_condition', 		//chính sách và điều khoản
									'link_introduce',		//Link giới thiệu 
		   							'disabled_functions', 	  //ẩn chức năng
		    						'disabled_deposit',   	  //ẩn nạp tiền/ module
									'disabled_withdraw',		//ẩn rút tiền/ module
									'company_email',
									'content_notice_withdraw',// ID của sản phẩm dịch voucher free ship
									// 'referral_video',// ID của sản phẩm dịch voucher free ship
									// 'default_sale_npp_referral_by',// ID số điện thoại mặc định khi người dùng đăng ký mà không tạo mã
									'content_referral_description_sharing',
									'content_referral_banner_link_sharing',
									// 'content_referral_description',
									'content_referral_banner_link',
									'start_key_memo',//key nạp tiền
									'content_bonus',//key nạp tiền
									'url_logo',//Logo cong ty
									'content_push_new_app',//
									'template_content_verify',//Nội dung email verify code
									'template_content_register',//Nội dung email đăng ký
									'content_referral_client',//Nội dung giới thiệu app client
									'brand_sms',
									'contentResetPasswordCode',
									'template_content_verify',
								)
							);

} else if ($act == 'gb') {
	$title .= 'Cài đặt tổng';
	
	$delivery_steps 	= new delivery_steps();
	$wallet 			= new product_commission();

	$lThemes			= array();
	$themesFiles 		= __DIR__.'/../css/theme';
	$routeFiles 		= scandir($themesFiles);
	foreach ($routeFiles as $routeFile) {
		$routeFilePath = $themesFiles . '/' . $routeFile;
		if (is_file($routeFilePath) && preg_match('/^.*\.(css)$/i', $routeFilePath))
			$lThemes[]  = $routeFile;
	}
	
	// $st->assign('opt_shop', $shop->opt_by_user( $dUserLogin, 0 ));//Tất cả shop: số 0 nghĩa là ko có option all
	$st->assign('lDeliverySteps', $delivery_steps->list_all_sort_by_id('', '', 'ASC'));
	$st->assign('lWallet', $wallet->wallet_list_all());
	$st->assign('lThemes', $lThemes);
	unset($lThemes);

}else if ($act == 'config_web') {
	$title .= 'Cài đặt cho web';

	$type = 1; //chỉ load setting của trang web erp
	$image = 0; // không load cài đặt kiểu hình ảnh

	$st->assign('img', $opt->list_all_by_type_img()); //chỉ lấy cài đặt là hình ảnh
	$st->assign('setting', $opt->list_all_by_type($type, $image)); // lấy tất cả cài đặt của trang web trừ cài đặt là ảnh

} else if ($act == 'pos') {

	$title .= $lang['lb_optPos']; //Tùy chỉnh POS

	$tablePrinter = '';
	$tableEpson = '';
	$printers = array();
	if ($setup['google_access_token'] != '') {
		require_once(__DIR__ . '/../class/GoogleCloudPrint/GoogleCloudPrint.php');
		$gcp = new GoogleCloudPrint();

		$gcp->setAuthToken($setup['google_access_token']);
		$printers = $gcp->getPrinters();
	}

	// if($dUserLogin['gid'] == '0'){	

	$masterID = @$_COOKIE['MB360POS_master_id'];
	if ($masterID == '') {
		$masterID = md5(time());
		setcookie('MB360POS_master_id', $masterID, (time() + 5 * 365 * 86400));
	}

	// $lShops = $shop->list_by_user($dUserLogin);
	//genaral table printer
		// foreach ($lShops as $key => $item) {
		// 	$tablePrinter .= '<tr>
		// 					<td>' . $item['name'] . '</td>
		// 					<td>
		// 						<select id="printer" shop-id="' . $item['id'] . '" class="form-control option-shop-cloud-printer">';
		// 	foreach ($printers as $sitem) {
		// 		if ($sitem['id'] != '__google__docs')
		// 			if ($item['printer_id'] == $sitem['id'])
		// 				$tablePrinter .= '<option selected value="' . $sitem['id'] . '">' . $sitem['displayName'] . ' / ' . $sitem['ownerName'] . '</option>';
		// 			else
		// 				$tablePrinter .= '<option value="' . $sitem['id'] . '">' . $sitem['displayName'] . ' / ' . $sitem['ownerName'] . '</option>';
		// 	}
		// 	$tablePrinter .= '</select>
		// 					</td>
		// 				</tr>';

		// 	$tableEpson .= '<tr>
		// 							<td class="text-left">' . $item['name'] . '</td>
		// 							<td><input disabled shop-id="' . $item['id'] . '" id="epson-printer-id-' . $item['id'] . '" class="form-control info-epson-printer inp-epson" value="' . $item['printer_id'] . '"/></td>
		// 							<td><input disabled id="epson-printer-name-' . $item['id'] . '" class="form-control inp-epson" value="' . $item['printer_name'] . '"/></td>
		// 							<td>
		// 							<button onclick="test_connect(\'' . $item['id'] . '\');" class="btn btn-warning">Test</button>
		// 							</td>
		// 						</tr>';
		// }

	// }else{

	// 	$st->assign('shop_id', $dUserLogin['shop_id']);
	// 	$dshop = $shop->get_detail($dUserLogin['shop_id']);
	// 	$st->assign('shop_name', $dshop['name']);

	// 	//genaral table printer
	// 	$tablePrinter .= '<tr>
	// 					<td>'.$dshop['name'].'</td>
	// 					<td>
	// 						<select id="printer" shop-id="'.$dshop['id'].'" class="form-control option-shop-cloud-printer">';
	// 	foreach ($printers as $sitem) {
	// 		if( $sitem['id'] != '__google__docs' )
	// 			if( $dshop['printer_id'] == $sitem['id'] )
	// 				$tablePrinter .= '<option selected value="'.$sitem['id'].'">'.$sitem['displayName'].' / '.$sitem['ownerName'].'</option>';
	// 			else
	// 				$tablePrinter .= '<option value="'.$sitem['id'].'">'.$sitem['displayName'].' / '.$sitem['ownerName'].'</option>';
	// 	}
	// 	$tablePrinter .= '</select>
	// 				</td>
	// 			</tr>';

	// 	$tableEpson .= '<tr>
	// 						<td class="text-left">'.$dshop['name'].'</td>
	// 						<td><input placeholder="10.0.0.84" disabled id="epson-printer-id-'.$dshop['id'].'" shop-id="'.$dshop['id'].'" class="form-control info-epson-printer inp-epson" value="'.$dshop['printer_id'].'"/></td>
	// 						<td><input placeholder="local_printer" disabled id="epson-printer-name-'.$dshop['id'].'" class="form-control inp-epson" value="'.$dshop['printer_name'].'"/></td>
	// 						<td>
	// 						<button onclick="test_connect(\''.$dshop['id'].'\');" class="btn btn-warning">Test</button>
	// 						</td>
	// 					</tr>';

	// }

	$optTimeZone = $main->optTimeZones($default_time_zone);
	$st->assign("optTimeZone", $optTimeZone);
	$st->assign("tablePrinter", $tablePrinter);
	$st->assign("tableEpson", $tableEpson);
	$st->assign("setup", $setup);
	// $st->assign('opt_shop', $shop->opt_by_user( $dUserLogin, 0 ) );
} else {
	$main->redirect($link);
}
?>