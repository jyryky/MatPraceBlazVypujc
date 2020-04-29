<html lang="en">
<title>Blažrent</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <script src="jquery-3.4.1.min.js"></script> -->

<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="css/style.css" />

<body>
    <h1><a href="index.php" id="nadpis">BLAŽRENT</a></h1>
    <a href=index.php style="padding-left:3%;" id="podtrzeni">← Zpět na hlavní stránku</a>
    <?php
session_start();
if (isset($_SESSION["uzivatel"])) {
    echo "<p id=\"admimOdsazeniOdkraje\" align=\"right\"> ADMIN: " . $_SESSION["uzivatel"] . " </p>";

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

    <div id="pridatSkupinuProduktu">
        <h2 align="center">Přidat novou<br> skupinu techniky</h2>
        <form method="post" action="pridat.php" id="formular">
            <div class="form-row">
                <div class="form-group">
                    <label for="KatNazev">Název: </label><input type="text" id="KatNazev" class="form-control" placeholder="RCF 312 mkv4"
                        name="nazev" required>
                </div>
                <div class="form-group">
                    <label for="KatCena">cena: </label><input type="number" id="KatCena" class="form-control" min=1 placeholder="Cena za den"
                        name="cena" required>
                </div>
            </div>
                <div class="form-group">
        </form>
        <label for="KatKat">kategorie:</label> <select id="KatKat" class="form-control"  name="kategorie" form="formular">
                <option value="1">Audio</option>
                <option value="2">Video</option>
                <option value="3">Light</option>
                <option value="4">Grip</option>
            </select>
    </div>
    
    <div class="form-row">
    <div class="form-group">
    <label for="KatPopis">Popis </label><textarea type="text" name="popis" id="KatPopis" size="500" form="formular" class="form-control" required></textarea>
    <input type="submit" name="submit1" class="btn btn-primary" value="odeslat" id="nastred" style="margin-top:20px;" form="formular" >
    </div>
    </div>
</div>



    <div id="pridatSamostatnyProduktu"> 
    <h2 align="center">Přidat nový kus<br> techniky do evidence</h2>
        <form method="post" action="pridat.php" id="formular2">
        </form>
        <div class="form-group">
            <div class="form-row">
       <label for="SamProd"> O jaký typ se jedná: </label><select id="SamProd" name="idtypu" class="form-control" form="formular2">
            <?php
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row["ID"], $row["Název"];
            echo "<option value=" . $row["ID"] . ">" . $row["Název"] . "</option>";
        }
    }
    ?>
    </div>

    <div class="form-group">
          
        </select><br>
        <label for="">Popis </label><textarea type="text" name="Evidence_popis" id="SamPopis" size="500" form="formular2" class="form-control"
            id="exampleFormControlTextarea1" required></textarea>

        <input type="submit" name="submit2" value="odeslat" id="nastred" style="margin-top:20px;" class="btn btn-primary" form="formular2">
    </div>
    </div>
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

    $sql = "INSERT INTO MP_produkty (Název, id_kategorie, pocetKusu,Cena, Popis)
VALUES ('$nazev','$kategorie',0,'$cena','$popis')";

    if ($conn->query($sql) === true) {
        echo '<script type="text/javascript">alert("Nová skupina byla úspěšně přidána. Ted přidej jednotlivé produkty")</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    unset($_POST);

}

if (isset($_POST["submit2"]) && !empty($_POST["Evidence_popis"])) {

    $typ = $_POST["idtypu"];
    $popis = $_POST["Evidence_popis"];

    $sql = "INSERT INTO mp_evidence_produktu (id_typu_produktu, Popis)
    VALUES ('$typ',' $popis')";

    if ($conn->query($sql) === true) {
        //echo '<script type="text/javascript">alert("chyba")</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        echo '<script type="text/javascript">alert("chyba")</script>';
    }
    $sql2 = "SELECT `pocetKusu` FROM `mp_produkty` WHERE ID='$typ'";
    $result = mysqli_query($conn, $sql2);
    $row = mysqli_fetch_array($result);
    $novyPocetKusu = $row["pocetKusu"] + 1;

    $sql3 = "UPDATE `mp_produkty` SET `PocetKusu`='$novyPocetKusu' WHERE `ID`='$typ'";
    if ($conn->query($sql3) === true) {
        $sql4="SELECT `id` FROM `mp_evidence_produktu` ORDER BY `id` DESC LIMIT 1";
        $result2 = mysqli_query($conn, $sql4);
        $row2 = mysqli_fetch_array($result2);
        echo '<script type="text/javascript">alert("Zboží úspěšně přídáno. Toto zboží má toto evidenční číslo: ' . $row2["id"] . '")</script>';
    } else {
        echo "Error: " . $sql3 . "<br>" . $conn->error;
        echo '<script type="text/javascript">alert("chyba")</script>';
    }
    $conn->close();
    unset($_POST);
}
?>
</body>