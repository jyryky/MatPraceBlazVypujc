<?php
session_start();
$db_user = "root";
$db_pass = "";
$db_db = "matprac2";
$connect = new mysqli("localhost", $db_user, $db_pass, $db_db);
if (isset($_POST["add_to_cart"])) {
    if ($_POST["quantity"] <= $_POST["pocetKusu"]) {
        if (isset($_SESSION["kosik"])) { //přídání do array
            $item_array_id = array_column($_SESSION["kosik"], "item_id");
            if (!in_array($_GET["ID"], $item_array_id)) {
                $count = count($_SESSION["kosik"]);
                $item_array = array(
                    'item_id' => $_GET["ID"],
                    'item_name' => $_POST["Název"],
                    'item_price' => $_POST["Cena"],
                    'item_quantity' => $_POST["quantity"],
                    'item_max_quantity' => $_POST["pocetKusu"],
                );

                $_SESSION["kosik"][$count] = $item_array;
            } else {
                echo '<script>alert("Toto zboží jste již přidal, přejděte do košíku a odstaňte ho")</script>';
            }
        } else {
            $item_array = array(
                'item_id' => $_GET["ID"],
                'item_name' => $_POST["Název"],
                'item_price' => $_POST["Cena"],
                'item_quantity' => $_POST["quantity"],
                'item_max_quantity' => $_POST["pocetKusu"],
            );
            $_SESSION["kosik"][0] = $item_array;
        }
    } else {
        unset($_POST);
        echo '<script>alert("vložte maximálně tolik kolik je počet Kusů")</script>';
    }
}

?>
<!DOCTYPE html>


<html>

<head>
	<title>BlazRent</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/style.css?v=1.0">
</head>

<body>

	<div class="" style="padding:16px;">
		<h1><a href="index.php" id="nadpis">BLAŽRENT</a></h1>
		<?php
if (isset($_SESSION["uzivatel"])) {
    echo "<p id=\"admimOdsazeniOdkraje\" align=\"right\"> ADMIN: " . $_SESSION["uzivatel"] . " </p>
		Rozcestník pro admina: <a href=\"pridat.php\" id=\"podtrzeni\"> pridat položku</a>, <a href=\"odebrat.php\"  id=\"podtrzeni\">odebrat položku</a>
		<button onclick=\"window.location.href ='odhlasitse.php'\"; class=\"btn btn-danger btn-xs\" id=\"buttonRight\">odhlásit se</button>";

}

?>
	</div>
	<div class="pridatdokosiku" align="right">
		<button onclick="window.location.href = 'zobrazitkosik.php';" style="margin-bottom:5px;"
			class="btn btn-warning">Zobrazit kosik</button>
	</div>

	<div id=selector>
		<div class="input-group">
			<form method="post" action="index.php">
				<select class="form-control" id="inputGroupSelect04" name="kategorie">
					<option value="1" name="kategorie">Audio</option>
					<option value="2" name="kategorie">Video</option>
					<option value="3" name="kategorie">Light</option>
					<option value="4" name="kategorie">Grip</option>
				</select>
				<input type=submit name="submit_kategorie" value="Zobrazit kategorie" id="submit_kategorie"
					class="btn btn-secondary btn-xs" />
			</form>
		</div>
	</div>
	<div class="containerr">

		<?php
if (!isset($_POST["submit_kategorie"])) {
    //výpis všech produků
    $query = "SELECT * FROM MP_produkty WHERE Vyřazené='nevyrazene' ORDER BY ID";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            ?>
		<div class="col-md-4" style="margin-bottom:10px; ">
			<div id="vsechny">
				<form method="post" action="index.php?action=add&ID=<?php echo $row["ID"]; ?>">
					<div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;"
						align="center">
						<h4 class="text-info"><?php echo $row["Název"]; ?></h4>

						<h4 class="text-danger"><?php echo $row["Cena"]; ?>CZK</h4>

						<p class="text-info"> Maximální počet kusů:<?php echo $row["pocetKusu"]; ?></p>

						<a href type="button" data-html="true" data-toggle="tooltip" data-placement="top" title="
								<?php
$date = date("Y-m-d");
            $id = $row["ID"]; //výpis všech volných produktů
            $query2 = "SELECT `mp_vypujcka`.`od`, `mp_vypujcka`.`do`
								FROM `mp_evidence_produktu`, `vypujcka-produkty` vypujcka_produkty, `mp_vypujcka`
								WHERE `mp_evidence_produktu`.`id` = `vypujcka_produkty`.`id_technika`
								and `mp_vypujcka`.`id` = `vypujcka_produkty`.`id_vypujcka`
								and `mp_evidence_produktu`.`id_typu_produktu`='$id'";

            $result2 = mysqli_query($connect, $query2);
            if (mysqli_num_rows($result2) > 0) {
                $i = 0;
                $j = 0;
                while ($row2 = mysqli_fetch_array($result2)) {
                    $i = $i + 1;
                    if ($row2["do"] < $date) {
                        $j = $j + 1;
                        continue;
                    }
                    echo ("Od: " . $row2["od"] . " Do: " . $row2["do"] . "<br>");
                }
                if ($j == $i) {
                    echo "tento produkt je volný kdykoliv";
                }
            } else {
                echo "tento produkt je volný kdykoliv";
            }?>
						">
							Zobrazit obsazení produktů<sup id="podtrzeni">?</sup>
						</a>
						<br>
						<input type="number" name="quantity" min="1" value="1" class="form-control" />

						<input type="hidden" name="Název" value="<?php echo $row["Název"]; ?>" />

						<input type="hidden" name="pocetKusu" value="<?php echo $row["pocetKusu"]; ?>" />

						<input type="hidden" name="Cena" value="<?php echo $row["Cena"]; ?>" />

						<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success"
							value="Přidat do košíku" />
					</div>
				</form>
			</div>
		</div>
	</div>



	<?php
}
    }
}
?>
	<?php
if (isset($_POST["submit_kategorie"])) {
    $kategorie = $_POST["kategorie"];
    $query = "SELECT * FROM MP_produkty WHERE id_kategorie='$kategorie' and Vyřazené='nevyrazene' ORDER BY ID";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            ?>
	<div id="vsechny">
		<div class="col-md-4" style="margin-bottom:10px;">
			<div id="vsechny">
				<div class="kategorie">
					<form method="post" action="index.php?action=add&ID=<?php echo $row["ID"]; ?>">
						<div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;"
							align="center">
							<h4 class="text-info"><?php echo $row["Název"]; ?></h4>

							<h4 class="text-danger"><?php echo $row["Cena"]; ?>CZK</h4>

							<p class="text-info"> Maximální počet kusů:<?php echo $row["pocetKusu"]; ?></p>

							<a href type="button" data-html="true" data-toggle="tooltip" data-placement="top" title="
								<?php
			$date = date("Y-m-d");
            $id = $row["ID"]; //výpis všech volných produktů
            $query2 = "SELECT `mp_vypujcka`.`od`, `mp_vypujcka`.`do`
								FROM `mp_evidence_produktu`, `vypujcka-produkty` vypujcka_produkty, `mp_vypujcka`
								WHERE `mp_evidence_produktu`.`id` = `vypujcka_produkty`.`id_technika`
								and `mp_vypujcka`.`id` = `vypujcka_produkty`.`id_vypujcka`
								and `mp_evidence_produktu`.`id_typu_produktu`='$id'";
            $result2 = mysqli_query($connect, $query2);
            if (mysqli_num_rows($result2) > 0) {
                $i = 0;
                $j = 0;
                while ($row2 = mysqli_fetch_array($result2)) {
                    $i = $i + 1;
                    if ($row2["do"] < $date) {
                        $j = $j + 1;
                        continue;
                    }
                    echo ("Od:" . $row2["od"] . " Do:" . $row2["do"] . "<br>");
                }
                if ($j == $i) {
                    echo "tento produkt je volný kdykoliv";
                }
            } else {
                echo "tento produkt je volný kdykoliv";
            }?>
						">
								Zobrazit dostupnost produktů
							</a>
							<br>

							<input type="number" name="quantity" min="1" value="1" class="form-control" />

							<input type="hidden" name="Název" value="<?php echo $row["Název"]; ?>" />

							<input type="hidden" name="pocetKusu" value="<?php echo $row["pocetKusu"]; ?>" />

							<input type="hidden" name="Cena" value="<?php echo $row["Cena"]; ?>" />

							<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success"
								value="Přidat do košíku" />
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
	

	<?php
}
    }
}
?>

	<div class="position-absolut" id="marginasi" >
		<hr>
		<p id="vypujcniPodminky">Výpůjční doba se účtuje ode dne vyzvednutí až po den vrácení.
			K veškeré technice je kabeláž samozřejmostí. Očekávejte prosím telefonát od našeho technika, který s
			vámi vyjedná detaily. Platba pouze předem v hotovosti.  <br>Ohledně všech nejasností volejte na číslo:+420
			606 366 </p>
	</div>
	<script>
		$(document).ready(function () {
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
</body>

</html>