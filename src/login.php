<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 1-5-2017
 * Time: 13:04
 */
include "database.php";
new database();
session_start();

$user = database::user($_SESSION['id']);
echo "<pre>";
print_r($user);
echo "</pre>";

?>