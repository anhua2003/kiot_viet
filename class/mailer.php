<?php
require_once __DIR__ . "/../library/phpmailer/src/PHPMailer.php";
require_once __DIR__ . "/../library/phpmailer/src/SMTP.php";
require_once __DIR__ . "/../library/phpmailer/src/Exception.php";
require_once __DIR__ . "/../library/phpmailer/src/POP3.php";
require_once __DIR__ . "/../library/phpmailer/src/OAuth.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class mailer
{
    //APPLICATION
    public $server_url;
    public $apikey;
    public $store_name;

    public function sendMail_an($addressMail, $code)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hongan212003@gmail.com';
        $mail->Password = 'ntdhfdliqpkjnpwn';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('nicknro21@gmail.com', mb_encode_mimeheader('NyNy', 'UTF-8', 'Q'));
        $mail->addAddress($addressMail);
        $mail->isHTML(true);
        $mail->Subject = mb_encode_mimeheader('Quên mật khẩu', 'UTF-8', 'Q');
        $mail->Body = '<strong>'.$code.'</strong>';
        $mail->send();
        return true;
    }
    public function testSMTP($host, $port, $email, $password, $tls)
    {
        $mail = new PHPMailer();

        //        $mail->SMTPDebug = 3;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $host;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $email;                 // SMTP username
        $mail->Password = $password;                           // SMTP password
        $mail->Port = $port;
        if ($tls == 1) {
            $mail->SMTPSecure = 'tls';
        } else {
            $mail->SMTPSecure = '';
        }
        $mail->Timeout = 5;
        if (!$mail->smtpConnect()) {
            $mail->smtpClose();
            return false;
        } else {
            $mail->smtpClose();
            return true;
        }
    }

    public function sendMail1($from, $pass, $to, $subject, $content, $setup = null)
    {
        // $email = new PHPMailer();
        // $email->CharSet = "UTF-8";
        // $email->Host = 'tailieu.loihangsong.us';
        // $email->Port = 465;
        // $email->SMTPAuth = true;
        // $email->isSMTP();
        // $email->Username = $from;
        // $email->Password = $pass;
        // $email->SMTPSecure = 'ssl';
        // // $email->addAttachment($image, 'new.jpg');
        // $email->isHTML(true);
        // $email->setFrom('admin@loihangsong.us', 'Lời Hằng Sống');
        // $email->addAddress($to);
        // $email->Subject = $subject;
        // $email->Body   = $content;
        // // $email->SMTPDebug = 2;
        // if (!$email->send()) {
        // 	echo $email->ErrorInfo;
        // 	return 2;
        // } else {
        // 	echo 'send mail';
        // 	return 1;
        // }

        $email = new PHPMailer();
        $email->CharSet = "UTF-8";
        $email->Host = '';
        $email->Port = 587;
        $email->SMTPAuth = true;
        $email->isSMTP();
        $email->Username = '';
        $email->Password = '';
        $email->SMTPSecure = 'ssl';
        // $email->addAttachment($image, 'new.jpg');
        $email->isHTML(true);
        $email->setFrom($setup['smtp_email_address'], "Dmember");
        $email->addAddress($to);
        $email->Subject = $subject;
        $email->Body   = $content;
        // $email->SMTPDebug = 2;
        if (!$email->send()) {
            echo $email->ErrorInfo;
            return 2;
        } else {
            echo 'send mail';
            return 1;
        }
    }

    public function sendMailCustom($to, $message, $subject = '', $fullname = null, $setup = null, $bcc = false)
    {
        $mail = new PHPMailer();
        // echo $setup['smtp_port'];
        // exit();
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'hongan212003@gmail.com'; // SMTP username
        $mail->Password = 'ntdhfdliqpkjnpwn'; // SMTP password
        $mail->Timeout = 15;

        if ($setup['smtp_tls'] == 1) {
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption
        } elseif ($setup['smtp_tls'] == 2) {
            $mail->SMTPSecure = 'ssl';
        } else {
            $mail->SMTPSecure = '';
        }
        $mail->Port = $setup['smtp_port'];

        $mail->CharSet = 'UTF-8';
        $mail->setFrom($setup['smtp_email_address'], $setup['smtp_email_name']);
        $mail->addAddress($to, $fullname);
        // if ($bcc) $mail->addBCC('noreply@dstore.global', 'Administrator');
        $mail->addReplyTo($setup['smtp_email_address'], $setup['smtp_email_name']);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->isHTML();
        $mail->send();

        if (!$mail->send()) {
        	echo $mail->ErrorInfo;
        	return false;
        } else {
        	return true;
        }
        // return true;
    }

    public function sendMail($to_email, $message)
    {
        $headers = "From: no-reply@hostmail.com \r\n";
        $headers .= "BCC: noreply@dstore.global \r\n";
        $headers .= "MIME-Version: 1.0 \r\n";
        $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
        $subject = "ChamCongApp";
        $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

        mail($to_email, $subject, $message, $headers);

        return true;
    }

    public function sendMailReset($email, $fullname, $token, $domain, $setup)
    {
        if ($setup['lang'] == 'en') {
            $subject = "Recovery password - ChamCongApp";
            $message = "<p>Dear $fullname,</p>
                    <p>Someone sent a request to recovery your AppChamCong's account password.</p> 
                    <p>Please click on the link below to start the recovery password procedure.</p>
                    <p>---------------------------------------------------------------------------------------------------------------------------------------</p>
                    <p><a href='$domain/?m=user&act=activate_reset_password&email=$email&token=$token'>$domain/?m=user&act=activate_reset_password&email=$email&token=$token</a></p>
                    <p>---------------------------------------------------------------------------------------------------------------------------------------</p>
                    <p>This link will be expired after 1 day from the time you receive this email.</p>
                    <p>If you did not send this request, please do nothing and contact to your network administrator and report about this issue. Thank you!</p>";
        } else {
            $subject = "Khôi phục mật khẩu - ChamCongApp";
            $message = "<p>Chào $fullname,</p>
                    <p>Ai đó vừa gửi yêu cầu khôi phục mật khẩu cho tài khoản AppChamCong của bạn.</p> 
                    <p>Vui lòng nhấp vào liên kết bên dưới để tiến hành quá trình khôi phục mật khẩu.</p>
                    <p>---------------------------------------------------------------------------------------------------------------------------------------</p>
                    <p><a href='$domain/?m=user&act=activate_reset_password&email=$email&token=$token'>$domain/?m=user&act=activate_reset_password&email=$email&token=$token</a></p>
                    <p>---------------------------------------------------------------------------------------------------------------------------------------</p>
                    <p>Liên kết sẽ hết hạn sau 1 ngày kể từ khi bạn nhận email khôi phục mật khẩu.</p>
                    <p>Nếu bạn không gửi yêu cầu khôi phục mật khẩu này thì bạn không cần thao tác gì thêm và vui lòng liên hệ với quản trị mạng để báo cáo vấn đề này. Xin cảm ơn!</p>";
        }

        // return true;
        //        $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
        //        $headers = "From: noreply@dstore.global \r\n";
        //        $headers .= "MIME-Version: 1.0 \r\n";
        //        $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
        //
        //        mail($email, $subject, $message, $headers);
        $this->sendMailCustom($email, $message, $subject, $fullname, $setup);
        return true;
    }

    public function sendNotification($to_email, $subject, $message, $headers)
    {
        $sent = mail($to_email, $subject, $message, $headers);
        if ($sent) {
            return true;
        } else {
            return false;
        }
    }

    public function pushFCMNotification($type, $to, $title, $message, $notify = '')
    {
        global $lang;

        foreach ($to as $user) {
            $message = strip_tags($message);
            $message = html_entity_decode($message, ENT_QUOTES);
            $message = preg_replace("/&#?[a-z0-9]+; | \r|\n/i", "", $message);
            if (strlen($message) > 150) $message = substr($message, 0, 150) . '...';
            $pack = [
                'to' => '/topics/user_' . $user,
                'notification' => [
                    "title" => $title,
                    "body" => $message
                ],
                "data" => [
                    "title" => $title,
                    "body" => $message,
                    'type' => $type,
                    'notify_id' => $notify,
                    'date' => translateFullDateStr(time(), true, $lang)
                ]
            ];
            $headers = array(
                'Authorization:key=AAAAOqCXAvU:APA91bHjwkk6D7qpW2Rja45jlkh6-6L0bBgRNrbw7Om4maaKetuKSL5Zn-NEw_CXVRpaNPyipVB3F7gtE8yFxVYfX9fzOqDKPfiqXy2rrLYQu-7XhwzeBsBs_ja5MkaxBWpMtVbAYgyJ',
                'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($pack));
            $result = curl_exec($ch);
            curl_close($ch);
        }
    }

    public function sendSMS($mobile, $message)
    {
        return true;
               if ($mobile != '' && $mobile != '0' && strlen($mobile) > 5) {
                   $api = "https://app.wholesalesms.com.au/api/v2/send-sms.json";
                   $ch = curl_init();
                   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                       'Authorization: Basic NWE0OGQwYzdmZTY2M2I1MmNlZDY1YTEyZTIzYjUwN2Q6NzNlNjY2ZmQwMmJmYTI5ZjU0NzMyYTVlN2RlOTJlYTI='
                   ));
                   curl_setopt($ch, CURLOPT_URL, $api);
                   curl_setopt($ch, CURLOPT_POST, TRUE);
                   curl_setopt($ch, CURLOPT_POSTFIELDS, 'to=' . $mobile . ';&message=' . $message . '&from=SmartIT');
                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
                   $kq = curl_exec($ch);
                   // $info = curl_getinfo($ch);
                   //print_r($info);
                   curl_close($ch);
                   print_r($kq); 
               }
               return $kq;
    }

    public function noti_late($email, $mobile, $fullname, $late, $setup)
    {
        $date = date('d/m/Y');
        $time = date('h:i A');
        if ($setup == 'en') {
            $message = "<p>Late check-in notification:</p>
                    <p>- Day/month/year: $date </p>
                    <p>- Staff\'s name: $fullname </p>
                    <p>- Check-in time:  $time</p>
                    <p>- Late for $late minutes </p>
                    <p>&nbsp;</p>
                    <p><strong>Thanks and best regards.</strong></p>
                    <p>====================================================================</p>                                
                    <p><b style='text-transform: uppercase;'>" . $setup['company_name'] . "</b></p>                                
                    <p>Address: " . $setup['office_address'] . "</p>                                
                    <p>Phone: " . $setup['hotline'] . ", Fax: " . $setup['fax'] . "</p>
                    <p>Tax ID: " . $setup['business_tax_id'] . "</p>";
        } else {
            $message = "<p>Thông báo check-in trễ:</p>
                    <p>- Ngày/tháng/năm: $date</p>
                    <p>- Tên nhân viên: $fullname </p>
                    <p>- Thời gian check-in: $time </p>
                    <p>- Đã trễ $late phút</p>
                    <p>&nbsp;</p>
                    <p><strong>Trân trọng cảm ơn.</strong></p>
                    <p>====================================================================</p>                                
                    <p><b style='text-transform: uppercase;'>" . $setup['company_name'] . "</b></p>                                
                    <p>Địa chỉ: " . $setup['office_address'] . "</p>                                
                    <p>Điện thoại: " . $setup['hotline'] . ", Fax: " . $setup['fax'] . "</p>
                    <p>Mã số thuế: " . $setup['business_tax_id'] . "</p>";
        }

        if ($email != '') {
            //            $this->sendMail($email, $message);
            $this->sendMailCustom($email, $message, 'ChamCongApp', $fullname, $setup, true);
        }
        //        if ($mobile != '') {
        //            $this->sendSMS($mobile, $message);
        //        }

        return true;
    }

    //Chỉ ần pin_code
    public function template_verify($pin_code)
    {
        global $setup;
        $c = isset($setup['template_content_verify']) ? $setup['template_content_verify'] : '';
        if ($c == '') {
            $c = '<p style="margin-top: 10px;margin-bottom: 30px;text-align: center;"><a style="color: #fff;text-decoration: none;word-break: break-word;font-size: 20px;line-height: 26px;padding: 12px 35px;background-color: #f0a334;display: inline-block;min-width: 80px;text-align: center;border-top-left-radius: 4px;border-top-right-radius: 4px;border-bottom-right-radius: 4px;border-bottom-left-radius: 4px;letter-spacing: 3px;">' . $pin_code . '</a></p>';
        } else {
            $c = str_replace('%pin_code%', $pin_code, $c);
        }
        return $c;
    }

    //Tạo template gửi mail khi đăng ký xong => Cần: Fullname; mobile *; Email *; $password
    public function template_register($dM, $password)
    {
        //info_fullname
        //info_mobile
        //info_email
        //info_password
        global $setup;

        $c = isset($setup['template_content_register']) ? $setup['template_content_register'] : '';
        if ($c == '') {
            $c = '<p style="margin-top: 10px;margin-bottom: 30px;text-align: center;"><a style="color: #fff;text-decoration: none;word-break: break-word;font-size: 20px;line-height: 26px;padding: 12px 35px;background-color: #f0a334;display: inline-block;min-width: 80px;text-align: center;border-top-left-radius: 4px;border-top-right-radius: 4px;border-bottom-right-radius: 4px;border-bottom-left-radius: 4px;letter-spacing: 3px;">Họ & Tên: ' . $dM['fullname'] . '</a></p>';
            if ($dM['mobile'] != '') $c .= '<p style="margin-top: 10px;margin-bottom: 30px;text-align: center;"><a style="color: #fff;text-decoration: none;word-break: break-word;font-size: 20px;line-height: 26px;padding: 12px 35px;background-color: #f0a334;display: inline-block;min-width: 80px;text-align: center;border-top-left-radius: 4px;border-top-right-radius: 4px;border-bottom-right-radius: 4px;border-bottom-left-radius: 4px;letter-spacing: 3px;">SĐT: ' . $dM['mobile'] . '</a></p>';
            if ($dM['email'] != '') $c .= '<p style="margin-top: 10px;margin-bottom: 30px;text-align: center;"><a style="color: #fff;text-decoration: none;word-break: break-word;font-size: 20px;line-height: 26px;padding: 12px 35px;background-color: #f0a334;display: inline-block;min-width: 80px;text-align: center;border-top-left-radius: 4px;border-top-right-radius: 4px;border-bottom-right-radius: 4px;border-bottom-left-radius: 4px;letter-spacing: 3px;">Email: ' . $dM['email'] . '</a></p>';
            $c .= '<p style="margin-top: 10px;margin-bottom: 30px;text-align: center;"><a style="color: #fff;text-decoration: none;word-break: break-word;font-size: 20px;line-height: 26px;padding: 12px 35px;background-color: #f0a334;display: inline-block;min-width: 80px;text-align: center;border-top-left-radius: 4px;border-top-right-radius: 4px;border-bottom-right-radius: 4px;border-bottom-left-radius: 4px;letter-spacing: 3px;">PIN: ' . $password . '</a></p>';
        } else {
            $c = str_replace('%info_fullname%', $dM['fullname'] == '' ? 'Quý khách' : $dM['fullname'], $c);
            if ($dM['mobile'] != '') $c = str_replace('%info_mobile%', $dM['mobile'], $c);
            if ($dM['email'] != '') $c = str_replace('%info_email%', $dM['email'], $c);
            $c = str_replace('%info_password%', $password, $c);
        }

        return $c;
    }

    //Tạo template gửi mail khi đặt hàng thành công
    public function template_submit_order($dM, $item, $order_id, $total, $ship_address)
    {
        global $setup;
        $h = '';
        $h .= '<!DOCTYPE html>
            <html lang="vi">
            
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Đơn hàng</title>
            </head>
            
            <body>
                <div style="width:100%;border-collapse:collapse;color:rgb(55,55,55);font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px;font-style:normal;font-variant-caps:normal;font-weight:normal;letter-spacing:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;background-color:rgb(249,249,249);line-height:24px;margin:0px;padding-bottom:20px">
                    <div style="text-align:center;padding:25px 15px 15px">
                        <a href="'.$setup['link_company'].'"target="_blank"><img style="outline:none;text-decoration:none;max-width:160px;height:auto;border:none" src="'.$setup['logo_url'].'"></a>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" width="600px" style="margin-left:auto;margin-right:auto;padding:20px;background:#fff;border-radius:3px">
                        <tbody>
                            <tr>
                                <td valign="top" style="border-collapse:collapse">
                                    <table width="100%" cellspacing="" border="0" align="center" style="border-collapse:collapse;color:rgb(55,55,55);font-size:14px;font-style:normal;font-variant-caps:normal;font-weight:normal;letter-spacing:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;line-height:24px;margin:0px;padding:0px;max-width:600px;margin-left:auto;margin-right:auto">
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="border-collapse:collapse">
                                                    <div>
                                                        <div style="border-top-left-radius:0.5rem;border-top-right-radius:0.5rem;border-bottom-right-radius:0.5rem;border-bottom-left-radius:0.5rem">
                                                            <h2 style="color:#'.$setup['theme_default_config'].';margin:0px 0px 15px;font-size:20px">Email xác nhận đơn hàng</h2>
                                                            <p style="font-size:14px;margin:0px 0px 5px;line-height:24px">Xin chào <strong>' . $dM['fullname'] . '</strong>,</p>
                                                            <p style="font-size:14px;margin:0px 0px 5px;line-height:24px">
                                                                Bạn có một đơn đặt hàng tại
                                                                <strong><a href="' . $setup['link_company'] . '" style="color:#'.$setup['theme_default_config'].'" target="_blank" >' . $setup['link_company'] . '</a></strong>
                                                            </p>
                                                            <p style="font-size:14px;margin:0px 0px 5px;line-height:24px">
                                                                Đơn hàng có mã số <strong>' . $order_id . '</strong> được mua lúc ' . date('d/m/Y H:i') . '
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" style="border-collapse:collapse">
                                    <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:collapse;color:rgb(55,55,55);font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:13px;font-style:normal;font-variant-caps:normal;font-weight:normal;letter-spacing:normal;text-align:center;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;background-color:rgb(249,249,249);line-height:22px;padding:0px;margin:10px auto;max-width:600px">
                                        <tbody>
                                            <tr>
                                                <td style="font-size:14px;padding:8px 10px;color: #444;font-weight: 600;" colspan="2">Sản phẩm</td>
                                                <td style="font-size:14px;padding:8px 10px;color: #444;font-weight: 600;">Đơn giá</td>
                                                <td style="font-size:14px;padding:8px 10px;color: #444;font-weight: 600;">SL</td>
                                                <td style="font-size:14px;padding:8px 10px;color: #444;font-weight: 600;">Thành tiền</td>
                                            </tr>'; 

                                            foreach($item as $it){
                                                $price_decrement = $it['price']-($it['price']*$it['decrement']/100);
                                                $h .= '<tr>
                                                        <td style="background: #fff;padding:8px;border:1px solid #f1f1f1;width:60px">
                                                            <a href="#" title="'.$it['title'].'" style="display:block;width:60px;min-height:60px" target="_blank"><img src="'.$it['link_img'].'" alt="'.$it['title'].'" style="margin:auto;max-width:100%;max-height:100%;border:none" class="CToWUd"></a>
                                                        </td>
                                                        <td style="background: #fff;padding:8px;border:1px solid #f1f1f1;text-align:left">
                                                            1. <a href="#" target="_blank" style="color: #333;text-decoration: none;"><b>'.$it['title'].'</b></a>
                                                        </td>
                                                        <td style="background: #fff;padding:8px;border:1px solid #f1f1f1">'.number_format_replace_cog($price_decrement).' đ</td>
                                                        <td style="background: #fff;padding:8px;border:1px solid #f1f1f1">'.$it['quantity'].'</td>
                                                        <td style="background: #fff;padding:8px;border:1px solid #f1f1f1">'.number_format_replace_cog($price_decrement*$it['quantity']).' đ</td>
                                                    </tr>';
                                            }

                                             $h .= '<tr>
                                                <td colspan="4" style="text-align:right;font-weight:bold;padding:8px;border:1px solid #f1f1f1">Tổng tiền</td>
                                                <td style="padding:8px;border:1px solid #f1f1f1;font-weight:bold">' . number_format_replace_cog($total) . ' đ</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align:right;padding:8px;border:1px solid #f1f1f1;color: #999;">Phí giao hàng</td>
                                                <td style="padding:8px;border:1px solid #f1f1f1;color: #999;">Liên hệ</td>
            
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align:right;font-weight:bold;padding:8px;border:1px solid #f1f1f1;color: #56BA47;font-size: 16px;">Số tiền phải trả</td>
                                                <td style="padding:8px;border:1px solid #f1f1f1;font-weight:bold;color: #56BA47;font-size: 16px;">' . number_format_replace_cog($total) . ' đ</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="margin: 5px 0px;font-size: 16px;color:#'.$setup['theme_default_config'].';"><strong>Thông tin nhận hàng</strong></p>
                                    <p style="margin: 5px 0px;"><strong>' . $dM['fullname'] . ' - ' . $dM['mobile'] . '</strong></p>
                                    <p style="margin: 5px 0px;"><strong>Địa chỉ: </strong>' . $ship_address . '</p>
                                    <p style="font-size:13px;margin:15px 0px 0px 0px;font-style:italic;line-height:24px;text-align: center;">
                                        (Đây là email được gửi tự động từ hệ thống, vui lòng không trả lời lại email này)
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </body>
            
            </html>';


        return $h;
    }

    // public function tempalate_verify($pin_code)
    // {
    //     $h = '';
    //     $h .= '<!DOCTYPE html>
    //     <html lang="vi">

    //     <head>
    //         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    //     </head>

    //     <body style="margin:0px">
    //         <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; color: rgb(55, 55, 55); font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 15px; font-style: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(249, 249, 249); line-height: 22px; margin: 0px; padding: 0px;">
    //             <tbody>
    //                 <tr>
    //                     <td width="546" valign="top" style="border-collapse: collapse;">
    //                         <div style="max-width: 600px; margin: 0px auto;position: relative;margin-top: 40px;margin-bottom: 40px;">
    //                             <div style="background-color: white; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem; border-bottom-left-radius: 0.5rem;padding: 30px 30px 20px;margin-bottom: 20px;box-shadow: 0px 0px 10px #ddd;">
    //                                 <div style="text-align: center;">
    //                                     <a href="http://dstore.global/" target="_blank"><img style="outline: none; text-decoration: none; max-width: 100%; height: 70px; border: none;" dfsrc="http://static.dstore.global/7713/picture/2021/03/31/logo-dmember-1617185474.png" src="http://static.dstore.global/7713/picture/2021/03/31/logo-dmember-1617185474.png"></a>
    //                                 </div>
    //                                 <h2 style="color: #f0a334; margin: 15px 0px 15px; line-height: 32px;">Quên mật khẩu?</h2>
    //                                 <p style="font-size: 18px; margin: 0px 0px 14px; line-height: 22px;"><strong>Chào quý khách,</strong></p>
    //                                 <p style="font-size: 15px; margin: 0px 0px 4px; line-height: 22px;"><strong>Dmember</strong> đã nhận được yêu cầu thay đổi mật khẩu của quý khách.</p>
    //                                 <p style="font-size: 20px; margin: 25px 0px 5px;line-height: 22px;text-transform: uppercase;text-align: center;"><strong>Mã xác nhận là</strong></p>
    //                                 <p style="margin-top: 10px;margin-bottom: 30px;text-align: center;"><a style="color: #fff;text-decoration: none;word-break: break-word;font-size: 20px;line-height: 26px;padding: 12px 35px;background-color: #f0a334;display: inline-block;min-width: 80px;text-align: center;border-top-left-radius: 4px;border-top-right-radius: 4px;border-bottom-right-radius: 4px;border-bottom-left-radius: 4px;letter-spacing: 3px;">%pin_code%</a></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><span style="font-size: 13pt;"><strong>DSTORE - MÔ HÌNH TMĐT PHI TẬP TRUNG</strong></span></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Địa chỉ</strong>: Số 2/3 Bạch Đằng, P. 2, Q. Tân Bình, TP.HCM</p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Chi Nhánh</strong>: Số 5 Ngõ Duy Tân, P. Dịch Vọng Hậu, Quận Cầu Giấy, Hà Nội</p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Chi Nhánh</strong>: Số 5 Đặng Văn Sâm, P. 2, Q. Tân Bình, TP. Hồ Chí Minh</p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Hotline</strong>: <a href="tel:19000126" style="color: #007dd1;text-decoration: none;">19007003</a></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Email</strong>: <a href="mailto:info@dstore.global" style="color: #007dd1;text-decoration: none;">info@dstore.global</a></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 4px; line-height: 22px;text-align: center;"><strong>Thời gian làm việc</strong>: 08h - 17h30 (Từ thứ 2 đến thứ 7)</p><br>
    //                                 <p style="font-size: 14px;margin: 0px 0px 0px;line-height: 22px;font-style: italic;text-align: center;">(Đây là email được gửi tự động từ hệ thống, vui lòng không trả lời lại email này)</p>
    //                             </div>
    //                         </div>
    //                     </td>
    //                 </tr>
    //             </tbody>
    //         </table>
    //     </body>

    //     </html>';
    //     return $h;
    // }

    // public function tempalate_verify_azone($pin_code)
    // {
    //     $h = '';
    //     $h .= '<!DOCTYPE html>
    //     <html lang="vi">

    //     <head>
    //         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    //     </head>

    //     <body style="margin:0px">
    //         <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; color: rgb(55, 55, 55); font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 15px; font-style: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(249, 249, 249); line-height: 22px; margin: 0px; padding: 0px;">
    //             <tbody>
    //                 <tr>
    //                     <td width="546" valign="top" style="border-collapse: collapse;">
    //                         <div style="max-width: 600px; margin: 0px auto;position: relative;margin-top: 40px;margin-bottom: 40px;">
    //                             <div style="background-color: white; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem; border-bottom-left-radius: 0.5rem;padding: 30px 30px 20px;margin-bottom: 20px;box-shadow: 0px 0px 10px #ddd;">
    //                                 <div style="text-align: center;">
    //                                     <a href="http://dstore.global/" target="_blank"><img style="outline: none; text-decoration: none; max-width: 100%; height: 50px; border: none;margin-top: 20px;" dfsrc="https://azone.sees.vn/erp_azone/assets/images/ecoposlogo.png?v=2.6472.6271620200478" src="https://azone.sees.vn/erp_azone/assets/images/ecoposlogo.png?v=2.6472.6271620200478"></a>
    //                                 </div>
    //                                 <h2 style="color: #f0a334; margin: 15px 0px 15px; line-height: 32px;">Quên mật khẩu?</h2>
    //                                 <p style="font-size: 18px; margin: 0px 0px 14px; line-height: 22px;"><strong>Chào quý khách,</strong></p>
    //                                 <p style="font-size: 15px; margin: 0px 0px 4px; line-height: 22px;"><strong>Azone</strong> đã nhận được yêu cầu thay đổi mật khẩu của quý khách.</p>
    //                                 <p style="font-size: 20px; margin: 25px 0px 5px;line-height: 22px;text-transform: uppercase;text-align: center;"><strong>Mã xác nhận là</strong></p>
    //                                 <p style="margin-top: 10px;margin-bottom: 30px;text-align: center;"><a style="color: #fff;text-decoration: none;word-break: break-word;font-size: 20px;line-height: 26px;padding: 12px 35px;background-color: #f0a334;display: inline-block;min-width: 80px;text-align: center;border-top-left-radius: 4px;border-top-right-radius: 4px;border-bottom-right-radius: 4px;border-bottom-left-radius: 4px;letter-spacing: 3px;">%pin_code%</a></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><span style="font-size: 13pt;"><strong>CTY CỔ PHẦN ĐẦU TƯ VÀ PHÁT TRIỂN AZONE</strong></span></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Địa chỉ</strong>: 147/147 Nguyễn Thị Tú, Phường Bình Hưng Hoà B, Bình Tân, TP.HCM</p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Hotline</strong>: <a href="tel:0932915999" style="color: #007dd1;text-decoration: none;">0932 915 999</a></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Email</strong>: <a href="mailto:info@azone.vn" style="color: #007dd1;text-decoration: none;">info@azone.vn</a></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 4px; line-height: 22px;text-align: center;"><strong>Thời gian làm việc</strong>: 08h - 17h30 (Từ thứ 2 đến thứ 7)</p><br>
    //                                 <p style="font-size: 14px;margin: 0px 0px 0px;line-height: 22px;font-style: italic;text-align: center;">(Đây là email được gửi tự động từ hệ thống, vui lòng không trả lời lại email này)</p>
    //                             </div>
    //                         </div>
    //                     </td>
    //                 </tr>
    //             </tbody>
    //         </table>
    //     </body>

    //     </html>';
    //     return $h;
    // }

    // public function tempalate_register_azone($dM, $password)
    // {
    //     $h = '';
    //     $h .= '<!DOCTYPE html>
    //     <html lang="vi">

    //     <head>
    //         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    //     </head>

    //     <body style="margin:0px">
    //         <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; color: rgb(55, 55, 55); font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 15px; font-style: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(249, 249, 249); line-height: 22px; margin: 0px; padding: 0px;">
    //             <tbody>
    //                 <tr>
    //                     <td width="546" valign="top" style="border-collapse: collapse;">
    //                         <div style="max-width: 600px; margin: 0px auto;position: relative;margin-top: 40px;margin-bottom: 40px;">
    //                             <div style="background-color: white; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem; border-bottom-left-radius: 0.5rem;padding: 30px 30px 20px;margin-bottom: 20px;box-shadow: 0px 0px 10px #ddd;">
    //                                 <div style="text-align: center;">
    //                                     <a href="http://dstore.global/" target="_blank"><img style="outline: none; text-decoration: none; max-width: 100%; height: 50px; border: none;margin-top: 20px;" dfsrc="https://azone.sees.vn/erp_azone/assets/images/ecoposlogo.png?v=2.6472.6271620200478" src="https://azone.sees.vn/erp_azone/assets/images/ecoposlogo.png?v=2.6472.6271620200478"></a>
    //                                 </div>
    //                                 <p style="font-size: 18px; margin: 30px 0px 14px; line-height: 22px;">Xin chào <strong>%info_fullname%,</strong></p>
    //                                 <p style="font-size: 15px; margin: 0px 0px 4px; line-height: 22px;">Chúc mừng bạn đã đăng ký thành công tài khoản App Azone</p>
    //                                 <p style="font-size: 15px; margin: 15px 0px 12px; line-height: 22px;"><strong>Thông tin tài khoản của bạn là:</strong></p>
    //                                 <p style="font-size: 15px; margin: 0px 0px 4px; line-height: 22px;">Họ & tên: <strong>%info_fullname%</strong></p>
    //                                 <p style="font-size: 15px; margin: 0px 0px 4px; line-height: 22px;">Số điện thoại: <strong>%info_mobile%</strong></p>
    //                                 <p style="font-size: 15px; margin: 0px 0px 24px; line-height: 22px;">Mật khẩu: <strong>%info_password%</strong></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><span style="font-size: 13pt;"><strong>CTY CỔ PHẦN ĐẦU TƯ VÀ PHÁT TRIỂN AZONE</strong></span></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Địa chỉ</strong>: 147/147 Nguyễn Thị Tú, Phường Bình Hưng Hoà B, Bình Tân, TP.HCM</p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Hotline</strong>: <a href="tel:0932915999" style="color: #007dd1;text-decoration: none;">0932 915 999</a></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Email</strong>: <a href="mailto:info@azone.vn" style="color: #007dd1;text-decoration: none;">info@azone.vn</a></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 4px; line-height: 22px;text-align: center;"><strong>Thời gian làm việc</strong>: 08h - 17h30 (Từ thứ 2 đến thứ 7)</p>
    //                                 <p style="font-size: 14px; margin: 20px 0px 0px; line-height: 22px;text-align: center;"><span style="font-size: 13pt;color: #FFAD01"><strong>TẢI APP TẠI ĐÂY</strong></span></p>
    //                                 <div style="text-align: center;">
    //                                     <a href="https://play.google.com/store/apps/details?id=vn.azone" target="_blank"><img style="outline: none; text-decoration: none; max-width: 100%; height: 50px; border: none;margin-top: 10px;" src="https://static.azone.vn/5038/picture/2021/05/05/app-google-1620201510.jpg"></a>
    //                                     <a href="https://apps.apple.com/us/app/azone/id1560838168" target="_blank"><img style="outline: none; text-decoration: none; max-width: 100%; height: 50px; border: none;margin-top: 10px;" src="https://static.azone.vn/5038/picture/2021/05/05/app-apple-1620201509.jpg"></a>
    //                                 </div>
    //                                 <br>
    //                                 <p style="font-size: 14px;margin: 0px 0px 0px;line-height: 22px;font-style: italic;text-align: center;">(Đây là email được gửi tự động từ hệ thống, vui lòng không trả lời lại email này)</p>
    //                             </div>
    //                         </div>
    //                     </td>
    //                 </tr>
    //             </tbody>
    //         </table>
    //     </body>

    //     </html>';
    //     return $h;
    // }

    // public function tempalate_register_dmember($dM, $password)
    // {
    //     $h = '';
    //     $h .= '<!DOCTYPE html>
    //     <html lang="vi">

    //     <head>
    //         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    //     </head>

    //     <body style="margin:0px">
    //         <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; color: rgb(55, 55, 55); font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 15px; font-style: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(249, 249, 249); line-height: 22px; margin: 0px; padding: 0px;">
    //             <tbody>
    //                 <tr>
    //                     <td width="546" valign="top" style="border-collapse: collapse;">
    //                         <div style="max-width: 600px; margin: 0px auto;position: relative;margin-top: 40px;margin-bottom: 40px;">
    //                             <div style="background-color: white; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem; border-bottom-left-radius: 0.5rem;padding: 30px 30px 20px;margin-bottom: 20px;box-shadow: 0px 0px 10px #ddd;">
    //                                 <div style="text-align: center;">
    //                                     <a href="http://dstore.global/" target="_blank"><img style="outline: none; text-decoration: none; max-width: 100%; height: 70px; border: none;" dfsrc="http://static.dstore.global/7713/picture/2021/03/31/logo-dmember-1617185474.png" src="http://static.dstore.global/7713/picture/2021/03/31/logo-dmember-1617185474.png"></a>
    //                                 </div>
    //                                 <p style="font-size: 18px; margin: 30px 0px 14px; line-height: 22px;">Xin chào <strong>%info_fullname%,</strong></p>
    //                                 <p style="font-size: 15px; margin: 0px 0px 4px; line-height: 22px;">Chúc mừng bạn đã đăng ký thành công tài khoản App Dmember</p>
    //                                 <p style="font-size: 15px; margin: 15px 0px 12px; line-height: 22px;"><strong>Thông tin tài khoản của bạn là:</strong></p>
    //                                 <p style="font-size: 15px; margin: 0px 0px 4px; line-height: 22px;">Họ & tên: <strong>%info_fullname%</strong></p>
    //                                 <p style="font-size: 15px; margin: 0px 0px 4px; line-height: 22px;">Số điện thoại: <strong>%info_mobile%</strong></p>
    //                                 <p style="font-size: 15px; margin: 0px 0px 24px; line-height: 22px;">Mật khẩu: <strong>%info_password%</strong></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><span style="font-size: 13pt;"><strong>DSTORE - MÔ HÌNH TMĐT PHI TẬP TRUNG</strong></span></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Địa chỉ</strong>: Số 2/3 Bạch Đằng, P. 2, Q. Tân Bình, TP.HCM</p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Chi Nhánh</strong>: Số 5 Ngõ Duy Tân, P. Dịch Vọng Hậu, Quận Cầu Giấy, Hà Nội</p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Chi Nhánh</strong>: Số 5 Đặng Văn Sâm, P. 2, Q. Tân Bình, TP. Hồ Chí Minh</p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Hotline</strong>: <a href="tel:19007003" style="color: #007dd1;text-decoration: none;">19007003</a></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 0px; line-height: 22px;text-align: center;"><strong>Email</strong>: <a href="mailto:info@dstore.global" style="color: #007dd1;text-decoration: none;">info@dstore.global</a></p>
    //                                 <p style="font-size: 14px; margin: 0px 0px 4px; line-height: 22px;text-align: center;"><strong>Thời gian làm việc</strong>: 08h - 17h30 (Từ thứ 2 đến thứ 7)</p>
    //                                 <p style="font-size: 14px; margin: 20px 0px 0px; line-height: 22px;text-align: center;"><span style="font-size: 13pt;color: #FFAD01"><strong>TẢI APP TẠI ĐÂY</strong></span></p>
    //                                 <div style="text-align: center;">
    //                                     <a href="https://play.google.com/store/apps/details?id=vn.vinagroups.dmember" target="_blank"><img style="outline: none; text-decoration: none; max-width: 100%; height: 50px; border: none;margin-top: 10px;" src="http://static.dstore.global/7713/picture/2021/05/05/app-google-1620202430.jpg"></a>
    //                                     <a href="https://apps.apple.com/us/app/dmember/id1480184490" target="_blank"><img style="outline: none; text-decoration: none; max-width: 100%; height: 50px; border: none;margin-top: 10px;" src="http://static.dstore.global/7713/picture/2021/05/05/app-apple-1620202429.jpg"></a>
    //                                 </div>
    //                                 <br>
    //                                 <p style="font-size: 14px;margin: 0px 0px 0px;line-height: 22px;font-style: italic;text-align: center;">(Đây là email được gửi tự động từ hệ thống, vui lòng không trả lời lại email này)</p>
    //                             </div>
    //                         </div>
    //                     </td>
    //                 </tr>
    //             </tbody>
    //         </table>
    //     </body>

    //     </html>';
    //     return $h;
    // }

}
