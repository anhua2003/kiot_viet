<?php
class product extends model
{
    protected $class_name = 'product';
    protected $join_name = 'category_product';

    function getAllProduct()
    {
        global $db, $domain;
        $sql = "SELECT a.*, b.category_name FROM $db->tbl_fix$this->class_name a, $db->tbl_fix$this->join_name b where a.category = b.id ORDER BY a.id";
        $result = $db->executeQuery($sql);
        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $img = explode(",", $row['img']);
            $row['img'] = [];
            foreach ($img as $item) {
                $row['img'][] = $domain . '/public/img/products/' . $row['category_name'] . '/' . $row['id_product'] . '/' . $item;
            }
            $kq[] = $row;
        }

        return $kq;
    }
    
    

    function getAllProductPage($limit)
    {
        global $db, $domain;
        $sql = "SELECT a.*, b.category_name FROM $db->tbl_fix$this->class_name a, $db->tbl_fix$this->join_name b where a.category = b.id LIMIT 0, $limit";
        $result = $db->executeQuery($sql);
        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $img = explode(",", $row['img']);
            $row['img'] = [];
            foreach ($img as $item) {
                $row['img'][] = $domain . '/public/img/products/' . $row['category_name'] . '/' . $row['id_product'] . '/' . $item;
            }
            $kq[] = $row;
        }

        return $kq;
    }

    function filterProduct($category_list)
    {
        global $db, $domain;
        $sql = "SELECT a.*, b.category_name FROM $db->tbl_fix$this->class_name a, $db->tbl_fix$this->join_name b where a.category = b.id and a.category in ($category_list)";
        $result = $db->executeQuery($sql);
        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $img = explode(",", $row['img']);
            $row['img'] = [];
            foreach ($img as $item) {
                $row['img'][] = $domain . '/public/img/products/' . $row['category_name'] . '/' . $row['id_product'] . '/' . $item;
            }
            $kq[] = $row;
        }

        return $kq;
    }

    function paginationProduct($page, $limit)
    {
        global $db,$domain;
        $start = ($page-1)*$limit;
        $sql = "SELECT a.*, b.category_name FROM $db->tbl_fix$this->class_name a, $db->tbl_fix$this->join_name b where a.category = b.id LIMIT $start, $limit";
        $result = $db->executeQuery($sql);
        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $img = explode(",", $row['img']);
            $row['img'] = [];
            foreach ($img as $item) {
                $row['img'][] = $domain . '/public/img/products/' . $row['category_name'] . '/' . $row['id_product'] . '/' . $item;
            }
            $kq[] = $row;
        }

        return $kq;
    }

    function paginationProduct_search($page, $limit, $key)
    {
        global $db,$domain;
        $start = ($page-1)*$limit;
        $sql = "SELECT a.*, b.category_name FROM $db->tbl_fix$this->class_name a, $db->tbl_fix$this->join_name b where a.category = b.id and a.name LIKE '%$key%' LIMIT $start, $limit";
        $result = $db->executeQuery($sql);
        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $img = explode(",", $row['img']);
            $row['img'] = [];
            foreach ($img as $item) {
                $row['img'][] = $domain . '/public/img/products/' . $row['category_name'] . '/' . $row['id_product'] . '/' . $item;
            }
            $kq[] = $row;
        }

        return $kq;
    }

    function getProperties($id)
    {
        global $db;
        $sql = "SELECT DISTINCT id_properties from $db->tbl_fix`properties_product` where id_product = '$id'";
        $result = $db->executeQuery($sql);
        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $kq[] = $row;
        }
        return $kq;
    }

    function getOption($id_properties, $id)
    {
        global $db;
        $sql = "SELECT a.properties_p, a.img, a.unique_id FROM $db->tbl_fix`properties_product` a WHERE a.id_properties = $id_properties and a.id_product = '$id'";  
        $result = $db->executeQuery($sql);
        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $kq[] = $row;
        }
        return $kq;
    }

    function getName($id)
    {
        global $db;
        $sql = "SELECT properties_name FROM $db->tbl_fix`properties_list` WHERE id = $id";
        $result = $db->executeQuery($sql);
        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $kq[] = $row;
        }
        return $kq;
    }

    function searchProduct($key)
    {
        global $db, $domain;
        $sql = "SELECT a.*, b.category_name FROM $db->tbl_fix$this->class_name a, $db->tbl_fix$this->join_name b WHERE a.name LIKE '%$key%' AND a.category = b.id";
        $result = $db->executeQuery($sql);
        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $img = explode(",", $row['img']);
            $row['img'] = [];
            foreach ($img as $item) {
                $row['img'][] = $domain . '/public/img/products/' . $row['category_name'] . '/' . $row['id_product'] . '/' . $item;
            }
            $kq[] = $row;
        }

        return $kq;
    }

    function searchProduct_page($key, $limit)
    {
        global $db, $domain;
        $sql = "SELECT a.*, b.category_name FROM $db->tbl_fix$this->class_name a, $db->tbl_fix$this->join_name b WHERE a.name LIKE '%$key%' AND a.category = b.id LIMIT $limit";
        $result = $db->executeQuery($sql);
        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $img = explode(",", $row['img']);
            $row['img'] = [];
            foreach ($img as $item) {
                $row['img'][] = $domain . '/public/img/products/' . $row['category_name'] . '/' . $row['id_product'] . '/' . $item;
            }
            $kq[] = $row;
        }

        return $kq;
    }

    function filter_price($price_min, $price_max)
    {
        global $db, $domain;
        $sql = "SELECT a.*, b.category_name FROM $db->tbl_fix$this->class_name a, $db->tbl_fix$this->join_name b WHERE a.price BETWEEN $price_min AND $price_max AND a.category = b.id";
        $result = $db->executeQuery($sql);
        $kq = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $img = explode(",", $row['img']);
            $row['img'] = [];
            foreach ($img as $item) {
                $row['img'][] = $domain . '/public/img/products/' . $row['category_name'] . '/' . $row['id_product'] . '/' . $item;
            }
            $kq[] = $row;
        }

        return $kq;
    }
}
?>