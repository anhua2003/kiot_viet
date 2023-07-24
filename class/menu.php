<?php
class menu extends model
{

    protected $class_name = 'menu'; // danh mục tin tức
    protected $id;
    protected $name;
    protected $type_link;
    protected $link;
    protected $description;
    protected $icon;
    protected $root_id; //id cấp cha
    protected $level; //cấp bậc thuộc menu cha
    protected $type; // loại menu =0 menu trên, =1 menu dưới
    protected $open_page; // hình thức mở trang =0 mở trang hiện tại, =1 mở trang mới
    protected $priority;
    protected $is_hidden;
    protected $delete;

    public function add() //thêm mới
    {
        global $db;

        $arr['name']                     = $this->get('name');
        $arr['type_link']                = $this->get('type_link');
        $arr['link']                     = $this->get('link');
        $arr['description']              = $this->get('description');
        $arr['icon']                     = $this->get('icon');
        $arr['root_id']                  = $this->get('root_id');
        $arr['level']                    = $this->get('level');
        $arr['type']                     = $this->get('type');
        $arr['open_page']                = $this->get('open_page');
        $arr['priority']                 = $this->get('priority');
        $arr['is_hidden']                = $this->get('is_hidden') + 0;
        $arr['delete']                   = $this->get('delete') + 0;

        $db->record_insert($db->tbl_fix . $this->class_name, $arr);

        return $db->mysqli_insert_id();
    }

    public function update() //cập nhật
    {
        global $db;

        $id                             = $this->get('id');

        $arr['name']                     = $this->get('name');
        $arr['type_link']                = $this->get('type_link');
        $arr['link']                     = $this->get('link');
        $arr['description']              = $this->get('description');
        $arr['icon']                     = $this->get('icon');
        $arr['root_id']                  = $this->get('root_id');
        $arr['level']                    = $this->get('level');
        $arr['type']                     = $this->get('type');
        $arr['open_page']                = $this->get('open_page');
        $arr['priority']                 = $this->get('priority');
        $arr['is_hidden']                = $this->get('is_hidden') + 0;
        $arr['delete']                   = $this->get('delete') + 0;

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id' ");

        return true;
    }

    public function list_by_type($keyword='', $offset='', $limit='')
    { //list all menu theo type
        global $db;
        $tree = array();

        $type     = $this->get('type');
        $root_id  = $this->get('root_id');

        if ($root_id == '' || $root_id < 1) {

            $sql = "SELECT * 
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `delete` = 0 
                    AND `is_hidden` = 0
                    AND `root_id` = '0'
                    AND `type` = $type
                    ORDER BY `priority` ASC";
            $l = $db->executeQuery_list($sql);
        } else {

            $this->set('root_id', $root_id);
            $this->set('is_hidden', 0);
            $l = $this->list_by_root();
        }


        if (COUNT($l) > 0) {
            foreach ($l as $key => $value) {
                $this->set('is_hidden', 0);
                $this->set('root_id', $value['id']);
                $sList = $this->list_by_root();
                if (COUNT($sList) > 0) {
                    $value['root_menu'] = $this->list_by_type();
                    $tree[] = $value;
                }else{
                    $value['root_menu'] = $sList;
                    $tree[] = $value;
                }
                
            }
        }
        return $tree;
    }

    public function list_by_type_count($keyword)
    { //đếm tất cả menu theo type
        global $db;

        $type     = $this->get('type');

        if ($keyword != '') {
            $keyword = " AND ( tb.`name` LIKE '%$keyword%' ) ";
        }

        $sql = "SELECT COUNT(*) total
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `delete` = 0
                    AND `type` = $type
                    $keyword";
        $result = $db->executeQuery($sql, 1);

        return $result['total'] + 0;
    }
    
    public function list_all_position(&$kq)
    { //list all menu tạo option khi tạo danh mục
        global $db;

        $type     = $this->get('type');
        $root_id  = $this->get('root_id');

        if ($root_id == '' || $root_id < 1) {

            $sql = "SELECT * 
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `delete` = 0 
                    AND `root_id` = '0'
                    AND `type` = $type
                    ORDER BY `priority` DESC";

            $l = $db->executeQuery_list($sql);
        } else {

            $this->set('root_id', $root_id);
            $this->set('is_hidden', 0);
            $l = $this->list_by_root();
        }


        if (COUNT($l) > 0) {
            foreach ($l as $key => $value) {
                $kq[] = $value;
                $this->set('is_hidden', 0);
                $this->set('root_id', $value['id']);
                $sList = $this->list_by_root();
                if (COUNT($sList) > 0) {
                    $this->list_all_position($kq);
                }
            }
        }

        return true;
    }

    public function list_by_root($offset = '', $limit = '')
    { //list menu theo root_id
        global $db;

        $hidden         = $this->get('is_hidden');
        $root_id        = $this->get('root_id');

        if ($hidden !== '') {
            $hidden = "AND `is_hidden` = '$hidden' ";
        }

        if ($limit !== '') $limit = "LIMIT $offset, $limit ";

        $sql = "SELECT * 
                FROM $db->tbl_fix$this->class_name tb
                WHERE `delete` = 0 
                AND `root_id` = '$root_id'
                $hidden
                ORDER BY `priority` ASC
                $limit";
        // echo $sql;
        // exit();
        $r = $db->executeQuery_list($sql);

        return $r;
    }
    public function list_menu_header_home()
    { //list menu theo root_id
        global $db;

        $sql = "SELECT * 
                FROM $db->tbl_fix$this->class_name tb
                WHERE `delete` = 0 
                AND `root_id` = 0
                AND `is_hidden` = 0
                ORDER BY `priority` ASC
                ";
        // echo $sql;
        // exit();
        $r = $db->executeQuery_list($sql);

        return $r;
    }

    public function delete_branch()
    { //xóa menu theo 1 nhánh
        global $db;

        $id         = $this->get('id');
        $this->set('root_id', $id);
        $l = $this->list_by_root(); //Lấy list con

        $arr['delete']             = 1;
        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id' "); //Xóa cha

        if (COUNT($l) > 0) { //Tìm và con
            foreach ($l as $key => $value) {
                $this->set('root_id', $value['id']);
                $sList = $this->list_by_root();
                if (COUNT($sList) > 0) {
                    $this->delete_branch();
                } else {
                    $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '" . $value['id'] . "' "); //Xóa cha
                }
            }
        }

        return true;
    }

    public function update_hidden_branch()
    { //ẩn menu theo 1 nhánh
        global $db;

        $id                    = $this->get('id');
        $arr['is_hidden']      = $this->get('is_hidden') != 1 ? 0 : 1;

        $this->set('root_id', $id);
        $this->set('is_hidden', '');
        $l = $this->list_by_root(); //Lấy list con

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id' "); //Cập nhật nó

        if (COUNT($l) > 0) { //Tìm và con
            foreach ($l as $key => $value) {
                $this->set('root_id', $value['id']);
                $this->set('is_hidden', '');
                $sList = $this->list_by_root();
                if (COUNT($sList) > 0) {
                    $this->set('id', $value['id']);
                    $this->set('is_hidden', $arr['is_hidden']); //do hàm list_cat_by_parent không được set hidden nên phải set lại
                    $this->update_hidden_branch();
                } else {
                    $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '" . $value['id'] . "' "); //Cập nhật nó
                }
            }
        }

        return true;
    }

    public function get_by_keyword($keyword)
    { //list menu theo root_id
        global $db;

        if($keyword!='')$keyword="AND `name` LIKE '%$keyword%'";

        $sql = "SELECT * 
                FROM $db->tbl_fix$this->class_name tb
                WHERE `delete` = 0
                AND `is_hidden` = 0
                $keyword
                ORDER BY `priority` ASC
                ";
        // echo $sql;
        // exit();
        $r = $db->executeQuery_list($sql);

        return $r;
    }

}
