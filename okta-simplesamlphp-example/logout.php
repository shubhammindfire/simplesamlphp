<?php

require('../simplesamlphp/lib/_autoload.php');

// this function handles user logout
function handleLogout($user_session_key)
{
	file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' => __LINE__,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
	$sp = $_SESSION[$user_session_key]['sp'];
	unset($_SESSION[$user_session_key]);
	// setcookie("PHPSESSID", "", time() - 3600);
	unset($_COOKIE);
	$as = new \SimpleSAML\Auth\Simple($sp);
	// $as->logout(["ReturnTo" => $_SERVER['PHP_SELF']]);
	$as->logout();
	\SimpleSAML\Session::getSessionFromRequest()->cleanup();


	// if (!isset($_REQUEST['idp'])) {
	// 	throw new \SimpleSAML\Error\BadRequest('Missing "idp" parameter.');
	// }
	// $idp = (string) $_REQUEST['idp'];
	// $idp = \SimpleSAML\IdP::getById($idp);

	// if (!isset($_REQUEST['association'])) {
	// 	throw new \SimpleSAML\Error\BadRequest('Missing "association" parameter.');
	// }
	// $assocId = urldecode($_REQUEST['association']);

	// $relayState = null;
	// if (isset($_REQUEST['RelayState'])) {
	// 	$relayState = (string) $_REQUEST['RelayState'];
	// }

	// $associations = $idp->getAssociations();
	// if (!isset($associations[$assocId])) {
	// 	throw new \SimpleSAML\Error\BadRequest('Invalid association id.');
	// }
	// $association = $associations[$assocId];

	// $metadata = \SimpleSAML\Metadata\MetaDataStorageHandler::getMetadataHandler();
	// $idpMetadata = $idp->getConfig();
	// $spMetadata = $metadata->getMetaDataConfig($association['saml:entityID'], 'saml20-sp-remote');

	// $lr = \SimpleSAML\Module\saml\Message::buildLogoutRequest($idpMetadata, $spMetadata);
	// $lr->setSessionIndex($association['saml:SessionIndex']);
	// $lr->setNameId($association['saml:NameID']);

	// $assertionLifetime = $spMetadata->getInteger('assertion.lifetime', null);
	// if ($assertionLifetime === null) {
	// 	$assertionLifetime = $idpMetadata->getInteger('assertion.lifetime', 300);
	// }
	// $lr->setNotOnOrAfter(time() + $assertionLifetime);

	// $encryptNameId = $spMetadata->getBoolean('nameid.encryption', null);
	// if ($encryptNameId === null) {
	// 	$encryptNameId = $idpMetadata->getBoolean('nameid.encryption', false);
	// }
	// if ($encryptNameId) {
	// 	$lr->encryptNameId(\SimpleSAML\Module\saml\Message::getEncryptionKey($spMetadata));
	// }

	// \SimpleSAML\Stats::log('saml:idp:LogoutRequest:sent', [
	// 	'spEntityID'  => $association['saml:entityID'],
	// 	'idpEntityID' => $idpMetadata->getString('entityid'),
	// ]);

	// $bindings = [\SAML2\Constants::BINDING_HTTP_POST];

	// /** @var array $dst */
	// $dst = $spMetadata->getDefaultEndpoint('SingleLogoutService', $bindings);
	// $binding = \SAML2\Binding::getBinding($dst['Binding']);
	// $lr->setDestination($dst['Location']);
	// $lr->setRelayState($relayState);

	// $binding->send($lr);
}
