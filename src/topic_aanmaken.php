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
        //if $_SESSION doesnt exist when this is being called then create it
        if(!isset($_SESSION)){
            session_start();
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
    <?php if (isset($_SESSION['id'])) {
        ?>

        <h1 class="koptekst"> Topic aanmaken</h1>
        <p class="description"> Volg het fomulier om een topic aan te maken.</p>
        <form method="post" id="topic_aanmaken">
            <p>Titel:</p><input type="text" name="titel"/> <br/>
            <p>Korte omschrijving:</p><input type="text" name="description"/> <br/>
            <p>Tekst:</p><textarea type="text" name="tekst" rows="4" cols="50"> </textarea> <br/>
            <p>Categorie:</p><select name="categorie"> <br/>
                <?php
                $categorie = database::execute('Select * FROM categorie');;
                foreach ($categorie as $result) {
                    echo "<option value='{$result['id']}'>{$result['titel']}</option>";
                }
                ?>
            </select>
            <input type="submit" value="Bevestigen" name="Bevestigen"/>
        </form>

        <?php
    }
    if(isset($_POST['titel']) && isset($_POST['description']) && isset($_POST['tekst']) && isset($_POST['categorie'])) {
        $titel = $_POST['titel'];
        $description = $_POST['description'];
        $tekst = $_POST['tekst'];
        $categorie = $_POST['categorie'];
        $id = $_SESSION['id'];
        $topic_id = database::execute("SELECT id FROM topic ORDER BY id DESC");
        $topic_last_id = $topic_id[0][0] + 1;
        database::execute_without_fetch("INSERT INTO topic (categorie_id, titel, tekst, tekst_groot, user_id) VALUES ('$categorie','$titel','$description', '$tekst', '$id') ");
        $database->execute_without_fetch("INSERT INTO post (user_id, topic_id) VALUES ('$id', '$topic_last_id')");
        header('Location: '. $_SERVER['HTTP_REFERER']);
    }
    ?>

</main>
</body>
</html>