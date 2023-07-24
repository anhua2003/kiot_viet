<?php

$publication = new publication();
$nod = $main->get('nod');
if ($act == 'idx') {

	if ($nod == 'list') {

		$page = @$_POST['page'];
		if ($page < 1) $page = 1;
		$paging->limit = 10;
		$offset = ($page - 1) * $paging->limit;
		$paging->total = $publication->listby_user_id_count();
		$paging->page = $page;
		$lNoti = $publication->listby_user_id($offset, $paging->limit);

		$kq['list_notification'] = tpl_list_notification($lNoti);
		$kq['page_html'] = $paging->display_ajax3();

		echo "done##" . $main->toJsonData(200, 'success', $kq);
		unset($lNoti);
		unset($kq);
	} else if ($nod == 'filter') {

		$page       		= $main->post('page');
		$notify_group_id    = $main->post('notify_group_id');

		$notification->set('notify_group_id', $notify_group_id);

		if ($page < 1) $page = 1;
		$paging->limit 	= $limit = 20;
		$offset 			= ($page - 1) * $limit;
		$paging->total 	= $notification->list_all_by_count();
		$paging->page 	= $page;

		$lItems 			= $notification->list_all_by($offset, $limit);

		foreach ($lItems as $key => $item) {
			if (strip_tags($item['content']) != $item['content'])
				$item['content'] = '<a>Vui lòng chọn để xem chi tiết.</a>';
			$lItems[$key] = $item;
		}

		$kq['offset'] 				= $offset;
		$kq['list_notification'] 	= $lItems;
		$kq['page_html'] 			= $paging->display('paging_noti');

		echo 'done##', $main->toJsonData(200, 'success', $kq);

		unset($l);
	} else if ($nod == 'detail') {

		$id       = $main->post('id');

		$notification->set('id', $id);
		$d = $notification->get_detail();

		if ($d['scheduled_at'] > 0) {
			$d['scheduled_date'] = date('d/m/Y', $d['scheduled_at']);
			$d['scheduled_hour'] = date('H', $d['scheduled_at']);
			$d['scheduled_minute'] = date('i', $d['scheduled_at']);
		} else {
			$d['scheduled_date'] = '';
			$d['scheduled_hour'] = 0;
			$d['scheduled_minute'] = 0;
		}

		echo 'done##', $main->toJsonData(200, 'success', $d);

		unset($d);
	} else if ($nod == 'detailx') {

		$id = @$_POST['id'];
		$posts['id'] = $id;
		$result = $api->exeAPI('get_publication', $posts);
		$data = explode('##', $result);
		$data = json_decode($data[1]);
		if (@$data->status == 200) {
			//update and return to UI
			$publication->set('id', $id);
			$publication->set('viewed_count', $data->data->viewed_count);
			$publication->set('viewed_user', $data->data->viewed_user);
			$publication->set('viewed_date', $data->data->viewed_date);
			$publication->update();

			$dPub = $publication->get_detail();
			if ($dPub['viewed_user'] != '')
				$dPub['viewed'] = count(explode(":", $dPub['viewed_user'])) - 2;
			else
				$dPub['viewed'] = 0;

			if ($dPub['list_user_id'] != '')
				$dPub['totals'] = count(explode(":", $dPub['list_user_id'])) - 2;
			else
				$dPub['totals'] = 0;

			echo "done##" . $main->toJsonData(200, 'success', $dPub);
		} else {
			echo "done##" . $main->toJsonData(403, 'Tin nhắn này không thực được gửi đến khách hàng.', $result);
		}
		unset($result);
		unset($data);
	} else {
		echo 'Error! Nod Missing';
	}
} else if ($act == 'delete') {
	if ($nod == 'delete') {

		$id       = $main->post('id');

		$notification->set('id', $id);
		$notification->set('is_deleted', time());
		$notification->set('deleted_by', $dUserLogin['id']);
		$notification->update_time_delete(); //update thời gian xóa thông báo

		echo 'done##', $main->toJsonData(200, 'success', null);
	} else {
		echo 'Missing Nod';
		$db->close();
		exit();
	}
} else if ($act == 'save') {

	if ($nod == 'save') {

		$id 					= $main->post('id');
		$to             		= $main->post('to');
		$to_label       		= $main->post('to_label');
		$notify_group_id       	= $main->post('notify_group_id');
		$subject        		= $main->post('subject');
		$content        		= $main->post('content');
		$content_app     		= $main->post('content_app');
		$subject_app     		= $main->post('subject_app');
		$scheduled_date     	= $main->post('scheduled_date');
		$scheduled_hour     	= $main->post('scheduled_hour');
		$scheduled_minute  		= $main->post('scheduled_minute');
		$lShop					= $main->post('lShop');
		$lGroup					= $main->post('lGroup');
		$lDepartment			= $main->post('lDepartment');
		$lTitle					= $main->post('lTitle');
		$page  					= $main->post('page');

		$no_send = 1; //tin đã gửi
		$scheduled_at = 0; //gửi ngay

		$notification->set('id', $id);
		$dNoti = $notification->get_by_id();

		if ($scheduled_date != '') { //func format ngày gửi, nếu ngày gửi rỗng thì tin được gửi ngay ngược lại chuyển theo ngày giờ được chọn (tùngcode-12/07/2021)
			$da = explode('/', $scheduled_date);
			$d = $da['0'];
			$m = $da['1'];
			$y = $da['2'];
			$date = mktime($scheduled_hour, $scheduled_minute, 0, $m, $d, $y);
			$scheduled_at = strtotime(date('m/d/Y H:i', $date));
			$no_send = 0; //tin chưa được gửi
		}

		$kq = array();

		if ($to == "" && ($lShop != '' || $lGroup != '' || $lDepartment != '' || $lTitle != '')) {

			if ($page < 1) $page = 1;
			$limit = 1;
			$offset = ($page - 1) * $limit;

			$members = new members();
			$members->set('shop_id', $lShop == '' ? 1 : $lShop);
			$members->set('is_official', '');
			$members->set('member_group_id', $lGroup);
			$members->set('member_department_id', $lDepartment);
			$members->set('member_title_id', $lTitle);
			$l = $members->filter_members('', '', '', '', 'user_id', 'ASC', $offset, $limit);

			if ($l && $l != '') {
				$kq['page'] = $page + 1;
			} else {
				$kq['page'] = 0;
			}

			$kq['quantity'] = $page * $limit;
			$kq['members'] = COUNT($l);
			$kq['count'] = $members->filter_members_count('', '', '', '');
			$kq['offset'] = $offset;

			foreach ($l as $it) {
				$to .= $it['user_id'] . ';';
			}
		}

		if (!isset($dNoti['id'])) {

			$notification->set('to', $to);
			$notification->set('subject', $subject);
			$notification->set('content', $content);
			$notification->set('scheduled_at', $scheduled_at);
			$notification->set('created_by', $dUserLogin['id']);
			$notification->sendNotiAndPush('client_', true, true, '📣 ' . $subject_app, $content_app, '', ''); //Tạo noti và push noti

			// $notification->set('to', $to == 'all;' ? '0' : $to);
			// $notification->set('to_label', $to_label);
			// $notification->set('notify_group_id', $notify_group_id);
			// $notification->set('subject', $subject);
			// $notification->set('content', $content);
			// $notification->set('content_app', $content_app);
			// $notification->set('subject_app', $subject_app);
			// $notification->set('scheduled_at', $scheduled_at);
			// $notification->set('created_by', $dUserLogin['id']);
			// $notification->set('force_read', 0);
			// $notification->set('no_send', $no_send);
			// $notification_id = $notification->add();

			// //send notification to all
			// $lTo = explode(';', $to);
			// $con = '';
			// foreach ($lTo as $key => $it) {
			// 	if ($it != '')
			// 		$con .= "'client_$it' in topics || ";
			// }

			// if ($con != '' && $subject_app != '' && $content_app != '') {

			// 	$con = substr($con, 0, -3);
			// 	$post['condition'] = $con;
			// 	// $post['to'] = "/topics/username_lengochuan";
			// 	$post['priority']  = 'high';
			// 	$post['notification_id']  = $notification_id;
			// 	$ii['title']  = $subject_app;
			// 	$ii['body']   = strip_tags($content_app);
			// 	$post['notification'] = $ii;
			// 	$main->sendFCM($post);

			// 	// print_r( $post );
			// 	unset($con);
			// 	unset($post);
			// 	unset($ii);
			// }

		} else {
			$notification->set('to', $to == 'all;' ? '0' : $to);
			$notification->set('to_label', $to_label);
			$notification->set('notify_group_id', $notify_group_id);
			$notification->set('subject', $subject);
			$notification->set('content', $content);
			$notification->set('content_app', $content_app);
			$notification->set('subject_app', $subject_app);
			$notification->set('scheduled_at', $scheduled_at);
			$notification->update();
		}

		echo 'done##', $main->toJsonData(200, 'success', $kq);
	} else {
		echo 'Missing Nod';
		$db->close();
		exit();
	}
} elseif ($act == 'search_members') {
	$members = new members();
	if ($nod == 'search_members') {
		$except 		= $main->post('except');
		$keyword 		= $main->post('keyword');

		$kq = $members->managers_showroom_by_keyword($keyword, $except);

		echo 'done##', $main->toJsonData(200, 'success', $kq);
	} else {
		echo 'Missing Nod';
		$db->close();
		exit();
	}
} else {
	echo 'Error! Action Missing';
}

function tpl_list_notification($lNoti)
{
	$html = '';
	foreach ($lNoti as $key => $item) {
		$html .= '
					<tr>
                      <td class="text-left" onclick="get_detail( ' . $item['id'] . ' );">
                        ' . $item['title'] . '
                      </td>
                      <td>
                        ' . date('d/m/y H:i', $item['created_at']) . '
                      </td>
                      <td>
                        <div class="btn-group">
		                    <button onclick="get_detail( ' . $item['id'] . ' );" class="btn btn-sq btn-primary">
		                      <i class="glyphicon glyphicon-eye-open"></i>
		                    </button>
		                    <button onclick="on_delete( ' . $item['id'] . ' );" class="btn btn-sq btn-danger">
		                      <i class="fa fa-trash-o icon-cate icon-other-x"></i>
		                    </button>
		                 </div>
                      </td>
                    </tr>
				';
	}
	return $html;
}
