<?php
class manager_image extends model
{

    protected $class_name = 'manager_image';
    protected $id;
    protected $name;
    protected $link;    //đường dẫn
    protected $description; //mô tả
    protected $position;    //vị trí hiển thị trong trang
    protected $page;    //trang hiển thị
    protected $type;    //ảnh là silde, banner,...
    protected $image;
    protected $is_hidden;
    protected $priority;

    public function add()
    {
        global $db;

        $arr['name']                = $this->get('name').'';
        $arr['link']                = $this->get('link').'';
        $arr['description']         = $this->get('description').'';
        $arr['position']            = $this->get('position');
        $arr['page']                = $this->get('page');
        $arr['image']               = $this->get('image');
        $arr['type']                = $this->get('type');
        $arr['is_hidden']           = $this->get('is_hidden')+0;
        $arr['priority']            = $this->get('priority');

        $db->record_insert($db->tbl_fix . $this->class_name, $arr);

        return $db->mysqli_insert_id();
    }

    public function update()
    {
        global $db;

        $id = $this->get('id');

        $arr['name']                = $this->get('name').'';
        $arr['link']                = $this->get('link').'';
        $arr['description']         = $this->get('description').'';
        $arr['position']            = $this->get('position');
        $arr['page']                = $this->get('page');
        $arr['image']               = $this->get('image');
        $arr['type']                = $this->get('type');
        $arr['priority']            = $this->get('priority');

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id' ");

        return true;
    }

    public function update_hidden()
    {
        global $db;

        $id = $this->get('id');
        $arr['is_hidden']           = $this->get('is_hidden');

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id' ");

        return true;
    }

    public function filter($keyword)
    {
        global $db;

        $position        = $this->get('position');
        $page            = $this->get('page');
        $type            = $this->get('type');
        $is_hidden       = $this->get('is_hidden');

        if($position!='') $position="AND `position` = '$position'";
        if($page!='') $page="AND `page` = '$page'";
        if($type!='') $type="AND `type` = '$type'";
        if($is_hidden!='') $is_hidden="AND `is_hidden` = '$is_hidden'";
        if($keyword!='') $keyword="AND `name` LIKE '%$keyword%'";

		$sql = "SELECT * FROM $db->tbl_fix`$this->class_name` 
                WHERE 1
                $is_hidden
                $position
                $page
                $type
                $keyword
                ORDER BY `priority` ASC";

		$result = $db->executeQuery_list($sql);
		return $result;
    }

}
