<?php
// ====== Lang choose Việt Nam
$lang["english"] = "English";
$lang["vietnamese"] = "Việt Nam";

// Global 
$lang['lb_logout'] = 'Logout';
$lang['lb_report'] = 'Reporting System';//Báo cáo
$lang['lb_table'] = 'Table';//Bàn
$lang['lb_done'] = 'Done'; //Hoàn tất
$lang['lb_reset'] = 'Reset';
$lang['lb_delete'] = 'Delete';
$lang['lb_deleteuser'] = 'Delete User'; //Xóa user
$lang['lb_amount'] = 'Qty';//Số lượng
$lang['lb_calculator'] = 'Calculator'; //Bảng tính
$lang['lb_view'] = 'View';//Xem
$lang['lb_day'] = 'Day'; //Ngày
$lang['lb_year'] = 'Year';//Năm
$lang['lb_month'] = 'Month'; //Tháng
$lang['lb_setting'] = 'Control Panel';//Nâng cao
$lang['lb_devtable'] = 'Divide Tables';//Chia bàn
$lang['lb_movtable'] = 'Move/Combine Tables';//Chuyển/Gộp bàn
$lang['lb_reset'] = 'Nhập lại';//Chuyển/Gộp bàn
$lang['nt_closedShift'] = 'Thông báo đã hết ca làm việc! Hệ thống sẽ tự động thoát ngay bây giờ.';
$lang['lb_update'] = 'Update'; //Cập nhật

// ====== login page
$lang["login"] = "Login";
$lang["login_name"] = "Username";
$lang["login_pass"] = "Password";
$lang["login_area"] = "Table Areas"; //Khu vực bàn
$lang["reset"] = "Reset";

//phpjquery/accountant_storing.php
$lang["lb_impExp"] = "Xuất/nhập kho";//Xuất/nhập kho
$lang["error_code"] = "Cannot identify the StockID"; // Không xác định được mã nhập kho
$lang["error_date_import_wh"] = "Please choose a date of Stocking in.";//Vui lòng chọn ngày nhập kho 
$lang["error_select_wh"] = "Please choose an appropriate warehouse."; //Vui lòng chọn kho hàng cần nhập
$lang["error_select_provider"] = "Please choose an appropriate supplier."; //Vui lòng chọn một nhà cung cấp
$lang["error_select_goods"] = "Please choose an appropriate item to stock in"; //Vui lòng chọn loại hàng nhập kho
$lang["error_valid_amount"] = "The entered number is not valid. It must be greater than 0."; //Số lượng nhập không hợp lệ, phải lớn hơn 0
$lang["error_valid_price"] = "The entered amount is not valid. It must be greater than 0."; //Đơn giá nhập không hợp lệ, phải lớn hơn 0
$lang["error_invalid_code"] = "The entered StockID could not be found."; //Không tìm thấy mã nhập kho này
$lang["error_invalid_date"] = "The chosen date is not valid."; //Chọn ngày báo cáo không hợp lệ
$lang["tt_allowZeroSell"] = "Allow sales when the product is stock out"; //Cho phép bán hàng khi số lượng = 0
$lang["lb_accoutingSetting"] = "Accounting Settings"; //Accounting Settings
$lang["tt_warehouse"] = "Warehouse"; //Kho hàng
$lang['lb_stoPay'] = 'Payment mtd'; //Thanh toán
$lang['lb_stoPayCash'] = 'Cash';//Tiền mặt
$lang['lb_stoPayTrans'] = 'Transfer';//Chuyển khoản
$lang["tt_importBy"] = "Imported by"; //Nhập bởi
$lang["lb_impCard"] = "Goods received notes"; //Phiếu nhập
$lang["lb_expCard"] = "Goods dispatched notes"; //Phiếu xuất
$lang["tt_expImpBy"] = "Received by/ Dispatched to"; //Xuất cho nhập bởi
$lang["tt_createdBy"] = "Created by"; //Tạo bởi
$lang["tt_transID"] = "Note #"; //Mã Giao Dịch
$lang['lb_stProID'] = 'Product ID (F5)';//Mã SP (F5)
$lang['lb_stoReset'] = 'Reset';//Nhập lại phiếu
$lang['lb_stoExpDate'] = 'Exp';//HSD

/*
all in folder m
*/
//m = accountant.php
$lang['tt_acc_storing'] = 'Stock in'; //Nhập hàng vào kho
$lang['tt_acc_report'] = 'Reporting'; //Báo cáo hàng hóa
$lang['tt_acc_index'] = 'Administrating Categories'; //Danh mục quản trị
$lang['tt_acc_info_vat'] = 'TAX Form'; //Nhập form vat

$lang['tt_acc_user_vat'] = 'Customer Managing'; //Quản lý khách hàng
$lang['tt_acc_recipe'] = 'Recipe Managing'; //Quản lý công thức
$lang['tt_acc_unit'] = 'Unit Converter'; //Quy đổi đơn vị
$lang['tt_acc_bills'] = 'Invoice Management'; //Quy đổi đơn vị
$lang['tt_acc_provider'] = 'List of Suppliers'; //Danh sách nhà cung cấp

/*
all in folder template
*/
// bills.tpl
$lang['lb_acbill_find_order'] = 'Order ID'; //Tìm order
$lang['lb_acbill_ondate'] = 'Created date'; //Vào ngày
$lang['lb_acbill_bl2shop'] = 'Assigned to';//Thuộc CH
$lang['lb_acbill_find'] = 'Search'; //Tìm
$lang['lb_acbill_lorder'] = 'Order list'; //DS order
$lang['lb_acbill_from'] = 'From';
$lang['lb_acbill_to'] = 'To';
$lang['lb_incorrectTime'] = 'Thời gian không hợp lệ';
$lang['lb_incoDecrement'] = 'Giá trị giảm không hợp lệ, phải nhỏ hơn tổng giá trị của ngày.';
$lang['lb_nopermissWH'] = 'Bạn không có quyền truy cập kho này';
$lang['lb_noFile'] = 'Không tìm thấy file cần nhập';
$lang['lb_syned'] = 'Đã đồng bộ.';
$lang['lb_noFouPro'] = 'Không tìm thấy sản phẩm';
$lang['lb_noExistFile'] = 'Lỗi! Không có file được nhập vào.';

// import.tpl
$lang['lb_acimp_createvat'] = 'Create Tax Invoice'; //Tạo hóa đơn vat
$lang['lb_acimp_mgcus'] = 'Customer Managing'; //Quản lý khách hàng
$lang['lb_acimp_cusname'] = 'Customer Name'; //Tên khách hàng
$lang['lb_acimp_mobile'] = 'Mobile'; //Số điện thoại
$lang['lb_acimp_company'] = 'Company Name'; //Tên đơn vị
$lang['lb_acimp_code'] = 'Tax ID';
$lang['lb_acimp_address'] = 'Address:';
$lang['lb_acimp_paytype'] = 'Payment Method:';
$lang['lb_acimp_accno'] = 'Acc No.'; //Số tài khoản
$lang['lb_acimp_gdsname'] = 'Items';
$lang['lb_acimp_value'] = 'Total Amount'; //Giá trị
$lang['lb_acimp_pervat'] = 'TAX Rate'; //Phần trăm VAT
$lang['lb_acimp_dorder'] = 'Order Date'; //Ngày order
$lang['lb_acimp_done'] = 'Done'; //Hoàn tất
$lang['lb_acimp_review'] = 'Preview'; //Xem trước
$lang['lb_notedessave'] = 'Save this customer info. into database.'; //Lưu thông tin khách hàng này vào hệ thống

// accountant/ index.tpl
$lang['lb_acin_mgcat'] = 'ACCOUNTING PANEL'; //DANH MỤC KẾ TOÁN
$lang['lb_acin_report'] = 'Report'; //Báo cáo
$lang['lb_acin_import'] = 'Imp./Exp. Stock'; //Nhập kho
$lang['lb_acin_vat'] = 'TAX Invoice'; //Hóa đơn VAT
$lang['lb_acin_cvunit'] = 'Unit Converter'; //Quy đổi đơn vị
$lang['lb_acin_recipe'] = 'Recipes'; //Công thức món ăn
$lang['lb_acin_hisorder'] = 'Orders History'; //Lịch sử order
$lang['lb_acin_supplier'] = 'Suppliers'; //Nhà cung cấp
$lang['lb_supplier'] = 'Suppliers'; //Nhà cung cấp
$lang['lb_acGeneral'] = 'General Ledger';//Quản lý thu chi
$lang['lb_acDept'] = 'I.O.U';//Công nợ
$lang['lb_acStockCounts'] = 'Stock counts';//Kiểm kê
// accountant / info_vat.tpl
$lang['lb_summoney'] = 'Total Amount'; //Tổng tiền
$lang['lb_deletevat'] = 'Delete Invoice'; //Xóa hóa đơn
$lang['lb_freview'] = 'Preview'; //Xem trước
$lang['lb_prinvat'] = 'Print Invoice'; //In hóa đơn 
// accountant / provider.tpl
$lang['lb_mgprovider'] = 'Suppliers Management'; //Quản lý nhà cung cấp
$lang['lb_nameprovider'] = 'Bussiness Name'; //Tên nhà cung cấp 
$lang['lb_contact'] = 'Contact Person'; //Người liên hệ 
$lang['lb_gdsprovider'] = 'Supplied Items'; //Sản phẩm cung cấp

// accountant / user_vat.tpl
$lang['lb_deletecus']= 'Delete Customer'; //Xóa khách hàng
// main / index.tpl
$lang['lb_main_cashier'] = 'Cashier';// Thu ngân
$lang['lb_main_autoprint'] = 'Receive printing orders automatically';//Nhận lệnh in tự động
$lang['lb_main_sltable'] = 'Chosen table';//Chọn bàn
$lang['lb_main_udprice'] = 'Chosen price bracket';//Cập nhật bảng giá
$lang['lb_main_cctable'] = 'Cancel table';//Hủy bàn
$lang['lb_main_shift'] = 'Work Shift'; //Giao Ca
$lang['lb_main_optable'] = 'Open Table';//Mở bàn
$lang['lb_main_paid'] = 'Collected';//Đã thu tiền
$lang['lb_main_noorder'] = 'Invoice ID';//Số HĐ
$lang['lb_main_SN'] = 'SN';
$lang['lb_tngan'] = 'Cashier';//T.Ngân
$lang['lb_KHang'] = 'Customer';//K.Hàng
$lang['lb_main_NV'] = 'Wait Staff'; //NV
$lang['lb_SL'] = 'QTY'; //SL
$lang['lb_goods'] = 'Items';
$lang['lb_price'] = 'Price';//Giá
$lang['lb_dish'] = 'Food';//Món ăn
$lang['lb_drinking'] = 'Beverage';//Thức uống
$lang['lb_others'] = 'Others'; //Khác
$lang['lb_cfirorder'] = 'Confirmed Order';//Xác nhận order
$lang['lb_cancel'] = 'Cancel';//Hủy
$lang['lb_return'] = 'Return';//Trả lại
$lang['lb_opprice'] = 'Giá mở <p class="font-size-10">(Updating ...)</p>';//Giá mở
$lang['lb_sum'] = 'Total Amount';//Tổng cộng
$lang['lb_desdish'] = 'Dishes Notes';//Diễn giải món ăn
$lang['lb_savedes'] = 'Save Notes';//Lưu diễn giải
$lang['lb_pridrink'] = 'Print beverage order';//In order nước
$lang['lb_pridish'] = 'Print food order';//In order món ăn
$lang['lb_desreturn1'] = '(Orders that havent been in cooking process could be canceled)'; //(Các món chưa làm xong, thì có thể trả lại)
$lang['lb_lefts'] = 'Remaining'; //còn
$lang['lb_rtreason'] = 'Reason';//Lý do trả
$lang['lb_cancelreason'] = 'Reason';//Lý do hủy
$lang['lb_recentamount'] = 'The current amount'; //Số lượng hiện tại
$lang['lb_leftamount'] = 'The remain amount'; //Số lượng còn lại
$lang['lb_conlai'] = 'Remaining'; //còn lại
$lang['lb_paid'] = 'Print Bill'; //Tính tiền
$lang['lb_VAT'] = 'TAX'; //Tính tiền
$lang['lb_KNo'] = '<p class="font-size-10">Customer owe</p>';//Khách nợ
$lang['lb_TheVip'] = '<p class="font-size-10">VIP Card (Updating ...)</p>';//Thẻ VIP
$lang['lb_VISAC'] = 'Card Payment';//Thanh toán thẻ
$lang['lb_USD'] = 'Foreign Currencies';//T.Toán ngoại tệ
$lang['lb_PaidBF'] = '<p class="font-size-10">Advanced Payment</p>';//Trả trước
$lang['lb_decre'] = '<p class="font-size-10">Discount</p>';//Giảm tiền
$lang['lb_serve'] = '<p class="font-size-10">Treating</p>';//Tiếp khách
$lang['lb_priTam'] = 'Temporary print';//In tạm
$lang['lb_updateprice'] = 'Prices Option in used'; //sử dụng bảng giá
$lang['lb_desupprice'] = 'Update all of the current orders with the chosen price bracket.'; //Đồng thời cập nhật các món đã gọi với bảng giá này
$lang['lb_reportfinance'] = 'Summary report'; //Báo cáo tài chính
// m / appointed.tpl
$lang['lb_booktable'] = 'Reservation'; //Đặt bàn
$lang['lb_back'] = 'Back';//Trở lại
$lang['lb_TenKH'] = 'Customer Name'; //Tên.KH
$lang['lb_mobile'] = 'Mobile';//Điện thoại
$lang['lb_today'] = 'Booking date';//Người đặt lịch
$lang['lb_tohour'] = 'Booking time';//Thời gian đặt lịch
$lang['lb_hour'] = 'Hour';//Giờ
$lang['lb_minute'] = 'Min';//Phút
$lang['lb_nocus'] = 'Customer Qty'; //Số khách
$lang['lb_datcoc'] = 'Bond'; //Đặt cọc
$lang['lb_huydat'] = 'Cancel'; //Hủy
// m / area.tpl
$lang['lb_home'] = 'Home';// Trang chủ
$lang['lb_slshop'] = 'Choose a Store'; //Chọn cửa hàng
$lang['lb_area'] = 'Areas';// Khu vực
$lang['lb_findtable'] = 'Search table';// Tìm bàn
$lang['lb_currency'] = 'AUD';// đ
$lang['lb_notpermis'] = 'You are not granted to access.'; //Bạn không được cấp phép truy cập
// m / bill.tpl
$lang['lb_dtorder'] = 'Order details';//Chi tiết order
$lang['lb_pribill'] = 'Print bill';//In bill
 // m / call.tpl
$lang['lb_calldish'] = 'Making order'; //Gọi món
$lang['lb_ordered'] = 'Ordered list';//Đã order
$lang['lb_PVu'] = 'Wait staff';//P.Vụ
$lang['lb_finddish'] = 'Search';//Tìm món
$lang['lb_note'] = 'Notes';//Ghi chú
//m cooked.tpl
$lang['lb_updated'] = 'Updated';//Đã cập nhật
//m detail_order.tpl
$lang['lb_confirm'] = 'Confirm';//Xác nhận
// supervisor accountant.tpl
$lang['lb_warehouse'] = 'Warehouse'; //Kho hàng
$lang['lb_imwh'] = 'Stock in'; //Nhập kho
$lang['lb_importWH'] = 'Import stock';
$lang['lb_exportWH'] = 'Good dispatched';
$lang['lb_createCard'] = 'Note';
//supervisor area.tpl
$lang['lb_maptable'] = 'Tables Areas'; //Sơ đồ bàn
$lang['lb_ltable'] = 'List of Tables'; //Danh sách bàn
$lang['lb_addarea'] = 'Add Area'; //Thêm khu vực
$lang['lb_namearea'] = 'Area name'; //Tên khu vực
$lang['lb_addtable'] = 'Add Table'; //Thêm bàn
$lang['lb_nametable'] = 'Table name'; //Tên bàn
//supervisor bills.tpl
$lang['lb_mgorder'] = 'Order Managing'; //Quản lý order
$lang['lb_pritemp'] = 'Temporary Bill'; //Phiếu in tạm
$lang['lb_PRITEMP'] = 'Temporary Bill'; //PHIẾU IN TẠM
$lang['lb_sumbill'] = 'Total'; //Tổng tiền
$lang['lb_decrement'] = 'Discount';//Giảm giá
$lang['lb_DECREMENT'] = 'DISCOUNT';//GIAM GIA
$lang['lb_TCong'] = 'Total amount';//T.Cộng
$lang['lb_TCONG'] = 'TOTAL AMOUNT';//T.CỘNG
$lang['lb_thankscus'] = 'Thank you and See you again'; //Xin cảm ơn quý khách
$lang['lb_notfoundorder'] = 'Order could not be found'; //Không tìm thấy order
 //supervisor calendar.tpl
$lang['tt_calendar'] = 'Access Roster'; //Lịch làm việc
$lang['tt_manage'] = 'Managers'; //Quản lý
$lang['tt_accountant'] = 'Accountants'; //Kế toán
$lang['tt_cashier'] = 'Cashiers'; //Thu ngân
$lang['Admin'] = 'Admin'; //Tổng quản
$lang['Manager'] = 'Managers'; //Quản lý
$lang['Accountant'] = 'Accountants'; //Kế toán
$lang['Treasure'] = 'Treasure'; //Kế toán
$lang['Staff'] = 'Staff'; //NV nghiep vu
$lang['tt_shift1'] = '1st Shift'; //Ca 1 
$lang['tt_shift2'] = '2nd Shift'; //Ca 2
$lang['lb_calReset'] = 'Reset';//Nhập lại
$lang['lb_calDone'] = 'Done';//Hoàn tất
//supervisor category.tpl
$lang['lb_mgmenu'] = 'Menu Managing'; //Quản lý menu
$lang['lb_tbprice'] = 'Price Bracket'; //Khung giá
$lang['lb_mon'] = 'Items'; //Món
$lang['lb_dishname'] = 'Dish name'; //Tên món
$lang['lb_unit'] = 'Unit'; //Đơn vị
$lang['lb_tra_huy'] = 'Cancel/Return'; //Trả/hủy
$lang['lb_yes'] = 'Yes'; //Có
$lang['lb_no'] = 'No'; //Không
$lang['lb_display'] = 'Visible'; //Hiển thị
$lang['lb_deletedish'] = 'Delete Dish'; //Xóa món

$lang['lb_show'] = 'View';//View
$lang['lb_record'] = 'records';//records
$lang['lb_found'] = 'Found total';//Found total
$lang['lb_recordTotal'] = 'records';//records

//clone category
$lang['lb_cloneCat'] = 'Sao chép danh mục';
$lang['lb_clChooseShop'] = 'Choose a store';
$lang['lb_clPrice'] = 'Copy prices';
$lang['lb_clCategory'] = 'Copy sub categories';
$lang['lb_clRootCat'] = 'Copy main categories';
$lang['lb_cloneCat'] = 'Items';
$lang['lb_btnClone'] = 'Copy';
$lang['lb_btnDelDish'] = 'Delete';
$lang['nt_clNoFouCat'] = 'Could not find the sub-category in the destinition due to copy.';
$lang['nt_NoFouCat2Cl'] = 'Could not find the sub-category for copying.';
$lang['nt_subCatExist'] = 'The selected sub-category could not be continued to copy.';

//supervisor device.tpl
$lang['tt_setpermis'] = 'Device Granting'; //Cấp phép thiết bị
//supervisor index.tpl
$lang['tt_admincat'] = 'Control Panel'; //Danh mục quản trị
$lang['lb_sellgds'] = 'Total sales'; //Bán hàng
$lang['lb_lb_posTitle'] = 'POS sales';//Bán hàng
$lang['lb_shop'] = 'Shop';//Cửa hàng
$lang['lb_menu'] = 'Menu';
$lang['lb_member'] = 'Member';//Khách hàng
$lang['lb_setcalendar'] = 'Access Roster'; //Đặt lịch làm việc
$lang['lb_accounting'] = 'Accounting'; //Kế toán
$lang['lb_shiftdate'] = 'Shift handover'; //Nhật ký giao ca
$lang['lb_customers'] = 'CRM'; //Khách hàng
$lang['lb_exportVoucher']= 'Export Vouchers';//Xuất Vouchers
$lang['lb_VoucherCoupon']= 'Coupons';//Voucher/ Coupon
$lang['lb_validUntil'] = 'Valid Until';//Hạn sử dụng
$lang['lb_unlimit']='Lifetime license';//Không giới hạn
$lang['tt_shareholder'] = 'Share Holders'; //Cổ đông
$lang['lb_chanelsell'] = 'Store List'; //Kênh bán hàng
$lang['tt_holderpermis'] = 'Granting permission to share holders'; //Cấp phép khách hàng hội đồng
$lang['tt_product'] = 'Products'; //Sản phẩm
//supervisor recipe.tpl
$lang['tt_buildrecipe'] = 'Build-up recipe'; //Xây dựng công thức 
$lang['lb_slddish'] = 'Selected item'; //Món được chọn
$lang['lb_sldish'] = 'Choose a dish'; //Chọn món
$lang['lb_vattu'] = 'Ingredients'; //Vật tư
$lang['lb_addnglieu'] = 'Choose Ingredient'; //Thêm nguyên liệu
$lang['lb_group'] = 'Group'; //Nhóm
$lang['lb_subCat'] = 'Subcat'; //Danh mục
$lang['lb_subCat2'] = 'Category';
$lang['lb_catdish'] = 'List of Dishes'; //Danh mục món
$lang['lb_addrecipe'] = 'Add Ingredient'; //Thêm mới nguyên liệu
$lang['lb_namerecipe'] = 'Ingredient Name'; //Tên Nguyên liệu
$lang['lb_quantification'] = 'Qty in used'; //Định lượng
//accountant report.tpl
$lang['tt_sysreport'] = 'Report System'; //Hệ thống báo cáo
$lang['lb_typereport'] = 'Report type'; //Loại báo cáo
$lang['lb_sellreport'] = 'Sales Report'; //Báo cáo bán hàng chi tiết
$lang['lb_cancelreport'] = 'Canceled order report'; //Báo cáo hủy order
$lang['lb_returnReport'] = 'Refund Report';
$lang['lb_dcancelreport'] = 'Sales Return in Details'; //Báo cáo hủy order chi tiết
$lang['lb_usedreport'] = 'Costs of Sales'; //Báo cáo tiêu hao vật tư
$lang['lb_whreport'] = 'Inventory Report'; //Báo cáo tồn kho
$lang['lb_discountReport'] = 'Discount Report';//Báo cáo giảm giá
$lang['lb_rpUpdate'] = 'Adjust';//Cập nhật
$lang['lb_reportto'] = 'Report achieved from Shop'; //Báo cáo cho cửa hàng
$lang['lb_reportfrom'] = 'From'; //Báo cáo từ ngày
$lang['lb_download'] = 'Download'; //Tải về
$lang['lb_codegd'] = 'Product ID'; //Mã hàng
$lang['lb_namegd'] = 'Product name'; //Tên Hàng
$lang['lb_billprice'] = 'Unit Price'; //Đơn giá
$lang['lb_cancelby'] = 'Cancel'; //Hủy bởi
$lang['lb_at'] = '@';//Lúc
$lang['lb_reason'] = 'Reason';//Lý do
$lang['lb_reInvSTT'] = '#';//STT
$lang['lb_stCheckedBy'] = 'Checked By';//Người kiểm
$lang['lb_rpInVa'] = 'Inventory Value Report';//Báo cáo giá trị hàng tồn
$lang['lb_reInvProName']='Product name';// Tên sản phẩm
$lang['lb_reInvQty']='Qty';// Số lượng
$lang['lb_reInvUPrice']='Unit price';//Đơn giá nhập
$lang['lb_reInvTotal']='Total';//Thành tiền
$lang['lb_reInvValue'] = 'INVENTORY VALUE REPORT';//BÁO CÁO THỐNG KÊ GIÁ TRỊ HÀNG TỒN
$lang['lb_reInvTsl'] = 'Total items';//Tổng số lượng
$lang['lb_reInvTgt'] = 'Total value';//Tổng giá trị
$lang['lb_refId'] = 'Item ID';//Mã hàng
$lang['lb_refPrice'] = 'Unit price';//Đơn giá
$lang['lb_refSubT'] = 'Sub Total';//Thành tiền
$lang['lb_refOrder'] = 'Order #';//Mã Order
$lang['lb_refAt'] = 'Time';//Lúc
// supervisor shift_history.tpl
$lang['lb_hisshift'] = 'Shift Handover Records'; //Lịch sử giao ca của
$lang['lb_ttreportfromto'] = 'Recording period'; //Báo cáo từ ngày đến ngày 
//supervisor shop.tpl
$lang['lb_mgshop'] = 'Store Management'; //Quản lý cửa hàng
$lang['lb_lshop'] = 'List of Stores'; //Danh sách cửa hàng
$lang['lb_addwh'] = 'Create Warehouse'; //Tạo kho
$lang['lb_addshop'] = 'Add New Store'; //Thêm cửa hàng mới
$lang['lb_nameshop'] = 'Store Name'; //Tên cửa hàng
$lang['lb_whofshop'] = 'Warehouse assigned to'; //Kho thuộc cửa hàng
$lang['lb_address'] = 'Address'; //Địa chỉ
$lang['lb_noshiftonshop'] = 'Shift Handover'; //Số lần giao ca
$lang['lb_deleteshop'] = 'Delete shop'; //Xóa cửa hàng
$lang['lb_paidtype'] = 'Payment Method'; //Hình thức thành toán
$lang['lb_cashes'] = 'Cash'; //Tiền mặt
$lang['lb_VISA'] = 'VISA Card'; //Thẻ VISA
$lang['lb_master'] = 'Master Card'; //Thẻ Master
$lang['lb_ATM'] = 'ATM Card'; //Thẻ ATM
$lang['lb_tranfer'] = 'Transfer'; //Chuyển khoản
$lang['lb_pmK'] = 'MB360 Pay'; //
// supervisor storing 
$lang['lb_cvtunit'] = 'Unit Converter'; //Quy đổi đơn vị
$lang['lb_imwhcode'] = 'Note #'; //Mã nhập kho
$lang['lb_noimport'] = 'Quantity'; //Số lượng nhập
$lang['lb_addgd'] = 'Add item'; //Thêm sản phẩm
$lang['lb_deletegd'] = 'Delete item'; //Xóa hàng hóa
$lang['tt_linwh'] = 'RECORD OF STOCK NOTES'; //THỐNG KÊ KHO HÀNG
$lang['lb_viewreport'] = 'View Report'; //Xem báo cáo
$lang['lb_imdate'] = 'Stock-in Date'; //Ngày nhập kho
//supervisor unit.tpl
$lang['lb_addnew'] = 'Add new item'; //Thêm mới
$lang['lb_sldelete'] = 'Delete selected'; //Xóa được chọn
$lang['lb_STT'] = 'No.'; //STT
$lang['lb_unitimwh'] = 'Importing Unit'; //Đ/vị nhập kho
$lang['lb_unituse'] = 'Exporting Unit'; //Đ/vị sử dụng
$lang['lb_func'] = 'Functions'; //Chức năng
$lang['lb_typegds'] = 'Product Type'; //Loại hàng
$lang['lb_factor'] = 'Conversion Ratio'; //Hệ số
$lang['lb_addgds'] = 'Add Item'; //Thêm hàng hóa
$lang['lb_calunit'] = 'Calculating Unit'; //Đơn vị tính
$lang['lb_addcalunit'] = 'Add Calculating Unit'; //Thêm đơn vị tính
$lang['lb_nameunit'] = 'Unit Name'; //Tên đơn vị tính
$lang['lb_expunit'] = 'Exporting Unit'; //Đơn vị xuất

// supervisor user.tpl
$lang['lb_mguser'] = 'Staff Management'; //Quản lý người dùng
$lang['lb_username'] = 'User name';
$lang['lb_pass'] = 'Password'; //Mật khẩu
$lang['lb_fullname'] = 'Full Name'; //Tên đầy đủ
$lang['lb_status'] = 'Status'; //Trạng thái
$lang['lb_bl2shop'] = 'Work at'; //Thuộc cửa hàng
$lang['lb_cellphone'] = 'Mobile'; //Di động
$lang['lb_phone'] = 'Phone'; //Điện thoại
$lang['lb_email'] = 'Email'; //Email
$lang['lb_bankname'] = 'Bank Name'; //Tên Ngân Hàng
$lang['lb_branch'] = 'Branch'; //Chi nhánh
$lang['lb_accname'] = 'Account Name'; //Tên TK
$lang['lb_accno'] = 'Account No.'; //Số TK
$lang['lb_defaupass'] = 'Reset Password'; //Đặt lại mật khẩu
$lang['lb_setpermisdev'] = 'Granting access for new device'; //Cấp phép đăng nhập thiết bị mới
$lang['tt_notesetpermis'] = 'Granting access for a new device'; //Cho phép đăng nhập một thiết bị bất kỳ
$lang['lb_userShipper'] = 'Delivery men';//Nhân viên giao nhận
$lang['lb_userVehicle'] = 'Vehicle';//Phương tiện
$lang['lb_Delivery'] = 'Delivery';//Giao nhận

// supervisor user_mobile.tpl
$lang['lb_active'] = 'Activate'; //Kích hoạt
// supervisor warehouse.tpl
$lang['tt_mgwh'] = 'WAREHOUSE MANAGEMENT'; //QUẢN LÝ KHO
$lang['lb_lwh'] = 'List of Warehouses'; //Danh sách kho
$lang['lb_createshop'] = 'Add Store'; //Tạo cửa hàng
$lang['lb_addwh'] = 'Add Warehouse'; //Thêm kho
$lang['lb_namewh'] = 'Warehouse Name'; //Tên kho
$lang['lb_wareAsto'] = 'Assigned to';//Thuộc cửa hàng
$lang['lb_deletewh'] = 'Delete Warehouse'; //Xóa kho
$lang['lb_material'] = 'Ingredient'; //Nguyên liệu
$lang['lb_product'] = 'Finished Product'; //Thành phẩm
$lang['tt_uservat'] = 'TAX-ORDERED CUSTOMER MANAGING'; //QUẢN LÝ KHÁCH HÀNG XUẤT VAT
$lang['tt_mgtempvat'] = 'TAX INVOCE FORM'; //Quản lý mẫu VAT
$lang['lb_donex'] = 'Done';//Xong
$lang['lb_ldrinkorder'] = 'LIST OF BEVERAGE ORDERS';//DANH SÁCH ORDER NƯỚC
$lang['lb_lorderdish'] = 'LIST OF FOOD ORDERS';//DANH SÁCH ORDER MÓN ĂN
$lang['lb_priority'] = 'Priority';//Ưu tiên
$lang['lb_second'] = 'second';//giây
$lang['lb_sumorder'] = 'Total orders';//Tổng order
$lang['lb_page'] = 'Page';//Trang
$lang['lb_canceldis'] = 'Cancel'; //Hủy món
$lang['lb_making'] = 'Cooking';//Chế biến
$lang['lb_addNewShop'] = 'Add Store'; //Thêm mới cửa hàng
$lang['lb_limitaccess'] = 'Limit Access'; //Giới hạn truy cập
$lang['lb_limitnote'] = 'For safety reason, you are not allowed to accessed on this browser.<br> Please access on the allowed browser or contact the administrator for further support.'; //Vì lý do an toàn bạn bị giới hạn truy cập trên trình duyệt này, hãy đăng nhập trên trình duyệt được cấp phép.<br> Hoặc liên hệ quản trị để được cấp phép truy cập mới

// phpjquery folder
//accountant_bills.php
$lang['nt_redirect'] = 'Forwarding to login page'; //Chuyển đến trang đăng nhập
$lang['nt_asklogin'] = 'You are not logged in. Please log in before using.'; //Bạn chưa đăng nhập. Vui lòng đăng nhập vào hệ thống trước khi sử dụng
$lang['nt_permisaccess'] = 'You are not authorised for this function'; //Bạn không có quyền sử dụng chức năng này
$lang['error'] = 'Error'; //Lỗi

$lang['nt_accessshoppermis'] = 'You are accessing in an unauthorised shop'; //Truy cập vào cửa hàng không được phép
$lang['nt_invaliddate'] = 'Please choose a valid date'; //Vui lòng chọn ngày hợp lệ

$lang['nt_incusname'] = 'Please enter customer name'; //Vui lòng nhập tên khách hàng
$lang['nt_inmobile'] = 'Please enter customer mobile'; //Vui lòng nhập số điện thoại khách hàng
$lang['nt_incompany'] = 'Please enter Company name'; //Vui lòng nhập tên đơn vị - Công ty
$lang['nt_invatcode'] = 'Please enter IBN'; //Vui lòng nhập mã số thuế
$lang['nt_inaddress'] = 'Please enter an address'; //Vui lòng nhập địa chỉ liên lạc
$lang['nt_ingoods'] = 'Please enter items description'; //Vui lòng nhập tên hàng hóa
$lang['nt_invaluevat'] = 'Please enter invoice value'; //Vui lòng nhập giá trị hóa đơn
$lang['nt_inpervat'] = 'Please enter TAX rate'; //Vui lòng nhập phần trăm giá trị gia tăng
$lang['nt_indateexpvat'] = 'Please enter invoice issue date'; //Vui lòng nhập ngày xuất hóa đơn
$lang['nt_indate'] = 'Chosen date is invalid'; //Ngày không hợp lệ
$lang['nt_candishontable'] = 'Please delete all items belong to this table'; //Vui lòng hủy món của bàn
$lang['nt_candishontableaf'] = 'before cancel this table'; //trước khi hủy bàn này
$lang['nt_canpermistable'] = 'You are not authorised to this command'; //Bạn không có quyền hủy

//add more
$lang['lb_cashfloat'] = 'Register float';// Số dư đầu ca
$lang['lb_totalsales'] = 'Main Functions';//Chức năng chính
$lang['lb_collected'] = 'Total income';// Đã thu
$lang['lb_searchtable'] = 'Search table';// Tìm kiếm bàn
$lang['lb_noorder'] = 'No order';// Chưa có order
$lang['lb_levents'] = 'List of events';// Danh sách sự kiện
$lang['lb_levents'] = 'Error! Please choose a dish';// Lỗi! Vui lòng chọn một món
$lang['lb_placeholsesearch'] = 'Enter the name of dish';// Tìm món trong placeholder ô tìm món
$lang['lb_priceused'] = 'Price bracket in used';// Áp dụng bảng giá
$lang['lb_sltbdelete'] = 'Please choose a table to delete';// Vui lòng chọn một bàn để hủy
$lang['lb_cfdishdelete'] = 'Are you sure to delete this dish';// Bạn có chắc là muốn hủy món
$lang['lb_cftabledelete'] = 'Are you sure to delete this table';// Bạn có chắc là muốn xóa bàn này
$lang['lb_cfconlpayment'] = 'Are you sure to collect payment this table';// Bạn có chắc là muốn xóa bàn này
$lang['lb_cfpribill'] = 'Do you want to print bill this table';// Bạn có chắc là muốn xóa bàn này
$lang['lb_sldishdelete'] = 'Please choose a dish to delete'; // Vui lòng chọn một món để xóa
$lang['lb_chefmod'] = 'Chef assisting mod'; // Chef mod
$lang['lb_close'] = 'Close'; // Thoát
$lang['lb_vieworder'] = 'View order';// Xem order
$lang['lb_movecombinetb'] = 'Movie/Combine table';// Dời/gộp bàn
$lang['lb_dividetable'] = 'Divide table';// Chia bàn
$lang['lb_save'] = 'Save';// Lưu
$lang['lb_mncollected'] = 'Collected';// Thu tiền
$lang['lb_dishes'] = 'Dishes';// Món ăn
$lang['lb_dishesreturned'] = 'Dishes returned';// Trả lại món
$lang['lb_signout'] = 'Sign out';// Thoát
$lang['lb_salereport'] = 'Quick sales report';//Báo cáo
$lang['lb_printbill'] = 'Print bill';//Tính tiền
$lang['lb_print'] = 'In Bill';//Print bill
$lang['lb_printA4'] = 'In Order A4';//Print bill A4
$lang['lb_printA5'] = 'In Order A5';//Print bill A5

/*
part 2
*/
$lang['lb_impunit'] = 'Importing Unit';//Đơn vị nhập
$lang['lb_coefficient'] = 'Converting'; //Hệ số
$lang['lb_exportunit'] = 'Exporting Unit';//Đơn vị xuất
$lang['lb_beforedatereport'] = 'Initial Stock'; //Tồn đầu kỳ
$lang['lb_impindate'] = 'Imp. Qty'; //Nhập trong kỳ
$lang['lb_expindate'] = 'Exp Qty'; //Xuất trong kỳ
$lang['lb_afterdatereport'] = 'Final Stock'; //Tồn cuối kỳ
$lang['lb_convertvalue'] = 'Converted'; //Quy đổi
$lang['lb_WHREPORT'] = 'Inventory Report';//BÁO CÁO TỒN KHO
$lang['lb_detail'] = 'Details';//Chi tiết
$lang['lb_selectlang'] = 'Choosing Language'; //Chọn ngôn ngữ hệ thống
$lang['tt_language'] = 'Language';//Ngôn ngữ
$lang['er_004'] = 'Error: 004'; //Lỗi:004
$lang['er_003'] = 'Error: 003'; //Lỗi:003
$lang['lb_reportcreater'] = 'Report created by'; //Người lập bảng báo cáo
$lang['lb_fromdate'] = 'Day......Month......Year......'; //Ngày......tháng......năm......
$lang['lb_createdate'] = 'Created date'; //Ngày lập
$lang['lb_createperson'] = 'Created By'; //Người lập
$lang['lb_startday'] = 'From'; //Từ ngày
$lang['lb_endday'] = 'To'; //Đến ngày

$lang['lb_inpnamesupplier'] = 'Please enter Supplier name'; //Vui lòng nhập tên nhà cung cấp
$lang['lb_inpnamecontact'] = 'Please enter a contact name'; //Vui lòng nhập tên người liên hệ
$lang['lb_inpphone'] = 'Please enter mobile phone'; //Vui lòng nhập số điện thoại
$lang['lb_notsupplier'] = 'Supplier could not be found'; //Không tìm thấy nhà cung cấp
$lang['lb_notdish2recipe'] = 'Could not find dish that needs to make recipe'; //Không tìm thấy món cần lập công thức
$lang['lb_discount'] = 'Discount'; //Giảm giá
$lang['lb_finalbill'] = 'Total'; //Thành tiền
$lang['lb_notorders'] = 'Waiting for order'; //Chưa gọi món
$lang['lb_notdish2collected'] = 'There is no order, so could not be collected.'; //Order chưa có món nên không thể tính tiền
$lang['lb_notordersent'] = 'Waiting for order/ All orders are sent'; //Chưa gọi món/tất cả đã được gửi
$lang['lb_pricebracklet'] = 'Price Bracket'; //Bảng giá
$lang['lb_notexistuser'] = 'User could not be found'; //Không tìm thấy tài khoản
$lang['lb_erpass'] = 'Invalid password. Please try again.'; //Sai mật khẩu. Vui lòng thử lại
$lang['lb_noteshiftpermis'] = ''; //Tài khoản này không được phép thực hiện bàn giao ca. Vì không đủ quyền hay không thuộc sự quản lý
$lang['lb_rqotheruser'] = ''; //Yêu cầu người nhận ca khác khách hàng
$lang['lb_recentshiftof'] = 'Vì hiện tại là ca của';//
$lang['lb_limitviewreportdt'] = 'Số lần xem báo cáo đã hết. Bạn không thể xem báo cáo lúc này';//
$lang['lb_donthavepermis'] = 'You are not authorised for using this function.';//
$lang['lb_shiftself'] = 'Bạn không thể tự bàn giao. Cần một quản lý xác nhận ca bàn giao này';//
$lang['lb_notenoughpermis'] = 'Bạn không đủ quyền để thực hiện nạp tiền vào hệ thống';//
$lang['lb_clemptytable'] = 'Bàn trống, không thể thu tiền';//
$lang['lb_eremptytablemove'] = 'Bàn đang trống không thể thực hiện chuyển gộp';//
$lang['lb_bl2table'] = 'của bàn';//
$lang['lb_move2table'] = 'chuyển sang bàn';//
$lang['lb_with'] = 'với';//
$lang['lb_moved2table'] = 'Đã chuyển sang bàn';//

$lang['lb_rqdtemptytable'] = 'Bàn chưa có món. Vui lòng dùng chức năng hủy bàn';//
$lang['lb_collecttable'] = 'Thu tiền bàn';//
$lang['lb_amountmoney'] = 'Số tiền';//
$lang['lb_updatebrackletpermis'] = 'Bạn không có quyền cập nhật bảng giá';//
$lang['lb_notexsitbracklet'] = 'Bảng giá không tồn tại';//
$lang['lb_updatedbracklet'] = 'Đã cập nhật bảng giá';//
$lang['lb_nothavepermis'] = 'Bạn không có đủ quyền để thực hiện giảm giá';//
$lang['lb_notdish2discount'] = 'Không tìm thấy món cầm giảm giá';//
$lang['lb_notfdish'] = 'Không tìm thấy món yêu cầu';//
$lang['lb_inpinvalidreturn'] = 'Số lượng trả lại không hợp lệ';//
$lang['lb_jqreturn'] = 'Return';//Trả lại
$lang['lb_jqdish'] = 'dish(es)';//món
$lang['lb_madenotreturn'] = 'Món đã được làm xong không thể trả lại';//
$lang['lb_canceled'] = 'Đã hủy';//
$lang['lb_jqcancel'] = 'Hủy';//
$lang['lb_noti2chef'] = 'Vui lòng thông báo đến pha chế';//
$lang['lb_emptytable'] = 'Bàn đang trống';//
$lang['lb_jqmaterial'] = 'Ingredient'; //Nguyên liệu
$lang['lb_jqdelete'] = 'Delete'; //Xóa
$lang['lb_jqedit'] = 'Edit'; //Cập nhật 
$lang['lb_jqnameitem'] = 'Product Name'; //
$lang['lb_jqSELLREPORTDT'] = 'SALES REPORT'; //BÁO CÁO BÁN HÀNG CHI TIẾT
$lang['lb_jqservice'] = 'Service'; //
$lang['lb_jqtax'] = 'TAX'; //
$lang['lb_jqbaseprice'] = 'COGS'; //
$lang['lb_jqlaiBH'] = 'Gross Profit'; //
$lang['lb_cancelorderreport'] = 'CANCELED ORDERS REPORT'; // BÁO CÁO HỦY ORDER
$lang['lb_jqamount'] = 'Quantity';//Số lượng
$lang['lb_jqcancelby'] = 'Canceled by'; //Hủy bởi
$lang['lb_jqReturnby'] = 'Handled by'; //Trả bởi

$lang['lb_jqreason'] = 'Reason';//Lý do
$lang['lb_jqsum'] = 'Total Amount';//Tổng cộng
$lang['lb_jqdcancelreport'] = 'CANCELED ORDER REPORT'; //BÁO CÁO HỦY ORDER CHI TIẾT
$lang['lb_jqReturnReport'] = 'REFUND REPORT'; //
$lang['lb_jqinpaddress'] = 'Vui lòng nhập đại chỉ'; //
$lang['lb_jqinpphone'] = 'Vui lòng nhập số điện thoại'; //
$lang['lb_jqnotwh'] = 'Không tìm thấy kho hàng bạn chọn để thêm nhà cung cấp'; //
$lang['lb_jqinpexsitsupplier'] = 'Đã có tên nhà cung cấp này. Vui lòng chọn một tên khác'; //
$lang['lb_jqinpnamepro'] = 'Vui lòng nhập tên sản phẩm'; //
$lang['lb_jqinpunit'] = 'Vui lòng chọn đơn vị tính'; //
$lang['lb_jqinptypeitem'] = 'Vui lòng chọn loại của hàng hóa'; //
$lang['lb_jqinpwh_id'] = 'Không tìm thấy kho hàng'; //
$lang['lb_jqexsitnameitem'] = 'Tên sản phẩm này đã được tạo'; //
$lang['lb_jqinpnameunit'] = 'Vui lòng nhập tên của đơn vị tính'; //
$lang['lb_jqinpvalcvt'] = 'Vui lòng nhập giá trị chuyển đổi'; //
$lang['lb_jqinpnamecvt'] = 'Vui lòng chọn tên chuyển đổi'; //
$lang['lb_jqinpexsitunit'] = 'Đơn vị tính này đã được tạo'; //
$lang['lb_jqreportwh'] = 'STOCKING REPORT'; //BÁO CÁO KHO HÀNG
$lang['lb_jqnotitem'] = 'Không tìm thấy hàng hóa'; //
$lang['lb_jqnotwh2additem'] = 'Không tìm thấy kho hàng bạn chọn để thêm sản phẩm mới'; //
$lang['lb_jqnotwh2addunit'] = 'Không tìm thấy kho hàng bạn chọn để thêm đơn vị tính mới'; //
$lang['lb_jqercanceldish'] = 'Không thể hủy món'; //
$lang['lb_jqernotdish'] = 'Không tìm thấy món cần hủy'; //
$lang['lb_jqinvalidamount'] = 'Số lượng hủy không hợp lệ'; //
$lang['lb_jqby'] = 'Bởi'; //
$lang['lb_jqnotsldish'] = 'Không tìm thấy món được chọn'; //
$lang['lb_jqcollect'] = 'Collect';// Thu tiền
$lang['lb_jqnotable'] = 'Không tìm thấy bàn';//
$lang['lb_jqsetbracklet'] = 'Chosen prices option';//Áp dụng bảng giá
$lang['lb_jqnote2chef'] = 'Vui lòng báo bếp/pha chế';//

$lang['lb_jqreportfinance'] = 'SALES REPORT'; //BÁO CÁO TÀI CHÍNH
$lang['lb_jqsumsell'] = 'Revenue'; //Bán hàng (tổng bán hàng)
$lang['lb_notbl2shop'] = 'Khách hàng không thuộc cửa hàng đã chọn'; //
$lang['lb_notexsituser'] = 'Không tìm thấy khách hàng'; //
$lang['lb_jqinpnamedish'] = 'Vui lòng nhập tên món'; //
$lang['lb_inpbracklet1'] = 'Vui lòng nhập bảng giá 1'; //
$lang['lb_inpbracklet2'] = 'Vui lòng nhập bảng giá 2'; //
$lang['lb_inpbracklet3'] = 'Vui lòng nhập bảng giá 3'; //
$lang['lb_jqnofcat'] = 'Không tìm thấy danh mục'; //
$lang['lb_jqexsitnamecat'] = 'Đã có tên danh mục này'; //
$lang['lb_jqnodishdelete'] = 'Không tìm thấy món cần xóa'; //
$lang['lb_jqcurrency'] = 'đ'; //
$lang['lb_jqdluserpermis'] = 'Bạn không được quyền xóa khách hàng này'; //
$lang['lb_jq5charuser'] = 'Tên tài khoản tối thiểu phải 5 ký tự'; //
$lang['lb_jqcreatepermisuser'] = 'Bạn không có quyền tạo khách hàng trong cửa hàng này'; //
$lang['lb_jqcreatepermisusergrp'] = 'Bạn không có quyền tạo khách hàng trong nhóm này'; //
$lang['lb_jquserexsit'] = 'Tên đăng nhập đã được sử dụng vui lòng chọn một tên đăng nhập khác'; //
$lang['lb_jqLien'] = 'Copy'; //
$lang['lb_FINALBILL'] = 'THÀNH TIỀN';//
$lang['lb_jqmbnobl2shop'] = 'Khách hàng không thuộc của hàng đã chọn';//
$lang['tt_ttaccountant'] = 'Accountants'; //Nhân viên kế toán
$lang['lb_deletesupplier'] = 'Delete Supplier'; //Xóa Nhà cung cấp
$lang['lb_jqexsitcat'] = 'Trùng tên danh mục, vui lòng chọn một tên danh mục khác'; //
$lang['lb_jqnofshop'] = 'Không tìm thấy cửa hàng'; //
$lang['lb_jqTN1'] = 'Staff 1'; //(Viết tắt của: Thu ngân 1)
$lang['lb_jqTN2'] = 'Staff 2'; //(Viết tắt của: Thu ngân 2)
$lang['lb_jqQL'] = 'Shift income';
$lang['lb_jqAt'] = 'Time';//Lúc
$lang['lb_jqnoitemsdelete'] = 'Không tìm thấy hàng hóa cần xóa. Vui lòng thử lại.'; //(Viết tắt của: Quản lý)
$lang['lb_jqinpnameunit'] = 'Vui lòng nhập tên đơn vị tính'; //
$lang['lb_jqusernobl2mg'] = 'Khách hàng không thuộc sự quản lý'; //
$lang['lb_jqnopermisdluser'] = 'Bạn không được quyền xóa user này'; //

//accountant reinventory
$lang['lb_lastCheckWH'] = 'Last Check';
$lang['lb_synchronization'] = 'Synchronization'; //Đồng bộ
$lang['lb_rinventory'] = 'Current Stock'; //Tồn thực tế
$lang['lb_rdifference'] = 'Gap'; //Chênh lệch
$lang['lb_ItemsID'] = 'CID'; //Mã HH
$lang['lb_invenhistory'] = 'Stock checking history'; //Lịch sử kiểm kê kho 
$lang['lb_inventorydate'] = 'Checking'; //Ngày kiểm
$lang['lb_inventoryuser'] = 'Checked by'; //Nhân viên kiểm kho
$lang['lb_fileupload'] = 'File Upload'; //
$lang['lb_INVENHISTORY'] = 'STOCK CHECKING HISTORY'; //LỊCH SỬ KIỂM KÊ KHO
$lang['lb_whhistoryempty'] = 'Mã nhập kho chưa có hàng hóa'; //
$lang['lb_filedownload'] = 'File Download'; //
$lang['lb_sumused'] = 'Total consumed'; //Tổng tiêu hao
$lang['lb_sumusedbyexport'] = 'Consumed by portion'; //Tiêu hao theo xuất
$lang['lb_noexportsell'] = 'Sold Qty'; //
$lang['lb_whoinventory'] = 'Checked by'; //NV kiểm kho
$lang['lb_namewhoinventory'] = 'Stock is checked by'; //NV kiểm kho
$lang['lb_amountused'] = 'Consumed amount'; //Lượng tiêu hao
$lang['lb_REPORTEXPORTGOOODS'] = 'BÁO CÁO TIÊU HAO VẬT TƯ'; //
$lang['lb_coffers'] = 'Available amount'; //Két tiền
$lang['lb_jqSL'] = 'Qty';// Quantity
$lang['lb_notiNoAllowAddMore'] = 'Không được phép thêm sản phẩm vào phiếu nữa!';// Không được phép thêm sản phẩm vào phiếu nữa!
$lang['lb_notiNoAllowAddMore'] = 'Bạn không được phép chỉnh xóa hàng hóa của phiếu nhập này!';// Không được phép thêm sản phẩm vào phiếu nữa!
$lang['lb_ttuser'] = 'User';//Người dùng
$lang['lb_pendingQuantity'] = 'Pending';
$lang['lb_returnGoods'] = 'Trả Hàng';

$lang['lb_permission'] = 'AUTHORITY LIST';
$lang['lb_settings'] = 'SETTINGS';

/* Add on 13/04/2015 */
$lang['lb_dataDelete'] = 'Ajustment';/*Chức năng xóa dữ liệu*/
$lang['lb_exampleSearchBill'] = 'Enter Order ID';//Ví dụ: 00123
$lang['lb_reprintListBill'] = 'Print';//in lại danh sách bill

$lang['lb_selectAll'] = 'All';//Tất cả
$lang['lb_selectCash'] = 'Cash';//Tiền mặt
$lang['lb_selectCard'] = 'Credit Cards';//Thẻ tín dụng
$lang['lb_selectUsd'] = 'Foreign Currencies';//Ngoại tệ
$lang['lb_pmCash'] = 'Cash'; //Tiền mặt
$lang['lb_pmCard'] = 'Card'; //Thẻ
$lang['lb_pmUsd'] = 'Foreign notes'; //Ngoại tệ
$lang['lb_pmK'] = 'MB360 Pay';//MB360 Pay
$lang['lb_MB360Pay'] = 'MB360 Pay';//MB360 Pay
$lang['lb_spent'] = 'Total outcome';// Tổng Chi
$lang['lb_liabilities'] = 'I.O.U';// Công nợ
$lang['lb_dataDeleteTitle'] = 'Adjust total sales';//Điều chỉnh doanh thu
$lang['lb_selectADate'] = 'Select date';//Chọn ngày
$lang['lb_sumAllCash'] = 'Total cash';//Tổng tiền mặt
$lang['lb_cashToChange'] = 'Reduced amount';//Tổng tiền mặt
$lang['lb_cashResult'] = 'Result';//Kết quả
$lang['lb_changePassword'] = 'Change password';//Đổi mật khẩu
$lang['lb_loginAsUser'] = 'PLEASE CHOOSE AN ACCOUNT TO LOGIN';//ĐĂNG NHẬP NHƯ KHÁCH HÀNG
$lang['lb_administrator'] = 'supervisor';//Khách hàng tổng quản

//chức năng két tiền
$lang['lb_cofferHeader'] = 'CASH FLOW MANAGEMENT ';//QUẢN LÝ TIỀN LẺ
$lang['lb_cofferTotal'] = 'Total amount';//Tổng tiền
$lang['lb_cofferFunding'] = 'Deposit';//Nạp tiền
$lang['lb_cofferWidthraw'] = 'Withdraw';//Rút tiền
$lang['lb_cofferChooseShop'] = 'Choose a store';//Chọn cửa hàng
$lang['lb_cofferMoth'] = 'Month';//Chọn cửa hàng
$lang['lb_typeTransaction'] = 'Type';//Loại GD
$lang['lb_cofferAmount'] = 'Amount of';//Số tiền
$lang['lb_cofferBalance'] = 'Balance';//Số dư
$lang['lb_cofferExe'] = 'Finished by';//người thực hiện
$lang['lb_cofferNewTransaction'] = 'New transaction';//Giao dịch mới
$lang['lb_cofferNewTypeTrans'] = 'Options';//Loai giao dich
$lang['lb_incorVal'] = 'Số tiền không hợp lệ';//Số tiền không hợp lệ
$lang['lb_incorWRVal'] = 'Số tiền rút lớn hơn số tiền hiện có trong két';//Số tiền rút lớn hơn số tiền hiện có trong két
$lang['lb_noTranType'] = 'Không tìm thấy loại giao dịch';//Không tìm thấy loại giao dịch
$lang['lb_incorCFPass'] = 'Xác nhận mật khẩu sai';//Xác nhận mật khẩu sai

$lang['lb_Staff'] = 'Staff';//Nhân viên đang làm việc
$lang['lb_orderPrintBill'] = 'Print Bill';
$lang['lb_orderDecrement'] = 'Discount';//Giảm giá
$lang['lb_orderVAT'] = 'TAX';//VAT
$lang['lb_orderTTAmount'] = 'Subtotal';//Đơn hàng
$lang['lb_orderSum'] = 'Total';//Tong cong
$lang['lb_orderMushPay'] = 'To pay';//Phải trả
$lang['lb_orderNote'] = 'Note';//Ghi chú

//cho quan ly order online
$lang['lb_onlOrderCode'] = 'Order ID';//Mã order online
$lang['lb_to'] = 'to';//đến
$lang['lb_selectAllStatus'] = 'All orders';//Tất cả trạng thái
$lang['lb_selectNoConfirm'] = 'Unconfirmed orders';//Chưa xác nhận order
$lang['lb_selectNoPacked'] = 'Unpacked orders';//Chưa đóng gói order
$lang['lb_selectNoReceived'] = 'Non-received orders';//Chưa nhận hàng
$lang['lb_selectNoPaid'] = 'Unpaid orders';//Chưa nhận tiền
$lang['lb_selectAllCus'] = 'All customers';//Tất cả khách hàng
$lang['lb_onlAddressCus'] = 'Address';//Địa chỉ
$lang['lb_onlEditCus'] = 'Edit';//Ghi chú
$lang['lb_onlNoteCus'] = 'Note';//Ghi chú
$lang['lb_onlUpdateBy'] = 'Updated by';//Cập nhật bởi
$lang['lb_onlListOrder'] = 'Online Orders';//Danh sách đơn hàng online
$lang['lb_optOrderOnl'] = 'Sản Phẩm';//Tùy chỉnh đơn hàng Online
$lang['lb_onlCodeBill'] = 'OrderID';//Mã Order
$lang['lb_onlDateOrder'] = 'Order Date';//TG Order
$lang['lb_onlNameCus'] = 'Client';//Khách hàng
$lang['lb_onlSumBill'] = 'Total amount';//Tổng tiền
$lang['lb_onlOrderStatus'] = 'Status';//Trạng thái

$lang['lb_PopQuantity'] = 'Amount';//Số lượng
$lang['lb_PopDecrement'] = 'Discount';//Giảm giá
$lang['lb_PopPrice'] = 'Unit Price';//Đơn giá
$lang['lb_PopDeByPercent'] = 'Discount by %';//Giảm giá theo %
$lang['lb_PopDeByPrice'] = 'Selling price';//Giam gia theo don gia
$lang['lb_PopDeOnBill'] = 'Discount by';//Giảm giá cho order - Giam gia theo don gia
$lang['lb_PopExampleDec'] = 'Ex: 20% or 20';
$lang['lb_PopExamplePrice'] = 'Ex: 10,000';
$lang['lb_PopExampleBill'] = 'Ex: 10%';

$lang['lb_popChangeVAT'] = 'Enter TAX(%)';
$lang['lb_collectCashBy'] = 'PAYMENT';//HÌNH THỨC THANH TOÁN
$lang['lb_collectSum'] = 'TOTAL';//Tổng cộng
$lang['lb_collectMustPay'] = 'Payment Amount';//Số tiền cần thanh toán

$lang['lb_collectCash'] = 'Cash';//TT. Tiền Mặt
$lang['lb_collectCard'] = 'Card';//TT. Thẻ
$lang['lb_collectUsd'] = 'Foreign Currency';//TT. Ngoại Tệ
$lang['lb_sumBooked'] = 'Nhận cọc';
$lang['lb_sumReturn'] = 'Hoàn tiền';
$lang['lb_subtractBooked'] = 'Trừ cọc';
$lang['lb_sumPend'] = 'Đã chi';
$lang['lb_collectPending'] = 'I.O.U';
$lang['lb_collectPath'] = 'Lay by';//Để Riêng Ra
$lang['lb_posSelectAttTitle'] = 'Choose attribute';//CHỌN THUỘC TÍNH
$lang['lb_close'] = 'Close';//Đóng

//for POS
$lang['rpholder_nameOrPhone'] = 'Email/ Mobile';//Tên / Số điện thoại khách hàng
$lang['rpholder_ProName'] = 'Product ID/ Name';//Tên/mã sản phẩm
$lang['rpholder_closeShift'] = 'End shift';//Kết ca
$lang['lb_posOrder'] = 'Order ID';//Đơn Hàng
$lang['lb_posRetureItems'] = 'Return';//Trả hàng
$lang['lb_posNoCat'] = 'There is no category';//Chưa có danh mục
$lang['lb_posNoPro'] = 'No item';//Chưa có sản phẩm
$lang['lb_retailPrice'] = 'Retail Price';//Giá lẻ
$lang['lb_bulkPrice'] = 'Bulk Price';//Giá sỉ
$lang['lb_posPrint'] = 'Print';//In Bill
$lang['lb_delivery'] = 'Delivery';//Ship hàng
$lang['lb_posListPacked'] = 'List of parking orders';//Danh sách order đã lưu
$lang['lb_posPackedTime'] = 'Date & Time';//Ngày giờ lưu
$lang['lb_posPackedUser'] = 'Created by';//Người tạo
$lang['lb_posCus'] = 'Customer';//Khách hàng
$lang['lb_posOption'] = '@';//Tùy chọn
$lang['lb_posNote'] = 'Note';//Ghi Chú
$lang['lb_posPack'] = 'Save';//Lưu - Thực hiện pack 1 order
$lang['lb_posPacked'] = 'Saved';//Đã Lưu - Thực hiện pack 1 order
$lang['lb_posDecrement'] = 'Discount';//Giảm Giá
$lang['lb_posSetting'] = 'Advance';//Nâng Cao
$lang['lb_collection'] = 'Pay';//Tính Tiền

//xoa du lieu he thong
$lang['lb_eraserHeader'] = 'Delete system data';//Xóa dữ liệu hệ thống
$lang['lb_eraserTxt1'] = 'Delete all of the data';//Xóa toàn bộ dữ liệu trong hệ thống, tính đến hết ngày
$lang['lb_eraserTxt2'] = '(Only the sales data tody will be kept)';//(Dữ liệu ngày hôm nay sẽ được giữ nguyên)
$lang['lb_eraserTxt3'] = 'THE DATA WILL BE DELETED INCLUDING';//CÁC DỮ LIỆU XÓA SẼ BAO GỒM
$lang['lb_eraserTxt4'] = 'Daily sales details';//Doanh số bán hàng chi tiết mỗi ngày
$lang['lb_eraserTxt5'] = 'Stock import records';//Thông tin về nhập kho
$lang['lb_eraserTxt6'] = 'Inventory report';//Báo cáo kho hàng
$lang['lb_eraserTxt7'] = 'Stock export records';//Thông tin về xuất kho
$lang['lb_eraserTxt8'] = 'Important: The data will NOT be able to recover after deleted';//Lưu ý : Dữ liệu sau khi xóa sẽ không phục hồi lại được
$lang['lb_eraserTxt9'] = 'I acknowledge the risk and agree to process';//Tôi đồng ý thực hiện thao tác này
$lang['lb_eraserExe'] = 'Delete data';//Xóa dữ liệu
$lang['lb_settingOnlineStore'] = 'Website Settings';//Quản trị website - online store
$lang['lb_language'] = 'Language';//Ngôn ngữ

$lang['lb_limitedNotice'] = 'You are authorised to access this link';//Bạn bị giới hạn truy cập vào chức năng theo đường link bên dưới
$lang['lb_ONLINEHEADER'] = 'LIST OF ONLINE ORDERS';//DANH SÁCH ĐƠN HÀNG ONLINE
$lang['lb_onlHeader'] = 'List of Online Orders';//Danh sách đơn hàng online

$lang['lb_date'] = 'Date';//Ngày
$lang['lb_listOnlineOrder'] = 'List of items';//List hàng hóa
$lang['lb_onlMyCus'] = 'Store';//Nhà thuốc
$lang['lb_location'] = 'Area';//Khu vực
$lang['lb_function'] = '@';//Chức năng
$lang['lb_onlUpdateBy'] = 'Updated by';//Cập nhật bởi
$lang['lb_onlNoOrder'] = 'There is no order';//Chưa có đơn hàng

$lang['lb_ttgenaral'] = 'Cashiers';//N.V nghiep vu
$lang['lb_ttCus'] = 'Customer';//Khách hàng

$lang['lb_catHeaderTitle'] = 'Product Management';//QUẢN LÝ DANH MỤC SẢN PHẨM
$lang['lb_catQuickCopy'] = 'Quick Copy';//Sao chép nhanh
$lang['lb_addNew'] = 'Add new';//Thêm mới
$lang['lb_catRoot'] = 'Main Categories';//Danh mục chính
$lang['lb_catSub'] = 'Sub Categories';//Danh mục phụ
$lang['lb_catSubSort'] = 'Sub Cat';//Danh mục phụ
$lang['lb_listPro'] = 'Product List';//Danh sách sản phẩm
$lang['lb_proName'] = 'Product name';//Tên sản phẩm
$lang['lb_proPriceSell'] = 'Price';//Giảm giá
$lang['lb_proSortPriSal'] = 'Promo price';
$lang['lb_proPriceSales'] = 'Promotion price';//Giá khuyến mại
$lang['lb_proAmount'] = 'Qty';//Số lượng
$lang['lb_proImg'] = 'Photos';//Hình ảnh

$lang['lb_proNewHeader'] = 'Create New Product';//Tạo Sản Phẩm Mới

$lang['lb_proStatus1'] = 'Brand new';//Mới 100%
$lang['lb_proStatus2'] = 'Never used';//Hàng chưa sử dụng
$lang['lb_proStatus3'] = 'Refurbished';//Hàng tân trang
$lang['lb_proStatus4'] = 'Used';//Hàng đã sử dụng
$lang['lb_proHidden'] = 'Show on POS';//Hiển thị
$lang['lb_proReturn'] = 'Allow to return';//Đổi trả
$lang['lb_returnAccepted'] = 'Accept';//Chấp nhận
$lang['lb_returnNoAccepted'] = 'Not Accept';//Không chấp nhận
$lang['lb_proPriceSale'] = 'Promotion price';//Giá khuyến mãi
$lang['lb_proAllowDeal'] = 'Price negotiable';//Giá thoa thuan
$lang['lb_proMultiAtt'] = 'SKU';//Đa dạng
$lang['lb_proManageAtt'] = 'Manage';//Quản lý - Quan ly da dang thuoc tinh
$lang['lb_proNoteAtt'] = 'Ex: color, size';//Apply to products that have many attributes. 
$lang['lb_proOnline'] = 'Show this products on website';//Hiện SP này tại online store
$lang['lb_proOnlName'] = 'Name on the Online store';//Tên hiển thị ở online store
$lang['lb_proLocation'] = 'Location';//Địa điểm
$lang['lb_proDescription'] = 'Description';//Miêu tả
$lang['lb_proFeature'] = 'Specicfication';//Miêu tả
$lang['pholder_proDescription'] = 'Product description ...';//Mô tả sản phẩm
$lang['pholder_proFeature'] = 'Product specs';//Đặt tính sản phẩm
$lang['lb_catRootAdd'] = 'Create New Category';//Tạo Danh Mục Chính
$lang['lb_catOnShop'] = 'Belong to';//Thuộc cửa hàng

$lang['lb_save'] = 'Save';//Lưu
$lang['lb_selectRootIcon'] = 'Choose an icon for the category';//Chọn Icon Cho Danh Mục
$lang['lb_selectIcon'] = 'Choose icon';//Chọn Icon
$lang['lb_catSubAdd'] = 'Create New Sub Category';//Tạo Danh Mục Phụ
$lang['lb_catOnRoot'] = 'Belong to';//Thuộc danh mục
$lang['lb_slSubIcon'] = 'Choose an icon for the sub category';//Chọn Icon Cho Danh Mục Phụ
$lang['lb_slCatIcon'] = 'Please choose the icon category';//Vui lòng chọn danh mục icon

$lang['lb_proMultiAttHeader'] = 'SKU MANAGEMENT';//Sản Phẩm Đa Dạng Thuộc Tính
$lang['lb_proAttri'] = 'Product attributes';//Thuộc tính sản phẩm
$lang['lb_proAttValue'] = 'Values';//Giá trị của thuộc tính
$lang['lb_resetLogin'] = 'Reset device list';//Reset đăng nhập
$lang['lb_loginNewDev'] = 'Login in new device';//Login thiết bị mới

//Quản trị website
$lang['lb_webManage'] = 'ONLINE-STORE SETTINGS';//QUẢN TRỊ WEBSITE
$lang['lb_webIntro'] = 'About us';//Giới thiệu
$lang['lb_webHotPro'] = 'Hot Products';//Sản phẩm hot
$lang['lb_webContact'] = 'Contact';//Liên hệ
$lang['lb_webNews'] = 'News';//Tin tức
$lang['lb_option'] = 'Settings';//Tin tức
$lang['lb_webIntroTitle'] = 'Title';//Tiêu đề
$lang['lb_webAutoHot'] = 'Automatic choose 10 products have highest sales within a week to be Hot Products';//Tự động lựa chọn 10 sản phẩm có số lượng bán nhiều nhất trong tuần đưa lên làm sản phẩm hot
$lang['lb_proPrice'] = 'Original price';//Giá bán
$lang['lb_proSales'] = 'Discounted price';//Giá khuyến mại
$lang['lb_mapShow'] = 'Show on Map';//Hiển thị bản đồ
$lang['lb_timeWorking'] = 'Bussiness hours';//Thời gian làm việc
$lang['lb_listNews'] = 'List of Articles';//Danh sách bài viết
$lang['lb_newsDetail'] = 'Article content';//Chi tiết bài viết
$lang['lb_ctyLogo'] = 'Company logo';//Logo Công ty
$lang['lb_webMenuColor'] = 'Menu display';//Màu thẻ menu
$lang['lb_webMenuIntro'] = 'About us';//Giới thiệu
$lang['lb_webMenuSale'] = 'On Sales';//Khuyến mại
$lang['lb_webShowRootCat'] = 'Show the main categories';//Hiển thị danh mục chính
$lang['lb_webGeneral'] = 'General';//Cài đặt chung
$lang['lb_webShipping'] = 'Shipping';//Chi Phí Shipping
$lang['lb_webAllowTo'] = 'Allow to choose delivery date';//Cho phép chọn ngày nhận hàng
$lang['lb_webShippingCost'] = 'Shipping cost';//Chi phí ship hàng
$lang['lb_webSuburb'] = 'Suburb';//Khu vực
$lang['lb_webPostCode'] = 'Post code';//Mã bưu điện
$lang['lb_webCost'] = 'Cost';//Chi phí
$lang['lb_webPay'] = 'Payment Methods';//Phương Thức Thanh Toán
$lang['lb_webCod'] = 'Cast on delivery (COD)';//Thanh toán khi nhận hàng (COD)
$lang['lb_webBank'] = 'Bank Account';//Tài khoản ngân hàng
$lang['lb_webPaypal'] = 'Paypal';//Tài khoản Paypal

//API
$lang['lb_notiOrderOnl'] = 'A new Online order is placed. Please check!';
$lang['lb_clkCFOrder'] = 'Click xác nhận đã nhận đơn hàng';
$lang['lb_clkCFPaid'] = 'Click xác nhận đã nhận tiền';
$lang['lb_clkCFPark'] = 'Click xác nhận đã đóng gói';
$lang['lb_clkCFRecevied'] = 'Đã nhận được hàng';
$lang['lb_cancelOrderOnl'] = 'Hủy order hàng này';
$lang['lb_notFouOrderOnl'] = 'Chưa có order';
$lang['lb_incorrectSLDate'] = 'Chọn ngày không hợp lệ';
$lang['lb_notiNewODOnl'] = 'Thông báo có order online mới. Vui lòng kiểm tra!';
$lang['lb_cfBFSend'] = 'Vui lòng xác nhận đơn hàng trước khi gửi vào bếp';
$lang['lb_cfBFReceived'] = 'Vui lòng xác nhận đã nhận được gói hàng này!';
$lang['lb_cfBFPark'] = 'Vui lòng xác nhận đã đóng gói, gói hàng này!';
$lang['lb_noExistOrderOnl'] = 'Không tìm thấy order';
$lang['lb_noExistOrder'] = 'Không tìm thấy order';
$lang['lb_slTypeProduct'] = 'Không tìm thấy loại sản phẩm.';
$lang['lb_noFouProduct'] = 'Không tìm thấy sản phẩm.';
$lang['lb_slCatPro'] = 'Không tìm thấy doanh mục yêu cầu.';
$lang['lb_noExistProWH'] = 'Không còn hàng trong kho. Vui lòng kiểm tra lại!';
$lang['lb_noExistPro'] = 'Không tìm thấy sản phẩm này.';
$lang['lb_noExistTypeDecrement'] = 'Không tìm thấy hình thức giảm giá';
$lang['lb_noPermissPercent'] = 'Bạn không được sử dụng chức năng giảm giá theo %.';
$lang['lb_noPermissPrice'] = 'Bạn không được sử dụng chức cập nhật giá bán sản phẩm.';
$lang['lb_updatedBy'] = 'Cập nhật bởi:';

$lang['lb_noExistCat'] = 'Không tìm thấy danh mục'; //
$lang['lb_noExist9Cat'] = 'Không tìm thấy danh mục chính'; //
$lang['lb_noExistShop'] = 'Không tìm thấy cửa hàng'; //
$lang['lb_dupCat'] = 'Trùng tên danh mục đã tạo'; //
$lang['lb_inpNameCat'] = 'Vui lòng nhập tên danh mục'; //
$lang['lb_inpShopOfCat'] = 'Không tìm thấy cửa hàng cần tạo danh mục'; //
$lang['lb_errCreate9Cat'] = 'Lỗi! Không tạo được danh mục chính'; //
$lang['lb_noPerMissUpdatePro'] = 'Bạn không được cấp quyền cập nhật sản phẩm!'; //
$lang['lb_errCreatePro'] = 'Không tạo được sản phẩm mới'; //
$lang['lb_limit5Att'] = 'Giới hạng 5 thuộc tính cho một sản phẩm'; //
$lang['lb_existAtt'] = 'Đã có thuộc tình này'; //
$lang['lb_noFouAtt'] = 'Không tìm thấy giá trị thuộc tính'; //
$lang['lb_clickCreateAtt'] = 'Click tạo thuộc tính'; //
$lang['lb_nameAtt_1'] = 'Attribute 1'; //
$lang['lb_nameAtt_2'] = 'Attribute 2'; //
$lang['lb_nameAtt_3'] = 'Attribute 3'; //
$lang['lb_nameAtt_4'] = 'Attribute 4'; //
$lang['lb_nameAtt_5'] = 'Attribute 5'; //

$lang['lb_proID'] = 'Product ID'; //
$lang['lb_images'] = 'Pictures'; //
$lang['lb_funcOption'] = '@'; //
$lang['lb_decremntPercent'] = 'Giảm giá phần trăm'; //
$lang['lb_decremntPrice'] = 'Giảm giá bán'; //
$lang['lb_noFouOrder'] = 'Không tìm thấy thông tin hóa đơn'; //
$lang['lb_noPermissFunct'] = 'Bạn không được cấp quyền sử dụng chức năng này'; //
$lang['lb_noFouOrder'] = 'Không tìm thấy order';
$lang['lb_allowAdmin'] = 'Chức năng chỉ dành cho Admin';
$lang['lb_wrongPassAdmin'] = 'Username hay mật khẩu không đúng.';

$lang['lb_itemsExist'] = 'Hiện tại trong kho chỉ còn:';
$lang['lb_items'] = 'sản phẩm';
$lang['lb_erProNoExist'] = 'Lỗi! Không tìm thấy sản phẩm';
$lang['lb_erEmptyInStock'] = 'Lỗi! Hệ thống không tìm thấy đủ sản phẩm trong kho để xuất.';
$lang['lb_outOfProduct'] = 'Hết hàng';
$lang['lb_showQuantity'] = 'Hiển thị số lượng kho ở online store';

$lang['lb_erNoAllowEditQty'] = 'Không thể cập nhật số lượng.';
$lang['lb_erNoAllowEditVal'] = 'Không thể cập nhật giá trị.';

//training mode
$lang['lb_traningNotice'] = 'Bạn đang trong chế động training mode.';
$lang['lb_stopTraining'] = 'Thoát training mode';
$lang['lb_trainMode'] = 'Training Mode';
$lang['lb_startTraining'] = 'Start Training';
$lang['lb_cloneData'] = 'Clone Database';

//API
$lang['nt_cartPaidNoCancel'] = 'Order đã thanh toán không thể hủy.';
$lang['lb_cartExedNoEdit'] = 'Order này đã thực hiện xuất kho không thể thêm sản phẩm vào order này nữa.';
$lang['nt_cancelThisCart'] = 'Hủy order hàng này';
$lang['nt_waitingReceivedCart'] = 'Đang chờ nhận hàng';
$lang['nt_noItemInCart'] = 'Order chưa có sản phẩm';

$lang['lb_chooseImg'] = 'Upload photo';

//qrcode qr code reading code
$lang['lb_codeCancel'] = 'Cancel';//Hủy
$lang['lb_codeStart'] = 'Start';//Bắt đầu
$lang['lb_codeStop'] = 'Stop';//Dừng lại

//setting pos
$lang['lb_optPos'] = 'POS Settings';
$lang['lb_optSetting'] = 'General';//Tùy chỉnh
$lang['lb_recentPass'] = 'Current password';
$lang['lb_newPass'] = 'New password';
$lang['lb_cfNewPass'] = 'Retype password';
$lang['lb_confPrint'] = 'Printing properties for Online orders';//Cấu hình In cho đơn hàng online
$lang['lb_allowConf'] = 'Manual configuration';//Cho phép tùy chỉnh
$lang['lb_confDefault'] = 'Pre-settup configuration';//Thiết lập mặt định
$lang['lb_printOrder'] = 'Order';//in đơn hàng
$lang['lb_printInvoice'] = 'Invoice';//in hóa đơn: A4, A5
$lang['lb_printerType'] = 'Printer type';
$lang['lb_lbShop'] = 'Shop name';
$lang['lb_lbPrinterIP'] = 'Printer IP';
$lang['lb_lbPrinterName'] = 'Printer name';
$lang['nt_successed'] = 'Not successed';
$lang['lb_sysStore'] = 'List Stores';
$lang['lb_sysPrintNote'] = 'Show note in bill';

//templates setting pos.tpl
$lang['lb_sysLangRegi'] = 'Language and Region';
$lang['lb_country'] = 'Country';
$lang['lb_lang'] = 'Language';
$lang['lb_curUnit'] = 'Currency Unit';
$lang['lb_printSett'] = 'Printing Settings';
$lang['lb_sysShowTax'] = 'Show TAX on the printing invoice';//Hiển thị VAT trên hóa đơn in?
$lang['lb_sysOn'] = 'On';//Có
$lang['lb_sysOff'] = 'Off';//Không
$lang['lb_sysPrintBill'] = 'Print bill right after finishing payment';//In bill khi thực hiện tính tiền?
$lang['lb_sysSetAuto'] = 'Setup auto surcharge';//Cài đặt phụ thu
$lang['lb_sysSur'] = 'Surcharge (%)';//Phụ thu (%)
$lang['lb_sysTimeFrame'] = 'Time Frame';//Giờ áp dụng
$lang['lb_sysText'] = '(*) If the internet was disconnected, the Offline would be activated and just only the Master device could maintain working at that time.'; //(*) Khi bị ngắt kết nối Internet, chế độ Offline sẽ được kích hoạt và chỉ có máy chủ mới có thể duy trì hoạt động trong lúc này.
$lang['lb_sysCom'] = 'Master device';//Máy chủ
$lang['lb_sysOS'] = 'OS';//Hệ điều hành
$lang['lb_sysSelect'] = 'Select';//Chọn
$lang['lb_sysTimeZone'] = 'Select timezone';//Múi giờ hệ thống

//m/website.php
$lang['tit_MNWebsite'] = 'Quản trị website online.';
$lang['lb_offlineMode'] = 'Offline Mode';//Chế độ Offline
$lang['lb_choseMasterDevice'] = 'Chế độ máy chủ';
$lang['lb_descDevice'] = 'Mô tả';
$lang['lb_choseThisMaster'] = 'Chọn thiết bị này làm máy chủ';

//accountant provider
$lang['lb_mgTreasurer'] = 'QUẢN LÝ THU CHI';

$lang['Admin'] = 'Quản trị viên';
$lang['Manager'] = 'Quản lý';
$lang['Treasurer'] = 'Thu ngân';
$lang['Accountant'] = 'Kế toán';
$lang['Customer'] = 'Khách hàng';
$lang['Staff'] = 'Thu ngân';

//m/treasurer.php
$lang['tit_treasurerSys'] = 'Quản lý thu chi';

//templates treasurer index.tpl
$lang['lb_mgTreasurer'] = 'QUẢN LÝ THU CHI';
$lang['lb_listTrans'] = 'DANH SÁCH GIAO DỊCH';
$lang['lb_MNTreasure'] = 'Quản lý thu chi';
$lang['lb_crtTreasure'] = 'Tạo phiếu thu chi';
$lang['lb_inpInfoTrea'] = 'Nhập thông tin';
$lang['lb_transEarn'] = 'Giao dịch thu';
$lang['lb_transSpend'] = 'Giao dịch chi';
$lang['lb_transCode'] = 'Mã giao dịch';
$lang['lb_transDate'] = 'Ngày';
$lang['lb_transNopNhan'] = 'Người nộp/nhận';
$lang['lb_transCreater'] = 'Người tạo GD';
$lang['lb_transAmount'] = 'Số tiền';
$lang['lb_transType'] = 'Hình thức';
$lang['lb_transNote'] = 'Ghi chú';
$lang['lb_transStart'] = 'Số dư đầu kỳ';
$lang['lb_sumEarn'] = 'Tổng thu';
$lang['lb_sumSpend'] = 'Tổng chi';
$lang['lb_transEnd'] = 'Số dư cuối kỳ';
$lang['lb_transAt'] = 'Thời gian';
$lang['lb_transcodeForm'] = 'Mã phiếu';
$lang['lb_transAlias'] = 'Mã tham chiếu';
$lang['lb_transContent'] = 'Nội dung';
$lang['lb_treEarn'] = 'Thu';
$lang['lb_treSpend'] = 'Chi';
$lang['nt_noPerLEarn'] = 'Bạn không có quyền xem phiếu thu';
$lang['nt_noPerLSpend'] = 'Bạn không có quyền xem phiếu chi';
$lang['nt_noPerListing'] = 'Bạn không có quyền xem danh sách thu/chi';
$lang['lb_typeCash'] = 'Tiền mặt';
$lang['lb_typePending'] = 'Công nợ';
$lang['lb_typeGenaral'] = 'General';
$lang['lb_typeTransfer'] = 'Chuyển khoản';
$lang['lb_expIntes'] = 'Xuất nội bộ';

// templates / main / retail.tpl
$lang['lb_main_addbalance'] = 'Top up cash';//Nạp tiền đầu ca
$lang['lb_newOutcome'] = 'New outcome reciept';//Tạo phiếu thu
$lang['lb_AmountDiscount'] = 'Amount';//Số tiền
$lang['lb_Ex200'] = 'Ex: 200,000 VNĐ';//VD: 200,000 VNĐ
$lang['lb_received'] = 'Received';//Tiền nhận
$lang['lb_change'] = 'Change';//Tiền thừa
$lang['lb_7Days'] = '7 days';
$lang['lb_15Days'] = '15 days';
$lang['lb_30Days'] = '30 days';
$lang['lb_60Days'] = '60 days';
$lang['lb_backPay'] = 'Back';//Trở lại
$lang['lb_rtScan'] = "Scan QR code on the client's mobile";//Quét QR code khách hàng
$lang['lb_rtCancel'] = 'Cancel';//Hủy
$lang['lb_rtIncomeN'] = 'New income Note';//Tạo phiếu thu
$lang['lb_rtAmount'] = 'Amount';//Số tiền thu
$lang['lb_rtPass'] = 'Password';//Mật khẩu
$lang['lb_rtNotes'] = 'Notes';//Ghi chú

//templates / print / all.tpl
$lang['lb_invoice'] = 'INVOICE';// Hóa đơn
$lang['lb_invoiceBooking'] = 'ORDER INVOICE';
$lang['lb_printDate'] = 'Date';//Ngày
$lang['lb_printCashier'] = 'Cashier';//Thu ngân
$lang['lb_printAdd'] = 'Add';//Đ/C
$lang['lb_printPhone'] = 'Phone';//Tel
$lang['lb_printClient'] = 'Client';//KH
$lang['lb_printSubTotal'] = 'Sub Total';//Thành tiền
$lang['lb_printDiscount'] = 'Discount';//Giảm giá
$lang['lb_printTax'] = 'TAX';//VAT
$lang['lb_printTotal'] = 'Total';//TỔNG CỘNG
$lang['lb_printThankYou'] = 'Thank You!';
$lang['lb_printCom'] = 'Commission';//Chiết khấu
$lang['lb_printReturn'] = 'Return';
$lang['lb_printInfoDev'] = 'Information Delivery';
$lang['lb_printDevNa'] = 'Tên';
$lang['lb_printDevMobile'] = 'Mobile';
$lang['lb_printDevAddr'] = 'Address';
$lang['lb_printDevNote'] = 'Notes';

//templates /supervisor / warehouse.tpl
$lang['lb_warephone'] = 'Phone';// Số điện thoại

//templates /supervisor / category.tpl
$lang['lb_copyProduct'] = 'Copy Product';//Sao chép
$lang['lb_productLabel'] = 'Product Label';//In Mã SP
$lang['lb_productCondition'] = 'Condition';//Tình trạng
$lang['lb_proRetailPrice'] = 'Retail price';//Giá bán lẻ
$lang['lb_proBulkPrice'] = 'Bulk price'; //Giá sỉ
$lang['lb_proSeri'] = 'Product w.S.N';//SP có số seri
$lang['lb_productID'] = 'Product ID';//Mã sản phẩm
$lang['lb_printProductLabel'] = 'Print Product Label';//In Mã Sản Phẩm
$lang['lb_printPOption'] = 'Options';//Thiết lập
$lang['lb_printPType'] = 'Label type';//Kiểu mã
$lang['lb_printPBarcode'] = 'Barcode';//Mã vạch
$lang['lb_printPPaperSize'] = 'Paper size';//Khổ giấy
$lang['lb_printPDisplay'] = 'Display';//Hiển thị
$lang['lb_printPName'] = 'Product Name';//Tên sản phẩm
$lang['lb_printPId'] = 'Product ID';//Mã sản phẩm
$lang['lb_printPPrice'] = 'Price';//Giá sản phẩm
$lang['lb_printPPriceSale'] = 'Price';//Giá Bán
$lang['lb_printPQty'] = 'Qty';//Số Lượng
$lang['lb_printPFunc'] = '@';//Chức năng
$lang['lb_printPPreview'] = 'Preview';//Xem trước
$lang['lb_printPExp'] = 'Exp PDF';//Xuất File
$lang['lb_printPNameId'] = 'Product ID/ Name';//Tên/ Mã Sản Phẩm

//liabilities / idx.tpl
$lang['lb_liaManagement'] = 'Liabilities Management';//Quản lý công nợ
$lang['lb_liaClients'] = 'Clients';//Khách Hàng
$lang['lb_liaSuppliers'] = 'Suppliers';//Nhà Cung Cấp
$lang['lb_liaCreLimit'] = 'Credit limit';//Hạn mức
$lang['lb_liaTotalDept'] = 'Total debt';//Nợ tổng
$lang['lb_liaDebtO'] = 'Debt owing';//Còn lại
$lang['lb_liaIOU'] = 'I.O.U #';//Mã CN
$lang['lb_liaOrder'] = 'Order #';//Mã GD
$lang['lb_liaDate'] = 'Date';//Ngày
$lang['lb_liaAmount'] = 'Amount';//Số tiền
$lang['lb_liaUp'] = 'Updated';//Cập nhật
$lang['lb_liaCol'] = 'Collected';//Đã thu
$lang['lb_liaOw'] = 'Owing';//Còn lại
$lang['lb_liaRef'] = 'Ref Doc';//Chứng từ
$lang['lb_liaCre'] = 'Created';//Ngày tạo
$lang['lb_liaSto'] = 'Store';//Cửa hàng
$lang['lb_liaNext'] = 'Next due date';//Lần thu tiếp theo
$lang['lb_liaNextP'] = 'Next due date';//Lần chi tiếp theo
$lang['lb_liaPay'] = 'Make payment';//Thanh toán
$lang['lb_liaMaCli'] = 'Manage Client Debts';//TỔNG HỢP CÔNG NỢ KHÁCH HÀNG
$lang['lb_liaMaSup'] = 'Manage Supplier Debts';//TỔNG HỢP CÔNG NỢ NHÀ CUNG CẤP
$lang['lb_liaCity'] = 'City';//Thành Phố
$lang['lb_liaHCM'] = 'Ho Chi Minh';//Hồ Chí Minh
$lang['lb_liaHN'] = 'Ha Noi';//Hà Nội
$lang['lb_liaCName'] = 'Client Name';//Họ Tên
$lang['lb_liaSName'] = 'Supplier';//Nhà cung cấp
$lang['lb_liaTDebt'] = 'Total debt';//Tổng nợ
$lang['lb_liaInv'] = 'Invoice #';//Mã nhập kho
$lang['lb_liaPaid'] = 'Paid';//Đã chi
$lang['lb_liaNextDate'] = 'Next due day';
$lang['lb_liaPayRe'] = 'Payment request';//Quản lý đề xuất chi
$lang['lb_liaMaRe'] = 'Manage request';//Tạo đề xuất chi

//inventory / index.tpl
$lang['lb_invStockCounts'] = 'Stock Counts';//Kiểm kê hàng hóa
$lang['lb_invInput'] = 'Input Options';//Kiểu nhập
$lang['lb_invAutomatic'] = 'Automatic';//Tự động
$lang['lb_invManual'] = 'Manual';//Nhập tay
$lang['lb_invProId'] = 'Product ID';//Mã sản phẩm
$lang['lb_invProName'] = 'Product Name';//Tên sản phẩm
$lang['lb_invQty'] = 'Qty';//Số lượng
$lang['lb_invEnter'] = 'Enter';//Nhập
$lang['lb_invList'] = 'List of Products';//Danh Sách Sản Phẩm
$lang['lb_invStt'] = '#';//STT
$lang['lb_invDown'] = 'Download';//Tải về
$lang['lb_invFunc'] = '@';//Chức năng

//member/ list.tpl
$lang['lb_cusList'] = 'Customer relationship management';//Danh Sách Khách Hàng
$lang['lb_cusRewP'] = 'Reward point';//Điểm thưởng
$lang['lb_cusNotApp'] = 'Not apply';//Không áp dụng
$lang['lb_cusRewN'] = 'You need to enter a value for converting rate to K point. Ex: The converting rate is $10 and total bill is $150, the client will earn 15K. 1K = $10';//Bạn cần nhập số tiền để làm hệ số quy đổi điểm K. Ví dụ: Hệ số quy đổi là 10,000 và tổng hóa đơn là 150,000, khách hàng sẽ được thưởng 15K. 1k = 1,000 VNĐ
$lang['lb_cusKP'] = 'Using K point';//Quy đổi điểm K
$lang['lb_cusAllowK'] = 'Allow to use K points to pay bill';//Sử dụng K cho thanh toán bill
$lang['lb_cusBulk'] = 'Bulk Buyer';//Khách sỉ
$lang['lb_cusFName'] = 'First name';//Tên
$lang['lb_cusLName'] = 'Last name';//Họ
$lang['lb_cusBirth'] = 'D.O.B';//Ngày sinh
$lang['lb_male'] = 'Male';//Nam
$lang['lb_female'] = 'Female';//Nữ
$lang['lb_cusAdr'] = 'Address';//Địa chỉ
$lang['lb_cusVN'] = 'Viet Nam';//Việt Nam
$lang['lb_cusNotes'] = 'Notes';//Ghi chú
$lang['lb_cusBill'] = 'Bill';//Hóa đơn
$lang['lb_cusPoint'] = 'K Point';//Điểm
$lang['lb_cusCliLi'] = 'List of Clients';//DANH SÁCH KHÁCH HÀNG
$lang['lb_cusRept'] = 'Report';//Thống kê
$lang['lb_cusMess'] = 'Send message';//Gửi tin nhắn
$lang['lb_cusMessSent'] = 'Sent message';//Tin đã gửi
$lang['lb_cusMemS'] = 'Member since';//Khách hàng từ
$lang['lb_cusMoB'] = 'Month of Birth';//Tháng sinh
$lang['lb_cusFullN'] = 'Full name';//Họ Tên
$lang['lb_cusSince'] = 'Since';//Từ ngày
$lang['lb_cusLasted'] = 'Lasted';//Gần nhất
$lang['lb_cusTolS'] = 'Total spent';//Tổng chi
$lang['lb_cusTolP'] = 'Total points';//Tổng điểm

//voucher / mycoupon.tpl
$lang['lb_couMana'] = 'Coupon Management';//Coupon
$lang['lb_couCreat'] = 'Create CP';//Thêm mới
$lang['lb_couAll'] = 'All Stores';//Tất cả
$lang['lb_couTime'] = 'Period';//Thời gian
$lang['lb_couAllSta'] = 'All coupon status';//Tất cả
$lang['lb_couCode'] = 'Coupon #';//Mã Coupon
$lang['lb_couName'] = 'Coupon Name';//Tên Coupon
$lang['lb_couCreD'] = 'Created date';//Ngày tạo
$lang['lb_couVal'] = 'Value';//Trị giá
$lang['lb_couExp'] = 'Expiry date';//Ngày hết hạn
$lang['lb_couUse'] = 'Times used';//Lượt sử dụng
$lang['lb_couPub'] = 'Publishing';//Đang lưu hành
$lang['lb_couPaused'] = 'Paused';//Tạm ngừng
$lang['lb_couExpired'] = 'Expired';//Hết hạn
$lang['lb_couNew'] = 'Create New Coupon';//Tạo Coupon
$lang['lb_couProP'] = 'Product photos';//Hình ảnh sản phẩm
$lang['lb_couCouName'] = 'Coupon name';//Tên coupon
$lang['lb_couPrice'] = 'Price';//Giá
$lang['lb_couOrg'] = 'Original';//Ban đầu
$lang['lb_couDis'] = 'Discounted';//Khuyến mại
$lang['lb_couExpDate'] = 'Expiry date';//Hết hạn
$lang['lb_couAppTo'] = 'Aplly to';//Áp dụng
$lang['lb_couSDes'] = 'Short desciption';//Ngắn gọn
$lang['lb_couDesL'] = 'Limit to 300 characters';//Giới hạn 300 ký tự
$lang['lb_couPolicies'] = 'Policies';//Chính sách
$lang['lb_couStoLi'] = 'Voucher will be redeemed at';//Danh sách cửa hàng áp dụng voucher này
$lang['lb_couAppSto'] = 'Applied to all stores';//Áp dụng cho tất cả cửa hàng

//m supervisor.php
$lang['lb_monday'] = 'Monday';//Thứ 2
$lang['lb_tuesday'] = 'Tuesday';//Thứ 3
$lang['lb_wednesday'] = 'Wednesday';//Thứ tư
$lang['lb_thursday'] = 'Thursday';//Thứ năm
$lang['lb_friday'] = 'Friday';//Thứ sáu
$lang['lb_saturday'] = 'Saturday';//Thứ bảy
$lang['lb_sunday'] = 'Sunday';//Chủ nhật
$lang['lb_hourClock'] = ': 00';//giờ

//setting/ index.tpl
$lang['lb_setCPass'] = 'Change password';//Đổi mật khẩu

//setting/ pos.tpl
$lang['lb_optComInf'] = 'Company Info';//Thông tin công ty
$lang['lb_optComName'] = 'Company name';//Tên công ty
$lang['lb_optComS'] = 'Short name';//Tên giao dịch viết tắt
$lang['lb_optTax'] = 'TAX ID';//Mã số thuế
$lang['lb_optCont'] = 'Contact No'; //Điện thoại

//for month label
$lang['lb_month_1'] = 'January'; //Tháng 1
$lang['lb_month_2'] = 'February'; //Tháng 2
$lang['lb_month_3'] = 'March'; //Tháng 3
$lang['lb_month_4'] = 'April'; //Tháng 4
$lang['lb_month_5'] = 'May'; //Tháng 5
$lang['lb_month_6'] = 'June'; //Tháng 6
$lang['lb_month_7'] = 'July'; //Tháng 7
$lang['lb_month_8'] = 'August'; //Tháng 8
$lang['lb_month_9'] = 'September'; //Tháng 9
$lang['lb_month_10'] = 'October'; //Tháng 10
$lang['lb_month_11'] = 'November'; //Tháng 11
$lang['lb_month_12'] = 'December'; //Tháng 12

//main / online.tpl
$lang['lb_onlRec'] = 'Receiver';//Người nhận
$lang['lb_shippingFee'] = 'Shipping fee';
$lang['lb_delivManag'] = 'Delivery Management';

$lang['lb_orderDate'] = 'Order Date';//
$lang['lb_orderList'] = 'Order List';//
$lang['lb_orderProcessing'] = 'Processing';//Processing
$lang['lb_orderPaid'] = 'Paid';//Paid
$lang['lb_orderCanceled'] = 'Canceled';//Canceled
$lang['lb_orderDeli'] = 'Delivery';//Delivery
$lang['lb_orderPickup'] = 'Pick up';//Pick up
$lang['lb_orderOn'] = 'on';// on
$lang['lb_orderID'] = 'Order ID';//Order ID
$lang['lb_onlMobile'] = 'Mobile';//Mobile

//class / template.php
$lang['lb_refund'] = 'Refund';//Trả hàng

//template / headmenu.tpl
$lang['lb_onlStoAbout'] = 'About us';//Giới thiệu

//template /main / delivery.tpl
$lang['lb_deliLog'] = 'Logbook';//Hành Trình
$lang['lb_deliAllList'] = 'All list';//Danh sách
$lang['lb_deliOtw'] = 'On the way';//Đang giao
$lang['lb_deliEd'] = 'Delivered';//Đã giao
$lang['lb_deliUn'] = 'Undelivered';//Chưa giao
$lang['lb_map'] = 'Map';//Bản đồ
$lang['lb_deliCanceled'] = 'Canceled';//Đã hủy
$lang['lb_deliSuburb'] = 'Suburb';//Địa điểm
$lang['lb_deliMen'] = 'Delivery man';//NV giao nhận
$lang['lb_deliAll'] = 'All';//Tất cả
$lang['lb_deliPen'] = 'Pending';//Chưa giao

//template / distance / index.tpl
$lang['lb_disVehicle'] = 'VEHICLE LOGBOOK MANAGERMENT';//QUẢN LÝ HÀNH TRÌNH
$lang['lb_disPayHis'] = 'Payment history';//Lịch sử thanh toán
$lang['lb_disVeh'] = 'Vehicle';//Phương tiện
$lang['lb_disToTrip'] = 'Total trips';//Tổng chuyến đi
$lang['lb_disToDis'] = 'Total distance';//Tổng lộ trình
$lang['lb_disToEx'] = 'Total expenes';//Tổng chi phí
$lang['lb_disMakePay'] = 'Make Payment';//Tạo thanh toán
$lang['lb_disAppBy'] = 'Approved by';//Duyệt bởi
$lang['lb_disStaff'] = 'Staff name';//Tên NV
$lang['lb_disPayList'] = 'PAYMENT LIST';//DANH SÁCH CHUYẾN
$lang['lb_disCan'] = 'Cancel';//Hủy
$lang['lb_disCreate'] = 'Create Payment';//Tạo thanh toán

// phpqjquery / distance_index.php
$lang['lb_disOrder'] = 'Order #';//Đơn hàng
$lang['lb_disStart'] = 'Start';//Khởi hành
$lang['lb_disStop'] = 'Stop';//Điểm đến
$lang['lb_disDis'] = 'Distance (Km)';//Quãng đường (Km)
$lang['lb_disExpen'] = 'Expenes (AU$)';//Chi phí (VNĐ)
$lang['lb_disNotes'] = 'Notes';//Ghi chú
$lang['lb_disDisKm'] = 'Distance';//KM
$lang['lb_disListOf'] = "LIST OF STAFF'S LOGBOOK";//DANH SÁCH SỐ HÀNH TRÌNH
$lang['lb_disSeAll'] = 'Select All';//Tất cả
$lang['lb_disCosPer'] = 'Cost Per Km ($)';//Phí theo KM


/*
- Report MB360Pay accountant_report_MB360Pay
*/
$lang['lb_orderID'] = 'Mã Order';
$lang['lb_totalOrder'] = 'Tổng số Order';
$lang['lb_totalOrder'] = 'Tổng số Order';
$lang['lb_orderDate'] = 'Thời Gian Order';
$lang['lb_customerName'] = 'Tên Khách Hàng';
$lang['lb_shopName'] = 'Tên Cửa Hàng';
$lang['lb_billTotal'] = 'MB360Pay / Tổng Bill';
$lang['lb_reportMB360Pay'] = 'BÁO CÁO THANH TOÁN VÍ MB360PAY';

/*
- Report MB360Pay accountant_report_MB360Pay
*/
$lang['lb_orderID'] = 'Mã Order';
$lang['lb_totalOrder'] = 'Tổng số Order';
$lang['lb_totalOrder'] = 'Tổng số Order';
$lang['lb_orderDate'] = 'Thời Gian Order';
$lang['lb_customerName'] = 'Tên Khách Hàng';
$lang['lb_shopName'] = 'Tên Cửa Hàng';
$lang['lb_billTotal'] = 'MB360Pay / Tổng Bill';
$lang['lb_reportMB360Pay'] = 'BÁO CÁO THANH TOÁN VÍ MB360PAY';


//report revenue
$lang['err_invalidDateInput'] = 'Ngày nhập không đúng định dạng';