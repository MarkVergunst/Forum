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
            <input id="inloggen" type="submit" value="inloggen"/>
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
            foreach (database::execute("SELECT * FROM users WHERE id = '{$_SESSION['id']}'") as $result) {
                ?>
                <p> Gebruikersnaam: <?php echo $result['login_name']; ?></p>
                <p> E-mail: <?php echo $result['email']; ?></p>
                <p> Voornaam: <?php echo $result['Voornaam']; ?></p>
                <p> Achternaam: <?php echo $result['Achternaam']; ?></p>
                <p> Geboortedatum: <?php $sqldate = date('d-m-Y', strtotime($result['geboortedatum']));
                    echo $sqldate; ?></p>
                <?php
            }
            ?>
            <button onclick="add_picture();">Foto toevoegen</button>
            <button onclick="change_Password();">Change Password</button>
        </section>
        <?php
    }
    ?>
</main>
</body>
<script type="text/javascript" src="javascript/script.js"></script>
</html>