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
//        $result = database::execute("SELECT * FROM users WHERE id = '{$_SESSION['id']}'");
//        echo "<pre>";
//        print_r($result);
//        echo "</pre>";
//        ?>
            <?php
        foreach (database::execute("SELECT * FROM users WHERE id = '{$_SESSION['id']}'") as $result){
?>
            <p> Gebruikersnaam: <?php echo $result['login_name']; ?></p>
            <p> E-mail: <?php echo $result['email']; ?></p>
            <p> Voornaam: <?php echo $result['Voornaam']; ?></p>
            <p> Achternaam: <?php echo $result['Achternaam']; ?></p>
            <p> Geboortedatum: <?php echo $result['geboortedatum']; ?></p>
            <?php
                    }
                ?>
            <button onclick="change_Password();">Change Password</button>
        </section>
</main>
</body>
<script type="text/javascript" src="script.js"></script>
</html>