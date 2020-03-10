<!DOCTYPE html>
<html lang="en">
<title>Blažrent</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=d  evice-width, initial-scale=1">
<!-- <script src="jquery-3.4.1.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
<link type="text/css" rel="stylesheet" href="css/style.css"/>
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
</style>
<body>
<form method="post" action="odeslat_email.php" id="odeslani_objednavky">
Jméno: <input type="text" name="name"><br>
Příjmení: <input type="text" name="surname"><br>
E-mail: <input type="text" name="email"><br>
Telefon: <input type="text" name="tel"><br>
objednavka od: <input type="date" name="date_from">
objednavka do: <input type="date" name="date_to">
<input type="submit" >
</form>
<?php
$db_user="root";
$db_pass="";
$db_db="matprac";
$connect = new mysqli("localhost",$db_user, $db_pass,$db_db);




//posílání emailu /////////////////////
session_start();
if (isset($_POST["email"])){
$prijemce = $_POST["email"];
$jmeno  = $_POST["name"];
$prijmeni =$_POST["surname"];
$tel =$_POST["tel"];
$predmet = "Objednavka Blazrent";
$objednavka_od=$_POST["date_from"];
$objednavka_do=$_POST["date_to"];

$date=date("Y-m-d");
//echo $date;
$sql = "INSERT INTO mp_zakaznici (jmeno,prijmeni,email,telefon,datum_objednavky)
        VALUES ('$jmeno', '$prijmeni','$prijemce', '$tel','$date')";
//$connect->query($sql)
$connect->query($sql);
///////////////////

//Zápis objednávky
$sql = "INSERT INTO mp_vypujcka(od,do,id_zakaznika)
VALUES('$objednavka_od','$objednavka_od',(SELECT id FROM mp_zakaznici
WHERE jmeno = '$jmeno' AND prijmeni = '$prijmeni' AND email='$prijemce' AND telefon='$tel' AND datum_objednavky='$date'
 ORDER BY id DESC LIMIT 1))";
$connect->query($sql);

//výpis ID objednávky
$sql = "SELECT id FROM `mp_vypujcka` WHERE ( SELECT id FROM mp_zakaznici
WHERE jmeno = '$jmeno' AND prijmeni = '$prijmeni' AND email='$prijemce' AND telefon='$tel' AND datum_objednavky='$date'
)
ORDER BY id DESC LIMIT 1";
$result=$connect->query($sql);

while($row= $result->fetch_assoc()) {
    $Id_objednavky=$row["id"];
    echo $Id_objednavky;
}



if(!empty($_SESSION["kosik"]))
{
    $total = 0;  
$txt = "Vaše Objednavka Č.".$Id_objednavky." \n Pro: ".$prijemce." ".$prijmeni."\n  <br> Email: ".$prijemce."\n<br> tel:".$tel."<br> Máte objednáno:  \n  <div class=\"table-responsive\"> <table class=\"table table-bordered\"> <tr>
<th width=>Item Name</th>
<th width=>Quantity</th>
<th width=>Price</th>
<th width=>total</th>
</tr>
";
foreach($_SESSION["kosik"] as $keys => $values)
    {
$add="
<tr>
<td>".$values["item_name"]."</td>
<td>".$values["item_quantity"]."</td>
<td>".$values["item_price"]."</td>
<td>".number_format($values["item_quantity"] * $values["item_price"], 2)."</td>
</tr>"
;
$txt .= $add;
}
$txt.="

</table>
   
</div>";
}


//$txt = wordwrap($txt,70);
$headers = "From: kuablec.jiri@sspbrno.cz" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
echo ($txt);


//odeslání mailu
//mail($prijemce,$predmet,$txt,$headers);


?>
</body>
</html>
<h1>vaše objednávka byla uspěšně odeslána</h1>
<?php } ?>
</body>
</html>