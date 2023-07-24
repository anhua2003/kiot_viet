<?php
    class wishlist extends model{
        protected $class_name = 'wishlist';
        function getMyWishlist($user_id)
        {
            global $db,$domain;
            $sql = "SELECT a.*, b.name, b.price, b.img, c.category_name FROM $db->tbl_fix$this->class_name a, $db->tbl_fix`product` b, $db->tbl_fix`category_product` c WHERE a.id_product = b.id_product AND a.user_id = '$user_id' AND c.id = b.category";
            $result = $db->executeQuery($sql);
            $kq = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $img = explode(",", $row['img']);
                $row['img'] = [];
                foreach ($img as $item) {
                    $row['img'][] = $domain . '/public/img/products/' . $row['category_name'] . '/' . $row['id_product'] . '/' . $item;
                }
                $kq[] = $row;
            }
            return $kq;
        }
    }
?>