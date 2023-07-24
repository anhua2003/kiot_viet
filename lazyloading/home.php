<?php
$nod        = $main->get('nod');

if ($act == 'contact') {
    if ($nod == 'send') {
        $name = $main->post("name");
        $email = $main->post("email");
        $message = $main->post('message');
        $user1 = new user1();
        $user1->contact($name,$email,$message);
        echo 'done##'.$main->toJsonData(200, null, null);
        $db->close();
        exit();
    } else {
        echo 'Missing action';
        $db->close();
        exit();
    }
} else if($act == 'news') {
    if($nod == 'see-more') {
        $limit = $main->post('limit');
        $news1 = new news1();
        $count = count($news1->get_news_all());
        $result = $news1->get_news($limit);
        echo 'done##'.$main->toJsonData(200, null, [$result,$count]);
    }
} else if($act == 'news-detail') {
    if($nod == 'comment') {
        $limit = $main->post('limit');
        $id_post = $main->post('id_post');
        $message = $main->post('message');
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
        $news1 = new news1();
        $news1->comment_post($id_post, $message, $user_id);
        $result = $news1->get_post_comment($id_post,$limit);
        echo 'done##'.$main->toJsonData(200, null, $result);
        $db->close();
        exit();
    } else if($nod == 'see-more') {
        $id_post = $main->post('id_post');
        $limit = $main->post('limit');
        $news1 = new news1();
        $result = $news1->get_post_comment($id_post, $limit);
        $all = $news1->get_all_post_comment($id_post);
        $count = count($all);
        echo 'done##'.$main->toJsonData(200, null, [$result,$count]);
        $db->close();
        exit();
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
