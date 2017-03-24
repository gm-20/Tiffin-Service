<?php
//Include FB config file
require_once 'fbConfig.php';

//Unset user data from session
unset($_SESSION['userData']);

//Destroy session data
$facebook->destroySession();
$_SESSION = array();
setcookie(session_name(),'',time()-2592000,'/');
session_destroy();


//Redirect to homepage
header("Location:tfb.php");
?>