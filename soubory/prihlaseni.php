<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<title>Blažrent</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <script src="jquery-3.4.1.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="cookies.js"></script>
<script src="ajax_nacteni_kosiku.js"></script>
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
</style>
<link type="text/css" rel="stylesheet" href="css/style.css"/>

<body id="prihlasenibody">
<h1 id="nahore">BLAŽRENT</h1>

<div class="session uzivatel" >
    <?php
    if (isset($_SESSION["uzivatel"])){
        echo "<p align=\"right\"> ADMIN: ".$_SESSION["uzivatel"]." </p> " ;
    }
	?>
	</div>
<form method="post" action="prihlaseni.php" class="form-signin" id="prihlaseni">
<label for="inputName" class="sr-only">Jméno:</label>
<input type="text" id="inputName" class="form-control" placeholder="Zadej přihlašovací jméno" name="login" required autofocus>
<label for="inputPassword" class="sr-only">Heslo:</label> <input type="password" id="inputPassword" class="form-control" name="pass" placeholder="Password" required ><br>
<input type="submit" value="Přihlásit se" class="btn btn-success btn-lg btn-block">
</form>

<?php

if(isset($_POST['login']) && isset($_POST['pass'])){
   
    if(empty($_POST['login']) || empty($_POST['pass'])){
        echo "zadej prosím všechny údaje";
    }
    else{
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'matprac2');


$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


$login=$_POST["login"];
$pass=$_POST["pass"];


$sql = "SELECT id FROM `mp_admins` WHERE password='$pass' AND login='$login'";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$count = mysqli_num_rows($result);
if($count == 1) {
    $_SESSION["uzivatel"] =$_POST["login"];
   //echo "správně";
    header("location: index.php");
 }else {
     echo"Your Login Name or Password is invalid";
 }


}

}

    ?>
</body>
</html>