<!DOCTYPE html>
<html lang="en">
<title>Blažrent</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <script src="jquery-3.4.1.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
<script src="ajax_odstranění.js"></script>
<script src="ajax_odstranění_evidence.js"></script>
<style>
    html,
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: "Roboto", sans-serif;
    }
</style>
<link type="text/css" rel="stylesheet" href="css/style.css" />
<?php
$db_user = "root";
$db_pass = "";
$db_db = "matprac2";
$connect = new mysqli("localhost", $db_user, $db_pass, $db_db);
?>

<body>
    <h1><a href="index.php" id="nadpis">BLAŽRENT</a></h1>
    <a href=index.php style="padding-left:3%;" id="podtrzeni">← Zpět na hlavní stránku</a>
    <div id="nastred2">
            <button value="Typ" type="button" class="btn btn-warning btn-sm" aria-pressed="true" id="typ">Zobraz evidenci typů produktů</button>
            <button value="kategorie" type="button" class="btn btn-warning btn-sm" aria-pressed="true" id="kategorie">Zobraz evidenci všech produktů</button>
    </div>
    <div id="produkty">

        <?php
if (isset($_POST["odeslat_typ"])) {
    if (!empty($_POST['check_list'])) {
        foreach ($_POST['check_list'] as $selected) {
            //echo $selected . "</br>";
            $sql = "UPDATE mp_produkty SET Vyřazené ='vyrazene' WHERE ID='$selected'";
            if ($connect->query($sql) === true) {
                echo '<script type="text/javascript">alert("Technika vyřazena")</script>';
            } else {
                echo "Stala se chyba kontaktujte Admina";
                //echo $connect->error;
            }
            
            
        }
    }
    $connect->close();
    unset($_POST);
} 
if (isset($_POST["odeslat_evidence"])) {
    if (!empty($_POST['check_list'])) {
        foreach ($_POST['check_list'] as $selected) {
           // echo $selected . "</br>";
            $sql = "UPDATE mp_evidence_produktu
            SET vyrazen ='vyrazene'
            WHERE id='$selected'";
            if ($connect->query($sql) === true) {
                echo '<script type="text/javascript">alert("Technika vyřazena")</script>';
            } else {
                echo "Stala se chyba kontaktujte Admina";
                //echo $connect->error;
            }
            $sql2="SELECT  `mp_produkty`.`PocetKusu`, `mp_evidence_produktu`.`id_typu_produktu`
            FROM `mp_produkty`,`mp_evidence_produktu`
            WHERE `mp_evidence_produktu`.`id` = '$selected' and `mp_evidence_produktu`.`id_typu_produktu`=`mp_produkty`.`ID`";
            $result = $connect->query($sql2);
            $row = $result->fetch_assoc();
            $idTypuProduktu=$row["id_typu_produktu"];
            $pocetkusuminusjedna=$row["PocetKusu"]-1;

            $sql3="UPDATE `mp_produkty`
            SET `PocetKusu` ='$pocetkusuminusjedna'
            WHERE `ID`='$idTypuProduktu'";
            $connect->query($sql3) ;

            
            
        }
    }
    $connect->close();
    unset($_POST);
}

?>


</body>

</html>