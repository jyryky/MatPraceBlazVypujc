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
<h2>formular</h2> 
<form method="post" action="odeslat_email.php" id="odeslani_objednavky">
Jméno a Příjmení / název firmy: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
Telefon: <input type="text" name="tel"><br>
<input type="submit" >
</form>
<?php

session_start();
if (isset($_POST["email"])){
$prijemce = $_POST["email"];
$jmeno  = $_POST["name"];
$tel =$_POST["tel"];
$predmet = "Objednavka Blazrent";

if(!empty($_SESSION["kosik"]))
{
    $total = 0;
    foreach($_SESSION["kosik"] as $keys => $values)
    {
$txt = "Vaše Objednavka Č.XXX \n Pro: ".$prijemce."\n <br> Email: ".$prijemce."\n<br> tel:".$tel."<br> Máte objednáno:  \n  <div class=\"table-responsive\"> <table class=\"table table-bordered\"> <tr>
<th width=>Item Name</th>
<th width=>Quantity</th>
<th width=>Price</th>
<th width=>total</th>

</tr>";
foreach($_SESSION["kosik"] as $keys => $values)
    {.
"<tr>
<td>".$values["item_name"]."</td>
<td>".$values["item_quantity"]."</td>
<td>".$values["item_price"]."</td>
<td>".number_format($values["item_quantity"] * $values["item_price"], 2)."</td>"
}."
</tr>
</table>
   
</div>";
    }}
//$txt = wordwrap($txt,70);
$headers = "From: kuablec.jiri@sspbrno.cz" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
echo ($txt);

mail($prijemce,$predmet,$txt,$headers);
?>
</body>
</html>
<h1>vaše objednávka byla uspěšně odeslána</h1>
<?php } ?>
</body>
</html>