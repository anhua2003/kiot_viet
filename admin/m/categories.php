<?php
if($act == 'index') {
    $result = $kiotviet->getList('categories');
    $st->assign('categories', $result);
}