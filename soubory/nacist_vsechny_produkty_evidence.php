<?php


$db_user="root";
$db_pass="";
$db_db="matprac2";
// Create connection
$conn = new mysqli("localhost",$db_user, $db_pass,$db_db);
$conn->set_charset("utf8");
if ($conn->connect_error) {
	echo "konec";
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT `mp_evidence_produktu`.`id`,`mp_produkty`.`Název`,`mp_evidence_produktu`.`popis`
FROM `mp_evidence_produktu`
LEFT JOIN `mp_produkty` ON  `mp_produkty`.`ID` = `mp_evidence_produktu`.`id_typu_produktu` 
WHERE vyrazen='nevyrazene'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    $produkty2[]=$row;
}
echo json_encode($produkty2);

?>