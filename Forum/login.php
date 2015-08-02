<?php

require_once 'dblogin.php';
require_once 'dbaccess.php';
require_once 'headbar.php';
require_once 'generator.php';

$username = "'".$_POST['username']."'";
$userPassword =  "'".crypt($_POST['password'], 'BYCRPYT')."'";

$where = "username = '$username' and password = '$userPassword'";
$db = new dbAccess($host, $user, $password, $database);
$result = $db->selectDB('users', $values, '', '', '');

if($result){
  $_SESSION['username'] = $_POST['username'];
  header("Location: homepage.php");
}


?>
