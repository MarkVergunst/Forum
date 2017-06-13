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
    <?php  }?>
    <?php foreach (database::execute("SELECT users.Voornaam, users.Achternaam, users.id, comment.* FROM users INNER JOIN comment ON users.id = comment.user_id  WHERE comment.post_id = $topic_id") as $result): ?>

        <br />
           <div><p>Gereageerd door: <?php
        echo $result['Voornaam'] . ' ';
        echo $result['Achternaam'];?></p></div>
        <div id="datum"><p>Date Reactie: <?php $sqldate=date('d-m-Y H:i:s',strtotime($result['date_comment'])); echo $sqldate;?></p></div>

        <article class="content">
            <p> <?php echo $result['comment']; ?></p>
        </article>
    <?php endforeach;

    if(isset($_SESSION['id'])){
        ?>
        <h1 class="koptekst"> Reageren?</h1>
        <p class="description"> Volg dit vak hieronder in om een reactie achter te laten.</p>
        <form method="post" id="reactie">
            <textarea rows="10" cols="126" name="reactie"></textarea>
            <br />
            <input type="submit" value="Bevestigen" name="Bevestigen" >
        </form>
        <?php
    }
    if(isset($_POST['reactie'])){
        $reactie = $_POST['reactie'];
        $id = $_SESSION['id'];
        database::execute_without_fetch("INSERT INTO comment (comment, post_id, user_id) VALUES ('$reactie','$topic_id','$id')");
        header('Location: '. $_SERVER['HTTP_REFERER']);
    }
    ?>
</main>
</body>

</html>