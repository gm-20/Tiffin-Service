<?php
session_start();

//Include Facebook SDK
require_once 'inc/facebook.php';

/*
 * Configuration and setup FB API
 */
$appId = '169353766870438'; //Facebook App ID
$appSecret = 'd9bd60964026bdb8698bd2600fa2b28f'; // Facebook App Secret
$redirectURL = 'http://fbl.com/project30/index.php'; // Callback URL
$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret
));
$fbUser = $facebook->getUser();
?>