<?php
$nod        = $main->get('nod');

if ($act == 'sign') {
    if ($nod == 'sign') {
        $email = $main->post('email');
        $password = $main->post('password');
        $home = new home();
        $home->set('email', $email);
        $home->set('password', $password);
        $result = $home->sign();
        if($result != false)
        {
            $_SESSION['id_admin'] = $result['id'];
            echo 'done##'.$main->toJsonData(200, 'Sign successful !', null);
        } else {
            echo 'done##'.$main->toJsonData(403, 'Sign fail', null);
        }
        $db->close();
        exit();
    }
} else {
    echo 'Missing action';
    $db->close();
    exit();
}
