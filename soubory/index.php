<?php 
session_start();
$db_user="root";
$db_pass="";
$db_db="matprac";
$connect = new mysqli("localhost",$db_user, $db_pass,$db_db);
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
if(isset($_GET["action"]))
{ //mazání
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["kosik"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["ID"])
			{
				unset($_SESSION["kosik"][$keys]);
				echo '<script>alert("Zboží odstraněno")</script>';
				echo '<script>window.location="index.php"</script>';
			}
		}
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
	</head>
	<body>
	<div class="session uzivatel">
	<?php
	if (isset($_SESSION["uzivatel"])){
		echo "<p> ADMIN: ".$_SESSION["uzivatel"]." </p>
		rozcestník pro admina: <a href=\"pridat.html\"> pridat položku</a>, <a href=\"odebrat.html\">odebrat položku</a>
		<button onclick=\"window.location.href = 'odhlasitse.php';\"style=\"margin-top:5px;\" id=\"odhlasit se button\" >odhlásit se</button>" ;
		
		}
	
	?>
	</div>

		<br />
		<div class="container">
			<br />
			<br />
			<br />
			<br /><br />
			<?php
			//výpis všech produků
				$query = "SELECT * FROM MP_produkty ORDER BY ID";
				$result = mysqli_query($connect, $query);
				if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
						
				?>
				
			<div class="col-md-4">
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
					<div class="pridat do kosiku">
			
			
			<?php
					}
				}
			?>
			<button onclick="window.location.href = 'zobrazitkosik.php';"style="margin-top:5px;" class="btn btn-success" >zobrazit kosik</button>
					</div>
	</body>
</html>
