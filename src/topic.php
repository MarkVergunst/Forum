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
            Gebruikersnaam: <input type="text"  />          <br />
            Wachtwoord: <input id="pass" type="password" />           <br />
            <input id="inloggen" type="submit" value="inloggen" />
            <!-- hier word bekeken of er al een sessie bestaat zo niet laat hij de loguit knop niet zien. -->
            <?php if(isset($_SESSION['id'])) { ?>
            <input type="submit" value="logout" name="logout">
        </form>
    </div>
    <?php
    }
    include_once "include/loguit.php";
    include_once "include/login.php";
    ?>
</aside>
<div id="logo">
    <h1>
        Ducati Forum
    </h1>
</div>
<main>
    <h1 class="koptekst"> Topics</h1>
    <p class="description"> klik op een topic om naar de post te gaan.</p>
<?php
    $categorie_id = $_GET['id'];
    foreach (database::execute("SELECT * FROM topic WHERE categorie_id = '$categorie_id'") as $result){ ?>
    <div onclick="load_Post(<?php echo $result['id'] ?>)" class="header">
      <p>  <?php echo $result['titel']; ?></p>
    </div>
    <article onclick="load_Post(<?php echo $result['id'] ?>)" class="content">
       <p> <?php echo $result['tekst']; ?> </p>
    </article>
        <?php
    }
?>
</main>
<script type="text/javascript" src="javascript/script.js"></script>
</body>
</html>
