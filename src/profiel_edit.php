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
    if (isset($_SESSION['id'])) {
    ?>
    <h1 class="koptekst"> Profiel pagina</h1>

    <section class="content">

        <?php

        ?>
        <form id="password_change" method="post">
            <p> Oud wachtwoord: </p><input type="password" name="old_password"/>
            <p> Nieuw wachtwoord </p><input type="password" name="new_password"/>
            <p> Nogmaals wachtwoord: </p><input type="password" name="again_password"/>
            <br/>
            <br/>
            <input type="submit" value="Bevestigen" name="Bevestigen"/>
        </form>
    </section>
    <p>
        <?php

        if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['again_password'])) {
            $result = $database->execute("SELECT * FROM users WHERE id = '{$_SESSION['id']}'");
            $old_pass = md5($_POST['old_password']);
            $db_pass = $result[0]['wachtwoord'];
            $new_pass = $_POST['new_password'];
            $again_pass = $_POST['again_password'];
            if ($old_pass === $db_pass) {
                if ($new_pass === $again_pass) {
                    if (preg_match('/[\!\@\#\$\%\^\&\*\(\)]/', $new_pass) && preg_match('/[123456789]/', $new_pass) && preg_match('/[abcdefghijklmopqrstuvwxyz]/', $new_pass) && preg_match('/[ABCDEFGHIJKLMOPQRSTUVWXYZ]/', $new_pass)) {
                        database::execute_without_fetch("UPDATE users SET wachtwoord = md5('$new_pass') WHERE id ='{$_SESSION['id']}'");
                        echo "uw wachtwoord is veranderd";
                    } else {
                        echo "u moet een moeilijker wachtwoord uit zoeken";
                    }
                } else {
                    echo "uw wachtwoord komt niet overheen";
                }
            } else {
                echo "uw oude wachtwoord klopt niet";
            }
        } else {
            echo "u moet alle velden invullen";
        }
        }
        ?>
        </p>

</main>
</body>

</html>