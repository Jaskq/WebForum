<?php

require_once 'dblogin.php';
require_once 'dbaccess.php';


$username = $_GET['username'];
$db = new dbAccess($host, $user, $password, $database);
$where = "username = '$username'";

$result = $db->selectDB('users', $where, '', '');
$result->data_seek(0);
$row = $result->fetch_array(MYSQLI_ASSOC);

if($row['username'] == ''){
  if(strlen($username) > 4){
    echo "<span class=\"validUser\">Username : Valid <span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span></span>";
  } else {
    echo "Username : ";
  }
} else {
  echo "<span class=\"invalidUser\">Username : Invalid <span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></span>";
}
?>
