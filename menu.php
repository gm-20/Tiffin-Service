<!DOCTYPE html>
<html lang="en">
<style>
body{
background-image:url('img/menu-back.jpg');
background-size:cover;
}
#overlay1 {
margin: auto;
position: absolute;
top: 70px;
 left: 50px;
bottom: 50px;
 right: 50px;
color: #FFF;
z-index:5;
border-radius:4px;}
#content{
width:100%;
height:200px;
 position:relative;
background:#F5F5F5;
 }
.menu{
margin-top:10px;
width:auto;
height:auto;
margin-left:100px;
border:1px solid transparent;

}
.btn1{
margin-left:400px;
}
.alert{
width:500px;
height:100px;
margin-left:250px;
}
.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
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
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s
}

.sidenav a:hover, .offcanvas a:focus{
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/materialize.min.css">
    <link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/bootstrap.min.css">

 <link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,400italic,700,700italic|Noto+Serif:400,400italic,700,700italic' rel='stylesheet' type='text/css'>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

<body>

     <div class="container" style="width: 100%; max-width: 100%;">
        <div class="mdl-grid fd-11-o-clock-action-bar" style="height: 11em;">
            <div class="mdl-cell mdl-cell--12-col">
<span style="font-size:30px;cursor:pointer; float:right" onclick="openNav()">&#9776;</span>

       </div>
</div>
<div id="overlay1">
<div id="mySidenav" class="sidenav">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

<div class="container">
    <div class="row profile">
		<div class="col-md-3">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<img src="images/srk.jpg" class="img-responsive img-circle" alt="" width="304" height="236">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						Marcus Doe
					</div>
					<div class="profile-usertitle-job">
						Developer
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class="profile-userbuttons">
					<button type="button" class="btn btn-success btn-sm">Follow</button>
					<button type="button" class="btn btn-danger btn-sm">Message</button>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li class="active">
							<a href="#">
							<i class="glyphicon glyphicon-home"></i>
							Overview </a>
						</li>
						<li>
							<a href="#">
							<i class="glyphicon glyphicon-user"></i>
							Account Settings </a>
						</li>
						<li>
							<a href="#">
							<i class="glyphicon glyphicon-ok"></i>
							Tasks </a>
						</li>
						<li>
							<a href="#">
							<i class="glyphicon glyphicon-flag"></i>
							Help </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>
		<div class="col-md-9">
           		</div>
	</div>
</div></div>

<div id="content">
<h1>Manu Tiffin center</h1>
</div>


<div class="menu">
  <?php include("insidemenu.html");
  ?>
<div class="alert alert-success">
<h3>Monthly Charges (Lunch+Dinner):2500</h3>
<h3>Monthly Charges (Breakfast+Lunch+Dinner):3000</h3>

</div>

<button type="button" class="btn btn-success btn-lg btn1">Trial</button>
<button type="button" class="btn btn-success  btn-lg btn2">Confirm</button>

</div>
</div>
</div>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "330px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>


  </body>
    </html>
