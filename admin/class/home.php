<?php
    class home extends model{
        protected $class_name = 'admin';
        function sign() 
        {
            global $db;
            $email = $this->get('email');
            $password = md5($this->get('password'));
            $sql = "SELECT * FROM $db->tbl_fix$this->class_name WHERE email = '$email' AND password = '$password'";
            $result = $db->executeQuery($sql,1);
            if($result != null)
            {
                return $result;
            } else {
                return false;
            }
        }
        
        function AccountInfo($id) 
        {
            global $db;
            $sql = "SELECT * FROM $db->tbl_fix$this->class_name WHERE id = '$id'";
            $result = $db->executeQuery($sql,1);
            return $result;
        }
    }
?>