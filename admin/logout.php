<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

include 'include/global.php';
include 'include/session.php';

$page = $main->get('page');

// if (isset($page) && $page=='admin') {
    
//     unset($_COOKIE['id']);
//     unset($_COOKIE['fullname']);
//     unset($_COOKIE['pass']);
//     unset($_COOKIE['username']);
//     unset($_COOKIE['gid']);

//     setcookie( 'id', '44', time() - 3600, '/');
//     setcookie('pass', '44', time() - 3600, '/');
//     setcookie('fullname', '44', time() - 3600, '/');
//     setcookie('username', '44', time() - 3600, '/');

//     unset($_SESSION['id']);
//     unset($_SESSION['pass']);
//     unset($_SESSION['fullname']);
//     unset($_SESSION['username']);
//     unset($_SESSION['gid']);

//     session_destroy();
//     $main->redirect('/admin');
// } elseif(isset($page) && $page=='client') {
//     // unset($_COOKIE['id']);
//     unset($_COOKIE['passwordClient']);
//     unset($_COOKIE['fullnameClient']);
//     unset($_COOKIE['usernameClient']);
//     // unset($_COOKIE['gid']);

//     // setcookie( 'id', '44', time() - 3600);
//     setcookie('fullnameClient', '44', time() - 3600, '/');
//     setcookie('usernameClient', '44', time() - 3600, '/');
//     setcookie('passwordClient', '44', time() - 3600, '/');

//     unset($_SESSION['passwordClient']);
//     unset($_SESSION['fullnameClient']);
//     unset($_SESSION['usernameClient']);

//     session_destroy();
//     $main->redirect('/dang-nhap');
// }else{
//     $main->redirect('/');
// }

if (isset($_SESSION['id_admin'])) {
    unset($_SESSION['id_admin']);
    $main->redirect('./sign');
}else{
    $main->redirect('/');
}
