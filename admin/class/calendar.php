<?php

class calendar {
		
	public function get_detail($username,$weekday){
		global $db,$database;
		
		
		$sql = "SELECT * FROM ".$db->tbl_fix."`calendar` WHERE `username`='".$username."' AND `weekdays`='".$weekday."' LIMIT 0,1";
	
		$row = $db->executeQuery ( $sql, 1 );
		
		
		return $row;
	}

	public function delete_by( $username ){
		global $db;
		
		$sql = "DELETE FROM $db->tbl_fix`calendar` WHERE `username`  = '$username' ";
		$db->executeQuery ( $sql );

		return true;
	}
	
	public function add($username,$weekdays,$from_1,$to_1,$from_2,$to_2){
		global $db,$database;		
		

		$arr['username'] = $username;
		$arr['weekdays'] = $weekdays;
		
		if($from_1 == $to_1){
			$arr['from_1'] = '-1';
			$arr['to_1'] = '-1';
		}else{
			$arr['from_1'] = $from_1;
			$arr['to_1'] = $to_1;
		}
		
		if($from_2 == $to_2){
			$arr['from_2'] = '-1';
			$arr['to_2'] = '-1';
		}else{
			$arr['from_2'] = $from_2;
			$arr['to_2'] = $to_2;
		}

		$db->record_insert($db->tbl_fix."calendar",$arr);
		
		
		
		return $db->mysqli_insert_id();
	}
	
	public function update($username,$weekdays,$from_1,$to_1,$from_2,$to_2){
		global $db,$database;		
		
		
		if($from_1 == $to_1){
			$arr['from_1'] = '-1';
			$arr['to_1'] = '-1';
		}else{
			$arr['from_1'] = $from_1;
			$arr['to_1'] = $to_1;
		}
		
		if($from_2 == $to_2){
			$arr['from_2'] = '-1';
			$arr['to_2'] = '-1';
		}else{
			$arr['from_2'] = $from_2;
			$arr['to_2'] = $to_2;
		}
		
		$db->record_update($db->tbl_fix."calendar",$arr," `username`='".$username."' AND `weekdays`='".$weekdays."'");
		
		

		return true;
	}
	
	public function convert() {
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$weekday = strtolower(date("l"));
		switch($weekday) {
			case 'monday':
				$weekday = '2';
				break;
			case 'tuesday':
				$weekday = '3';
				break;
			case 'wednesday':
				$weekday = '4';
				break;
			case 'thursday':
				$weekday = '5';
				break;
			case 'friday':
				$weekday = '6';
				break;
			case 'saturday':
				$weekday = '7';
				break;
			default:
				$weekday = '1';
				break;
		}
		return $weekday;
	}
	
	public function login_time( $username ){
		global $db;

		$sql2  = "SELECT `id`, `gid` FROM $db->tbl_fix`user` WHERE `username` = '$username' AND `status`='Active' LIMIT 0,1";	
		$dUserLogin = $db->executeQuery($sql2, 1);

		if( !isset($dUserLogin['id']) ){
			return false;
		}else if( isset($dUserLogin['id']) &&  $dUserLogin['gid'] < 2 ){
			return true;
		}else{

			$sql  = "SELECT from_1,to_1,from_2,to_2 FROM `calendar` WHERE `username`='".$username."' AND `weekdays`='".$this->convert()."' LIMIT 0,1";		
			$row = $db->executeQuery( $sql, 1);

			$time = strtotime(date('m/d/Y'));
			$from_1 = $time + $row['from_1']*3600;
			$to_1 = $time + $row['to_1'] * 3600;
			// echo "  $from_1 - $to_1 - ".time();
			// exit();
			if( $from_1 < time() && time() < $to_1 ){
				return true;
			}else{
				$from_2 = $time + $row['from_2']*3600;
				$to_2 = $time + $row['to_2']*3600;
				if( $from_2 < time() && time() < $to_2){
					return true;
				}else{
					return false;
				}
			}
		}

	}
	
}
$calendar = new calendar();
