<?php
$nod        = $main->get('nod');

if ($act == 'idx') {
    if ($nod == 'list') {

        $members = new members();

        $page       = $main->post('page') + 0;

        $members->set('user_id', isset($_SESSION['usernameClient']) ? $_SESSION['usernameClient'] : '');
        $dClient = $members->get_detail();

        if (!isset($dClient['user_id'])) {
            echo "done##", $main->toJsonData(403, 'Không tìm thấy người dùng.', null);
        } else {
            $notification->set('for_admin', 0); //for client only
            $notification->set('to', isset($dClient['user_id']) ? $dClient['user_id'] : '');
            
            if ($page < 1) $page = 1;
            $paging->limit                = $limit = $setup['perpage'];
            $offset                       = ($page - 1) * $paging->limit;
            $paging->page                 = $page;
            $paging->total                = $notification->list_all_by_client_count();
            $kq['page_html']              = $paging->display('paging_this');

            $kq['total_record'] = $paging->total;
            $kq['un_read_number'] = $notification->count_un_read();

            $l = $notification->list_all_by_client($offset, $paging->limit);

            // foreach ($l as $key => $item) {
            //     $str = strip_tags($item['content']);
            //     $item['sort_description'] = $main->substrwords($str, 86, '...');
            //     if ($item['content'] != $str) {
            //         $item['content'] = 'Vui lòng click chọn để xem chi tiết nội dung';
            //     }
            //     $l[$key] = $item;
            // }
            $kq['l'] = $l;

            echo "done##", $main->toJsonData(200, 'success', $kq);

            unset($l);
            unset($kq);
        }
    } else if ($nod == 'detail') {

        $members = new members();

        $members->set('user_id', isset($_SESSION['usernameClient']) ? $_SESSION['usernameClient'] : '');
        $dClient = $members->get_detail();

        $id           = $main->post('id');

        $notification->set('id', $id);
        $d = $notification->get_detail();

        if (isset($d['id'])) {

            if (isset($dClient['user_id'])) {
                $notification->set('id', $id);
                $notification->update_read($dClient['user_id']);
            }

            echo "done##", $main->toJsonData(200, 'success', $d);
        } else {
            echo "done##", $main->toJsonData(403, 'Không tìm thấy tin này', null);
        }
    } else if ($nod == 'read') {

        $members = new members();

        $members->set('user_id', isset($_SESSION['usernameClient']) ? $_SESSION['usernameClient'] : '');
        $dClient = $members->get_detail();

        if (!isset($dClient['user_id'])) {
            echo "done##", $main->toJsonData(403, 'Không tìm thấy người dùng.', null);
        } else {
            $id           = $main->post('id');

            if (isset($dClient['user_id'])) {
                $notification->set('id', $id);
                $notification->update_read($dClient['user_id']);
            }
            echo "done##", $main->toJsonData(200, 'success', null);
        }
    } else {
        echo 'Missing action';
        $db->close();
        exit();
    }
} else if ($act == 'delete') {
    if ($nod == 'delete') {
        $members = new members();

        $members->set('user_id', isset($_SESSION['usernameClient']) ? $_SESSION['usernameClient'] : '');
        $dClient = $members->get_detail();
        if (!isset($dClient['user_id'])) {
            echo "done##", $main->toJsonData(403, 'Không tìm thấy người dùng.', null);
        } else {
            $id           = $main->post('id');

            if (isset($dClient['user_id'])) {
                $notification->set('id', $id);
                $notification->delete_by_client($dClient['user_id']);
            }
            echo "done##", $main->toJsonData(200, 'success', null);
        }
    } else {
        echo 'Missing action';
        $db->close();
        exit();
    }
} else {
    echo 'Missing action';
    $db->close();
    exit();
}
