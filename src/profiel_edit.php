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

        </form>
        <?php
        include "database.php";
        $database = new database();


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

        if (isset($_SESSION['id'])) {
            $user = database::user($_SESSION['id']);
            echo "<pre>";
            print_r($user);
            echo "</pre>";
        }
        ?>
    </div>
</aside>
<div id="logo">
    <h1>
        Ducati Forum
    </h1>
</div>
<main>
    <h1 class="koptekst"> Profiel pagina</h1>

    <section class="content">

        <?php
        $result = $database->execute("SELECT * FROM users WHERE id = '{$_SESSION['id']}'");
            ?>
            <form id="password_change" method="post">
                <p> Oud wachtwoord: </p><input type="password" name="old_password"/>
                <p> Nieuw wachtwoord </p><input type="password" name="new_password"/>
                <p> Nogmaals wachtwoord: </p><input type="password" name="again_password"/>
                <br />
                <br />
                <input type="submit" value="Bevestigen" name="Bevestigen" />
            </form>
        <?php
        if(isset($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['again_password'])){
            $old_pass = md5($_POST['old_password']);
            $db_pass = $result['wachtwoord'];
            $new_pass = $_POST['new_password'];
            $again_pass = $_POST['again_password'];
            if ($old_pass == $db_pass){
                 if ($new_pass == $again_pass) {
                     database::execute_without_fetch("UPDATE users SET wachtwoord = '$new_pass' WHERE id =('{$_SESSION['id']}'");
                     echo "uw wachtwoord is veranderd";
                    }
                    echo "uw wachtwoord komt niet overheen";
            }
            echo "uw oude wachtwoord klopt niet";
        }else {
            echo "<br /><br /><br /><br /><br /><br /><br /><br /><br />u moet alle velden invullen";
        }
        ?>
    </section>
</main>
</body>

</html>