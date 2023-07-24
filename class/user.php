<?php
class user {
	private $id;
	private $strID;
	private $username;
	private $fullname;
	private $password;
	private $salt;
	private $mobile;
	private $phone;
	private $address;
	private $email;
	private $bank_name;
	private $bank_account;
	private $bank_branch;
	private $bank_id;
	private $gid;
	private $shop_id;
	private $status;
	private $vehicle;
	private $unit_cost;
	private $add_device;
	private $permission;
	private $accessed;//Cửa hàng được phép truy cấp: Shop_id1;shopid2;
	private $session_token;//Cửa hàng được phép truy cấp: Shop_id1;shopid2;
	
	// 1 set get user_id
	public function setid($id) {
		$this->id = $id;
	}
	public function getid() {
		return $this->id;
	}
	// 1 set get user_id
	public function setstrID($strID) {
		$this->strID = $strID;
	}
	public function getstrID() {
		return $this->strID;
	}
	// 2 set get username
	public function setusername($val) {
		$this->username = $val;
	}
	public function getusername() {
		return $this->username;
	}
	// 3 set get fullname
	public function setfullname($val) {
		$this->fullname = $val;
	}
	public function getfullname() {
		return $this->fullname;
	}
	// 4 set get password
	public function setpassword($pass) {
		$this->password = $pass;
	}
	public function getpassword() {
		return $this->password;
	}	
	//  5 salt
	public function getsalt(){
		return $this->salt;
	}
	public function setsalt($val){
		$this->salt = $val;
	}
	// 	6 set get mobile
	public function setmobile($val) {
		$this->mobile = $val;
	}
	public function getmobile() {
		return $this->mobile;
	}
	// 	7 set get phone
	public function setphone($val) {
		$this->phone = $val;
	}
	public function getphone() {
		return $this->phone;
	}
	// 	8 set get address
	public function setaddress($val) {
		$this->address = $val;
	}
	public function getaddress() {
		return $this->address;
	}
	// 	9 set get email
	public function setemail($email) {
		$this->email = $email;
	}
	public function getemail() {
		return $this->email;
	}
	// 	10 set get bank_name
	public function setbank_name($val) {
		$this->bank_name = $val;
	}
	public function getbank_name() {
		return $this->bank_name;
	}
	// 	11 set get bank_branch
	public function setbank_branch($val) {
		$this->bank_branch = $val;
	}
	public function getbank_branch() {
		return $this->bank_branch;
	}
	// 	12 set get bank_account
	public function setbank_account($val) {
		$this->bank_account = $val;
	}
	public function getbank_account() {
		return $this->bank_account;
	}
	// 	13 set get bank_id
	public function setbank_id($val) {
		$this->bank_id = $val;
	}
	public function getbank_id() {
		return $this->bank_id;
	}
	// 	14 set get gid
	public function setgid($gid) {
		$this->gid = $gid;
	}
	public function getgid() {
		return $this->gid;
	}
	// 	15 set get status
	public function setstatus($status) {
		$this->status = $status;
	}
	public function getstatus() {
		return $this->status;
	}
	// 	16 set get note
	public function setnote($val) {
		$this->note = $val;
	}
	public function getnote() {
		return $this->note;
	}
	// 	17 set get shop_id
	public function setshop_id($val) {
		$this->shop_id = $val;
	}
	public function getshop_id() {
		return $this->shop_id;
	}
	// 	18 set get permission
	public function setpermission($val) {
		$this->permission = $val;
	}
	public function getpermission() {
		return $this->permission;
	}
	// 	19 set get vehicle
	public function setvehicle($val) {
		$this->vehicle = $val;
	}
	public function getvehicle() {
		return $this->vehicle;
	}
	// 	20 set get unit_cost
	public function setunit_cost($val) {
		$this->unit_cost = $val;
	}
	public function getunit_cost() {
		return $this->unit_cost;
	}
	// 	20 set get unit_cost
	public function setaccessed($val) {
		$this->accessed = $val;
	}
	public function getaccessed() {
		return $this->accessed;
	}
	// 	20 set get unit_cost
	public function setsession_token($val) {
		$this->accessed = $val;
	}
	public function getsession_token() {
		return $this->accessed;
	}

	public function check_login() {
		global $db,$database;
		
		$username = $this->getusername();

		$rows = array();
		$username = str_replace(' ', '_', $username );
		$username = str_replace('#', '_', $username );
		$username = str_replace('/', '_', $username );
		$username = str_replace('\\', '_', $username );

		// if( preg_match('/^[ \b]+$/',  $username ) ){

			$sql = "SELECT `user`.*, gid.`wallet_accessed`
					FROM $db->tbl_fix`user`
					LEFT JOIN $db->tbl_fix`gid` ON gid.`id` = user.`gid`
					WHERE `username` = '$username' 
					AND `password` = '".$this->getpassword()."' 
					AND `status`='Active' limit 0,1";
			$rows = $db->executeQuery ( $sql, 1 );
		// }
		return $rows;
	}
	
	//get username width deactive status
	public function check_deactive() {
		global $db,$database;
		
		
		$username = $this->getusername();
		
		$rows = array();
		$username = str_replace(' ', '_', $username );
		$username = str_replace('#', '_', $username );
		$username = str_replace('/', '_', $username );
		$username = str_replace('\\', '_', $username );
		
		if( preg_match('/^[ \w]+$/',  $username ) ){

			$sql = "SELECT * FROM " . $db->tbl_fix . "`user` WHERE `username` = '$username' AND `password` = '".$this->getpassword()."' AND `status`= 'Deactive' limit 0,1";

			$rows = $db->executeQuery ( $sql, 1 );
			
		}
		
		
		return $rows;
	}


	public function get_master_account(){
		global $db;

		$sql = "SELECT * FROM " . $db->tbl_fix . "`user` WHERE `gid` = -1 AND `status`='Active' limit 0,1";
		$rows = $db->executeQuery ( $sql, 1 );
		return $rows;
	}

	public function check_master_account( $password ){
		global $db;

		$sql = "SELECT * FROM " . $db->tbl_fix . "`user` WHERE `password`= '$password' AND `gid` = -1 AND `status`='Active' limit 0,1";
		$rows = $db->executeQuery ( $sql, 1 );
		
		return $rows;
	}

	public function filter( $keyword, $shop_id, $gid ,$offset = 0, $limit = '') {
		global $db;

		if( $shop_id != '' ) $shop_id = " AND `shop_id` = '$shop_id' ";
		if( $gid != '' ) $gid = " AND `gid` = '$gid' ";
		if( $keyword != '' ) $keyword = " AND ( `username` LIKE '%$keyword%' OR `mobile` LIKE '%$keyword%' OR `fullname` LIKE '%$keyword%')";

		if ($limit != '') $limit = "LIMIT $offset,$limit";
		$sql = "SELECT `user`.*, gid.`name` as gid_name
				FROM " . $db->tbl_fix . "`user`
				LEFT JOIN `gid` ON gid.id = user.gid
				WHERE `user`.`gid` > 0
				$shop_id
				$gid
				$keyword
				ORDER BY username ASC
				$limit";
		
		$rows = $db->executeQuery_list( $sql);

		return $rows;
	}

	public function filter_count( $keyword, $shop_id, $gid ) {
		global $db;

		if( $shop_id != '' ) $shop_id = " AND `shop_id` = '$shop_id' ";
		if( $gid != '' ) $gid = " AND `gid` = '$gid' ";
		if( $keyword != '' ) $keyword = " AND ( `username` LIKE '%$keyword%' OR `mobile` LIKE '%$keyword%' OR `fullname` LIKE '%$keyword%')";

		$sql = "SELECT COUNT(*) total
				FROM " . $db->tbl_fix . "`user`
				WHERE `user`.`gid` > 0
				$shop_id
				$gid
				$keyword";
		
		$rows = $db->executeQuery( $sql, 1);
		
		return $rows['total']+0;
	}

	public function listby_shop_gid($shop_id,$gid) {
		global $db,$database;
		

		$sql = "select * from " . $db->tbl_fix . "user where `shop_id`='".$shop_id."' AND `gid` = '".$gid."' AND `status`='Active' ORDER BY username ASC";
		
		$rows = $db->executeQuery ( $sql);
		while($row = mysqli_fetch_assoc($rows)){
			$result[] = $row;
		}
		

		return $result;
	}
	
	public function listby_shop($shop_id) {
		global $db,$database;
		

		$sql = "select * from " . $db->tbl_fix . "user where `shop_id`='".$shop_id."' AND `status`='Active' ORDER BY gid ASC";
		
		$rows = $db->executeQuery ( $sql);
		while($row = mysqli_fetch_assoc($rows)){
			$result[] = $row;
		}
		

		return $result;
	}
	
	public function listby_shop2( $shop_id ) {
		global $db,$database;
		

		$sql = "select * from " . $db->tbl_fix . "user where `shop_id`='".$shop_id."' AND `status`='Active' AND gid>1 ORDER BY gid ASC";
		
		$rows = $db->executeQuery ( $sql);
		while($row = mysqli_fetch_assoc($rows)){
			$result[] = $row;
		}
		

		return $result;
	}
	
	public function optby_shop_gid($shop_id, $gid) {
		global $db,$database;
		

		$sql = "SELECT * FROM " . $db->tbl_fix . "`user` WHERE ( `accessed` LIKE '".$shop_id.";%' OR  `accessed` LIKE '%".$shop_id.";%' ) AND `gid` = '$gid' AND `status` = 'Active' ORDER BY username ASC";
		
		$rows = $db->executeQuery ( $sql);
		$kq = '';
		while($row = mysqli_fetch_assoc($rows)){
			$kq .= '<option value="'.$row["username"].'">'.$row["fullname"].' ('.$row["username"].')</option>';
		}
		
		
		return $kq;
	}

	public function opt_by_gid( $gid ) {
		global $db;

		$sql = "SELECT * FROM " . $db->tbl_fix . "`user` WHERE `gid` = '$gid' AND `status` = 'Active' ORDER BY fullname ASC";
		
		$rows = $db->executeQuery ( $sql);
		$kq = '';
		while($row = mysqli_fetch_assoc($rows)){
			$kq .= '<option value="'.$row["username"].'">'.$row["fullname"].' ('.$row["username"].')</option>';
		}
		
		return $kq;
	}
	
	public function optby_shop_gid_all( $shop_id, $gid) {
		global $db,$database;
		

		$sql = "SELECT * FROM " . $db->tbl_fix . "user WHERE ( `accessed` LIKE '".$shop_id.";%' OR  `accessed` LIKE '%".$shop_id.";%' ) AND `gid` = '".$gid."' ORDER BY username ASC";
		
		$rows = $db->executeQuery ( $sql);
		while($row = mysqli_fetch_assoc($rows)){
			$kq .= '<option value="'.$row["username"].'">'.$row["username"].'</option>';
		}
		

		return $kq;
	}

	public function opt_shipper() {
		global $db;

		$sql = "select id,fullname from " . $db->tbl_fix . "user where `gid` = '9' ORDER BY username ASC";
		
		$kq = '';
		$rows = $db->executeQuery ( $sql);
		while( $row = mysqli_fetch_assoc($rows) ){
			$kq .= '<option value="'.$row["id"].'">'.$row["fullname"].'</option>';
		}

		return $kq;
	}
	
	public function optall_gid7( $shop_id ) {
		global $db,$database;
		$shop = new shop();
		
		
		$lshop = $shop->listby_username($_SESSION['username']);
		$where_shop='';
		if(is_array($lshop)){
			foreach($lshop as $key=>$item){
				$where_shop .= "OR `shop_id`='".$item['id']."' ";
			}		
			$where_shop = '('.substr($where_shop,3).') AND ';
		}
		$sql = "SELECT * FROM " . $db->tbl_fix . "user WHERE ".$where_shop." `gid` = '7' ORDER BY username ASC";//Hội đồng quản trị
		
		$rows = $db->executeQuery ( $sql);
		$kq = '';
		while($row = mysqli_fetch_assoc($rows)){
			$kq .= '<option value="'.$row["username"].'">'.$row["username"].'</option>';
		}
		
		
		return $kq;
	}
	
	public function optby_shop_manage( $shop_id ) {
		global $db,$database;
		

		$sql = "select * from " . $db->tbl_fix . "user where ( `accessed` LIKE '".$shop_id.";%' OR  `accessed` LIKE '%".$shop_id.";%' ) AND `gid` < 2 AND `status`='Active' ORDER BY username ASC";
		
		$rows = $db->executeQuery ( $sql);
		$kq = '';
		while($row = mysqli_fetch_assoc($rows)){
			$kq .= '<option value="'.$row["username"].'">'.$row["username"].'</option>';
		}
		

		return $kq;
	}
	
	public function getSaltbyuser(){
		global $db;		
		$sql = "SELECT salt FROM " . $db->tbl_fix . "user WHERE `username`='" . $this->getusername() . "'";
		$rows = $db->executeQuery ( $sql, 1 );
		return $rows['salt'];
	}
	
	public function get_detail($username){
		global $db;		
		$sql = "SELECT * FROM " . $db->tbl_fix . "`user` WHERE `username`='" . str_replace("'", "\'", $username) . "'";
		$rows = $db->executeQuery ( $sql, 1 );
		return $rows;
	}
	public function get_root_user(){
		global $db;		
		$sql = "SELECT * FROM " . $db->tbl_fix . "`user` WHERE `gid`='0' LIMIT 1";
		$rows = $db->executeQuery ( $sql, 1 );
		return $rows;
	}
	
	public function get_fullname($username){
		global $db;		
		$sql = "SELECT fullname FROM " . $db->tbl_fix . "`user` WHERE `username`='" . str_replace("'", "\'", $username) . "'";
		$rows = $db->executeQuery ( $sql, 1 );
		return $rows['fullname'];
	}

	public function get_fullname_by_id( $id ){
		global $db;
		$sql = "SELECT `fullname` FROM " . $db->tbl_fix . "`user` WHERE `id` = '$id' ";
		$rows = $db->executeQuery ( $sql, 1 );
		return isset($rows['fullname'])?$rows['fullname']:'';
	}
	
	public function detailbyuser(){
		global $db;		
		$sql = "SELECT * FROM " . $db->tbl_fix . "user WHERE `username`='" . str_replace("'", "\'", $this->getusername()) . "'";
		$rows = $db->executeQuery ( $sql, 2 );
		return $rows;
	}
	
	public function updatePass() {
		global $db;
		$arr["password"] = $this->getpassword();
		$db->record_update($db->tbl_fix."user", $arr," `username`='" . str_replace("'", "\'", $this->getusername()) . "'");
	}
	
	public function update_password() {
		global $db;

		$id 				= $this->getid();

		$salt = $this->randString(10);
		$password = $this->getpassword();
		$pass = md5(md5($password).$salt);
		
		$arr['password'] = $pass;
		$arr['salt'] = $salt;

		$db->record_update($db->tbl_fix."`user`", $arr,"	`id` = '$id' ");
	}
	
	public function update_shop($username,$shop_id) {
		global $db;
		$arr["shop_id"] = $shop_id;
		$db->record_update($db->tbl_fix."user", $arr," `username`='" . str_replace("'", "\'", $username) . "' ");
		return false;
	}
	
	public function update_lang($username,$lang) {
		global $db;
		$arr["lang"] = $lang;
		$db->record_update($db->tbl_fix."user", $arr," `username`='" . str_replace("'", "\'", $username) . "' ");
		return true;
	}
	
	public function update_add_device($username,$allow) {
		global $db;
		if($allow=='1'){
			$arr["add_device"] = '1';
		}else{
			$arr["add_device"] = '0';
		}
		$db->record_update($db->tbl_fix."user", $arr," `username`='" . str_replace("'", "\'", $username) . "' ");
		return true;
	}
	
	public function update_status($username,$status) {
		global $db;
		$arr["status"] = $status;
		$db->record_update($db->tbl_fix."user", $arr," `username`='" . str_replace("'", "\'", $username) . "' ");
		return false;
	}
	
	public function update_security($username,$security) {
		global $db;
		$arr["security"] = $security;
		$db->record_update($db->tbl_fix."user", $arr," `username`='" . str_replace("'", "\'", $username) . "' ");
	}

	public function update_permission_by_gid( $gid, $default_permission, $accessed ) {
		global $db;
		
		$arr['permission'] = $default_permission;
		$arr['accessed'] = $accessed;//gid.shop_accessed table

		$db->record_update($db->tbl_fix."`user`", $arr," `gid` ='$gid' ");
	}
	
	public function update_accessed($username,$str_shops) {
		global $db;
		$arr["accessed"] = $str_shops;
		$db->record_update($db->tbl_fix."user", $arr," `username`='" . str_replace("'", "\'", $username) . "' ");
	}
	
	public function delete($username) {
		global $db;
		$db->record_delete($db->tbl_fix."user"," `username`='" . str_replace("'", "\'", $username) . "' ");
		return true;
	}
	
	public function list_noti($shop_id, $gid){
		global $db;
		
		$return = ';';
		$sql = "SELECT id FROM " . $db->tbl_fix . "`user` WHERE ( `accessed` LIKE '".$shop_id.";%' OR  `accessed` LIKE '%".$shop_id.";%' ) AND `gid`='" .$gid. "'";
		$rows = $db->executeQuery ( $sql);
		while($row = mysqli_fetch_assoc($rows)){
			$return .= $row['username'].';';
		}
		return $return;
	}

	public function list_noti_admin(){
		global $db;
		$sql = "SELECT id FROM " . $db->tbl_fix . "`user` WHERE `gid`='0' LIMIT 1";
		$rows = $db->executeQuery ( $sql, 1);
		return ''.$rows['id'].';';
	}
	
	public function add(){
		global $db;
		
		$arr['strID'] = $this->get_new_strID();
		$arr['username'] = $this->getusername();
		$arr['fullname'] = $this->getfullname();
		$arr['shop_id'] = $this->getshop_id();
		$arr['gid'] = $this->getgid();
		
		$salt = $this->randString(10);
		$password = $this->getpassword();
		$pass = md5(md5($password).$salt);
		
		$arr['password'] = $pass;
		$arr['salt'] = $salt;
		
		$arr['mobile'] = $this->getmobile();
		$arr['phone'] = $this->getphone();
		$arr['address'] = $this->getaddress();
		$arr['email'] = $this->getemail();
		$arr['bank_name'] = $this->getbank_name();
		$arr['bank_branch'] = $this->getbank_branch();
		$arr['bank_account'] = $this->getbank_account();
		$arr['bank_id'] = $this->getbank_id();
		$arr['status'] = $this->getstatus();
		$arr['vehicle'] = $this->getvehicle();
		$arr['unit_cost'] = $this->getunit_cost()+0;
		$arr['note'] = $this->getnote();
		$arr['create_user'] = $_SESSION['username'];
		$arr['permission'] = $this->getpermission();
		$arr['accessed'] 	= $this->getaccessed();
		$arr['session_token'] 	= '';
		
		$db->record_insert($db->tbl_fix.'`user`',$arr);
	
		return true;
	}
	
	public function update(){
		global $db;
			
		if($this->getpassword()!=''){
			$salt = $this->randString(10);
			$password = $this->getpassword();
			$pass = md5(md5($password).$salt);
			
			$arr['password'] = $pass;
			$arr['salt'] = $salt;
		}
		
		$id = $this->getid();
		$arr['username'] = $this->getusername();
		$arr['fullname'] = $this->getfullname();
		$arr['shop_id'] = $this->getshop_id();
		$arr['gid'] = $this->getgid();
		
		$arr['mobile'] = $this->getmobile();
		$arr['phone'] = $this->getphone();
		$arr['address'] = $this->getaddress();
		$arr['email'] = $this->getemail();
		$arr['bank_name'] = $this->getbank_name();
		$arr['bank_branch'] = $this->getbank_branch();
		$arr['bank_account'] = $this->getbank_account();
		$arr['bank_id'] = $this->getbank_id();
		$arr['status'] = $this->getstatus();
		$arr['note'] = $this->getnote();
		$arr['permission'] = $this->getpermission();
		$arr['accessed'] 	= $this->getaccessed();
		$arr['vehicle'] = $this->getvehicle();
		$arr['unit_cost'] = $this->getunit_cost();

		$db->record_update($db->tbl_fix.'`user`',$arr," `id` = '$id' ");
		
		return true;
	}

	public function reset_password($username){
		global $db;
		$duser = $this->get_detail($username);
		if($duser['username']!=''){
			
			$dpass = $this->create_default_password();
			
			$arr['password'] = $dpass['password'];
			$arr['salt'] = $dpass['salt'];
			
			$db->record_update($db->tbl_fix.'`user`',$arr," username='".$username."'");
			
		}else{
			echo "Không tìm thấy tên khách hàng trong hệ thống.";
			$db->close();
			exit();
		}
		return true;
	}

	public function reset_device($username){
		global $db;
		$duser = $this->get_detail($username);
		if($duser['username']!=''){
			
			$arr['security'] = '';			
			$db->record_update($db->tbl_fix.'`user`',$arr," username='".$username."'");
			
		}else{
			echo "Không tìm thấy tên khách hàng trong hệ thống.";
			$db->close();
			exit();
		}
		return true;
	}

	private function create_default_password(){
		$salt = $this->randString(10);
		$password = '1234Abcd';
		$pass = md5(md5($password).$salt);
		$return['password'] = $pass;
		$return['salt'] = $salt;
		return $return;
	}

	public function update_session_token( $dThis ){
		global $db;

		$id 				= $dThis['id'];
		$arr['session_token'] 	= md5($dThis['id'].$dThis['fullname'].time().$dThis['mobile'].$this->randString(6));
		$db->record_update('user', $arr, " `id` = '$id' ");
		
		return $arr['session_token'];
	}

	public function get_by_session_token( $session_token ){
		global $db;

		$sql = "SELECT * FROM `user` WHERE `session_token` = '$session_token' LIMIT 1 ";
		$result = $db->executeQuery( $sql, 1);
		
		return $result;
	}

	private function randString($length = 10) {
		$characters = 'w01s2345arbctvdeffg1hijklm4nop6789qrstuv3wxyz5AB675839CDEFGHIJ627g184g9gKLMfNdOPsQRSTfUVWgXdYsZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	// public function get_default_permission($gid){
	// 	global $db;
	// 	$sql = "SELECT `permission` FROM permission WHERE `gid_default` LIKE '%:".$gid.":%' ORDER BY title";
	// 	$result = $db->executeQuery( $sql );

	// 	$html = '#';
	// 	while ($row = mysqli_fetch_assoc($result)) {
	// 		$html .= $row['permission'].'#';
	// 	}

	// 	return $html;
	// }

	public function update_total_coffer( $username, $coffer_value ){
		global $db;
		
		$arr["total_coffers"] = $coffer_value;
		$db->record_update($db->tbl_fix."user", $arr, "`username` ='$username'" );
		
		return true;
	}
	
	public function plus_total_coffer( $username, $coffer_value ){
		global $db;
		
		$sql = "UPDATE `user` SET `total_coffers` = `total_coffers` + '$coffer_value' WHERE `username` = '$username' ";
		$db->executeQuery( $sql );
		
		return true;
	}

	public function update_syqueueid(){
		global $db;
		$sql = "SELECT `username` FROM user";
		$result = $db->executeQuery( $sql );
		$i = 1;
		while ($row = mysqli_fetch_assoc($result)) {
			$arr['id'] = $i;

			$db->record_update('user', $arr, " `username` = '".$row['username']."' ");
			$i++;
		}

		return true;
	}

	// public function get_permission( $string_permission , $gid ){
	// 	global $db;
	// 	if($gid == 4){
	// 		return '';
	// 	}
	// 	if($string_permission == '' ){
	// 		$string_permission = $this->get_default_permission($gid);
	// 	}
	// 	$string_permission = explode("#", $string_permission);
	// 	//Mục bán hàng
	// 	$sql = "SELECT * FROM permission WHERE `group` = '1' AND `root`='0' ORDER BY title";
	// 	$result = $db->executeQuery( $sql );
	// 	$html = '<div class="col-lg-4 col-md-4">
	// 				<div class="font-size-18"> <span class="circle_price">1</span> <b> Bán hàng</b></div>
	// 			';
	// 	$i = 1;
	// 	while ( $row = mysqli_fetch_assoc($result) ) {
	// 		$html .= '<div class="col-lg-12 col-md-12 top10">
	// 					<b>'.$i++.'. '.$row['title'].':</b>
	// 					</div>';

	// 		$sub_sql = "SELECT * FROM permission WHERE `group` = '1' AND `root`='".$row['id']."' AND `gid_option` LIKE '%:".$gid.":%' ORDER BY title";
	// 		$sub_result = $db->executeQuery( $sub_sql );

	// 		while( $sub_row = mysqli_fetch_assoc($sub_result) ){
	// 			if(in_array($sub_row['permission'] , $string_permission)){
					
	// 				$html .= '<div class="col-lg-12 opt_permission">
	// 							<label class="none-bold">
	// 								<input class="ckb_permission ace" type="checkbox" checked value="'.$sub_row['permission'].'"/> 
	// 								<span class="lbl"> '.$sub_row['title'].'</span>
	// 							</label>
	// 						 </div>';
	// 			}else{
	// 				$html .= '<div class="col-lg-12 opt_permission">
	// 							<label class="none-bold">
	// 								<input class="ckb_permission ace" type="checkbox" value="'.$sub_row['permission'].'"/> 
	// 								<span class="lbl"> '.$sub_row['title'].'</span>
	// 							</label>
	// 						 </div>';
	// 			}
	// 		}
	// 	}
	// 	$html .= '</div>';

	// 	//Chức nâng cao
	// 	$sql = "SELECT * FROM permission WHERE `group` = '2' AND `root`='0' ORDER BY title";
	// 	$result = $db->executeQuery( $sql );
	// 	$html .= '<div class="col-lg-4 col-md-4 border-lr-w">
	// 				<div class="font-size-18"> <span class="circle_price">2</span> <b> Nâng cao</b></div>
	// 			';
	// 	$i = 1;
	// 	while ( $row = mysqli_fetch_assoc($result) ) {
	// 		$html .= '<div class="col-lg-12 col-md-12 top10">
	// 					<b>'.$i++.'. '.$row['title'].':</b>
	// 					</div>';

	// 		$sub_sql = "SELECT * FROM permission WHERE `group` = '2' AND `root`='".$row['id']."' AND `gid_option` LIKE '%:".$gid.":%' ORDER BY title";
	// 		$sub_result = $db->executeQuery( $sub_sql );

	// 		while( $sub_row = mysqli_fetch_assoc($sub_result) ){
	// 			if(in_array($sub_row['permission'] , $string_permission)){
					
	// 				$html .= '<div class="col-lg-12 opt_permission">
	// 							<label class="none-bold">
	// 								<input class="ckb_permission ace" type="checkbox" checked value="'.$sub_row['permission'].'"/> 
	// 								<span class="lbl"> '.$sub_row['title'].'</span>
	// 							</label>
	// 						 </div>';
	// 			}else{
	// 				$html .= '<div class="col-lg-12 opt_permission">
	// 							<label class="none-bold">
	// 								<input class="ckb_permission ace" type="checkbox" value="'.$sub_row['permission'].'"/> 
	// 								<span class="lbl"> '.$sub_row['title'].'</span>
	// 							</label>
	// 						 </div>';
	// 			}
	// 		}
	// 	}
	// 	$html .= '</div>';

	// 	//Kế toán
	// 	$sql = "SELECT * FROM permission WHERE `group` = '3' AND `root`='0' ORDER BY title";
	// 	$result = $db->executeQuery( $sql );
	// 	$html .= '<div class="col-lg-4 col-md-4">
	// 				<div class="font-size-18"><span class="circle_price">3</span> <b> Kế toán</b></div>
	// 			';
	// 	$i = 1;
	// 	while ( $row = mysqli_fetch_assoc($result) ) {
	// 		$html .= '<div class="col-lg-12 col-md-12 top10">
	// 					<b>'.$i++.'. '.$row['title'].':</b>
	// 					</div>';

	// 		$sub_sql = "SELECT * FROM permission WHERE `group` = '3' AND `root`='".$row['id']."' AND `gid_option` LIKE '%:".$gid.":%' ORDER BY title";
	// 		$sub_result = $db->executeQuery( $sub_sql );

	// 		while( $sub_row = mysqli_fetch_assoc($sub_result) ){
	// 			if(in_array($sub_row['permission'] , $string_permission)){
					
	// 				$html .= '<div class="col-lg-12 opt_permission">
	// 							<label class="none-bold">
	// 								<input class="ckb_permission ace" type="checkbox" checked value="'.$sub_row['permission'].'"/> 
	// 								<span class="lbl"> '.$sub_row['title'].'</span>
	// 							</label>
	// 						 </div>';
	// 			}else{
	// 				$html .= '<div class="col-lg-12 opt_permission">
	// 							<label class="none-bold">
	// 								<input class="ckb_permission ace" type="checkbox" value="'.$sub_row['permission'].'"/> 
	// 								<span class="lbl"> '.$sub_row['title'].'</span>
	// 							</label>
	// 						 </div>';
	// 			}
	// 		}
	// 	}
	// 	$html .= '</div>';

	// 	return $html;
	// }
	
	//Load menu to show
	public function menu_funcs_load( $is_hidden ){
		global $db;

		$sqlHidden = '';
		if( $is_hidden != '' ){
			$sqlHidden = " AND `is_hidden` = '$is_hidden' ";
		}

		//Mục bán hàng
		$sql = "SELECT `id`, `title`, `is_hidden`, `link`, `m`, `act`, `root`, `icon`, `is_menu` FROM $db->tbl_fix`permission`
				WHERE `root` = '0'
				$sqlHidden
				AND (`is_menu` = '1' OR `is_menu` = '2')
				ORDER BY `priority` ASC";
		
		$r = $db->executeQuery( $sql );

		$arr = array();
		while( $row = mysqli_fetch_assoc($r) ){
			$row['subItems'] = $this->menu_funcs_load_sub( $row['id'], $is_hidden );
			$arr[] = $row;
		}

		return $arr;
	}

	public function menu_funcs_load_sub( $root_id, $is_hidden ){
		global $db;

		$sqlHidden = '';
		if( $is_hidden != '' ){
			$sqlHidden = " AND `is_hidden` = '$is_hidden' ";
		}

		//Mục bán hàng
		$sql = "SELECT `id`, `title`, `is_hidden`, `link`, `m`, `act`, `root`, `icon`, `is_menu` FROM $db->tbl_fix`permission`
				WHERE `root` = '$root_id'
				$sqlHidden
				AND (`is_menu` = '1' OR `is_menu` = '2')
				ORDER BY `priority` ASC";
		$r = $db->executeQuery( $sql );

		$arr = array();
		while( $row = mysqli_fetch_assoc($r) ){
			$row['subItems'] = $this->menu_load_sub( $row['id'], $is_hidden );
			$arr[] 			 = $row;
		}

		return $arr;
	}

	//Load menu to show
	public function menu_load( $is_hidden ){
		global $db;

		$sqlHidden = '';
		if( $is_hidden != '' ){
			$sqlHidden = " AND `is_hidden` = '$is_hidden' ";
		}

		//Mục bán hàng
		$sql = "SELECT `id`, `title`, `is_hidden`, `link`, `m`, `act`, `root`, `icon` FROM $db->tbl_fix`permission`
				WHERE `root` = '0'
				$sqlHidden
				AND `is_menu` = '1'
				ORDER BY `priority` ASC";
		
		$r = $db->executeQuery( $sql );

		$arr = array();
		while( $row = mysqli_fetch_assoc($r) ){
			$row['subItems'] = $this->menu_load_sub( $row['id'], $is_hidden );
			$arr[] = $row;
		}

		return $arr;
	}

	public function menu_load_sub( $root_id, $is_hidden ){
		global $db;

		$sqlHidden = '';
		if( $is_hidden != '' ){
			$sqlHidden = " AND `is_hidden` = '$is_hidden' ";
		}

		//Mục bán hàng
		$sql = "SELECT `id`, `title`, `is_hidden`, `link`, `m`, `act`, `root`, `icon` FROM $db->tbl_fix`permission`
				WHERE `root` = '$root_id'
				$sqlHidden
				AND `is_menu` = '1'
				ORDER BY `priority` ASC";
				
		$r = $db->executeQuery( $sql );

		$arr = array();
		while( $row = mysqli_fetch_assoc($r) ){
			$row['subItems'] = $this->menu_load_sub( $row['id'], $is_hidden );
			$arr[] 			 = $row;
		}

		return $arr;
	}

	public function menu_update( $lIDs, $is_hidden ){
		global $db;

		$sqlIDs = '';
		$lIDs = explode(';', $lIDs);
		if( COUNT($lIDs) > 0 ){
			foreach($lIDs as $ite ){
				if( $ite != '' ){
					$sqlIDs .= " `id` = '$ite' OR ";
				}
			}
			if( $sqlIDs != '' ){
				$sqlIDs = "(".substr($sqlIDs, 0, -3).") AND (`is_menu` = 1 OR `is_menu` = 2)";
				$arr['is_hidden'] = $is_hidden;
				$db->record_update("$db->tbl_fix`permission`", $arr, $sqlIDs );

				/**
				 * BEGIN get all permission to hide
				 */
				//List toàn bộ danh sách quyền con và ẩn theo luôn
				$sql = "SELECT `list_permission` FROM $db->tbl_fix`permission`
						WHERE $sqlIDs ";
				$lPer = $db->executeQuery_list($sql);

				$sqlPers = '';
				foreach( $lPer as $item ){
					$lPerArr = explode(';', $item['list_permission']);
					foreach( $lPerArr as $itePer ){
						if( $itePer != '' ){
							$sqlPers .= " `id` = '$itePer' OR ";
						}
					}
				}
				if( $sqlPers != '' ){
					$sqlPers = "(".substr($sqlPers, 0, -3).") AND `is_menu` = 0";
					$arr['is_hidden'] = $is_hidden;
					$db->record_update("$db->tbl_fix`permission`", $arr, $sqlPers );
				}
				/**
				 * END get all permission to hide
				 */

			}
		}

		return true;
	}

	public function get_permission_new(){
		global $db;

		//Mục bán hàng
		$sql = "SELECT * FROM $db->tbl_fix`permission`
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

			
			$sub_sql = "SELECT * FROM $db->tbl_fix`permission`
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

	public function eraser_system( $delete_product ){
		global $db, $shop, $setup, $pos_register, $db_pos, $providers, $wh;
		
		$rgStore 	= $pos_register->get_detail_bystore_name( $db_pos );
		$providers->set('from_pos_id', $rgStore['id'] );
		$providers->reset_spent();
		unset($rgStore);

		$from 		= $setup['begin_time'];
		$lShops 	= $shop->list_all_shop();

		foreach ( $lShops as $key => $item ) {
			$from = $item['created_at'];
			while ( date('Y', $from) == date('Y') ) {
				$db->record_delete($db->tbl_fix."`order_".$item['id']."_".date("Y", $from)."`"," 1 " );
				$db->record_delete($db->tbl_fix."`detail_order_".$item['id']."_".date("Y", $from)."`"," 1 " );
				$from += 86400*365;
			}

			$arr['created_at'] = time();
			$db->record_update( $db->tbl_fix."`shop`", $arr ," `id` = '".$item['id']."' " );
		}

		// $sub_sql = "SELECT max(id) as id FROM `warehouse_import` LIMIT 1";
		// $sub_result = $db->executeQuery( $sub_sql , 1 );
		// if( isset( $sub_result['id'] ) ){
			$db->record_delete($db->tbl_fix."`warehouse_import`"," 1 " );//Theo id kho
		// }
		
		$db->record_delete($db->tbl_fix."`cancel_report`"," 1 " );//theo shop_id
		$db->record_delete($db->tbl_fix."`coffers`"," 1 " );//shop_id
		$db->record_delete($db->tbl_fix."`coupon`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`coupon_history`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`collected_orders`"," 1 " );//shop_id

		$db->record_delete($db->tbl_fix."`warehouse_history`"," 1 " );// warehouse_import_id
		$db->record_delete($db->tbl_fix."`warehouse_card`"," 1 " );//product_id
		$db->record_delete($db->tbl_fix."`warehouse_inventory`"," 1 ");//warehouse_id
		// $db->record_delete($db->tbl_fix."`warehouse_dtinventory`"," 1 " );
		$db->record_delete($db->tbl_fix."`log`"," 1 " );
		
		$db->record_delete($db->tbl_fix."`slip`"," 1 " );//shop_id
		$db->record_delete($db->tbl_fix."`slip_detail`"," 1 " );//slip_id

		$db->record_delete($db->tbl_fix."`treasurer`"," 1 " );//shop_id
		$db->record_delete($db->tbl_fix."`publication`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`notification`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`member_transaction`"," 1 " );//shop_id
		
		$db->record_delete($db->tbl_fix."`liabilities`"," 1 " );//shop_id
		$db->record_delete($db->tbl_fix."`liabilities_history`"," 1 " );//liabilities_id
		$db->record_delete($db->tbl_fix."`liabilities_suggest`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`liabilities_suggest_detail`"," 1 " );//không có
		// $db->record_delete($db->tbl_fix."`package_history`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`transaction_bank`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`transaction_history`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`wallet_detail`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`wallet_transaction`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`delivery`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`delivery_history`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`voucher`"," 1 " );//không có
		$db->record_delete($db->tbl_fix."`voucher_history`"," 1 " );//không có

		$arr1['value'] = strtotime("01/01/".date("Y"));
		$db->record_update($db->tbl_fix."`setting`" , $arr1," `varname` = 'begin_time' " );
		
		$arr4['total_spent'] = '0';
		$arr4['point'] = '0';
		
		$arr4['wallet_main'] = '0';
		$arr4['wallet_cashback'] = '0';
		$arr4['wallet_register'] = '500000';
		$db->record_update( $db->tbl_fix."`members`", $arr4 ," 1 " );
		
		if( $delete_product == 1 ){

			$db->record_delete($db->tbl_fix."`SKU`"," 1 " );//shop_id
			$db->record_delete($db->tbl_fix."`product`"," 1 " );//shop_id
			$db->record_delete($db->tbl_fix."`category`"," 1 " );//shop_id
			$db->record_delete($db->tbl_fix."`root_category`"," 1 " );//shop_id
			
		}else{

			$arr2['on_stock'] = '0';
			$db->record_update( $db->tbl_fix."`SKU`", $arr2 ," 1 " );//product_id
			
			$arr3['sum_stock'] = '0';
			$db->record_update( $db->tbl_fix."`product`", $arr3 ," 1 " );//shop_id

		}

		
		return true;
	}

	public function eraser_system_by_shop_id( $shop_id, $delete_product ){
		global $db, $shop, $setup, $pos_register, $db_pos, $providers, $wh;
		
		$rgStore 	= $pos_register->get_detail_bystore_name( $db_pos );
		$providers->set('from_pos_id', $rgStore['id'] );
		$providers->reset_spent();
		unset($rgStore);

		$dShop 	= $shop->get_detail( $shop_id );
		if( isset($dShop['id']) ){

			$from 		= $dShop['created_at'];
			
			while ( date('Y', $from) == date('Y') ) {

				$db->record_delete($db->tbl_fix."`order_".$shop_id."_".date("Y", $from)."`"," 1 " );
				$db->record_delete($db->tbl_fix."`detail_order_".$shop_id."_".date("Y", $from)."`"," 1 " );
				$from += 86400*365;

			}

			$dWH = $wh->get_detail_by_shop_id( $shop_id );

			if( isset($dWH['id']) ){
				$warehouse_id = $dWH['id'];
				//xóa warehouse_history trước khi xóa warehouse_import
				$sql = "DELETE FROM $db->tbl_fix`warehouse_history` WHERE `wh_import_id` IN (SELECT wi.`id` `wh_import_id` FROM `warehouse_import` wi WHERE wi.`warehouse_id` = '$warehouse_id')";
				$db->executeQuery ( $sql );
				unset( $sql );
				
				$db->record_delete($db->tbl_fix."`warehouse_import`", " `warehouse_id` = '$warehouse_id' " );//warehouse_id
				$db->record_delete($db->tbl_fix."`warehouse_inventory`", " `warehouse_id` = '$warehouse_id' " );//warehouse_id

			}

			$sql = "DELETE FROM $db->tbl_fix`warehouse_card` WHERE `product_id` IN (SELECT ttb.`id` `product_id` FROM $db->tbl_fix`product` ttb WHERE ttb.`shop_id` = '$shop_id')";
			$db->executeQuery ( $sql );
			unset( $sql );

			$sql = "DELETE FROM $db->tbl_fix`slip_detail` WHERE `slip_id` IN (SELECT ttb.`id` `slip_id` FROM $db->tbl_fix`slip` ttb WHERE ttb.`shop_id` = '$shop_id')";
			$db->executeQuery ( $sql );
			unset( $sql );

			$sql = "DELETE FROM $db->tbl_fix`liabilities_history` WHERE `liabilities_id` IN (SELECT ttb.`id` `liabilities_id` FROM $db->tbl_fix`liabilities` ttb WHERE ttb.`shop_id` = '$shop_id')";
			$db->executeQuery ( $sql );
			unset( $sql );

			$db->record_delete($db->tbl_fix."`cancel_report`"," `shop_id` = '$shop_id' " );//theo shop_id
			$db->record_delete($db->tbl_fix."`coffers`"," `shop_id` = '$shop_id' " );//shop_id
			$db->record_delete($db->tbl_fix."`collected_orders`"," `shop_id` = '$shop_id' " );//shop_id
			$db->record_delete($db->tbl_fix."`treasurer`"," `shop_id` = '$shop_id' " );//shop_id
			$db->record_delete($db->tbl_fix."`member_transaction`"," `shop_id` = '$shop_id' " );//shop_id
			$db->record_delete($db->tbl_fix."`slip`"," `shop_id` = '$shop_id' " );//shop_id
			$db->record_delete($db->tbl_fix."`liabilities`"," `shop_id` = '$shop_id' " );//shop_id
			
			if( $delete_product == 1 ){

				$sql = "DELETE FROM $db->tbl_fix`SKU` WHERE `product_id` IN (SELECT ttb.`id` `product_id` FROM $db->tbl_fix`product` ttb WHERE ttb.`shop_id` = '$shop_id')";
				$db->executeQuery ( $sql );
				unset( $sql );

				$sql = "DELETE FROM $db->tbl_fix`category` WHERE `type` IN (SELECT ttb.`id` `type` FROM $db->tbl_fix`root_category` ttb WHERE ttb.`shop_id` = '$shop_id')";
				$db->executeQuery ( $sql );
				unset( $sql );

				$db->record_delete($db->tbl_fix."`product`"," `shop_id` = '$shop_id' " );//shop_id
				$db->record_delete($db->tbl_fix."`category`"," `shop_id` = '$shop_id' " );//shop_id
				$db->record_delete($db->tbl_fix."`root_category`"," `shop_id` = '$shop_id' " );//shop_id
				
			}else{
				
				$sql = "UPDATE $db->tbl_fix`SKU` SET `on_stock` = '0' WHERE `product_id` IN (SELECT ttb.`id` `product_id` FROM $db->tbl_fix`product` ttb WHERE ttb.`shop_id` = '$shop_id')";
				$db->executeQuery ( $sql );
				unset( $sql );

				$arr3['sum_stock'] = '0';
				$db->record_update( $db->tbl_fix."`product`", $arr3 ," `shop_id` = '$shop_id' " );
			}

			return true;
		}else{
			return false;
		}
	}
	
	public function optby_gid2( $gid ) {
		global $db;

		$sql = "SELECT id,fullname FROM " . $db->tbl_fix . "`user` 
				WHERE  `gid` = '".$gid."' AND `status`='Active'
				ORDER BY `username` ASC";
		
		$rows = $db->executeQuery ( $sql);
		$kq = '';
		while( $row = mysqli_fetch_assoc( $rows ) ){
			$kq .= '<option value="'.$row["id"].'">'.$row["fullname"].'</option>';
		}

		return $kq;
	}

	public function optby_gid( $gid ) {
		global $db;

		$sql = "SELECT fullname,username FROM " . $db->tbl_fix . "`user` 
				WHERE  `gid` = '".$gid."' AND `status`='Active'
				ORDER BY `username` ASC";
		
		$rows = $db->executeQuery ( $sql);
		$kq = '';
		while( $row = mysqli_fetch_assoc( $rows ) ){
			$kq .= '<option value="'.$row["username"].'">'.$row["fullname"].' ('.$row['username'].')</option>';
		}

		return $kq;
	}

	public function opt_all_user() {
		global $db;

		$sql = "SELECT `id`, `fullname`, `username` FROM " . $db->tbl_fix . "`user` 
				WHERE  `id` > 2 AND `status`='Active'
				ORDER BY `fullname` ASC";
		
		$rows = $db->executeQuery ( $sql);
		$kq = '';
		while( $row = mysqli_fetch_assoc( $rows ) ){
			$kq .= '<option value="'.$row["id"].'">'.$row["fullname"].' ('.$row['username'].')</option>';
		}

		return $kq;
	}

	public function optby_gid_fullname( $gid ) {
		global $db;

		$sql = "SELECT id,fullname,username FROM " . $db->tbl_fix . "`user` 
				WHERE  `gid` = '".$gid."' AND `status`='Active'
				ORDER BY `username` ASC";
		
		$rows = $db->executeQuery ( $sql);
		$kq = '';
		while( $row = mysqli_fetch_assoc( $rows ) ){
			$kq .= '<option value="'.$row["id"].'">'.$row["fullname"].'</option>';
		}

		return $kq;
	}

	public function opt_by_shop_id( $shop_id ) {
		global $db;

		$sql = "SELECT id,fullname,username FROM " . $db->tbl_fix . "`user` 
				WHERE  `accessed` LIKE '%;$shop_id;%' OR `gid` = '0'
				ORDER BY `fullname` ASC";
		
		$rows = $db->executeQuery ( $sql);
		$kq = '';
		while( $row = mysqli_fetch_assoc( $rows ) ){
			$kq .= '<option value="'.$row['username'].'">('.$row['username'].') '.$row['fullname'].'</option>';
		}

		return $kq;
	}

	public function get_detail_by_id($id){
		global $db;
		$sql = "SELECT * FROM " . $db->tbl_fix . "`user` WHERE `id`='" . $id . "'";
		$rows = $db->executeQuery ( $sql, 1 );
		return $rows;
	}

	public function get_new_strID(){
		global $db;
		$sql = "SELECT strID FROM " . $db->tbl_fix . "`user` ORDER BY strID DESC LIMIT 1";
		$rows = $db->executeQuery ( $sql, 1 );
		if( isset($rows['strID']) ){
			$first = ord($rows['strID']);
			$last = ord( substr($rows['strID'],1) );
			if( $last < 90 ){
				return chr($first).chr($last+1);
			}else{
				return chr($first+1).'A';
			}
		}else{
			return 'AA';
		}
	}
	
}
$user = new user ();
