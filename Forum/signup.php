<?php

require_once 'dblogin.php';
require_once 'dbaccess.php';
require_once 'headbar.php';
require_once 'generator.php';

$username = "'".$_POST['username']."'";
$userPassword =  "'".crypt($_POST['password'], 'BYCRPYT')."'";
$email = $_POST['email'];

$db = new dbAccess($host, $user, $password, $database);

$fields = ["username", "password"];
$values = [$username, $userPassword];

$result = $db->insertDB('users', $values, $fields, '', '');

if($result){
  $_SESSION['username'] = $_POST['username'];
  header("Location: homepage.php");
}
?>
