<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
date_default_timezone_set('UTC');

include '../define.php';
require_once __DIR__ . '/../#directthumuc/config.php';

$act = $main->get('act');
$apiKey = $main->get('apiKey');

$data = array();

if ($apiKey == 'finpal0822') {
    $data =  json_decode(file_get_contents("php://input"), true);
    if (COUNT($data) > 0) {
        if ($act == 'buy') {
            $strategy_data_buy = new strategy_data_buy();
            foreach ($data as $key => $item) {
                $strategy_data_buy->set('ticker', $item['TICKER']);
                $strategy_data_buy->set('date_time', strtotime($item['DATE_TIME']['date']));
                $strategy_data_buy->set('market_price', $item['MARKET_PRICE']);
                $strategy_data_buy->set('last_major_support', $item['LAST_MAJOR_SUPPORT']);
                $strategy_data_buy->set('last_minor_support', $item['LAST_MINOR_SUPPORT']);
                $strategy_data_buy->set('last_major_resistance', $item['LAST_MAJOR_RESISTANCE']);
                $strategy_data_buy->set('last_minor_resistance', $item['LAST_MINOR_RESISTANCE']);
                $strategy_data_buy->set('gap_resistance', $item['GAP_RESISTANCE']);
                $strategy_data_buy->set('gap_support', $item['GAP_SUPPORT']);
                $strategy_data_buy->set('resistance_final', $item['RESISTANCE_FINAL']);
                $strategy_data_buy->set('support_final', $item['SUPPORT_FINAL']);
                $strategy_data_buy->set('take_profit', $item['TAKE_PROFIT']);
                $strategy_data_buy->set('cut_loss', $item['CUT_LOSS']);
                $strategy_data_buy->set('valuation_price', $item['VALUATION_PRICE']);
                $strategy_data_buy->set('buy_portion', $item['BUY_PORTION']);
                $strategy_data_buy->set('market_trend', $item['MARKET_TREND']);
                $strategy_data_buy->set('market_portion', $item['MARKET_PORTION']);
                $strategy_data_buy->set('pros_cons', $item['PROS_CONS']);
                $strategy_data_buy->set('pros_cons_portion', $item['PROS_CONS_PORTION']);
                $strategy_data_buy->set('st_buy_percentage', $item['ST_BUY_PERCENTAGE']);
                $strategy_data_buy->set('st_buy_strategy', $item['ST_BUY_STRATEGY']);
                $strategy_data_buy->set('lt_buy_percentage', $item['LT_BUY_PERCENTAGE']);
                $strategy_data_buy->set('lt_buy_strategy', $item['LT_BUY_STRATEGY']);
                $strategy_data_buy->set('gap_valuation', $item['GAP_VALUATION']);
                $strategy_data_buy->add();
            }
            // echo $main->toJsonData(200, 'success', NULL);
        } elseif ($act == 'sell') {
            $strategy_data_sell = new strategy_data_sell();
            foreach ($data as $key => $item) {
                $strategy_data_sell->set('ticker', $item['TICKER']);
                $strategy_data_sell->set('buy_date', strtotime($item['BUY_DATE']['date']));
                $strategy_data_sell->set('st_price_strength', $item['ST_PRICE_STRENGTH']);
                $strategy_data_sell->set('st_price_momentum', $item['ST_PRICE_MOMENTUM']);
                $strategy_data_sell->set('st_money_strength', $item['ST_MONEY_STRENGTH']);
                $strategy_data_sell->set('st_sell_percentage', $item['ST_SELL_PERCENTAGE']);
                $strategy_data_sell->set('st_sell_strategy', $item['ST_SELL_STRATEGY']);
                $strategy_data_sell->set('lt_sell_percentage', $item['LT_SELL_PERCENTAGE']);
                $strategy_data_sell->set('lt_sell_strategy', $item['LT_SELL_STRATEGY']);
                $strategy_data_sell->add();
            }
            echo $main->toJsonData(200, 'success', NULL);
        } else {
            echo $main->toJsonData(403, 'Không tìm thấy yêu cầu.', NULL);
        }
    } else {
        echo $main->toJsonData(403, 'Không có dữ liệu.', NULL);
    }
} else {
    echo $main->toJsonData(403, 'Bạn không có quyền truy cập.', NULL);
}
