<?php
class news_category extends model
{

    protected $class_name = 'news_category'; // danh mục tin tức
    protected $id;
    protected $name;
    protected $root_id;
    protected $level;
    protected $description;
    protected $priority;
    protected $meta_title;
    protected $meta_description;
    protected $meta_keyword;
    protected $type;
    protected $avatar;
    protected $icon;
    protected $background;
    protected $link_url;
    protected $is_hidden;
    protected $deleted;

    public function add()
    {
        global $db, $main;

        $arr['name']                     = $this->get('name');
        $arr['root_id']                  = $this->get('root_id');
        $arr['level']                    = $this->get('level');
        $arr['description']              = $this->get('description');
        $arr['priority']                 = $this->get('priority')+0;
        $arr['meta_title']               = $this->get('meta_title');
        $arr['meta_description']         = $this->get('meta_description');
        $arr['meta_keyword']             = $this->get('meta_keyword');
        $arr['type']                     = $this->get('type')+0;
        $arr['avatar']                   = $this->get('avatar');
        $arr['icon']                     = $this->get('icon');
        $arr['background']               = $this->get('background');
        $arr['link_url']                 = $main->convert_link_url($this->get('name'));
        $arr['is_hidden']                = $this->get('is_hidden') + 0;
        $arr['deleted']                  = $this->get('deleted') + 0;

        $db->record_insert($db->tbl_fix . $this->class_name, $arr);

        return $db->mysqli_insert_id();
    }

    public function update()
    {
        global $db, $main;

        $id                             = $this->get('id');

        $arr['name']                     = $this->get('name');
        $arr['root_id']                  = $this->get('root_id');
        $arr['description']              = $this->get('description');
        $arr['priority']                 = $this->get('priority')+0;
        $arr['meta_title']               = $this->get('meta_title');
        $arr['meta_description']         = $this->get('meta_description');
        $arr['meta_keyword']             = $this->get('meta_keyword');
        $arr['type']                     = $this->get('type')+0;
        $arr['avatar']                   = $this->get('avatar');
        $arr['icon']                     = $this->get('icon');
        $arr['background']               = $this->get('background');
        $arr['link_url']                 = $main->convert_link_url($this->get('name'));

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id' ");

        $this->update_level_branch();

        return true;
    }

    // filter tin tức theo loại (tin tức, album, videos) (tùngcode-07/07/2021)
    public function list_category()
    {
        global $db;

        $sql = "SELECT * FROM $db->tbl_fix`$this->class_name` WHERE `deleted` = 0 ORDER BY `priority` ASC, `id` DESC";
        $result = $db->executeQuery($sql);

        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['root_id'] > 0) {
                $this->set('id', $row['root_id']);
                $root = $this->get_detail();
                $row['root_name'] = $root['name'];
            } else {
                $row['root_name'] = "";
            }

            $row['avatar'] = explode(';', $row['avatar']);

            $kq[] = $row;
        }

        return $kq;
    }

    public function filter($keyword, $offset, $limit)
    { //list all danh mục
        global $db;

        if ($limit != '')
            $limit = " LIMIT $offset, $limit ";

        if ($keyword != '') {
            $keyword = " AND ( tb.`name` LIKE '%$keyword%' ) ";
        }

        $sql = "SELECT * 
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `deleted` = 0
                    $keyword
                    ORDER BY `priority`
                    $limit";

        $l = $db->executeQuery_list($sql);

        return $l;
    }

    public function filter_count($keyword)
    { //đếm tất cả danh mục
        global $db;

        if ($keyword != '') {
            $keyword = " AND ( tb.`name` LIKE '%$keyword%' ) ";
        }

        $sql = "SELECT COUNT(*) total
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `deleted` = 0
                    $keyword";

        $result = $db->executeQuery($sql, 1);

        return $result['total'] + 0;
    }

    public function list_all_position(&$kq)
    { //list all item in right position
        global $db;

        $root_id  = $this->get('root_id');
        $id  = $this->get('id');

        if ($id !== '') {
            $id = "AND `id` != '$id' ";
        }

        if ($root_id == '' || $root_id < 1) {

            $sql = "SELECT * 
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `deleted` = 0 
                    AND `root_id` = '0'
                    $id
                    ORDER BY `priority` DESC";

            $l = $db->executeQuery_list($sql);
        } else {

            $this->set('root_id', $root_id);
            $this->set('is_hidden', '');
            $l = $this->list_cat_by_root();
        }


        if (COUNT($l) > 0) {
            foreach ($l as $key => $value) {
                $kq[] = $value;
                $this->set('is_hidden', '');
                $this->set('root_id', $value['id']);
                $sList = $this->list_cat_by_root();
                if (COUNT($sList) > 0) {
                    $this->list_all_position($kq);
                }
            }
        }

        return true;
    }

    // list danh mục theo root_id
    public function list_cat_by_root($offset = '', $limit = '')
    {
        global $db;

        $hidden         = $this->get('is_hidden');
        $root_id        = $this->get('root_id');
        $level          = $this->get('level');
        $id             = $this->get('id');

        if ($id != '') {
            $id = "AND `id` != '$id' ";
        }

        if ($hidden !== '') {
            $hidden = "AND `is_hidden` = '$hidden' ";
        }

        if ($level != '') {
            $level = "AND `level` <= '$level' ";
        }

        if ($limit !== '') $limit = "LIMIT $offset, $limit ";

        $sql = "SELECT * 
                FROM $db->tbl_fix$this->class_name tb
                WHERE `deleted` = 0 
                AND `root_id` = '$root_id'
                $hidden
                $level
                $id
                ORDER BY `priority` DESC
                $limit";
                
        $r = $db->executeQuery_list($sql);

        return $r;
    }


    // filter option danh mục theo loại (tin tức, album, videos) (tùngcode-07/07/2021)
    public function opt_by_type()
    {
        global $db, $database;


        $sql = "SELECT `id`,`name` FROM $db->tbl_fix`$this->class_name` WHERE `deleted` = 0 ORDER BY id ASC";
        $result = $db->executeQuery($sql);
        $option = '';
        while ($row = mysqli_fetch_assoc($result)) {

            $option .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }

        return $option;
    }

    // function xóa tin tức (ẩn đi không hiển thị ở web và backoffice) (tùngcode-07/07/2021)
    public function delete_is_hidden()
    {
        global $db;

        $id                             = $this->get('id');

        $arr['deleted']                  = $this->get('deleted');

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id' OR `root_id` = '$id' ");

        return true;
    }

    // function ẩn tin tức (ẩn đi ở web nhưng backoffice vẫn có thể chỉnh sửa) (tùngcode-07/07/2021)
    public function hidden_category()
    {
        global $db;

        $id                                 = $this->get('id');
        $arr['is_hidden']                   = $this->get('is_hidden');

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id' OR `root_id` = '$id' ");

        return true;
    }

    // func xóa đi 1 nhánh danh mục
    public function delete_branch()
    {
        global $db;

        $id         = $this->get('id');
        $this->set('root_id', $id);
        $l = $this->list_cat_by_root(); //Lấy list con

        $arr['deleted']             = 1;
        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id' "); //Xóa cha

        $news = new news();
        $news->set('news_category_id', $id);
        $news->set('deleted', 1);
        $news->deleted_is_hidden_by_category();

        if (COUNT($l) > 0) { //Tìm và con
            foreach ($l as $key => $value) {
                $this->set('root_id', $value['id']);
                $sList = $this->list_cat_by_root();
                if (COUNT($sList) > 0) {
                    $this->delete_branch();
                } else {
                    $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '" . $value['id'] . "' "); //Xóa cha

                    $news->set('news_category_id', $value['id']);
                    $news->set('deleted', 1);
                    $news->deleted_is_hidden_by_category();
                }
            }
        }

        return true;
    }

    // func ẩn đi 1 danh mục 
    public function update_hidden_branch()
    {
        global $db;

        $id                    = $this->get('id');
        $arr['is_hidden']      = $this->get('is_hidden') != 1 ? 0 : 1;

        $this->set('root_id', $id);
        $this->set('is_hidden', '');
        $l = $this->list_cat_by_root(); //Lấy list con

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id' "); //Cập nhật nó

        $news = new news();
        $news->set('news_category_id', $id);
        $news->set('is_hidden', $arr['is_hidden']);
        $news->hidden_news_by_category();

        if (COUNT($l) > 0) { //Tìm và con
            foreach ($l as $key => $value) {
                $this->set('root_id', $value['id']);
                $this->set('is_hidden', '');
                $sList = $this->list_cat_by_root();
                if (COUNT($sList) > 0) {
                    $this->set('id', $value['id']);
                    $this->set('is_hidden', $arr['is_hidden']); //do hàm list_cat_by_parent không được set hidden nên phải set lại
                    $this->update_hidden_branch();
                } else {
                    $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '" . $value['id'] . "' "); //Cập nhật nó

                    $news->set('news_category_id', $value['id']);
                    $news->set('is_hidden', $arr['is_hidden']);
                    $news->hidden_news_by_category();
                }
            }
        }

        return true;
    }

    // func update_levl nhánh khi parent chuyển root_id
    public function update_level_branch()
    {
        global $db;

        $id                    = $this->get('id');
        $level                 = $this->get('level');

        $arr['level'] = $level;
        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '" . $id . "' "); //Cập nhật nó

        $this->set('root_id', $id);
        $this->set('is_hidden', '');
        $this->set('level', '');
        $this->set('id', '');
        $l = $this->list_cat_by_root();

        if (COUNT($l) > 0) { //Tìm và con
            foreach ($l as $key => $value) {
                    $this->set('id', $value['id']);
                    $this->set('level', $level);
                    $this->update_level_branch();
            }
        }

        return true;
    }
    // list danh mục cấp cha
    public function get_category()
    {
        global $db;

        $sql = "SELECT * 
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `deleted` = 0
                    AND `is_hidden` = 0
                    AND `root_id` = 0
                    ORDER BY `priority`";

        $l = $db->executeQuery_list($sql);

        return $l;
    }

    // list danh mục theo id cấp cha
    public function get_by_root_id()
    {
        global $db;

        $root_id = $this->get('root_id');

        $sql = "SELECT * 
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `deleted` = 0
                    AND `is_hidden` = 0
                    AND `root_id` = $root_id
                    ORDER BY `priority`";

        $l = $db->executeQuery_list($sql);

        return $l;
    }

    //Load menu to show
	public function load_cat_menu( $is_hidden ){
		global $db;

		$sqlHidden = '';
		if( $is_hidden != '' ){
			$sqlHidden = " AND `is_hidden` = '$is_hidden' ";
		}

		//Mục bán hàng
		$sql = "SELECT * FROM $db->tbl_fix`$this->class_name`
				WHERE `root_id` = '0'
                AND `deleted` = '0'
				$sqlHidden
				ORDER BY `priority` ASC";
		
		$r = $db->executeQuery( $sql );

		$arr = array();
		while( $row = mysqli_fetch_assoc($r) ){
			$row['subItems'] = $this->load_cat_menu_sub( $row['id'], $is_hidden );
			$arr[] = $row;
		}

		return $arr;
	}

    public function load_cat_menu_sub( $root_id, $is_hidden ){
		global $db;

		$sqlHidden = '';
		if( $is_hidden != '' ){
			$sqlHidden = " AND `is_hidden` = '$is_hidden' ";
		}

		//Mục bán hàng
		$sql = "SELECT * FROM $db->tbl_fix`$this->class_name`
				WHERE `root_id` = '$root_id'
                AND `deleted` = '0'
				$sqlHidden
				ORDER BY `priority` ASC";
		$r = $db->executeQuery( $sql );

		$arr = array();
		while( $row = mysqli_fetch_assoc($r) ){
			$row['subItems'] = $this->load_cat_menu_sub( $row['id'], $is_hidden );
			$arr[] 			 = $row;
		}

		return $arr;
	}

    public function get_by_keyword($keyword)
    { //list menu theo root_id
        global $db;

        if($keyword!='')$keyword="AND `name` LIKE '%$keyword%'";

        $sql = "SELECT * 
                FROM $db->tbl_fix$this->class_name tb
                WHERE `deleted` = 0
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
