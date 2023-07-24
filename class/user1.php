<?php
    class user1 extends model{
        protected $class_name = 'user';
        private $username;
        private $email;
        private $password;

        function setUsername($username) {
            $this->username = $username;
        }

        function setEmail($email) {
            $this->email = $email;
        }

        function setPassword($password) {
            $this->password = $password;
        }

        function getUsername() {
            return $this->username;
        }

        function getEmail() {
            return $this->email;
        }

        function getPassword() {
            return $this->password;
        }

        function add_account() {
            global $db;
            
            $arr['id'] = null;
            $arr['user_name'] = $this->getUsername();
            $arr['email'] = $this->getEmail();
            $password = $this->getPassword();
            $md5Pass = md5($password);
            $arr['password'] = $md5Pass;
            $kq = $db->record_insert($db->tbl_fix.'`user`', $arr);
            return $kq;
        }

        function login() {
            global $db;

            $email = $this->getEmail();
            $password = md5($this->getPassword());
            $sql = "SELECT * FROM $db->tbl_fix$this->class_name WHERE email = '$email' AND password = '$password'";
            $kq = $db->executeQuery($sql,1);
            if($kq == null)
            {
                return false;
            } else {
                return $kq;
            }
        }

        function checkEmail() {
            global $db;

            $email = $this->getEmail();
            $sql = "SELECT * FROM $db->tbl_fix$this->class_name WHERE email = '$email'";
            $kq = $db->executeQuery($sql, 1);
            if($kq == null)
            {
                return false;
            } else {
                return true;
            }
        }

        function saveNewPassword($newpass)
        {
            global $db;
            $email = $this->getEmail();
            $newPassword = md5($newpass);
            $arr['password'] = $newPassword;
            $db->record_update($db->tbl_fix."`user`", $arr, "`email` = '$email'");
            return true;
        }

        function getInfoAccount($id)
        {
            global $db;
            $sql = "SELECT * FROM $db->tbl_fix$this->class_name WHERE id = '$id'";
            $result = $db->executeQuery($sql,1);
            return $result;
        }

        function update_avatar($avatar_name, $id)
        {
            global $db;
            $arr['avatar'] = $avatar_name;
            $db->record_update($db->tbl_fix.'`user`', $arr, "`id` = '$id'");
            return true;
        }

        function update_profile($id)
        {
            global $db;
            $arr['user_name'] = $this->get('user_name');
            $arr['address'] = $this->get('address');
            $arr['phone'] = $this->get('phone');
            $db->record_update($db->tbl_fix.'`user`', $arr, "`id` = '$id'");
            return true;
        }

        function getOrder_id($id)
        {
            global $db;
            $sql = "SELECT a.*, b.status as status_name FROM $db->tbl_fix`invoice` a, $db->tbl_fix`status_order` b WHERE a.user_id = '$id' AND a.status = b.id";
            $result = $db->executeQuery_list($sql);
            return $result;
        }

        function check_wishlist($product_id, $id)
        {
            global $db;
            $sql = "SELECT * FROM $db->tbl_fix`wishlist` WHERE user_id = '$id' and id_product = '$product_id'";
            $result = $db->executeQuery($sql, 1);
            if($result == null)
            {
                return true;
            } else {
                return false;
            }
        }

        function insert_wishlist($product_id, $id)
        {
            global $db;
            $arr['user_id'] = $id;
            $arr['id_product'] = $product_id;
            $db->record_insert($db->tbl_fix.'`wishlist`', $arr);
            return true;
        }
        
        function get_wishlist($user_id)
        {
            global $db;
            $sql = "SELECT * FROM $db->tbl_fix`wishlist` WHERE user_id = '$user_id'";
            $result = $db->executeQuery_list($sql);
            return $result;
        }

        function delete_wishlist($product_id, $id)
        {
            global $db;
            $db->record_delete($db->tbl_fix.'`wishlist`', "id_product = '$product_id' AND user_id = '$id'");
            return true;
        }

        function get_detail_invoice($order_id)
        {
            global $db;
            $sql = "SELECT a.*, b.*, c.status FROM $db->tbl_fix`invoice_detail` a, $db->tbl_fix`bill_information` b, $db->tbl_fix`invoice` c WHERE a.order_id = '$order_id' AND a.order_id = b.order_id AND a.order_id = c.order_id";
            $result = $db->executeQuery($sql);
            $kq = [];
            $sql2 = "SELECT total FROM $db->tbl_fix`invoice` WHERE order_id = '$order_id'";
            $total = $db->executeQuery($sql2,1);
            while($row = mysqli_fetch_assoc($result))
            {
                $row['unique_txt'] = '';
                if($row['unique_prop'] != '')
                {
                    $unique = explode("-", $row['unique_prop']);
                    foreach ($unique as $item)
                    {
                        $sql1 = "SELECT properties_p FROM $db->tbl_fix`properties_product` WHERE unique_id = '$item'";
                        $uni = $db->executeQuery($sql1,1);
                        $row['unique_txt'] .= '-'.$uni['properties_p'];
                        $row['unique_txt'] = ltrim($row['unique_txt'], '-');
                    }
                }
                $kq[] = $row;
            }
            return [$kq,$total];
        }

        function checkPass($old_pass, $id)
        {
            global $db;
            $old_pass = md5($old_pass);
            $sql = "SELECT * FROM $db->tbl_fix$this->class_name WHERE id = '$id' AND password = '$old_pass'";
            $result = $db->executeQuery($sql, 1);
            if($result == null)
            {
                return false;
            } else {
                return true;
            }
        }

        function updatePassword($new_pass, $id)
        {
            global $db;
            $arr['password']  = md5($new_pass);
            $db->record_update($db->tbl_fix.'`user`', $arr, "`id` = '$id'");
            return true;
        }

        function contact($name, $email, $message)
        {
            global $db;
            $arr['name'] = $name;
            $arr['email'] = $email;
            $arr['message'] = $message;
            $db->record_insert($db->tbl_fix.'`contact`',$arr);
            return true;
        }
    }
?>