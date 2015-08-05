<?php

require_once 'dblogin.php';
require_once 'dbaccess.php';
require_once 'headbar.php';
require_once 'generator.php';
require_once 'thread.php';

$title = $_GET['title'];
$where = "title = '$title'";

$threads = new Thread($where);

if(isset($_SESSION['username'])){
  $username = $_SESSION['username'];
}
$body = $threads->displayFullThread($username, true);

$page = generatePage($body, $title);
echo $page;

?>
