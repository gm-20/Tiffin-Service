<?php
$db_hostname = "localhost";
$db_username = "root";
$db_password = "";
$db_database="tiffin";
$connection = new mysqli($db_hostname,$db_username,$db_password,$db_database);
if($connection->connect_error) die($connection->connect_error);

if(isset($_POST['delete']) && isset($_POST['phone'])){
  $phone = get_post($connection,'phone');
  $query = "DELETE from user where phone = '$phone'";
  $result = $connection->query($query);
}

if(isset($_POST['name']) && isset($_POST['addr']) && isset($_POST['phone'])){

  $name = ucfirst(strtolower(get_post($connection,'name')));
  $addr = ucfirst(strtolower(get_post($connection,'addr')));
  $phone = get_post($connection,'phone');

  $query = "INSERT INTO user values "."('$name','$addr','$phone')";
  $result = $connection->query($query);

}

echo <<<_END
<html>
<head title="TiffinAdmin">
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
 <script>
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
 });

 </script>
</head>
<body>
<div class="container">
<h3><ul>TiffinAdmin</ul></h3>
<hr>
<div class="search-box">
<input type="text" name="search" autocomplete="off" placeholder="Search by Name">
<div class="result"></div>
</div>
<hr>
<form action="t.php" method="post"><pre>
Name     <input type="text" name="name">
Address  <input type="text" name="addr">
Phone    <input type="text" name="phone">
<button class="waves-effect waves-light btn-large" type="submit" >Add User
<i class="material-icons right">send</i>
</button>
<hr>
</pre></form>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>

</body>
</html>
_END;

$query = "select * from user";

$result = $connection->query($query);
$rows = $result->num_rows;

for($j = 0 ; $j < $rows ; ++$j){
  $result->data_seek($j);
  $row = $result->fetch_array(MYSQLI_NUM);
  echo <<<_END
  <html>
  <head title="TiffinAdmin">
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
  </head>
  <body>
  <div class="container">

  <pre>
  Name    $row[0]
  Address $row[1]
  Phone   $row[2]
  </pre>
  <form action="t.php" method="post">
  <input type="hidden" name="delete" value="yes">
  <input type="hidden" name="phone" value="$row[2]">
  <input class="waves-effect waves-teal btn-flat" type="submit" value="DELETE RECORD"></form>
  </div>
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>

  </body>
  </html>
_END;
}

$result->close();
$connection->close();

function get_post($connection,$var){
  return $connection->real_escape_string($_POST[$var]);
}

 ?>
