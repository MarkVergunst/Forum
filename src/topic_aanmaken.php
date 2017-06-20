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
<?php
//echo "<pre>";
//print_r($topic_last_id);
//echo "</pre>";
//?>

</html>