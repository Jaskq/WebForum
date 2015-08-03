<?php

require_once 'dblogin.php';
require_once 'dbaccess.php';
require_once 'headbar.php';
require_once 'generator.php';

$comment = "'".$_POST['comment']."'";
$mode = $_POST['mode'];

$db = new dbAccess($host, $user, $password, $database);

if($mode == "edit"){
  $id = $_POST['id'];
  $fields = ["comment"];
  $values = [$comment];
  $where = "id = $id";
  $result = $db->updateDB('threads', $values, $fields, $where);

  if($result){
      echo "Success";
  }
} elseif($mode == "reply"){
  $title = "'".$_POST['title']."'";
  $poster = "'".$_SESSION['username']."'";

  $fields = ["poster", "title", "comment", "commentid"];
  $values = [$poster, $title, $comment, 1];

  $result = $db->insertDB('threads', $values, $fields);

  if($result){
   echo "Success";
  }
}
?>
