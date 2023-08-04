<?php
$nod        = $main->get('nod');

if ($act == 'add') {
    if($nod == 'add') {
        $post['name'] = $main->post('category_name');
        $kiotviet->add_category($post);
        $result = $kiotviet->getList('categories');
        echo 'done##'.$main->toJsonData(200, null, $result);
    }
} else if($act == 'delete') {
    if($nod == 'delete') {
        $id = $main->post('categoryId');
        $kiotviet->delete_category($id);
        $result = $kiotviet->getList('categories');
        echo 'done##'.$main->toJsonData(200, null, $result);
    }
} else if($act == 'edit') {
    if($nod == 'detail') {
        $result = $kiotviet->getList('categories');
        echo 'done##'.$main->toJsonData(200, null, $result);
    }
} else {
    echo 'Missing action';
    $db->close();
    exit();
}
