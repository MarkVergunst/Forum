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
    <h1 class="koptekst"> Posts</h1>
    <?php
    $topic_id = $_GET['id'];
    ?>
    <?php foreach (database::execute("SELECT users.Voornaam, users.Achternaam, users.id, topic.user_id FROM users INNER JOIN topic ON users.id = topic.user_id WHERE topic.id = '$topic_id'") as $resultaat): ?>
        <div><p>Gemaakt door: <?php
                echo $resultaat['Voornaam'] . ' ';
                echo $resultaat['Achternaam'];?></p></div>
    <?php endforeach;
    foreach (database::execute("Select topic.id, topic.titel, topic.tekst, post.topic_id, post.date_post, post.foto, post.user_id  FROM topic INNER JOIN post ON topic.id = post.topic_id WHERE post.topic_id = '$topic_id' ") as $result){ ?>
        <div id="datum"><p>Date Post: <?php $sqldate=date('d-m-Y H:i:s',strtotime($result['date_post'])); echo $sqldate;?></p></div>
        <div class="header">
            <p>  <?= $result['titel'];?></p>
        </div>
        <article class="content">
            <p> <?php echo $result['tekst']; ?></p>
        </article>
    <?php  }
    $id = $_SESSION['id'];
    $result = $database->execute("SELECT * FROM topic WHERE user_id = '$id' AND id = '$topic_id'");
        ?>
        <h1 class="koptekst"> Aanpassen</h1>
        <p class="description"> Volg dit Formulier om uw topic aan te passen.</p>
        <form method="post" id="reactie">
            <textarea rows="10" cols="126"  name="aanpassing"><?php echo $result[0]['tekst'] ?></textarea>
            <br />
            <input type="submit" value="Bevestigen" name="Bevestigen" >
        </form>
        <?php
        $resultaat = $database::execute("SELECT * FROM topic WHERE user_id = '$id' AND id = '$topic_id'");

        if($_SESSION['id'] == $resultaat[0]['user_id']) {
            // moet nog beveiliging toegevoegd worden.
            if (isset($_POST['aanpassing'])) {
                $tekst = $_POST['aanpassing'];
                $topic_id = $_GET['id'];
                $database->execute_without_fetch("UPDATE topic SET tekst  = '$tekst' WHERE id = '$topic_id'");
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }else{
            header('Location: ' . 'post.php?id='. $topic_id);
        }
    ?>

</main>
</body>

</html>