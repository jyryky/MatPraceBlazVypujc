<?php 
session_start();
require_once './config/config.php';
$connect = new mysqli($db_host,$db_user, $db_pass,$_db);
if ($connect->connect_error) {
	echo "konec";
    die("Connection failed: " . $connect->connect_error);
} 
if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["kosik"]))
	{//přídání do array
		$item_array_id = array_column($_SESSION["kosik"], "item_id");
		if(!in_array($_GET["ID"], $item_array_id))
		{
			$count = count($_SESSION["kosik"]);	
			$item_array = array(
				'item_id'			=>	$_GET["ID"],
				'item_name'			=>	$_POST["Název"],
				'item_price'		=>	$_POST["Cena"],
				'item_quantity'		=>	$_POST["quantity"]
			);
			
			$_SESSION["kosik"][$count] = $item_array;
		}
		else
		{
			echo '<script>alert("Toto zboží jste již přidal, přejděte do košíku a odstaňte ho")</script>';
		}
	}
	else
	{
		$item_array = array(
			'item_id'			=>	$_GET["ID"],
			'item_name'			=>	$_POST["Název"],
			'item_price'		=>	$_POST["Cena"],
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["kosik"][0] = $item_array;
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
		<link  rel="stylesheet"  href="css/style.css?v=1.0" >
	</head>
	<body>
	
	<div class="session uzivatel">
	<h1><a href="index.php" id="nadpis">BLAŽRENT</a></h1>
	<?php
	if (isset($_SESSION["uzivatel"])){
		echo "<p> ADMIN: ".$_SESSION["uzivatel"]." </p>
		rozcestník pro admina: <a href=\"pridat.html\"> pridat položku</a>, <a href=\"odebrat.html\">odebrat položku</a>
		<button onclick=\"window.location.href = 'odhlasitse.php';\"style=\"margin-top:5px;\" id=\"odhlasit se button\" >odhlásit se</button>" ;
		
		}
	
	?>
	</div>
	<div class="pridat do kosiku" align="right">
			<button onclick="window.location.href = 'zobrazitkosik.php';"style="margin-top:5px;"  class="btn btn-success"  >zobrazit kosik</button>
	</div>
	<div class="input-group mb-3">
  
<form method="post" action="index.php">
	<select class="custom-select" id="inputGroupSelect02" name="kategorie">
    <option value="1" name="kategorie">Audio</option>
    <option value="2" name="kategorie">Video</option>
    <option value="3" name="kategorie">Light</option>
	<option value="4" name="kategorie">Grip</option>
  </select>
  <input type=submit name="submit_kategorie" value="zobrazit kategorie" id="submit_kategorie" />
</form>
		<div class="container">
			<?php
			if(!isset($_POST["submit_kategorie"])){
			//výpis všech produků
				$query = "SELECT * FROM _produkty WHERE Vyřazené='nevyrazene' ORDER BY ID";
				$result = mysqli_query($connect, $query);
				if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
				?>	
			<div class="col-md-4" style="margin-bottom:10px;">
			<div id="vsechny">
				<form method="post" action="index.php?action=add&ID=<?php echo $row["ID"]; ?>">
					<div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
						<h4 class="text-info"><?php echo $row["Název"]; ?></h4>

						<h4 class="text-danger"><?php echo $row["Cena"]; ?>CZK</h4>

						<input type="text" name="quantity" value="1" class="form-control" />

						<input type="hidden" name="Název" value="<?php echo $row["Název"]; ?>" />

						<input type="hidden" name="Cena" value="<?php echo $row["Cena"]; ?>" />

						<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
					</div>
				</form>
			</div>
			</div>
			<?php
					}
				}
			}
			?>
			
			<?php 
			if(isset($_POST["submit_kategorie"])){
			$kategorie=$_POST["kategorie"];
				$query = "SELECT * FROM MP_produkty WHERE id_kategorie='$kategorie' ORDER BY ID";
				$result = mysqli_query($connect, $query);
				if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
				?>	
			<div class="col-md-4" style="margin-bottom:10px;">
			<div class="kategorie">
				<form method="post" action="index.php?action=add&ID=<?php echo $row["ID"]; ?>">
					<div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
						<h4 class="text-info"><?php echo $row["Název"]; ?></h4>

						<h4 class="text-danger"><?php echo $row["Cena"]; ?>CZK</h4>

						<input type="text" name="quantity" value="1" class="form-control" />

						<input type="hidden" name="Název" value="<?php echo $row["Název"]; ?>" />

						<input type="hidden" name="Cena" value="<?php echo $row["Cena"]; ?>" />

						<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
					</div>
				</form>
			</div>
			</div>	
			<?php
						}
				}
			}
			?>
			
	</body>
</html>
