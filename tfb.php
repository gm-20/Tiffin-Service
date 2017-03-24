<?php

////////////////////////////////////////////////////FB login
//Include FB config file && User class
require_once 'fbConfig.php';
require_once 'User.php';

if(!$fbUser){
	$fbUser = NULL;
	$loginURL = $facebook->getLoginUrl(array('redirect_uri'=>$redirectURL,'scope'=>$fbPermissions));
	$output = '<a href="'.$loginURL.'"><img src="images/fblogin-btn.jpg" height="50"></a>';
}else{
//Get user profile data from facebook
	$fbUserProfile = $facebook->api('/me?fields=id,first_name,last_name,email,link,gender,locale,picture');

	//Initialize User class
	$user = new User();

	//Insert or update user data to the database
	$fbUserData = array(
		'oauth_provider'=> 'facebook',
		'oauth_uid' 	=> $fbUserProfile['id'],
		'first_name' 	=> $fbUserProfile['first_name'],
		'last_name' 	=> $fbUserProfile['last_name'],
		'email' 		=> $fbUserProfile['email'],
		'gender' 		=> $fbUserProfile['gender'],
		'locale' 		=> $fbUserProfile['locale'],
		'picture' 		=> $fbUserProfile['picture']['data']['url'],
		'link' 			=> $fbUserProfile['link']
	);
	$userData = $user->checkUser($fbUserData);

	//Put user data into session
	$_SESSION['userData'] = $userData;

	//Render facebook profile data
	if(!empty($userData)){
		$output = '<h1>Facebook Profile Details </h1>';
		$output .= '<img src="'.$userData['picture'].'">';
        $output .= '<br/>Facebook ID : ' . $userData['oauth_uid'];
        $output .= '<br/>Name : ' . $userData['first_name'].' '.$userData['last_name'];
        $output .= '<br/>Email : ' . $userData['email'];
        $output .= '<br/>Gender : ' . $userData['gender'];
        $output .= '<br/>Locale : ' . $userData['locale'];
        $output .= '<br/>Logged in with : Facebook';
		$output .= '<br/><a href="'.$userData['link'].'" target="_blank">Click to Visit Facebook Page</a>';
        $output .= '<br/>Logout from <a href="logout.php">Facebook</a>';
	}else{
		$output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
	}
}

?>

<?php
//////////////////////////////////////////////////////Gmail Login
require_once 'gapi/gpConfig.php';
require_once 'gapi/User.php';

if(isset($_GET['code'])){
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	//	$redirectURL = 'http://' . $_SERVER['HTTP_HOST'] . '/';
	header("location:tfb.php");
//	header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
	$gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
	//Get user profile data from google
	$gpUserProfile = $google_oauthV2->userinfo->get();
	//here we r craeting a class named gUser
	$user = new gUser();
    $gpUserData = array(
        'oauth_provider'=> 'google',
        'oauth_uid'     => $gpUserProfile['id'],
        'first_name'    => $gpUserProfile['given_name'],
        'last_name'     => $gpUserProfile['family_name'],
        'email'         => $gpUserProfile['email'],
        'gender'        => (isset($gpUserProfile['gender']) ? $gpUserProfile['gender'] : null),
        'locale'        => $gpUserProfile['locale'],
        'picture'       => $gpUserProfile['picture'],
        'link'          => (isset($gpUserProfile['link']) ? $gpUserProfile['link'] : null)
    );
		//checkUser is function of class gUser
    $userData = $user->checkUser($gpUserData);

	$_SESSION['userData'] = $userData;

    if(!empty($userData)){
        $gutput = '<h1>Google+ Profile Details </h1>';
        $gutput .= '<img src="'.$userData['picture'].'" width="300" height="220">';
        $gutput .= '<br/>Google ID : ' . $userData['oauth_uid'];
        $gutput .= '<br/>Name : ' . $userData['first_name'].' '.$userData['last_name'];
        $gutput .= '<br/>Email : ' . $userData['email'];
        $gutput .= '<br/>Gender : ' . $userData['gender'];
        $gutput .= '<br/>Locale : ' . $userData['locale'];
        $gutput .= '<br/>Logged in with : Google';
        $gutput .= '<br/><a href="'.$userData['link'].'" target="_blank">Click to Visit Google+ Page</a>';
        $gutput .= '<br/>Logout from <a href="gapi/logout.php" >Google</a>';
    }else{
        $gutput = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
}
 else {
	$authUrl = $gClient->createAuthUrl();
	$gutput = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="img/glogin.png" alt=""/></a>';
}



?>






<?php
$db_hostname = "localhost";
$db_username = "root";
$db_password = "";
$db_database="tiffin";



$connection = new mysqli($db_hostname,$db_username,$db_password,$db_database);
if($connection->connect_error) die($connection->connect_error);

$query = "select * from user";

$result = $connection->query($query);
$rows = ($result)->num_rows;
echo <<<_END
<!DOCTYPE html>
<html lang="en">
<style>

#overlay1 {
margin: auto;
position: absolute;
top: 70px;
 left: 50px;
bottom: 60px;
 right: 50px;
color: #FFF;
z-index:5;
border-radius:4px;}

#content{
width:100%;
height:350px;
 position:relative;
background:#99FF33;
 }
.btn-success{
margin-left:940px;
margin-top: 15px;
}
.btn-primary{
margin-left:1140px;
margin-top:-10px;
  }
.btn-floating{
margin-left:1100px;
margin-top:-40px;
}
h1{font-family:Arial, Helvetica, sans-serif;color:#999999;}
input[type=text] {
    width: 130px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-image: url('searchicon.png');
    background-position: 10px 10px;
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
}

input[type=text]:focus {
    width: 100%;
}

.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 10;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 15px;
    color: #bebdbd;
    display: block;
    transition: 0.3s
}

.sidenav a:hover, .offcanvas a:focus{
    //color: #f1f1f1;
		color: #aea6c1;
		text-decoration: none;

}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

#main {
    transition: margin-left .5s;
    padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px; text-decoration:none;}
}

.search-box{
			 width: 1100px;
			 position: relative;
			 display: inline-block;
			 font-size: 18px;
	 }
	 .search-box input[type="text"]{
			 height: 32px;
			 padding: 5px 10px;
			 border: 1px solid #CCCCCC;
			 font-size: 14px;
	 }
	 .result{
			 position: absolute;
			 z-index: 999;
			 top: 100%;
			 left: 0;
	 }
	 .search-box input[type="text"], .result{
			 width: 100%;
			 box-sizing: border-box;
	 }
	 /* Formatting result items */
	 .result p{
			 margin: 0;
			 padding: 7px 10px;
			 border: 1px solid #CCCCCC;
			 border-top: none;
			 cursor: pointer;
			 display: block;
			 color:#000000;
			 background-color: #CCCCCC;
	 }
	 .result p:hover{
			 background: #f2f2f2;
	 }
</style>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/materialize.min.css"
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/materialize.css">
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		<link href="https://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <script type="text/javascript" src="js/jquery.onImagesLoad.min.js"></script>
    <script type="text/javascript" src="js/jquery.responsiveSlides.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
		<script>
		function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        var term = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(term.length){
					//ajax call to backend bitch form.php
            $.get("form.php", {query: term}).done(function(data){
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });

    $(document).on("click", ".result p", function(){
        //$(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        //naina jo saanjh khwab dekhte hain naina...............
				window.location.href= 'menus/' + $(this).text() + '.php';
        $(this).parent(".result").empty();
    });
});
		</script>
<body style="background-color: #bebdbd;">
<!--
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <li>
	<a href="#" data-toggle="modal" data-target="#editprofile"><i class="glyphicon glyphicon-user"></i> Edit Profile</a>
	</li>
	<li>
	<a href="#"><i class="glyphicon glyphicon-time"></i> Transaction History</a>
	</li>
	<li>
	<a href="#"><i class="glyphicon glyphicon-calendar"></i> Attendence</a>
	</li>
	<li>
  <a href="#"><i class="glyphicon glyphicon-shopping-cart"></i> Add Order</a>
	</li>
	<li>
  <a href="#"> <i class="glyphicon glyphicon-off"></i> Logout</a>
	</li>
	<li>
  <a href="about.php"><i class="glyphicon glyphicon-envelope"></i> Feedback</a>
	</li>
 </div>
 -->
<div class="container" style="width: 100%; max-width: 100%;">
    <div class="mdl-grid fd-11-o-clock-action-bar" style="height: 11em;">
         <div class="mdl-cell mdl-cell--12-col">
            <span style="cursor:pointer;" onclick="openNav()"><img src="menu.png" alt="Tiffinwala" height="50px" width ="70px"></span>

        <p style="text-align: center;"><b>Tiffinwala</b></p>
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Signup</button>
         </div>
    </div>
     <div id="overlay1">
		 <div class="search-box">
<input type="text" name="search" autocomplete="off" placeholder="Search by Name">
<div class="result"></div>
	 </div>
     <div id="content">
     <img src="img/home-page-new-bck-1.jpg">
     <img src="img/home-page-new-bck-2.jpg">
     <img src="img/home-page-new-bck-3.jpg">


</div>
</div>
<br>
_END;
?>

<?php
$count = 0;
for($j = -1 ; $j < $rows ; ++$j){
  $result->data_seek($j);
  $row = $result->fetch_array(MYSQLI_NUM);
echo <<<_END
<style>
.tiffin-center{
width:1230px;
height:170px;
margin-top:70px;
margin-left:50px;
//border:1px solid black;
border: 3px solid #dadada;
border-radius: 7px;
postion:absolute;
background-color:white;
}



</style>
_END;

echo <<<_END
<div class="tiffin-center" class="container">
 <h1> $row[0]</h1> <h4>$row[1]</h4><h5>$row[2]</h5>
 <a class="btn-floating btn-large waves-effect waves-light red" href="menus/$row[0].php"><i class="material-icons">menu</i></a>
  </div>
_END;
}
?>
<?php
echo <<<_END
</div>



 <script language="javascript">

$(function(){

	var p=$('#content').responsiveSlides({
		height:350,						// slides conteiner height
		background:'#fff',				// background color and color of overlayer to fadeout on init
		autoStart:true,					// boolean autostart
		startDelay:0,					// start whit delay
		effectInterval:5000,			// time to swap photo
		effectTransition:1000,			// time effect
		pagination:[
			{
				active:true,			// activate pagination
				inner:true,				// pagination inside or aouside slides conteiner
				position:'B_L', 		/*
											pagination align:
												T_L = top left
												T_C = top center
												T_R = top right

												B_L = bottom left
												B_C = bottom center
												B_R = bottom right
										*/
				margin:10, 				// pagination margin
				dotStyle:'', 			// dot pagination class style
				dotStyleHover:'', 		// dot pagination class hover style
				dotStyleDisable:''		// dot pagination class disable style
			}
		]
	});

});
</script>
<script>
$('.dropdown-button').dropdown({
      inDuration: 300,
      outDuration: 225,
      constrain_width: false, // Does not change width of dropdown to that of the activator
      hover: true, // Activate on hover
      gutter: 0, // Spacing from edge
      belowOrigin: false, // Displays dropdown below the button
      alignment: 'left' // Displays dropdown with edge aligned to the left of button
    });
$('.dropdown-button').dropdown('open');
$('.dropdown-button').dropdown('close');

</script>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registration</h4>
        </div>
        <div class="modal-body">
       <div><center>$output</center></div>
       <div><center>$gutput</center></div>
</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

<!--Edit profile model-->
<div class="modal fade" id="editprofile" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-edit"></span> Edit Details</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
         <form role="form-horizontal">
            <div class="form-group form-group-lg">
<div class="col-sm-8">
                    <label for="usrname"><span class="glyphicon glyphicon-edit"></span> Change delivery address</label>
                   <input type="text" class="form-control" id="usrname" placeholder="Enter New Delievery address">
            </div></div>
<br>
<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-right"></span> Save New Address</button>
          </form>
<br><br>
<form role="form">
            <div class="form-group">
<div class="col-sm-6">

              <label for="psw"><span class="glyphicon glyphicon-edit"></span>Change Mobile No</label>

              <input type="text" class="form-control" name="oldno" placeholder="Enter old Number">
<br>

              <input type="text" class="form-control" name="newno" placeholder="Enter New Number">
</div>
            </div>
<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-right"></span> Save New Number</button>
          </form>


<!--tiffin details-->
<label for="psw"><span class="glyphicon glyphicon-edit"></span>Tiffin Details</label>

<div class="panel panel-default">
    <div class="panel-body">
<label for="psw">Your Tiffin Center:</label><br>
<label for="psw">Starting Date:</label><br>
<label for="psw">Tiffin owner name:</label><br>
<label for="psw">Address:</label><br>

</div>
  </div>

<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-cross"></span>Cancel My Order</button>

                      </div>
        </div>

    </div>
  </div>


<style>
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700,300);
footer { background-color:#0c1a1e; min-height:350px; font-family: 'Open Sans', sans-serif; }
.footerleft { margin-top:50px; padding:0 36px; }
.logofooter { margin-bottom:10px; font-size:25px; color:#fff; font-weight:700;}

.footerleft p { color:#fff; font-size:12px !important; font-family: 'Open Sans', sans-serif; margin-bottom:15px;}
.footerleft p i { width:20px; color:#999;}


.paddingtop-bottom {  margin-top:50px;}
.footer-ul { list-style-type:none;  padding-left:0px; margin-left:2px;}
.footer-ul li { line-height:29px; font-size:12px;}
.footer-ul li a { color:#a0a3a4; transition: color 0.2s linear 0s, background 0.2s linear 0s; }
.footer-ul i { margin-right:10px;}
.footer-ul li a:hover {transition: color 0.2s linear 0s, background 0.2s linear 0s; color:#ff670f; }

.social:hover {
     -webkit-transform: scale(1.1);
     -moz-transform: scale(1.1);
     -o-transform: scale(1.1);
 }




 .icon-ul { list-style-type:none !important; margin:0px; padding:0px;}
 .icon-ul li { line-height:75px; width:100%; float:left;}
 .icon { float:left; margin-right:5px;}


 .copyright { min-height:40px; background-color:#000000;}
 .copyright p { text-align:left; color:#FFF; padding:10px 0; margin-bottom:0px;}
 .heading7 { font-size:21px; font-weight:700; color:#d9d6d6; margin-bottom:22px;}
 .post p { font-size:12px; color:#FFF; line-height:20px;}
 .post p span { display:block; color:#8f8f8f;}
 .bottom_ul { list-style-type:none; float:right; margin-bottom:0px;}
 .bottom_ul li { float:left; line-height:40px;}
 .bottom_ul li:after { content:"/"; color:#FFF; margin-right:8px; margin-left:8px;}
 .bottom_ul li a { color:#FFF;  font-size:12px;}
</style>


<br>
<br>
<footer class="container">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-6 footerleft ">
        <div class="logofooter"> Logo</div>
        <p>We are student of NIT Raipur and are starting a buisness model for tiffin service in Raipur.</p>
        <p><i class="fa fa-map-pin"></i> 631, Sindhiya Nagar , Durg , C.G. - 491001, INDIA</p>
        <p><i class="fa fa-phone"></i> Phone (India) : +91 9755908329</p>
        <p><i class="fa fa-envelope"></i> E-mail : grvm0520@gmail.com</p>

      </div>
      <div class="col-md-2 col-sm-6 paddingtop-bottom">
        <h6 class="heading7">GENERAL LINKS</h6>
        <ul class="footer-ul">
          <li><a href="#"> Career</a></li>
          <li><a href="#"> Privacy Policy</a></li>
          <li><a href="#"> Terms & Conditions</a></li>
          <li><a href="#"> Client Gateway</a></li>
          <li><a href="#"> Ranking</a></li>
          <li><a href="#"> Frequently Ask Questions</a></li>
        </ul>
      </div>
      <div class="col-md-3 col-sm-6 paddingtop-bottom">
			<div class="fb-page" data-href="https://plus.google.com/apps/activities
" data-tabs="timeline" data-height="300" data-small-header="false" style="margin-bottom:15px;" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
				<div class="fb-xfbml-parse-ignore">
					<blockquote cite="https://www.facebook.com/facebook"><a href="https://plus.google.com/apps/activities
">Google+</a></blockquote>
				</div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 paddingtop-bottom">
        <div class="fb-page" data-href="https://www.facebook.com/facebook" data-tabs="timeline" data-height="300" data-small-header="false" style="margin-bottom:15px;" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
          <div class="fb-xfbml-parse-ignore">
            <blockquote cite="https://www.facebook.com/facebook"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<div class="copyright">
  <div class="container">
    <div class="col-md-6">
      <p>© 2017 - All Rights with Tiffinwala</p>
    </div>
    <div class="col-md-6">
      <ul class="bottom_ul">
        <li><a href="#">tiffinwala.com</a></li>
        <li><a href="#">About us</a></li>
        <li><a href="#">Faqs</a></li>
        <li><a href="#">Contact us</a></li>
        <li><a href="#">Site Map</a></li>
      </ul>
    </div>
  </div>
</div>

</body>
</html>
_END;


 ?>
