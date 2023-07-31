<?php
    if($act == 'index') {
        $kiotviet = new kiotviet();
        $invoices = $kiotviet->getList('invoices');
        $st->assign('invoices', $invoices);
    }
?>