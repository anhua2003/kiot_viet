<?php
    class cart extends model{
        protected $invoice = 'invoice';
        function create_bill() 
        {
            global $db;
            $order_id = rand(0,9999);
            $arr['user_id'] = $this->get('user_id');
            $arr['order_id'] = $order_id;
            $arr['total'] = $this->get('total');
            $date = new DateTime('now');
            $arr['date_buy'] = $date->format('Y-m-d');
            $arr['status'] = 1;
            $db->record_insert($db->tbl_fix.'`invoice`', $arr);
            return $order_id;
        }

        function insert_information()
        {
            global $db;
            $order_id = $this->create_bill();
            $arr['order_id'] = $order_id;
            $arr['name'] = $this->get('name');
            $arr['email'] = $this->get('email');
            $arr['address'] = $this->get('address');
            $arr['city'] = $this->get('city');
            $arr['country'] = $this->get('country');
            $arr['phone'] = $this->get('phone');
            $db->record_insert($db->tbl_fix.'`bill_information`', $arr);
            $this->insert_order_detail($order_id);
            return true;
        }

        function insert_order_detail($order_id)
        {
            global $db;
            $array = $this->get('array');
            foreach ($array as $item)
            {
                $item_array = json_decode($item, true);
                $arr['order_id'] = $order_id;
                $arr['id_product'] = $item_array['product_id'];
                $arr['name_product'] = $item_array['title'];
                $arr['price'] = $item_array['price']*(100-$item_array['decrement'])/100;
                $arr['quantity'] = $item_array['quantity'];
                $unique_prop = "";
                foreach ($item_array['prop_id'] as $prop) {
                    $value_parts = explode("-", $prop['value']);
                    $unique_prop .= $value_parts[0] . "-";
                }

                $unique_prop = rtrim($unique_prop, "-");
                $arr['unique_prop'] = $unique_prop;
                $db->record_insert($db->tbl_fix.'`invoice_detail`', $arr);
            }
        }
    }