<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20-6-2017
 * Time: 16:46
 */
// dit stukje code zorgt voor het uitloggen
if(isset($_POST['logout'])){
    unset($_SESSION['id']);
    header('Location: '. $_SERVER['HTTP_REFERER']);
}
?>