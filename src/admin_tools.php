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