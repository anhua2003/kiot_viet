<?php
    class news1 extends model{
        protected $class_name = 'news1';
         
        function get_news($limit) {
            global $db;
            $sql = "SELECT * FROM $db->tbl_fix$this->class_name LIMIT $limit";
            $result = $db->executeQuery_list($sql);
            return $result;
        }

        function get_news_all() {
            global $db;
            $sql = "SELECT * FROM $db->tbl_fix$this->class_name";
            $result = $db->executeQuery_list($sql);
            return $result;
        }

        function get_news_detail($id)
        {
            global $db;
            $sql = "SELECT * FROM $db->tbl_fix$this->class_name WHERE id = '$id'";
            $result = $db->executeQuery($sql,1);
            return $result;
        }

        function get_other_news($id)
        {
            global $db;
            $sql = "SELECT * FROM $db->tbl_fix$this->class_name WHERE id != '$id'";
            $result = $db->executeQuery_list($sql);
            return $result;
        }

        function update_view($id)
        {
            global $db;
            $sql = "SELECT views FROM $db->tbl_fix$this->class_name WHERE id = '$id'";
            $views = $db->executeQuery($sql,1);
            $arr['views'] = $views['views'] + 1;
            $db->record_update($db->tbl_fix.$this->class_name, $arr, "`id` = '$id'");
            return true;
        }

        function comment_post($id, $content, $user_id)
        {
            global $db;
            $date = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
            $_date = $date->format("Y-m-d H:i:s");
            $arr['id_post'] = $id;
            $arr['user_id'] = $user_id;
            $arr['content'] = $content;
            $arr['num_like'] = 0;
            $arr['_date'] = $_date;
            $db->record_insert($db->tbl_fix.'`news_comment`', $arr);
            return true;
        }

        function get_post_comment($id_post, $limit)
        {
            global $db;
            $sql = "SELECT a.*, b.user_name, b.avatar FROM $db->tbl_fix`news_comment` a, $db->tbl_fix`user` b WHERE a.id_post = '$id_post' AND a.user_id = b.id ORDER BY a._date DESC LIMIT $limit";
            $result = $db->executeQuery($sql);
            $kq = [];
            while ($row = mysqli_fetch_assoc($result))
            {
                $formatTimeAgo = new formatTimeAgo();
                $row['formatTime'] = $formatTimeAgo->formatTimeAgo($row['_date']);
                $kq[] = $row;
            }
            return $kq;
        }

        function get_all_post_comment($id_post)
        {
            global $db;
            $sql = "SELECT * FROM $db->tbl_fix`news_comment` WHERE id_post = '$id_post'";
            $result = $db->executeQuery_list($sql);
            return $result;
        }
    }
?>