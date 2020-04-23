<?php


$db_user="root";
$db_pass="";
$db_db="matprac2";
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

$sql = "SELECT  `ID`,  `Název`,`Kategorie`,`Cena`,Dostupnost FROM `MP_produkty` WHERE `Kategorie`='$button' ";
$result = $conn->query($sql);


/*echo "<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
<th>Hometown</th>
<th>Job</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['first_name'] . "</td>";
    echo "<td>" . $row['last_name'] . "</td>";
    echo "<td>" . $row['birth'] . "</td>";
    echo "<td>" . $row['MONTHNAME(`birth`)'] . "</td>";
    echo "</tr>";
}
echo "</table>";*//*
while($row = $result->fetch_assoc()) {
    $prezident[] = array("first_name" => $row['firstname'], "last_name" =>  $row['LastName'], "birth" => $row['birth'], "mesic"=> $row['MONTH(`birth`)']);   
}*/
while($row = $result->fetch_assoc()) {

    /*$prezidenti[] = array("first_name" => $row['first_name'], "last_name" =>  $row['last_name'], "birth" => $row['birth'], "mesic"=> $row['MONTHNAME(`birth`)']);
    $prezidenti[] = array("first_name" => $row['first_name'], "last_name" =>  $row['last_name'], "birth" => $row['birth'], "mesic"=> $row['MONTHNAME(`birth`)']);*/

    $produkty[]=$row;
}
//echo $produkty;
//$prezidenti[] = array($row["first_name"]. $row["last_name"]. $row["birth"].$row["MONTHNAME(`birth`)"];
echo json_encode($produkty);
/*directions = json_decode($_POST[$prezident]);
var_dump(directions);*/
 
// prezidenti

 
?>