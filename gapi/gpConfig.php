<?php
//session_start();

//Include Google client library
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '501938051026-h1sapcubpu1earfn2fcqd8f7k6fn36ie.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'hc0CchZXhc8NtV9CkvC_M8xb'; //Google client secret
$redirectURL = 'http://localhost/project30/tfb.php'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to Tiffinwala');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>
