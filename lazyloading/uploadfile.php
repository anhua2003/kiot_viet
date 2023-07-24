<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set("Asia/Ho_Chi_minh");

include "../define.php";
require_once __DIR__.'/../#directthumuc/config.php';

$user->setusername($_SESSION["username"]);
$user->setpassword($_SESSION["pass"]);
$dUserLogin = $user->check_login();

if(isset($_FILES['files']["name"])){

	$m = $main->get('m');
	$w = $main->get('w');//where to save
	if( $w == '' ) $w == 'image';

	if( $m == '' ){

		$import_code 	= $main->post('import_code');
		$wh_id 			= $main->post('wh_id');

		if (!file_exists('../uploads/'.$db_pos.'/'.$dUserLogin['shop_id'].'/'.date('Y-m-d'))) {
			//tạo thư mục chứa file trên server
			@mkdir('../uploads/'.$db_pos.'/'.$dUserLogin['shop_id'].'/'.date('Y-m-d'), 0777, true);
		}
		
		$_FILES['files']["name"] = $import_code."-".$wh_id."-".$_FILES["files"]["name"];
		$img_name = $main->upimg($_FILES['files'],"../uploads/$db_pos/".$dUserLogin['shop_id']."/".date('Y-m-d'),800);
		
		$img_name = $link.'/'."uploads/$db_pos/".$dUserLogin['shop_id']."/".date('Y-m-d')."/".$img_name;
		
		$wh_import->update_url( $import_code, $wh_id, $img_name );
		ob_end_clean();
		echo '{"files":[{"name":"'.$img_name.'","protected":"sees.vn license"}]}';
		//$kq = json_encode($kq);
		//echo "done#".$kq;

	}elseif( $m == 'multiple' ){
		
		$whereToSave 	= '../uploads/'.$database.'/'.$w.'/'.date('Y-m-d');//on server
		$getSaved 		= '/uploads/'.$database.'/'.$w.'/'.date('Y-m-d').'/';//on client: web request
		
		if (!file_exists($whereToSave)) {
			@mkdir( $whereToSave, 0777, true);
		}
		
		$_FILES['files']['name'] = $_FILES['files']['name'];
		$img_name = $main->upimg( $_FILES['files'], $whereToSave, 800);
		
		$img_name = $link.$getSaved.$img_name;
		
		ob_end_clean();
		echo '{"files":[{"name":"'.$img_name.'","protected":"sees.vn license"}]}';

	}
	
}else{
	echo 'Error: 404 not found';
}
