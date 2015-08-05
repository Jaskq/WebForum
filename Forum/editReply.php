<?php

require_once 'dblogin.php';
require_once 'dbaccess.php';
require_once 'headbar.php';
require_once 'generator.php';
require_once 'thread.php';

$mode = $_POST['mode'];

$db = new dbAccess($host, $user, $password, $database);

if($mode == "edit"){
  $comment = "'".$_POST['comment']."'";
  $id = $_POST['id'];
  $fields = ["comment"];
  $values = [$comment];
  $where = "id = $id";
  $result = $db->updateDB('threads', $values, $fields, $where);

  if($result){
      echo "Success";
  }
} elseif($mode == "reply"){
  $comment = "'".$_POST['comment']."'";
  $title = "'".$_POST['title']."'";
  $poster = "'".$_SESSION['username']."'";
  $fields = ["poster", "title", "comment", "commentid"];
  $values = [$poster, $title, $comment, 1];
  $result = $db->insertDB('threads', $values, $fields);

  if($result){
    echo "Success";
  }
} elseif($mode == "delete"){
  $id = $_POST['id'];
  $where = "id = $id";
  $result = $db-> deleteDB('threads', $where);

  if($result){
    echo "Success";
  }
  else {
    echo "Hello";
  }
}
?>
