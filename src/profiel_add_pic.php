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
    <?php
    if (isset($_SESSION['id'])) {
    ?>
    <h1 class="koptekst"> Profiel pagina</h1>
    <p class="description">hier kunt u een profielfoto toevoegen</p>
    <section class="content">

        <form method="post" enctype="multipart/form-data">
            <input type="file" name="foto">
            <input type="submit" value="Bevestigen" name="Bevestigen">
        </form>

        <?php
        $file_get = $_FILES['foto']['name'];
        $temp = $_FILES['foto']['tmp_name'];
        $id = $_SESSION['id'];
        mkdir('pictures/' . $id);
        $file_to_saved = "pictures/$id/" . $file_get;
        move_uploaded_file($temp, $file_to_saved);

        echo $file_to_saved;

        if (isset($_POST['Bevestigen'])) {

            echo "<br />Img inserted successfully";
            header('Location: profiel.php');
        } else {
            echo "<br />There is something wrong with this code. Eff!";
        }
        }
        ?>

    </section>


</main>
</body>

</html>