<?php

/**
 * m/client.php dành cho Client sau khi đã login và được phép truy cập vào các chức năng đã login của Client
 */

$members = new members();

/**
 * BEGIN kiểm tra Client đăng nhập mới cho Login vào các trang client đăng nhập
 */

$member_group = new member_group();

$members->set('email', @$_SESSION['usernameClient']);
$members->set('password', @$_SESSION['passwordClient']);
$dClientLogin = $members->check_login();

if (!isset($dClientLogin['user_id'])) {
	$main->redirect($link);
} else {

	//BEGIN trong đăng nhập thành công
	$member_group->set('id', $dClientLogin['member_group_id']);
	$dMemberGroup = $member_group->get_detail();

	$st->assign('dClientLogin', $dClientLogin);
	$st->assign('dMemberGroup', $dMemberGroup);
	$notification->set('for_admin', 0); //for client only
	$notification->set('to', isset($dClientLogin['user_id']) ? $dClientLogin['user_id'] : '');
	$st->assign('un_read_number', $notification->count_un_read());
	$st->assign('str_permission_client', $dClientLogin['permission']);//vancode
	$st->assign('gmid', $dClientLogin['gmid']);//vancode

	/**
	 * END kiểm tra Client đăng nhập mới cho Login vào các trang client đăng nhập
	 */

	if ($act == 'listprofile') {
		$title .= 'Menu';
	} else if ($act == 'profile') {
		$title .= 'Thông tin cá nhân';

		$st->assign('dMember', $dClientLogin);
	} else if ($act == 'notification') {
		$title .= 'Trung tâm thông báo';

	} else if ($act == 'order') {
		$title .= 'Quản lý đơn hàng';
	} else if ($act == 'address') {
		$title .= 'Sổ địa chỉ';
	} else if ($act == 'paymentcard') {
		$title .= 'Quản lý ngân hàng';
	} else if ($act == 'wallet') {
		$title .= 'Quản lý ví';
	} else if ($act == 'member') {
		$title .= 'Quản lý đội nhóm';

		$st->assign('opt_group', $member_group->opt_all_by_group());
	} else if ($act == 'training') {
		$title .= 'Quản lý chứng chỉ';
	} else if ($act == 'change_password') {
		$title .= 'Đổi mật khẩu';
	} else {
		$main->redirect($domain);
	}
}
