<?php


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




// Get value of clicked button
$button = $_GET['button'];
//$button ="audio";
$sql = "SELECT `ID`,`Název`,`Kategorie`,`Cena`,Dostupnost,`Popis` FROM `MP_produkty` ";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    $produkty[]=$row;
}
echo json_encode($produkty);

?>