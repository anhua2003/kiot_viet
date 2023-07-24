<?php
class holding_follow extends model{
    protected $class_name="holding_follow";
    protected $id;
    protected $client_id;
    protected $stock;
    protected $resistance_final;
    protected $support_final;
    protected $valuation_price;
    protected $is_hidden;
    protected $deleted;
    protected $created_at;
    
    public function add()
    {
        global $db;

        $arr['client_id']               = $this->get('client_id');
        $arr['stock']                   = $this->get('stock');
        $arr['is_hidden']               = $this->get('is_hidden')+0;
        $arr['deleted']                 = $this->get('deleted')+0;
        $arr['created_at']              = time();

        $db->record_insert($db->tbl_fix . $this->class_name, $arr);

        return $db->mysqli_insert_id();
    }
    public function filter()
    {
        global $db;

        $client_id=$this->get('client_id');
        $sql="SELECT hf.`stock`,hf.`id` hf_id,
              IFNULL(hf.`resistance_final`,sdb.`resistance_final`) hf_resistance_final,
              IFNULL(hf.`support_final`,sdb.`support_final`) hf_support_final,
              IFNULL(hf.`valuation_price`,sdb.`valuation_price`) hf_valuation_price,
              sdb.*
              FROM $db->tbl_fix$this->class_name `hf`
              INNER JOIN $db->tbl_fix`strategy_data_buy` `sdb` ON hf.`stock`=sdb.`ticker`
              WHERE client_id=$client_id
              ";
              
        $kq=$db->executeQuery_list($sql);

        return $kq;
    }
    public function edit()
    {
        global $db;
        $arr=array();
        $id = $this->get('id');
        if($this->get('resistance_final')!='')  $arr['resistance_final']        = $this->get('resistance_final');
        if($this->get('support_final')!='')     $arr['support_final']           = $this->get('support_final');
        if($this->get('valuation_price')!='')   $arr['valuation_price']         = $this->get('valuation_price');

        if(count($arr)>0){
            $db->record_update($db->tbl_fix . $this->class_name, $arr,"id=$id");
        }

        return true;
    }
}