<?php
    class category extends model{
        protected $class_name = 'category_product';

        function getCategory() {
            global $db;
            $sql = "SELECT * FROM $db->tbl_fix$this->class_name";
            $result = $db->executeQuery($sql);
            $kq = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $kq[] = $row;
            }
            return $kq;
        }
    }
?>