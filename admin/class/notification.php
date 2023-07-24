<?php
class notification extends model
{

	protected $class_name = 'notification';

	protected $id;
	protected $subject_app;
	protected $content_app;
	protected $subject;
	protected $content;

	protected $push_type; //varchar = 30 character
	protected $push_type_value; // value = link = object json=> text

	protected $to;
	protected $to_label;

	protected $read_status;
	protected $force_read;
	protected $scheduled_at;
	protected $no_send; //số lần gửi
	protected $deleted; //client_1; client_2; => người đã xem và muốn xóa tin nhắn này

	protected $created_at;
	protected $created_by;

	protected $notify_group_id; //nhóm tin nhắn

	protected $is_deleted; //Admin đã xóa tin nhắn này
	protected $deleted_by; //Xóa bởi Admin nào

	protected $for_admin; //Phân loại tin nhắn cho user quản trị hay là tin nhắn cho Client (members)

	public function add()
	{
		global $db;

		$arr['subject_app']			= $this->get('subject_app');
		$arr['content_app']			= $this->get('content_app');
		$arr['subject'] 			= $this->get('subject');
		$arr['content'] 			= $this->get('content');

		$arr['push_type'] 			= $this->get('push_type');
		$arr['push_type_value'] 	= $this->get('push_type_value');

		$arr['to'] 					= $this->get('to');
		$arr['to_label'] 			= $this->get('to_label');

		$arr['notify_group_id'] 	= $this->get('notify_group_id') + 0;

		$arr['read_status']			= $this->get('read_status') . '';
		$arr['force_read'] 			= $this->get('force_read') + 0;
		$arr['scheduled_at'] 		= $this->get('scheduled_at') + 0;
		$arr['deleted'] 			= '';

		$arr['created_at'] 			= time();
		$arr['created_by'] 			= $this->get('created_by');

		$arr['notify_group_id'] 	= $this->get('notify_group_id') + 0;
		$arr['no_send'] 			= $this->get('no_send')+0;

		$arr['is_deleted'] 			= 0;
		$arr['deleted_by'] 			= 0;

		$arr['for_admin'] 			= $this->get('for_admin') + 0;


		$db->record_insert($db->tbl_fix . '`' . $this->class_name . '`', $arr);
		return $db->mysqli_insert_id();
	}

	public function update()
	{
		global $db;
		$id = $this->get('id');

		$arr['subject_app']		= $this->get('subject_app');
		$arr['content_app']		= $this->get('content_app');
		$arr['subject'] 		= $this->get('subject');
		$arr['content'] 		= $this->get('content');
		$arr['to'] 				= $this->get('to');
		$arr['to_label'] 		= $this->get('to_label');
		$arr['notify_group_id'] = $this->get('notify_group_id');
		$arr['read_status'] 	= $this->get('read_status') . '';
		$arr['force_read'] 		= $this->get('force_read') + 0;
		$arr['scheduled_at'] 	= $this->get('scheduled_at') + 0;

		$db->record_update($db->tbl_fix . '`' . $this->class_name . '`', $arr, " `id` = '$id' ");
		return true;
	}

	//Thông báo chéo cross ERP
	public function add_to_partner_pos($the_db_partner, $content, $order_id)
	{
		global $db;

		$the_db_partner = $the_db_partner . '.';

		$sql = "SELECT `id` FROM $the_db_partner`user` WHERE `gid` = '0' OR `gid` = '1' ";
		$lUsers = $db->executeQuery_list($sql);

		$to = ';';
		foreach ($lUsers as $it)
			$to .= $it['id'] . ';';

		unset($lUsers);

		$arr['subject'] = 'Thông báo từ đối tác';
		$arr['content'] = $content;
		$arr['read_status'] = '';
		$arr['force_read'] = 0;
		$arr['order_id'] = $order_id;
		$arr['deleted'] 	= '';
		$arr['created_at'] 	= time();
		$arr['created_by'] 	= $this->get('created_by');

		$db->record_insert($the_db_partner . "`notification`", $arr);
		return $db->mysqli_insert_id();
	}

	//List tin nhắn chưa đọc
	public function list_unread_by($offset = 0, $limit = '')
	{
		global $db;

		if ($limit != '') $limit = " LIMIT $offset, $limit ";

		$for_admin 	= $this->get('for_admin');
		if ($for_admin == '') $for_admin = 0;
		$to 		= $this->get('to');

		$sql = "SELECT *
				FROM `" . $this->class_name . "`
				WHERE ( `to` LIKE '%;$to;%' OR `to` LIKE '$to;%' ) AND `deleted` NOT LIKE '$to;%' AND `deleted` NOT LIKE '%;$to;%'
					AND `read_status` NOT LIKE '$to;%' AND `read_status` NOT LIKE '%;$to;%'
					AND `no_send` > 0
					AND `is_deleted` = 0
					AND `for_admin` = '$for_admin'
				ORDER BY `id` DESC
				$limit";

		$result = $db->executeQuery($sql);
		$kq = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$kq[] = $row;
		}

		return $kq;
	}

	//List all tin nhắn của client
	public function list_all_by_client($offset = 0, $limit = '')
	{
		global $db;

		if ($limit != '') $limit = " LIMIT $offset, $limit ";
		$for_admin = $this->get('for_admin') + 0;

		$to = $this->get('to');

		if ($to == '') {
			return array();
		} else {
			if ($to != '') $to_client = "OR
										 `to` LIKE '%;$to;%' OR `to` LIKE '$to;%' 
										";

			$sql = "SELECT *
					FROM $db->tbl_fix`" . $this->class_name . "`
					WHERE ( `to` = '0' $to_client)
					AND `deleted` NOT LIKE '$to;%' AND `deleted` NOT LIKE '%;$to;%'
					AND ( ( `no_send` > 0 OR `scheduled_at` > 0 ) OR ( `no_send` = 0 OR `scheduled_at` = 0 ) )
					AND `is_deleted` = 0
					AND `for_admin` = 0
					ORDER BY `id` DESC
					$limit";

			$result = $db->executeQuery($sql);
			$kq = array();
			while ($row = mysqli_fetch_assoc($result)) {
				$row['read_status'] = strpos($row['read_status'], $this->get('to') . ';') !== false ? '1' : '0';
				$row['deleted'] = strpos($row['deleted'], $this->get('to') . ';') !== false ? '1' : '0';
				$kq[] = $row;
			}

			return $kq;
		}
	}

	public function list_all_by_client_count()
	{
		global $db;

		$to = $this->get('to');

		if ($to == '') {
			return 0;
		} else {
			if ($to != '') $to = "OR  (
											( `to` LIKE '%;$to;%' OR `to` LIKE '$to;%' ) AND `deleted` NOT LIKE '$to;%' AND `deleted` NOT LIKE '%;$to;%' 
										)";

			$sql = "SELECT COUNT(*) as total
					FROM $db->tbl_fix`" . $this->class_name . "`
					WHERE ( `to` = '0' ) $to 
					AND ( ( `no_send` > 0 OR `scheduled_at` > 0 ) OR ( `no_send` = 0 OR `scheduled_at` = 0 ) )
					AND `is_deleted` = 0
					AND `for_admin` = 0";

			$result = $db->executeQuery($sql, 1);

			return $result['total'] + 0;
		}
	}

	//đếm số tin nhắn chưa đọc của client for_admin = 0; hoặc user admin for_admin = 1
	public function count_un_read()
	{
		global $db;

		$for_admin	 = $this->get('for_admin');
		if ($for_admin === '') $for_admin = 0;

		$to = $this->get('to');

		if ($to == '') {
			return 0;
		} else {
			$to_ = $to;
			if ($to != '') $to = "OR  ( 	`to` <> '0'
											AND ( `to` LIKE '%;$to;%' OR `to` LIKE '$to;%' )
											AND `deleted` NOT LIKE '$to;%' AND `deleted` NOT LIKE '%;$to;%'
											AND `read_status` NOT LIKE '$to;%' AND `read_status` NOT LIKE '%;$to;%'
										)";

			$sql = "SELECT COUNT(*) as total
					FROM `" . $this->class_name . "`
					WHERE ( `to` = '0' 
							AND `deleted` NOT LIKE '$to_;%' AND `deleted` NOT LIKE '%;$to_;%'
							AND `read_status` NOT LIKE '$to_;%' AND `read_status` NOT LIKE '%;$to_;%' )
					$to
					AND `no_send` > 0
					AND `is_deleted` = 0
					AND `for_admin` = '$for_admin'
					";

			$result = $db->executeQuery($sql, 1);

			return $result['total'] + 0;
		}
	}

	//update delete by client
	public function delete_by_client($to = 0)
	{
		global $db;
		if ($to > 0) {
			$id 	= $this->get('id');
			$sql = "UPDATE $db->tbl_fix`$this->class_name` SET `deleted` = CONCAT(`deleted`, '$to', ';') WHERE `id` = '$id' AND `deleted` NOT LIKE '$to;%' AND `deleted` NOT LIKE '%;$to;%' ";
			$db->executeQuery($sql);
		}

		return true;
	}

	//update delete by client
	public function delete_by_admin()
	{
		global $db;

		$id 	= $this->get('id');
		$arr['is_deleted'] = time();
		$arr['deleted_by'] = $this->get('deleted_by');
		$db->record_update("$db->tbl_fix`$this->class_name`", $arr, " `id` = '$id' ");

		return true;
	}

	//update count
	public function update_read($to)
	{
		global $db;

		$id = $this->get('id');

		if ($to > 0) {
			$id 	= $this->get('id');
			$sql = "UPDATE $db->tbl_fix`$this->class_name` SET `read_status` = CONCAT(`read_status`, '$to', ';') WHERE `id` = '$id' AND `read_status` NOT LIKE '$to;%' AND `read_status` NOT LIKE '%;$to;%' ";
			$db->executeQuery($sql);
		}

		return true;
	}

	//List ALL noti in admin
	public function list_all_by($ofset = 0, $limit = '')
	{
		global $db;

		$notify_group_id = $this->get('notify_group_id');
		if ($notify_group_id !== '')
			$notify_group_id = " AND `noti`.notify_group_id = '$notify_group_id' ";

		if ($limit != '') $limit = " LIMIT $ofset, $limit ";

		$sql = "SELECT noti.*, IFNULL(u.`username`, '') as create_by, IFNULL(gr.`name`, 'Không nhóm') notify_group_name
				FROM $db->tbl_fix`" . $this->class_name . "` noti 
				LEFT JOIN $db->tbl_fix`user` u ON noti.`created_by` = u.`id`
				LEFT JOIN $db->tbl_fix`notification_group` gr ON noti.`notify_group_id` = gr.`id`
				WHERE `noti`.`is_deleted` = '0' $notify_group_id
				ORDER BY `id` DESC
				$limit ";

		$result = $db->executeQuery_list($sql);

		return $result;
	}

	public function list_all_by_count()
	{
		global $db;

		$notify_group_id = $this->get('notify_group_id');
		if ($notify_group_id !== '')
			$notify_group_id = " AND `noti`.notify_group_id = '$notify_group_id' ";

		$sql = "SELECT COUNT(*) as total 
				FROM $db->tbl_fix`" . $this->class_name . "` noti
				WHERE `noti`.`is_deleted` = 0 $notify_group_id";

		$result = $db->executeQuery($sql, 1);

		return $result['total'] + 0;
	}

	//Get detail by id
	public function get_by_id()
	{
		global $db;

		$sql = "SELECT * 
				FROM $db->tbl_fix`$this->class_name` noti
				WHERE `id` = '" . $this->get('id') . "' 
				AND `noti`.`is_deleted` = 0";
		$result = $db->executeQuery($sql, 1);
		return $result;
	}

	//Get theo thời gian gửi (tùngcode-12/07/2021)
	public function get_by_scheduled_at($from_send, $to_send)
	{
		global $db;

		$scheduled_at 	= $this->get('scheduled_at');
		$no_send	  	= $this->get('no_send');

		$sql = "SELECT * 
				FROM $db->tbl_fix`$this->class_name` noti
				WHERE noti.`scheduled_at` >= '$from_send' AND '$to_send' > noti.`scheduled_at`
				AND `noti`.`no_send` = $no_send
				AND `noti`.`is_deleted` = 0";
				
		$result = $db->executeQuery_list($sql);
		return $result;
	}

	//update số lần gửi (tùngcode-12/07/2021)
	public function update_no_send()
	{
		global $db;

		$id 	 	= $this->get('id');
		$no_send 	= $this->get('no_send');
		$created_at = time();

		$sql = "UPDATE $db->tbl_fix`$this->class_name` SET `no_send` = $no_send, `created_at` = $created_at WHERE `id` = '$id'";
		$db->executeQuery($sql);

		return true;
	}

	//update thời gian xóa thông báo(tùngcode-12/07/2021)
	public function update_time_delete()
	{
		global $db;

		$id 	 	= $this->get('id');
		$is_deleted = $this->get('is_deleted');
		$deleted_by = $this->get('deleted_by');

		$sql = "UPDATE $db->tbl_fix`$this->class_name` SET `is_deleted` = '$is_deleted', `deleted_by` = '$deleted_by' WHERE `id` = '$id'";
		
		$db->executeQuery($sql);

		return true;
	}

	//Tạo noti và push
	public function sendNotiAndPush(
		$key_topic
		/** client_[client_id] */
		,
		$is_pushed = true
		/**Có đẩy thông báo lên app ko */
		,
		$is_sound = true
		/** Có đẩy âm thanh lên app không */
		,
		$push_subject = ''
		/**Nếu không set thì bằng với OBJ */
		,
		$push_content = ''
		/**Nếu không set thì bằng với OBJ */
		,
		$push_type = ''
		/**Loại push:  nhảy đến 1 chức năng nào đó */
		,
		$push_type_value = ''
		/**Giá trị của loại push để nhảy đến 1 chức năng nào đó */
	) {
		global $main;

		$to 			= $this->get('to'); //ClientID1;ClientID2;
		$subject 		= $this->get('subject'); //Tựa đề
		$content 		= $this->get('content'); //Nội dung
		$created_by 	= $this->get('created_by'); //Người tạo => user.id

		$this->set('to', $to == 'all;' ? '0' : $to);
		$this->set('subject', $subject);
		$this->set('content', $content);
		$this->set('created_by', $created_by);
		$notification_id = $this->add();

		if ($is_pushed) {

			$lTo = explode(';', $to);
			$con = '';
			foreach ($lTo as $key => $it) {
				if ($it != '')
					$con .= "'" . $key_topic . "$it' in topics || ";
			}

			if ($con != '') {

				if ($push_type != '') {
					$notification_id = 0;
				}

				$con = substr($con, 0, -3);
				$post['condition'] = $con;
				// $post['to'] = '/topics/client_' . $to;

				$post['priority']  = 'high';
				$ii['title']  = $push_subject == '' ? $subject : $push_subject;
				$ii['body']   = $push_content == '' ? $content : $push_content;
				$post['notification'] = $ii;
				$post['notification']['is_sound'] = $is_sound;
				$post['data']['force_refresh'] = true;
				$post['data']['notify_id']     	= $notification_id;
				$post['data']['type']     		= $push_type; //Mã push
				$post['data']['value']     		= $push_type_value; //Giá trị push
				$main->sendFCM($post);
			}
		}

		return true;
	}

	//Tạo noti và push
	// public function sendNotiChangeBalance( $key_topic/** client_[client_id] */
	// 										, $amount_change = 0 /**Giá trị số dư thay đổi */
	// 										, $is_pushed = true /**Có đẩy thông báo lên app ko */
	// 										, $is_sound = true /** Có đẩy âm thanh lên app không */
	// 										, $push_subject = '' /**Nếu không set thì bằng với OBJ */
	// 										, $push_content = '' /**Nếu không set thì bằng với OBJ */
	// 										, $push_type = '' /**Loại push:  nhảy đến 1 chức năng nào đó */
	// 										, $push_type_value = '' /**Giá trị cảu loại push để nhảy đến 1 chức năng nào đó */
	// 										){
	// 	global $main;

	// 	$to 			= $this->get('to');//ClientID1;ClientID2;
	// 	$subject 		= $this->get('subject');//Tựa đề
	// 	$content 		= $this->get('content');//Nội dung
	// 	$created_by 	= $this->get('created_by');//Người tạo => user.id
        
	// 	$this->set('to', $to.';');
	// 	$this->set('subject', $subject );
	// 	$this->set('content', $content);
	// 	$this->set('created_by', $created_by);
	// 	$notification_id = $this->add();
		
	// 	if( $is_pushed ){

	// 		$lTo = explode(';', $to);
	// 		$con = '';
	// 		foreach ($lTo as $key => $it) {
	// 			if ($it != '')
	// 				$con .= "'".$key_topic."$it' in topics || ";
	// 		}
			
	// 		if ( $con != '' ) {

	// 			if( $push_type != '' ){
	// 				$notification_id = 0;
	// 			}
				
	// 			$con = substr($con, 0, -3);
	// 			$post['condition'] = $con;
	// 			// $post['to'] = '/topics/client_' . $to;

	// 			$post['priority']  = 'high';
	// 			$ii['title']  = $push_subject == '' ? $subject:$push_subject;
	// 			$ii['body']   = $push_content == '' ? $content:$push_content;
	// 			$post['notification'] = $ii;
	// 			$post['notification']['is_sound'] = $is_sound;
	// 			$post['data']['force_refresh'] = true;
	// 			$post['data']['notify_id']     	= $notification_id;
	// 			$post['data']['type']     		= $push_type;//Mã push
	// 			$post['data']['value']     		= $push_type_value;//Giá trị push
	// 			$main->sendFCM( $post );
	// 		}

	// 	}
				
	// 	return true;
	// }
	
}
$notification = new notification();
