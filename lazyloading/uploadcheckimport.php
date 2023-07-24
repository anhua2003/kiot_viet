<?php
$user->setusername($_SESSION["username"]);
$user->setpassword($_SESSION["pass"]);
$dUserLogin = $user->check_login();

include "../library/PHPExcel/PHPExcel/IOFactory.php";

if($act=='checkfile'&& isset($_POST['files'])){
	
	$kq = $_POST['files'];
	
	set_include_path(get_include_path() . PATH_SEPARATOR . '../library/PHPExcel/');
	
	$inputFileName = "../".$kq;
	if (file_exists($inputFileName)) {
		
		try {
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		} catch(Exception $e) {
			exit('Error loading file :' . $e->getMessage());
		}
		$objPHPExcel->setActiveSheetIndex(0);
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$dwh = $wh->get_detail($sheetData['5']['B']);

		if($dUserLogin['create_user']==$dwh['username']){
			$html = '';
			$i = 0;
			foreach ($sheetData as $row) {
				$i++;
				if($i > 8){
					if($row['C']==$lang['lb_material'] || $row['C'] == $lang['lb_product']){
						$html .= '<tr class="text-center font-weight-bold active5  color-red">
										<td></td>
										<td>'.$row['C'].'</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>';
					}else{
						if(is_numeric($row['A'])&&$i>9){
							$dgoods = $goods->get_detail($row['A']);
							if($dgoods!=''){
								if($row['G']=='') $row['G'] = 0;
								if($row['H']=='') $row['H'] = 0;
								if($row['I']=='') $row['I'] = 0;
								if($row['J']=='') $row['J'] = 0;
								if($row['K']=='') $row['K'] = 0;
								if($row['L']=='') $row['L'] = 0;
								if($row['M']=='') $row['M'] = 0;
								
								//cho màu
								// 1 tồn thực tế lớn hơn tồn hệ thống => red
								// (tồn cuối kỳ trừ tồn thực tế )/tồn cuối kỳ<=0.1 green
								// (tồn cuối kỳ trừ tồn thực tế )/tồn cuối kỳ<=0.2 yellow
								// (tồn cuối kỳ trừ tồn thực tế )/tồn cuối kỳ<=0.3 red
								
								if($row['J'] > $row['L']){ // Tồn thực tế nhỏ hơn tồn hệ thống có hao hụt
									$test = ($row['J'] - $row['L'])/$row['J'];
									if($test<=0.1){
										$background = 'row_test_green';//green
									}else if($test<=0.2){
										$background = 'row_test_yellow';//yellow
									}else{
										$background = 'row_test_red';//red
									}
								}else{// Kho dư ra ??
									$background = 'row_test_red';
								}
								
								$html .= '<tr class="text-center '.$background.' font-weight-bold">
											<td>'.$row['A'].'</td>
											<td class="text-left">'.$row['B'].'</td>
											<td>'.$row['D'].'</td>
											<td>'.$row['E'].'</td>
											<td>'.$row['F'].'</td>
											<td>'.$row['G'].'</td>
											<td>'.$row['H'].'</td>
											<td>'.number_format_replace_cog($row['I']).'</td>
											<td>'.number_format_replace_cog($row['J']).'</td>
											<td>'.$row['K'].'</td>
											<td>'.$row['L'].'</td>
											<td>'.$row['M'].'</td>
										</tr>';
							}else{
								//error empty goods
								$html .= '<tr class="text-center font-weight-bold  color-red">
											<td>'.$row['A'].'</td>
											<td class="text-left">'.$row['B'].'</td>
											<td>'.$row['D'].'</td>
											<td>'.$row['E'].'</td>
											<td>'.$row['F'].'</td>
											<td>'.$row['G'].'</td>
											<td>'.$row['H'].'</td>
											<td>'.$row['I'].'</td>
											<td>'.$row['J'].'</td>
											<td>'.$row['K'].'</td>
											<td>'.$row['L'].'</td>
											<td>'.$row['M'].'</td>
										</tr>';
							}
						}else{
							if($row['A']!=''){
								//error goods
								$html .= '<tr class="text-center font-weight-bold  color-red">
											<td>'.$row['A'].'</td>
											<td class="text-left">'.$row['B'].'</td>
											<td>'.$row['D'].'</td>
											<td>'.$row['E'].'</td>
											<td>'.$row['F'].'</td>
											<td>'.$row['G'].'</td>
											<td>'.$row['H'].'</td>
											<td>'.$row['I'].'</td>
											<td>'.$row['J'].'</td>
											<td>'.$row['K'].'</td>
											<td>'.$row['L'].'</td>
											<td>'.$row['M'].'</td>
										</tr>';
							}
						}
					}
				}
			}
			$kq='';
			$kq['view_report'] = '
						<div class="col-lg-12 color-white text-center">
							<h4>'.$lang['lb_WHREPORT'].'<!--BÁO CÁO TỒN KHO--></h4>
						</div>
						<table class="table table-bordered bg-white">
							<thead>
								<tr class="bg-ccc">
									<th class="text-center" width="5%">'.$lang['lb_ItemsID'].'<!--Mã HH--></th>
									<th class="text-center">'.$lang['lb_namegd'].'<!--Tên hàng--></th>
									<th class="text-center" width="7%">'.$lang['lb_impunit'].'<!--Đ/v Nhập--></th>
									<th class="text-center" width="7%">'.$lang['lb_coefficient'].'<!--Hệ số--></th>
									<th class="text-center" width="7%">'.$lang['lb_exportunit'].'<!--Đ/v Xuất--></th>
									<th class="text-center" width="8%">'.$lang['lb_beforedatereport'].'<!--Tồn đầu kỳ--></th>
									<th class="text-center" width="8%">'.$lang['lb_impindate'].'<!--Nhập trong kỳ--></th>
									<th class="text-center" width="8%">'.$lang['lb_expindate'].'<!--Xuất trong kỳ--></th>
									<th class="text-center" width="8%">'.$lang['lb_afterdatereport'].'<!--Tồn cuối kỳ--></th>
									<th class="text-center" width="7%">'.$lang['lb_convertvalue'].'<!--Quy đổi--></th>
									<th class="text-center" width="7%">'.$lang['lb_rinventory'].'<!--Tồn thực tế--></th>
									<th class="text-center" width="7%">'.$lang['lb_rdifference'].'<!--Chênh lệch--></th>
								</tr>
							</thead>
							<tbody id="goods_holder">
								'.$html.'
							</tbody>
						</table>
						';
			//tạo ra một inventory vào database
			$whinven_id = $wh_inven->add($sheetData['4']['E'],$sheetData['4']['G'],$_POST['files'],$dwh['id']);
			$kq['upload_id'] = $whinven_id;
			$kq = json_encode($kq);
			echo "done##".$kq;
		}else{
			echo $lang['lb_nopermissWH']; //"Bạn không có quyền truy cập kho này.";
		}
	}else{
		echo $lang['lb_noFile'];//Không tìm thấy file cần nhập
	}
	
}else if($act=='synchronization'){
	// $dwh_inven = $wh_inven->get_detail($_POST['whinven_id']);
	
	// set_include_path(get_include_path() . PATH_SEPARATOR . '../library/PHPExcel/');
		
	// $inputFileName = "../".$dwh_inven['url_excel'];
	// if (file_exists($inputFileName)) {
	// 	if($dwh_inven['synchronization']=='0'){
	// 		try {
	// 			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	// 		} catch(Exception $e) {
	// 			exit('Error loading file :' . $e->getMessage());
	// 		}
	// 		$objPHPExcel->setActiveSheetIndex(0);
	// 		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	// 		$dwh = $wh->get_detail($sheetData['5']['B']);
	// 		if($dUserLogin['create_user']==$dwh['username']){
	// 			$wh_id = $sheetData['5']['B'];
	// 			$i = 0;
	// 			foreach ($sheetData as $key=>$row) {
	// 				$i++;
	// 				if($i > 8){
						
	// 					$dgoods = $goods->get_detail($row['A']);
	// 					if($dgoods!=''){
	// 						//thêm vào database những gì đã đồng bộ
	// 						$wh_dtinven->add($_POST['whinven_id'],$row['A'],$row['G'],$row['H'],number_format_replace_cog($row['I']),number_format_replace_cog($row['J']),$row['K'],$row['L'],$row['M']);
	// 						//Thêm một record nhập kho type đồng bộ ()
	// 						$wh_history->create_synchronization($row['A'],$row['M'],$wh_id,'synchronization');
	// 					}
						
	// 				}
	// 			}
				
	// 			$wh_inven->update_synchronization($_POST['whinven_id'],$sheetData['5']['H']);
				
	// 			echo "done##sv";
	// 		}else{
	// 			echo $lang['lb_nopermissWH'];//Bạn không có quyền truy cập kho này
	// 		}
	// 	}else{
	// 		echo $lang['lb_syned'];//Đã đồng bộ.
	// 	}
	// }else{
	// 	echo "Không tìm thấy file cần nhập.";//Không tìm thấy file cần nhập.
	// }
	
}else{
	echo $lang['lb_noExistFile'];//Lỗi! Không có file được nhập vào.
}

function randString($length = 3) {
    $characters = '123414214214321431231354658767090932482734723655171798381923672362351637818324';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}