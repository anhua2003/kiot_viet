<?php
/*DB .VN*/
$server_sql = 'localhost';
$user_sql   = 'root';
$pass_sql   = '';
$database   = 'citipos_thuctap';//vinateks db
$app_key = '69dg90ohf003s';
$app_secret = '8acdc621450d76843b6c3ab6bbaf3c8295033fa9';
$db = new db();
$db->setServer ( $server_sql );
$db->setUsername ( $user_sql );
$db->setPassword ( $pass_sql );
$db->setDatabase ( $database );
$db->tbl_fix    = $database.'.';

$domain         = 'http://'.$_SERVER['SERVER_NAME'].'';
$link           = 'http://'.$_SERVER['SERVER_NAME'].'';
$tpldirect 	    = __DIR__.'/../templates/';

$setup = $opt->showall();
$st->assign('setup', $setup);

$menu_template = new menu_template();
$st->assign('menu_top', $menu_template->menu_top());
$st->assign('menu_bottom', $menu_template->menu_bottom());
$st->assign('menu_suggest', $menu_template->menu_suggest());

$global_apikey_public               = '0123kSKmsdfrtl234sd';
$global_apikey_client               = 'Client0123kSKm123123';
$global_apikey_panel                = 'panel812js19JN123';
