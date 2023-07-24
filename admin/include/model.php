<?php
class model{

	protected $class_name = 'model';
	protected $paramater;

	// set value with paramater
	public function set( $parameter, $val) {
		$this->$parameter = $val;
		return true;
	}
	// get value with paramater
	public function get( $parameter ) {
		return $this->$parameter;
	}

	// get value with paramater
	public function get_detail() {
		global $db;
		
		$sql = "SELECT * FROM `". $this->class_name ."` WHERE `id` = '".$this->get('id')."'";
		$result = $db->executeQuery( $sql, 1);

		return $result;
	}

	public function update_field( $field ){
		global $db;
		$id = $this->get('id');
		
		$arr[$field] 	= $this->get($field);
		
		if( isset($arr[$field]) )
			$db->record_update( $db->tbl_fix.'`'.$this->class_name.'`', $arr, " `id` = '$id' " );
		
		return true;
	}

	// get value with paramater
	public function get_by_field( $field ) {
		global $db;
		
		$d = $this->get_detail();
		if( isset($d[$field]) ) return $d[$field];
		
		return 'Undefined';
	}

	public function list_all_sort_by_id( $offset = 0, $limit = '', $orderBy = '' ) {
		global $db;
		
        if( $limit != '' ) $limit = " LIMIT $offset, $limit ";
        
        if( $orderBy != 'DESC' && $orderBy != 'ASC' ) $orderBy = 'DESC';
		
		$sql = "SELECT * FROM `". $this->class_name ."` ORDER BY `id` $orderBy $limit ";

		$result = $db->executeQuery_list( $sql );

		return $result;
	}

	public function list_all( $offset = 0, $limit = '' ) {
		global $db;
		
		if( $limit != '' ) $limit = " LIMIT $offset, $limit ";
		
		$sql = "SELECT * FROM `". $this->class_name ."` $limit ";

		$result = $db->executeQuery_list( $sql );

		return $result;
	}

	public function list_all_count() {
		global $db;

		$sql = "SELECT COUNT(*) total FROM `". $this->class_name ."` ";

		$result = $db->executeQuery( $sql, 1 );

		return $result['total']+0;
	}

	public function list_option_all( $value, $text, $sort_by_field = '', $sort_method = 'ASC' , $condition = '' ) {
		global $db;
		
		if( $sort_by_field != '' )
			$sortby = " ORDER BY `$sort_by_field` ".$sort_method;
		else
			$sortby = " ORDER BY `$text` ".$sort_method;

		if( $condition != '' ) $condition = "WHERE $condition";
		
		$sql = "SELECT `$value` , `$text` FROM `". $this->class_name ."` $condition $sortby ";

		$result = $db->executeQuery( $sql );

		$opt = '';
		while($row = mysqli_fetch_assoc($result) ){
			$opt .= '<option value="'.$row[$value].'">'.$row[$text].'</option>';
		}

		return $opt;
	}

	public function delete() {
		global $db;
		
		$result = $db->record_delete( $this->class_name, " `id` = '".$this->get('id')."'");

		return $result;
	}

	public function delete_field(){
        global $db;
        
        $id                         = $this->get('id');

        $arr['deleted']             = time();
        $arr['deleted_by']          =  $this->get('deleted_by');

		$db->record_update( $db->tbl_fix.$this->class_name , $arr, " `id` = '$id' " );

		return true;
    }

	public function echo_($str) {
		echo $str;
		return false;
	}

	public function exit_($str) {
		global $db;
		$db->close();
		exit( $str );
	}

	public function print_r_($str) {
		print_r( $str );
		return false;
	}

}