<html lang="en">
<title>Blažrent</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <script src="jquery-3.4.1.min.js"></script> -->

<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
<link type="text/css" rel="stylesheet" href="css/style.css"/>
<?php
session_start();
if (isset($_SESSION["uzivatel"])){
    echo "<p> ADMIN: ".$_SESSION["uzivatel"]." </p>";
    ?>
    <form method="post" action="pridat.php" id="formular">
            název: <input type="text" name="nazev"><br>
            <!-- kategorie:  <input type="radio" name="kat" value="male" checked> Male<br>-->
           <!-- <input type="radio" name="kat" value="female"> Female<br>-->
           <!-- <input type="radio" name="kat" value="other"> Other-->
           <!-- <button value="light" type="submit">light</button>-->
           cena: <input type="number" name="cena" ><br>
           
        </form>
        kategorie: <select name="kategorie" form="formular">
            <option value="1">Audio</option>
            <option value="2">Video</option>
            <option value="3">Light</option>
            <option value="4">Grip</option>
            </select><br>
        Popis <input type="text" name="popis", size="500" form="formular" ><br>      
        <input type="submit" name="submit" value="submit" form="formular">
   
   <?php 
}
else{
    echo "na toto nemáte práva, nebo nejste přihlášeni";

}
// Check connection
if(isset($_POST["submit"])){

$nazev=$_POST["nazev"];
$cena=$_POST["cena"];
$kategorie=$_POST["kategorie"];
$popis=$_POST["popis"];

//DB
$db_user="root";
$db_pass="";
$db_db="matprac";
// Create connection
$conn = new mysqli("localhost",$db_user, $db_pass,$db_db);
$conn->set_charset("utf8");

if ($conn->connect_error) {
	echo "konec";
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "INSERT INTO MP_produkty (Název, id_kategorie, Cena, Popis)
VALUES ('$nazev','$kategorie','$cena','$popis')";

if ($conn->query($sql) === TRUE) {
    echo "Položka byla úspěšně přidána";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
echo ("<br><a href=\"index.php\" >vrátit se zpátky</a>");
}

?>