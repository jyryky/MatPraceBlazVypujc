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
if (isset($_POST["email"])){
$prijemce = $_POST["email"];
$jmeno  = $_POST["name"];
$tel =$_POST["tel"];
$predmet = "Objednavka Blazrent";
$txt = "Vaše Objednavka Č.XXX \n Pro: ".$prijemce."\n Email: ".$prijemce."\n tel:".$tel."Máte objednáno: XXX";
$txt = wordwrap($txt,70);
$headers = "From: kuablec.jiri@sspbrno.cz" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
echo ($prijemce. $jmeno.$tel);
mail($prijemce,$predmet,$txt,$headers);
?>
</body>
</html>
<h1>vaše objednávka byla uspěšně odeslána</h1>
<?php } ?>
</body>
</html>