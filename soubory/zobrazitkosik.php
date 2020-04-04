<!DOCTYPE html>
<html lang="en">
<title>Blažrent</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<!-- <script src="jquery-3.4.1.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="cookies.js"></script>
<script src="ajax_nacteni_kosiku.js"></script>
<!-- <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>-->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
</style>
<link  rel="stylesheet"  href="css/style.css">
</head>
<body onload="get_cookies_array()">
<div class="zarovnani">
<h1><a href="index.php" id="nadpis">BLAŽRENT</a></h1>
<div class="session uzivatel">
    <?php
    session_start();

    if(isset($_GET["action"]))
{ 
    if($_GET["action"] == "delete")
    {
        foreach($_SESSION["kosik"] as $keys => $values)
        {
            if($values["item_id"] == $_GET["ID"])
            {
                unset($_SESSION["kosik"][$keys]);
                echo '<script>alert("Zboží odstraněno")</script>';
                echo '<script>window.location="zobrazitkosik.php"</script>';
            }
        }
    }
}?>
    <?php
	if (isset($_SESSION["uzivatel"])){
        echo "<p align=\"right\"> ADMIN: ".$_SESSION["uzivatel"]." </p> " ;
        }
	?>
	</div>
<form method="post" action="">
<a href=index.php>← Zpět na hlavní stránku</a>

    <!--<div style="clear:both"></div>-->
    <br />
    <h3>Order Details</h3>
    <div class="table-responsive">
        <table class="table table-hover" style="border-color:black">
            <tr>
                <th width="40%">Název produktu</th>
                <th width="10%">Množství</th>
                <th width="20%">Cena</th>
                <th width="15%">Celkem</th>
                <th width="5%">Odebrat?</th>
            </tr>
            <?php
            if(!empty($_SESSION["kosik"]))
            {
                $total = 0;
                foreach($_SESSION["kosik"] as $keys => $values)
                {
            ?>
            <tr>
                <td><?php echo $values["item_name"]; ?></td>
                <td><?php echo $values["item_quantity"]; ?></td>
                <td> <?php echo $values["item_price"]; ?> CZK</td>
                <td> <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?> CZK</td>
                <td><a href="zobrazitkosik.php?action=delete&ID=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
            </tr>
            <?php
                    $total = $total + ($values["item_quantity"] * $values["item_price"]);
                }
            ?>
            <tr>
                <td colspan="3" align="right">Celkem</td>
                <td align="right"> <?php echo number_format($total, 2); ?> CZK</td>
                <td></td>
            </tr>
             
            <?php
            }//}
            ?>
               
        </table>
    </div>
    <div class="pridatdokosiku">
    <?php 
    if(!empty($_SESSION["kosik"]))
            {
                ?>
    <input type="button" value="Dokončit objednávku" onclick="window.location.href='odeslat_email.php'; "style="margin-top:5px;" class="btn btn-success">
    <?php  }?>
    </div>
</div>
</div>
</div>
<br />
</body>
</html>