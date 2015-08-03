<?php

  require_once 'dbaccess.php';
  require_once 'dblogin.php';
  require_once 'generator.php';
  require_once 'headbar.php';
  require_once 'thread.php';

  $body = "";

  $where = "commentid = 0";
  $threads = new Thread($where, "desc");
  $username = "";

  if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
  }

  $body = $threads->displayThread($username);

  $page = generatePage($body);
  echo $page;

?>
