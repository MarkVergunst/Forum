<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="css/styles.css" rel="stylesheet">
    <title>Ducati Forum</title>
    <script type="text/javascript" src="script.js"></script>
    <script type="text/javascript" src="ajax.js"></script>
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
        // dit stukje code zorgt voor de connectie met de database
        include "database.php";
        $database = new database();
        //if $_SESSION doesnt exist when this is being called then create it
        if(!isset($_SESSION)){
            session_start();
        }
        // dit stukje code zorgt voor het uitloggen
        if(isset($_POST['logout'])){
            unset($_SESSION['id']);
            header('Location: '. $_SERVER['HTTP_REFERER']);
        }
        // dit stukje code zorgt voor het inloggen en het checken van het uniek zijn van een gebruiker
        if(isset($_POST['gebruikersnaam']) && isset($_POST['wachtwoord'])){
            $user = $_POST['gebruikersnaam'];
            $wachtwoord = md5($_POST['wachtwoord']);
            $result = $database->execute("Select * FROM users WHERE login_name = '$user' AND wachtwoord = '$wachtwoord'");
            if(count($result)== 1) {
                $_SESSION["id"] = $result[0]['id'];

                echo "<button id='profiel' onclick='profielpagina();'>Profiel pagina</button>";
                $user = database::user($_SESSION['id']);

                echo "<br />login Succes";
                header('Location: '. $_SERVER['HTTP_REFERER']);

            }else{
                echo "<br />login failed";
            }
        }
        // dit wordt verwijderd bij release
        if (isset($_SESSION['id'])) {
            $user = database::user($_SESSION['id']);
            echo "<pre>";
            print_r($user);
            echo "</pre>";
        }
        ?>
</aside>
<div id="logo">
    <h1>
        Ducati Forum
    </h1>
</div>
<main>
    <h1 class="koptekst"> Categorieën</h1>
    <p class="description"> klik op een categorie om naar de topic te gaan.</p>
    <?php foreach (database::execute("Select * FROM categorie") as $result){ ?>
        <div onclick="load_Topic(<?php echo $result['id'] ?>);" class="header">
          <p>  <?php echo $result['titel'];?></p>
        </div>
        <article onclick="load_Topic(<?php echo $result['id'] ?>);" class="content">
           <p> <?php echo $result['description']; ?></p>
        </article>
    <?php } ?>
</main>

</body>
</html>
<script type="text/javascript" src="script.js"></script>