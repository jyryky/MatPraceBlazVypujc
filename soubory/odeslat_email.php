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
<div class="session uzivatel">
    <?php
if (isset($_SESSION["uzivatel"])) {
    echo "<p align=\"right\"> ADMIN: " . $_SESSION["uzivatel"] . " </p> ";
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


<input type="button" value="zobrazit košík" onclick="window.location.href='zobrazitkosik.php'; "style="margin:5px;" class="btn btn-warning">
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
            <label for="datum od" class="col-2 col-form-label">objednavka od: </label>
            <input type="date" name="date_from" class="form-control" id="datum od">
        </div>
        <div class="form-group col-md-6">
        <label for="datum od" class="col-2 col-form-label">objednavka do: </label>
        <input type="date" name="date_to" class="form-control" id="datum do">
        </div>
    </div>

        <input type="submit" name="submit" value="odeslat objednávku" class="btn btn-success" id="odeslat"; style="margin:5px;">
</form>

<?php
$db_user = "root";
$db_pass = "";
$db_db = "matprac2";
$connect = new mysqli("localhost", $db_user, $db_pass, $db_db);

//posílání emailu /////////////////////
session_start();
if (isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["tel"]) && isset($_POST["date_from"]) && isset($_POST["date_to"])) {
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
        /*foreach ($_SESSION["kosik"] as $keys => $values) {
        $produktyKtereMajiKolizniDatum = [];
        $forID = $values["item_id"];
        $sql = "SELECT mp_produkty.pocetKusu
        FROM mp_produkty
        WHERE `ID` = '$forID'";
        $result = $connect->query($sql);
        while ($row = $result->fetch_assoc()) {
        $maxPocetProdutku = $row["pocetKusu"];
        }
        $pocetObsazenychProduktu = 0;
        //for ($i = 1; $i <= $maxPocetProdutku; $i++){ ////////////////////////////////////////////////////////////////////////////////// VYMYSLET ZÍTRA S KLÁROU!!!!!!!
        $sql2 = "SELECT `mp_vypujcka`.`od`, `mp_vypujcka`.`do` , `mp_evidence_produktu`.`id`, `mp_evidence_produktu`.`id_typu_produktu`
        FROM `mp_evidence_produktu`, `vypujcka-produkty` vypujcka_produkty, `mp_vypujcka`
        WHERE `mp_evidence_produktu`.`id` = `vypujcka_produkty`.`id_technika`
        and `mp_vypujcka`.`id` = `vypujcka_produkty`.`id_vypujcka`
        and `mp_evidence_produktu`.`id_typu_produktu`='$forID'";
        $result2 = mysqli_query($connect, $sql2);
        if (mysqli_num_rows($result2) > 0) {
        while ($row2 = mysqli_fetch_array($result2)) {
        if ($row2["do"] >= $date) {
        $daterow = $row2["od"];
        $odZDtabazeString = strtotime($row2["od"]);
        $oddateFOR = $oddate;
        //for ($j=0; $j<$values["item_quantity"]; $j++){}+
        for ($iii = 0; $iii <= $days; $iii++) {
        $breakProDruhýCyklus = 0;
        for ($ii = 0; $ii <= $days; $ii++) {
        if ($oddateFOR == $odZDtabazeString) {
        $pocetObsazenychProduktu++;
        $breakProDruhýCyklus++;
        //array_push($produktyKtereMajiKolizniDatum, $row2["id"]);
        echo "break";
        break;
        }
        $dt = date("Y-m-d", strtotime("+1 day", $odZDtabazeString));
        $odZDtabazeString = strtotime($dt);
        }
        if ($breakProDruhýCyklus == 1) {
        break;
        }
        //$oddateFOR->modify('+1 day');
        $dt = date("Y-m-d", strtotime("+1 day", $oddateFOR));
        $oddateFOR = strtotime($dt);
        // echo $oddateFOR."<br>";

        }
        echo "<br>  pocet obsazenych produktů " . $pocetObsazenychProduktu;
        echo "<br> id produktu " . $row2["id_typu_produktu"];
        echo "<br> id evidence " . $row2["id"];
        if ($pocetObsazenychProduktu == $values["item_quantity"]) {
        array_push($produktyKtereMajiKolizniDatum, $row2["id_typu_produktu"]);
        }
        array_push($volneIdProduktu, $row2["id"]);
        }
        }
        }
        $volneIdProduktu = array_unique($volneIdProduktu);
        print_r($produktyKtereMajiKolizniDatum);
        echo "<br> item quantity" . $values["item_quantity"];
        echo "klářina podnminka:".$maxPocetProdutku - count($produktyKtereMajiKolizniDatum);
        if ($maxPocetProdutku - count($produktyKtereMajiKolizniDatum) < $values["item_quantity"]) {
        $blby++;
        echo "blbec:" . $blby;
        }
        }
        //vypsání kolizních produktů
        if ($blby > 0) {
        //echo count($produktyKtereMajiKolizniDatum);
        foreach ($_SESSION["kosik"] as $keys => $values) {
        for ($i = 0; $i < count($produktyKtereMajiKolizniDatum); $i++) {
        {if ($values["item_id"] == $produktyKtereMajiKolizniDatum[$i]) {
        //echo $values["item_name"];
        unset($_POST);
        echo '<script type="text/javascript">alert("Následující zboží má kolizní datum: ' . $values["item_name"] . '")</script>';

        }
        }
        }
        }
        //echo ' <script type="text/javascript">document.location=\'zobrazitkosik.php\'</script>';
        }*/

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
                   /* print_r($PoleIdKoliznichProduktu);
                    echo "<br> polevšech id";
                    print_r($PoleVsechID);*/

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
            //print_r($PoleVsechID);

            //print_r(array_diff( $PoleVsechID,$PoleIdKoliznichProduktu));
            $PoleVsechID = array_unique($PoleVsechID);
            $PoleIdDobrychProduktu = array_merge($PoleIdDobrychProduktu, array_diff($PoleVsechID, $PoleIdKoliznichProduktu));

            //echo $values["item_max_quantity"];
            if ($values["item_max_quantity"] - count($PoleIdKoliznichProduktu) < $values["item_quantity"]) {
                echo '<script type="text/javascript">alert("Následující zboží má kolizní datum: ' . $values["item_name"] . '")</script>';
            } else {

                while ($values["item_quantity"] > $i) {
                    array_push($PoleIdProZapis, $PoleIdDobrychProduktu[$i]);
                    $i++;
                }
            }
        }

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
VALUES((SELECT `ID` FROM `mp_produkty`
WHERE ID = '$values2') ,(SELECT `id` FROM `mp_vypujcka`
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
Máte objednáno:  \n  <div class=\"table-responsive\"> <table class=\"table table-bordered\"> <tr>
<th width=>Produkt</th>
<th width=>Množství</th>
<th width=>Cena</th>
<th width=>Celkem</th>
</tr>
";
            foreach ($_SESSION["kosik"] as $keys => $values) {
                $add = "
<tr>
<td>" . $values["item_name"] . "</td>
<td>" . $values["item_quantity"] . "</td>
<td>" . $values["item_price"] . "</td>


<td>" . number_format($values["item_quantity"] * $values["item_price"], 2) . "</td>
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
    } else {
        echo '<script>alert("zadejte správně datum")</script>';
    }
    ?>
</body>
</html>

<?php } elseif (isset($_POST["submit"])) {
    echo "<br>nevyplnil jste všechny údaje";
}

?>
</body>
</html>