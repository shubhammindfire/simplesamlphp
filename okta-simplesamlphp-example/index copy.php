<?php
/* -*- coding: utf-8 -*-
 * Copyright 2015 Okta, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */



require('../simplesamlphp/lib/_autoload.php');
// require_once('/home/project/simplesamlphp/simplesamlphp/lib/_autoload.php');

file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$_REQUEST' =>$_REQUEST, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$_GET' =>$_GET, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$_POST' =>$_POST, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' =>__LINE__, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
session_start();

//$as = new \SimpleSAML\Auth\Simple('default-sp');
//file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('test' => 1), true).PHP_EOL, FILE_APPEND | LOCK_EX);

file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' =>__LINE__, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);

//$currentSite = 'http://local.simplesamlphp-oktaa.com/okta-simplesamlphp-example/';
//$as->login([
//    'KeepPost' => TRUE,
//    'ReturnTo' => $currentSite
//]);
//
//var_dump($as->isAuthenticated());



//exit();
//$as = new \SimpleSAML\Auth\Simple('default-sp');
//var_dump($as);

//var_dump();

//$currentSite = 'http://local.simplesamlphp-oktaa.com/okta-simplesamlphp-example/';
//$as->login([
//    'KeepPost' => TRUE,
//        'ReturnTo' => $currentSite
//]);

//exit();

$bootstrap_cdn_css_url = '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.min.css';
$bootstrap_cdn_js_url  = '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js';
$jquery_cdn_url        = '//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js';

$title = 'SimpleSAMLphp Example SAML SP';
$user_session_key = 'user_session';
$saml_sso = 'saml_sso';


file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' =>__LINE__, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
// If the user is logged in and requesting a logout.
if (isset($_SESSION[$user_session_key]) && isset($_REQUEST['logout'])) {
    file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' =>__LINE__, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
   $sp = $_SESSION[$user_session_key]['sp'];
   unset($_SESSION[$user_session_key]);
//    $as = new SimpleSAML_Auth_Simple($sp);
//   $as = new \SimpleSAML\Auth\Simple('default-sp');
   $as = new \SimpleSAML\Auth\Simple($sp);
//    \SimpleSAML\Session::getSessionFromRequest()->cleanup();
   $as->logout(["ReturnTo" => $_SERVER['PHP_SELF']]);
    \SimpleSAML\Session::getSessionFromRequest()->cleanup();
}

file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' =>__LINE__, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
// If the user is logging in.
if (isset($_REQUEST[$saml_sso])) {
    file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' =>__LINE__, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
    $sp = $_REQUEST[$saml_sso];
    // $as = new SimpleSAML_Auth_Simple($sp);
//    $as = new \SimpleSAML\Auth\Simple('default-sp');
     $as = new \SimpleSAML\Auth\Simple($sp);

//     var_dump($as->isAuthenticated());


//    \SimpleSAML\Session::getSessionFromRequest()->cleanup();

//    $currentSite = 'http://local.simplesamlphp-oktaa.com/okta-simplesamlphp-example/';
//    $as->login([
//        'KeepPost' => TRUE,
//        'ReturnTo' => $currentSite
////        'ReturnTo' => $currentSite
//    ]);
//    $as->login()


//    \SimpleSAML\Session::getSessionFromRequest()->cleanup();

    file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' =>__LINE__, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
    file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$as->isAuthenticated()' => $as->isAuthenticated()), true).PHP_EOL, FILE_APPEND | LOCK_EX);

    unset($_COOKIE['SimpleSAML']);
    unset($_COOKIE['SimpleSAMLAuthToken']);

    $as->requireAuth();
//        $as->login([
//        'KeepPost' => TRUE,
//        'ReturnTo' => $_SERVER['PHP_SELF']
//    ]);
    file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' =>__LINE__, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
    file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$as->isAuthenticated()' => $as->isAuthenticated()), true).PHP_EOL, FILE_APPEND | LOCK_EX);

    file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' =>__LINE__, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
    file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$as->getAuthData(\'saml:sp:NameID\')' => get_class_methods($as->getAuthData('saml:sp:NameID')), ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
    file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$as->getAuthData(\'saml:sp:NameID\')' => $as->getAuthData('saml:sp:NameID')->getValue(), ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);

    $user = array(
        'sp'         => $sp,
        'authed'     => $as->isAuthenticated(),
        'idp'        => $as->getAuthData('saml:sp:IdP'),
//        'nameId'     => $as->getAuthData('saml:sp:NameID')['Value'],
//        'nameId'     => $as->getAuthData('saml:sp:NameID')['Value'],
        'nameId'     => $as->getAuthData('saml:sp:NameID')->getValue(),
        'attributes' => $as->getAttributes(),
    );

    file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$user' => $user), true).PHP_EOL, FILE_APPEND | LOCK_EX);
    
    $_SESSION[$user_session_key] = $user;
    file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' =>__LINE__, ), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
}

?>  
<!DOCTYPE html>
<html>
  <head>
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="<?= $bootstrap_cdn_css_url ?>" rel="stylesheet" media="screen">
  </head>
  <body style="padding-top: 60px">
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
	  <!-- this is what makes the "hamburger" icon -->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><?= $title ?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
	  <?php if(isset($_SESSION[$user_session_key])) { ?>
            <li><a href="?logout=true">Logout</a></li>
	  <?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
    <?php if(isset($_SESSION[$user_session_key])) { ?>
      <h1>Logged in</h1>
      <p class="lead">Contents of the most recent SAML assertion:</p>
      <div class="col-md-8">
        <table class="table">
	<?php foreach($_SESSION[$user_session_key]['attributes'] as $key => $value) { ?>
          <tr>
            <td><?= $key ?></td>
            <td><?= $value[0] ?></td>
          </tr>
	<?php } ?>
        </table>
      </div>
    <?php
      } else {
        // $sources = SimpleSAML_Auth_Source::getSources();
        $sources = \SimpleSAML\Auth\Source::getSources();
    ?>
      <p class="lead">Select the IdP you want to use to authenticate:</p>
      <ol>
        <?php foreach($sources as $source) { ?>
        <li><a href="?<?= $saml_sso ?>=<?= $source ?>"><?= $source ?></a></li>
	<?php } ?>
      </ol>
    <?php } ?>
    </div>
    <script src="<?= $jquery_cdn_url ?>"></script>
    <script src="<?= $bootstrap_cdn_js_url ?>"></script>
  </body>
</html>
