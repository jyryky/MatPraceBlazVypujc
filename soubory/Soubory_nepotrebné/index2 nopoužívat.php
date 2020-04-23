<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title>Nákupní seznam</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=latin-ext" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
    <?php
    /* $_SESSION["status"] = TRUE;
    ----- DATABASE CONNECTION ----- 

    require_once './config/config.php';

    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_db);

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    }

    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
    }

    $mysqli->set_charset('utf8');
  


    CREATE TABLE IF NOT EXISTS `sape_shopping` (
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `description` varchar(50) NOT NULL,
    `count` int(11) NOT NULL,
    `price` float(11,2) NOT NULL
    ); 

    INSERT INTO `sape_shopping` (`description`, `count`, `price`) VALUES
    ('Čokoláda', 3, 25),
    ('Rohlíky', 10, 1.5),
    ('Kuřecí prsa', 1, 0),
    ('Jogurty', 2, 12.90)

    */

    /* ----- INSERT DATA ----- */

    if (isset($_POST['addValue'])) {
        if (empty($_POST['price'])) {
            $price = 0;
        } else {
            $price = $_POST['price'];
        }
        $sql = $mysqli -> prepare("INSERT INTO sape_shopping (`description`, `count`, `price`) VALUES (?,?,?)");
        $sql->bind_param ('sid', $_POST['description'], $_POST['count'], $price);
        if (!$sql->execute()) {
            printf("Error: %s\n", $mysqli->error);
        }
    } */
    ?>

    <header id="main-header">
        <div class="darken">
            <div class="container">
                <h1>Nákupní seznam</h1>
                <p>Co nesmím zapomenout koupit?</p>
                if (isset($_SESSION["status"])){
                echo "již jste vložil něco"
                }
      
                <form method="post" action="#">
                    <div class="form-row">
                        <input type="text" name="description" placeholder="Zboží" required>
                        <input type="number" name="count" placeholder="Počet" required>
                        <input type="number" name="price" placeholder="Cena za kus" step="0.01">
                    </div>
                    <input type="submit" name="addValue" value="Přidat k seznamu">
                </form>
            </div>
        </div>
    </header>
    <div id="main">
        <div class="container">
            <ul id="shopping-list">
                <?php
                $pocet_nezebrazenych=0;
                $celkova_cena=0;
                $sql = "SELECT * FROM `sape_shopping`";

                if ($result = $mysqli->query($sql)) {

                    while ($row = $result->fetch_array()) {
                        echo "<li>";
                        echo "<div class='description'>" . $row['description'] . "</div>";
                        echo "<div class='count'>" . $row['count'] . "</div>";
                        echo "<div class='price'>";

                        if ($row['price'] != 0) {
                            echo number_format($row['count'] * $row['price'], 2);
                            $celkova_cena=$celkova_cena+($row['count'] * $row['price']);
                        } else {
                            $pocet_nezebrazenych=+1;  
                            echo "-";
                        }

                        echo "</div>";    
                        echo "</li>";
                                                  
                    }
        
                    
                    echo "<div class=\"pocet_nezobrazenych\"><b>Počet položek které nemají cenu: ".$pocet_nezebrazenych."</b></div>"; 
                    echo "<b>Celková cena: ".$celkova_cena. "</b> " ;
                    $result->close();
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>