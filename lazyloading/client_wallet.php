<?php
$nod        = $main->get('nod');

if ($act == 'idx') {
    if ($nod == 'filter') {

        $wallet_transaction = new wallet_transaction();

        $keyword                = $main->post('keyword');
        $wallet_id              = $main->post('wallet_id');
        $from                   = '';
        $to                     = '';
        $transaction_type       = '';
        $page                     = $main->post('page') + 0;

        if ($from != '') {
            $validData = $main->validateFromTo($from, $to);
        }
        if ($from != '' && isset($validData['status']) && $validData['status'] != 200) {
            echo $main->toJsonData($validData['status'], $validData['message'], null);
        } else {

            $wallet_transaction->set('client_id', $_SESSION['username_client']);
            $wallet_transaction->set('wallet_id', $wallet_id);
            $wallet_transaction->set('transaction_type', $transaction_type);

            $kq = $wallet_transaction->list_by_client_info($keyword, $from, $to, '', '');
            if ($page < 1) $page = 1;
            $paging->limit = $setup['perpage'];
            $offset = ($page - 1) * $paging->limit;
            $paging->page = $page;
            $paging->total = $kq['total_record'];
            $page_html = $paging->display('paging_this');

            $kq['l'] = $wallet_transaction->list_by_client($keyword, $from, $to, '', '', $offset, $paging->limit);
            $kq['wallet_id'] = $wallet_id;
            $kq['client_id'] = $_SESSION['username_client'];

            $kq['page_html'] = $page_html;
            // print_r($kq);
            // exit();
            echo 'done##', $main->toJsonData(200, 'success', $kq);
            unset($kq);
        }
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
