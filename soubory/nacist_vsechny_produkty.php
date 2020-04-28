<?php


$db_user="root";
$db_pass="";
$db_db="matprac2";

$conn = new mysqli("localhost",$db_user, $db_pass,$db_db);
$conn->set_charset("utf8");
if ($conn->connect_error) {
	echo "konec";
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT `ID`,`Název`,`Cena`,`PocetKusu`,`Popis` FROM `MP_produkty` WHERE Vyřazené='nevyrazene' ";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    $produkty[]=$row;
}
echo json_encode($produkty);
?>