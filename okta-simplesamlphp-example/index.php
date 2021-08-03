<?php

require('../simplesamlphp/lib/_autoload.php');

require('login.php');
require('logout.php');

file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$_REQUEST' => $_REQUEST,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$_GET' => $_GET,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('$_POST' => $_POST,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' => __LINE__,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);
session_start();

file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' => __LINE__,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);

$bootstrap_cdn_css_url = '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.min.css';
$bootstrap_cdn_js_url  = '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js';
$jquery_cdn_url        = '//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js';

$title = 'SimpleSAMLphp Example SAML SP';
$user_session_key = 'user_session';
$saml_sso = 'saml_sso';


file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' => __LINE__,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);

// If the user is logged in and requesting a logout.
if (isset($_SESSION[$user_session_key]) && isset($_REQUEST['logout'])) {
  handleLogout($user_session_key);
}

file_put_contents('/home/subhamk/Documents/local_server_logs/log.txt', print_r(array('__LINE__' => __LINE__,), true) . PHP_EOL, FILE_APPEND | LOCK_EX);

// If the user is logging in.
if (isset($_REQUEST[$saml_sso])) {
  handleLogin($user_session_key, $saml_sso);
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
          <?php if (isset($_SESSION[$user_session_key])) { ?>
            <li><a href="?logout=true">Logout</a></li>
          <?php } ?>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
  </nav>
  <div class="container">
    <?php if (isset($_SESSION[$user_session_key])) {
      var_dump($_SESSION);
      echo ("\nCOOKIE :- ");
      var_dump($_COOKIE);
    ?>
      <h1>Logged in</h1>
      <p class="lead">Contents of the most recent SAML assertion:</p>
      <div class="col-md-8">
        <table class="table">
          <?php foreach ($_SESSION[$user_session_key]['attributes'] as $key => $value) { ?>
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
      var_dump($_SESSION);
      echo ("\nCOOKIE :- ");
      var_dump($_COOKIE);
    ?>
      <p class="lead">Select the IdP you want to use to authenticate:</p>
      <ol>
        <?php foreach ($sources as $source) { ?>
          <li><a href="?<?= $saml_sso ?>=<?= $source ?>"><?= $source ?></a></li>
        <?php } ?>
      </ol>
    <?php } ?>
  </div>
  <script src="<?= $jquery_cdn_url ?>"></script>
  <script src="<?= $bootstrap_cdn_js_url ?>"></script>
</body>

</html>