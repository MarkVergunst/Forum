<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20-6-2017
 * Time: 16:49
 */
// dit zorgt ervoor dat je kant registreren en dat word dan in de database gezet

if(isset($_POST['gebruikersnaam'])&&!empty($_POST['gebruikersnaam']) && isset($_POST['wachtwoord'])&&!empty($_POST['wachtwoord']) && isset($_POST['email'])&&!empty($_POST['email']) && isset($_POST['voornaam']) &&!empty($_POST['voornaam']) && isset($_POST['achternaam'])&&!empty($_POST['achternaam'] && !empty($_POST['g-recaptcha-response']))){

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
            echo "<br />uw e-mail adres klopt niet";
        }
    }else {
        echo "<br />de wachtwoorden komen niet overheen.";
    }
}else {
    echo 'u heeft niet alle velden ingevuld<br />';
}
?>