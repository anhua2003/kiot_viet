<?php
class wallet_cashback extends model{

    protected $class_name = 'wallet_cashback';
	protected $product_commission_id;
	protected $member_group_id;
	protected $is_value;//Chiết khấu theo giá trị hay là percent
	protected $value;//float

    //for point config
	protected $is_point_value;//Là point tính theo giá trị = 1; =0 thì phần trăm
	protected $point;//giá trị point
    
    public function add(){
        global $db;
        
        $arr['product_commission_id']   = $this->get('product_commission_id');
        $arr['member_group_id']         = $this->get('member_group_id');
        $arr['is_value']                = $this->get('is_value');
        $arr['value']                   = $this->get('value');

        $arr['is_point_value']          = $this->get('is_point_value');
        $arr['point']                   = $this->get('point');

		$db->record_insert($db->tbl_fix.$this->class_name , $arr );

		return $db->mysqli_insert_id();
    }

    public function add_or_update(){
        global $db;

        $d = $this->get_detail_record();
        
        if( isset($d['product_commission_id']) ){

            $product_commission_id          = $this->get('product_commission_id');
            $member_group_id                = $this->get('member_group_id');
            $arr['is_value']                = $this->get('is_value');
            $arr['value']                   = $this->get('value');

            $arr['is_point_value']          = $this->get('is_point_value');
            $arr['point']                   = $this->get('point');

            $db->record_update($db->tbl_fix.$this->class_name , $arr, " `product_commission_id` = '$product_commission_id' AND `member_group_id` = '$member_group_id' " );
            return true;
        }else{
            $arr['product_commission_id']   = $this->get('product_commission_id');
            $arr['member_group_id']         = $this->get('member_group_id');
            $arr['is_value']                = $this->get('is_value');
            $arr['value']                   = $this->get('value');

            $arr['is_point_value']          = $this->get('is_point_value');
            $arr['point']                   = $this->get('point');

            $db->record_insert($db->tbl_fix.$this->class_name , $arr );
		    return $db->mysqli_insert_id();
        }

    }

    public function get_detail_record(){
		global $db;

        $product_commission_id   = $this->get('product_commission_id');
        $member_group_id         = $this->get('member_group_id');

		$sql = "SELECT * FROM $db->tbl_fix$this->class_name
                WHERE
                `product_commission_id` = '$product_commission_id' 
                AND `member_group_id` = '$member_group_id'
                LIMIT 1";
        
		$row = $db->executeQuery ( $sql, 1 );
		
		return $row;
    }
    
    public function update(){
        global $db;
        
        $product_commission_id   = $this->get('product_commission_id');
        $member_group_id         = $this->get('member_group_id');
        $arr['value']            = $this->get('value');

		$db->record_update($db->tbl_fix.$this->class_name , $arr, " `product_commission_id` = '$product_commission_id' AND `member_group_id` = '$member_group_id' " );
        
        return true;
    }
    
    public function delete_by(){
        global $db;
        
        $product_commission_id   = $this->get('product_commission_id');

        $db->record_delete( $db->tbl_fix.$this->class_name , " `product_commission_id` = '$product_commission_id' " );
        
        $arr['product_commission_id'] = 0;
		$db->record_update( $db->tbl_fix."`product`" ,$arr ," `product_commission_id` = '$product_commission_id' " );
        
        return true;
    }
    
}