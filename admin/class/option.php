<?php
class option {
	private $varname;
	private $value;
	private $defaultvalue;
	private $datatype;
	private $type;  // loại setting 0 là erp và 1 là web
	private $is_hidden; // cho phép hiển thị khi gọi api hay ko
	private $not_edit; // cho phép chỉnh sửa hay ko
	private $group;

	
	// set get varname
	public function setvarname($varname) {
		$this->varname = $varname;
	}
	public function getvarname() {
		return $this->varname;
	}
	// set get title
	public function setvalue($value) {
		$this->value = $value;
	}
	public function getvalue() {
		return $this->value;
	}
	// set get title
	public function settitle($value) {
		$this->title = $value;
	}
	public function gettitle() {
		return $this->title;
	}
	// set get group
	public function setgroup($group) {
		$this->group = $group;
	}
	public function getgroup() {
		return $this->group;
	}
	// set get group
	public function settype($type) {
		$this->type = $type;
	}
	public function gettype() {
		return $this->type;
	}
	// set get permission
	public function setpermission($permission) {
		$this->permission = $permission;
	}

	public function getpermission() {
		return $this->permission;
	}
	
	public function update(){
		global $db;
		$arr['value'] = $this->getvalue();
		$db->record_update($db->tbl_fix."setting", $arr, "varname='".$this->getvarname()."'");

		return true;
	}

	public function delete(){
		global $db;

		$varname = $this->getvarname();
		$db->record_delete( $db->tbl_fix."`setting`", " `varname`= '$varname' ");

		return true;
	}

	public function insert(){
		global $db;

		$arr['varname'] = $this->getvarname();
		$arr['title'] 	= $this->gettitle();
		$arr['value'] 	= $this->getvalue();
		$arr['defaultvalue'] = '';
		$arr['datatype'] = 'text';
		$arr['group'] = '1';
		$arr['type'] = $this->gettype();
		$arr['is_hidden'] = 1;
		$arr['not_edit'] = 1;
		$arr['priority'] = '0';
		$db->record_insert($db->tbl_fix.'setting', $arr);

		return true;
		
	}
	
	public function company_info($company_title, $company_sort, $company_address, $company_tax, $company_fax, $company_phone, $company_email ){
		global $db;
		
		$setup = $this->showall();

		if( !isset($setup['company_title']) ){
			//insert
			$arr['varname'] = 'company_title';
			$arr['title'] = 'Tên công ty';
			$arr['value'] = $company_title;
			$arr['defaultvalue'] = $company_title;
			$arr['datatype'] = 'text';
			$arr['group'] = '1';
			$arr['priority'] = '0';
			$db->record_insert('setting', $arr);

		}else{
			//udpate
			$this->setvalue( $company_title );
			$this->setvarname('company_title', $company_title );
			$this->update();
		}

		if( !isset($setup['company_sort']) ){
			//insert
			$arr['varname'] = 'company_sort';
			$arr['title'] = 'Tên viết tắt công ty';
			$arr['value'] = $company_sort;
			$arr['defaultvalue'] = $company_sort;
			$arr['datatype'] = 'text';
			$arr['group'] = '1';
			$arr['priority'] = '0';
			$db->record_insert('setting', $arr);
			
		}else{
			//udpate
			$this->setvalue( $company_sort );
			$this->setvarname('company_sort', $company_sort );
			$this->update();
		}

		if( !isset($setup['company_address']) ){
			//insert
			$arr['varname'] = 'company_address';
			$arr['title'] = 'Địa chỉ công ty';
			$arr['value'] = $company_address;
			$arr['defaultvalue'] = $company_address;
			$arr['datatype'] = 'text';
			$arr['group'] = '1';
			$arr['priority'] = '0';
			$db->record_insert('setting', $arr);
			
		}else{
			//udpate
			$this->setvalue( $company_address );
			$this->setvarname('company_address', $company_address );
			$this->update();
		}

		if( !isset($setup['company_tax']) ){
			//insert
			$arr['varname'] = 'company_tax';
			$arr['title'] = 'Số Tax code công ty';
			$arr['value'] = $company_tax;
			$arr['defaultvalue'] = $company_tax;
			$arr['datatype'] = 'text';
			$arr['group'] = '1';
			$arr['priority'] = '0';
			$db->record_insert('setting', $arr);
		}else{
			//udpate
			$this->setvalue( $company_tax );
			$this->setvarname('company_tax', $company_tax );
			$this->update();
		}

		if( !isset($setup['company_fax']) ){
			//insert
			$arr['varname'] = 'company_fax';
			$arr['title'] = 'Số Fax công ty';
			$arr['value'] = $company_fax;
			$arr['defaultvalue'] = $company_fax;
			$arr['datatype'] = 'text';
			$arr['group'] = '1';
			$arr['priority'] = '0';
			$db->record_insert('setting', $arr);
		}else{
			//udpate
			$this->setvalue( $company_fax );
			$this->setvarname('company_fax', $company_fax );
			$this->update();
		}

		if( !isset($setup['company_phone']) ){
			//insert
			$arr['varname'] = 'company_phone';
			$arr['title'] = 'Số phone công ty';
			$arr['value'] = $company_phone;
			$arr['defaultvalue'] = $company_phone;
			$arr['datatype'] = 'text';
			$arr['group'] = '1';
			$arr['priority'] = '0';
			$db->record_insert('setting', $arr);
		}else{
			//udpate
			$this->setvalue( $company_phone );
			$this->setvarname('company_phone', $company_phone );
			$this->update();
		}

		if( !isset($setup['company_email']) ){
			//insert
			$arr['varname'] = 'company_email';
			$arr['title'] = 'Email công ty';
			$arr['value'] = $company_email;
			$arr['defaultvalue'] = $company_email;
			$arr['datatype'] = 'text';
			$arr['group'] = '1';
			$arr['priority'] = '0';
			$db->record_insert('setting', $arr);
		}else{
			//udpate
			$this->setvalue( $company_email );
			$this->setvarname('company_email', $company_email );
			$this->update();
		}

		return;
	}

	public function listall() {
		Global $db;
		$sql = "SELECT * FROM " . $db->tbl_fix . "`setting`";
		$result = $db->executeQuery ( $sql );
		$return = array();
		while ( $rows = mysqli_fetch_assoc ( $result ) ) {
			$return [] = $rows;
		}
		return $return;
	}

	public function list_all_by_type($type, $image /*load cài đặt là image hay ko 0 là ko 1 là có*/) {
		Global $db;

		$img = "";
		if($image == 0){
			$img = "AND `datatype` <> 'image'";
		}

		$sql = "SELECT * FROM " . $db->tbl_fix . "`setting` WHERE `type` = '$type' AND `is_hidden` = 0 AND `not_edit` = 0 $img";
		$result = $db->executeQuery ( $sql );
		$return = array();
		while ( $rows = mysqli_fetch_assoc ( $result ) ) {
			$return [] = $rows;
		}
		return $return;
	}

	public function list_all_by_type_img() {
		Global $db;

		$sql = "SELECT * FROM " . $db->tbl_fix . "`setting` WHERE `datatype` = 'image'";
		$result = $db->executeQuery ( $sql );
		$return = array();
		while ( $rows = mysqli_fetch_assoc ( $result ) ) {
			$return [] = $rows;
		}
		return $return;
	}

	public function listbygroup() {
		Global $db;
		$sql = "SELECT * FROM `" . $db->tbl_fix . "setting` where `group`='".$this->getgroup()."' order by priority";
		$result = $db->executeQuery ( $sql );
		$return = array();
		while ( $rows = mysqli_fetch_assoc ( $result ) ) {
			$return [] = $rows;
		}
		return $return;
		
	}
	public function showall(){
		$arr = $this->listall();
		$res = array();
		foreach ($arr as $key => $item) {
			$res[$item['varname']] = $item['value'];
		}
		return $res;
	}

	public function get_by_varname() {
		Global $db;
		$sql = "SELECT * FROM `setting` where `varname`='".$this->getvarname()."'";
		$result = $db->executeQuery ( $sql,1 );
		return $result;
		
	}
}
$opt = new option ();