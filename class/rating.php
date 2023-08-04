<?php
    class rating extends model{
        protected $class_name = 'comment';

        function insert_rating()
        {
            global $db;
            $date = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
            $getdate = $date->format('Y-m-d H:i:s');
            $product_id = $this->get('product_id');
            $order_id = $this->get('order_id');
            $arr['user_id'] = $this->get('user_id');
            $arr['product_id'] = $this->get('product_id');
            $arr['contents'] = $this->get('content');
            $arr['rating'] = $this->get('rating');
            $arr['imgs'] = $this->get('img');
            $arr['_date'] = $getdate;
            $db->record_insert($db->tbl_fix.'`comment`', $arr);
            $c['c_rate'] = 1;
            $db->record_update($db->tbl_fix.'`invoice_detail`', $c, "`id_product` = '$product_id' AND `order_id` = '$order_id'");
            return true;
        }

        function getRating($id)
        {
            global $db;
            $sql = "SELECT a.*, b.user_name, b.avatar FROM $db->tbl_fix$this->class_name a, $db->tbl_fix`user` b WHERE a.product_id = '$id' AND a.user_id = b.id ORDER BY a._date DESC";
            $result = $db->executeQuery($sql);
            $response = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $row['imgArray'] = explode(",", $row['imgs']);
                $row['formatTime'] = [];
                $formatTimeAgo = new formatTimeAgo();
                $row['formatTime'] = $formatTimeAgo->formatTimeAgo($row['_date']);
                $response[] = $row;
            }
            $arr = [];
            for($i = 1; $i<=5; $i++)
            {
                $sql1 = "SELECT count(rating) as rate FROM $db->tbl_fix$this->class_name WHERE rating = '$i' AND product_id = '$id'";
                $rate = $db->executeQuery($sql1,1);
                $arr[$i.'sao'] = $rate['rate'];
            }

            $sql2 = "SELECT sum(rating) as total_rating FROM $db->tbl_fix$this->class_name WHERE product_id = '$id'";
            $kq = $db->executeQuery($sql2,1);
            if(count($response) == 0)
            {
                $average = 0;
            } else {
                $average = $kq['total_rating']/count($response);
            }
            return [$response, $arr, $average];
        }
    }
?>