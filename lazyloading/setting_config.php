<?php

$nod = $main->get('nod');
if( $act == 'idx') {

	if( $nod == 'save' ){

		$data = $main->post('data', 'json');

        $data = json_decode( $data, true );
        if( $data ){
            foreach ($data as $key => $item) {
                $opt->setvarname($item['varname']);
                $opt->setvalue($item['value']);
                $opt->update();
            }
        }

        echo 'done##',$main->toJsonData( 200, 'success', null );
		
	}else if( $nod == 'info_shop' ){
		
		$shop_id 	= $main->post('shop_id');
		$dshop 		= $shop->get_detail($shop_id);

		$kq['note_in_bill'] = $dshop['note_in_bill'];

		echo 'done##',$main->toJsonData(200, 'success', $kq);
		
		
	}else if( $nod == 'show_vat' ){

		$show_vat = $_POST['show_vat'];

		$opt->setvarname( 'show_vat' );
		$opt->setvalue($show_vat);
		$opt->update();

		echo 'done##',$main->toJsonData(200, 'success', '');

	}else if( $nod == 'update_lang_region' ){
		
		$country = $_POST['country'];
		$lang = $_POST['lang'];
		$currency = $_POST['currency'];
		$time_zone = $_POST['time_zone'];

		$opt->setvarname( 'country' );
		$opt->setvalue( $country );
		$opt->update();

		$opt->setvarname( 'lang' );
		$opt->setvalue( $lang );
		$opt->update();

		if( $currency == 'AU$' ){
			$currency = 'AU$';
			$decimal = 2;
		}else if( $currency == 'US$' ){
			$currency = 'US$';
			// $symbol_currency = 'US$';
			$decimal = 2;
		}else{
			$currency = 'VNĐ';
			// $symbol_currency = 'VNĐ';
			$decimal = 0;
		}

		$opt->setvarname( 'currency' );
		$opt->setvalue( $currency );
		$opt->update();

		// $opt->setvarname( 'symbol_currency' );
		// $opt->setvalue( $symbol_currency );
		// $opt->update();

		$opt->setvarname( 'decimal' );
		$opt->setvalue( $decimal );
		$opt->update();

		$post['time_zone'] = $time_zone;
		$result = $api2Admin->exeAPI( 'update_timezone', $post );
		
		$posts['data'] = json_encode(  array(
						'country' => $country,
						'currency' => $currency,
						'decimal' => $decimal,
					) );
		
		// $result = $api2Store->exeAPI2Store('/website/setting_update', $posts );
		unset( $posts );

		$pos_register->update_time_zone( $_SESSION['db_pos'], $time_zone );

		echo 'done##',$main->toJsonData( 200, 'success', null );

	}else if( $nod == 'printing_on_cashed' ){

		$printing_on_cashed = $_POST['printing_on_cashed'];

		$opt->setvarname( 'printing_on_cashed' );
		$opt->setvalue($printing_on_cashed);
		$opt->update();
		
		echo 'done##',$main->toJsonData(200, 'success', null);
		$db->close();
		exit();

	}else if( $nod == 'is_cloud_printer' ){

		$is_cloud_printer = $_POST['is_cloud_printer'];
		$opt->setvarname( 'is_cloud_printer' );
		$opt->setvalue( $is_cloud_printer );
		$opt->update();

		if( $is_cloud_printer == 0 ){
			//reset google_access_token.setting, reset printer_id.shop, reset printer_name.shop
			$opt->setvarname( 'google_access_token' );
			$opt->setvalue( '' );
			$opt->update();
			$shop->reset_printer();
		}else if( $is_cloud_printer == 1 ){
			//load table google API

		}else if( $is_cloud_printer == 2 ){
			//load list table
			$opt->setvarname( 'google_access_token' );
			$opt->setvalue( '' );
			$opt->update();
			$shop->reset_printer();
		}

		echo 'done##',$main->toJsonData(200, 'success', null);

	}else if( $nod == 'update_printer_info' ){
		$data = $main->post('data', 'json');

		$lShop = json_decode($data, true);
		foreach ($lShop as $key => $item) {
			$shop->update_printer_info( $item['id'], $item['printer_id'], $item['printer_name'] );
		}

		echo 'done##',$main->toJsonData(200, 'success', null);

	}else if( $nod == 'disconnect_google_cloud' ){
		
		$opt->setvarname( 'google_access_token' );
		$opt->setvalue('');
		$opt->update();
		
		echo 'done##',$main->toJsonData( 200, 'success', null);

	}else if( $nod == 'google_cloud_access_token' ){

		$google_access_token = $_POST['google_access_token'];
		$opt->setvarname( 'google_access_token' );
		$opt->setvalue($google_access_token);
		$opt->update();

		require_once(__DIR__.'/../class/GoogleCloudPrint/GoogleCloudPrint.php');
		$gcp = new GoogleCloudPrint();

		echo 'done##',$main->toJsonData( 200, 'success', null );

	}else if( $nod == 'taxs' ){

		$taxs = $main->post( 'taxs', 'number');

		$opt->setvalue( $taxs );
		$opt->setvarname('taxs');	
		$opt->update();

		echo 'done##',$main->toJsonData(200, 'success', null );

	}else if( $nod == 'note_in_bill' ){

		$shop_id = $main->post('shop_id');
		$note_in_bill = $main->post('note_in_bill');
		
		$shop->update_note_in_bill( $shop_id, $note_in_bill );

		echo 'done##',$main->toJsonData(200, 'success', null);
		
	}else if( $nod == 'disable_offline' ){

		$password 		= $main->post('password');
		$cfPassword 	= md5(md5($password).$dUserLogin['salt']);

		if( $cfPassword == $dUserLogin['password'] ){

			$shop_id 	= $main->post('shop_id');
			$shop->disable_offline( $shop_id );

			$lShop = $shop->listby_username( $dUserLogin['username'] );
			$kq['html'] = list_master_shop( $lShop );

			echo "done##",$main->toJsonData(200, 'disabled', $kq);

		}else{
			echo "done##",$main->toJsonData(200, 'incorrect', 'Mật khẩu không đúng. Vui lòng xác nhận lại.');
		}

	}else if( $nod == 'enable_offline' ){

		$shop_id = @$_POST['shop_id'];
		$master_name = @$_POST['master_name'];
		$master_info = @$_POST['master_info'];
		$master_id = @$_POST['master_id'];

		$shop->remove_master_id( $master_id );
		$shop->set_master_device( $shop_id, $master_id, $master_name, $master_info );

		$lShop = $shop->listby_username( $dUserLogin['username'] );
		$kq['html'] = list_master_shop( $lShop );

		echo 'done##',$main->toJsonData(200, 'enabled', $kq);


	}else if( $nod == 'surcharge_get' ){

		$shop_id = $_POST['shop_id'];
		$dShop = $shop->get_detail( $shop_id );
		// print_r($dShop);
		if( isset($dShop['id']) ){
			$kq['surcharge_on'] = $dShop['surcharge_on'];
			$kq['surcharge_percent'] = $dShop['surcharge_percent'];
			$surcharge_from = explode(":", $dShop['surcharge_from']);
			@$kq['surcharge_hour_from'] = $surcharge_from[0]+0;
			@$kq['surcharge_minute_from'] = $surcharge_from[1]+0;
			$surcharge_to = explode(":", $dShop['surcharge_to']);
			@$kq['surcharge_hour_to'] = $surcharge_to[0]+0;
			@$kq['surcharge_minute_to'] = $surcharge_to[1]+0;
		}else{
			$kq['surcharge_on'] = 0;
			$kq['surcharge_percent'] = 0;
			$kq['surcharge_hour_from'] = 0;
			$kq['surcharge_minute_from'] = 0;
			$kq['surcharge_hour_to'] = 0;
			$kq['surcharge_minute_to'] = 0;
		}

		echo "done##",$main->toJsonData( 200, 'success', $kq );

		unset( $dShop );
		unset( $kq );

	}else if( $nod == 'surcharge_update' ){

		$shop_id = $_POST['shop_id'];
		$surcharge_on = $_POST['surcharge_on'];
		$surcharge_percent = $_POST['surcharge_percent'];
		$surcharge_from = $_POST['surcharge_from'];
		$surcharge_to = $_POST['surcharge_to'];

		$shop->update_surcharge( $shop_id, $surcharge_on, $surcharge_percent, $surcharge_from, $surcharge_to );

		echo "done##",$main->toJsonData( 200, 'success', null );

	}else if( $nod == 'company' ){
		
		$company_title 		= $main->post('company_title');
		$company_sort 		= $main->post('company_sort');
		$company_address 	= $main->post('company_address');
		$company_tax 		= $main->post('company_tax');
		$company_fax 		= $main->post('company_fax');
		$company_phone 		= $main->post('company_phone');
		$company_email 		= $main->post('company_email');
		
		$opt->company_info($company_title, $company_sort, $company_address, $company_tax, $company_fax, $company_phone, $company_email );
		
		echo "done##".$main->toJsonData( 200, 'updated', null );

	}else if( $nod == 'zerosell' ){

		$value 		= $main->post('value');
		$username 	= $main->post('username');
		$password 	= $main->post('password');

		$user->setusername( $username );
		$salt =$user->getSaltbyuser();
		
		$pw = md5($password);
		$pw = $pw.$salt;
		$pw = md5($pw);
		$user->setpassword($pw);
		$admin = $user->check_login();
		
		if(isset($admin['gid'])){
			if($admin['gid'] == 0){
			
				$opt->setvalue($value);
				$opt->setvarname('allow_zero_sell');	
				$opt->update();

				//syning
				$posts['allow_zero_sell'] = $setup['allow_zero_sell'];
				$api->exeAPI('/website/allow_zero_sell', $posts, $_SESSION);
				
				echo 'done##',$main->toJsonData('200', 'success', null);
				
			}else{
				echo 'done##',$main->toJsonData('403', $lang['lb_allowAdmin'], null);//'Chức năng chỉ danh cho quản trị viên.'$lang['lb_allowAdmin']
			}
		}else{
			echo 'done##',$main->toJsonData('403', $lang['lb_wrongPassAdmin'] , null);//'Username hay mật khẩu không đúng.'
		}
		
	} else {
		echo ($lang['er_004']." - Nod missing! ");
	}

} else {
	echo ($lang['er_004']." - Action missing! ");
}

function list_master_shop( $lShop){
	$html = '';

	foreach ($lShop as $key => $item) {
		
		if( $item['online_status'] > 0 ){
				$html .='<tr>
							<td class="text-left">
								'.$item['name'].'
							</td>
							<td>
								<label class="pull-center inline " val="'.$item['id'].'">
									<input id="enable_offline_'.$item['id'].'" checked="" type="checkbox" class="enabled_offline ace ace-switch ace-switch-4" value="'.$item['id'].'">
									<span class="lbl middle"></span>
								</label>
							</td>
							<td id="master_name_holder_'.$item['id'].'">
							'.$item['master_name'].'
							</td>
							<td id="master_info_holder_'.$item['id'].'">
							'.$item['master_info'].'
							</td>
						</tr>';
		}else{
			$html .= '<tr>
						<td class="text-left">
							'.$item['name'].'
						</td>
						<td>
							<label class="pull-center inline enabled_offline"  val="'.$item['id'].'">
								<input id="enable_offline_'.$item['id'].'" type="checkbox" class="enabled_offline ace ace-switch ace-switch-4" value="'.$item['id'].'">
								<span class="lbl middle"></span>
							</label>
						</td>
						<td id="master_name_holder_'.$item['id'].'">
							<button disabled id="btn_sl_master_device_'.$item['id'].'" onclick="select_master_device( '.$item['id'].' )" class="btn btn-default"> Chọn </button>
						</td>
						<td id="master_info_holder_'.$item['id'].'">
						</td>
					</tr>';
		}


	}

	return $html;

}