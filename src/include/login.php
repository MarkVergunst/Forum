<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20-6-2017
 * Time: 16:44
 */
// dit stukje code zorgt voor het inl oggen en het checken van het uniek zijn van een gebruiker
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