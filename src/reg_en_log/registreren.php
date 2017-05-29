<html>
<header>

</header>
<script>
    function login() {
        window.location = "index.php";
    }
</script>
<body>
<form method="post">
    <legend><b>Registreren.</b></legend>
    Gebruikersnaam  <input type="text" id="invoer" name="gebruikersnaam"> <br />
    Wachtwoord <input type="password" id="password" name="wachtwoord"><br />
    Nogmaals Wachtwoord <input type="password" id="password" name="confirmwachtwoord"><br />
    E-mail adres <input type="text" id="invoer" name="email"> <br />
    Voornaam <input type="text" id="invoer" name="voornaam"> <br />
    Achternaam <input type="text" id="invoer" name="achternaam"> <br />

    <input type="submit" name="Verzenden">
</form>

<button type="button" onclick="login();">Login</button>
</body>
<?php
include "database.php";
$database = new database();
session_start();

if(isset($_POST['gebruikersnaam'])&&!empty($_POST['gebruikersnaam']) && isset($_POST['wachtwoord'])&&!empty($_POST['wachtwoord']) && isset($_POST['email'])&&!empty($_POST['email']) && isset($_POST['voornaam']) &&!empty($_POST['voornaam']) && isset($_POST['achternaam'])&&!empty($_POST['achternaam'])){
if($_POST['wachtwoord'] === $_POST['confirmwachtwoord']) {
    $user = $_POST['gebruikersnaam'];
    $wachtwoord = md5($_POST['wachtwoord']);
    $confirmpassword = md5($_POST['confirmwachtwoord']);
    $email = $_POST['email'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $result = $database->execute_without_fetch("INSERT INTO users
         (login_name, wachtwoord, email, voornaam, achternaam)
         values
         ('$user', '$wachtwoord', '$email', '$voornaam', '$achternaam')");

    echo "<br />gelukt";
}else{
    echo "<br />passwords didn't match";
}
}else {
    echo "<br />mislukt";
}
?>
</html>




