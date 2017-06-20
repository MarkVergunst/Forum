<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "database.php";
    $database = new database();
    ?>
    <meta charset="UTF-8">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/reg.css" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <title>Ducati Forum</title>
</head>
<body>
<header>
    <nav>
        <?php include "nav.php"; ?>
    </nav>
</header>

<aside>
    <div id="login" >
        <form method="post" >
            <br />
            Gebruikersnaam: <input type="text"  name="username" />          <br />
            Wachtwoord: <input id="pass" type="password" name="password" />           <br />
            <input id="inloggen" type="submit" value="inloggen" />
            <!-- hier word bekeken of er al een sessie bestaat zo niet laat hij de loguit knop niet zien. -->
            <?php if(isset($_SESSION['id'])) { ?>
            <input type="submit" value="logout" name="logout">
            <?php }
            include_once "include/loguit.php";
            include_once "include/login.php";
            ?>
        </form>
    </div>
</aside>
<div id="logo">
    <h1>
        Ducati Forum
    </h1>
</div>
<main>
    <h1 class="koptekst"> Registreren</h1>

    <section class="content">
        <form method="post">
            Gebruikersnaam:* <input type="text" class="invoer" name="gebruikersnaam"> <br/>
            Wachtwoord:* <input type="password" class="invoer" name="wachtwoord"><br/>
            Nogmaals Wachtwoord:* <input type="password" class="invoer" name="confirmwachtwoord"><br/>
            E-mail adres:* <input type="text" class="invoer" name="email"> <br/>
            Voornaam:* <input type="text" class="invoer" name="voornaam"> <br/>
            Achternaam:* <input type="text" class="invoer" name="achternaam"> <br/>
            geboortedatum: <input type="date" id="date" class="invoer" name="geboortedatum"> <br/>
            <!-- reCaptcha werkt alleen als je dit op een domein maakt.. localhost staat niet geregistreerd omdat google niet weet welke computer localhost is van mij.-->
            <div class="g-recaptcha" name="recaptcha" data-sitekey="6LfzAiYUAAAAAD4hLM_ZjUBOcg4Q-nD5O4a2mpSq"></div>
            <input type="submit" id="verzenden" name="Verzenden">
        </form>
    </section>
    <?php
    include_once "include/registreren.php";
    ?>
</main>
</body>
</html>