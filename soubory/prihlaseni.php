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
<link type="text/css" rel="stylesheet" href="css/style.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
</style>
<body>
<form method="post" action="prihlaseni.php" id="prihlaseni">
Jméno: <input type="text" name="login"><br>
Heslo: <input type="text" name="pass"><br>
<input type="submit" value="odešli se">
</form>

<?php

if(isset($_POST['login']) && isset($_POST['pass'])){
   
    if(empty($_POST['login']) || empty($_POST['pass'])){
        echo "zadej prosím všechny údaje";
    }
    else{

$db_user="root";
$db_pass="";
$db_db="matprac";
$connect = new mysqli("localhost",$db_user, $db_pass,$db_db);
$db = mysqli_select_db($connect, "matprac");
$login=$_POST["login"];
$pass=$_POST["pass"];

$sql = ("SELECT * FROM 'mp_admins_bezpassword' WHERE pass='$pass' AND loginn='$login'");
$result=mysqli_query($connect,$sql);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
echo $row;
if($row == 1){
$_SESSION["uzivatel"] =$_POST["login"];
echo $_SESSION["uzivatel"];
//header("Location: index.php"); // Redirecting to other page
} 
else
{
$errorr = "Username of Password is Invalid";
echo $errorr;
}
mysqli_close($connect); // Closing connection
}

}

    ?>
</body>
</html>