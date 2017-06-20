<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 19-6-2017
 * Time: 12:51
 */
?>
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
        // dit stukje code zorgt voor het uitloggen
        if(isset($_POST['logout'])) {
            unset($_SESSION['id']);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        // dit stukje maakt het inloggen mogelijk
        if(isset($_POST['gebruikersnaam']) && isset($_POST['wachtwoord'])){
            $user = $_POST['gebruikersnaam'];
            $wachtwoord = md5($_POST['wachtwoord']);
            $result = $database->execute("Select * FROM users WHERE login_name = '$user' AND wachtwoord = '$wachtwoord'");
            if(count($result)== 1) {
                $_SESSION["id"] = $result[0]['id'];

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
    <h1 class="koptekst"> Comment</h1>
    <?php
    $topic_id = $_GET['id'];
    ?>
    <?php foreach (database::execute("SELECT users.Voornaam, users.Achternaam, users.id
FROM users INNER JOIN comment 
ON users.id = comment.user_id WHERE comment.id = '$topic_id'") as $resultaat): ?>
        <div><p>Gemaakt door: <?php
                echo $resultaat['Voornaam'] . ' ';
                echo $resultaat['Achternaam'];?></p></div>
    <?php endforeach;
    foreach (database::execute("SELECT users.Voornaam, users.Achternaam, users.id, comment.* FROM users INNER JOIN comment ON users.id = comment.user_id  WHERE comment.id = $topic_id") as $result){ ?>
        <div id="datum"><p>Date Post: <?php $sqldate=date('d-m-Y H:i:s',strtotime($result['date_comment'])); echo $sqldate;?></p></div>
        <article class="content">
            <p> <?php echo $result['comment']; ?></p>
        </article>
    <?php  }
    $id = $_SESSION['id'];
    $result = $database->execute("SELECT * FROM comment WHERE user_id = '$id' AND id = '$topic_id'");
    ?>
    <h1 class="koptekst"> Aanpassen</h1>
    <p class="description"> Volg dit Formulier om uw comment aan te passen.</p>
    <form method="post" id="reactie">
        <input type="hidden" name="id" value="<?= $result[0]['id'] ?>">
        <textarea rows="10" cols="126"  name="aanpassing"><?php echo $result[0]['comment'] ?></textarea>
        <br />
        <input type="submit" value="Bevestigen" name="Bevestigen" >
    </form>
    <?php

//    print_r($result);
    $resultaat = $database::execute("SELECT * FROM comment WHERE user_id = '$id' AND id = '$topic_id'");

    if($_SESSION['id'] == $resultaat[0]['user_id']) {
        // moet nog beveiliging toegevoegd worden.
        if (isset($_POST['aanpassing'])) {
            $tekst = $_POST['aanpassing'];
            $comment_id = $_POST['id'];
            $database->execute_without_fetch("UPDATE comment SET comment  = '$tekst' WHERE id = '$comment_id'");
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }else{
        header('Location: ' . 'post.php?id='. $topic_id);
    }
    ?>

</main>
</body>

</html>
