<html lang="en">
<title>Blažrent</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <script src="jquery-3.4.1.min.js"></script> -->

<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="css/style.css" />

<body>
    <h1><a href="index.php" id="nadpis">BLAŽRENT</a></h1>
    <?php
session_start();
if (isset($_SESSION["uzivatel"])) {
    echo "<p> ADMIN: " . $_SESSION["uzivatel"] . " </p>";

    $db_user = "root";
    $db_pass = "";
    $db_db = "matprac2";
// Create connection
    $conn = new mysqli("localhost", $db_user, $db_pass, $db_db);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        echo "konec";
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT `Název`,`ID` FROM `mp_produkty` WHERE Vyřazené='nevyrazene'";
    ?>
    <div>
        <form method="post" action="pridat.php" id="formular">
            název: <input type="text" name="nazev"><br>
            cena: <input type="number" name="cena"><br>
            Celkový počet kusů: <input type="number" name="PocetKusu"><br>
        </form>
        kategorie: <select name="kategorie" form="formular">
            <option value="1">Audio</option>
            <option value="2">Video</option>
            <option value="3">Light</option>
            <option value="4">Grip</option>
        </select><br>
        Popis <input type="text" name="popis" , size="500" form="formular" class="form-control"
            id="exampleFormControlTextarea1"><br>
        <input type="submit" name="submit1" value="odeslat" form="formular">
    </div>



    <div>
        <form method="post" action="pridat.php" id="formular2">
        </form>
        O jaký typ se jedná: <select name="idtypu" form="formular2">
            <?php
$result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row["ID"], $row["Název"];
            echo "<option value=" . $row["ID"] . ">" . $row["Název"] . "</option>";
        }
    }
    ?>
        </select><br>
        Popis <input type="text" name="Evidence_popis" , size="500" form="formular2" class="form-control"
            id="exampleFormControlTextarea1"><br>

        <input type="submit" name="submit2" value="odeslat" form="formular2">
    </div>

    <?php
} else {
    echo "na toto nemáte práva, nebo nejste přihlášeni";

}
// Check connection
if (isset($_POST["submit1"])) {

    $nazev = $_POST["nazev"];
    $cena = $_POST["cena"];
    $kategorie = $_POST["kategorie"];
    $popis = $_POST["popis"];
    $pocetKusu = $_POST["PocetKusu"];

    $sql = "INSERT INTO MP_produkty (Název, id_kategorie, pocetKusu,Cena, Popis)
VALUES ('$nazev','$kategorie','$pocetKusu','$cena','$popis')";

    if ($conn->query($sql) === true) {
        echo "Položka byla úspěšně přidána";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    echo ("<br><a href=\"index.php\" >vrátit se zpátky</a>");
}

if (isset($_POST["submit2"])) {

    $typ = $_POST["idtypu"];
    $popis = $_POST["Evidence_popis"];

    $sql = "INSERT INTO mp_evidence_produktu (id_typu_produktu, Popis)
    VALUES ('$typ',' $popis')";

    if ($conn->query($sql) === true) {
        echo "Položka byla úspěšně přidána";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $sql2 = "SELECT `pocetKusu` FROM `mp_produkty` WHERE ID='$typ'";
    $result = mysqli_query($conn, $sql2);
    $row = mysqli_fetch_array($result);
    $novyPocetKusu = $row["pocetKusu"] + 1;

    $sql3 = "UPDATE `mp_produkty` SET `PocetKusu`='$novyPocetKusu' WHERE `ID`='$typ'";
    if ($conn->query($sql3) === true) {
        echo "upratava";
    } else {
        echo "Error: " . $sql3 . "<br>" . $conn->error;
    }
    $conn->close();
    echo ("<br><a href=\"index.php\" >vrátit se zpátky</a>");
}
?>
</body>