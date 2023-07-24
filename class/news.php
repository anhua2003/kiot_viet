<?php
class news extends model
{

    protected $class_name = 'news'; // tin tức
    protected $id;
    protected $title;
    protected $short_description;
    protected $description;
    protected $news_category_id;
    protected $news_type_id;
    protected $news_group_id;  //nhóm tin tức =0 default, =1 nổi bật, =2 tiêu điểm
    protected $link;
    protected $link_url;
    protected $meta_title;
    protected $meta_description;
    protected $meta_keyword;
    protected $avatar;
    protected $image;
    protected $created_at;
    protected $is_hidden;
    protected $deleted;

    public function add()
    {
        global $db, $main;

        $arr['title']                    = $this->get('title');
        $arr['short_description']        = $this->get('short_description');
        $arr['description']              = $this->get('description');
        $arr['news_category_id']         = $this->get('news_category_id');
        $arr['news_type_id']             = $this->get('news_type_id');
        $arr['news_group_id']            = $this->get('news_group_id');
        $arr['link']                     = $this->get('link');
        $arr['link_url']                 = $main->convert_link_url($arr['title']);
        $arr['meta_title']               = $this->get('meta_title');
        $arr['meta_description']         = $this->get('meta_description');
        $arr['meta_keyword']             = $this->get('meta_keyword');
        $arr['avatar']                   = $this->get('avatar');
        $arr['image']                    = $this->get('image');
        $arr['created_at']               = time();
        $arr['is_hidden']                = $this->get('is_hidden') + 0;
        $arr['deleted']                  = 0;

        $db->record_insert($db->tbl_fix . $this->class_name, $arr);

        return $db->mysqli_insert_id();
    }

    public function update()
    {
        global $db;

        $id                             = $this->get('id');

        $arr['title']                    = $this->get('title');
        $arr['short_description']        = $this->get('short_description');
        $arr['description']              = $this->get('description');
        $arr['news_category_id']         = $this->get('news_category_id');
        $arr['news_type_id']             = $this->get('news_type_id');
        $arr['news_group_id']            = $this->get('news_group_id');
        $arr['link']                     = $this->get('link');
        $arr['link_url']                 = $this->get('link_url');
        $arr['meta_title']               = $this->get('meta_title');
        $arr['meta_description']         = $this->get('meta_description');
        $arr['meta_keyword']             = $this->get('meta_keyword');
        $arr['avatar']                   = $this->get('avatar');
        $arr['image']                    = $this->get('image');

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id' ");

        return true;
    }

    // list tất cả tin tức
    public function filter($keyword, $offset, $limit)
    {
        global $db;

        $news_category_id = $this->get('news_category_id');

        $news_category = ""; //nếu không có danh mục load tất cả tin tức
        if ($news_category_id != '') {
            $news_category = "AND `news_category_id` = $news_category_id";
        }

        if ($limit != '')
            $limit = " LIMIT $offset, $limit ";

        if ($keyword != '') {
            $keyword = " AND ( tb.`title` LIKE '%$keyword%' ) ";
        }

        $sql = "SELECT * 
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `deleted` = 0
                    AND `is_hidden` = 0
                    $news_category
                    $keyword
                    ORDER BY `id` DESC
                    $limit";

        $l = $db->executeQuery($sql);

        $kq = array();
        while ($row = mysqli_fetch_assoc($l)) {
            $row['icon'] = $this->create_icon($row['news_type_id']);
            $kq[] = $row;
        }

        return $kq;
    }

    public function filter_count($keyword)
    {
        global $db;

        $news_category_id = $this->get('news_category_id');

        $news_category = ""; //nếu không có danh mục load tất cả tin tức
        if ($news_category_id != '') {
            $news_category = "AND `news_category_id` = $news_category_id";
        }

        if ($keyword != '') {
            $keyword = " AND ( tb.`title` LIKE '%$keyword%' ) ";
        }

        $sql = "SELECT COUNT(*) total 
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `deleted` = 0
                    AND `is_hidden` = 0
                    $news_category
                    $keyword ";

        $result = $db->executeQuery($sql, 1);

        return $result['total'] + 0;
    }

    public function get_detail_by_id()
    {
        global $db;

        $news_category = new news_category();

        $id = $this->get('id');

        $sql = "SELECT *
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `id` = $id";

        $d = $db->executeQuery($sql, 1);

        if (isset($d['id'])) {
            if ($d['image'] != '') {
                $d['image'] = explode(';', $d['image']);
            }
            $news_category->set('id', $d['news_category_id']);
            $cat_link = $news_category->get_detail();
            if (isset($cat_link['id'])) {
                $d['cat_link'] = $cat_link['link_url'] . '-cn' . $cat_link['id'];
                $d['cat_name'] = $cat_link['name'];
            } else {
                $d['cat_link'] = '';
                $d['cat_name'] = '';
            }
        }

        return $d;
    }

    public function get_news_suggest($type)
    {
        global $db;

        $id = $this->get('id');

        $sql = "SELECT *
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `deleted` = 0
                    AND `is_hidden` = 0
                    AND `news_group_id` = $type
                    AND `id` <> $id
                    ORDER BY `id` DESC
                    LIMIT 0, 32";

        $l = $db->executeQuery_list($sql);

        return $l;
    }

    // filter tin tức theo loại (tin tức, album, videos) (tùngcode-07/07/2021)
    public function list_by_type()
    {
        global $db;

        $news_category = new news_category();

        $news_type_id = $this->get('news_type_id');

        $sql = "SELECT * FROM $db->tbl_fix`$this->class_name` WHERE `news_type_id` = '$news_type_id' AND `deleted` = 0 ORDER BY `id` DESC";
        $result = $db->executeQuery($sql);

        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['news_category_id'] > 0) {
                $news_category->set('id', $row['news_category_id']);
                $category = $news_category->get_detail();
                $row['category_name'] = $category['name'];
            } else {
                $row['category_name'] = "";
            }

            $row['avatar'] = explode(';', $row['avatar']);

            $kq[] = $row;
        }

        return $kq;
    }

    // function xóa tin tức (ẩn đi không hiển thị ở web và backoffice) (tùngcode-07/07/2021)
    public function deleted_is_hidden()
    {
        global $db;

        $id                             = $this->get('id');

        $arr['deleted']                  = time();

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id'");

        return true;
    }

    // function ẩn tin tức (ẩn đi ở web nhưng backoffice vẫn có thể chỉnh sửa) (tùngcode-07/07/2021)
    public function hidden_news()
    {
        global $db;

        $id                                 = $this->get('id');
        $arr['is_hidden']                   = $this->get('is_hidden');

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `id` = '$id'");

        return true;
    }

    // function xóa tin tức (ẩn đi không hiển thị ở web và backoffice) theo danh mục (tùngcode-07/07/2021)
    public function deleted_is_hidden_by_category()
    {
        global $db;

        $news_category_id       = $this->get('news_category_id');

        $arr['deleted']          = time();

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `news_category_id` = '$news_category_id'");

        return true;
    }

    // function ẩn tin tức (ẩn đi ở web nhưng backoffice vẫn có thể chỉnh sửa) theo danh mục (tùngcode-07/07/2021)
    public function hidden_news_by_category()
    {
        global $db;

        $news_category_id                   = $this->get('news_category_id');
        $arr['is_hidden']                   = $this->get('is_hidden');

        $db->record_update($db->tbl_fix . $this->class_name, $arr, " `news_category_id` = '$news_category_id'");

        return true;
    }

    public function get_news_by_category_id()
    {
        global $db;

        $id                 = $this->get('id');
        $news_category_id   = $this->get('news_category_id');

        $sql = "SELECT *
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `deleted` = 0
                    AND `is_hidden` = 0
                    AND `news_category_id` = $news_category_id
                    AND `id` <> $id
                    ORDER BY `id` DESC
                    LIMIT 0, 32";

        $result = $db->executeQuery($sql);

        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $row['icon'] = $this->create_icon($row['news_type_id']);
            $kq[] = $row;
        }

        return $kq;
    }

    public function create_icon($type)
    {
        $icon = '';

        if ($type == 1) {
            $icon = '';
        } else if ($type == 2) {
            $icon = '<i class="fa fa-picture-o" aria-hidden="true"></i>';
        } else {
            $icon = '<i class="fa fa-video-camera" aria-hidden="true"></i>';
        }
        return $icon;
    }

    // list tất cả tin tức
    public function filter_manager($keyword, $offset, $limit)
    {
        global $db, $main;

        $news_category_id = $this->get('news_category_id');

        $news_category = ""; //nếu không có danh mục load tất cả tin tức
        if ($news_category_id != '') {
            $news_category = "AND `news_category_id` = $news_category_id";
        }

        if ($limit != '')
            $limit = " LIMIT $offset, $limit ";

        if ($keyword != '') {
            $keyword = " AND ( tb.`title` LIKE '%$keyword%' ) ";
        }

        $sql = "SELECT * 
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `deleted` = 0
                    $news_category
                    $keyword
                    ORDER BY `id` DESC
                    $limit";

        $l = $db->executeQuery($sql);

        $kq = array();
        while ($row = mysqli_fetch_assoc($l)) {
            $row['icon'] = $this->create_icon($row['news_type_id']);
            $row['link_news'] = $main->convert_link_url($row['title']);
            $kq[] = $row;
        }

        return $kq;
    }

    public function filter_manager_count($keyword)
    {
        global $db;

        $news_category_id = $this->get('news_category_id');

        $news_category = ""; //nếu không có danh mục load tất cả tin tức
        if ($news_category_id != '') {
            $news_category = "AND `news_category_id` = $news_category_id";
        }

        if ($keyword != '') {
            $keyword = " AND ( tb.`title` LIKE '%$keyword%' ) ";
        }

        $sql = "SELECT COUNT(*) total 
                    FROM $db->tbl_fix$this->class_name tb
                    WHERE `deleted` = 0
                    $news_category
                    $keyword ";

        $result = $db->executeQuery($sql, 1);

        return $result['total'] + 0;
    }

}
