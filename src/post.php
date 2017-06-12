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
    <h1 class="koptekst"> Posts</h1>
    <?php
    $topic_id = $_GET['id'];
    ?>
    <?php foreach (database::execute("Select topic.id, topic.titel, topic.tekst, post.topic_id, post.date_post, post.foto  FROM topic INNER JOIN post ON topic.id = post.topic_id WHERE post.topic_id = '$topic_id' ") as $result){ ?>
        <div id="datum"><p>Date Post: <?php echo $result['date_post']?></p></div>
        <div class="header">
            <p>  <?php echo $result['titel'];?></p>
        </div>
        <article class="content">
            <p> <?php echo $result['tekst']; ?></p>
        </article>
    <?php } ?>
</main>
</body>

</html>