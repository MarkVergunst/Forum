<?php
if(!isset($_SESSION)){
    session_start();
}

if(isset($_POST['header'])){
    $echo = "true%%";
    $_SESSION['level'] = 2;
    echo $echo;
}

?>