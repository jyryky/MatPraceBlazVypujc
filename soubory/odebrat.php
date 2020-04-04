<!DOCTYPE html>
<html lang="en">
<title>Blažrent</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <script src="jquery-3.4.1.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
<link type="text/css" rel="stylesheet" href="css/style.css"/>
<script src="ajax_odstranění.js"></script>
<script src="cookies.js"></script>
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
</style>
<form method="post" action="odebrat.php" id="formular_odebrat">

<body>
    <button value="zobraz" type="button">zobraz</button>
    <div id="produkty">
    </div>
 <input type="submit" value="odeslat" name="odeslat" id="odeslat" form="formular_odebrat">   
 </form>
<?php
if(isset($_POST["odeslat"])){
if(!empty($_POST['check_list'])){
    $db_user="root";
    $db_pass="";
    $db_db="matprac";
$connect = new mysqli("localhost",$db_user, $db_pass,$db_db);
    

foreach($_POST['check_list'] as $selected){
echo $selected."</br>";
$sql="UPDATE mp_produkty SET Vyřazené ='vyrazene' WHERE ID='$selected'";
if ($connect->query($sql) === TRUE) {
    echo "Zboží úspěšně vyřazeno";
} else {
    echo "Stala se chyba kontaktujte Admina" ;
    //echo $connect->error;
}
$connect->close();

}
}
}



?>


</body>
</html>