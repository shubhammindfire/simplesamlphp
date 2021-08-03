<?php

require('../simplesamlphp/lib/_autoload.php');

// this function handle user login
function handleLogin($user_session_key, $saml_sso)
{
	// unset($_COOKIE['SimpleSAML']);
	// unset($_COOKIE['SimpleSAMLAuthToken']);
	file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' => __LINE__,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
	$sp = $_REQUEST[$saml_sso];
	$as = new \SimpleSAML\Auth\Simple($sp);

	file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' => __LINE__,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
	file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$as->isAuthenticated()' => $as->isAuthenticated()), true) . PHP_EOL, FILE_APPEND | LOCK_EX);

	unset($_COOKIE['SimpleSAML']);
	unset($_COOKIE['SimpleSAMLAuthToken']);

	$as->requireAuth();

	file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' => __LINE__,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
	file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$as->isAuthenticated()' => $as->isAuthenticated()), true) . PHP_EOL, FILE_APPEND | LOCK_EX);

	file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' => __LINE__,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
	file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$as->getAuthData(\'saml:sp:NameID\')' => get_class_methods($as->getAuthData('saml:sp:NameID')),), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
	file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$as->getAuthData(\'saml:sp:NameID\')' => $as->getAuthData('saml:sp:NameID')->getValue(),), true) . PHP_EOL, FILE_APPEND | LOCK_EX);

	$user = array(
		'sp'         => $sp,
		'authed'     => $as->isAuthenticated(),
		'idp'        => $as->getAuthData('saml:sp:IdP'),
		'nameId'     => $as->getAuthData('saml:sp:NameID')->getValue(),
		'attributes' => $as->getAttributes(),
	);

	file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$user' => $user), true) . PHP_EOL, FILE_APPEND | LOCK_EX);

	$_SESSION[$user_session_key] = $user;
	file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' => __LINE__,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
}
