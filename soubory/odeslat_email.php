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
<link  rel="stylesheet"  href="css/style.css?v=1.0" >
<body>
<h1><a href="index.php" id="nadpis">BLAŽRENT</a></h1>
<div class="session uzivatel">
    <?php
session_start();
if (isset($_SESSION["uzivatel"])) {
    echo "<p id=\"admimOdsazeniOdkraje2\" align=\"right\"> ADMIN: " . $_SESSION["uzivatel"] . " </p> ";
}
?>
    </div>
<?php
$date = date("Y-m-d h:i:s");
//echo $date;
$dateBezHodin = date("Y-m-d");
//echo $date;
///////// kontrola jestli už některý produkt není půjčený
?>

<div class="odsazeniodkraju">
<input type="button" value="zobrazit košík" onclick="window.location.href='zobrazitkosik.php'; "style="margin-bottom:30px;margin-left:17px;" class="btn btn-warning">
<form method="post" action="odeslat_email.php" id="odeslani_objednavky" >

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="jmeno">Jméno:</label>
                <input type="text" name="name" class="form-control" id="jmeno">
            </div>
            <div class="form-group col-md-6">
                <label for="prijmeni">Příjmení: </label>
                <input type="text" name="surname" class="form-control" id="prijmeni" >
            </div>
        </div>

    <div class="form-group col-md-6">

            <label for="inputEmail">E-mail:</label>
            <input type="email" class="form-control" id="inputEmail" name="email">
    </div>
    <div class="form-group col-md-6">
            <label for="tel">Telefon: (bez mezer)</label>
            <input class="form-control" type="tel" name="tel" id="tel"><br>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="datum od" class="col-2 col-form-label">Objednavka od: </label>
            <input type="date" name="date_from" class="form-control" id="datum od">
        </div>
        <div class="form-group col-md-6">
        <label for="datum od" class="col-2 col-form-label">Objednavka do: </label>
        <input type="date" name="date_to" class="form-control" id="datum do">
        </div>
    </div>
    <div id="odsazeniodtopu">
        <input type="submit" name="submit" value="odeslat objednávku" class="btn btn-success btn-lg" id="nastred" style="margin-top:250px;">
</div>
   
</form>
</div>
<?php

$db_user = "root";
$db_pass = "";
$db_db = "matprac2";
$connect = new mysqli("localhost", $db_user, $db_pass, $db_db);

//posílání emailu /////////////////////

if (isset($_POST["submit"]) AND !empty($_POST["email"]) AND !empty($_POST["name"]) AND !empty($_POST["surname"]) AND !empty($_POST["tel"]) AND !empty($_POST["date_from"]) AND !empty($_POST["date_to"]) AND !empty($_SESSION["kosik"])) {
    $prijemce = $_POST["email"];
    $jmeno = $_POST["name"];
    $prijmeni = $_POST["surname"];
    $tel = $_POST["tel"];
    $predmet = "Objednavka Blazrent";
    $objednavka_od = $_POST["date_from"];
    $objednavka_do = $_POST["date_to"];



    $oddate = strtotime($objednavka_od);
    $dodate = strtotime($objednavka_do);
// výpočet délky výpujčky
    $diff = abs($dodate - $oddate);
    $days = idate('d', $diff); //převedení na inteeger
    $blby = 0;
//echo $days;
    //////////////////////////////
    if ($oddate <= $dodate) {
        $t = time();
        $date = date("Y-m-d h:i:s");
        $dateBezHodin = date("Y-m-d");
//echo $date;
        //////////////////////////////////////////////////////////////////// kontrola jestli už některý produkt není půjčený
        $dateBezHodin = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
        //$dateBezHodin->modify('+1 day');
        $volneIdProduktu = [];
        $pocitadlokoliznichproduktu=0;
//Zjištění jestli je dostatečný počet produktů volný
        $PoleIdDobrychProduktu = [];
        $PoleVsechID = [];
        $PoleIdProZapis = [];
        foreach ($_SESSION["kosik"] as $keys => $values) {
            $i = 0;
            $PoleIdDobrychProduktu = [];
            $PoleIdKoliznichProduktu = [];
            $PoleVsechID = [];
            $forID = $values["item_id"];
            $sql = "SELECT `mp_vypujcka`.`od`, `mp_vypujcka`.`do` , `mp_evidence_produktu`.`id`, `mp_evidence_produktu`.`id_typu_produktu`
            FROM `mp_evidence_produktu`, `vypujcka-produkty` vypujcka_produkty, `mp_vypujcka`
            WHERE `mp_evidence_produktu`.`id` = `vypujcka_produkty`.`id_technika`
            and `mp_vypujcka`.`id` = `vypujcka_produkty`.`id_vypujcka`
            and `mp_evidence_produktu`.`id_typu_produktu`= '$forID'";
            $result = $connect->query($sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    $rowDoDatetime = strtotime($row["do"]);
                    $rowoOdDatetime = strtotime($row["od"]);
                    //array_push($PoleVsechID, $row["id"]);
                    //echo $row["do"]." ".$oddate." ".$rowDoDatetime." ";
                    if ($rowDoDatetime >= $oddate && $rowoOdDatetime <= $dodate) {
                        array_push($PoleIdKoliznichProduktu, $row["id"]);
                    }

                }
            }
            $sql2 = "SELECT `mp_evidence_produktu`.`id`
               FROM `mp_evidence_produktu`
               WHERE `mp_evidence_produktu`.`id_typu_produktu` = '$forID'";
            $result2 = $connect->query($sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row = $result2->fetch_assoc()) {
                    array_push($PoleVsechID, $row["id"]);
                }
            }
            $PoleVsechID = array_unique($PoleVsechID);
            $PoleIdDobrychProduktu = array_merge($PoleIdDobrychProduktu, array_diff($PoleVsechID, $PoleIdKoliznichProduktu));
            if ($values["item_max_quantity"] - count($PoleIdKoliznichProduktu) < $values["item_quantity"]) {
                echo '<script type="text/javascript">alert("Následující zboží má kolizní datum: ' . $values["item_name"] . '")</script>';
                $pocitadlokoliznichproduktu++;
            } else {
                while ($values["item_quantity"] > $i) {
                    //echo "i:".$i;
                    //print_r($PoleIdDobrychProduktu);
                    array_push($PoleIdProZapis, $PoleIdDobrychProduktu[$i]);
                    $i++;
                }
            }
        }

if ($pocitadlokoliznichproduktu==0){
    

        //print_r($PoleIdDobrychProduktu);
        //print_r($PoleIdProZapis);
        /*else{
        array_push( $PoleIdDobrychProduktu,$row["id"]);
        }    */

///////////////////////////////////////////////////////////////////////////////
        $stmt = $connect->prepare("INSERT INTO mp_zakaznici (jmeno,prijmeni,email,telefon,datum_objednavky) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssis", $jmeno, $prijmeni, $prijemce, $tel, $date);
//$connect->query($sql);
        $stmt->execute();
        $stmt->close();
///////////////////

//Zápis objednávky
        $sql = "INSERT INTO mp_vypujcka(od,do,id_zakaznika)
VALUES('$objednavka_od','$objednavka_do',(SELECT id FROM mp_zakaznici
WHERE jmeno = '$jmeno' AND prijmeni = '$prijmeni' AND email='$prijemce' AND telefon='$tel' AND datum_objednavky='$date'
 ORDER BY id DESC LIMIT 1))";
        $connect->query($sql);

//výpis ID objednávky
        $sql = "SELECT id FROM `mp_vypujcka` WHERE ( SELECT id FROM mp_zakaznici
WHERE jmeno = '$jmeno' AND prijmeni = '$prijmeni' AND email='$prijemce' AND telefon='$tel' AND datum_objednavky='$date'
)
ORDER BY id DESC LIMIT 1";

        $result = $connect->query($sql);
        while ($row = $result->fetch_assoc()) {
            $Id_objednavky = $row["id"];
            //echo $Id_objednavky;
        }

//přidělení techniky k objedavce
foreach ($PoleIdProZapis as $values2) {
            $sql = "INSERT INTO `vypujcka-produkty` (`id_technika`,`id_vypujcka`)
VALUES($values2 ,(SELECT `id` FROM `mp_vypujcka`
WHERE id = '$Id_objednavky'))";
            $connect->query($sql);
        }
//}
//email zpáva
        if (!empty($_SESSION["kosik"])) {
            $total = 0;
            $txt = "Vaše Objednavka Č." . $Id_objednavky . " \n Pro: " . $prijemce . " " . $prijmeni . "\n  <br> Email: " . $prijemce . "\n<br> tel:" . $tel . "<br>
OD:" . $objednavka_od . "\n<br>
DO:" . $objednavka_do . "\n<br>
Počet dní:" . $days . "\n<br>
Máte objednáno:  \n  <div class=\"table-responsive\"> <table class=\"table table-bordered\"> <tr>
<th>Produkt</th>
<th>Množství</th>
<th>Cena</th>
<th>Celkem</th>
</tr>
";
            foreach ($_SESSION["kosik"] as $keys => $values) {
                $add = "
<tr>
<td>" . $values["item_name"] . "</td>
<td>" . $values["item_quantity"] . "</td>
<td>" . $values["item_price"] . "</td>


<td>" . number_format($days*($values["item_quantity"] * $values["item_price"]), 2) . "</td>
</tr>"
                ;
                $txt .= $add;
            }
            $txt .= "
</table>
</div>";
        }
        ///email zprava konec
        $headers = "From: kuablec.jiri@sspbrno.cz" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Bcc:technik@blazrent.cz" . "\r\n";
        echo ($txt);
        echo ("<h1>vaše objednávka byla uspěšně odeslána</h1>");

        //odeslání mailu NUTNO ODKOMEŘÁŘOVAT
        //mail($prijemce,$predmet,$txt,$headers);
        unset($_SESSION["kosik"]);
        $_POST=[];
    }
elseif($pocitadlokoliznichproduktu>0){
    echo '<script>window.location="zobrazitkosik.php"</script>';
}
    } else {
        echo '<script>alert("zadejte správně datum")</script>';
    }

    ?>
</body>
</html>

<?php } 
elseif (isset($_POST["submit"])) {
    echo '<script type="text/javascript">alert("Vyplňte prosím všechny údaje a zkontrolujte košík.")</script>';
}

?>
<div id="spodale a">
		<hr class="Podminkycara">
		<p id="vypujcniPodminky">Výpůjční doba se účtuje ode dne vyzvednutí až po den vrácení.
			K veškeré technice je kabeláž samozřejmostí. Očekávejte prosím telefonát od našeho technika, který s
			vámi vyjedná detaily. Platba pouze předem v hotovosti. Ohledně všech nejasností volejte na číslo:+420
			606 366 008 </p>
	</div>
</body>
</html>