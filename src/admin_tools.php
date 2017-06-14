    <!DOCTYPE html>
    <html lang="en">
    <head>
        <?php
        include "include.php";
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
            $id = $_SESSION['id'];
            $resultaat = database::execute("SELECT * FROM users WHERE id = '$id'");
            if($resultaat[0][7] > 2){
            ?>
        </div>
    </aside>
    <div id="logo">
        <h1>
            Ducati Forum
        </h1>
    </div>
    <main>
        <h1 class="koptekst"> Admin Tools</h1>
        <p class="description"> Hier kunt u de rang van de members verhogen.</p>

        <section class="content">
            <form method="post" id="admin">
                <select name="account">
                    <?php
                    foreach (database::execute('Select * FROM users') as $result) {
                        echo "<option value='{$result['id']}'>{$result['login_name']}</option>";
                    }
                    ?>
                </select>
                <select name="rank">
                    <?php
                    foreach (database::execute('Select * FROM level') as $result) {
                        echo "<option value='{$result['id']}'>{$result['level_naam']}</option>";
                    }
                    ?>
                </select>
                <input type="submit" name="Bevestigen" value="Bevestigen" />
            </form>
            <?php
            if (isset($_POST['account']) && isset($_POST['rank'])){
                $account = $_POST['account'];
                $rank = $_POST['rank'];
                database::execute_without_fetch("UPDATE users SET `level` = '$rank' WHERE id = '$account'");
            }
            ?>

        </section>
    </body>
    <?php
    }
    ?>
    </html>