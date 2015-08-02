<?php

require_once 'headbar.php';
require_once 'dbaccess.php';
require_once 'dblogin.php';

$username = "'".$_SESSION['username']."'";
$title = "'".$_POST['title']."'";
$post = "'".$_POST['forumText']."'";
$db = new dbAccess($host, $user, $password, $database);
$fields = ["poster", "title", "comment", "commentid"];
$values = [$username, $title, $post, 0];
$result = $db->insertDB('threads', $values, $fields, '', '');

if($result){
    $title = $_POST['title'];
    header("Location: forum.php?title=".$title);
} else {

}

?>
