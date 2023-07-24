<?php
include '../define.php';

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

$m             = $main->get('m');
$act         = $main->get('act');
$apikey     = $main->get('apikey');

date_default_timezone_set('Asia/Ho_Chi_minh');
$default_time_zone = 'Asia/Ho_Chi_Minh'; //set default time_zone

// switch language
if (isset($_SESSION['lang']) && in_array($_SESSION['lang'], array('vi', 'en'))) {
    include '../lang/' . $_SESSION['lang'] . '/home.php';
} else {
    include '../lang/vi/home.php';
    $_SESSION['lang'] = 'vi';
}

if ($apikey == $global_apikey_public) {
    if (isset($m['0'])) {

        include $m . '.php';
    } else {
        echo $lang['er_003'] . " - index.ajax.";
    }
} elseif ($apikey == $global_apikey_client) {
    
    if (isset($m['0'])) {
        //kiểm tra ngôn ngữ
        include '../lang/vi/home.php';

        $members = new members();
        $members->set('user_id', @$_SESSION['usernameClient']);
        $members->set('password', @$_SESSION['passwordClient']);
        $dMemberLogin = $members->check_login();

        if($dMemberLogin['user_id']){
            include $m . '.php';
        } else {
            echo "<b>Chuyển đến trang đăng nhập ...</b>. <script> setTimeout(function(){window.location = '" . $domain . "/logout.php';},2000); </script>";
            $db->close();
            exit();
        }

        // if (isset($dClientLogin['gid'])) {
        //     if (($dClientLogin['gid'] == '1' ||  $permiss !== false)) {
        //         include $m . '.php';
        //     } else {
        //         echo 'done##', $main->toJsonData(403, 'Bạn không được phép sử dụng chức năng này.', null);
        //         $db->close();
        //         exit();
        //     }
        // } else {
        //     echo "<b>Chuyển đến trang đăng nhập ...</b>. <script> setTimeout(function(){window.location = '" . $domain . "/logout.php';},2000); </script>";
        //     $db->close();
        //     exit();
        // }
    } else {
        echo $lang['er_003'] . " - index.ajax.";
    }
} elseif ($apikey == $global_apikey_panel) {
    if (isset($m['0'])) {

        include '../lang/vi/home.php';

        @$user->setusername($_SESSION['username']);
        @$user->setpassword($_SESSION['pass']);
        $dUserLogin = $user->check_login();

        // $dUserLogin['gid'] = 1;

        // $permiss = -1;
        // $permiss = true;

        $permiss = strpos($dUserLogin['permission'], ':' . $m . $act . ':');
        if (!$permiss) { ///*Nếu gặp thì cho qua, sẽ ktra lại sau; vì các chức năng này cần ktra điều kiện*/
            $permiss = $m . $act == 'mainupdate_price' && isset($_POST['type']) && $_POST['type'] == 'price' ? true : false;
        }

        if ($dUserLogin['gid'] != '-1' && $dUserLogin['gid'] != '0' && $permiss === false) {
            echo 'done##', $main->toJsonData(403, $lang['lb_noPermissFunct'], null);
        } else {
            include $m . '.php';
        }

        // if (isset($dUserLogin['gid'])) {
        //     if (($dUserLogin['gid'] == '1' ||  $permiss !== false)) {
        //         include $m . '.php';
        //     } else {
        //         echo 'done##', $main->toJsonData(403, 'Bạn không được phép sử dụng chức năng này.', null);
        //         $db->close();
        //         exit();
        //     }
        // } else {
        //     echo "<b>Chuyển đến trang đăng nhập ...</b>. <script> setTimeout(function(){window.location = '" . $domain . "/logout.php';},2000); </script>";
        //     $db->close();
        //     exit();
        // }
    } else {
        echo $lang['er_003'] . " - index.ajax.";
    }
} else {
    echo 'Missing apikey request';
}

@$db->close();

if (!file_exists(__DIR__ . '/../logs/lazyloading'))
    @mkdir(__DIR__ . '/../logs/lazyloading', 0777, true);

$filename = __DIR__ . '/../logs/lazyloading/' . $database . '.log.' . date('Y-m-d-H') . '.txt';
$strLog = ob_get_contents();
@$main->writeToFile($filename, ':[GET]:' . json_encode($_GET) . ':[POST]:' . json_encode($_POST) . '[dUser]' . json_encode($dUserLogin) . ':' . '[dUserClient]' . json_encode($dClientLogin) . ':\n' . $strLog);
unset($strLog);
