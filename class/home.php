<?php
class home extends model
{
    protected $class_name = 'product';
    protected $join_name = 'category_product';
    function getProduct($id)
    {
        global $db, $domain;
        $sql = "SELECT a.*, b.category_name FROM $db->tbl_fix $this->class_name a, $db->tbl_fix$this->join_name b where a.category = $id and b.id = a.category";
        $l = $db->executeQuery($sql);
        $kq = array();
        while ($row = mysqli_fetch_assoc($l)) {
            $img = explode(",", $row['img']);
            $row['img'] = [];
            foreach($img as $item)
            {
                $row['img'][] = 'http://'.$domain.'/public/img/products/'.$row['category_name'].'/'.$row['id_product'].'/'.$item;
            }
            $kq[] = $row;
        }

        return $kq;
    }

    function getDetailProduct($id)
    {
        global $db, $domain;
        $sql = "SELECT a.*, b.category_name FROM $db->tbl_fix $this->class_name a, $db->tbl_fix$this->join_name b where a.id_product = '$id' and a.category = b.id";
        $result = $db->executeQuery($sql,1);
        $kq = [];
        $img_arr = explode(",", $result['img']);
        foreach($img_arr as $item)
        {
            $kq[] = $domain.'/public/img/products/'.$result['category_name'].'/'.$result['id_product'].'/'.$item;
        }
        $result['img'] = $kq;
        return $result;
    }
}
?>