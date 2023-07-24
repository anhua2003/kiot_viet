<?php
class notification_group extends model{

    protected $class_name = 'notification_group';
    protected $id;
    protected $name;
    protected $created_at;
    protected $created_by;
    protected $is_deleted;
    protected $deleted_by;

    public function add(){
        global $db;

        $arr['name']                 = $this->get('name');
        $arr['created_at']           = time();
        $arr['created_by']           = $this->get('created_by');
        $arr['is_deleted']           = 0;
        $arr['deleted_by']           = 0;

        $db->record_insert( $db->tbl_fix.$this->class_name, $arr );

        return $db->mysqli_insert_id();
    }

    public function update(){
        global $db;

        $id                 = $this->get('id');

        $arr['name']        = $this->get('name');
        
        $db->record_update( $db->tbl_fix.$this->class_name, $arr, " `id` = '$id' " );

        return true;
    }

    public function delete_item(){
        global $db;

        $id                       = $this->get('id');
        $arr['is_deleted']        = time();
        $arr['deleted_by']        = $this->get('deleted_by');
        
        $db->record_update( $db->tbl_fix.$this->class_name, $arr, " `id` = '$id' " );

        return true;
    }

    public function filter( $offset = '', $limit = '') {//filter all
		global $db;

        if( $limit !== '' ) $limit = "LIMIT $offset, $limit";
        
        $sql = "SELECT *
                FROM $db->tbl_fix`". $this->class_name ."` th
                WHERE `is_deleted` = 0
                ORDER BY `name` ASC
                $limit";

		$result = $db->executeQuery_list( $sql );

		return $result;
	}

    public function filter_count() {//filter all
		global $db;

        $sql = "SELECT COUNT(*) total
                FROM $db->tbl_fix`". $this->class_name ."` th
                WHERE `is_deleted` = 0";

		$result = $db->executeQuery( $sql, 1 );

		return $result['total'];
	}
    
}