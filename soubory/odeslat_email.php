<!DOCTYPE html>
<html lang="en">
<title>Blažrent</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=d  evice-width, initial-scale=1">
<!-- <script src="jquery-3.4.1.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/style.css"/>
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
</style>
<body>
<div class="session uzivatel">
    <?php
    if (isset($_SESSION["uzivatel"])){
    echo "<p align=\"right\"> ADMIN: ".$_SESSION["uzivatel"]." </p> " ;
    }
	?>
    </div>
    
<input type="button" value="zobrazit košík" onclick="window.location.href='zobrazitkosik.php'; "style="margin:5px;" class="btn btn-success">
<form method="post" action="odeslat_email.php" id="odeslani_objednavky" >
<div class="form-group">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="formGroupExampleInput">Jméno:
            <input type="text" name="name" class="form-control" id="formGroupExampleInput">
        </div>
        <div class="form-group col-md-6">
            <label for="formGroupExampleInput">Příjmení: </label> 
            <input type="text" class="form-control" id="formGroupExampleInput" name="surname">
        </div>
    </div>
    <div class="form-row">
            <label for="inputEmail4">E-mail:</label>
            <input type="email" class="form-control" id="inputEmail4" name="email">
    </div>
    <label for="inputEmail4">Telefon: </label>
<input class="form-control" type="tel" name="tel"><br>
objednavka od: <input type="date" name="date_from">
objednavka do: <input type="date" name="date_to">
<input type="submit" name="submit" >
</div>
</form>

<?php
$db_user="root";
$db_pass="";
$db_db="matprac";
$connect = new mysqli("localhost",$db_user, $db_pass,$db_db);




//posílání emailu /////////////////////
session_start();
if (isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["tel"]) && isset($_POST["date_from"]) && isset($_POST["date_to"])){
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

while($row= $result->fetch_assoc()) {
    $Id_objednavky=$row["id"];
    //echo $Id_objednavky;
}

//přidělení techniky k objedavce
foreach($_SESSION["kosik"] as $keys => $values)
{
$forID=$values["item_id"]  ;
$sql="INSERT INTO `vypujcka-produkty` (`id_technika`,`id_vypujcka`)
VALUES((SELECT `ID` FROM `mp_produkty`
WHERE ID = '$forID') ,(SELECT `id` FROM `mp_vypujcka`
WHERE id = '$Id_objednavky'))";
$connect->query($sql);
    }

//email zpáva 
if(!empty($_SESSION["kosik"])){
$total = 0;  
$txt = "Vaše Objednavka Č.".$Id_objednavky." \n Pro: ".$prijemce." ".$prijmeni."\n  <br> Email: ".$prijemce."\n<br> tel:".$tel."<br>
OD:".$objednavka_od."\n<br>
DO:".$objednavka_do."\n<br>
Máte objednáno:  \n  <div class=\"table-responsive\"> <table class=\"table table-bordered\"> <tr>
<th width=>Produkt</th>
<th width=>Množství</th>
<th width=>Cena</th>
<th width=>Celkem</th>
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
///email zprava konec


//$txt = wordwrap($txt,70);
$headers = "From: kuablec.jiri@sspbrno.cz" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
echo ($txt);


//odeslání mailu NUTNO ODKOMEŘÁŘOVAT
mail($prijemce,$predmet,$txt,$headers);
unset($_SESSION["kosik"]);

?>
</body>
</html>
<h1>vaše objednávka byla uspěšně odeslána</h1>
<?php } 
elseif (isset($_POST["submit"])) {
echo "<br>nevyplnil jste všechny údaje";
 }
 

?>
</body>
</html>