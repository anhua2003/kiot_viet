<?php
require 'D:/Thuctap/demo/demothuctap/library/vendor/autoload.php';
use NVuln\TiktokShop\Client;
$client = new Client($app_key, $app_secret);
$auth = $client->auth();
try {
	$authorization_code =  isset($_SESSION['token']) ? $_SESSION['token'] : '';
	$token = $auth->getToken($authorization_code);
	$_SESSION['token'] = $token['access_token'];

	$_SESSION['refresh_token'] = $token['refresh_token'];
} catch (Exception $e) {

	if (!isset($_SESSION['token'])) {
		if($main->get('m') == 'user')
		{
			$_SESSION['state'] = $state = $main->str_rand(40);
			$authUrl = $auth->createAuthRequest($state, true);
	
	
			if (isset($_GET['code'])) {
	
				$_SESSION['token'] = $_GET['code'];
				setcookie('token', $_SESSION['token']);
				header('Location: http://demo.local/tai-khoan');
			} else {
				header('Location: ' . $authUrl);
			}
		}
	} else {
		$new_token = $auth->refreshNewToken($_SESSION['refresh_token']);

		$_SESSION['token'] = $new_token['access_token'];
		$_SESSION['refresh_token'] = $new_token['refresh_token'];
	}
}
$access_token = isset($_SESSION['token']) ? $_SESSION['token'] : '';
if(isset($_SESSION['token']))
{
	$client->setAccessToken($access_token);
}