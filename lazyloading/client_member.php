<?php
$nod        = $main->get('nod');

if ($act == 'idx') {
    if ($nod == 'filter') {

        $members = new members();

        $field                              = $main->post('field');
        $sort                               = $main->post('sort');

        $keyword                            = $main->post('keyword');
        $joined_at                          = $main->post('joined_at');
        $member_group_id                    = $main->post('member_group_id');
        $member_department_id               = '';
        $month                              = '';
        $year                               = '';
        $birth_month                        = '';
        $city                               = '';
        $page                               = $main->post('page');

        if (isset($_SESSION['username_client']) && $_SESSION['username_client'] != '') {
            $members->set('user_id', $_SESSION['username_client']);
            $dClient = $members->get_detail();

            if ($joined_at != '')
                $joined_from = strtotime($mainconvert_strdate($joined_at));
            else
                $joined_from = '';

            $members->set('member_group_id', $member_group_id);
            $members->set('member_department_id', $member_department_id);
            $members->set('code', $dClient['code']);
            $members->set('mobile', $dClient['mobile']);

            $kq = $members->filter_members_summary($keyword, $joined_from, $birth_month, $city);
            $kq['total_record']      = $members->filter_members_count($keyword, $joined_from, $birth_month, $city);

            if ($page < 1) $page = 1;
            $paging->limit = $limit = $setup['perpage'];
            $offset = ($page - 1) * $paging->limit;
            $paging->page = $page;
            $paging->total = $kq['total_record'];
            $page_html = $paging->display('paging_members');

            $lmembers = $members->filter_members($keyword, $joined_from, $birth_month, $city, $field, $sort, $offset, $limit);

            $kq['page_html'] = $page_html;
            $kq['list_members'] = $lmembers;
            $kq['page'] = $page;
            $kq['perpage'] = $limit + 0;
            // print_r($kq);
            // exit();
            echo 'done##', $main->toJsonData(200, 'success', $kq);
            unset($kq);
        } else {
            echo 'done##', $main->toJsonData(403, 'Không tìm thấy người dùng', null);
            unset($kq);
        }
    }elseif ($nod == 'get_detail_member') {
        $members            = new members();
		$member_department 	= new member_department();
		$member_title 		= new member_title();

		$user_id = $main->post('user_id');

		$members->set('user_id', $user_id);
		$dMember 		= $members->get_detail();

		$dMember['member_group_name'] = '';
		$member_group->set('id', $dMember['member_group_id']);
		$d = $member_group->get_detail();
		if (isset($d['id']))
			$dMember['member_group_name'] = $d['name'];

		$dMember['member_title_name'] = '';
		$member_title->set('id', $dMember['member_title_id']);
		$d = $member_title->get_detail();
		if (isset($d['id']))
			$dMember['member_title_name'] = $d['name'];

		$dMember['by_user_cs_fullname'] = 'Mặc định';
		if ($dMember['by_user_cs'] > 0)
			$dMember['by_user_cs_fullname'] = $user->get_fullname_by_id($dMember['by_user_cs']);

		$dMember['member_department_name'] = 'Mặc định';
		if ($dMember['member_department_id'] > 0) {
			$dMember['member_department_name'] = '';
			$member_department->set('id', $dMember['member_department_id']);
			$member_department->get_full_name($dMember['member_department_name']);
		}

		$eco_city 		= new eco_city();
		$eco_district 	= new eco_district();
		$eco_ward 		= new eco_ward();

		$eco_district->set('id_city', $dMember['city_id']);
		$eco_ward->set('id_district', $dMember['district_id']);
		$dMember['opt_district'] 	= $eco_district->opt_by();
		$dMember['opt_ward'] 		= $eco_ward->opt_by();

		$dMember['city_allowed_list'] 		= $eco_city->get_by_list_strID($dMember['city_allowed']);
		$dMember['district_allowed_list'] 	= $eco_district->get_by_list_strID($dMember['district_allowed']);

		$dMember['unix_time'] = time();
		echo 'done##', $main->toJsonData('200', 'success', $dMember);
		unset($dMember);
		unset($d);
	}elseif ($nod == 'member_history_order') {

		$members_id 	= $main->post('members_id');
		$page 			= $main->post('page');
		$is_booking 	= $main->post('is_booking');

		$collected_orders->set('members_id', $members_id);
		$collected_orders->set('is_booking', $is_booking);

		if ($page < 1) $page = 1;
		$paging->limit = $setup['perpage'];
		$offset = ($page - 1) * $paging->limit;
		$paging->page = $page;
		$paging->total = $collected_orders->filter_order_by_members_count('');
		$kq['page_html'] = $paging->display('paging_history_order') . '';


		$kq['lItems'] = $collected_orders->filter_order_by_members('',$offset, $paging->limit);

		echo 'done##' . $main->toJsonData(200, 'success', $kq);
		unset($kq);
	}elseif ($nod == 'member_booking_order') {

		$members_id 	= $main->post('members_id');
		$page 			= $main->post('page');
		$is_booking 	= $main->post('is_booking');

		$collected_orders->set('members_id', $members_id);
		$collected_orders->set('is_booking', $is_booking);

		if ($page < 1) $page = 1;
		$paging->limit = $setup['perpage'];
		$offset = ($page - 1) * $paging->limit;
		$paging->page = $page;
		$paging->total = $collected_orders->filter_order_by_members_count('');
		$kq['page_html'] = $paging->display('paging_booking_order') . '';

		$kq['lItems'] = $collected_orders->filter_order_by_members('',$offset, $paging->limit);

		echo 'done##' . $main->toJsonData(200, 'success', $kq);
		unset($kq);
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
