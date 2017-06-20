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
    <h1 class="koptekst"> Categorieën</h1>
    <p class="description"> klik op een categorie om naar de topic te gaan.</p>
    <!-- dit zorgt voor het ophalen van de juiste gegevens.-->
    <?php foreach (database::execute("Select * FROM categorie") as $result){ ?>
        <div onclick="load_Topic(<?php echo $result['id'] ?>);" class="header">
            <p>  <?php echo $result['titel'];?></p>
        </div>
        <article onclick="load_Topic();" class="content">
            <p> <?php echo $result['description']; ?></p>
        </article>
    <?php } ?>
</main>
</body>

</html>