<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "database.php";
    $database = new database();
    ?>
    <meta charset="UTF-8">
    <link href="css/styles.css" rel="stylesheet">
    <title>Ducati Forum</title>
    <script type="text/javascript" src="javascript/script.js"></script>
</head>
<body>
<header>
    <nav>
        <?php include "nav.php"; ?>
    </nav>
</header>

<aside>
    <div id="login" >

        <form method="post">
            <br />
            Gebruikersnaam: <input type="text" name="gebruikersnaam"  />          <br />
            Wachtwoord: <input id="pass" type="password" name="wachtwoord" />           <br />

            <input id="inloggen" type="submit" value="inloggen" />
            <!-- hier word bekeken of er al een sessie bestaat zo niet laat hij de loguit knop niet zien. -->
            <?php if(isset($_SESSION['id'])) { ?>
            <input type="submit" value="logout" name="logout">
        </form>

        <?php
        }
        include_once "include/loguit.php";
        include_once "include/login.php";
        ?>
    </div>
</aside>
<div id="logo">
    <h1>
        Ducati Forum
    </h1>
</div>
<main>
    <?php
    $id = $_SESSION['id'];
    $resultaat = database::execute("SELECT * FROM users WHERE id = '$id'");
    if($resultaat[0]['level'] > 1){
    ?>
    <h1 class="koptekst"> Categorie aanmaken</h1>
    <p class="description"> Volg dit formulier om een Categorie aan te maken.</p>
<form method="post" id="categorie_aanmaken">
    <p>Titel:</p><input type="text" name="titel" /> <br />
    <p>korte samenvatting:</p><input type="text" name="description" /> <br />
    <input type="submit" value="Bevestigen" name="Bevestigen"/>
</form>
    <?php
    if(isset($_POST['titel']) && isset($_POST['description'])) {
        $titel = $_POST['titel'];
        $description = $_POST['description'];
        database::execute_without_fetch("INSERT INTO categorie (titel, description) VALUES ('$titel','$description')");
    }
    }
    ?>

</main>
</body>

</html>