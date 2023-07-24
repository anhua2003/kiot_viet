<?php
class gid extends model {
	protected $class_name = 'gid';
	protected $id;
	protected $name;
	protected $default_permission;
	protected $default_report;//default_report_permission
	protected $permission_resellers;//permission_resellers
	protected $shop_accessed;//shop_accessed: cửa hàng được phép truy cập
	protected $bank_change_allow;//Danh sách ngân hàng cho phép xem số dư thay đổi
	protected $treasurer_allow_all;//On/off = 0|| 1 => chỉ người tạo mới xem được đơn mình tạo
	
	public function add(){
		global $db;
		
		$arr['name'] 					= $this->get('name');
		$arr['permission_resellers'] 	= '';
		$arr['default_permission'] 		= '';
		$arr['default_report']	 		= '';
		$arr['shop_accessed']	 		= '';
		$db->record_insert( $db->tbl_fix.'`'.$this->class_name.'`', $arr );
		
		return $db->mysqli_insert_id();
	}
	
	public function update(){
		global $db;
		$id = $this->get('id');
		
		if( $this->get('name') ) 				$arr['name'] 				= $this->get('name');
		
		$db->record_update( $db->tbl_fix.'`'.$this->class_name.'`', $arr, " `id` = '$id' " );
		return true;
	}
	
	public function update_permission(){
		global $db;
		$id = $this->get('id');
		
		$arr['default_permission'] 	= $this->get('default_permission');
		$arr['default_report'] 		= $this->get('default_report');
		$arr['shop_accessed'] 		= $this->get('shop_accessed');
		
		$db->record_update( $db->tbl_fix.'`'.$this->class_name.'`', $arr, " `id` = '$id' " );
		return true;
	}
	
	public function get_string_permission( $lstring ){//id;id1;id2;
		global $db;
		
		$sqlWhere = '';
		$l = explode(';', $lstring);
		
		foreach ($l as $key => $id) {
			$sqlWhere .= " `id` = '$id' OR ";
		}

		if( $sqlWhere != '' ){

			$sqlWhere = substr($sqlWhere, 0, -3);
			
			$sql = "SELECT `permission`.`permission` FROM ".$db->tbl_fix."`permission` WHERE $sqlWhere";
			
			$result = $db->executeQuery( $sql );

			$s = '';
			while( $row = mysqli_fetch_assoc($result) ){
				$s .= $row['permission'].';';
			}
			
			return $s.':useridx:';
		}else{
			return ':useridx:';
		}
    }
    
    public function opt_all(){
		global $db;
		$l = $this->list_all();
        
        $opt = '';
        foreach($l as $key => $item ){
            $opt .= '<option value="'.$item['id'].'">'.$item['name'].'</option>';
        }
        
		return $opt;
	}
	
}
$gid = new gid();