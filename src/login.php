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
echo "login succes";
}else{
echo "<br />login failed";
}
}
?>