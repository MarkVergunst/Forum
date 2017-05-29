<html>
<header>

</header>
<script>
    function registreren() {
        window.location = "registreren.php";
    }
</script>
<body>
<form method="post">
    <legend><b>Inloggen</b></legend>
  Gebruikersnaam  <input type="text" id="invoer" name="gebruikersnaam"> <br />
    Wachtwoord <input type="password" id="password" name="wachtwoord"><br />
    <input type="submit" name="Verzenden" >
</form>

<button type="button" onclick="registreren();">Registreren</button>
</body>
<?php
include "database.php";
$database = new database();
session_start();

if(isset($_POST['gebruikersnaam']) && isset($_POST['wachtwoord'])){
    $user = $_POST['gebruikersnaam'];
    $wachtwoord = md5($_POST['wachtwoord']);
    $result = $database->execute("Select * FROM users WHERE login_name = '$user' AND wachtwoord = '$wachtwoord'");
    if(count($result)== 1) {
        $_SESSION["id"] = $result[0]['id'];
        header("Location: login.php");
    }else{
        echo "<br />login failed";
    }
}
?>
</html>




