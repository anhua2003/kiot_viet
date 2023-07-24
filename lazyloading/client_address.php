<?php
$nod        = $main->get('nod');

if ($act == "idx") {
    if ($nod == 'list') {
        $address_book       = new address_book();
        $members            = new members();

        $members->set('user_id', isset($_SESSION['username_client']) ? $_SESSION['username_client'] : '');
        $dClient = $members->get_detail();

        if (!isset($dClient['user_id'])) {
            echo "done##", $main->toJsonData(403, 'Người dùng không tồn tại.', null);
        } else {
            $address_book->set('client_id', $dClient['user_id']);
            $l = $address_book->filter();

            echo "done##", $main->toJsonData(200, 'success', $l);
        }
    }else if ($nod == 'detail') {
        $address_book       = new address_book();
        $members            = new members();

        $id            = $main->post('id');

        $members->set('user_id', isset($_SESSION['username_client']) ? $_SESSION['username_client'] : '');
        $dClient = $members->get_detail();

        if (!isset($dClient['user_id'])) {
            echo "done##", $main->toJsonData(403, 'Người dùng không tồn tại.', null);
        } else {
            $address_book->set('client_id', $dClient['user_id']);
            $address_book->set('id', $id);
            $l = $address_book->get_detail();

            echo "done##", $main->toJsonData(200, 'success', $l);
        }
    } else if ($nod == 'opt_district') {

        $eco_district = new eco_district();

        $city_id = $main->post('city_id');
        $eco_district->set('id_city', $city_id);

        $kq = $eco_district->opt_by();

        echo 'done##', $main->toJsonData(200, 'success', $kq);
    } else if ($nod == 'opt_ward') {

        $eco_ward = new eco_ward();

        $district_id = $main->post('district_id');
        $eco_ward->set('id_district', $district_id);

        $kq = $eco_ward->opt_by();

        echo 'done##', $main->toJsonData(200, 'success', $kq);
    } else {
        echo 'Missing action';
        $db->close();
        exit();
    }
} else if ($act == 'location') {
    if ($nod == 'add') {
        
        $fullname           = $main->post('fullname');
        $mobile             = $main->post('mobile');
        $city_id            = $main->post('province');
        $district_id        = $main->post('district');
        $ward_id            = $main->post('ward');
        $address            = $main->post('street');
        $is_default         = $main->post('is_default');

        $address_book       = new address_book();
        $eco_city           = new eco_city();
        $eco_district       = new eco_district();
        $eco_ward           = new eco_ward();

        $members = new members();

        $members->set('user_id', isset($_SESSION['username_client']) ? $_SESSION['username_client'] : '');
        $dClient = $members->get_detail();

        if (!isset($dClient['user_id'])) {
            echo "done##", $main->toJsonData(403, 'Người dùng không tồn tại', null);
        } else {
            $eco_city->set('id_city', $city_id);
            $city = $eco_city->get_name();
            $eco_district->set('id_district', $district_id);
            $district = $eco_district->get_name();
            $eco_ward->set('id_ward', $ward_id);
            $ward = $eco_ward->get_name();

            if ($city_id == 0 || $city == '') {
                echo "done##", $main->toJsonData(403, 'Không xác định được Tỉnh/ Thành', null);
            } else if ($district_id == 0 || $district == '') {
                echo "done##", $main->toJsonData(403, 'Không xác định được Quận/ Huyện', null);
            } else if ($ward_id == 0 || $ward == '') {
                echo "done##", $main->toJsonData(403, 'Không xác định được Phường/ Xã', null);
            } else {
                $address_book->set('client_id', $dClient['user_id']);
                $l = $address_book->filter();

                $address_book->set('is_default', COUNT($l) > 0 ? $is_default : 1);
                unset($l);

                $address_book->set('city_id', $city_id);
                $address_book->set('district_id', $district_id);
                $address_book->set('ward_id', $ward_id);

                $address_book->set('city', $city);
                $address_book->set('district', $district);
                $address_book->set('ward', $ward);
                $address_book->set('address', $address);
                $address_book->set('country', 'Việt Nam');

                $address_book->set('fullname', $fullname);
                $address_book->set('mobile', $mobile);

                $address_book->add();

                echo "done##", $main->toJsonData(200, 'success', null);
            }
        }
    } else if ($nod == 'update') {
        
        $id                 = $main->post('id');
        $fullname           = $main->post('fullname');
        $mobile             = $main->post('mobile');
        $city_id            = $main->post('province');
        $district_id        = $main->post('district');
        $ward_id            = $main->post('ward');
        $address            = $main->post('street');
        $is_default         = $main->post('is_default');
        
        $address_book       = new address_book();
        $eco_city           = new eco_city();
        $eco_district       = new eco_district();
        $eco_ward           = new eco_ward();

        $members = new members();

        $members->set('user_id', isset($_SESSION['username_client']) ? $_SESSION['username_client'] : '');
        $dClient = $members->get_detail();

        if (!isset($dClient['user_id'])) {
            echo "done##", $main->toJsonData(403, 'Người dùng không tồn tại', null);
        } else {
            $eco_city->set('id_city', $city_id);
            $city = $eco_city->get_name();
            $eco_district->set('id_district', $district_id);
            $district = $eco_district->get_name();
            $eco_ward->set('id_ward', $ward_id);
            $ward = $eco_ward->get_name();

            if ($city_id == 0 || $city == '') {
                echo "done##", $main->toJsonData(403, 'Không xác định được Tỉnh/ Thành', null);
            } else if ($district_id == 0 || $district == '') {
                echo "done##", $main->toJsonData(403, 'Không xác định được Quận/ Huyện', null);
            } else if ($ward_id == 0 || $ward == '') {
                echo "done##", $main->toJsonData(403, 'Không xác định được Phường/ Xã', null);
            } else {

                $address_book->set('id', $id);

                $address_book->set('client_id', $dClient['user_id']);

                $address_book->set('city_id', $city_id);
                $address_book->set('district_id', $district_id);
                $address_book->set('ward_id', $ward_id);

                $address_book->set('city', $city);
                $address_book->set('district', $district);
                $address_book->set('ward', $ward);
                $address_book->set('address', $address);
                $address_book->set('country', 'Việt Nam');

                $address_book->set('fullname', $fullname);
                $address_book->set('mobile', $mobile);
                $address_book->set('is_default', $is_default);

                $address_book->update();

                echo "done##", $main->toJsonData(200, 'success', null);
            }
        }
    } else {
        echo 'Missing action';
        $db->close();
        exit();
    }
} else if ($act == 'delete') {
    if ($nod == 'delete') {
        $address_book       = new address_book();
        $members            = new members();

        $members->set('user_id', isset($_SESSION['username_client']) ? $_SESSION['username_client'] : '');
        $dClient = $members->get_detail();

        if (!isset($dClient['user_id'])) {
            echo "done##", $main->toJsonData(403, 'Người dùng không tồn tại.', null);
        } else {
            $id                 = $main->post('id');

            $address_book->set('id', $id);
            $address_book->set('client_id', $dClient['user_id']);
            $address_book->delete_item();

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
