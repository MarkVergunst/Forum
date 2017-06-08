<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/reg.css" rel="stylesheet">
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
        <form method="post" >
            <br />
            Gebruikersnaam: <input type="text"  name="username" />          <br />
            Wachtwoord: <input id="pass" type="password" name="password" />           <br />
            <input id="inloggen" type="submit" value="inloggen" />
        </form>
    </div>
</aside>
<div id="logo">
    <h1>
        Ducati Forum
    </h1>
</div>
<main>
    <div class="head">
        <h1> Registreren </h1>
    </div>
    <section class="content">
        <form method="post">
            Gebruikersnaam:*  <input type="text" class="invoer" name="gebruikersnaam"> <br />
            Wachtwoord:* <input type="password" class="invoer" name="wachtwoord"><br />
            Nogmaals Wachtwoord:* <input type="password" class="invoer" name="confirmwachtwoord"><br />
            E-mail adres:* <input type="text" class="invoer" name="email"> <br />
            Voornaam:* <input type="text" class="invoer" name="voornaam"> <br />
            Achternaam:* <input type="text" class="invoer" name="achternaam"> <br />
            geboortedatum: <input type="date" id="date" class="invoer" name="geboortedatum"> <br />
            <input type="submit"  id="verzenden" name="Verzenden">
        </form>
    </section>
    <?php
    include "database.php";
    $database = new database();


    if(isset($_POST['username']) && isset($_POST['password'])){
        $user = $_POST['username'];
        $wachtwoord = md5($_POST['password']);
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

    if(isset($_POST['gebruikersnaam'])&&!empty($_POST['gebruikersnaam']) && isset($_POST['wachtwoord'])&&!empty($_POST['wachtwoord']) && isset($_POST['email'])&&!empty($_POST['email']) && isset($_POST['voornaam']) &&!empty($_POST['voornaam']) && isset($_POST['achternaam'])&&!empty($_POST['achternaam'])){
    if($_POST['wachtwoord'] === $_POST['confirmwachtwoord']) {
    $user = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];
    $confirmpassword = $_POST['confirmwachtwoord'];
    $email = $_POST['email'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $geboortedatum = $_POST['geboortedatum'];
    $sqldate=date('Y-m-d',strtotime($geboortedatum));
           if (preg_match('/\@/', $email) && preg_match('/\./', $email)){
        //succes
    }else {
        echo 'e-mail adress invalid <br />';
    }
    if (preg_match('/[\!\@\#\$\%\^\&\*\(\)]/',$wachtwoord) && preg_match('/[123456789]/',$wachtwoord) && preg_match('/[abcdefghijklmopqrstuvwxyz]/',$wachtwoord) && preg_match('/[ABCDEFGHIJKLMOPQRSTUVWXYZ]/', $wachtwoord)){
      $wachtwoord = md5($wachtwoord);
      $confirmpassword = md5($confirmpassword);
               $result = $database->execute_without_fetch("INSERT INTO users
    (login_name, wachtwoord, email, voornaam, achternaam, geboortedatum)
    values
    ('$user', '$wachtwoord', '$email', '$voornaam', '$achternaam', '$sqldate')");
    }else{
        echo 'error mismatch password';
    }
    echo "<br />gelukt";
    }else{
        echo "<br />passwords didn't match";
    }
    }else {
        echo "<br />mislukt";
    }


    ?>
</main>
</body>
</html>