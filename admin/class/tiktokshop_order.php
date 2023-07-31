<?php
    class tiktokshop_order extends model {
        function insertDb($item) {
            $date = new DateTime('now');
            $year = $date->format('Y');
            $id_shop = 1;// chi nhánh shop
            $class_name = 'order_'.$id_shop.'_'.$year;
        }
    }
?>