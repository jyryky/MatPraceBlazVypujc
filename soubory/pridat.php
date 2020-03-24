<?php
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

// Check connection
if ($conn->connect_error) {
	echo "konec";
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "INSERT INTO MP_produkty (Název, id_kategorie, Cena, Popis)
VALUES ('$nazev', '$kategorie','$cena','$popis')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
echo ("<br><a href=\"index.php\" >vrátit se zpátky</a>");
?>